
<section>  
<form role="form" data-parsley-validate action="<?php echo site_url('__ps_quotation/update_quotation/'.$this->quotation_id) ?>" method="POST" onSubmit="return fieldCheck();"> 
<div class="panel-body  m-b-xl">
 <?php 

     //====start : get data quotation ship_to  =========
     $data_quotation = $query_quotation->row_array();

     $status = "";
     $contract_id = "";
     if(!empty($data_quotation)){
         $project_title = $data_quotation['title'];
         $contract_id = $data_quotation['contract_id'];
         $status = $data_quotation['status'];

         $competitor  =$data_quotation['competitor_id'];
         $unit_time  =$data_quotation['unit_time'];
         $time  =$data_quotation['time'];
         $job_type  =$data_quotation['job_type'];

         $is_prospect  = $data_quotation['is_prospect'];
         //$is_go_live  =$data_quotation['is_go_live'];
         //$previous_quotation_id  =$data_quotation['previous_quotation_id'];

         //$project_start  =$data_quotation['project_start'];
         //$project_end     =$data_quotation['project_end'];

         $sold_to_id        =$data_quotation['sold_to_id'];    
         $sold_to_name1     =$data_quotation['sold_to_name1'];      
         //$sold_to_name2     =$data_quotation['sold_to_name2'];
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
         $sold_to_tax_id  = $data_quotation['sold_to_tax_id'];


         $ship_to_id        =$data_quotation['ship_to_id'];    
         $ship_to_name1     =$data_quotation['ship_to_name1'];      
         //$ship_to_name2     =$data_quotation['ship_to_name2'];
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
         $ship_to_tax_id  = $data_quotation['ship_to_tax_id'];
         //$ship_to_customer_group  =$data_quotation['ship_to_customer_group'];

         $ship_to_tel  =$data_quotation['ship_to_tel'];
         $ship_to_tel_ext  =$data_quotation['ship_to_tel_ext'];
         $ship_to_fax  =$data_quotation['ship_to_fax'];
         $ship_to_fax_ext  =$data_quotation['ship_to_fax_ext'];
         $ship_to_mobile  =$data_quotation['ship_to_mobile'];
         $ship_to_email  =$data_quotation['ship_to_email'];
         $distribution_channel_db  =$data_quotation['distribution_channel'];
         $required_doc =  unserialize($data_quotation['required_doc']);
         $plan_code_prospect = $data_quotation['plan_code_prospect'];
         $is_cal_vat = $data_quotation['is_cal_vat'];
         $account_group = $data_quotation['account_group'];
        
      }
      else{ 
         $competitor  =  '';
         $unit_time  = '';
         $time  = '';
         $job_type  ='';
         
         $is_prospect  ='';
         $account_group='';

         //$is_go_live  ='';
         //$previous_quotation_id  ='';

         //$project_start  =$data_quotation['project_start'];
         //$project_end     =$data_quotation['project_end'];

         $sold_to_id  = '';
         $sold_to_name1   = '';          
         //$sold_to_name2    = '';       
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
         $sold_to_tax_id = '';

         $sold_to_tel  ='';
         $sold_to_tel_ext  ='';
         $sold_to_fax  ='';
         $sold_to_fax_ext  ='';
         $sold_to_mobile  ='';
         $sold_to_email  ='';


         $ship_to_id        = ''; 
         $ship_to_name1     = '';        
        //$ship_to_name2     = '';
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
         $ship_to_tax_id = '';

         $ship_to_tel  ='';
         $ship_to_tel_ext  ='';
         $ship_to_fax  ='';
         $ship_to_fax_ext  ='';
         $ship_to_mobile  ='';
         $ship_to_email  ='';
         $distribution_channel_db  ='';
         $required_doc = '';
         $plan_code_prospect = '';
         $is_cal_vat = '';

      }

    //====end : get data quotation ship_to =========

   //====start : get data main contract quotation  =========
        // $data_main_contract = $query_main_contract->row_array(); 

        // if(!empty($data_main_contract)){

        //   $main_contact_id              =$data_main_contract['main_contact_id'];
        //   $data_contract_firstname      =$data_main_contract['firstname'];
        //   $data_contract_lastname       =$data_main_contract['lastname'];
        //   //$data_contract_position       =$data_main_contract['position'];
        //   $data_contract_function       =$data_main_contract['function'];
        //   $data_contract_department     =$data_main_contract['department'];
        //   $data_contract_phone_no       =$data_main_contract['phone_no'];
        //   $data_contract_phone_no_ext   =$data_main_contract['phone_no_ext'];
        //   $data_contract_mobile_no      =$data_main_contract['mobile_no'];
        //   $data_contract_fax            = $data_main_contract['fax'];
        //   $data_contract_email          =$data_main_contract['email'];

        // }else{

        //     $main_contact_id = 0;
        //     $data_contract_firstname = '';
        //     $data_contract_lastname ='';
        //     //$data_contract_position ='';
        //     $data_contract_function ='';
        //     $data_contract_department ='';
        //     $data_contract_phone_no ='';
        //     $data_contract_phone_no_ext = '';
        //     $data_contract_mobile_no ='';
        //     $data_contract_fax = '';
        //     $data_contract_email = '';


        // }


   //====end : get data  main contract quotation =========


//==========================================
////////////  get plant_code ///////////////
//==========================================
$plant_name = '';
$array_plant = array();
$temp_bapi_ship_to = $bapi_ship_to->result_array();
if(!empty($temp_bapi_ship_to)){   
foreach($bapi_ship_to->result_array() as $value){ 
  if(!empty($value['plant_code'])){
      if (in_array( $value['plant_code'], $array_plant, TRUE)){                
        //echo "have";
      }else{
          //echo "nohave";
          //array_push($texture,$value['texture_id']);
          $array_plant[$value['plant_code']] = $value['plant_name']; 
      }//end else  
  }//end if check plant_code
}//end foreach
}//end if

if(!empty($array_plant)){
   foreach($array_plant as $p => $p_value) {
      if($p==$plan_code_prospect){
        $plant_name = $p_value;
      }
  }//end for
}


/////////////////////////////////////
 // === start :  get bapi sap =======
/////////////////////////////////////

//get $data_quotation = $bapi_sold_to->row_array();   
  //===== get title region ==========
if($is_prospect != 1 ){
    $sold_to_ac = ''; 
    foreach($bapi_sold_to->result_array() as $value){         
       if($value['id']== $sold_to_id){                                          
            $sold_to_ac  = $value['sold_to_account_group'];
        }
    }//end foreach
}else{
 $sold_to_ac  = $account_group;
}


/////////////////// sold to/////////////////////////

//===== get title contry==========
  $sold_to_country_title ='';
  $temp_bapi_country = $bapi_country->result_array();
    if(!empty($temp_bapi_country)){
      foreach($bapi_country->result_array() as $value){  
         if($value['id']== $sold_to_country){                                          
              $sold_to_country_title  = $value['title'];
          }

      }//end foreach
  }else{  $sold_to_country_title = ''; }

//===== get title region ==========
  $sold_to_region_title ='';
  $temp_bapi_region= $bapi_region->result_array();
    if(!empty($temp_bapi_region)){
      foreach($bapi_region->result_array() as $value){         
         if($value['id']== $sold_to_region){                                          
              $sold_to_region_title  = $value['title'];
          }

      }//end foreach
  }else{  $sold_to_region_title = ''; }


//===== get title industry ==========
  $sold_to_industry_title ='';
  $temp_bapi_industry= $bapi_industry->result_array();
    if(!empty($temp_bapi_industry)){
      foreach($bapi_industry->result_array() as $value){         
         if($value['id']== $sold_to_industry){                                          
              $sold_to_industry_title  = $value['title'];
          }

      }//end foreach
  }else{  $sold_to_industry_title = ''; }


  //===== get title industry ==========
  $sold_to_business_scale_title ='';
  $temp_business_scale= $bapi_business_scale->result_array();
    if(!empty($temp_business_scale)){
      foreach($bapi_business_scale->result_array() as $value){         
         if($value['id']== $sold_to_business_scale){                                          
              $sold_to_business_scale_title  = $value['title'];
          }

      }//end foreach
  }else{  $sold_to_business_scale_title = ''; }

/////////////////// ship to/////////////////////////


//===== get title contry==========
  $ship_to_country_title ='';
  $temp_bapi_country = $bapi_country->result_array();
    if(!empty($temp_bapi_country)){
      foreach($bapi_country->result_array() as $value){  
         if($value['id']== $ship_to_country){                                          
              $ship_to_country_title  = $value['title'];
          }

      }//end foreach
  }else{  $ship_to_country_title = ''; }


