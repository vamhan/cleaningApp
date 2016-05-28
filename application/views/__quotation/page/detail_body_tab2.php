<!-- /////////////////////END :  building/////////////////// -->

<?php 
// == start : query job_type ====
  $data_quotation = $query_quotation->row_array();
   if(!empty($data_quotation)){      
       $job_type  = $data_quotation['job_type'];
       $industry  = $data_quotation['ship_to_industry'];
       $ship_to_id  = $data_quotation['ship_to_id'];
       //$industry ='Z001';
    }else{
       $job_type ='';
      $industry ='';
      $ship_to_id='';
    }
// == End : query job_type ====

 //=== START : GET BUILDING ============================================= 
    $count_building =0;
    $temp_get_building = $get_building_Byid->result_array();
    if(!empty($temp_get_building)){
      foreach($get_building_Byid->result_array() as $value_building){ 
       $count_building++;    
    }//foreach
  }//end if

  //echo "count_building :".$count_building;

  ////// get total area //////////////
   $total = 0;
   $temp_area = $get_area->row_array();
     if(!empty($temp_area)){ 
        foreach($get_area->result_array() as $value){ 
        $total = $total+$value['space'];   
      }
    }//end if
?>





<!-- stat : div tab2 empty -->
<div class="col-sm-12 no-padd div_tab2_empty" style="padding-top:30px;">
  <section class="panel panel-default">
    <header class="panel-heading bg-danger lt no-border">
      <div class="clearfix">
        <span class="pull-left thumb-sm tx-white"><i class="fa fa-warning fa-3x "></i></span>
        <div class="clear margin-left-medium " style="padding-left:25px;">
          <div class="h3 m-t-xs m-b-xs text-white">
            ผิดพลาด : กรุณาเพิ่มข้อมูลให้ครบถ้วน
           <!--  <i class="fa fa-circle text-white pull-right text-xs m-t-sm"></i> -->
          </div>
          <small class="text-muted h5">กรุณาเพิ่มข้อมูลตามด้านล่าง</small>
        </div>                
      </div>
    </header>
    <ul class="list-group no-radius alt">
      <li class="list-group-item" href="#">  
      <!--   <span class="badge bg-success">25</span> -->
        <i class="fa fa-circle icon-muted"></i> 
          <span class="h5 margin-left-medium">ไม่มีข้อมูล ลูกค้า -> ประเภทงาน</span>
      </li>
      <li class="list-group-item" href="#">
       <!--  <span class="badge bg-info">16</span> -->
        <i class="fa fa-circle icon-muted"></i> 
          <span class="h5 margin-left-medium">ไม่มีข้อมูล ลูกค้า -> ประเภทธุรกิจ</span>
      </li>
       <!--  <li class="list-group-item" href="#">
          <i class="fa fa-circle icon-muted"></i> 
            <span class="h5 margin-left-medium">Profile visits</span>
        </li> -->
    </ul>
  </section>

</div>
<!-- end : div tab2 empty -->


 
<div class="detail_body_tab2">

<form role="form" data-parsley-validate action="<?php echo site_url('__ps_quotation/update_quotation_area/'.$this->quotation_id.'/'.$ship_to_id) ?>" method="POST" id="form_clone"> 
<input type="hidden" name="job_type" id="job_type" class="form-control" value="<?php echo $job_type; ?>">
<input type="hidden" name="industry" id="industry" class="form-control" value="<?php echo $industry; ?>">
<input type="hidden" name="ship_to_id" id="ship_to_id" class="form-control" value="<?php echo $ship_to_id; ?>">
<input type="hidden" name="first_conut_building" id="first_conut_building" class="form-control" value="<?php echo 0;//echo $count_building?>">
<input type="hidden" name="count_add_building" id="count_add_building" class="form-control" value="<?php if($count_building==0){ echo 1; }else{ echo $count_building;} ?>">





<div class="div-building">

<!-- ////////////////////////////////////////////////// START GET DB //////////////////////////////////////////////////////////// -->

