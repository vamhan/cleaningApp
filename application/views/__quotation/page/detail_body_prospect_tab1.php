
<section>  
<form role="form" id="update_prospect_form" data-parsley-validate action="<?php echo site_url('__ps_quotation/update_prospect/'.$this->prospect_id) ?>" method="POST"> 
<input type="hidden" name="submit_val" class="submit_val" value="0">
<div class="panel-body m-b-xl"> 
 <?php 

     //====start : get data prospect ship_to  =========
     $data_prospect = $query_prospect->row_array();    

     if(!empty($data_prospect)){
         $sold_to_name1     =$data_prospect['sold_to_name1'];      
         //$sold_to_name2     =$data_prospect['sold_to_name2'];
         $sold_to_address1  =$data_prospect['sold_to_address1'];
         $sold_to_address2  =$data_prospect['sold_to_address2'];
         $sold_to_address3  =$data_prospect['sold_to_address3'];
         $sold_to_address4  =$data_prospect['sold_to_address4'];
         $sold_to_district  =$data_prospect['sold_to_district'];
         $sold_to_country   =$data_prospect['sold_to_country'];        
         $sold_to_region       =$data_prospect['sold_to_region'];
         $sold_to_city         =$data_prospect['sold_to_city'];
         $sold_to_postal_code  =$data_prospect['sold_to_postal_code'];
         $sold_to_industry     =$data_prospect['sold_to_industry'];
         $sold_to_business_scale  =$data_prospect['sold_to_business_scale'];
         //$sold_to_customer_group  =$data_prospect['sold_to_customer_group'];

         $sold_to_tel  =$data_prospect['sold_to_tel'];
         $sold_to_tel_ext  =$data_prospect['sold_to_tel_ext'];
         $sold_to_fax  =$data_prospect['sold_to_fax'];
         $sold_to_fax_ext  =$data_prospect['sold_to_fax_ext'];
         $sold_to_mobile  =$data_prospect['sold_to_mobile'];
         $sold_to_email  =$data_prospect['sold_to_email'];
        
         $competitor  =$data_prospect['competitor_id'];
         $unit_time  =$data_prospect['unit_time'];
         $time  =$data_prospect['time'];
         $job_type  =$data_prospect['job_type'];
         $distribution_channel_db  =$data_prospect['distribution_channel'];
         $plan_code_prospect = $data_prospect['plan_code_prospect'];
      }
      else{ 
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
         //$sold_to_customer_group = '';
         $sold_to_tel  ='';
         $sold_to_tel_ext  ='';
         $sold_to_fax  ='';
         $sold_to_fax_ext  ='';
         $sold_to_mobile  ='';
         $sold_to_email  ='';

         $competitor  =  '';
         $unit_time  = '';
         $time  = '';
         $job_type  = '';
         $distribution_channel_db  = '';
         $plan_code_prospect = '';
      }

    //====end : get data prospect ship_to =========

 // if($sold_to_country==''){
 //    $sold_to_country='TH';
 // }  

 // if($sold_to_region==''){
 //    $sold_to_region='02';
 // }  


   // //====start : get data main contract prospect  =========
   //      $data_main_contract = $query_main_contract->row_array(); 

   //      if(!empty($data_main_contract)){

   //        $main_contact_id              =$data_main_contract['main_contact_id'];
   //        $data_contract_firstname      =$data_main_contract['firstname'];
   //        $data_contract_lastname       =$data_main_contract['lastname'];
   //        //$data_contract_position       =$data_main_contract['position'];
   //        $data_contract_function       =$data_main_contract['function'];
   //        $data_contract_department     =$data_main_contract['department'];
   //        $data_contract_phone_no       =$data_main_contract['phone_no'];
   //        $data_contract_phone_no_ext   =$data_main_contract['phone_no_ext'];
   //        $data_contract_mobile_no      =$data_main_contract['mobile_no'];
   //        $data_contract_fax            = $data_main_contract['fax'];
   //        $data_contract_email          =$data_main_contract['email'];

   //      }else{

   //          $main_contact_id = 0;
   //          $data_contract_firstname = '';
   //          $data_contract_lastname ='';
   //          $data_contract_position ='';
   //          $data_contract_function ='';
   //          $data_contract_department ='';
   //          $data_contract_phone_no ='';
   //          $data_contract_phone_no_ext = '';
   //          $data_contract_mobile_no ='';
   //          $data_contract_fax = '';
   //          $data_contract_email = '';


   //      }

   // //====end : get data  main contract prospect =========

 ?>  
