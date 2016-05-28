<style type="text/css">
.dt_header{
display: none  !important;
}

.dt_footer .row-fluid{
display: none  !important;
}

</style>

<div class="div_detail" style="padding-left:50px;padding-right:50px;padding-bottom:50px;">
<h4 class="page-header font-bold tx-black"><i class="fa fa-leaf h5"></i> จำนวนคน/ตำแหน่ง</h4>


<!--///////////////////////////// START ::  GET  staff nomal ///////////////////////////////////// -->
<div class="col-sm-12">
<section class="panel panel-default">
  <header class="panel-heading font-bold h5">พนักงาน: งานประจำ</header>
  <table class="table table-striped m-b-none">

<?php
///////////////// GET : MAN GROUP //////////////////////
$daily_pay_rate_type='';
$level_staff = '';
$position = '';
$uniform = '';
$gender = '';
$count_row =0;

$this->db->select('tbt_man_group.*');
$this->db->where('quotation_id', $this->quotation_id);
$query_man = $this->db->get('tbt_man_group');
$group = $query_man->row_array();
if (!empty($group)) {
foreach($query_man->result_array() as $value_gr){ 
//echo $value_gr['total'].'<br>';
$count_row++;

//== get bapi_level_staff ==
$temp_bapi_level_staff= $bapi_level_staff->result_array();
if(!empty($temp_bapi_level_staff)){
foreach($bapi_level_staff->result_array() as $value_level){ 
if($value_gr['employee_level_id'] == $value_level['id'] ){    
    $level_staff = $value_level['description'];
}//end if
}//end foreach
}//end if


//== get temp_bapi_position ==
$temp_bapi_position= $bapi_position->result_array();
if(!empty($temp_bapi_position)){
foreach($bapi_position->result_array() as $value_position){ 
  if($value_gr['position'] == $value_position['id'] ){  
    $position = $value_position['title'];
  }//end if
}//end foreach
}//end if


//== get bapi_unifrom ==
$temp_bapi_uniform= $bapi_unifrom->result_array();
if(!empty($temp_bapi_uniform)){
foreach($bapi_unifrom->result_array() as $value_unifrom){
  if($value_gr['uniform_id'] == $value_unifrom['material_no'] ){  
   $uniform = $value_unifrom['material_description'];
  }//end if
}//end foreach
}//end if

?>

<thead>
  <tr>
    <th  width="600" class="tx-blue font-bold">จำนวนพนักงาน กลุ่มที่ : <?php echo $count_row; ?> </th>
    <th class="tx-blue font-bold"><?php echo $value_gr['total']?> คน</th>
  </tr>
</thead>
<tbody>
  <tr>                    
      <td><?php echo freetext('level_staff'); ?></td>
      <td><?php echo $level_staff; ?></td>
  </tr> 
  <tr>                    
      <td><?php echo freetext('position'); ?></td>
      <td><?php echo $position; ?></td>
  </tr>    
  <tr>                    
      <td><?php echo freetext('uniform'); ?></td>
      <td><?php echo $uniform; ?></td>
  </tr>        
</tbody>

<?php
  }//end foreach
}//end if

// todo : emty
if($count_row==0){

 echo "<tr><div class='h5' style='padding:10px;'>ไม่มีข้อมูล</div></tr>";

}//end if
?>

  </table>
</section>
</div>




<?php  