<?php 
if($count_building!=0){

//$temp_get_building = $get_building_Byid->result_array();
$temp_no_building =0;
if(!empty($temp_get_building)){
    foreach($get_building_Byid->result_array() as $value_building){ 
      $temp_no_building++;

      //$total = $total+$value['space'];         
        // echo '<br>==================== div no buiding : '. $temp_no_building.'===================';
        // echo '<br>biilding_title : '.$value_building['biilding_title'];
        // echo '<br>total_building : '.$value_building['total_building'];

?>


<section class="back-color-blue-w panel panel-default clonedInputBuilding"  id="clonedInputBuilding<?php echo $temp_no_building; ?>" >             
<div class="panel-body"> 
<div class="form-group">
      <!-- start : input group -->
      <div class="col-sm-12 no-padd">    

              <!-- start : input group -->
                <div class="col-md-8">
                  <div class="input-group m-b">
                    <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('building_title').'</font></div>'; ?></span>
                    <input data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>" type="text" autocomplete="off" class="form-control building_name"  name="building_<?php echo $temp_no_building; ?>"  value="<?php echo $value_building['biilding_title']; ?>">
                     <span class="input-group-btn">
                      <button class="btn btn-default delete-building" type="button"><i class="fa fa-trash-o h5"></i></button>
                    </span>
                  </div>
                </div> 
              <!-- end : input group -->

              <div class="col-md-4">
                 <div class="input-group m-b">                                                  
                     <span class="input-group-addon">
                      <div class="label-width-adon">
                        <font class="pull-left">
                        <?php  echo freetext('totol_of_building').' : '; ?>
                        </font>
                      </div>
                     </span> 
                     <input type="text" autocomplete="off" readonly name="total_of_building_<?php echo $temp_no_building; ?>" class="form-control total_of_building text-right" placeholder="" value="<?php echo $value_building['total_building']; ?>">
                     <span class="input-group-addon">(m2)</span>
                </div>
              </div>
        </div>
        <!-- end : input group -->




<?php

          //$temp_get_floor = $get_floor_Byid->result_array();
       $temp_get_floor_Byid= $get_floor_Byid->result_array();
       $temp_no_floor = 0;
       $count_floor =0;
       if(!empty($temp_get_floor_Byid)){              
              foreach($get_floor_Byid->result_array() as $value_floor){ 
                if($value_building['building_id']==$value_floor['building_id']){
                    $count_floor++;
                }//end if count floor
              }//end foreach count floor
              //echo '<br>*** count_floor : '.$count_floor.' ***';


?>
 <!--  ################### start : section-table-floor ################# -->          
      <div class="col-sm-12 section-table-floor">
         <input type="hidden" class="total_floor" name="<?php echo 'total_floor_bu_'.$temp_no_building ?>" value="<?php echo $count_floor; ?>"/>
<?php
              foreach($get_floor_Byid->result_array() as $value_floor){ 
                if($value_building['building_id']==$value_floor['building_id']){
                  $temp_no_floor++;
                    // echo '<br>=========== div no floor : '. $temp_no_floor.'============';                  
                    // echo '<br>floor_title : '.$value_floor['floor_title'];
                    // echo '<br>total_floor : '.$value_floor['total_floor'];

                      $count_area_row =0;
                      foreach($get_area->result_array() as $value_area){ 
                          if( $value_floor['floor_id'] == $value_area['floor_id']){
                              $count_area_row++;
                          }//end if count get_area
                        }//end foreach count get_area
                        //echo '<br>*** count_area_row : '.$count_area_row.' ***';
?>



               <section class="panel panel-default cloneFloor" id="cloneFloor<?php echo $temp_no_floor; ?>">
                <input type="hidden" class="total_area_tr" name="<?php echo "total_area_bu_".$temp_no_building."_fl_".$temp_no_floor; ?>" value="<?php echo $count_area_row+1; ?>"/>
                  <table  class=" table  area_table">
                      <thead>
                        <tr class="back-color-gray h5">                          
                          <th>                            
                          <?php echo freetext('floor_title').' : ';?>
                          <input data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>" type="text" autocomplete="off"  class="no-padd floor_name"  name="<?php echo'building_'.$temp_no_building.'_floor_'.$temp_no_floor ?>"  value="<?php echo $value_floor['floor_title']; ?>">                                              
                          </th>
                          <th><?php echo freetext('area_type');?></th>
                          <th><?php echo freetext('area_title');?></th>
                          <th><?php echo freetext('texture_area');?></th>
                          <th><?php echo freetext('space').' (m2)';?></th>
                          <?php if($job_type=='ZQT1'){ ?><th><?php echo freetext('clearing_frequency');?></th><?php }//end if ?>
                          <th class="tx-center">                               
                           <?php if($temp_no_floor!=1){ ?><button class="btn btn-default pull-right delete-floor" type="button"><i class="fa fa-trash-o h5"></i></button><?php }//end if ?>
                          </th>                          
                        </tr>
                      </thead>
                      <tbody>
                      <!-- ADD DATA area to floor-->

<?php


                     $temp_no_area = 0;
                     $totol_of_floor =0;                    
                     $temp_get_area_Byid= $get_area->result_array();
                     if(!empty($temp_get_area_Byid)){

                         

                         foreach($get_area->result_array() as $value_area){ 
                            if( $value_floor['floor_id'] == $value_area['floor_id']){
                                 $temp_no_area++;
                                 //echo '<br>==== div no area : '. $temp_no_area.'=====<br>';

                                  $area_title =  $value_area['area_title'];
                                  $industry_room_id =  $value_area['industry_room_id'];
                                  $industry_room_description =  $value_area['industry_room_description'];
                                  $texture_description =  $value_area['texture_description'];
                                  $texture_id =  $value_area['texture_id'];
                                  $clear_job_type_id =   $value_area['clear_job_type_id'];
                                  $area_space =  $value_area['space'];
                                  $area_frequency =  $value_area['frequency'];
                                  $is_on_clearjob =  $value_area['is_on_clearjob'];
                                  $ship_to_id =  $value_area['ship_to_id'];
                                  $totol_of_floor = $totol_of_floor+ $area_space;

                                   // echo "area_title : ".$area_title."<br>";
                                   // echo "industry_room_id : ".$industry_room_id."<br>";
                                   // echo "industry_room_description : ".$industry_room_description."<br>";
                                   // echo "texture_description : ".$texture_description."<br>";
                                   // echo "texture_id : ".$texture_id."<br>";
                                   // echo "clear_job_type_id : ".$clear_job_type_id."<br>";
                                   // echo "area_space : ".$area_space."<br>";
                                   // echo "area_frequency : ".$area_frequency."<br>";
                                   // echo "is_on_clearjob : ".$is_on_clearjob."<br>";
                                   // echo "ship_to_id : ".$ship_to_id."<br>";

?>


                <tr class="h5 count_<?php echo $temp_no_area; ?>">
                    <td></td>
                    
                    <td><?php echo $industry_room_description;?>
                      <input type="hidden" name="<?php echo 'area_'.$temp_no_area.'_cloneFloor'.$temp_no_floor.'_clonedInputBuilding'.$temp_no_building.'_'.'roomID'; ?>" value="<?php echo $industry_room_id ?>">
                      <input type="hidden" name="<?php echo 'area_'.$temp_no_area.'_cloneFloor'.$temp_no_floor.'_clonedInputBuilding'.$temp_no_building.'_'.'roomName'; ?>" value="<?php echo $industry_room_description ?>">
                    </td>

                    <td><?php if(!empty($area_title)){ echo $area_title; }else{ echo '-'; }?>
                      <input type="hidden" name="<?php echo 'area_'.$temp_no_area.'_cloneFloor'.$temp_no_floor.'_clonedInputBuilding'.$temp_no_building.'_'.'title'; ?>" value="<?php echo $area_title ?>">
                    </td>

                    <td><?php echo $texture_description;?>
                      <input type="hidden" name="<?php echo 'area_'.$temp_no_area.'_cloneFloor'.$temp_no_floor.'_clonedInputBuilding'.$temp_no_building.'_'.'textureID'; ?>" value="<?php echo $texture_id ?>">
                      <input type="hidden" name="<?php echo 'area_'.$temp_no_area.'_cloneFloor'.$temp_no_floor.'_clonedInputBuilding'.$temp_no_building.'_'.'textureName'; ?>" value="<?php echo $texture_description ?>">
                      <input type="hidden" name="<?php echo 'area_'.$temp_no_area.'_cloneFloor'.$temp_no_floor.'_clonedInputBuilding'.$temp_no_building.'_'.'clearJobID'; ?>" value="<?php echo $clear_job_type_id ?>">
                    </td>

                    <td><?php echo $area_space;?>
                      <input type="hidden" class="space" name="<?php echo 'area_'.$temp_no_area.'_cloneFloor'.$temp_no_floor.'_clonedInputBuilding'.$temp_no_building.'_'.'space'; ?>" value="<?php echo $area_space ?>">
                    </td>

                    <td>
                     <?php 
                     if($job_type=='ZQT1'){//check ZQT1
                      if($is_on_clearjob==1){ 
                      ?>
                        <span class="col-sm-6" style="padding-left:0px;"><input data-parsley-min ="1"  data-parsley-error-message="<?php echo freetext('required_min'); ?>" maxlength="2" type="text" autocomplete="off" onkeypress="return isInt(event)" name="<?php echo 'area_'.$temp_no_area.'_cloneFloor'.$temp_no_floor.'_clonedInputBuilding'.$temp_no_building.'_'.'frequency'; ?>" class="form-control no-padd" placeholder="clearing" value="<?php echo $area_frequency ?>">
                      </span>     
                   <?php }else{//end if check is_on_clearjob ?>
                   <span class="col-sm-6"  style="padding-left:0px;"><input data-parsley-min ="1"  data-parsley-error-message="<?php echo freetext('required_min'); ?>" maxlength="2" type="text" autocomplete="off" onkeypress="return isInt(event)" name="<?php echo 'area_'.$temp_no_area.'_cloneFloor'.$temp_no_floor.'_clonedInputBuilding'.$temp_no_building.'_'.'frequency'; ?>" class="form-control no-padd" placeholder="0" ></span>
                   <?php }//end else
                      }//end if check
                   ?>

                     <!--  <span><a href="#" class="btn btn-default edit_area_btn"><i class="fa fa-pencil"></i></a></span> -->
                      <span class="margin-left-small"><button type="button" onclick="SomeDeleteRowFunction(<?php echo $area_space; ?>,this);" class="btn btn-default delete-area"><i class="fa fa-trash-o"></i></button></span>
                   </td>                 
              </tr>




<?php

                            }//end if checkou floor
                          }//===== end : foreach area ========
                        }//end : empty area

?>

                    </tbody> 
                      <tfoot>
                        <tr>
                          <td></td>
                            <td>  
                              <select  class="form-control area_type" name="select_area" >
                                  <option selected='selected' value='0'>กรุณาเลือก</option>
                                    <?php 
                                        $temp_bapi_aera= $bapi_area->result_array();
                                        if(!empty($temp_bapi_aera)){
                                        foreach($bapi_area->result_array() as $value){ 
                                          if($industry == $value['industry_id']){
                                     ?>
                                         <option  value='<?php echo $value['id'] ?>'><?php echo $value['title'] ?></option> 
                                    <?php 
                                          }//end if
                                        }//end foreach
                                       }else{ ?>
                                         <option value='0'>ไม่มีข้อมูล</option> 
                                    <?php } ?>
                               </select>
                               <input type='hidden' readonly name="industry_room_description" class='form-control industry_room_description'/>
                               <span class="tx-red mag_area"></span>
                            </td>
                            <td>
                              <input type='text' class='form-control area_title' placeholder='<?php echo freetext('area_title'); ?>'/>
                              <span class="tx-red mag_area_title"></span>
                            </td>                    
                           <td>  
                             <select  class="form-control select_texture" name="select_texture" >
                                  <option selected='selected' value='0'>กรุณาเลือก</option>
                                    <?php 
                                        $temp_bapi_texture= $bapi_texture->result_array();
                                        if(!empty($temp_bapi_texture)){
                                        foreach($bapi_texture->result_array() as $value){ 
                                          if(!empty($value['clear_type_id'])){
                                     ?>
                                         <option  value='<?php echo $value['material_no'] ?>'><?php echo $value['material_description']; //echo ' |'.$value['clear_type_id']; ?></option> 
                                    <?php 
                                          }//end if
                                        }//end foreach
                                       }else{ ?>
                                         <option value='0'>ไม่มีข้อมูล</option> 
                                    <?php } ?>
                               </select>
                               <input type='hidden' readonly name="texture_description" class='form-control texture_description'/>
                               <input type='hidden' readonly name="clear_job_type_id" class='form-control clear_job_type_id'/>
                               <span class="tx-red mag_texture"></span>
                            </td>                            
                            <td>
                              <input type='text' class='form-control area_space' onkeypress="return isNumberKey(event)" placeholder='<?php echo freetext('space'); ?>'/>
                              <span class="tx-red mag_space"></span>
                            </td>
                          <td>
                            <button type="button"  class="btn btn-info pull-right add-area"><i class="fa fa-plus"></i> <?php echo freetext('add_area'); ?></button>
                          </td>
                        </tr>
                        </tfoot>
                  </table>

                   <div class="panel-body">                  
                       <div class=" padd-all-small input-group m-b col-sm-3  pull-right">                                                  
                         <span class="input-group-addon">
                          <font class="pull-left"><?php echo freetext('total_of_floor'); ?></font>
                         </span> 
                         <input type="text" autocomplete="off" readonly name="<?php echo "total_of_floor_".$temp_no_floor."_".$temp_no_building;?>" class="form-control total_of_floor text-right" placeholder="" value="<?php echo $totol_of_floor; ?>">                       
                         <span class="input-group-addon">(m2)</span>
                      </div>                  
                  </div>

              </section> 


<?php

                }//end if checkout buiding id                
              }//====== end : foreach floor ========== 
?>

</div><!-- ################### end : section-table-floor #################  -->

<?php
            }//==== end if  empty floor=======
?>


<!--  ################### end : section-table-floor ################# -->

  <!-- form submit add floor -->
      <div class="form-group col-sm-12 no-padd">      
         <div class="col-sm-12">
             <button type="button" class="btn btn-info h5 pull-right add-floor">
                <i class="fa fa-plus-circle"></i> 
                <?php  echo freetext('ADD'); ?>
                <span class="help-block m-b-none"><?php  echo freetext('floor'); ?></span>
              </button>
         </div>
      </div>
      <!-- end : form submit add floor-->

</div><!-- end : panel-body -->
</div><!-- end : form group -->
</section><!-- /////////////////////END :  building/////////////////// -->


<?php
     }//====== end : foreach building ========== 
}//== end: if empty ===

}//check count building
?>