<section class="panel panel-default customer_tab">    
     <div class="panel-heading" style="padding-bottom :24px;">
       <font class="font-bold h5"> <?php echo freetext('customer'); //echo $sold_to_country .' '.$sold_to_region; ?></font>       
        
      <!--   <div class="col-md-4  pull-right no-padd">
           <div class="input-group m-b">
             <span class="input-group-addon"><?php //echo '<div class="label-width-adon"><font class="pull-left">'.freetext('account_group').'</font></div>'; ?></span>
              <input readonly type="hidden" name="job_type" class="form-control" value="<?php //echo  $job_type; ?>" />
              <input readonly type="text" autocomplete="off"  class="form-control" value="<?php //echo  freetext($job_type); ?>" />  
          </div>
        </div>   -->

    </div>


    <!-- start : data action plan -->
    <div class="panel-body"> 
        <div class="form-group">       
       
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
                    <!--   <select  name='unit_time' class='form-control' >                       
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
          <div class="col-sm-12  no-padd"> 
            <?php
             $permission = $this->permission[$this->cat_id];
             $distribution_channel =  $this->session->userdata('distribution_channel');
             //echo '<br>distribution_channel : ';
             //print_r($distribution_channel);
            ?>
              <div class="col-md-5">                 
                      
                       <div class="input-group m-b">
                         <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('distribution_channel').'</font></div>'; ?></span>
                          <select   name='distribution_channel' class='form-control distribution_channel' id="distribution_channel">
                            <option selected='selected' value='all'>กรุณาเลือก</option>   
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
                                     <option  <?php if($distribution_channel_db == $value['id'] ){ echo 'selected="selected"';  } ?>  value='<?php echo $value['id'] ?>'><?php echo $value['distribution_channel_description'] ?></option> 
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
                          <span id="msg_distribution_channel"></span>
                        </div>
                                         
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


                    <div class="col-sm-12 add-all-medium">

                      <!-- start : input group -->  
                          <div class="col-sm-12 no-padd"> 
                               <div class="col-md-12">
                                 <div class="input-group m-b">
                                    <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_name1').'</font></div>'; ?></span>
                                    <input type="text" autocomplete="off" maxlength="160" class="form-control"  name="sold_to_name1"  value="<?php echo $data_prospect['sold_to_name1']; ?>"  data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>">
                                   <!--   <span class="input-group-btn">
                                      <button class="btn btn-default" type="button"><i class="fa fa-th"></i></button>
                                    </span> -->
                                  </div>
                              </div>                     

                             <!--  <div class="col-md-6">
                                 <div class="input-group m-b">
                                     <span class="input-group-addon"><?php //echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_name2').'</font></div>'; ?></span>
                                    <input type="text" autocomplete="off" maxlength="40" class="form-control" name="sold_to_name2" value="<?php //echo $data_prospect['sold_to_name2']; ?>">  
                                  </div>
                              </div>
 -->                              
                          </div> 
                    <!-- end : input group -->

                    <!-- start : input group -->  
                          <div class="col-sm-12 no-padd"> 
                               <div class="col-md-6">
                                 <div class="input-group m-b">
                                     <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_address1').'</font></div>'; ?></span>
                                    <input type="text" autocomplete="off" class="form-control"  name="sold_to_address1" value="<?php echo $data_prospect['sold_to_address1']; ?>">  
                                  </div>
                              </div>                     

                              <div class="col-md-6">
                                 <div class="input-group m-b">
                                    <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_address2').'</font></div>'; ?></span>
                                    <input type="text" autocomplete="off" class="form-control"  name="sold_to_address2" value="<?php echo $data_prospect['sold_to_address2']; ?>">  
                                  </div>
                              </div>
                          </div> 
                    <!-- end : input group -->

                    <!-- start : input group -->  
                          <div class="col-sm-12 no-padd"> 
                               <div class="col-md-6">
                                 <div class="input-group m-b">
                                   <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_address3').'</font></div>'; ?></span>
                                  <input type="text" autocomplete="off" class="form-control"  name="sold_to_address3" value="<?php echo $data_prospect['sold_to_address3']; ?>">  
                                </div>
                              </div>                     

                              <div class="col-md-6">
                                 <div class="input-group m-b">
                                     <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_address4').'</font></div>'; ?></span>
                                    <input type="text" autocomplete="off" class="form-control"  name="sold_to_address4" value="<?php echo $data_prospect['sold_to_address4']; ?>">  
                                  </div>
                              </div>
                          </div> 
                    <!-- end : input group -->


                    <!-- start : input group -->  
                          <div class="col-sm-12 no-padd"> 
                               <div class="col-md-6">
                                <div class="input-group m-b">
                                   <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_district').'</font></div>'; ?></span>
                                  <input type="text" autocomplete="off" class="form-control"  name="sold_to_district" value="<?php echo $data_prospect['sold_to_district']; ?>">  
                                </div>
                              </div>                     

                              <div class="col-md-6">
                                 <div class="input-group m-b">                                                  
                                    <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_city').'</font></div>'; ?></span>
                                    <input type="text" autocomplete="off" name="sold_to_city" class="form-control"   value="<?php echo $sold_to_city; ?>" data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>">                               
                                </div>
                              </div>
                          </div> 
                    <!-- end : input group --> 


                     <!-- start : input group -->  
                          <div class="col-sm-12 no-padd"> 
                               <div class="col-md-6">
                                <div class="input-group m-b">
                                   <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_postal_code').'</font></div>'; ?></span>
                                  <input type="text" autocomplete="off" name="sold_to_postal_code" class="form-control"  maxlength="5" onkeypress="return isInt(event)"  value="<?php echo $data_prospect['sold_to_postal_code']; ?>" data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>">
                                </div>
                              </div>                     

                              <div class="col-md-6">
                                 <div class="input-group m-b">
                                   <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_country').'</font></div>'; ?></span>
                                    <select  name='sold_to_country' class='form-control' id="sold_to_country">
                                      <?php 
                                          $temp_bapi_country = $bapi_country->result_array();
                                          if(!empty($temp_bapi_country)){
                                            if(empty($sold_to_country)){
                                                  echo '<option value="TH" >Thailand</option>';
                                            }//end if
                                          foreach($bapi_country->result_array() as $value){ 
                                       ?>
                                           <option  <?php if($sold_to_country==$value['id'] ){ echo 'selected="selected"';  } ?>  value='<?php echo $value['id'] ?>'><?php echo $value['title'] ?></option> 
                                      <?php }//end foreach
                                         }else{ ?>
                                           <option value='0'>ไม่มีข้อมูล</option> 
                                      <?php } ?>
                                    </select>
                                    <span class="tx-red" id="msg_sold_to_country"></span>
                                  </div>
                              </div> 

                          </div> 
                    <!-- end : input group -->             

                  

                    <!-- start : input group -->  
                          <div class="col-sm-12 no-padd">                                                  

                              <div class="col-md-6">
                                 <div class="input-group m-b">
                                   <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_region').'</font></div>'; ?></span>
                                    <select  name='sold_to_region' class='form-control' id="sold_to_region">
                                      <?php 
                                          $temp_bapi_region = $bapi_region->result_array();
                                          if(!empty($temp_bapi_region)){
                                             if(empty($sold_to_region)){
                                                foreach($bapi_region->result_array() as $value){ 
                                                      //echo '<option value="02" >Bangkok TH</option>';
                                                      //echo '<option value="'.$value['id'].'" >'.$value['title'].'</option>';
                                                    ?>                                                      
                                                       <option  <?php if($value['id']=='02' ){ echo 'selected="selected"';  } ?> value='<?php echo $value['id'] ?>'><?php echo $value['title'] ?></option> 
                                                    <?php
                                                }
                                              }//end if
                                          foreach($bapi_region->result_array() as $value){ 
                                       ?>
                                           <option  <?php if($sold_to_region==$value['id'] ){ echo 'selected="selected"';  } ?> value='<?php echo $value['id'] ?>'><?php echo $value['title'] ?></option> 
                                      <?php 
                                          }//end foreach
                                         }else{ ?>
                                           <option value='0'>ไม่มีข้อมูล</option> 
                                      <?php } ?>
                                    </select>
                                    <span class="tx-red" id="msg_sold_to_region"></span>
                                </div>
                              </div>

                              <div class="col-md-6">
                                 <div class="input-group m-b">
                                   <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('plant').'</font></div>'; ?></span>
                                    <select  name='plan_code_prospect' class='form-control' id="plan_code_prospect" data-parsley-required="true" data-parsley-error-message="">