//===== get title region ==========
  $ship_to_region_title ='';
  $temp_bapi_region= $bapi_region->result_array();
    if(!empty($temp_bapi_region)){
      foreach($bapi_region->result_array() as $value){         
         if($value['id']== $ship_to_region){                                          
              $ship_to_region_title  = $value['title'];
          }

      }//end foreach
  }else{  $ship_to_region_title = ''; }


  //===== get title industry ==========
  $ship_to_industry_title ='';
  $temp_bapi_industry= $bapi_industry->result_array();
    if(!empty($temp_bapi_industry)){
      foreach($bapi_industry->result_array() as $value){         
         if($value['id']== $ship_to_industry){                                          
              $ship_to_industry_title  = $value['title'];
          }

      }//end foreach
  }else{  $ship_to_industry_title = ''; }


 

  //===== get title industry ==========
  $ship_to_business_scale_title ='';
  $temp_business_scale= $bapi_business_scale->result_array();
    if(!empty($temp_business_scale)){
      foreach($bapi_business_scale->result_array() as $value){         
         if($value['id']== $ship_to_business_scale){                                          
              $ship_to_business_scale_title  = $value['title'];
          }

      }//end foreach
  }else{  $ship_to_business_scale_title = ''; }


/////////////////////////////////////
// === end :  get bapi sap =======
/////////////////////////////////////

// === disbled cilck chemical , staff =====
  $check_temp_area = $get_area->row_array();
   if(!empty($check_temp_area)){  
        $check_temp_area ='disabled';
   }else{
       $check_temp_area ='';
   }//end else




 ?>   
    
  