<!-- ////////////////////////////////////////////////// END GET DB ///////////////////////////// -->




<?php if($count_building==0){ ?>
<section class="back-color-blue-w panel panel-default clonedInputBuilding"  id="clonedInputBuilding1" >             
<div class="panel-body"> 
	<div class="form-group">
			<!-- start : input group -->
          <div class="col-sm-12 no-padd">      

	  		 <!-- start : input group -->
                <div class="col-md-8">
                  <div class="input-group m-b">
                    <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('building_title').'</font></div>'; ?></span>
                    <input data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>" type="text" autocomplete="off" class="form-control building_name"  name="building_1" >
                     <span class="input-group-btn">
                      <button class="btn btn-default delete-building" type="button"><i class="fa fa-trash-o h5"></i></button>
                    </span>
                  </div>
                </div> 
              <!-- end : input group -->

              <div class="col-md-4">
                 <div class="input-group m-b">                                                  
                     <span class="input-group-addon">
                      <div class="label-width-adon">
                        <font class="pull-left">
                        <?php  echo freetext('totol_of_building').' : '; ?>
                        </font>
                      </div>
                     </span> 
                     <input type="text" autocomplete="off" readonly name="total_of_building_1" class="form-control total_of_building text-right" placeholder="" value="0">
                      <span class="input-group-addon">(m2)</span>
                </div>
              </div>
          </div>
   <!-- end : input group -->
        <!--  ################### start : section-table-floor ################# -->
          <div class="col-sm-12 section-table-floor">
          		<input type="hidden" class="total_floor" name="total_floor_bu_1" value="1"/>
          		<section class="panel panel-default cloneFloor" id="cloneFloor1">
                <input type="hidden" class="total_area_tr" name="total_area_bu_1_fl_1" value="1"/>
                  <table  class="table  area_table">
                      <thead>
                        <tr class="back-color-gray h5">                        	
                          <th>                          	
                      		<?php echo freetext('floor_title').' : ';?>
                      		<input data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>" type="text" autocomplete="off" class="no-padd floor_name" name="building_1_floor_1"  placeholder=" ">                   	                       	 
                          </th>
                          <th><?php echo freetext('area_type');?></th>
                          <th><?php echo freetext('area_title');?></th>
                          <th><?php echo freetext('texture_area');?></th>
                          <th><?php echo freetext('space').' (m2)';?></th>
                          <?php if($job_type=='ZQT1'){ ?><th><?php echo freetext('clearing_frequency');?></th><?php }//end if ?>
                          <th class="tx-center">  
                           <!--  <button class="btn btn-default pull-right delete-floor" type="button"><i class="fa fa-trash-o h5"></i></button> -->
                          </th>                          
                        </tr>
                      </thead>
                      <tbody>
                                            
                      </tbody> 
                      <tfoot>
                        <tr>
                        	<td></td>
                            <td>                            
                               <select  class="form-control area_type" name="select_area" >
                                  <option seleted='seleted' value='0'>กรุณาเลือก</option>
                                    <?php 
                                        $temp_bapi_aera= $bapi_area->result_array();
                                        if(!empty($temp_bapi_aera)){
                                        foreach($bapi_area->result_array() as $value){ 
                                          if($industry == $value['industry_id']){
                                     ?>
                                         <option  value='<?php echo $value['id'] ?>'><?php echo $value['title'] ?></option> 
                                    <?php 
                                          }//end if
                                        }//end foreach
                                       }else{ ?>
                                         <option value='0'>ไม่มีข้อมูล</option> 
                                    <?php } ?>
                               </select>
                               <input type='hidden' readonly name="industry_room_description" class='form-control industry_room_description'/>
                              <span class="tx-red mag_area"></span>
                            </td>
                            <td>
                            	<input type='text' class='form-control area_title' placeholder='<?php echo freetext('area_title'); ?>'/>
                               <span class="tx-red mag_area_title"></span>
                            </td>                    
                           <td>   
                             <select  class="form-control select_texture" name="select_texture" >
                                  <option seleted='seleted' value='0'>กรุณาเลือก</option>
                                    <?php 
                                        $temp_bapi_texture= $bapi_texture->result_array();
                                        if(!empty($temp_bapi_texture)){
                                        foreach($bapi_texture->result_array() as $value){ 
                                           if(!empty($value['clear_type_id'])){
                                     ?>
                                         <option  value='<?php echo $value['material_no'] ?>'><?php echo $value['material_description'] ?></option> 
                                    <?php 
                                          }//end if
                                        }//end foreach
                                       }else{ ?>
                                         <option value='0'>ไม่มีข้อมูล</option> 
                                    <?php } ?>
                               </select>
                              <input type='hidden' readonly name="texture_description" class='form-control texture_description'/>
                              <input type='hidden' readonly name="clear_job_type_id" class='form-control clear_job_type_id'/>
                              <span class="tx-red mag_texture"></span>
                            </td>                            
                            <td>
                            	<input type='text' class='form-control area_space' onkeypress="return isNumberKey(event)" placeholder='<?php echo freetext('space'); ?>'/>
                               <span class="tx-red mag_space"></span>
                            </td>
                        	<td>
                        		<button type="button"  class="btn btn-info pull-right add-area"><i class="fa fa-plus"></i> <?php echo freetext('add_area'); ?></button>
                        	</td>
                        </tr>
	                    </tfoot>
                  </table>
                   <div class="panel-body">                  
                       <div class=" padd-all-small input-group m-b col-sm-3  pull-right">                                                  
                         <span class="input-group-addon">
                          <font class="pull-left"><?php echo freetext('total_of_floor'); ?></font>
                         </span> 
                         <input type="text" autocomplete="off" readonly name="total_of_floor_1_1" class="form-control total_of_floor text-right" placeholder=" " value="0">
                         <span class="input-group-addon">(m2)</span>
                      </div>                  
                  </div>

               </section> 
          </div> 
          <!--  ################### end : section-table-floor ################# -->

			<!-- form submit add floor -->
			<div class="form-group col-sm-12 no-padd">				
				 <div class="col-sm-12">
					   <button type="button" class="btn btn-info h5 pull-right add-floor">
					    	<i class="fa fa-plus-circle"></i> 
					    	<?php  echo freetext('ADD'); ?>
					    	<span class="help-block m-b-none"><?php  echo freetext('floor'); ?></span>
					    </button>
				 </div>
			</div>
			<!-- end : form submit add floor-->

	</div><!-- end : panel-body -->
</div><!-- end : form group -->
</section><!-- /////////////////////END :  building/////////////////// -->

<?php }//end count 0 ?>