<?php 
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
?>
                                      <option value="" >กรุณาเลือก</option>
                                      <?php 
                                      if(!empty($array_plant)){
                                      foreach($array_plant as $a => $a_value) {
                                      ?>
                                      <option  value='<?php echo $a; ?>'  <?php if($plan_code_prospect==$a){ echo 'selected="selected"';  } ?> ><?php echo $a_value; ?></option> 
                                      <?php           
                                        }//end foreach
                                        }else{ 
                                      ?>
                                        <option value=''>ไม่มีข้อมูล</option> 
                                      <?php }//end else ?>
                                    </select>                                  
                                </div>
                              </div>

                          </div> 
                    <!-- end : input group -->  


                     <!-- start : input group -->
                          <div class="col-sm-12 no-padd"> 

                               <div class="col-md-6">
                                 <div class="input-group m-b">                                                  
                                     <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_industry').'</font></div>'; ?></span>
                                     <select  name='sold_to_industry' id="sold_to_industry" class='form-control' >
                                      <?php 
                                          $temp_bapi_industry = $bapi_industry->result_array();
                                          if(!empty($temp_bapi_industry)){
                                            if(empty($sold_to_industry)){
                                                  echo '<option value="all" >กรุณาเลือก</option>';
                                              }//end if
                                          foreach($bapi_industry->result_array() as $value){ 
                                       ?>
                                           <option  <?php if($sold_to_industry==$value['id'] ){ echo 'selected="selected"';  } ?> value='<?php echo $value['id'] ?>'><?php echo $value['title'] ?></option> 
                                      <?php }//end foreach
                                         }else{ ?>
                                           <option value='0'>ไม่มีข้อมูล</option> 
                                      <?php } ?>
                                    </select>
                                    <span class="tx-red" id="msg_sold_to_industry"></span>
                                </div>
                              </div>

                               <div class="col-md-6">
                                 <div class="input-group m-b">                                                 
                                      <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_business_scale').'</font></div>'; ?></span>
                                   
                                      <select  name='sold_to_business_scale' id='sold_to_business_scale' class='form-control' data-parsley-required="true" data-parsley-error-message='<?php echo freetext('required_msg'); ?>'  >
                                      <?php 
                                          $temp_bapi_business_scale = $bapi_business_scale->result_array();
                                          if(!empty($temp_bapi_business_scale)){
                                            if(empty($sold_to_business_scale)){
                                                  echo '<option value="" >กรุณาเลือก</option>';
                                              }//end if
                                          foreach($bapi_business_scale->result_array() as $value){ 
                                       ?>
                                           <option  <?php if($sold_to_business_scale==$value['id'] ){ echo 'selected="selected"';  } ?> value='<?php echo $value['id'] ?>'><?php echo $value['title'] ?></option> 
                                      <?php }//end foreach
                                         }else{ ?>
                                           <option value='0'>ไม่มีข้อมูล</option> 
                                      <?php } ?>
                                    </select>
                                    <span class="tx-red" id="msg_sold_to_business_scale"></span>
                                </div>
                              </div>  

                              <!-- <div class="col-md-6">
                                 <div class="input-group m-b">                                                  
                                      <span class="input-group-addon"><?php //echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_customer_group').'</font></div>'; ?></span>
                                      <select  name='sold_to_customer_group' class='form-control' >
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
                                   <input type="text" autocomplete="off" maxlength="10" onkeypress="return isNumberKey(event)" name="sold_to_tel" class="form-control mask-tel"  value="<?php echo $sold_to_tel  ; ?>" >
                                </div>
                              </div>

                               <div class="col-sm-5" style="padding-right:0px;">
                                 <div class="input-group m-b">
                                  <span class="input-group-addon"><?php echo '<font class="pull-left">'.freetext('sold_to_tel_ext').'</font>'; ?></span>
                                  <input type="text" autocomplete="off" maxlength="10" onkeypress="return isNumberKey(event)" name="sold_to_tel_ext" class="form-control" value="<?php echo $sold_to_tel_ext; ?>" >
                                </div>
                              </div>
                            </div>


                            <div class="col-md-6 ">
                              <div class="col-sm-7 no-padd">
                                 <div class="input-group m-b">
                                   <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_fax').'</font></div>'; ?></span>
                                   <input type="text" autocomplete="off" maxlength="10" onkeypress="return isNumberKey(event)"  name="sold_to_fax" class="form-control mask-tel"  value="<?php echo $sold_to_fax; ?>" >
                                </div>
                              </div>

                               <div class="col-sm-5" style="padding-right:0px;">
                                 <div class="input-group m-b">
                                  <span class="input-group-addon"><?php echo '<font class="pull-left">'.freetext('sold_to_fax_ext').'</font>'; ?></span>
                                  <input type="text" autocomplete="off" maxlength="10" onkeypress="return isNumberKey(event)" name="sold_to_fax_ext" class="form-control" value="<?php echo $sold_to_fax_ext; ?>" >
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
                                  <input type="text" autocomplete="off"  maxlength="10" onkeypress="return isNumberKey(event)" name="sold_to_mobile" class="form-control mask-mobile"  value="<?php echo $data_prospect['sold_to_mobile']; ?>">
                                </div>
                              </div>                     

                              <div class="col-md-6">
                                 <div class="input-group m-b">
                                   <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_email').'</font></div>'; ?></span>
                                  <input type="text" maxlength="200"  autocomplete="off"  name="sold_to_email" class="form-control"   value="<?php echo $data_prospect['sold_to_email']; ?>"   data-parsley-type="email">
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
                        <!-- <th><?php //echo freetext('lastname'); //Last Name?></th> -->
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
                        if(!empty($query_contact)){
                            foreach($query_contact->result_array() as $value){ 
                          ?>
                          <tr class="other_contracts_id" id="<?php echo $value['id']; ?>">
                            <td><?php echo $value['title'].' '.$value['firstname'].' '.$value['lastname'];?></td>
                           <!--  <td><?php //echo $value['lastname'];?></td> -->
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
                                id="<?php echo $value['id']; ?>" doc-id="<?php echo $this->prospect_id; ?>"   doc-type="prospect">
                                <i class="fa fa-trash-o"></i>
                              </a>
                            </td>
                          </tr>
                          <?php
                              }//end foreach
                            }else{ 
                          ?>                                   
                          <tr>
                              <td colspan='7'><?php echo 'ไม่มีข้อมูล';?></td>                                              
                          </tr>
                        <?php } ?>
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
                          </td>
                          <td colspan="2"><input type="text" placeholder="<?php echo freetext('firstname');?>" autocomplete="off" name="other_fist_name" class="form-control other_fist_name" ><span class="tx-red text_msg1"></span></td>
                          <td colspan="2"><input type="text" placeholder="<?php echo freetext('lastname');?>" autocomplete="off" name="other_last_name" class="form-control other_last_name" ><span class="tx-red text_msg2"></span></td>
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
                          <td colspan="2"><input type="text" onkeypress="return isInt(event)" placeholder="<?php echo freetext('tel');?>" autocomplete="off" name="other_tel"   onkeypress="return isNumberKey(event)"  class="form-control other_tel mask-tel"><span class="tx-red text_msg7"></span></td>
                          
                        </tr>
                        <tr>
                          <td colspan="1"><input type="text" onkeypress="return isInt(event)" placeholder="<?php echo freetext('tel_ext');?>" autocomplete="off" name="other_tel_ext" maxlength="10"  onkeypress="return isNumberKey(event)" class="form-control other_tel_ext"><span class="tx-red text_msg8"></span></td>
                          <td colspan="2"><input type="text" onkeypress="return isInt(event)" placeholder="<?php echo freetext('fax');?>" autocomplete="off" name="other_fax" onkeypress="return isNumberKey(event)" class="form-control other_fax mask-tel"><span class="tx-red text_msg9"></span></td>
                          <td colspan="2"><input type="text" onkeypress="return isInt(event)" placeholder="<?php echo freetext('fax_ext');?>" autocomplete="off" name="other_fax_ext" maxlength="10"  onkeypress="return isNumberKey(event)" class="form-control other_fax_ext"><span class="tx-red text_msg10"></span></td>
                          <td colspan="2"><input type="text" onkeypress="return isInt(event)" placeholder="<?php echo freetext('mobile_phone');?>" autocomplete="off" name="other_mobile_no" onkeypress="return isNumberKey(event)" class="form-control other_mobile_no mask-mobile" ><span class="tx-red text_msg5"></span></td>
                          <td colspan="2"><input type="text" placeholder="<?php echo freetext('email');?>" autocomplete="off" name="other_email" class="form-control other_email" >
                              <span class="tx-red text_msg6"></span>
                              <span class="tx-red text_msg_email"></span>
                          </td>
                          <td><a href="#" class="btn btn-s-md btn-default add_oter_contracts"><?php echo freetext('add'); //add?></a></td>
                        </tr>
                    </tfoot>                     
                </table>
          <!--==================== end : table ============-->
           </div>
            <div class='clear:both'></div>
             
          </div> <!-- end : col12 -->                        
      </div><!--end : form-group -->
  </div><!--end : panel-body -->
