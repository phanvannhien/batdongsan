 <form id="search-form" action="" method="post">
 <div id="search-holder" class="wrapper">
            <div id="sdm" class="clearfix">
              <?php
                $listTermDanhMuc = get_terms('danh-muc',array('parent' => 0,'hide_empty'=>0));
                $i = 0; 
                foreach ($listTermDanhMuc as $list) {
                  # code...
                  $checked = ($i==0)?"checked":'';
                  echo '<input '.$checked.' id="checked-'.$list->term_id.'" type="radio" value="'.$list->term_id.'" name="s_dm" class="checkbox-radio">';
                  echo '<label for="checked-'.$list->term_id.'" class="ckeckbox-label">'.$list->name.'</label>';
                  $i++;
                }
              ?>
            </div>
            <ul id="container-search" >
              <li class="clearfix">
              <div class="select-value clearfix">
                <div onclick="showSearch('tinhtp','list-tp');jQuery('a#s_quanhuyen').text('Quận/Huyện')">
                    <a id="s_tinhtp" href="javascript:;">Tỉnh/Tp</a>
                    <span class="btDropdown" title="Tỉnh/Tp"><i class="fa fa-toggle-down color-red"></i></span>
                    <input type="hidden" class="input_select" id="s_tinhtp" name="s_tinhtp" value="">
                </div>
                <div id="list-tp" class="holder-list" style="display:none">
                  <div class="title-list">
                    <a class="pull-right" href="javascript:close('list-tp')"><i class="fa fa-close"></i></a>
                    <h4>Chọn tỉnh thành</h4>
                  </div>
                  <div class="content-list">
                    <ul>
                    <?php
                      $listTp = get_terms('dia-diem',array('parent' => 0,'hide_empty'=>0));
                      $i=0; 
                      foreach ($listTp as $list) {
                        # code...
                        $i++;
                        echo '<li>';
                        echo "<a class='s-value-query' data-close='list-tp' data-value='".$list->term_id."' data-we='s_tinhtp' href='javascript:setTp({$list->term_id})' title='".$list->name."'>".$list->name."</a>";
                        
                        echo '</li>';
                        echo ($i % 5 == 0)?'</ul><ul>':'';
                      }
                    ?>
                    </ul>
                  </div>  
                </div>
              </div>
              <!-- Tp -->
              <div class="select-value clearfix">
                <div id="holder-lst-sub-qh" onclick="showSearch('s_tinhtp','list-qh');">
                    <a id="s_quanhuyen" href="javascript:;">Quận/Huyện</a>
                    <span class="btDropdown" title="Chọn Quận/Huyện"><i class="fa fa-toggle-down color-red"></i></span>
                    <input type="hidden" class="input_select" id="s_quanhuyen" name="s_quanhuyen" value="" onkeypress="javascript:return false;">
                </div>
                <div id="list-qh" class="holder-list" style="display:none">
                  <div class="title-list">
                    <a class="pull-right" href="javascript:close('list-qh')"><i class="fa fa-close"></i></a>
                    <h4>Chọn Quận / Huyện</h4>
                  </div>
                  <div class="content-list">
                    <ul id="lst-sub-qh">
                      
                    </ul>
                  </div>  
                </div>

              </div>
               <!-- QH -->
              
              <!-- Loai BDS -->
              <div class="select-value clearfix">
                <div onclick="showSearch('','list-loaibds');">
                    <a id="s_loaibds" href="javascript:;">Loại BĐS</a>
                    <span class="btDropdown" title="Chọn Loại BDS"><i class="fa fa-toggle-down color-red"></i></span>
                    <input type="hidden" class="input_select" id="s_loaibds" name="s_loaibds" value="" onkeypress="javascript:return false;">
                </div>
                <div id="list-loaibds" class="holder-list" style="display:none">
                  <div class="title-list">
                    <a class="pull-right" href="javascript:close('list-loaibds')"><i class="fa fa-close"></i></a>
                    <h4>Chọn Loại BĐS</h4>
                  </div>
                  <?php
                    $listTp = get_terms('loai-bat-dong-san',array('parent' => 0,'hide_empty'=>0));
                    //var_dump($listTp);
                    $percentWith = ceil((int)count($listTp) / 5)* 200;
                  ?>
                  <div class="content-list" style="width:<?php echo $percentWith.'px'?>">
                    <ul>
                    <?php
                      
                      $i=0; 
                      foreach ($listTp as $list) {
                        # code...
                        $i++;
                        echo '<li>';
                        echo '<a class="s-value-query" data-close="list-loaibds" data-value="'.$list->term_id.'" data-we="s_loaibds" title="'.$list->name.'" href="#">'.$list->name.'</a>';
                        echo '</li>';
                        echo ($i % 5 == 0)?'</ul><ul>':'';
                      }
                    ?>
                    </ul>
                  </div>  
                </div>

              </div>
               <!-- QH -->
              <div class="slider-range clearfix">
                  <span style="display: inline-block;line-height: 30px;">Diện tích: </span>
                  <div class="holder-s-range">
                    <div id="slider-range-dt"></div>
                  </div>
                  <span id="amount-dt">250-500</span><span>m2</span>
              </div> 
              
              <div class="slider-range clearfix">
                  <span style="display: inline-block;line-height: 30px;">Giá: </span>
                  <div class="holder-s-range">
                    <div id="slider-range-gia"></div>
                  </div>
                  <span id="amount-gia">200-500</span><span>tr</span>
              </div> 
              
              <a onclick="searchAction()" class="btn btn-default" name="submit-searh" href="javascript:;"><span class="fa fa-search"></span> Tìm ngay </a>
              

              </li>
             
            </ul>
          </div>
          <!-- #search-holder -->