<section class="panel panel-default ">    
      <input readonly type="hidden" class="form-control account_group" value="<?php echo  $sold_to_ac; ?>" /> 
      <div class="panel-heading" style="padding-bottom :24px;">
       <font class="font-bold h5"> <?php echo freetext('customer'); ?></font>       
        <div class="col-md-4  pull-right no-padd">
           <div class="input-group m-b">
             <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('account_group').'</font></div>'; ?></span>
             <!--  <select readonly name='job_type' class='form-control' >
                   <option <?php //if($job_type ==  'ZQT1' ){ echo  "selected='selected'"; } ?> value='1'><?php //echo freetext('ZQT1'); //No have serial code?>  </option>
                   <option <?php //if($job_type ==  'ZQT2' ){ echo  "selected='selected'"; } ?> value='2'><?php //echo freetext('ZQT2'); //No have serial code?>  </option> 
                   <option <?php //if($job_type ==  'ZQT3' ){ echo  "selected='selected'"; } ?> value='3'><?php //echo freetext('ZQT3'); //No have serial code?>  </option>  
              </select> -->               
              <input readonly type="hidden" name="job_type" class="form-control" value="<?php echo  $job_type; ?>" />  
              <input readonly type="text" autocomplete="off"  class="form-control" value="<?php  if($sold_to_ac!='Z16' && $account_group != 'Z16' ){ echo  freetext($job_type); }else{ echo "งานจรจ้างพิเศษ"; } ?>" />           
          </div>    

        </div> 
    </div>

    <!-- start : data action plan -->
    <div class="panel-body"> 
        <div class="form-group">  

          <div class="col-sm-12 no-padd"> 
           <div class="col-md-12">
                <div class="input-group m-b">
                   <span class="input-group-addon"><?php echo '<font class="pull-left">'.freetext('title').'</font>'; ?></span>
                  <input type="text" autocomplete="off"  name="project_title" class="form-control"  maxlength="512" value="<?php  if(!empty($project_title) ){ echo $project_title; } ?>"  data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>">
                </div>                  
            </div>
          </div>    
       
          <!-- start : input group -->
          <div class="col-sm-12 no-padd">   
             

              <div class="col-md-6">
                  <div class="col-md-5 no-padd">
                    <div class="input-group m-b">
                       <span class="input-group-addon"><?php echo '<font class="pull-left">'.freetext('time').'</font>'; ?></span>
                      <input type="text" autocomplete="off" onkeypress="return isInt(event)" name="time" class="form-control"  maxlength="4" value="<?php  if(!empty($time) || $time!=0 ){ echo $time; } ?>"  data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>">
                    </div>
                  </div>
                  <div class="col-md-5">

                     <!--  <select  name='unit_time' class='form-control' >                       
                        <?php if($job_type == 'ZQT2' || $job_type == 'ZQT3'  ){ ?><option value="day"  <?php if($unit_time=='day'){ echo "selected='selected'"; }  ?>  ><?php echo freetext('day'); ?></option><?php } ?>
                        <?php if($job_type == 'ZQT1' ){ ?><option value="month"  <?php if($unit_time=='month'){ echo "selected='selected'"; }  ?> ><?php echo freetext('month'); ?></option><?php } ?>                    
                      </select> -->
                      
                      <?php if(!empty($unit_time)){ ?>
                      <input type="hidden" readonly="readonly" name="unit_time" class="form-control"   value="<?php echo $unit_time; ?>" />
                      <input type="text" readonly="readonly" name="unit_time_th" class="form-control"   value="<?php  if($unit_time=='day'){ echo 'วัน'; }else{ echo 'เดือน'; } ?>" />
                      <?php }else{ ?>
                      <input type="hidden" readonly="readonly" name="unit_time" class="form-control"   value="<?php if($job_type == 'ZQT1'){ echo 'month'; }else{ echo 'day'; } ?>" />
                      <input type="text" readonly="readonly" name="unit_time_th" class="form-control"   value="<?php if($job_type == 'ZQT1'){ echo 'เดือน'; }else{ echo 'วัน'; } ?>" />
                      <?php } ?>
                  </div>
              </div>                    

               <div class="col-md-6">
                 <div class="input-group m-b">                                                  
                     <span class="input-group-addon">
                      <div class="label-width-adon">                      
                      </div>
                        <font class="pull-left">
                        <input type="checkbox" name="is_competitor" <?php if(!empty($competitor)) { echo "checked='checked'"; echo "value='1'";  }else{ echo "value='0'";  }?> >
                        <?php  echo freetext('competitor'); ?>
                        </font>
                     </span>  
                     
                     <span class="have_compectitor hide">
                         <select  name='competitor_id' class='form-control' disabled>
                            <?php 
                                $temp_bapi_competitor = $bapi_competitor->result_array();
                                if(!empty($temp_bapi_competitor)){
                                foreach($bapi_competitor->result_array() as $value){ 
                             ?>
                                 <option  <?php if($competitor==$value['competitor_id'] ){ echo 'selected="selected"';  } ?>  value='<?php echo $value['competitor_id'] ?>'><?php echo $value['competitor_name'] ?></option> 
                            <?php }//end foreach
                               }else{ ?>
                                 <option value='0'>ไม่มีข้อมูล</option> 
                            <?php } ?>
                        </select>
                      </span>

                      <span class="no_compectitor hide">
                        <select   class='form-control'disabled>
                           <option value='0'>ไม่มีข้อมูล</option> 
                        </select>
                        <input type="hidden" name="competitor_id"  value="" disabled/>
                      </span>
                    
                    <span class="div_compectitor">
                      <?php if(!empty($competitor)){     ?>
                        <select name='competitor_id' class='form-control selected_compectitor'>
                            <?php 
                                $temp_bapi_competitor = $bapi_competitor->result_array();
                                if(!empty($temp_bapi_competitor)){
                                foreach($bapi_competitor->result_array() as $value){ 
                             ?>
                                 <option  <?php if($competitor==$value['competitor_id'] ){ echo 'selected="selected"';  } ?>  value='<?php echo $value['competitor_id'] ?>'><?php echo $value['competitor_name'] ?></option> 
                            <?php }//end foreach
                               }else{ ?>
                                 <option value='0'>ไม่มีข้อมูล</option> 
                            <?php } ?>
                        </select>
                      <?php }else{ ?>
                        <select   class='form-control'disabled>
                           <option value='0'>ไม่มีข้อมูล</option> 
                        </select>
                        <input type="hidden" name="competitor_id" class="input_compectitor"   value="" />
                      <?php } ?>
                    </span>

                </div>
              </div>

          </div>
          <!-- end : input group -->   


           <!--  distribution_channel-->
          <div class="col-sm-12 no-padd"> 
            <?php
             $permission = $this->permission[$this->cat_id];
             $distribution_channel =  $this->session->userdata('distribution_channel');
             //echo '<br>distribution_channel : ';
             //print_r($distribution_channel);
            ?>
              <div class="col-md-6 ">          
                       <div class="col-md-10 input-group m-b">
                         <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('distribution_channel').'</font></div>'; ?></span>
                          <select  disabled name='distribution_channel_selected' class='form-control' id="distribution_channel">
                            <?php 
                                if ($permission['shipto']['value'] == 'all') {                          
                                  foreach($bapi_distribution->result_array() as $value){ 
                                 ?>
                                     <option  value='<?php echo $value['id'] ?>'><?php echo $value['distribution_channel_description'] ?></option> 
                                <?php 
                                  }//end foreach
                                } else {
                                  foreach($distribution_channel as $a => $a_value) {
                                    $temp_bapi_distribution = $bapi_distribution->result_array();
                                    if(!empty($temp_bapi_distribution)){                                
                                    foreach($bapi_distribution->result_array() as $value){ 
                                      if($a_value == $value['id']){
                                 ?>
                                     <option  <?php if($distribution_channel_db ==$value['id'] ){ echo 'selected="selected"';  } ?>  value='<?php echo $value['id'] ?>'><?php echo $value['distribution_channel_description'] ?></option> 
                                <?php 
                                        }//end if
                                      }//end foreach
                                    }else{ 
                                ?>
                                     <option value='0'>ไม่มีข้อมูล</option> 
                                <?php 
                                    }//end else
                                  }//end foeach  distribution_channel
                                }
                            ?>
                          </select>
                          <input type='hidden' readonly name="distribution_channel"  value="<?php echo $distribution_channel_db; ?>" >
                        </div>
                                             
              </div>  

                                               
                  <div class="col-md-6">                                  
                        <label>
                          <font class="pull-left">
                          <input type="checkbox" <?php if(!empty($is_cal_vat) || $is_cal_vat!=0 ||empty($time) ){ ?> checked='checked' <?php } ?>  name="is_cal_vat" value="1" class="is_cal_vat" >
                            <span class="h4">คิดภาษีมูลค่าเพิ่ม</span>                    
                          </font>
                        </label>
                  </div>                  
               

          </div>       
          <!-- end distribution -->                           

            <!--########################### Start :div detail customer ############################-->
          <div class="col-sm-12"> 
              <div class="panel panel-default ">

                <div class="panel-heading">
                  <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseCustomer" class="toggle_custotmer">
                      <?php echo freetext('company'); //Customer?>    
                      <i class="icon_customer_down fa fa-caret-down  text-active pull-right"></i><i class="icon_customer_up fa fa-caret-up text  pull-right"></i>
                    </a>       
                  </h4>
                </div>

                <div id="collapseCustomer" class="panel-collapse in">
                  <!-- start :body detail customer -->
                  <div class="panel-body">

                    <input readonly type="hidden" class="form-control"  name="sold_to_id"  value="<?php echo $sold_to_id; ?>" >
                   <div class="col-sm-12 add-all-medium">

                       <!-- start : input group -->  
                          <div class="col-sm-12 no-padd"> 
                               <div class="col-md-12">
                                <div class="input-group m-b">
                                  <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_name1').'</font></div>'; ?></span>
                                  <input  readonly type="text" autocomplete="off" class="form-control"  name="sold_to_name1"  value="<?php echo $sold_to_name1; ?>" >
                                   <span class="input-group-btn">
                                    <?php if($is_prospect==0){?>
                                    <button class="btn btn-default btn_select_sold_to" type="button" <?php echo $check_temp_area; ?> ><i class="fa fa-th"></i></button>
                                  <?php }else{ ?>
                                    <button class="btn btn-default btn_soldTo_prospect" type="button" <?php echo $check_temp_area; ?> ><i class="fa fa-th"></i></button>
                                  <?php } ?>
                                  </span>
                                </div>
                              </div>                     

                              <!-- <div class="col-md-6">
                                <div class="input-group m-b">
                                   <span class="input-group-addon"><?php //echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_name2').'</font></div>'; ?></span>
                                  <input readonly type="text" autocomplete="off" class="form-control" name="sold_to_name2" value="<?php //echo $sold_to_name2; ?>">  
                                </div>
                              </div> -->
                          </div> 
                    <!-- end : input group -->    

                    <!-- start : input group -->  
                          <div class="col-sm-12 no-padd"> 
                               <div class="col-md-6">
                                 <div class="input-group m-b">
                                  <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_address1').'</font></div>'; ?></span>
                                  <input readonly type="text" autocomplete="off" class="form-control"  name="sold_to_address1" value="<?php echo $sold_to_address1; ?>">  
                                </div>
                              </div>                     

                              <div class="col-md-6">
                                <div class="input-group m-b">
                                  <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_address2').'</font></div>'; ?></span>
                                  <input readonly type="text" autocomplete="off" class="form-control"  name="sold_to_address2" value="<?php echo $sold_to_address2; ?>">  
                                </div>
                              </div>
                          </div> 
                    <!-- end : input group -->

                     <!-- start : input group -->  
                          <div class="col-sm-12 no-padd"> 
                               <div class="col-md-6">
                                 <div class="input-group m-b">
                                   <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_address3').'</font></div>'; ?></span>
                                  <input readonly type="text" autocomplete="off" class="form-control"  name="sold_to_address3" value="<?php echo $sold_to_address3; ?>">  
                                </div>
                              </div>                     

                              <div class="col-md-6">
                                <div class="input-group m-b">
                                   <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_address4').'</font></div>'; ?></span>
                                  <input readonly type="text" autocomplete="off" class="form-control"  name="sold_to_address4" value="<?php echo $sold_to_address4; ?>">  
                                </div>
                              </div>
                          </div> 
                    <!-- end : input group -->

                     <!-- start : input group -->  
                          <div class="col-sm-12 no-padd"> 
                               <div class="col-md-6">
                                 <div class="input-group m-b">
                                     <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_district').'</font></div>'; ?></span>
                                    <input readonly type="text" autocomplete="off" class="form-control"  name="sold_to_district" value="<?php echo $sold_to_district; ?>">  
                                  </div>
                              </div>                     

                              <div class="col-md-6">
                                <div class="input-group m-b">                                                  
                                     <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_city').'</font></div>'; ?></span>
                                     <input readonly type="text" autocomplete="off" name="sold_to_city" class="form-control"   value="<?php echo $sold_to_city; ?>" >                                
                                </div>
                              </div>
                          </div> 
                    <!-- end : input group -->     


                     <!-- start : input group -->  
                          <div class="col-sm-12 no-padd"> 
                               <div class="col-md-6">
                                 <div class="input-group m-b">
                                   <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_postal_code').'</font></div>'; ?></span>
                                  <input readonly type="text" autocomplete="off" name="sold_to_postal_code" class="form-control"   value="<?php echo $sold_to_postal_code; ?>" >
                                </div>
                              </div>                     

                              <div class="col-md-6">
                                <div class="input-group m-b">
                                   <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_country').'</font></div>'; ?></span>
                                    <input readonly type="hidden" name="sold_to_country" class="form-control"  value="<?php echo $sold_to_country; ?>">
                                    <input readonly type="text" autocomplete="off" name="sold_to_country_title" class="form-control"  value="<?php echo $sold_to_country_title; ?>">
                                </div>
                              </div>
                          </div> 
                    <!-- end : input group -->                 

            

                    <!-- start : input group -->  
                          <div class="col-sm-12 no-padd">    
                              <div class="col-md-6">
                                 <div class="input-group m-b">
                                   <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_region').'</font></div>'; ?></span>
                                  <input readonly type="hidden" name="sold_to_region" class="form-control"   value="<?php echo $sold_to_region; ?>" >
                                  <input readonly type="text" autocomplete="off" name="sold_to_region_title" class="form-control"  value="<?php echo $sold_to_region_title; ?>">
                                </div>
                              </div>

                               <div class="col-md-6">
                                 <div class="input-group m-b">
                                   <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_tax_id').'</font></div>'; ?></span>
                                  <!-- <input readonly type="hidden" name="sold_to_tax_id" class="form-control"   value="<?php //echo $sold_to_region; ?>" > -->
                                  <input readonly type="text" autocomplete="off" name="sold_to_tax_id" class="form-control"  value="<?php echo $sold_to_tax_id; ?>">
                                </div>
                              </div>

                          </div> 
                    <!-- end : input group -->  

                      <?php if($is_prospect == 1){ ?> 
                           <div class="col-md-6">
                                 <div class="input-group m-b">
                                   <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('plant').'</font></div>'; ?></span>
                                  <input readonly type="text" autocomplete="off" name="plan_code_prospect" class="form-control"  value="<?php echo $plant_name;//$plan_code_prospect; ?>">
                                </div>
                             </div>
                      <?php } ?>



                     <!-- start : input group -->
                        <!--    <div class="col-md-12 ">
                            <div class="input-group m-b">
                               <span class="input-group-addon"><?php //echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_industry').'</font></div>'; ?></span>
                              <input readonly type="text" autocomplete="off" class="form-control"  name="sold_to_industry"   value="<?php //echo $sold_to_industry; ?>">  
                            </div>
                          </div>  -->
                    <!-- end : input group --> 

                     <!-- start : input group -->
                          <div class="col-sm-12 no-padd"> 

                              <div class="col-md-6">
                                 <div class="input-group m-b">                                                  
                                      <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_industry').'</font></div>'; ?></span>
                                       <input readonly type="hidden" name="sold_to_industry" class="form-control"   value="<?php echo $sold_to_industry; ?>" >
                                       <input readonly type="text" autocomplete="off" name="sold_to_industry_title" class="form-control"   value="<?php echo $sold_to_industry_title; ?>" >
                                </div>
                              </div>


                               <div class="col-md-6">
                                 <div class="input-group m-b">                                                  
                                      <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_business_scale').'</font></div>'; ?></span>
                                      <input readonly type="hidden" name="sold_to_business_scale" class="form-control"   value="<?php echo $sold_to_business_scale; ?>" >
                                      <input readonly type="text" autocomplete="off" name="sold_to_business_scale_title" class="form-control"   value="<?php echo $sold_to_business_scale_title; ?>" >
                                </div>
                              </div>                      

                              <!-- <div class="col-md-6">
                                 <div class="input-group m-b">                                                  
                                      <span class="input-group-addon"><?php //echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_customer_group').'</font></div>'; ?></span>
                                      <select readonly  name='sold_to_customer_group' class='form-control' >
                                           <option value='2'>option2</option> 
                                      </select>
                                </div>
                              </div> --> 
                          </div>   
                    <!-- end : input group --> 


                     <!-- start : input group -->
                          <div class="col-sm-12 no-padd"> 
                               <div class="col-md-6 ">
                                <div class="col-sm-7 no-padd">
                                 <div class="input-group m-b">
                                   <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_tel').'</font></div>'; ?></span>
                                   <input readonly type="text" autocomplete="off" maxlength="10" name="sold_to_tel" class="form-control"  value="<?php echo $sold_to_tel; ?>" >
                                </div>
                              </div>

                               <div class="col-sm-5" style="padding-right:0px;">
                                 <div class="input-group m-b">
                                  <span class="input-group-addon"><?php echo '<font class="pull-left">'.freetext('sold_to_tel_ext').'</font>'; ?></span>
                                  <input readonly type="text" autocomplete="off" maxlength="10" name="sold_to_tel_ext" class="form-control" value="<?php echo $sold_to_tel_ext; ?>" >
                                </div>
                              </div>
                            </div>                      

                            <div class="col-md-6 ">
                              <div class="col-sm-7 no-padd">
                                 <div class="input-group m-b">
                                   <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_fax').'</font></div>'; ?></span>
                                   <input readonly type="text" autocomplete="off" maxlength="10" name="sold_to_fax" class="form-control"  value="<?php echo $sold_to_fax; ?>" >
                                </div>
                              </div>

                               <div class="col-sm-5" style="padding-right:0px;">
                                 <div class="input-group m-b">
                                  <span class="input-group-addon"><?php echo '<font class="pull-left">'.freetext('sold_to_fax_ext').'</font>'; ?></span>
                                  <input readonly type="text" autocomplete="off" maxlength="10" name="sold_to_fax_ext" class="form-control" value="<?php echo $sold_to_fax_ext; ?>" >
                                </div>
                              </div>
                            </div> 

                        </div>   
                    <!-- end : input group --> 


                      <!-- start : input group -->
                          <div class="col-sm-12 no-padd"> 
                              <div class="col-md-6">
                                 <div class="input-group m-b">
                                   <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_mobile').'</font></div>'; ?></span>
                                  <input readonly type="text" autocomplete="off"  maxlength="10" name="sold_to_mobile" class="form-control"  value="<?php echo $sold_to_mobile; ?>" >
                                </div>
                              </div> 

                              <div class="col-md-6">
                                 <div class="input-group m-b">
                                   <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_email').'</font></div>'; ?></span>
                                  <input readonly type="text" autocomplete="off"  maxlength="200" name="sold_to_email" class="form-control"  value="<?php echo $sold_to_email; ?>">
                                </div>
                              </div> 

                          </div>   
                    <!-- end : input group --> 



                        
                    </div>
               
                  </div>
                  <!-- end :body detail customer -->

                </div>
              </div>
           </div>
      <!--################################ end :div  detail customer ############################-->

      <!--########################### Start :div detail site ############################-->
      
          <div class="col-sm-12 customer_tab"> 
              <div class="panel panel-default ">
                <div class="panel-heading">
                  <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseContact" class="toggle_person">
                      <?php echo freetext('site_ship_to'); //Contact person?>
                      <i class="icon_person_down fa fa-caret-down text-active pull-right"></i><i class="icon_person_up fa fa-caret-up text  pull-right"></i> 
                     </a> 
                  </h4>
                </div>
                <div id="collapseContact" class="panel-collapse in">
                  <!-- start :body detail customer -->
                  <div class="panel-body">
                    <div class="col-sm-12 add-all-medium">
                      <!-- start : input group -->
                      <?php 
                        $shipTo_readonly = "";
                        if($is_prospect == 0){ 
                          $shipTo_readonly = "readonly='readonly'";
                      ?>
                        <input type="hidden" class="form-control"  name="ship_to_id"  value="<?php echo $ship_to_id; ?>" >
                      <?php }else{ 
                         $shipTo_readonly = "";
                       ?>
                         <input type="hidden" class="form-control"  name="ship_to_id"  value="<?php echo $ship_to_id; ?>" >
                      <?php } ?>



                      <!-- start : input group -->  
                       <?php  if($is_prospect == 1){ ?>
                          <div class="col-sm-12 no-padd" style="margin-bottom:20px;">                                                
                              <div class="col-md-6 pull-left">                                  
                                    <label>
                                      <font class="pull-left">
                                      <input type="checkbox" name="is_coppy_address" value="" class="is_coppy_address" >
                                      ตามที่อยู่บริษัท                        
                                      </font>
                                    </label>
                              </div>
                              
                          </div> 
                       <?php } ?>
                    <!-- end : input group -->



                          <!-- start : input group -->  
                          <div class="col-sm-12 no-padd"> 
                               <div class="col-md-12">
                                 <div class="input-group m-b">
                                   <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('ship_to_name1').'</font></div>'; ?></span>
                                  <input <?php echo $shipTo_readonly; ?> type="text" maxlength="160" autocomplete="off" class="form-control"  name="ship_to_name1"  value="<?php echo $ship_to_name1?>">
                                  <?php  if($is_prospect == 0){ ?>
                                   <span class="input-group-btn">
                                    <button class="btn btn-default btn_select_shipTo" type="button" <?php echo $check_temp_area; ?> ><i class="fa fa-th"></i></button>
                                  </span>
                                   <?php } ?>
                                </div>
                              </div>                     

                             <!--  <div class="col-md-6">
                                <div class="input-group m-b">
                                   <span class="input-group-addon"><?php //echo '<div class="label-width-adon"><font class="pull-left">'.freetext('ship_to_name2').'</font></div>'; ?></span>
                                  <input <?php //echo $shipTo_readonly; ?> type="text" maxlength="40" autocomplete="off" class="form-control" name="ship_to_name2" value="<?php //echo $ship_to_name2?>" >  
                                </div>
                              </div> -->
                          </div> 
                    <!-- end : input group -->

                     <!-- start : input group -->  
                          <div class="col-sm-12 no-padd"> 
                               <div class="col-md-6">
                                 <div class="input-group m-b">
                                  <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('ship_to_address1').'</font></div>'; ?></span>
                                  <input <?php echo $shipTo_readonly; ?> type="text"  autocomplete="off" class="form-control"  name="ship_to_address1" value="<?php echo $ship_to_address1; ?>">  
                                </div>
                              </div>                     

                              <div class="col-md-6">
                                <div class="input-group m-b">
                                  <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('ship_to_address2').'</font></div>'; ?></span>
                                  <input <?php echo $shipTo_readonly; ?> type="text" autocomplete="off" class="form-control"  name="ship_to_address2" value="<?php echo $ship_to_address2; ?>">  
                                </div>
                              </div>
                          </div> 
                    <!-- end : input group -->

                     <!-- start : input group -->  
                          <div class="col-sm-12 no-padd"> 
                               <div class="col-md-6">
                                 <div class="input-group m-b">
                                     <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('ship_to_address3').'</font></div>'; ?></span>
                                    <input <?php echo $shipTo_readonly; ?> type="text" autocomplete="off" class="form-control" name="ship_to_address3"  value="<?php echo $ship_to_address3?>">  
                                  </div>
                              </div>                     

                              <div class="col-md-6">
                                <div class="input-group m-b">
                                   <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('ship_to_address4').'</font></div>'; ?></span>
                                  <input <?php echo $shipTo_readonly; ?> type="text" autocomplete="off" class="form-control" name="ship_to_address4" value="<?php echo $ship_to_address4?>">  
                                </div>
                              </div>
                          </div> 
                    <!-- end : input group -->

                     <!-- start : input group -->  
                          <div class="col-sm-12 no-padd"> 
                               <div class="col-md-6">
                                <div class="input-group m-b">
                                   <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('ship_to_district').'</font></div>'; ?></span>
                                  <input <?php echo $shipTo_readonly; ?> type="text" autocomplete="off" class="form-control" name="ship_to_district" value="<?php echo $ship_to_district?>">  
                                </div>
                              </div>                     

                              <div class="col-md-6">
                                <div class="input-group m-b">                                                  
                                      <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('ship_to_city').'</font></div>'; ?></span>
                                      <input <?php echo $shipTo_readonly; ?> type="text" autocomplete="off" name="ship_to_city" class="form-control"  value="<?php echo $ship_to_city; ?>">                                 
                                </div>
                              </div>
                          </div> 
                    <!-- end : input group -->

                    <!-- start : input group -->  
                          <div class="col-sm-12 no-padd">   
                              <div class="col-md-6">
                                <div class="input-group m-b">
                                  <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('ship_to_postal_code').'</font></div>'; ?></span>
                                  <input <?php echo $shipTo_readonly; ?> type="text" maxlength="5" onkeypress="return isInt(event)" autocomplete="off" name="ship_to_postal_code" class="form-control"  value="<?php echo $ship_to_postal_code?>">
                                </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="input-group m-b">
                                   <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('ship_to_country').'</font></div>'; ?></span>
                                  <?php  if($is_prospect == 1){  ?>
                                       <select  name='ship_to_country' class='form-control' id="ship_to_country">
                                          <?php 
                                              $temp_bapi_country = $bapi_country->result_array();
                                              if(!empty($temp_bapi_country)){
                                                 if(empty($ship_to_country)){
                                                  echo '<option value="TH" >Thailand</option>';
                                                 }//end if
                                              foreach($bapi_country->result_array() as $value){ 
                                           ?>
                                               <option  <?php if($ship_to_country==$value['id'] ){ echo 'selected="selected"';  } ?>  value='<?php echo $value['id'] ?>'><?php echo $value['title'] ?></option> 
                                          <?php }//end foreach
                                             }else{ ?>
                                               <option value='0'>ไม่มีข้อมูล</option> 
                                          <?php } ?>
                                        </select>

                                  <?php }else{ ?>                                         
                                         <input readonly type="hidden" class="form-control" name="ship_to_country" value="<?php echo $ship_to_country?>">  
                                         <input readonly type="text" autocomplete="off" class="form-control" name="ship_to_country_title" value="<?php echo $ship_to_country_title?>"> 
                                  <?php } ?>
                                   <span class="tx-red" id="msg_ship_to_country"></span>
                                </div>
                              </div> 
                          </div> 
                    <!-- end : input group -->
                      

                    <!-- start : input group -->  
                          <div class="col-sm-12 no-padd">      
                              <div class="col-md-6">
                                 <div class="input-group m-b">
                                   <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('ship_to_region').'</font></div>'; ?></span>
                                   
                                    <?php  if($is_prospect == 1){  ?>
                                      <select   name='ship_to_region' class='form-control'  id="ship_to_region">
                                      <?php 
                                          $temp_bapi_region = $bapi_region->result_array();
                                          if(!empty($temp_bapi_region)){
                                             if(empty($ship_to_region)){
                                                foreach($bapi_region->result_array() as $value){ 
                                                   //echo '<option value="02" >Bangkok TH</option>';
                                                ?>
                                                   <option  <?php if($value['id']=='02' ){ echo 'selected="selected"';  } ?> value='<?php echo $value['id'] ?>'><?php echo $value['title'] ?></option> 
                                                <?php
                                                }

                                              }//end if
                                          foreach($bapi_region->result_array() as $value){                                           
                                       ?>
                                           <option  <?php if($ship_to_region==$value['id'] ){ echo 'selected="selected"';  } ?> value='<?php echo $value['id'] ?>'><?php echo $value['title'] ?></option> 
                                      <?php
                                          }//end foreach
                                         }else{ ?>
                                           <option value='0'>ไม่มีข้อมูล</option> 
                                      <?php } ?>
                                    </select>
                                  <?php }else{ ?>                                         
                                         <input readonly type="hidden" class="form-control" name="ship_to_region" value="<?php echo $ship_to_region?>">  
                                         <input readonly type="text" autocomplete="off" class="form-control" name="ship_to_region_title" value="<?php echo $ship_to_region_title?>"> 
                                  <?php } ?>
                                    <span class="tx-red" id="msg_ship_to_region"></span>
                                </div>
                              </div>

                                <div class="col-md-6">
                                 <div class="input-group m-b">
                                   <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('ship_to_tax_id').'</font></div>'; ?></span>
                                  <!-- <input readonly type="hidden" name="sold_to_tax_id" class="form-control"   value="<?php //echo $sold_to_region; ?>" > -->
                                  <input <?php echo $shipTo_readonly; ?> type="text" autocomplete="off" name="ship_to_tax_id" class="form-control"  value="<?php echo $ship_to_tax_id; ?>">
                                </div>
                              </div>

                              
                          </div> 
                    <!-- end : input group -->   

                    
                      <!-- start : input group -->
                           <!-- <div class="col-md-12 ">
                            <div class="input-group m-b">
                               <span class="input-group-addon"><?php //echo '<div class="label-width-adon"><font class="pull-left">'.freetext('ship_to_industry').'</font></div>'; ?></span>
                              <input <?php //echo $shipTo_readonly; ?> type="text" autocomplete="off" class="form-control" name="ship_to_industry" value="<?php //echo $ship_to_industry?>">  
                            </div>
                          </div>  -->
                    <!-- end : input group --> 

                    <!-- start : input group -->
                          <div class="col-sm-12 no-padd"> 

                              <div class="col-md-6">
                                 <div class="input-group m-b">                                                  
                                      <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('ship_to_industry').'</font></div>'; ?></span>
                                      
                                    <?php  if($is_prospect == 1){  ?>                                    
                                       <select  name='ship_to_industry' class='form-control' id="ship_to_industry">
                                        <?php 
                                            $temp_bapi_industry = $bapi_industry->result_array();
                                            if(!empty($temp_bapi_industry)){
                                                if(empty($ship_to_industry)){
                                                echo '<option value="all" >กรุณาเลือก</option>';
                                                }
                                                foreach($bapi_industry->result_array() as $value){ 
                                         ?>
                                             <option  <?php if($ship_to_industry==$value['id'] ){ echo 'selected="selected"';  } ?> value='<?php echo $value['id'] ?>'><?php echo $value['title'] ?></option> 
                                        <?php }//end foreach
                                           }else{ ?>
                                             <option value='0'>ไม่มีข้อมูล</option> 
                                        <?php } ?>
                                      </select>
                                    <?php }else{ ?>                                         
                                           <input readonly type="hidden" class="form-control" name="ship_to_industry" value="<?php echo $ship_to_industry?>">  
                                           <input readonly type="text" autocomplete="off" class="form-control" name="ship_to_industry_title" value="<?php echo $ship_to_industry_title?>"> 
                                    <?php } ?>
                                    <span class="tx-red" id="msg_ship_to_industry"></span>
                                </div>
                              </div>   


                               <div class="col-md-6">
                                 <div class="input-group m-b">                                                  
                                      <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('ship_to_business_scale').'</font></div>'; ?></span>
                                      
                                      <?php  if($is_prospect == 1){  ?>
                                      <select  name='ship_to_business_scale' class='form-control' id="ship_to_business_scale">
                                        <?php 
                                            $temp_bapi_business_scale = $bapi_business_scale->result_array();
                                            if(!empty($temp_bapi_business_scale)){
                                              if(empty($ship_to_business_scale)){
                                                echo '<option value="all" >กรุณาเลือก</option>';
                                              }
                                            foreach($bapi_business_scale->result_array() as $value){ 
                                         ?>
                                             <option  <?php if($ship_to_business_scale==$value['id'] ){ echo 'selected="selected"';  } ?> value='<?php echo $value['id'] ?>'><?php echo $value['title'] ?></option> 
                                        <?php }//end foreach
                                           }else{ ?>
                                             <option value='0'>ไม่มีข้อมูล</option> 
                                        <?php } ?>
                                     </select>
                                    <?php }else{ ?>                                         
                                           <input readonly type="hidden" class="form-control" name="ship_to_business_scale" value="<?php echo $ship_to_business_scale?>">  
                                           <input readonly type="text" autocomplete="off" class="form-control" name="ship_to_business_scale_title" value="<?php echo $ship_to_business_scale_title?>"> 
                                    <?php } ?>                                
                                    <span class="tx-red" id="msg_ship_to_business_scale"></span>
                                </div>
                              </div>                      

                             <!--  <div class="col-md-6">
                                 <div class="input-group m-b">                                                  
                                      <span class="input-group-addon"><?php //echo '<div class="label-width-adon"><font class="pull-left">'.freetext('ship_to_customer_group').'</font></div>'; ?></span>
                                      <select <?php //echo $shipTo_readonly; ?>  name='ship_to_customer_group' class='form-control' >
                                           <option value='2'>option2</option> 
                                      </select>
                                </div>
                              </div>  -->

                          </div>   
                    <!-- end : input group -->     


                     <!-- start : input group -->
                          <div class="col-sm-12 no-padd"> 
                               <div class="col-md-6 ">
                                <div class="col-sm-7 no-padd">
                                 <div class="input-group m-b">
                                   <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('ship_to_tel').'</font></div>'; ?></span>
                                   <input <?php echo $shipTo_readonly; ?> type="text"  autocomplete="off" maxlength="10" name="ship_to_tel" class="form-control mask-tel"  value="<?php echo $ship_to_tel  ; ?>" >
                                </div>
                              </div>

                               <div class="col-sm-5" style="padding-right:0px;">
                                 <div class="input-group m-b">
                                  <span class="input-group-addon"><?php echo '<font class="pull-left">'.freetext('ship_to_tel_ext').'</font>'; ?></span>
                                  <input <?php echo $shipTo_readonly; ?> type="text" autocomplete="off" maxlength="10" name="ship_to_tel_ext" class="form-control" onkeypress="return isInt(event)" value="<?php echo $ship_to_tel_ext; ?>" >
                                </div>
                              </div>
                            </div>                      

                            <div class="col-md-6 ">
                              <div class="col-sm-7 no-padd">
                                 <div class="input-group m-b">
                                   <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('ship_to_fax').'</font></div>'; ?></span>
                                   <input <?php echo $shipTo_readonly; ?> type="text" autocomplete="off" maxlength="10" name="ship_to_fax" class="form-control mask-tel"  value="<?php echo $ship_to_fax; ?>" >
                                </div>
                              </div>

                               <div class="col-sm-5" style="padding-right:0px;">
                                 <div class="input-group m-b">
                                  <span class="input-group-addon"><?php echo '<font class="pull-left">'.freetext('ship_to_fax_ext').'</font>'; ?></span>
                                  <input <?php echo $shipTo_readonly; ?> type="text" autocomplete="off" maxlength="10" name="ship_to_fax_ext" class="form-control" onkeypress="return isInt(event)" value="<?php echo $ship_to_fax_ext; ?>" >
                                </div>
                              </div>
                            </div> 

                        </div>   
                    <!-- end : input group --> 


                      <!-- start : input group -->
                          <div class="col-sm-12 no-padd"> 
                              <div class="col-md-6">
                                 <div class="input-group m-b">
                                   <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('ship_to_mobile').'</font></div>'; ?></span>
                                  <input  <?php echo $shipTo_readonly; ?> type="text" autocomplete="off"  maxlength="10" name="ship_to_mobile" class="form-control mask-mobile"  value="<?php echo $ship_to_mobile; ?>" >
                                </div>
                              </div> 

                              <div class="col-md-6">
                                 <div class="input-group m-b">
                                   <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('ship_to_email').'</font></div>'; ?></span>
                                  <input <?php echo $shipTo_readonly; ?> type="text" maxlength="200"  autocomplete="off"  name="ship_to_email" class="form-control"  value="<?php echo $ship_to_email; ?>" >
                                </div>
                              </div> 

                          </div>   
                    <!-- end : input group --> 

                        
                    </div><!-- end :col 12 add-all-medium -->                                               
                  </div> <!-- end :panel customer -->  
                </div><!--end : collapseContact -->
              </div><!-- end : panel panel-default -->
           </div>
          
      <!--################################ end :div detail site ############################-->
        </div><!-- End : panel body -->                   
    </div><!-- End : form group -->                                 
  </section><!-- end : panel -->  