</div>


<!-- form submit  add buliding-->
<div class="form-group col-sm-12 no-padd">
  <div class="pull-left col-sm-6">
    <span  class="btn btn-info h5 cloneButton1" >
    	<i class="fa fa-plus-circle"></i> 
    	<?php  echo freetext('ADD'); ?>
    	<span class="help-block m-b-none"><?php  echo freetext('building'); ?></span>
    </span>
  </div>
  <div class="col-sm-4 pull-right no-padd">
     <div class="input-group m-b">                                                  
         <span class="input-group-addon">
         	<font class="pull-left"><?php  echo freetext('total_space').' : '; ?></font>
         </span> 
         <input type="text" autocomplete="off" readonly name="total" id="total" class="form-control text-right"  value="<?php echo $total; ?>" >
         <span class="input-group-addon">(m2)</span>
    </div>              
  </div>
</div>
<!-- end : form submit  add buliding-->



<!-- form submit save-->
<div class="form-group col-sm-12 no-padd">
  <div class="pull-right">
    <button type="submit" class="btn btn-default"><?php echo freetext('cancel'); ?></button>
    <button type="submit" class="btn btn-primary margin-left-small"><?php echo freetext('Save_changes'); ?></button>
  </div>
</div>
<!-- end : form submit save -->

</form>


