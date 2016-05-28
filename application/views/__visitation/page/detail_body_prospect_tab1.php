
<section>  
<form role="form" data-parsley-validate action="<?php echo site_url('__ps_quotation/update_prospect/'.$this->prospect_id) ?>" method="POST"> 
<div class="panel-body"> 
 <?php 

     //====start : get data prospect ship_to  =========
     $data_prospect = $query_prospect->row_array();    

     if(!empty($data_prospect)){
         $sold_to_name1     =$data_prospect['sold_to_name1'];      
         $sold_to_name2     =$data_prospect['sold_to_name2'];
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
      }
      else{ 
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
      }

    //====end : get data prospect ship_to =========

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
<section class="panel panel-default ">    
     <div class="panel-heading" style="padding-bottom :24px;">
       <font class="font-bold"> <?php echo freetext('customer'); ?></font>       
        <div class="col-md-4  pull-right no-padd">
           <div class="input-group m-b">
             <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('account_group').'</font></div>'; ?></span>
              <select readonly name='job_type' class='form-control' >
                   <option <?php if($job_type == 'ZQT1' ){ echo  "selected='selected'"; } ?> value='ZQT1'><?php echo freetext('ZQT1'); //No have serial code?>  </option>
                   <option <?php if($job_type == 'ZQT2' ){ echo  "selected='selected'"; } ?> value='ZQT2'><?php echo freetext('ZQT2'); //No have serial code?>  </option> 
                   <option <?php if($job_type == 'ZQT3' ){ echo  "selected='selected'"; } ?> value='ZQT3'><?php echo freetext('ZQT3'); //No have serial code?>  </option>  
              </select>
          </div>
        </div>  
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
                      <input type="text" autocomplete="off" name="time" class="form-control"  maxlength="4" value="<?php  if(!empty($time) || $time!=0 ){ echo $time; } ?>"  data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>">
                    </div>
                  </div>
                  <div class="col-md-5">
                      <select  name='unit_time' class='form-control' >                       
                        <option value="day"  <?php if($unit_time=='day'){ echo "selected='selected'"; }  ?>  >day</option>
                        <option value="month"  <?php if($unit_time=='month'){ echo "selected='selected'"; }  ?> >month</option>                     
                      </select>
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
                           <option  value='1' >option1</option>
                           <option  value='2' >option2</option> 
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
                        <select  name='competitor_id' class='form-control selected_compectitor' >
                           <option <?php if($competitor==1) { echo "selected='selected'"; } ?> value='1' >option1</option>
                           <option <?php if($competitor==2) { echo "selected='selected'"; } ?> value='2' >option2</option>  
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

            <!--########################### Start :div detail customer ############################-->
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
                  <!-- start :body detail customer -->
                  <div class="panel-body">


                    <div class="col-sm-12 add-all-medium">
                      <!-- start : input group -->
                        <div class="col-md-12">
                          <div class="input-group m-b">
                            <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_name1').'</font></div>'; ?></span>
                            <input type="text" autocomplete="off" class="form-control"  name="sold_to_name1"  value="<?php echo $data_prospect['sold_to_name1']; ?>"  data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>">
                           <!--   <span class="input-group-btn">
                              <button class="btn btn-default" type="button"><i class="fa fa-th"></i></button>
                            </span> -->
                          </div>
                        </div> 
                      <!-- end : input group -->

                      <!-- start : input group -->
                          <div class="col-md-12 ">
                            <div class="input-group m-b">
                               <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_name2').'</font></div>'; ?></span>
                              <input type="text" autocomplete="off" class="form-control" name="sold_to_name2" value="<?php echo $data_prospect['sold_to_name2']; ?>">  
                            </div>
                          </div>  
                    <!-- end : input group -->

                    <!-- start : input group -->
                          <div class="col-md-12 ">
                            <div class="input-group m-b">
                               <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_address1').'</font></div>'; ?></span>
                              <input type="text" autocomplete="off" class="form-control"  name="sold_to_address1" value="<?php echo $data_prospect['sold_to_address1']; ?>">  
                            </div>
                          </div> 
                    <!-- end : input group -->

                    <!-- start : input group -->
                          <div class="col-md-12 ">
                            <div class="input-group m-b">
                              <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_address2').'</font></div>'; ?></span>
                              <input type="text" autocomplete="off" class="form-control"  name="sold_to_address2" value="<?php echo $data_prospect['sold_to_address2']; ?>">  
                            </div>
                          </div> 
                    <!-- end : input group -->   

                    <!-- start : input group -->
                           <div class="col-md-12 ">
                            <div class="input-group m-b">
                               <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_address3').'</font></div>'; ?></span>
                              <input type="text" autocomplete="off" class="form-control"  name="sold_to_address3" value="<?php echo $data_prospect['sold_to_address3']; ?>">  
                            </div>
                          </div> 
                    <!-- end : input group -->

                      <!-- start : input group -->
                           <div class="col-md-12 ">
                            <div class="input-group m-b">
                               <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_address4').'</font></div>'; ?></span>
                              <input type="text" autocomplete="off" class="form-control"  name="sold_to_address4" value="<?php echo $data_prospect['sold_to_address4']; ?>">  
                            </div>
                          </div> 
                    <!-- end : input group -->

                     <!-- start : input group -->
                           <div class="col-md-12 ">
                            <div class="input-group m-b">
                               <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_district').'</font></div>'; ?></span>
                              <input type="text" autocomplete="off" class="form-control"  name="sold_to_district" value="<?php echo $data_prospect['sold_to_district']; ?>">  
                            </div>
                          </div> 
                    <!-- end : input group -->


                    <!-- start : input group -->  
                          <div class="col-sm-12 no-padd"> 

                               <div class="col-md-6">
                                 <div class="input-group m-b">
                                   <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_country').'</font></div>'; ?></span>
                                    <select  name='sold_to_country' class='form-control' >
                                      <?php 
                                          $temp_bapi_country = $bapi_country->result_array();
                                          if(!empty($temp_bapi_country)){
                                          foreach($bapi_country->result_array() as $value){ 
                                       ?>
                                           <option  <?php if($sold_to_country==$value['id'] ){ echo 'selected="selected"';  } ?>  value='<?php echo $value['id'] ?>'><?php echo $value['title'] ?></option> 
                                      <?php }//end foreach
                                         }else{ ?>
                                           <option value='0'>ไม่มีข้อมูล</option> 
                                      <?php } ?>
                                    </select>
                                  </div>
                              </div>                     

                              <div class="col-md-6">
                                 <div class="input-group m-b">
                                   <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_region').'</font></div>'; ?></span>
                                    <select  name='sold_to_region' class='form-control' >
                                      <?php 
                                          $temp_bapi_region = $bapi_region->result_array();
                                          if(!empty($temp_bapi_region)){
                                          foreach($bapi_region->result_array() as $value){ 
                                       ?>
                                           <option  <?php if($sold_to_region==$value['id'] ){ echo 'selected="selected"';  } ?> value='<?php echo $value['id'] ?>'><?php echo $value['title'] ?></option> 
                                      <?php }//end foreach
                                         }else{ ?>
                                           <option value='0'>ไม่มีข้อมูล</option> 
                                      <?php } ?>
                                    </select>
                                </div>
                              </div>

                          </div> 
                    <!-- end : input group -->      


                     <!-- start : input group -->  
                          <div class="col-sm-12 no-padd"> 
                               <div class="col-md-6">
                                 <div class="input-group m-b">                                                  
                                    <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_city').'</font></div>'; ?></span>
                                    <input type="text" autocomplete="off" name="sold_to_city" class="form-control"   value="<?php echo $sold_to_city; ?>" data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>">                               
                                </div>
                              </div>                      

                              <div class="col-md-6">
                                 <div class="input-group m-b">
                                   <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_postal_code').'</font></div>'; ?></span>
                                  <input type="text" autocomplete="off" name="sold_to_postal_code" class="form-control"   value="<?php echo $data_prospect['sold_to_postal_code']; ?>" data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>">
                                </div>
                              </div>
                          </div> 
                    <!-- end : input group --> 

                    
                     <!-- start : input group -->
                          <div class="col-sm-12 no-padd"> 

                               <div class="col-md-6">
                                 <div class="input-group m-b">                                                  
                                     <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_industry').'</font></div>'; ?></span>
                                     <select  name='sold_to_industry' class='form-control' >
                                      <?php 
                                          $temp_bapi_industry = $bapi_industry->result_array();
                                          if(!empty($temp_bapi_industry)){
                                          foreach($bapi_industry->result_array() as $value){ 
                                       ?>
                                           <option  <?php if($sold_to_industry==$value['id'] ){ echo 'selected="selected"';  } ?> value='<?php echo $value['id'] ?>'><?php echo $value['title'] ?></option> 
                                      <?php }//end foreach
                                         }else{ ?>
                                           <option value='0'>ไม่มีข้อมูล</option> 
                                      <?php } ?>
                                    </select>
                                </div>
                              </div>

                               <div class="col-md-6">
                                 <div class="input-group m-b">                                                  
                                      <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_business_scale').'</font></div>'; ?></span>
                                   
                                      <select  name='sold_to_business_scale' class='form-control' >
                                      <?php 
                                          $temp_bapi_business_scale = $bapi_business_scale->result_array();
                                          if(!empty($temp_bapi_business_scale)){
                                          foreach($bapi_business_scale->result_array() as $value){ 
                                       ?>
                                           <option  <?php if($sold_to_business_scale==$value['id'] ){ echo 'selected="selected"';  } ?> value='<?php echo $value['id'] ?>'><?php echo $value['title'] ?></option> 
                                      <?php }//end foreach
                                         }else{ ?>
                                           <option value='0'>ไม่มีข้อมูล</option> 
                                      <?php } ?>
                                    </select>

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
                                   <input type="text" autocomplete="off" maxlength="10" onkeypress="return isNumberKey(event)" name="sold_to_tel" class="form-control"  value="<?php echo $sold_to_tel  ; ?>" data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>">
                                </div>
                              </div>

                               <div class="col-sm-5" style="padding-right:0px;">
                                 <div class="input-group m-b">
                                  <span class="input-group-addon"><?php echo '<font class="pull-left">'.freetext('sold_to_tel_ext').'</font>'; ?></span>
                                  <input type="text" autocomplete="off" maxlength="3" onkeypress="return isNumberKey(event)" name="sold_to_tel_ext" class="form-control" value="<?php echo $sold_to_tel_ext; ?>" >
                                </div>
                              </div>
                            </div>


                            <div class="col-md-6 ">
                              <div class="col-sm-7 no-padd">
                                 <div class="input-group m-b">
                                   <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_fax').'</font></div>'; ?></span>
                                   <input type="text" autocomplete="off" maxlength="10" onkeypress="return isNumberKey(event)"  name="sold_to_fax" class="form-control"  value="<?php echo $sold_to_fax; ?>" data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>">
                                </div>
                              </div>

                               <div class="col-sm-5" style="padding-right:0px;">
                                 <div class="input-group m-b">
                                  <span class="input-group-addon"><?php echo '<font class="pull-left">'.freetext('sold_to_fax_ext').'</font>'; ?></span>
                                  <input type="text" autocomplete="off" maxlength="3" onkeypress="return isNumberKey(event)" name="sold_to_fax_ext" class="form-control" value="<?php echo $sold_to_fax_ext; ?>" >
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
                                  <input type="text" autocomplete="off"  maxlength="10" onkeypress="return isNumberKey(event)" name="sold_to_mobile" class="form-control"  value="<?php echo $data_prospect['sold_to_mobile']; ?>" data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>">
                                </div>
                              </div>                     

                              <div class="col-md-6">
                                 <div class="input-group m-b">
                                   <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('sold_to_email').'</font></div>'; ?></span>
                                  <input type="text" autocomplete="off" name="sold_to_email" class="form-control"   value="<?php echo $data_prospect['sold_to_email']; ?>"  data-parsley-required="true"  data-parsley-type="email">
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
       <font class="font-bold"> <?php echo freetext('contract_person'); ?></font>        
    </div>
    <div class="panel-body"> 
      <div class="form-group">
        <div class="col-sm-12 add-all-medium">
          <div class="col-sm-12" id="other">
         <!--==================== end : table ============--> 
              <input type="hidden" name="first_conut_other" id="first_conut_other" class="form-control" value="0">
              <input type="hidden" name="count_other_contract" id="count_other_contract" class="form-control" value="0">
              <table  class="table  m-b-none table_other_contracts" >               
                <thead>
                  <tr class="back-color-gray">
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
                          <td><?php echo $value['firstname'];?></td>
                          <td><?php echo $value['lastname'];?></td>
                          <td><?php echo $value['function'];?></td>
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
    <button type="submit" class="btn btn-default">Cancel</button>
    <button type="submit" class="btn btn-primary  btn_save_changes margin-left-small">Save changes</button>
  </div>