<!--################################ start :tab contract and other ############################-->

<section class="panel panel-default ">               
     <div class="panel-heading" style="padding-bottom :24px;">
       <font class="font-bold h5"> <?php echo freetext('contract_person'); ?></font>        
    </div>
    <div class="panel-body"> 
      <div class="form-group">
        <div class="col-sm-12 add-all-medium no-padd">
          <div class="col-sm-12 no-padd" id="other">
         <!--==================== end : table ============--> 
                <input type="hidden" name="first_conut_other" id="first_conut_other" class="form-control" value="0">
                <input type="hidden" name="count_other_contract" id="count_other_contract" class="form-control" value="0">
               
                <table  class="table  m-b-none table_other_contracts" >               
                    <thead>
                      <tr class="back-color-gray">
                        <th><?php echo freetext('firstname'); //First Name?></th>
                       <!--  <th><?php //echo freetext('lastname'); //Last Name?></th> -->
                        <th><?php echo freetext('function'); //Function?></th>
                        <th><?php echo freetext('department');?></th>
                        <th><?php echo freetext('tel'); //Function?></th>
                        <th><?php echo freetext('tel_ext'); //Function?></th>
                        <th><?php echo freetext('fax'); //Function?></th>
                        <th><?php echo freetext('fax_ext'); //Function?></th> 
                        <th><?php echo freetext('mobile_phone'); //mobile phone?></th>
                        <th><?php echo freetext('email'); //mobile phone?></th>
                        <th><?php echo freetext('action'); //mobile phone?></th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                      $count_row_contact =0;   
                    //GET :: sap_tbm_contact
                    if(!empty($ship_to_id) && $is_prospect ==0 ){
                      //echo "ship_to";              
                      $this->db->select('sap_tbm_contact.*');
                      $this->db->where('sap_tbm_contact.ship_to_id', $ship_to_id);
                      $query_sap_tbm_contact= $this->db->get('sap_tbm_contact');
                      $temp_query_sap_tbm_contact = $query_sap_tbm_contact->row_array();
                      if(!empty($temp_query_sap_tbm_contact)){ 
                      foreach($query_sap_tbm_contact->result_array() as $value){
                        $count_row_contact++; 
                    ?>
                     <tr id="<?php echo $value['id']; ?>">
                        <td><?php echo $value['title'].' '.$value['firstname'].' '.$value['lastname'];?></td>
                        <!-- <td><?php //echo $value['lastname'];?></td> -->
                        <td><?php echo $value['function_des'];?></td>
                        <td><?php echo $value['department_des'];?></td>
                        <td><?php echo $value['tel'];?></td>
                        <td><?php echo $value['tel_ext'];?></td>
                        <td><?php echo $value['fax'];?></td>
                        <td><?php echo $value['fax_ext'];?></td>
                        <td><?php echo $value['mobile'];?></td>
                        <td><?php echo $value['email'];?></td>
                        <td></td>
                      </tr>
                    <?php
                        }//end foreach
                      }//end if                    
                    }else{
                      //echo "prospect";
                    }
                    ?>

                      <?php 
                          $temp_query_contact = $query_contact->result_array();
                                    

                        if(!empty($temp_query_contact)){                            
                            foreach($query_contact->result_array() as $value){
                              //if($is_prospect==1 && $value['prospect_id']==$sold_to_id){ 
                              if($value['quotation_id']==$this->quotation_id || ($is_prospect==1 && $value['prospect_id']==$sold_to_id) ){   
                              $count_row_contact++;                           
                          ?>
                          <tr id="<?php echo $value['id']; ?>">
                            <td><?php echo $value['title'].' '.$value['firstname'].' '. $value['lastname'];?></td>
                            <!-- <td><?php //echo $value['lastname'];?></td> -->
                            <td><?php echo $value['function_title'];?></td>
                            <td><?php echo $value['department_title'];?></td>
                            <td><?php echo $value['tel'];?></td>
                            <td><?php echo $value['tel_ext'];?></td>
                            <td><?php echo $value['fax'];?></td>
                            <td><?php echo $value['fax_ext'];?></td>
                            <td><?php echo $value['mobile_no'];?></td>
                            <td><?php echo $value['email'];?></td>
                            <td>
                              <a data-toggle="tooltip" data-placement="top" title="<?php echo freetext('del_label'); ?>" class="btn btn-default delete_other_contact margin-left-small" 
                                id="<?php echo $value['id']; ?>" doc-id="<?php echo $this->quotation_id ?>"   doc-type="quotation">
                                <i class="fa fa-trash-o"></i>
                              </a>
                            </td>
                          </tr>
                          <?php
                                }//end if
                              }//end foreach
                            }else{ 
                          ?>                                   
                         <!--  <tr>
                              <td colspan='7'><?php //echo 'ไม่มีข้อมูล';?></td>                                              
                          </tr> -->
                        <?php 
                            }//end if temp                   
                            
                            if($count_row_contact==0){
                                echo "<tr class='empty_other_contact'><td colspan='7'>ไม่มีข้อมูล</td></tr>";
                            }//end if
                       ?>
                    </tbody> 
                    <tfoot>
                        <tr>  
                            <td>
                              <select  class="form-control contact_title" name="contact_title" >
                                    <option seleted='seleted' value='0'>กรุณาเลือก</option>
                                      <?php 
                                          $temp_bapi_title= $bapi_contact_title->result_array();
                                          if(!empty($temp_bapi_title)){
                                          foreach($bapi_contact_title->result_array() as $value){                                         
                                       ?>
                                           <option  value='<?php echo $value['title'] ?>'><?php echo $value['title'] ?></option> 
                                      <?php 
                                           
                                          }//end foreach
                                         }else{ ?>
                                           <option value='0'>ไม่มีข้อมูล</option> 
                                      <?php } ?>
                             </select>
                             <span class="tx-red text_msg_title"></span>
                            </td>  
                            <td  colspan="2"><input type="text" placeholder="<?php echo freetext('firstname');?>" autocomplete="off" name="other_fist_name" class="form-control other_fist_name"><span class="tx-red text_msg1"></span></td>
                            <td  colspan="2"><input type="text" placeholder="<?php echo freetext('lastname');?>" autocomplete="off" name="other_last_name" class="form-control other_last_name" ><span class="tx-red text_msg2"></span></td>
                            <td colspan="2">
                             <!--  <input type="text" autocomplete="off" name="other_function" class="form-control other_function" > -->
                              <select  class="form-control other_function" name="other_function" >
                                    <option seleted='seleted' value='0'>กรุณาเลือกตำแหน่ง</option>
                                      <?php 
                                          $temp_bapi_otherfuction= $bapi_other_function->result_array();
                                          if(!empty($temp_bapi_otherfuction)){
                                          foreach($bapi_other_function->result_array() as $value){                                         
                                       ?>
                                           <option  value='<?php echo $value['id'].'|'.$value['description'] ?>'><?php echo $value['description'] ?></option> 
                                      <?php 
                                           
                                          }//end foreach
                                         }else{ ?>
                                           <option value='0'>ไม่มีข้อมูล</option> 
                                      <?php } ?>
                             </select>
                              <span class="tx-red text_msg3"></span>
                            </td>
                            <td colspan="2"> 
                            <select  class="form-control other_department" name="other_department" >
                                    <option seleted='seleted' value='0'>กรุณาเลือกแผนก</option>
                                      <?php 
                                          $temp_bapi_department= $bapi_department->result_array();
                                          if(!empty($temp_bapi_department)){
                                          foreach($bapi_department->result_array() as $value){                                         
                                       ?>
                                           <option  value='<?php echo $value['id'].'|'.$value['title'] ?>'><?php echo $value['title'] ?></option> 
                                      <?php 
                                           
                                          }//end foreach
                                         }else{ ?>
                                           <option value='0'>ไม่มีข้อมูล</option> 
                                      <?php } ?>
                            </select>
                            <span class="tx-red text_msg11"></span>
                            </td>                          
                            <td colspan="2"><input type="text" onkeypress="return isInt(event)" placeholder="<?php echo freetext('tel');?>" autocomplete="off" name="other_tel"   onkeypress="return isNumberKey(event)"  class="form-control other_tel mask-tel" ><span class="tx-red text_msg7"></span></td>
                        </tr>
                        <tr>
                            <td  colspan="1"><input onkeypress="return isInt(event)" type="text" placeholder="<?php echo freetext('tel_ext');?>" autocomplete="off" name="other_tel_ext" maxlength="10" onkeypress="return isNumberKey(event)" class="form-control other_tel_ext"><span class="tx-red text_msg8"></span></td>
                            <td  colspan="2"><input onkeypress="return isInt(event)" type="text" placeholder="<?php echo freetext('fax');?>" autocomplete="off" name="other_fax" onkeypress="return isNumberKey(event)" class="form-control other_fax mask-tel"><span class="tx-red text_msg9"></span></td>
                            <td  colspan="2"><input onkeypress="return isInt(event)" type="text" placeholder="<?php echo freetext('fax_ext');?>" autocomplete="off" name="other_fax_ext" maxlength="10" onkeypress="return isNumberKey(event)" class="form-control other_fax_ext"><span class="tx-red text_msg10"></span></td>
                            
                            <td  colspan="2"><input onkeypress="return isInt(event)" type="text" placeholder="<?php echo freetext('mobile_phone');?>" autocomplete="off" name="other_mobile_no"  onkeypress="return isNumberKey(event)" class="form-control other_mobile_no mask-mobile" ><span class="tx-red text_msg5"></span></td>
                            <td  colspan="2"><input type="text" placeholder="<?php echo freetext('email');?>" autocomplete="off" name="other_email" class="form-control other_email" >
                                <span class="tx-red text_msg6"></span>
                                <span class="tx-red text_msg_email"></span>
                            </td>
                            <td><center><a href="#" class="btn btn-s-md btn-default add_oter_contracts"><?php echo freetext('add'); //add?></a></center></td>
                        </tr>
                    </tfoot>  
                 <!--  </tfoot>
                </tfoot> -->









                </table>
          <!--==================== end : table ============-->
           </div>
            <div class='clear:both'></div>
             
          </div> <!-- end : col12 -->                        
      </div><!--end : form-group -->
  </div><!--end : panel-body -->