</div>





<!-- /////////////////////////////////////////////// CLONE BUILDING /////////////////////////////////////////////////////////////// -->


<section class="back-color-blue-w panel panel-default clonedInputBuilding hide"  id="clonedInputBuilding_0" >             
<div class="panel-body"> 
  <div class="form-group">
      <!-- start : input group -->
          <div class="col-sm-12 no-padd">      

         <!-- start : input group -->
                <div class="col-md-8">
                  <div class="input-group m-b">
                    <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('building_title').'</font></div>'; ?></span>
                    <input data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>" type="text" autocomplete="off" class="form-control building_name"  name="building"  >
                     <span class="input-group-btn">
                      <button class="btn btn-default delete-building" type="button"><i class="fa fa-trash-o h5"></i></button>
                    </span>
                  </div>
                </div> 
              <!-- end : input group -->

              <div class="col-md-4">
                 <div class="input-group m-b">                                                  
                     <span class="input-group-addon">
                      <div class="label-width-adon">
                        <font class="pull-left">
                        <?php  echo freetext('totol_of_building').' : '; ?>
                        </font>
                      </div>
                     </span> 
                     <input type="text" autocomplete="off" readonly name="total_of_building_0" class="form-control total_of_building text-right" placeholder="" value="0">
                     <span class="input-group-addon">(m2)</span>
                </div>
              </div>
          </div>
          <!-- end : input group -->
        <!--  ################### start : section-table-floor ################# -->          
          <div class="col-sm-12 section-table-floor">
             <input type="hidden" class="total_floor" name="total_floor" value="1"/>
              <section class="panel panel-default cloneFloor" id="cloneFloor1">
                <input type="hidden" class="total_area_tr" name="total_area_tr" value="1"/>
                  <table  class="table  area_table">
                      <thead>
                        <tr class="back-color-gray h5">                          
                          <th>                            
                          <?php echo freetext('floor_title').' : ';?>
                          <input data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>" type="text" autocomplete="off"  class="no-padd floor_name"  name="floor"  placeholder=" ">                                              
                          </th>
                          <th><?php echo freetext('area_type');?></th>
                          <th><?php echo freetext('area_title');?></th>
                          <th><?php echo freetext('texture_area');?></th>
                          <th><?php echo freetext('space').' (m2)';?></th>
                          <?php if($job_type=='ZQT1'){ ?><th><?php echo freetext('clearing_frequency');?></th><?php }//end if ?>
                          <th class="tx-center"> 
                           <!--  <button class="btn btn-default pull-right delete-floor" type="button"><i class="fa fa-trash-o h5"></i></button> -->
                          </th>                          
                        </tr>
                      </thead>
                      <tbody>
                          <!-- ADD DATA area to floor-->                       
                      </tbody> 
                      <tfoot>
                        <tr>
                          <td></td>
                            <td>
                              <select  class="form-control area_type" name="select_area" >
                                  <option selected='selected' value='0'>กรุณาเลือก</option>
                                    <?php 
                                        $temp_bapi_aera= $bapi_area->result_array();
                                        if(!empty($temp_bapi_aera)){
                                        foreach($bapi_area->result_array() as $value){ 
                                          if($industry == $value['industry_id']){
                                     ?>
                                         <option  value='<?php echo $value['id'] ?>'><?php echo $value['title'] ?></option> 
                                    <?php 
                                          }//end if
                                        }//end foreach
                                       }else{ ?>
                                         <option value='0'>ไม่มีข้อมูล</option> 
                                    <?php } ?>
                               </select>
                               <input type='hidden' readonly name="industry_room_description" class='form-control industry_room_description'/>
                                <span class="tx-red mag_area"></span>
                            </td>
                            <td>
                              <input type='text' class='form-control area_title' placeholder='<?php echo freetext('area_title'); ?>'/>
                               <span class="tx-red mag_area_title"></span>
                            </td>                    
                           <td>  
                             <select  class="form-control select_texture" name="select_texture" >
                                  <option selected='selected' value='0'>กรุณาเลือก</option>
                                    <?php 
                                        $temp_bapi_texture= $bapi_texture->result_array();
                                        if(!empty($temp_bapi_texture)){
                                        foreach($bapi_texture->result_array() as $value){ 
                                           if(!empty($value['clear_type_id'])){
                                     ?>
                                         <option  value='<?php echo $value['material_no'] ?>'><?php echo $value['material_description'] ?></option> 
                                    <?php 
                                          }//end if
                                        }//end foreach
                                       }else{ ?>
                                         <option value='0'>ไม่มีข้อมูล</option> 
                                    <?php } ?>
                               </select>
                               <input type='hidden' readonly name="texture_description" class='form-control texture_description'/>
                               <input type='hidden' readonly name="clear_job_type_id" class='form-control clear_job_type_id'/>
                                <span class="tx-red mag_texture"></span>
                            </td>                            
                            <td>
                              <input type='text' class='form-control area_space' onkeypress="return isNumberKey(event)" placeholder='<?php echo freetext('space'); ?>'/>
                               <span class="tx-red mag_space"></span>
                            </td>
                          <td>
                            <button type="button"  class="btn btn-info pull-right add-area"><i class="fa fa-plus"></i> <?php echo freetext('add_area'); ?></button>
                          </td>
                        </tr>
                      </tfoot>
                  </table>
                   <div class="panel-body">                  
                       <div class=" padd-all-small input-group m-b col-sm-3  pull-right">                                                  
                         <span class="input-group-addon">
                          <font class="pull-left"><?php echo freetext('total_of_floor'); ?></font>
                         </span> 
                         <input type="text" autocomplete="off" readonly name="total_of_floor_0_0" class="form-control total_of_floor text-right" placeholder=" " value="0">
                         <span class="input-group-addon">(m2)</span>
                      </div>                  
                  </div>
               </section> 
          </div> 
          <!--  ################### end : section-table-floor ################# -->

      <!-- form submit add floor -->
      <div class="form-group col-sm-12 no-padd">       
         <div class="col-sm-12">
             <button type="button" class="btn btn-info h5 pull-right add-floor">
                <i class="fa fa-plus-circle"></i> 
                <?php  echo freetext('ADD'); ?>
                <span class="help-block m-b-none"><?php  echo freetext('floor'); ?></span>
              </button>
         </div>
      </div>
      <!-- end : form submit add floor-->

  </div><!-- end : panel-body -->