</div>
<!-- end : form submit -->


</form>
</div>
</section>



<!--################################ start : important docment ############################-->
<section class="panel panel-default ">               
     <div class="panel-heading" style="padding-bottom :24px;">
       <font class="font-bold"> <?php echo freetext('importance'); ?></font>
        <div class="col-sm-1  pull-right no-padd">
            <select  name='month' class='form-control' >
                 <option value='0'>all</option> 
            </select>
        </div>  
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
                     <input type="submit"  name="submit" id="submit" class="btn btn-s-md btn-info pull-left btn_upload_importance"   value="<?php  echo freetext('upload'); //Upload?>" />
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
       <font class="font-bold"> <?php echo freetext('other_document'); ?></font>
        <div class="col-sm-1  pull-right no-padd">
            <select  name='month' class='form-control' >
                 <option value='0'>all</option> 
            </select>
        </div>  
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
                     <input type="submit"  name="submit" id="submit" class="btn btn-s-md btn-info pull-left btn_upload_other"   value="<?php  echo freetext('upload'); //Upload?>" />
                  </div>
                </form>
              </div>              
              <!-- End : upload file -->

          </div> <!-- end : col12 -->                        
      </div><!--end : form-group -->
  </div><!--end : panel-body -->
</section>
 <!--################################ end : important docment ############################-->