</section>



<!--################################ start :tab contract and other ############################-->










 <!--################################ start : required ############################-->


  <!--   <?php // foreach($get_requiredByid->result_array() as $row){  if($row['id']== $re_doc_id  ){ echo 'checked="checked"'; } } ?>  -->
<section class="panel panel-default">
  <header class="panel-heading font-bold h5">                  
    <?php echo freetext('required');  ?>
 </header>
  <div class="panel-body">
   
    <!-- start : input group -->
      <div class="col-sm-12 ">

       <?php //get_requiredByid
          $temp_required = $get_required_doc->result_array();
         if(!empty($temp_required)){
           foreach($get_required_doc->result_array() as $value){
               $re_doc_id  = $value['id']; 
               if($required_doc!=''){                                           
        ?>
     
          
          <div class="col-sm-4 h5" >   
              <div class=" checkbox">
                <label>
                   <input <?php if(is_array($required_doc) && in_array($re_doc_id, $required_doc)){ echo "checked='checked'"; } ?> 
                      type="checkbox" name="required_doc[]"  class="required_doc" value="<?php echo $re_doc_id; ?>">
                     <?php echo $value['title']; ?>
                </label>
              </div>
          </div>

        <?php  
              }else{
        ?>

         <div class="col-sm-4 h5" >   
              <div class=" checkbox">
                <label>
                   <input checked="checked"
                      type="checkbox" name="required_doc[]"  class="required_doc" value="<?php echo $re_doc_id; ?>">
                     <?php echo $value['title']; ?>
                </label>
              </div>
          </div>

        <?php
              }//end else

            }//end foreach tbm required
          }else{
         ?>
            <div class="col-sm-2">          
                 <label>                        
                   <?php echo freetext('ไม่มีข้อมูลเอกสาร'); ?>
                  </label>
            </div>
        <?php } ?>

              
     </div>
      <!-- end : input group -->    
  </div>