</div><!-- end : form group -->
</section><!-- /////////////////////END :  building/////////////////// -->



<!-- /////////////////////////////////////////////// CLONE FLOOR /////////////////////////////////////////////////////////////// -->

 <section class="panel panel-default cloneFloor hide" id="cloneFloor0">
            <input type="hidden" class="total_area_tr" name="total_area_tr" value="1"/>
                  <table  class="table  area_table">
                      <thead>
                        <tr class="back-color-gray h5">                          
                          <th>                            
                          <?php echo freetext('floor_title').' : ';?>
                          <input data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>" type="text" autocomplete="off"  class="no-padd floor_name"  name="floor" placeholder=" ">                                              
                          </th>
                          <th><?php echo freetext('area_type');?></th>
                          <th><?php echo freetext('area_title');?></th>
                          <th><?php echo freetext('texture_area');?></th>
                          <th><?php echo freetext('space').' (m2)';?></th>
                          <?php if($job_type=='ZQT1'){ ?><th><?php echo freetext('clearing_frequency');?></th><?php }//end if ?>
                          <th class="tx-center">       
                            <button class="btn btn-default delete-floor pull-right" type="button"><i class="fa fa-trash-o h5"></i></button>
                          </th>                          
                        </tr>
                      </thead>
                      <tbody>
                          <!-- ADD DATA area to floor-->                      
                      </tbody> 
                      <tfoot>
                        <tr>
                          <td></td>
                            <td>                              
                               <select  class="form-control area_type" name="select_area" >
                                  <option selected='selected' value='0'>กรุณาเลือก</option>
                                    <?php 
                                        $temp_bapi_aera= $bapi_area->result_array();
                                        if(!empty($temp_bapi_aera)){
                                        foreach($bapi_area->result_array() as $value){ 
                                          if($industry == $value['industry_id']){
                                     ?>
                                         <option  value='<?php echo $value['id'] ?>'><?php echo $value['title'] ?></option> 
                                    <?php 
                                          }//end if
                                        }//end foreach
                                       }else{ ?>
                                         <option value='0'>ไม่มีข้อมูล</option> 
                                    <?php } ?>
                               </select>
                               <input type='hidden' readonly name="industry_room_description" class='form-control industry_room_description'/>
                               <span class="tx-red mag_area"></span>
                            </td>
                            <td>
                              <input type='text' class='form-control area_title' placeholder='<?php echo freetext('area_title'); ?>'/>
                              <span class="tx-red mag_area_title"></span>
                            </td>                    
                           <td>  
                               <select  class="form-control select_texture" name="select_texture" >
                                  <option selected='selected' value='0'>กรุณาเลือก</option>

                                    <?php 
                                        $temp_bapi_texture= $bapi_texture->result_array();
                                        if(!empty($temp_bapi_texture)){
                                        foreach($bapi_texture->result_array() as $value){ 
                                           if(!empty($value['clear_type_id'])){
                                     ?>
                                         <option  value='<?php echo $value['material_no'] ?>'><?php echo $value['material_description'] ?></option> 
                                    <?php 
                                          }//end if
                                        }//end foreach
                                       }else{ ?>
                                         <option value='0'>ไม่มีข้อมูล</option> 
                                    <?php } ?>
                               </select>
                               <input type='hidden' readonly name="texture_description" class='form-control texture_description'/>
                               <input type='hidden' readonly name="clear_job_type_id" class='form-control clear_job_type_id'/>
                               <span class="tx-red mag_texture"></span>
                            </td>                            
                            <td>
                              <input type='text' class='form-control area_space' onkeypress="return isNumberKey(event)" placeholder='<?php echo freetext('space'); ?>'/>
                               <span class="tx-red mag_space"></span>
                            </td>
                          <td>
                            <button type="button" class="btn btn-info pull-right add-area"><i class="fa fa-plus"></i> <?php echo freetext('add_area'); ?></button>
                          </td>
                        </tr>
                      </tfoot>
                  </table>
                   <div class="panel-body">                  
                       <div class=" padd-all-small input-group m-b col-sm-3  pull-right">                                                  
                         <span class="input-group-addon">
                          <font class="pull-left"><?php echo freetext('total_of_floor'); ?></font>
                         </span> 
                         <input type="text" autocomplete="off" readonly name="total_of_floor_0_0" class="form-control total_of_floor text-right" placeholder=" " value="0">
                         <span class="input-group-addon">(m2)</span>
                      </div>                  
                  </div>
               </section> 





