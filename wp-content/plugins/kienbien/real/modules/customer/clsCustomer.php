<?php

	class KBRealCustomer{

		private $prefix;
		private $table;
		
		public function __construct(){
			global $wpdb;
			$this->prefix = $wpdb->prefix;
			$this->table = $this->prefix.'customer';	
		}

		public function getAllCustomer(){
			global $wpdb;
			return $wpdb->get_results('SELECT * FROM '.$this->table);
		}	

		public function getCustomerByID($email){
			global $wpdb;
			return $wpdb->get_row("SELECT * FROM $this->table WHERE email = '$email'"); 
		}

		public function getCustomerRealByID($customerID){
			global $wpdb;
			return $wpdb->get_row("SELECT * FROM $this->table WHERE id = '$customerID'"); 
		}

		public function insertCustomer($params){
			global $wpdb;
			if(is_array($params)){
				return $wpdb->insert( 
					$this->table, 
					$params, 
					array('%s','%s','%s','%s','%s') 
				);
			}
			return false;
		}

		public function editCustomer($id,$params){
			if(is_array($params)){
				$wpdb->update( 
					$this->table, 
					$params, 
					$id, 
					array( '%d','%s','%s','%s','%s','%s') , 
					array( '%d' ) 
				);
			}
		}

		public function delCustomer($id){
			return $wpdb->delete($this->table, $id , array('%d') );
		}
	}