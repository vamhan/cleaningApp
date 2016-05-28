<?php


     $count_building = '';
     $total = 0;
     $building = array();// buiding id for qt
     $building_name = array();
     
     $count_array_buildeing = 0;
     $temp_area = $get_area->row_array();
     if(!empty($temp_area)){   

       foreach($get_area->result_array() as $value){ 
        $total = $total+$value['space'];         
          if (in_array( $value['building_id'], $building, TRUE)){                
                //echo "have";
            }else{
                //echo "nohave";
                array_push($building,$value['building_id']);
                $building_name[$value['building_id']] = $value['building_title'];
            }   

       }//end foreach

        $count_array_buildeing = count($building);
       // $count_array_buildeing = $count_array_buildeing-1;
        //echo  'conun_array_buildeing : '.$count_array_buildeing;
        //==== count building======
        if($count_array_buildeing != 0){
            $count_building = $count_array_buildeing;
        }else{
             $count_building = 0;
        }

      }else{

          $count_building = 0;
      }

   //echo $count_building;
//=== END : GET BUILDING =============================================


// print_r($building);
// $arrlength_buiding = count($building);
// for($x = 0; $x < $arrlength_buiding; $x++) {
//     echo $building[$x];
//     echo "<br><br><br>";
// }















$temp_count_building =0;
$floor =array();
$floor_name = array();
$total_floor = 0;
//print_r($building_name);//bu_id->bu_name
foreach($building_name as $a => $a_value) {
    $temp_count_building++;
    //echo "<br>############################# BUILDING ID :".$a." ######################## <br>";
    //echo "BU-ID =" . $a . ", BU-Value = ".$a_value. "| bu-no : " .$temp_count_building;


      $total_of_building = 0;//set total_of_building
      foreach($get_area->result_array() as $value){ 
        if($a == $value['building_id']){
            $total_of_building =  $total_of_building + $value['space'];
        }
      }//end foreach
?>

<section class="back-color-blue-w panel panel-default clonedInputBuilding"  id="clonedInputBuilding<?php echo $temp_count_building; ?>" >             
<div class="panel-body"> 
<div class="form-group">
      <!-- start : input group -->
      <div class="col-sm-12 no-padd">    

              <!-- start : input group -->
                <div class="col-md-8">
                  <div class="input-group m-b">
                    <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('building_title').'</font></div>'; ?></span>
                    <input data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>" type="text" autocomplete="off" class="form-control building_name"  name="building_<?php echo $temp_count_building; ?>"  value="<?php echo $a_value; ?>">
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
                     <input type="text" autocomplete="off" readonly name="total_of_building_<?php echo $temp_count_building; ?>" class="form-control total_of_building" placeholder="" value="<?php echo $total_of_building; ?>">
                     <span class="input-group-addon">(m2)</span>
                </div>
              </div>
        </div>
        <!-- end : input group -->


<?php
        foreach($get_area->result_array() as $value){
              if($value['building_id'] == $a){
                if (in_array( $value['floor_id'], $floor, TRUE)){                
                    //echo "have";
                }else{
                    //echo "nohave";
                    array_push($floor,$value['floor_id']);
                    $floor_name[$value['floor_id']] = $value['floor_title'];
                }   
              }
              $total_floor= count($floor);
        }//end foreach floor
      // echo '<br> floor_id ||';
      // print_r($floor);
      // echo '<br> floor_name ||';
      // print_r($floor_name);      
      // echo '<br> total_floor ||';
      // echo $total_floor;


?>
  <!--  ################### start : section-table-floor ################# -->          
      <div class="col-sm-12 section-table-floor">
         <input type="hidden" class="total_floor" name="<?php echo 'total_floor_bu_'.$temp_count_building ?>" value="<?php echo $total_floor; ?>"/>


<?php
      $temp_count_floor =0;
      $area =array();
      $area_name = array();
      $total_Area_of_floor = 0;
      foreach($floor_name as $b => $b_value) {
        $temp_count_floor++;
        // echo "<br>============= floor ID :".$b." ============= <br>";
        // echo "f-ID =" . $b . ", f-Value = ".$b_value."| f-no : ".$temp_count_floor;
?>

 
<?php
              foreach($get_area->result_array() as $value){
                  if($value['building_id'] == $a){
                      if($value['floor_id'] == $b){
                           if (in_array( $value['area_id'], $area, TRUE)){                
                                //echo "have";
                            }else{
                                //echo "nohave";
                                array_push($area,$value['area_id']);
                                $area_name[$value['area_id']] = $value['area_title'];
                            }   
                    
                      }//end if
                  }//end if
                  $total_Area_of_floor= count($area);
              }// end foreach floor

               // echo '<br> area ||';
               // print_r($area);
               // echo '<br> area_name ||';
               // print_r($area_name);
               // echo '<br>total_Area_of_floor ||';
               // print_r($total_Area_of_floor);
?>

            <section class="panel panel-default cloneFloor" id="cloneFloor<?php echo $temp_count_floor; ?>">
                <input type="hidden" class="total_area_tr" name="<?php echo "total_area_bu_".$temp_count_building."_fl_".$temp_count_floor; ?>" value="<?php echo $total_Area_of_floor+1; ?>"/>
                  <table  class=" table  area_table">
                      <thead>
                        <tr class="back-color-gray">                          
                          <th>                            
                          <?php echo freetext('floor_title').' : ';?>
                          <input data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>" type="text" autocomplete="off"  class="no-padd floor_name"  name="<?php echo'building_'.$temp_count_building.'_floor_'.$temp_count_floor ?>"  value="<?php echo $b_value ?>">                                              
                          </th>
                          <th><?php echo freetext('area_type');?></th>
                          <th><?php echo freetext('area_title');?></th>
                          <th><?php echo freetext('texture');?></th>
                          <th><?php echo freetext('space').' (m2)';?></th>
                          <th class="tx-center">    
                            <button class="btn btn-default pull-right delete-floor" type="button"><i class="fa fa-trash-o h5"></i></button>
                          </th>                          
                        </tr>
                      </thead>
                      <tbody>
                      <!-- ADD DATA area to floor-->
<?php

               $temp_count_area =0;
               $totol_of_floor =0;
               foreach($area_name as $c => $c_value) {
                 $temp_count_area++;
                 
                   foreach($get_area->result_array() as $value){
                        if($value['area_id'] == $c){
                            $area_title =  $value['area_title'];
                            $industry_room_id =  $value['industry_room_id'];
                            $industry_room_description =  $value['industry_room_description'];
                            $texture_description =  $value['texture_description'];
                            $texture_id =  $value['texture_id'];
                            $clear_job_type_id =   $value['clear_job_type_id'];
                            $area_space =  $value['space'];
                            $area_frequency =  $value['frequency'];
                            $is_on_clearjob =  $value['is_on_clearjob'];
                            $ship_to_id =  $value['ship_to_id'];
                             $totol_of_floor = $totol_of_floor+ $area_space;
                        }


                   }//end data area 
              
                   // echo "<br>===== area ID :".$c."|no :".$temp_count_area." ===== <br>";
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
                <tr class="count_<?php echo $temp_count_area; ?>">
                    <td></td>
                    
                    <td><?php echo $industry_room_description;?>
                      <input type="hidden" name="<?php echo 'area_'.$temp_count_area.'_cloneFloor'.$temp_count_floor.'_clonedInputBuilding'.$temp_count_building.'_'.'roomID'; ?>" value="<?php echo $industry_room_id ?>">
                      <input type="hidden" name="<?php echo 'area_'.$temp_count_area.'_cloneFloor'.$temp_count_floor.'_clonedInputBuilding'.$temp_count_building.'_'.'roomName'; ?>" value="<?php echo $industry_room_description ?>">
                    </td>

                    <td><?php echo $area_title;?>
                      <input type="hidden" name="<?php echo 'area_'.$temp_count_area.'_cloneFloor'.$temp_count_floor.'_clonedInputBuilding'.$temp_count_building.'_'.'title'; ?>" value="<?php echo $area_title ?>">
                    </td>

                    <td><?php echo $texture_description;?>
                      <input type="hidden" name="<?php echo 'area_'.$temp_count_area.'_cloneFloor'.$temp_count_floor.'_clonedInputBuilding'.$temp_count_building.'_'.'textureID'; ?>" value="<?php echo $texture_id ?>">
                      <input type="hidden" name="<?php echo 'area_'.$temp_count_area.'_cloneFloor'.$temp_count_floor.'_clonedInputBuilding'.$temp_count_building.'_'.'textureName'; ?>" value="<?php echo $texture_description ?>">
                      <input type="hidden" name="<?php echo 'area_'.$temp_count_area.'_cloneFloor'.$temp_count_floor.'_clonedInputBuilding'.$temp_count_building.'_'.'clearJobID'; ?>" value="<?php echo $clear_job_type_id ?>">
                    </td>

                    <td><?php echo $area_space;?>
                      <input type="hidden" class="space" name="<?php echo 'area_'.$temp_count_area.'_cloneFloor'.$temp_count_floor.'_clonedInputBuilding'.$temp_count_building.'_'.'space'; ?>" value="<?php echo $area_space ?>">
                    </td>

                    <td>
                     <?php 
                     if($job_type=='ZQT1'){//check ZQT1
                      if($is_on_clearjob==1){ 
                      ?>
                        <span class="col-sm-6"><input maxlength="2" type="text" autocomplete="off" onkeypress="return isInt(event)" name="<?php echo 'area_'.$temp_count_area.'_cloneFloor'.$temp_count_floor.'_clonedInputBuilding'.$temp_count_building.'_'.'frequency'; ?>" class="form-control no-padd" placeholder="clearing" value="<?php echo $area_frequency ?>">
                      </span>     
                   <?php }else{//end if check is_on_clearjob ?>
                   <span class="col-sm-6"><input maxlength="2" type="text" autocomplete="off" onkeypress="return isInt(event)" name="<?php echo 'area_'.$temp_count_area.'_cloneFloor'.$temp_count_floor.'_clonedInputBuilding'.$temp_count_building.'_'.'frequency'; ?>" class="form-control no-padd" placeholder="0" ></span>
                   <?php }//end else
                      }//end if check
                   ?>

                     <!--  <span><a href="#" class="btn btn-default edit_area_btn"><i class="fa fa-pencil"></i></a></span> -->
                      <span class="margin-left-small"><button type="button" onclick="SomeDeleteRowFunction(<?php echo $area_space; ?>,this);" class="btn btn-default delete-area"><i class="fa fa-trash-o"></i></button></span>
                   </td>                 
                </tr>

<?php
            }//end foreach area 

           //TODO:: set area and area_name
           $area =  array();
           $area_name =  array(); 
           $total_Area_of_floor = 0; 
?>



    
                  </tbody> 
                      <tfoot>
                        <tr>
                          <td></td>
                            <td>  
                              <select  class="form-control area_type" name="select_area" >
                                  <option selected='selected' value='0'>กรุณาเลือกบริการ</option>
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
                                  <option selected='selected' value='0'>กรุณาเลือกบริการ</option>
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
                         <input type="text" autocomplete="off" readonly name="<?php echo "total_of_floor_".$temp_count_floor."_".$temp_count_building;?>" class="form-control total_of_floor" placeholder="" value="<?php echo $totol_of_floor; ?>">                       
                         <span class="input-group-addon">(m2)</span>
                      </div>                  
                  </div>

              </section> 



<?php
      }//end foreach floor_name   
     
    //TODO : set floor and floor name
     $floor =  array();
    $floor_name =  array(); 
?>

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

<?php
}//end foreach building
?>