</section>



<!--============ .nav-justified ======================-->
   <!--  <section class="panel panel-default">
      <header class="panel-heading bg-light">
        <ul class="nav nav-tabs nav-justified">
            <li class="h5 contrack_person active"><a href="#contrack_person" data-toggle="tab"><?php //echo freetext('contract_person');?></a></li>
            <li class="h5 other"><a href="#other" data-toggle="tab"><?php //echo freetext('other_contacts');?></a></li>                           
        </ul>
      </header>

      <div class="panel-body">
        <div class="tab-content">
          <div class="tab-pane active" id="contrack_person">  
                <div class="col-sm-12 add-all-medium"> -->
                   
                   <!-- start : input group -->
                  <!--  <input type="hidden" name="contrack_main_id" class="form-control"  value="<?php //echo  $main_contact_id; ?>">
                      <div class="col-sm-12">  
                          <div class="col-md-6">
                             <div class="input-group m-b">
                               <span class="input-group-addon"><?php //echo '<div class="label-width-adon"><font class="pull-left">'.freetext('first_name').'</font></div>'; ?></span>
                              <input type="text" autocomplete="off" name="contract_firstname" class="form-control"  value="<?php //echo $data_contract_firstname; ?>"  data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>">
                            </div>
                          </div>

                           <div class="col-md-6">
                             <div class="input-group m-b">
                               <span class="input-group-addon"><?php //echo '<div class="label-width-adon"><font class="pull-left">'.freetext('last_name').'</font></div>'; ?></span>
                              <input type="text" autocomplete="off" name="contract_lastname" class="form-control" value="<?php //echo $data_contract_lastname ; ?>" data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>">
                            </div>
                          </div>
                      </div>  -->
                   <!-- end : input group --> 

                       <!-- start : input group -->
                    <!--   <div class="col-sm-12">  
                        
                           <div class="col-md-6">
                             <div class="input-group m-b">
                               <span class="input-group-addon"><?php //echo '<div class="label-width-adon"><font class="pull-left">'.freetext('function').'</font></div>'; ?></span>
                              <input type="text" autocomplete="off" name="contact_function" class="form-control"   value="<?php //echo $data_contract_function ; ?>" >
                            </div>
                          </div>

                          <div class="col-md-6 ">
                              <div class="col-sm-7 no-padd">
                                 <div class="input-group m-b">
                                   <span class="input-group-addon"><?php //echo '<div class="label-width-adon"><font class="pull-left">'.freetext('telephone').'</font></div>'; ?></span>
                                   <input type="text" autocomplete="off" maxlength="10" name="contact_telephone" class="form-control"  value="<?php //echo $data_contract_phone_no  ; ?>" data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>">
                                </div>
                              </div>

                               <div class="col-sm-5" style="padding-right:0px;">
                                 <div class="input-group m-b">
                                  <span class="input-group-addon"><?php //echo '<font class="pull-left">'.freetext('ext').'</font>'; ?></span>
                                  <input type="text" autocomplete="off" name="contact_ext" class="form-control" value="<?php //echo $data_contract_phone_no_ext; ?>" >
                                </div>
                              </div>
                            </div>

                      </div>  -->
                       <!-- end : input group -->

                       <!-- start : input group -->
                       <!-- <div class="col-sm-12">  
                          <div class="col-md-6">
                             <div class="input-group m-b">
                              <span class="input-group-addon"><?php //echo '<div class="label-width-adon"><font class="pull-left">'.freetext('department').'</font></div>'; ?></span>
                              <input type="text" autocomplete="off" name="contact_department" class="form-control" value="<?php //echo $data_contract_department; ?>" >
                            </div>
                          </div>

                           <div class="col-md-6">
                             <div class="input-group m-b">
                              <span class="input-group-addon"><?php //echo '<div class="label-width-adon"><font class="pull-left">'.freetext('email').'</font></div>'; ?></span>
                              <input type="text" autocomplete="off" name="contact_email" class="form-control"  value="<?php //echo $data_contract_email; ?>"  data-parsley-required="true"  data-parsley-type="email">
                            </div>
                          </div>                           
                      </div>  -->
                       <!-- end : input group -->

                      <!-- start : input group -->
                      <!--  <div class="col-sm-12">  
                          <div class="col-md-6">
                             <div class="input-group m-b">
                              <span class="input-group-addon"><?php //echo '<div class="label-width-adon"><font class="pull-left">'.freetext('mobile_phone').'</font></div>'; ?></span>
                              <input type="text" autocomplete="off" name="contact_mobile_phone" class="form-control" value="<?php //echo $data_contract_mobile_no; ?>" data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>">
                            </div>
                          </div>

                           <div class="col-md-6">
                             <div class="input-group m-b">
                              <span class="input-group-addon"><?php //echo '<div class="label-width-adon"><font class="pull-left">'.freetext('fax').'</font></div>'; ?></span>
                              <input type="text" autocomplete="off" name="contact_fax" class="form-control" value="<?php //echo $data_contract_fax; ?>" data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>">
                            </div>
                          </div>
                      </div>  -->
                       <!-- end : input group -->                   
            <!--   </div>

          </div>
          <div class="tab-pane" id="other"> -->
                          
                                <!-- <input type="hidden" name="first_conut_other" id="first_conut_other" class="form-control" value="0">
                                <input type="hidden" name="count_other_contract" id="count_other_contract" class="form-control" value="0">
                                <table  class="table  m-b-none table_other_contracts" > -->
                               
                                  <!--   <thead>
                                      <tr class="back-color-gray">
                                        <th><?php //echo freetext('firstname'); //First Name?></th>
                                        <th><?php //echo freetext('lastname'); //Last Name?></th>
                                        <th><?php //echo freetext('function'); //Function?></th> 
                                        <th><?php //echo freetext('mobile_phone'); //mobile phone?></th>
                                        <th><?php //echo freetext('email'); //mobile phone?></th>
                                        <th><?php //echo freetext('action'); //mobile phone?></th>
                                        <th></th>
                                      </tr>
                                    </thead>
                                    <tbody> -->

                                      <?php 
                                        // if(!empty($query_contact)){
                                        //     foreach($query_contact->result_array() as $value){ 
                                          ?>
                                         <!--  <tr id="<?php //echo $value['id']; ?>">
                                            <td><?php //echo $value['firstname'];?></td>
                                            <td><?php //echo $value['lastname'];?></td>
                                            <td><?php //echo $value['function'];?></td>
                                            <td><?php //echo $value['mobile_no'];?></td>
                                            <td><?php //echo $value['email'];?></td>
                                            <td>
                                              <a data-toggle="tooltip" data-placement="top" title="<?php //echo freetext('del_label'); ?>" class="btn btn-default delete_other_contact margin-left-small" 
                                                id="<?php //echo $value['id']; ?>" doc-id="<?php //echo $this->prospect_id; ?>"   doc-type="prospect">
                                                <i class="fa fa-trash-o"></i>
                                              </a>
                                            </td>
                                          </tr> -->
                                          <?php
                                              //}//end foreach
                                           // }else{ 
                                          ?>                                   
                                         <!--  <tr>
                                              <td colspan='7'><?php //echo 'ไม่มีข้อมูล';?></td>                                              
                                          </tr> -->
                                        <?php //} ?>
                                    <!-- </tbody> 
                                    <tfoot>
                                        <tr>
                                          <td><input type="text" autocomplete="off" name="other_fist_name" class="form-control other_fist_name" ><span class="tx-red text_msg1"></span></td>
                                          <td><input type="text" autocomplete="off" name="other_last_name" class="form-control other_last_name" ><span class="tx-red text_msg2"></span></td>
                                          <td><input type="text" autocomplete="off" name="other_function" class="form-control other_function" ><span class="tx-red text_msg3"></span></td>
                                          <td><input type="text" autocomplete="off" name="other_mobile_no" class="form-control other_mobile_no" ><span class="tx-red text_msg5"></span></td>
                                          <td><input type="text" autocomplete="off" name="other_email" class="form-control other_email" >
                                              <span class="tx-red text_msg6"></span>
                                              <span class="tx-red text_msg_email"></span>
                                          </td>
                                          <td><a href="#" class="btn btn-s-md btn-default add_oter_contracts"><?php //echo freetext('add'); //add?></a></td>
                                        </tr>
                                    </tfoot>                     
                                </table>  
                          </div>
                          
                        </div>
                      </div>
                    </section> -->