</section>


 <!--################################ end :required ############################-->




<!-- form submit -->
<div class="form-group col-sm-12 no-padd">
  <div class="pull-right">
    <a href="<?php echo site_url('__ps_quotation/listview_quotation'); ?>"  class="btn btn-default"> <?php echo freetext('cancel'); ?></a>
    <button type="submit" class="btn btn-primary  btn_save_changes margin-left-small"> <?php echo freetext('Save_changes'); ?></button>
  </div>
</div>
<!-- end : form submit -->


</form>
</div>
</section>








<!--################################ start : important docment ############################-->
<section class="panel panel-default ">               
     <div class="panel-heading" style="padding-bottom :24px;">
       <font class="font-bold h5"> <?php echo freetext('doc_file_customer'); ?></font>
        <!-- <div class="col-sm-1  pull-right no-padd">
            <select  name='month' class='form-control' >
                 <option value='0'>all</option> 
            </select>
        </div>  --> 
    </div>

    <div class="panel-body"> 
      <div class="form-group">
        <div class="col-sm-12 add-all-medium">
          <div class="col-sm-12">
            <section class="panel panel-default">
                  <table  class=" table  m-b-none ">
                      <thead>
                        <tr class="back-color-gray">
                          <th width="55%"><?php echo freetext('name_file_upload'); //name?></th>
                          <th class="tx-center">Action</th>                          
                        </tr>
                      </thead>
                      <tbody>
                         <?php 
                            $temp_importance = $query_doc_importance->result_array();
                            //print_r($temp);
                           if(!empty($temp_importance)){                            
                               foreach($query_doc_importance->result_array() as $value){ 
                          ?>
                            
                              <tr id="<?php echo $value['id'];?>">
                              <td><?php echo $value['description'];?></td>
                              <td class="tx-center">
                                <a  href='<?php echo site_url($value['path']);?>' target="_blank" data-toggle="modal" class="btn btn-default" type="button"><i class="fa fa-expand h5"></i> <?php echo freetext('view'); //View?></a>
                                <a href='<?php echo site_url($value['path']);?>'  download="<?php echo site_url($value['description']);?>" class="btn btn-default  margin-left-small" type="button"><i class="fa fa-download"></i> <?php echo freetext('download'); //Download?></a>
                                <a class="btn btn-default delete_importance_file margin-left-small" type="button" id="<?php echo $value['id']; ?>" 
                                  doc-id="<?php echo $this->quotation_id; ?>" doctype="quotation"><i class="fa fa-trash-o"></i> <?php echo freetext('delete'); ?>
                                </a>
                              </td> 
                            </tr>
                            <?php
                                }
                              }else{ echo '<tr><td colspan="3">ไม่มีข้อมูล</td></tr>'; }
                            ?>                            
                      </tbody> 
                  </table>
               </section> 
             </div>

             <!-- start : upload file -->
               <div class="col-sm-12">
                  <form method="post" action="<?php echo site_url('__ps_quotation/upload_file_quotation');?>" enctype="multipart/form-data" />                  
                  <div class="col-sm-10 no-padd">
                     <input readonly type="hidden" name="is_importance" id="is_importance" value="1" />
                     <input readonly type="hidden" name="quotation_id" value="<?php echo $this->quotation_id; ?>" />
                     <input type="file"  name="image"  class="filestyle" data-icon="false" data-classButton="btn btn-default col-sm-2 pull-left" data-classInput="pull-left h3 col-sm-10">                  
                  </div>
                  <div class="col-sm-2 ">
                     <!-- <a href="#" class="btn btn-s-md btn-info pull-left" id="upload_file"><i class="fa fa-upload h5"></i> <?php  //echo freetext('upload'); //Upload?></a>  -->
                    <!--  <input type="submit"  name="submit" id="submit" class="btn btn-s-md btn-info pull-left btn_upload_importance"   value="<?php  //echo freetext('upload'); //Upload?>" /> -->
                      <button disabled id="submit" class="btn btn-s-md btn-info pull-left btn_upload_importance" ><?php  echo freetext('upload'); //Upload?></button>
                  </div>
                </form>
              </div>              
              <!-- End : upload file -->

          </div> <!-- end : col12 -->                        
      </div><!--end : form-group -->
  </div><!--end : panel-body -->
