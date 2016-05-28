<section>  
<?php 

  // $data_document = $query_documet->row_array();    
  if(!empty($data_document)){
    $id = $data_document['quotation_id'];
    if (empty($id)) {
      $id = $data_document['prospect_id'];
      $this->db->where('id', $id);
      $query_quotation = $this->db->get('tbt_prospect');
      $data_quotation = $query_quotation->row_array(); 
      $is_prospect  = 1;
    } else {
      $query_quotation = $this->__quotation_model->get_quotationByid($id);
      $data_quotation = $query_quotation->row_array(); 
      $is_prospect  = 0;
    }
  }  

  if(!empty($data_quotation)){

    $competitor  =$data_quotation['competitor_id'];
    $unit_time  =$data_quotation['unit_time'];
    $time  =$data_quotation['time'];
    $job_type  =$data_quotation['job_type'];

    //$is_go_live  =$data_quotation['is_go_live'];
    //$previous_quotation_id  =$data_quotation['previous_quotation_id'];

    //$project_start  =$data_quotation['project_start'];
    //$project_end     =$data_quotation['project_end'];    
    $sold_to_name1     =$data_quotation['sold_to_name1'];      
    $sold_to_name2     =$data_quotation['sold_to_name2'];
    $sold_to_address1  =$data_quotation['sold_to_address1'];
    $sold_to_address2  =$data_quotation['sold_to_address2'];
    $sold_to_address3  =$data_quotation['sold_to_address3'];
    $sold_to_address4  =$data_quotation['sold_to_address4'];
    $sold_to_district  =$data_quotation['sold_to_district'];
    $sold_to_country   =$data_quotation['sold_to_country'];    // varchar2
    $sold_to_region       =$data_quotation['sold_to_region']; // varchar2
    $sold_to_city         =$data_quotation['sold_to_city']; 
    $sold_to_postal_code  =$data_quotation['sold_to_postal_code'];  // varchar5
    $sold_to_industry     =$data_quotation['sold_to_industry']; // varchar4
    $sold_to_business_scale  =$data_quotation['sold_to_business_scale'];
    //$sold_to_customer_group  =$data_quotation['sold_to_customer_group'];

    $sold_to_tel  =$data_quotation['sold_to_tel'];
    $sold_to_tel_ext  =$data_quotation['sold_to_tel_ext'];
    $sold_to_fax  =$data_quotation['sold_to_fax'];
    $sold_to_fax_ext  =$data_quotation['sold_to_fax_ext'];
    $sold_to_mobile  =$data_quotation['sold_to_mobile'];
    $sold_to_email  =$data_quotation['sold_to_email'];


    if (!$is_prospect) {
      $sold_to_id        =$data_quotation['sold_to_id'];
      $ship_to_id        =$data_quotation['ship_to_id'];    
      $ship_to_name1     =$data_quotation['ship_to_name1'];      
      $ship_to_name2     =$data_quotation['ship_to_name2'];
      $ship_to_address1  =$data_quotation['ship_to_address1'];
      $ship_to_address2  =$data_quotation['ship_to_address2'];
      $ship_to_address3  =$data_quotation['ship_to_address3'];
      $ship_to_address4  =$data_quotation['ship_to_address4'];
      $ship_to_district  =$data_quotation['ship_to_district'];
      $ship_to_country   =$data_quotation['ship_to_country'];        
      $ship_to_region       =$data_quotation['ship_to_region'];
      $ship_to_city         =$data_quotation['ship_to_city'];
      $ship_to_postal_code  =$data_quotation['ship_to_postal_code'];
      $ship_to_industry     =$data_quotation['ship_to_industry'];
      $ship_to_business_scale  =$data_quotation['ship_to_business_scale'];
      //$ship_to_customer_group  =$data_quotation['ship_to_customer_group'];

      $ship_to_tel  =$data_quotation['ship_to_tel'];
      $ship_to_tel_ext  =$data_quotation['ship_to_tel_ext'];
      $ship_to_fax  =$data_quotation['ship_to_fax'];
      $ship_to_fax_ext  =$data_quotation['ship_to_fax_ext'];
      $ship_to_mobile  =$data_quotation['ship_to_mobile'];
      $ship_to_email  =$data_quotation['ship_to_email'];
    }


  } else { 
    $competitor  =  '';
    $unit_time  = '';
    $time  = '';
    $job_type  ='';

    $is_prospect  ='';

    $sold_to_id  = '';
    $sold_to_name1   = '';          
    $sold_to_name2    = '';       
    $sold_to_address1  = '';  
    $sold_to_address2  = '';  
    $sold_to_address3  = '';  
    $sold_to_address4  = '';  
    $sold_to_district  = '';  
    $sold_to_country   = '';   
    $sold_to_region    = '';   
    $sold_to_city      = '';  
    $sold_to_postal_code = '';  
    $sold_to_industry   = '';  
    $sold_to_business_scale = '';  
    $sold_to_customer_group = '';

    $sold_to_tel  ='';
    $sold_to_tel_ext  ='';
    $sold_to_fax  ='';
    $sold_to_fax_ext  ='';
    $sold_to_mobile  ='';
    $sold_to_email  ='';


    $ship_to_id        = ''; 
    $ship_to_name1     = '';        
    $ship_to_name2     = '';
    $ship_to_address1  = '';
    $ship_to_address2  = '';
    $ship_to_address3  = '';
    $ship_to_address4  = '';
    $ship_to_district  = '';
    $ship_to_country   = '';        
    $ship_to_region       = '';
    $ship_to_city         = '';         
    $ship_to_postal_code  = '';
    $ship_to_industry     = '';
    $ship_to_business_scale  = '';
    $ship_to_customer_group  = '';

    $ship_to_tel  ='';
    $ship_to_tel_ext  ='';
    $ship_to_fax  ='';
    $ship_to_fax_ext  ='';
    $ship_to_mobile  ='';
    $ship_to_email  ='';
  }

  $sold_to_country_title ='';
  $temp_bapi_country = $bapi_country->result_array();

  if(!empty($temp_bapi_country)){
    foreach($bapi_country->result_array() as $value){  
      if($value['id']== $sold_to_country){                                          
        $sold_to_country_title  = $value['title'];
      }
    }
  } else {  $sold_to_country_title = ''; }

  //===== get title region ==========
  $sold_to_region_title ='';
  $temp_bapi_region= $bapi_region->result_array();
  if(!empty($temp_bapi_region)){
    foreach($bapi_region->result_array() as $value){         
      if($value['id']== $sold_to_region){                                          
        $sold_to_region_title  = $value['title'];
      }
    }//end foreach
  } else {  $sold_to_region_title = ''; }

  //===== get title industry ==========
  $sold_to_industry_title ='';
  $temp_bapi_industry= $bapi_industry->result_array();
  if(!empty($temp_bapi_industry)){
    foreach($bapi_industry->result_array() as $value){         
      if($value['id']== $sold_to_industry){                                          
        $sold_to_industry_title  = $value['title'];
      }
    }//end foreach
  } else {  $sold_to_industry_title = ''; }

  //===== get title industry ==========
  $sold_to_business_scale_title ='';
  $temp_business_scale= $bapi_business_scale->result_array();
  if(!empty($temp_business_scale)){
    foreach($bapi_business_scale->result_array() as $value){         
      if($value['id']== $sold_to_business_scale){                                          
        $sold_to_business_scale_title  = $value['title'];
      }
    }//end foreach
  } else {  $sold_to_business_scale_title = ''; }

  /////////////////// ship to/////////////////////////
  if (!$is_prospect) {
    //===== get title contry==========
    $ship_to_country_title ='';
    $temp_bapi_country = $bapi_country->result_array();
    if(!empty($temp_bapi_country)){
      foreach($bapi_country->result_array() as $value){  
        if($value['id']== $ship_to_country){                                          
          $ship_to_country_title  = $value['title'];
        }
      }//end foreach
    } else {  $ship_to_country_title = ''; }

    //===== get title region ==========
    $ship_to_region_title ='';
    $temp_bapi_region= $bapi_region->result_array();
    if(!empty($temp_bapi_region)){
      foreach($bapi_region->result_array() as $value){         
        if($value['id']== $ship_to_region){                                          
          $ship_to_region_title  = $value['title'];
        }
      }//end foreach
    } else {  $ship_to_region_title = ''; }


    //===== get title industry ==========
    $ship_to_industry_title ='';
    $temp_bapi_industry= $bapi_industry->result_array();
    if(!empty($temp_bapi_industry)){
      foreach($bapi_industry->result_array() as $value){         
        if($value['id']== $ship_to_industry){                                          
          $ship_to_industry_title  = $value['title'];
        }
      }//end foreach
    } else {  $ship_to_industry_title = ''; }

    //===== get title industry ==========
    $ship_to_business_scale_title ='';
    $temp_business_scale= $bapi_business_scale->result_array();
    if(!empty($temp_business_scale)){
      foreach($bapi_business_scale->result_array() as $value){         
        if($value['id']== $ship_to_business_scale){                                          
          $ship_to_business_scale_title  = $value['title'];
        }
      }//end foreach
    } else {  $ship_to_business_scale_title = ''; }
  }