<!--======== / .nav-justified ===============-->



<!-- form submit -->
<div class="form-group col-sm-12 no-padd">
  <div class="pull-right">
    <a href="<?php echo site_url('__ps_quotation/listview_prospect'); ?>"  class="btn btn-default"> <?php echo freetext('cancel'); ?></a>
    <button type="submit" class="btn btn-primary  btn_save_changes margin-left-small"><?php echo freetext('Save_changes'); ?></button>
  </div>
  <div class="pull-left">
    <a href="#" class="btn btn-info submit_prospect"><?php echo freetext('submit_prospect'); ?></a>
  </div>
</div>
<!-- end : form submit -->


</form>
</div>
</section>



<!--################################ start : important docment ############################-->
<section class="panel panel-default ">               
     <div class="panel-heading" style="padding-bottom :24px;">
       <font class="font-bold h5"> <?php echo freetext('importance'); ?></font>
        <!-- <div class="col-sm-1  pull-right no-padd">
            <select  name='month' class='form-control' >
                 <option value='0'>all</option> 
            </select>
        </div> -->  
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
                                  doc-id="<?php echo $this->prospect_id; ?>" doctype="prospect"><i class="fa fa-trash-o"></i> <?php echo freetext('delete'); ?>
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
                  <form method="post" action="<?php echo site_url('__ps_quotation/upload_file_prospect');?>" enctype="multipart/form-data" />                  
                  <div class="col-sm-10 no-padd">
                     <input readonly type="hidden" name="is_importance" id="is_importance" value="1" />
                     <input readonly type="hidden" name="prospect_id" value="<?php echo $this->prospect_id; ?>" />
                     <input type="file"  name="image"  class="filestyle" data-icon="false" data-classButton="btn btn-default col-sm-2 pull-left" data-classInput="pull-left h3 col-sm-10">                  
                  </div>
                  <div class="col-sm-2 ">
                     <!-- <a href="#" class="btn btn-s-md btn-info pull-left" id="upload_file"><i class="fa fa-upload h5"></i> <?php  //echo freetext('upload'); //Upload?></a>  -->
                     <!-- <input type="submit"  name="submit" id="submit" class="btn btn-s-md btn-info pull-left btn_upload_importance"   value="<?php  //echo freetext('upload'); //Upload?>" /> -->
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








 <!--################################ start : important docment ############################-->