//START :check job_type clering ZQT1
if( $this->job_type == 'ZQT1'){ 
?>

<!--///////////////////////////// START ::  GET  staff clearing ///////////////////////////////////// -->
<div class="col-sm-12">
<section class="panel panel-default">
<header class="panel-heading font-bold h5">พนักงาน: งานเคลียร์</header>
<table class="table table-striped m-b-none">

<?php 
$temp_count_freq = 0;
 $count_chemical =0;
 $count_clearing_number =0;
 $total_chemical_clearing =0;

//== TODO :: get frequency area =======================

$temp_area_clearing = $get_area->row_array();
$array_frequency =array('');
if(!empty($temp_area_clearing)){ 
   foreach($get_area->result_array() as $value){ 
      if($value['is_on_clearjob']==1){
        if (in_array( $value['frequency'], $array_frequency, TRUE)){                
                //echo "have";
        }else{
            //echo "nohave";
            array_push($array_frequency,$value['frequency']);            
        }//end else 
      }//end if check clearing
   }//end foreach
}//end if
// prine 
// print_r($array_frequency);
// echo "<br>";
//== TODO :: get  area clearing =======================
    
$temp_clearing_type =array('');
$temp_clearing_name =array();
$temp_frequen= $array_frequency;
if(!empty($temp_frequen)){
   foreach($array_frequency as $fre => $fre_value) { 
    if($fre != 0){
      $temp_count_freq++;
?>     

                    <thead>
                      <tr>
                        <th  width="600" class="tx-blue font-bold">จำนวน <?php echo 'Frequency '.$fre_value.' month'; ?></th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>

<?php       
//echo '<br>/////////////////// frequency : '.$fre_value.' //////////////////////';
foreach($get_area->result_array() as $value){ 
if($value['is_on_clearjob']==1 && $value['frequency']==$fre_value){
    // echo '<br>///// clear_job_type_id : '.$value['clear_job_type_id'].' //////////';
    // echo '<br>clearing_des : '.$value['clearing_des'];                  
  if (in_array( $value['clear_job_type_id'], $temp_clearing_type, TRUE)){                
          //echo "have";
  }else{
      //echo "nohave";
      array_push($temp_clearing_type,$value['clear_job_type_id']);  
      $temp_clearing_name[$value['clear_job_type_id']] = $value['clearing_des'];          
  }//end else 
  //set : $count_space_for_clearing =0;               
}//end if check clearing
}//end foreach  
$count_array_clering = count($temp_clearing_name);


}//end if

// echo "<br>";
// echo "temp_clearing_type_name :";
// print_r($temp_clearing_name);
// echo "<br>";
$total_clearing_frequency =0; 
$count_array_clering = count($temp_clearing_name);
$temp_count_clearing = 0;
$count_space =0;          
foreach($temp_clearing_name as $clear_id => $clear_value) {    
$count_clearing_number++;        
$temp_count_clearing++; 

foreach($get_area->result_array() as $value){ 
      if( $clear_id==$value['clear_job_type_id'] && $fre_value == $value['frequency']){
        //echo '<br>space :'.$value['space'];
        $count_space = $count_space  +$value['space'];
      }//end if
  }//end end foreach 
 $count_space =   number_format($count_space, 2, '.', '');               
 //echo '<br>count_space : '.$count_space;

//===== GET : total_price_staff_clearing ========
$price_job =0;
// echo 'clear_id :'.$clear_id;
// echo 'fre_value :'.$fre_value;
$temp_price_staff= $get_area->result_array();
if(!empty($temp_price_staff)){
  foreach($get_area->result_array() as $value_price){  
      if($value_price['frequency']== $fre_value && $value_price['clear_job_type_id']== $clear_id){
          $staff = $value_price['staff'];       
      }//end if
  }// foreach
}else{
     $staff = ''; 
}//end else

?>

                      <tr>
                          <td><?php  echo $clear_value.' X '.$count_space.' M2 ';?></td>
                          <td><?php  if(!empty($staff)){ echo "จำนวนพนักงาน : ".$staff."  คน"; }else{ echo "ไม่มีข้อมูล"; } ?></td>
                      </tr>

<?php                     
    $count_space =0;
     }//end foreach temp_clearing_name
    //set : array annd count space          
    $temp_clearing_type =array();
    $temp_clearing_name =array();

}//end foreach   
}//end if empty

//frequency empty
if($temp_count_freq==0){
 echo "<tr><div class='h5 ' style='padding:10px;'>ไม่มีข้อมูล</div></tr>";
}//end fre empty


}//end :check job_type clering ZQT1
?>

</tbody>
</table>
</section>
</div>





<!-- form submit -->
<div class="form-group col-sm-12 ">
  <div class="pull-right">
    <a href="<?php echo site_url($this->page_controller.'/listview/'.$this->quotation_id); ?>"  class="btn btn-info" style="width:120px;"> <?php echo freetext('back'); ?></a>
   
  </div>
</div>
<!-- end : form submit -->

</div><!-- end : class div_detail -->


          