?>     
  <div class="panel-body">
    <div class="form-group">       
      <div class="col-sm-12"> 
        <div class="panel panel-default ">
          <div class="panel-heading">
            <h4 class="panel-title">
              <a data-toggle="collapse" data-parent="#accordion" href="#collapseCustomer" class="toggle_custotmer">
                <?php echo freetext('customer'); //Customer?>    
                <i class="icon_customer_down fa fa-caret-down  text-active pull-right"></i><i class="icon_customer_up fa fa-caret-up text  pull-right"></i>
              </a>       
            </h4>
          </div>
          <div id="collapseCustomer" class="panel-collapse in">
            <div class="panel-body">
              <div class="col-sm-12 add-all-medium">
                <div class="col-md-12">
                  <div class="input-group m-b">
                    <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_name1').'</font></div>'; ?></span>
                    <input  readonly type="text" autocomplete="off" class="form-control"  value="<?php echo $sold_to_name1; ?>" >
                  </div>
                </div> 
                <div class="col-md-12 ">
                  <div class="input-group m-b">
                    <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_name2').'</font></div>'; ?></span>
                    <input readonly type="text" autocomplete="off" class="form-control"value="<?php echo $sold_to_name2; ?>">  
                  </div>
                </div>  
                <div class="col-md-12 ">
                  <div class="input-group m-b">
                    <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_address1').'</font></div>'; ?></span>
                    <input readonly type="text" autocomplete="off" class="form-control" value="<?php echo $sold_to_address1; ?>">  
                  </div>
                </div> 
                <div class="col-md-12 ">
                  <div class="input-group m-b">
                    <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_address2').'</font></div>'; ?></span>
                    <input readonly type="text" autocomplete="off" class="form-control" value="<?php echo $sold_to_address2; ?>">  
                  </div>
                </div> 
                <div class="col-md-12 ">
                  <div class="input-group m-b">
                    <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_address3').'</font></div>'; ?></span>
                    <input readonly type="text" autocomplete="off" class="form-control" value="<?php echo $sold_to_address3; ?>">  
                  </div>
                </div> 
                <div class="col-md-12 ">
                  <div class="input-group m-b">
                    <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_address4').'</font></div>'; ?></span>
                    <input readonly type="text" autocomplete="off" class="form-control" value="<?php echo $sold_to_address4; ?>">  
                  </div>
                </div> 
                <div class="col-md-12 ">
                  <div class="input-group m-b">
                    <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_district').'</font></div>'; ?></span>
                    <input readonly type="text" autocomplete="off" class="form-control" value="<?php echo $sold_to_district; ?>">  
                  </div>
                </div> 

                <div class="col-sm-12 no-padd"> 
                  <div class="col-md-6">                                 
                    <div class="input-group m-b">
                      <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_country').'</font></div>'; ?></span>
                      <input readonly type="text" autocomplete="off" class="form-control"  value="<?php echo $sold_to_country_title; ?>">
                    </div>
                  </div> 
                  <div class="col-md-6">
                    <div class="input-group m-b">
                      <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_region').'</font></div>'; ?></span>
                      <input readonly type="text" autocomplete="off" class="form-control"  value="<?php echo $sold_to_region_title; ?>">
                    </div>
                  </div>
                </div> 
                <div class="col-sm-12 no-padd"> 
                  <div class="col-md-6">
                    <div class="input-group m-b">                                                  
                      <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_city').'</font></div>'; ?></span>
                      <input readonly type="text" autocomplete="off" class="form-control"   value="<?php echo $sold_to_city; ?>" >                                
                    </div>
                  </div>                      
                  <div class="col-md-6">
                    <div class="input-group m-b">
                      <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_postal_code').'</font></div>'; ?></span>
                      <input readonly type="text" autocomplete="off" class="form-control"   value="<?php echo $sold_to_postal_code; ?>" >
                    </div>
                  </div>
                </div> 
                <div class="col-sm-12 no-padd"> 
                  <div class="col-md-6">
                    <div class="input-group m-b">                                                  
                      <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_industry').'</font></div>'; ?></span>
                      <input readonly type="text" autocomplete="off" class="form-control"   value="<?php echo $sold_to_industry_title; ?>" >
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="input-group m-b">                                                  
                      <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_business_scale').'</font></div>'; ?></span>
                      <input readonly type="text" autocomplete="off" class="form-control"   value="<?php echo $sold_to_business_scale_title; ?>" >
                    </div>
                  </div>    
                </div>   
                <div class="col-sm-12 no-padd"> 
                  <div class="col-md-6 ">
                    <div class="col-sm-7 no-padd">
                      <div class="input-group m-b">
                      <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_tel').'</font></div>'; ?></span>
                      <input readonly type="text" autocomplete="off" maxlength="10" class="form-control"  value="<?php echo $sold_to_tel  ; ?>" >
                      </div>
                    </div>
                    <div class="col-sm-5" style="padding-right:0px;">
                      <div class="input-group m-b">
                        <span class="input-group-addon"><?php echo '<font class="pull-left">'.freetext('sold_to_tel_ext').'</font>'; ?></span>
                        <input readonly type="text" autocomplete="off" maxlength="3" class="form-control" value="<?php echo $sold_to_tel_ext; ?>" >
                      </div>
                    </div>
                  </div> 
                  <div class="col-md-6 ">
                    <div class="col-sm-7 no-padd">
                      <div class="input-group m-b">
                        <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_fax').'</font></div>'; ?></span>
                        <input readonly type="text" autocomplete="off" maxlength="10" class="form-control"  value="<?php echo $sold_to_fax; ?>" >
                      </div>
                    </div>
                    <div class="col-sm-5" style="padding-right:0px;">
                      <div class="input-group m-b">
                        <span class="input-group-addon"><?php echo '<font class="pull-left">'.freetext('sold_to_fax_ext').'</font>'; ?></span>
                        <input readonly type="text" autocomplete="off" maxlength="3" class="form-control" value="<?php echo $sold_to_fax_ext; ?>" >
                      </div>
                    </div>
                  </div> 
                </div>   
                <div class="col-sm-12 no-padd"> 
                  <div class="col-md-6">
                    <div class="input-group m-b">
                      <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_mobile').'</font></div>'; ?></span>
                      <input readonly type="text" autocomplete="off"  maxlength="10" class="form-control"  value="<?php echo $sold_to_mobile; ?>" >
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="input-group m-b">
                      <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_email').'</font></div>'; ?></span>
                      <input readonly type="text" autocomplete="off"  maxlength="10" class="form-control"  value="<?php echo $sold_to_email; ?>">
                    </div>
                  </div> 
                </div>  
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php
      if (!$is_prospect) {
    ?>
      <div class="col-sm-12"> 
        <div class="panel panel-default ">
          <div class="panel-heading">
            <h4 class="panel-title">
              <a data-toggle="collapse" data-parent="#accordion" href="#collapseContact" class="toggle_person">
                <?php echo freetext('ship_to'); //Contact person?>
                <i class="icon_person_down fa fa-caret-down text-active pull-right"></i><i class="icon_person_up fa fa-caret-up text  pull-right"></i> 
              </a> 
            </h4>
          </div>
          <div id="collapseContact" class="panel-collapse in">
            <div class="panel-body">
              <div class="col-sm-12 add-all-medium">
              <?php 
                $shipTo_readonly = "";
                if($is_prospect == 0) { 
                  $shipTo_readonly = "readonly='readonly'";
              ?>
                  <input type="hidden" class="form-control"  value="<?php echo $ship_to_id; ?>" >
              <?php 
                } else { 
                    $shipTo_readonly = "";
              ?>
                  <input type="hidden" class="form-control"  value="" >
              <?php 
                } 
              ?>
                <div class="col-md-12">
                  <div class="input-group m-b">
                    <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('ship_to_name1').'</font></div>'; ?></span>
                    <input <?php echo $shipTo_readonly; ?> type="text" autocomplete="off" class="form-control"  value="<?php echo $ship_to_name1?>">
                  </div>
                </div> 
                <div class="col-md-12 ">
                  <div class="input-group m-b">
                    <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('ship_to_name2').'</font></div>'; ?></span>
                    <input <?php echo $shipTo_readonly; ?> type="text" autocomplete="off" class="form-control" value="<?php echo $ship_to_name2?>" >  
                  </div>
                </div> 
                <div class="col-md-12 ">
                  <div class="input-group m-b">
                    <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('ship_to_address1').'</font></div>'; ?></span>
                    <input <?php echo $shipTo_readonly; ?> type="text" autocomplete="off" class="form-control" value="<?php echo $ship_to_address1?>">  
                  </div>
                </div> 
                <div class="col-md-12 ">
                  <div class="input-group m-b">
                    <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('ship_to_address2').'</font></div>'; ?></span>
                    <input <?php echo $shipTo_readonly; ?> type="text" autocomplete="off" class="form-control" value="<?php echo $ship_to_address2?>">  
                  </div>
                </div> 
                <div class="col-md-12 ">
                  <div class="input-group m-b">
                    <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('ship_to_address3').'</font></div>'; ?></span>
                    <input <?php echo $shipTo_readonly; ?> type="text" autocomplete="off" class="form-control"  value="<?php echo $ship_to_address3?>">  
                  </div>
                </div>  
                <div class="col-md-12 ">
                  <div class="input-group m-b">
                    <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('ship_to_address4').'</font></div>'; ?></span>
                    <input <?php echo $shipTo_readonly; ?> type="text" autocomplete="off" class="form-control" value="<?php echo $ship_to_address4?>">  
                  </div>
                </div>  
                <div class="col-md-12 ">
                  <div class="input-group m-b">
                    <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('ship_to_district').'</font></div>'; ?></span>
                    <input <?php echo $shipTo_readonly; ?> type="text" autocomplete="off" class="form-control" value="<?php echo $ship_to_district?>">  
                  </div>
                </div> 
                <div class="col-sm-12 no-padd"> 
                  <div class="col-md-6">
                    <div class="input-group m-b">
                      <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('ship_to_country').'</font></div>'; ?></span>
                      <?php  
                        if($is_prospect == 1) {  
                      ?>
                          <select class='form-control' >
                        <?php 
                            $temp_bapi_country = $bapi_country->result_array();
                            if(!empty($temp_bapi_country)){
                              foreach($bapi_country->result_array() as $value){ 
                         ?>
                                <option  <?php if($ship_to_country==$value['id'] ){ echo 'selected="selected"';  } ?>  value='<?php echo $value['id'] ?>'><?php echo $value['title'] ?></option> 
                        <?php 
                              }//end foreach
                            } else { 
                        ?>
                                <option value='0'>ไม่มีข้อมูล</option> 
                        <?php 
                            } 
                        ?>
                          </select>
                      <?php 
                        } else { 
                      ?>                                          
                          <input readonly type="text" autocomplete="off" class="form-control" value="<?php echo $ship_to_country_title?>"> 
                      <?php 
                        } 
                      ?>
                    </div>
                  </div>                     
                  <div class="col-md-6">
                    <div class="input-group m-b">
                      <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('ship_to_region').'</font></div>'; ?></span>
                      <?php  
                        if($is_prospect == 1) {  
                      ?>
                        <select name='ship_to_region' class='form-control' >
                      <?php 
                          $temp_bapi_region = $bapi_region->result_array();
                          if(!empty($temp_bapi_region)){
                            foreach($bapi_region->result_array() as $value){ 
                      ?>
                              <option  <?php if($ship_to_region==$value['id'] ){ echo 'selected="selected"';  } ?> value='<?php echo $value['id'] ?>'><?php echo $value['title'] ?></option> 
                      <?php 
                            }//end foreach
                          } else { 
                      ?>
                              <option value='0'>ไม่มีข้อมูล</option> 
                      <?php 
                          } 
                      ?>
                        </select>
                      <?php 
                        } else { 
                      ?>                                         
                        <input readonly type="text" autocomplete="off" class="form-control" value="<?php echo $ship_to_region_title?>"> 
                      <?php 
                        } 
                      ?>
                    </div>
                  </div>
                </div> 
                <div class="col-sm-12 no-padd"> 
                  <div class="col-md-6">
                    <div class="input-group m-b">                                                  
                      <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('ship_to_city').'</font></div>'; ?></span>
                      <input <?php echo $shipTo_readonly; ?> type="text" autocomplete="off" class="form-control"  value="<?php echo $ship_to_city; ?>">                                 
                    </div>
                  </div>  
                  <div class="col-md-6">
                    <div class="input-group m-b">
                      <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('ship_to_postal_code').'</font></div>'; ?></span>
                      <input <?php echo $shipTo_readonly; ?> type="text" autocomplete="off" class="form-control"  value="<?php echo $ship_to_postal_code?>">
                    </div>
                  </div>
                </div> 
                <div class="col-sm-12 no-padd"> 
                  <div class="col-md-6">
                    <div class="input-group m-b">                                                  
                      <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('ship_to_industry').'</font></div>'; ?></span>
                      <?php  
                        if($is_prospect == 1) {  
                      ?>
                        <select  name='ship_to_industry' class='form-control' >
                      <?php 
                          $temp_bapi_industry = $bapi_industry->result_array();
                          if(!empty($temp_bapi_industry)){
                            foreach($bapi_industry->result_array() as $value){ 
                       ?>
                              <option  <?php if($ship_to_industry==$value['id'] ){ echo 'selected="selected"';  } ?> value='<?php echo $value['id'] ?>'><?php echo $value['title'] ?></option> 
                      <?php 
                            }//end foreach
                          } else { 
                      ?>
                              <option value='0'>ไม่มีข้อมูล</option> 
                      <?php } ?>
                        </select>
                      <?php 
                        } else { ?>                                         
                            <input readonly type="text" autocomplete="off" class="form-control" value="<?php echo $ship_to_industry_title?>"> 
                      <?php 
                        } 
                      ?>
                    </div>
                  </div>   
                  <div class="col-md-6">
                    <div class="input-group m-b">                                                  
                      <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('ship_to_business_scale').'</font></div>'; ?></span>
                      <?php  
                        if($is_prospect == 1) {  
                      ?>
                        <select  name='ship_to_business_scale' class='form-control' >
                      <?php 
                          $temp_bapi_business_scale = $bapi_business_scale->result_array();
                          if(!empty($temp_bapi_business_scale)){
                            foreach($bapi_business_scale->result_array() as $value){ 
                       ?>
                              <option  <?php if($ship_to_business_scale==$value['id'] ){ echo 'selected="selected"';  } ?> value='<?php echo $value['id'] ?>'><?php echo $value['title'] ?></option> 
                      <?php 
                            }//end foreach
                          } else { 
                      ?>
                              <option value='0'>ไม่มีข้อมูล</option> 
                      <?php 
                          } 
                      ?>
                        </select>
                      <?php 
                        } else { 
                      ?>                                         
                          <input readonly type="text" autocomplete="off" class="form-control" value="<?php echo $ship_to_business_scale_title?>"> 
                      <?php 
                        } 
                      ?>                                
                    </div>
                  </div>        
                </div>   
                <div class="col-sm-12 no-padd"> 
                  <div class="col-md-6 ">
                    <div class="col-sm-7 no-padd">
                      <div class="input-group m-b">
                        <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('ship_to_tel').'</font></div>'; ?></span>
                        <input <?php echo $shipTo_readonly; ?> type="text" autocomplete="off" maxlength="10" class="form-control"  value="<?php echo $ship_to_tel  ; ?>">
                      </div>
                    </div>
                    <div class="col-sm-5" style="padding-right:0px;">
                      <div class="input-group m-b">
                        <span class="input-group-addon"><?php echo '<font class="pull-left">'.freetext('ship_to_tel_ext').'</font>'; ?></span>
                        <input <?php echo $shipTo_readonly; ?> type="text" autocomplete="off" maxlength="3" class="form-control" value="<?php echo $ship_to_tel_ext; ?>" >
                      </div>
                    </div>
                  </div>  
                  <div class="col-md-6 ">
                    <div class="col-sm-7 no-padd">
                      <div class="input-group m-b">
                        <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('ship_to_fax').'</font></div>'; ?></span>
                        <input <?php echo $shipTo_readonly; ?> type="text" autocomplete="off" maxlength="10" class="form-control"  value="<?php echo $ship_to_fax; ?>" >
                      </div>
                    </div>
                    <div class="col-sm-5" style="padding-right:0px;">
                      <div class="input-group m-b">
                        <span class="input-group-addon"><?php echo '<font class="pull-left">'.freetext('ship_to_fax_ext').'</font>'; ?></span>
                        <input <?php echo $shipTo_readonly; ?> type="text" autocomplete="off" maxlength="3" class="form-control" value="<?php echo $ship_to_fax_ext; ?>" >
                      </div>
                    </div>
                  </div> 
                </div>   
                <div class="col-sm-12 no-padd"> 
                  <div class="col-md-6">
                    <div class="input-group m-b">
                      <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('ship_to_mobile').'</font></div>'; ?></span>
                      <input  <?php echo $shipTo_readonly; ?> type="text" autocomplete="off"  maxlength="10" class="form-control"  value="<?php echo $ship_to_mobile; ?>" >
                    </div>
                  </div> 
                  <div class="col-md-6">
                    <div class="input-group m-b">
                      <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('ship_to_email').'</font></div>'; ?></span>
                      <input <?php echo $shipTo_readonly; ?> type="text" autocomplete="off"  maxlength="10" class="form-control"  value="<?php echo $ship_to_email; ?>" >
                    </div>
                  </div> 
                </div>  
              </div><!-- end :col 12 add-all-medium -->                                               
            </div> <!-- end :panel customer -->  
          </div><!--end : collapseContact -->
        </div><!-- end : panel panel-default -->
      </div>
    <?php
      }
    ?>
    </div><!-- End : panel body -->                   
  </div><!-- End : form group -->                                 