<section class="panel panel-default ">               
     <div class="panel-heading" style="padding-bottom :24px;">
       <font class="font-bold h5"> <?php echo freetext('other_document'); ?></font>
       <!--  <div class="col-sm-1  pull-right no-padd">
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
                                  doc-id="<?php echo $this->prospect_id; ?>" doctype="prospect"><i class="fa fa-trash-o"></i> <?php echo freetext('delete'); //delete?></a>
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
                <form method="post" action="<?php echo site_url('__ps_quotation/upload_file_prospect');?>" enctype="multipart/form-data" />   
                  <div class="col-sm-10 no-padd">
                  <input type="hidden" readonly name="is_importance" id="is_importance" value="0" />
                  <input type="hidden" readonly name="prospect_id" value="<?php echo $this->prospect_id; ?>" />
                  <input type="file" name="image"  class="filestyle" data-icon="false" data-classButton="btn btn-default col-sm-2 pull-left" data-classInput="pull-left h3 col-sm-10">
                  </div>
                  <div class="col-sm-2 ">
                     <!-- <a href="#" class="btn btn-s-md btn-info pull-left"><i class="fa fa-upload h5"></i> <?php// echo freetext('upload'); //Upload?></a>  -->
                     <!-- <input type="submit"  name="submit" id="submit" class="btn btn-s-md btn-info pull-left btn_upload_other"   value="<?php  //echo freetext('upload'); //Upload?>" /> -->
                      <button disabled id="submit" class="btn btn-s-md btn-info pull-left btn_upload_other"  ><?php  echo freetext('upload'); //Upload?></button>
                  </div>
                </form>
              </div>              
              <!-- End : upload file -->

          </div> <!-- end : col12 -->                        
      </div><!--end : form-group -->
  </div><!--end : panel-body -->
</section>
 <!--################################ end : important docment ############################-->