</form>


<script type="text/javascript">
  jQuery(function() {

    
    
    // for dien tich
    jQuery( "#slider-range-dt" ).slider({
      range: true,
      min: 100,
      max: 1000,
      values: [ 250, 500 ],
      slide: function( event, ui ) {
        jQuery( "#amount-dt" ).text( + ui.values[0] + "-" + ui.values[1]);
      }
    });
   // for price
   jQuery( "#slider-range-gia" ).slider({
      range: true,
      min: 50,
      max: 5000,
      values: [ 200, 500],
      slide: function( event, ui ) {
        jQuery( "#amount-gia" ).text( + ui.values[ 0 ] + "-" + ui.values[1]);
      }
    });
  });

  function showSearch(requiredElenment,where){
    if(requiredElenment != ''){
      if(jQuery('input#'+requiredElenment).val()== ''){
         var html = jQuery('<p/>').text('Vui lòng chọn Tỉnh/Tp');
        
          jQuery(html).modal({
            close :true,
            minWidth :200,
            minHeight :50,
            containerCss:{'background':'#FFF','padding':'20px','text-align':'center'}
          });
      }else{
        getSearchQuanHuyen(jQuery('input#'+requiredElenment).val());
        jQuery('#'+where).slideDown();
      }
    }else{
      jQuery('#'+where).slideDown();
    }
    
  }

  function close(where){
     jQuery('#'+where).slideUp();
  }

  jQuery('a.s-value-query').live('click',function(e){
      e.preventDefault();
      var whereElement = jQuery(this).data('we');
      var value = jQuery(this).data('value');
      var titleText = jQuery(this).attr('title');
      console.log(whereElement + value + titleText);
      jQuery('input#'+whereElement).val(value);
      jQuery('a#'+whereElement).html(titleText);
      close(jQuery(this).data('close'));
  });

  function searchAction(){
    var dmSeach = jQuery('input[name="s_dm"]').val();
    var tinhTp = jQuery('input#s_tinhtp').val();
    var quanHuyen = jQuery('input#s_quanhuyen').val();
    var loaiBDS = jQuery('input#s_loaibds').val();
    var sdientich =  jQuery('span#amount-dt').text();
    var sgia =  jQuery('span#amount-gia').text();

    if(tinhTp == '' || quanHuyen == '' || loaiBDS == ''){
        var html = jQuery('<p/>').text('Chọn Tỉnh/Tp, Quận/Huyện, Loại BDS');
        
        jQuery(html).modal({
          close :true,
          minWidth :200,
          minHeight :50,
          overlayClose:true,
          containerCss:{'background':'#FFF','padding':'20px','text-align':'center'}
        });
        return;
    }else{
        jQuery.ajax({
            type: "POST",
            url: url_ajax,
            data: {
              dmSeach:dmSeach,
              tinhTp:tinhTp,
              quanHuyen:quanHuyen,
              loaiBDS:loaiBDS,
              sdientich:sdientich,
              sgia:sgia,
              action:'getSearchBDS',
            },   
            beforeSend:function(){
              var html = jQuery('<p/>').text('Đang tìm kiếm...');
              jQuery(html).modal({
                close :false,
                minWidth :200,
                minHeight :20,
                containerCss:{'background':'#FFF','padding':'20px','text-align':'center'}
              });

            },
            success: function(data) {
                jQuery.modal.close(); // must call this!
                jQuery('#main-content').html(data); 
            }
        });
    }

  }
</script>