</section><!-- end : panel -->  
<section class="panel panel-default ">               
  <div class="panel-heading" style="padding-bottom :24px;">
    <font class="font-bold"> <?php echo freetext('contract_person'); ?></font>        
  </div>
  <div class="panel-body"> 
    <div class="form-group">
      <div class="col-sm-12 add-all-medium">
        <div class="col-sm-12" id="other">
          <table  class="table  m-b-none table_other_contracts" >               
            <thead>
              <tr class="back-color-gray">
                <th><?php echo freetext('contact_title'); //First Name?></th>
                <th><?php echo freetext('firstname'); //First Name?></th>
                <th><?php echo freetext('lastname'); //Last Name?></th>
                <th><?php echo freetext('function'); //Function?></th>
                <th><?php echo freetext('department');?></th>
                <th><?php echo freetext('tel'); //Function?></th>
                <th><?php echo freetext('tel_ext'); //Function?></th>
                <th><?php echo freetext('fax'); //Function?></th>
                <th><?php echo freetext('fax_ext'); //Function?></th> 
                <th><?php echo freetext('mobile_phone'); //mobile phone?></th>
                <th><?php echo freetext('email'); //mobile phone?></th>
              </tr>
            </thead>
            <tbody>
            <?php 
              if (!$is_prospect) {
                $query_contact = $this->__quotation_model->get_contact_quotation($id);

                $this->db->where('id',$id); 
                $query = $this->db->get('tbt_quotation');
                $quotation = $query->row_array();

                $this->db->select('sap_tbm_contact.*, sap_tbm_department.title As department_title'); 
                $this->db->select('sap_tbm_function.description As function_title'); 
                $this->db->join('sap_tbm_department', 'sap_tbm_department.id = sap_tbm_contact.department','left');
                $this->db->join('sap_tbm_function', 'sap_tbm_function.id = sap_tbm_contact.function','left');
                $this->db->where('sap_tbm_contact.ship_to_id', $quotation['ship_to_id']); 
                $query = $this->db->get('sap_tbm_contact');
                $sap_contact_result = $query->result_array();

              } else {
                $query_contact = $this->__quotation_model->get_contact_prospect($id);
              }

              $temp_query_contact = $query_contact->result_array();

              if(!empty($temp_query_contact) || !empty($sap_contact_result)) {   
                if(!empty($temp_query_contact)) {                         
                  foreach($query_contact->result_array() as $value){
            ?>  
                    <tr id="<?php echo $value['id']; ?>">
                      <td><?php echo $value['title'];?></td>
                      <td><?php echo $value['firstname'];?></td>
                      <td><?php echo $value['lastname'];?></td>
                      <td><?php echo $value['function_title'];?></td>
                      <td><?php echo $value['department_title'];?></td>
                      <td><?php echo $value['tel'];?></td>
                      <td><?php echo $value['tel_ext'];?></td>
                      <td><?php echo $value['fax'];?></td>
                      <td><?php echo $value['fax_ext'];?></td>
                      <td><?php echo $value['mobile_no'];?></td>
                      <td><?php echo $value['email'];?></td>
                    </tr>
            <?php
                  }
                }//end foreach
                if(!empty($sap_contact_result)) {                         
                  foreach($sap_contact_result as $value){
            ?>
                    <tr id="<?php echo $value['id']; ?>">
                      <td><?php echo $value['title'];?></td>
                      <td><?php echo $value['firstname'];?></td>
                      <td><?php echo $value['lastname'];?></td>
                      <td><?php echo $value['function'];?></td>
                      <td><?php echo $value['tel'];?></td>
                      <td><?php echo $value['tel_ext'];?></td>
                      <td><?php echo $value['fax'];?></td>
                      <td><?php echo $value['fax_ext'];?></td>
                      <td><?php echo $value['mobile'];?></td>
                      <td><?php echo $value['email'];?></td>
                    </tr>
            <?php
                  }
                }//end foreach
              } else { 
            ?>                                   
                <tr>
                  <td colspan='7'><?php echo 'ไม่มีข้อมูล';?></td>                                              
                </tr>
            <?php 
              } 
            ?>
            </tbody>                   
          </table>
        </div>
      </div> <!-- end : col12 -->                        
    </div><!--end : form-group -->
  </div>
</section>