</section>
 <!--################################ end : important docment ############################-->


<!--  <span class="btn btn-s-md btn-info pull-left"><i class="fa fa-upload h5"></i> <?php echo freetext('upload'); //Upload?></span>  -->


<!--################################ start : important docment ############################-->
<section class="panel panel-default ">               
     <div class="panel-heading" style="padding-bottom :24px;">
       <font class="font-bold h5"> <?php echo freetext('doc_file_service'); ?></font>
        <!-- <div class="col-sm-1  pull-right no-padd">
            <select  name='month' class='form-control' >
                 <option value='0'>all</option> 
            </select>
        </div>   -->
    </div>

    <div class="panel-body"> 
      <div class="form-group">
        <div class="col-sm-12 add-all-medium">
          <div class="col-sm-12">
            <section class="panel panel-default">
                  <table  class=" table  m-b-none ">
                      <thead>
                        <tr class="back-color-gray">
                          <th width="55%"><?php echo freetext('name_file_upload'); //name?></th>
                          <th class="tx-center">Action</th>                          
                        </tr>
                      </thead>
                      <tbody>
                         <?php 
                            $temp_ohter = $query_doc_other->result_array();
                           if(!empty($temp_ohter)){
                             foreach($query_doc_other->result_array() as $value){                               
                          ?>
                            
                              <tr id="<?php echo $value['id'];?>">
                              <td><?php echo $value['description'];?></td>
                              <td class="tx-center">
                                <a  href='<?php echo site_url($value['path']);?>' target="_blank" data-toggle="modal" class="btn btn-default" type="button"><i class="fa fa-expand h5"></i> <?php echo freetext('view'); //View?></a>
                                <a href='<?php echo site_url($value['path']);?>'  download="<?php echo site_url($value['description']);?>" class="btn btn-default  margin-left-small" type="button"><i class="fa fa-download"></i> <?php echo freetext('download'); //Download?></a>
                                <a class="btn btn-default delete_other_file margin-left-small" type="button" id="<?php echo $value['id']; ?>" 
                                  doc-id="<?php echo $this->quotation_id; ?>" doctype="quotation"><i class="fa fa-trash-o"></i> <?php echo freetext('delete'); //delete?></a>
                              </td> 
                            </tr>
                            <?php
                               }
                              }else{ echo '<tr><td colspan="3">ไม่มีข้อมูล</td></tr>'; }
                            ?>
                           
                      </tbody> 
                  </table>
               </section> 
             </div>
             <div class='clear:both'></div>
             <!-- start : upload file -->
               <div class="col-sm-12">
                <form method="post" action="<?php echo site_url('__ps_quotation/upload_file_quotation');?>" enctype="multipart/form-data" />   
                  <div class="col-sm-10 no-padd">
                  <input type="hidden" readonly name="is_importance" id="is_importance" value="0" />
                  <input type="hidden" readonly name="quotation_id" value="<?php echo $this->quotation_id; ?>" />
                  <input type="file" name="image"  class="filestyle" data-icon="false" data-classButton="btn btn-default col-sm-2 pull-left" data-classInput="pull-left h3 col-sm-10">
                  </div>
                  <div class="col-sm-2 ">
                     <!-- <a href="#" class="btn btn-s-md btn-info pull-left"><i class="fa fa-upload h5"></i> <?php// echo freetext('upload'); //Upload?></a>  -->
                    <!--  <input  type="submit"   name="submit" id="submit" class="btn btn-s-md btn-info pull-left btn_upload_other"   value="<?php  //echo freetext('upload'); //Upload?>" /> -->
                     <button disabled id="submit" class="btn btn-s-md btn-info pull-left btn_upload_other"><?php  echo freetext('upload'); //Upload?></button>
                  </div>
                </form>
              </div>              
              <!-- End : upload file -->

          </div> <!-- end : col12 -->                        
      </div><!--end : form-group -->
  </div><!--end : panel-body -->