<?php

// $temp_count_building =0;
// $floor =array();
// $floor_name = array();
// $total_floor = 0;
// print_r($building_name);//bu_id->bu_name
// foreach($building_name as $a => $a_value) {
//     $temp_count_building++;
//     echo "<br>############################# BUILDING ID :".$a." ######################## <br>";
//     echo "BU-ID =" . $a . ", BU-Value = ".$a_value. " no : " .$temp_count_building;

//          foreach($get_area->result_array() as $value){
//               if($value['building_id'] == $a){
//                 if (in_array( $value['floor_id'], $floor, TRUE)){                
//                     //echo "have";
//                 }else{
//                     //echo "nohave";
//                     array_push($floor,$value['floor_id']);
//                     $floor_name[$value['floor_id']] = $value['floor_title'];
//                 }   
//               }
//               $total_floor= count($floor);
//         }//end foreach floor

//       echo '<br> floor_id ||';
//       print_r($floor);
//       echo '<br> floor_name ||';
//       print_r($floor_name);      
//       echo '<br> floor_count ||';
//       echo $total_floor;


//        $temp_count_floor =0;
//       $area =array();
//       $area_name = array();
//       $total_Area_of_floor = 0;
//       foreach($floor_name as $b => $b_value) {
//        $temp_count_floor++;
//         echo "<br>============= floor ID :".$b." ============= <br>";
//         echo "f-ID =" . $b . ", f-Value = ".$b_value."| f-no : ".$temp_count_floor;

