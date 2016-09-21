<?php

	class KBBDS{

		private $prefix;
		private $table;
		
		public function __construct(){
			global $wpdb;
			$this->prefix = $wpdb->prefix;
			$this->table = $this->prefix.'bds';	
		}

		public function getAllReal(){
			global $wpdb;
			return $wpdb->get_results('SELECT * FROM '.$this->table);
		}


		public function searchReal($dm,$tp,$qh,$loai,$price,$dtich){
			global $wpdb;
			$price = array_map('trim', explode('-', $price));
			$dtich = array_map('trim', explode('-', $dtich));

			$sql = "SELECT * FROM {$this->table} WHERE bds_cate_id = '{$dm}' AND tinhtp = '{$tp}' AND quanhuyen = '{$qh}' AND loai_bds='{$loai}' AND {$price[0]} <= price <= {$price[1]} AND {$dtich[0]} <= dientich <= {$dtich[1]}";

			return $wpdb->get_results($sql);
			//var_dump($wpdb->last_query);
		}

		public function getCountRealByCate($cateID,$taxonomy){
			global $wpdb;
			$fieldQuery = '';


			if($taxonomy == 'danh-muc'){
				$fieldQuery = 'bds_cate_id';
			}
			if($taxonomy == 'dia-diem'){
				$fieldQuery = 'tinhtp';
			}
			if($taxonomy == 'loai-bat-dong-san'){
				$fieldQuery = 'loai_bds';
			}

			return $wpdb->get_row("SELECT count(*) as num_rows FROM {$this->table} WHERE {$fieldQuery} = '{$cateID}'");

		}



		public function getAllRealByCate($cateID,$taxonomy,$start,$limit,$all = false){
			global $wpdb;
			$fieldQuery = '';


			if($taxonomy == 'danh-muc'){
				$fieldQuery = 'bds_cate_id';
			}
			if($taxonomy == 'dia-diem'){
				$fieldQuery = 'tinhtp';
			}
			if($taxonomy == 'loai-bat-dong-san'){
				$fieldQuery = 'loai_bds';
			}

			if($all){
				return $wpdb->get_row("SELECT count(*) as num_rows FROM {$this->table} WHERE {$fieldQuery} = '{$cateID}'");
		
			}

			return $wpdb->get_results("SELECT * FROM {$this->table} WHERE {$fieldQuery} = '{$cateID}' LIMIT {$start},{$limit}");
		
		}

		public function getAllRealByDanhMuc($dmID,$limit){
			global $wpdb;
			return $wpdb->get_results("SELECT * FROM {$this->table} WHERE bds_cate_id = {$dmID} LIMIT {$limit}");
			//var_dump($wpdb->last_query);
		}

		public function getAllRealByUserLimit($userID,$start = 0,$limit = 0){
			global $wpdb;
			return $wpdb->get_results("SELECT * FROM {$this->table} WHERE bds_user_id = {$userID} LIMIT {$start},{$limit}");
		}

		public function getAllRealByUser($userID){
			global $wpdb;
			return $wpdb->get_results("SELECT * FROM {$this->table} WHERE bds_user_id = {$userID}");
		}
		
		public function getAllRealLimit($start,$limit){
			global $wpdb;
			return $wpdb->get_results("SELECT * FROM {$this->table} LIMIT {$start},{$limit}");
		}		

		public function getRealByID($realID){
			global $wpdb;
			return $wpdb->get_row("SELECT * FROM $this->table WHERE bds_id = '$realID'"); 
		}

		public function insertReal($params){
			global $wpdb;
			if(is_array($params)){
				return $wpdb->insert($this->table, $params);
			}
			return false;
		}

		public function checkExistRealUser($userID,$realID){
			global $wpdb;
			$data =  $wpdb->get_row("SELECT * FROM $this->table WHERE bds_user_id = '$userID' AND bds_id = '$realID'"); 
			
			if(count($data) >= 1)
				return true;
			return false;
		}
		public function editReal($id,$params){
			global $wpdb;
			if(is_array($params)){
				return $wpdb->update( $this->table, $params, array( 'bds_id' => $id ));
				//var_dump($wpdb->last_query);
			}
			return false;
		}

		public function delReal($bID){
			global $wpdb;
			$arrIDs = array('bds_id'=>$bID);
			return $wpdb->delete($this->table, $arrIDs , array('%d') );
		}

		public function setStatus($bid,$status){
			global $wpdb;
			$params = array('bds_status'=>$status);
			return $wpdb->update( $this->table, $params, array( 'bds_id' => $bid ));
		}
	}