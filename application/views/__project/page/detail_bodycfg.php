<?php 
  // var_dump($detail);

$function_list = $this->session->userdata('function');

$is_other = false;
if (in_array('MK', $function_list) || in_array('CR', $function_list) || in_array('ST', $function_list) || in_array('OP', $function_list)|| in_array('IC', $function_list)|| in_array('WF', $function_list)|| in_array('IT', $function_list)|| in_array('AC', $function_list)|| in_array('FI', $function_list) ) {
  $is_other = true;
}


$is_customer = false;
if (in_array('MK', $function_list) || in_array('CR', $function_list) || in_array('AC', $function_list) || in_array('FI', $function_list) ) {
  $is_customer = true;
}


//print_r($function_list );

?>
          


          <section class="vbox">
            <section class="scrollable padder">  
              <!-- start : main-row -->          
              <div class="row">
                <div class="col-sm-12 padd-all-medium">
                  <span class="col-sm-8"><h3 class="h3 padd-all-medium"><?php echo '['.$detail['ship_to_id'].'] : '.$detail['title']; ?></h3></span>
                  <?php if($this->page_controller == '__ps_asset_track'){  // echo $this->page_controller; ?>
                  <span class="col-sm-4 padd-all-medium"><a href="<?php echo my_url('__ps_projects/listview'); ?>" class="btn btn-primary  btn-small pull-right">select project</a></span>
                  <?php } ?>

                  <!-- start : select project button -->
                  <span class="col-sm-4 padd-all-medium pull-right"><a href="<?php echo my_url('__ps_projects/listview'); ?>" target='_self' class="btn btn-primary  btn-small pull-right">
                  <i class='fa fa-archive'></i>
                  &nbsp;
                  เลือกโครงการ
                  </a></span>
                  <!-- end : select project button -->


                </div>
              </div>


              <div class="row padd-all-medium">
                  <!--########################### Start :div detail customer ############################-->
                  <div class="panel panel-default ">
                    <div class="panel-heading">
                      <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseCustomer" class="toggle_custotmer">
                          <?php echo freetext('customer'); //Customer?>  
                          <i class="icon_customer_down fa fa-caret-down text-active pull-right"></i><i class="icon_customer_up fa fa-caret-up text  pull-right"></i>      
                        </a> 
                      </h4>
                    </div>
                    <div id="collapseCustomer" class="panel-collapse in">
                      <!-- start :body detail customer -->
                      <div class="panel-body">


                        <div class="col-sm-12 add-all-medium">
                            <div class="row no-padd">
                              <div class="col-md-4 no-padd">
                                <div class="input-group m-b">
                                  <span class="input-group-addon"><?php echo "ระยะเวลาของโครงการ :"; //Start :?></span>
                                  <input type="text" autocomplete="off" class="form-control" value="<?php echo common_easyDateFormat($detail["project_start"]).'  ถึง  '.common_easyDateFormat($detail["project_end"]); ?>" readonly>                                 
                                </div>  
                              </div>

                              <div class="col-md-4">
                                 <div class="input-group m-b">
                                  <span class="input-group-addon"><?php echo freetext('contract')." :"; //Contract :?></span>
                                  <input type="text" autocomplete="off" class="form-control" value="<?php echo (array_key_exists('contract_id', $detail))?$detail["contract_id"]:"N/A"; ?>" readonly>
                                </div>
                              </div>

                              <div class="col-md-4 no-padd">
                                 <div class="input-group m-b">
                                  <span class="input-group-addon"><?php echo freetext('type')." :"; //Type :?></span>
                                  <?php 
                                    //determine job type
                                    $job_type = 'N/A';
                                    if(array_key_exists('job_type', $detail)){
                                      if(strtoupper($detail['job_type']) == 'ZQT1'){
                                        $job_type = 'งานประจำ';
                                      }else if(strtoupper($detail['job_type']) == 'ZQT2'){
                                        $job_type = 'งานจร';
                                      }else if(strtoupper($detail['job_type']) == 'ZQT3'){
                                        $job_type = 'งานประเคลียร์';
                                      }//end 
                                    }
                                   ?>
                                  <input type="text" autocomplete="off" class="form-control" value="<?php echo $job_type; ?>" readonly>
                                </div>
                              </div>
                            </div>
                        </div>



                       <!--  <div class="form-group col-sm-12 back-color-gray padd-all-medium round-small" >
                          <h3 class="h3"><?php //echo freetext('customer'); //Customer?></h3>  
                           <p class="h6 padd-all-small">
                            <?php //echo $detail["customer_name"]; ?>
                           </p>
                        </div>

                        <div class="form-group col-sm-12 back-color-gray padd-all-medium round-small" >
                          <h3 class="h3"><?php //echo freetext('site_name')." :"; //Site name :?></h3>  
                           <p class="h6 padd-all-small">
                            <?php //echo $detail["shop_to_title"]; ?>
                           </p>
                        </div> -->


                         <div class="form-group col-sm-12  no-padd" >

                          <div class="col-sm-6  pull-left no-padd" style="padding:0px 5px 0px 0px;" >                            
                            <div class="col-sm-12 back-color-gray  padd-all-medium round-small " style="height:100px;" >
                             <h3 class="h3"><?php echo freetext('customer'); //Customer?></h3>  
                             <p class="h6 padd-all-small">
                              <?php echo $detail["customer_name"]; ?>
                             </p>
                           </div>
                          </div>

                          <div class="col-sm-6 pull-right" style="padding:0px 0px 0px 5px;">                           
                            <div class="col-sm-12 back-color-gray  padd-all-medium round-small " style="height:100px;">
                             <h3 class="h3"><?php echo freetext('site_name')." :"; //Site name :?></h3>  
                             <p class="h6 padd-all-small">
                              <?php echo $detail["shop_to_title"]; ?>
                              <br><b>เขตการขาย :</b> <?php print $detail['ship_to_distribution_channel'];?>
                             </p>
                           </div>
                          </div>

                        </div>


                      </div>
                      <!-- end :body detail customer -->

                    </div>
                  </div>
          <!--################################ end :div detail customer ############################-->
            


  <!--########################### Start :div detail Contact ############################-->
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4 class="panel-title">
              <a data-toggle="collapse" data-parent="#accordion" href="#collapseContact"  class="toggle_person">
                <?php echo freetext('contact_person'); //Contact person?>             
               <i class="icon_person_down fa fa-caret-down text-active pull-right"></i><i class="icon_person_up fa fa-caret-up text  pull-right"></i>
              </a>  
            </h4>
          </div>
          <div id="collapseContact" class="panel-collapse in">
            <!-- start :body detail Contact -->
            <div class="panel-body">
              <div class="col-sm-12">
                <section class="panel panel-default" >
                  <form role="form"  data-parsley-validate action="<?php echo site_url('__ps_project/create_contact/'.$detail['id'] ) ?>" method="POST">
                  <table  class="table  m-b-none " >
                      <thead>
                        <tr class="back-color-gray">
                          <th><?php echo freetext('firstname').'-'.freetext('lastname'); //First Name?></th>
                         <!--  <th><?php //echo freetext('lastname'); //Last Name?></th> -->
                          <th><?php echo freetext('function'); //Function?></th>
                          <th><?php echo freetext('department');?></th>
                          <th><?php echo freetext('tel'); //Function?></th>
                          <th><?php echo freetext('tel_ext'); //Function?></th>
                          <th><?php echo freetext('fax'); //Function?></th>
                          <th><?php echo freetext('fax_ext'); //Function?></th> 
                          <th><?php echo freetext('mobile_phone'); //mobile phone?></th>
                          <th><?php echo freetext('email'); //mobile phone?></th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                      
                      <?php  
                      $conunt_contract = 0;                     
                      //GET SAP:: sap_tbm_contact
                      if(!empty($detail['ship_to_id']) ){
                        //echo "ship_to";              
                        $this->db->select('sap_tbm_contact.*');
                        $this->db->where('sap_tbm_contact.ship_to_id', $detail['ship_to_id']);
                        if(in_array('OP', $function_list) ){
                        $this->db->where('sap_tbm_contact.department', 'Z001');
                        }
                        $query_sap_tbm_contact= $this->db->get('sap_tbm_contact');
                        $temp_query_sap_tbm_contact = $query_sap_tbm_contact->row_array();
                        if(!empty($temp_query_sap_tbm_contact)){ 
                        foreach($query_sap_tbm_contact->result_array() as $value){ 
                          $conunt_contract++;       
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
                      }
                    ?>


                     <?php                       
                      //GET :: tbt_contact
                      if(!empty($detail['ship_to_id']) ){
                        //echo "ship_to";              
                        $this->db->select('tbt_contact.*');
                        $this->db->select('sap_tbm_department.title As department_des'); 
                        $this->db->select('sap_tbm_function.description As function_des'); 
                        $this->db->join('sap_tbm_department', 'sap_tbm_department.id = tbt_contact.department','left');
                        $this->db->join('sap_tbm_function', 'sap_tbm_function.id = tbt_contact.function','left');

                        $this->db->where('tbt_contact.quotation_id', $this->quotation_id);
                        if(in_array('OP', $function_list) ){
                        $this->db->where('tbt_contact.department', 'Z001');
                        }
                        $query_tbt_contact= $this->db->get('tbt_contact');
                        $temp_query_tbt_contact = $query_tbt_contact->row_array();
                        
                        if(!empty($temp_query_tbt_contact)){ 
                        foreach($query_tbt_contact->result_array() as $value){ 
                        $conunt_contract++;  
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
                          <td><?php echo $value['mobile_no'];?></td>
                          <td><?php echo $value['email'];?></td>
                          <td></td>
                        </tr>
                      <?php
                           
                          }//end foreach
                        }//end if                    
                      }
                      if($conunt_contract==0){
                          echo "<tr><td colspan='10'>ไม่มีข้อมูล</td></tr>";
                      }
                    ?>




                    <?php 
                    //old get datat contract
                       //  if(!empty($contact_list)){
                       //  foreach ($contact_list as $key => $value) {
                       //  $icon_main = '' ;
                       //  if( $value['is_main_contact']==1){ $icon_main ='<i class="fa fa-thumb-tack"></i>';}else{$icon_main =''; }    
                    ?>
                         <!--  <tr id="<?php //echo $value['id']; ?>">
                            <td><?php //echo $value['title'].''.$value['firstname'];?></td>
                            <td><?php //echo $value['lastname'];?></td>
                            <td><?php //echo $value['function_title'];?></td>
                            <td><?php //echo $value['department_title'];?></td>
                            <td><?php //echo $value['tel'];?></td>
                            <td><?php //echo $value['tel_ext'];?></td>
                            <td><?php //echo $value['fax'];?></td>
                            <td><?php //echo $value['fax_ext'];?></td>
                            <td><?php //echo $value['mobile_no'];?></td>
                            <td><?php //echo $value['email'];?></td>
                          </tr> -->
                    <?php
                    //   }//end foreach
                    // }//end empty 
                  ?>
                      </tbody>                   
                  </table>
                </form>
               </section> 
              </div>

            </div>
            <!-- end :body detail Contact -->

          </div>
        </div>
<!--################################ end :div detail Contact ############################-->


<?php if($is_customer == true){ ?>
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
                  <form method="post" action="<?php echo site_url('__ps_project/upload_file_quotation');?>" enctype="multipart/form-data" />                  
                  <div class="col-sm-10 no-padd">
                     <input readonly type="hidden" name="is_importance" id="is_importance" value="1" />
                     <input readonly type="hidden" name="quotation_id" value="<?php echo $this->quotation_id; ?>" />
                     <input type="file"  name="image"  class="filestyle" data-icon="false" data-classButton="btn btn-default col-sm-2 pull-left" data-classInput="pull-left h3 col-sm-10">                  
                  </div>
                  <div class="col-sm-2 ">
                     <!-- <a href="#" class="btn btn-s-md btn-info pull-left" id="upload_file"><i class="fa fa-upload h5"></i> <?php  //echo freetext('upload'); //Upload?></a>  -->
                    <!--  <input type="submit"  name="submit" id="submit" class="btn btn-s-md btn-info pull-left btn_upload_importance"   value="<?php  //echo freetext('upload'); //Upload?>" /> -->
                      <button  id="submit" class="btn btn-s-md btn-info pull-left btn_upload_importance" ><?php  echo freetext('upload'); //Upload?></button>
                  </div>
                </form>
              </div>              
              <!-- End : upload file -->

          </div> <!-- end : col12 -->                        
      </div><!--end : form-group -->
  </div><!--end : panel-body -->
</section>
 <!--################################ end : important docment ############################-->
 <?php } ?>

<?php if($is_other==true){ ?>
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
                <form method="post" action="<?php echo site_url('__ps_project/upload_file_quotation');?>" enctype="multipart/form-data" />   
                  <div class="col-sm-10 no-padd">
                  <input type="hidden" readonly name="is_importance" id="is_importance" value="0" />
                  <input type="hidden" readonly name="quotation_id" value="<?php echo $this->quotation_id; ?>" />
                  <input type="file" name="image"  class="filestyle" data-icon="false" data-classButton="btn btn-default col-sm-2 pull-left" data-classInput="pull-left h3 col-sm-10">
                  </div>
                  <div class="col-sm-2 ">
                     <!-- <a href="#" class="btn btn-s-md btn-info pull-left"><i class="fa fa-upload h5"></i> <?php// echo freetext('upload'); //Upload?></a>  -->
                    <!--  <input  type="submit"   name="submit" id="submit" class="btn btn-s-md btn-info pull-left btn_upload_other"   value="<?php  //echo freetext('upload'); //Upload?>" /> -->
                     <button  id="submit" class="btn btn-s-md btn-info pull-left btn_upload_other"><?php  echo freetext('upload'); //Upload?></button>
                  </div>
                </form>
              </div>              
              <!-- End : upload file -->

          </div> <!-- end : col12 -->                        
      </div><!--end : form-group -->
  </div><!--end : panel-body -->
</section>
 <!--################################ end : important docment ############################-->

<?php } ?>
 

          </section>
        </section>
          <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
        