//               foreach($get_area->result_array() as $value){
//                   if($value['building_id'] == $a){
//                       if($value['floor_id'] == $b){
//                            if (in_array( $value['area_id'], $area, TRUE)){                
//                                 //echo "have";
//                             }else{
//                                 //echo "nohave";
//                                 array_push($area,$value['area_id']);
//                                 $area_name[$value['area_id']] = $value['area_title'];
//                             }   
                    
//                       }//end if
//                   }//end if
//                   $total_Area_of_floor= count($area);
//               }// end foreach floor

//                echo '<br> area ||';
//                print_r($area);
//                echo '<br> area_name ||';
//                print_r($area_name);
//                echo '<br>total_Area_of_floor ||';
//                print_r($total_Area_of_floor);

//                $temp_count_area =0;
//                foreach($area_name as $c => $c_value) {
//                 $temp_count_area++;
//                    foreach($get_area->result_array() as $value){
//                         if($value['area_id'] == $c){
//                             $area_title =  $value['area_title'];
//                             $industry_room_id =  $value['industry_room_id'];
//                             $industry_room_description =  $value['industry_room_description'];
//                             $texture_description =  $value['texture_description'];
//                             $texture_id =  $value['texture_id'];
//                             $area_pace =  $value['space'];
//                             $area_frequency =  $value['frequency'];
//                             $is_on_clearjob =  $value['is_on_clearjob'];
//                             $ship_to_id =  $value['ship_to_id'];
//                         }

//                    }//end data area 
              
//                    echo "<br>===== area ID :".$c."|no :".$temp_count_area." ===== <br>";
//                    echo "area_title : ".$area_title."<br>";
//                    echo "industry_room_id : ".$industry_room_id."<br>";
//                    echo "industry_room_description : ".$industry_room_description."<br>";
//                    echo "texture_description : ".$texture_description."<br>";
//                    echo "texture_id : ".$texture_id."<br>";
//                    echo "area_pace : ".$area_pace."<br>";
//                    echo "area_frequency : ".$area_frequency."<br>";
//                    echo "is_on_clearjob : ".$is_on_clearjob."<br>";
//                    echo "ship_to_id : ".$ship_to_id."<br>";

//               }//end  area 




//              //TODO:: set area and area_name
//              $area =  array();
//              $area_name =  array(); 
//              $total_Area_of_floor = 0; 

//       }//end foreach floor_name
      
     
//     //TODO : set floor and floor name
//       $floor =  array();
//       $floor_name =  array();      
// }//end foreach building

?>