</section>
 <!--################################ end : important docment ############################-->

<?php
  if($this->act=='view_quotation' && $status == 'EFFECTIVE'){
?>
<!--################################ start : download contact doc ############################-->
<section class="panel panel-default ">               
     <div class="panel-heading" style="padding-bottom :24px;">
       <font class="font-bold h5"> <?php echo freetext('contract_doc'); ?></font>
    </div>
    <?php
      $quotation = $query_quotation->row_array();      
      //$doc       = $this->__ps_project_query->getObj('cms_document_other', array('industry_id' => $quotation['ship_to_industry']));
      $doc       = $this->__ps_project_query->getObj('cms_document_other', array('industry_id' => $quotation['ship_to_industry']), false, null, 'id desc,create_date desc');
      //$doc_en    = $this->__ps_project_query->getObj('cms_document_other_en', array('industry_id' => $quotation['ship_to_industry']));
      $doc_en    = $this->__ps_project_query->getObj('cms_document_other_en', array('industry_id' => $quotation['ship_to_industry']), false, null, 'id desc,create_date desc');
     
      // echo "<pre>";
      // print_r($doc);
      // echo "<pre>";
      // print_r($doc_en);
    ?>
    <div class="panel-body row"> 
      <div class="col-sm-6 b-r">
        <div class="form-group">
          <div class="col-sm-12 add-all-medium m-t-sm">
            <a href="#" class="btn btn-primary download_btn download_quotation_th m-r-md"><i class="fa fa-download"></i> ใบเสนอราคา</a>
            <a href="<?php echo site_url('__ps_quotation/loadAreaDoc/'.$data_quotation['id']); ?>" class="btn btn-primary download_btn m-r-md"><i class="fa fa-download"></i> พื้นที่บริการ</a>
            <?php if ($data_quotation['job_type'] == 'ZQT1') { ?><a href="<?php echo site_url('__ps_quotation/loadStaffDoc/'.$data_quotation['id']); ?>" class="btn btn-primary download_btn"><i class="fa fa-download"></i> การจัดวางกำลังคน</a><?php } ?>
          </div>                    
        </div><!--end : form-group -->
      <?php
        if (!empty($contract_id)) {
      ?>
        <div class="form-group">
          <div class="col-sm-12 add-all-medium m-t-sm">       
            <a href="#" class="btn btn-primary download_btn download_contract_th"><i class="fa fa-download"></i> สัญญาว่าจ้างทำความสะอาด</a>
            <?php
              if (!empty($doc)) {
            ?>

            <a href="<?php echo site_url('__ps_quotation/downloadDetailDoc/'.$data_quotation['id']); ?>" class="btn btn-primary download_btn"><i class="fa fa-download"></i> <?php echo substr($doc['description'], 0, strpos($doc['description'], '.')); ?></a>
            <?php
              }
            ?>
          </div>                    
        </div><!--end : form-group -->
      <?php      
        }
      ?>
      </div>
      <div class="col-sm-6">
        <div class="form-group">
          <div class="col-sm-12 add-all-medium m-t-sm">
            <a href="#" class="btn btn-info download_btn download_quotation_en m-r-md"><i class="fa fa-download"></i> Quotation</a>
            <a href="<?php echo site_url('__ps_quotation/loadAreaDoc/'.$data_quotation['id']).'/en'; ?>" class="btn btn-info download_btn m-r-md"><i class="fa fa-download"></i> Area to be Serviced</a>
            <?php if ($data_quotation['job_type'] == 'ZQT1') { ?><a href="<?php echo site_url('__ps_quotation/loadStaffDoc/'.$data_quotation['id'].'/en'); ?>" class="btn btn-info download_btn"><i class="fa fa-download"></i> Staffing Allocation</a><?php } ?>
          </div>                    
        </div><!--end : form-group -->
      <?php
        if (!empty($contract_id)) {
      ?>
        <div class="form-group">
          <div class="col-sm-12 add-all-medium m-t-sm">   
            <a href="#" class="btn btn-info download_btn download_contract_en"><i class="fa fa-download"></i> Cleaning Services Agreement</a>
            <?php
              if (!empty($doc_en)) {
            ?>

            <a href="<?php echo site_url('__ps_quotation/downloadDetailDocEn/'.$data_quotation['id']); ?>" class="btn btn-info download_btn"><i class="fa fa-download"></i> <?php echo substr($doc_en['description'], 0, strpos($doc_en['description'], '.')); ?></a>
            <?php
              }
            ?>
          </div>                    
        </div><!--end : form-group -->
      <?php
        }
      ?>
    </div>
  </div><!--end : panel-body -->
</section>
 <!--################################ end : download contact doc ############################-->
 <?php
  }
 ?>