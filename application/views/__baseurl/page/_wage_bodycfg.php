<style type="text/css">
.dt_header{
display: none  !important;
}

.dt_footer .row-fluid{
display: none  !important;
}

<?php

//################### start : GET total_staff_quotation ##################################
$temp_quotation_staff = $query_quotation->row_array();
if(!empty($temp_quotation_staff)){ 
   foreach($query_quotation->result_array() as $value){          
          $total_staff_quotation_db  = $value['total_staff_quotation'];
       }//end foreach

}else{
   $total_staff_quotation_db =0;
}

?>


</style>
<div class="div_detail">


<div class="col-lg-12" style="margin-bottom:20px;"> 
<h4 class="page-header">DATA WAGE</h4>
<div class="row fontawesome-icon-list">
  
<div class="col-lg-12"> 
    <div class="col-lg-6"> 
    <label class="col-lg-2 control-label h4"><?php echo freetext('#staff'); ?></label>
    <div class="col-lg-10">
    <span class="h4"><?php echo $total_staff_quotation_db; ?> คน</span>
    </div>
    </div> 

    <div class="col-lg-6"> 
    <label class="col-lg-4 control-label h4"><?php echo freetext('total_all'); ?></label>
    <div class="col-lg-6">
    <span class="h4">1 คน</span>
    </div>
    </div>
</div>

</div>  
</div>






<?php

///////////////// GET : MAN GROUP //////////////////////
$daily_pay_rate_type='';
$level_staff = '';
$position = '';
$uniform = '';
$gender = '';


$this->db->select('tbt_man_group.*');
$this->db->where('quotation_id', $this->quotation_id);
$query_man = $this->db->get('tbt_man_group');
$group = $query_man->row_array();
if (!empty($group)) {
foreach($query_man->result_array() as $value_gr){ 

if($value_gr['daily_pay_rate_type']=='day'){
  $daily_pay_rate_type ='วัน';
}else{
  $daily_pay_rate_type ='เดือน';
}


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

//echo "<br>title : ".$value_gr['title'];
//$equipment_total = $equipment['total_price'];
?>
                      <br><br><br><br>
                      <div class="col-sm-12">
                      <section class="panel panel-default">
                        <header class="panel-heading">
                          <h5><span class="font-bold"><?php echo freetext('benefits')." : </span>".$value_gr['title']." <span class='font-bold' style='margin-left:50px;'>".freetext('total_man')." : </span>".$value_gr['staff']." คน"; ?></h5>
                          <h5><span class="font-bold"><?php echo freetext('level_staff')." : </span>".$level_staff." , <span class='font-bold'>".freetext('position')." : </span>".$position.", <span class='font-bold'>".freetext('uniform')." : </span>".$uniform; ?></h5>
                          <h5><?php echo "ค่าแรงราย (".$daily_pay_rate_type.") : ".$value_gr['daily_pay_rate']." บาท"; ?></h5>
                          <h5><?php echo freetext('overtime')." : ".$value_gr['overtime']." บาท"; ?></h5>
                          <h5><?php echo freetext('holiday')." : ".$value_gr['holiday']." บาท"; ?></h5> 
                          <h5><?php echo freetext('transport_exp')." : ".$value_gr['transport_exp']." บาท"; ?></h5>
                          <h5><?php echo freetext('incentive')." : ".$value_gr['incentive']." บาท"; ?></h5> 
                          <h5><?php echo freetext('bonus')." : ".$value_gr['bonus']." บาท"; ?></h5> 
                          <h5><?php echo freetext('special')." : ".$value_gr['special']." บาท"; ?></h5> 
                          
                          <?php if(!empty($value_gr['other_title'])){ ?>
                          <h5><?php echo $value_gr['other_title']." : ".$value_gr['other_value']." บาท"; ?></h5>
                          <?php } ?>

                          <h5><?php echo freetext('waege')." : ".$value_gr['wage']." บาท"; ?></h5> 
                          <h5><?php echo freetext('benefit')." : ".$value_gr['benefit']." บาท"; ?></h5> 
                          <h5><?php echo freetext('wage_benefit')." : ".$value_gr['wage_benefit']." บาท"; ?></h5> 
                          <h5><?php echo freetext('sub_total')." : ".$value_gr['subtotal']." บาท"; ?></h5> 
                        </header>
                        <table class="table table-striped m-b-none">


<?php  
///////////////// GET : MAN GROUP //////////////////////
$this->db->select('tbt_man_subgroup.*');
$this->db->where('man_group_id', $value_gr['id']);
$query_sub_man = $this->db->get('tbt_man_subgroup');
$sub_group = $query_sub_man->row_array();
if (!empty($sub_group)) {
foreach($query_sub_man->result_array() as $value){ 
//echo "<br>total : ".$value['total']; 
if($value['gender']=='female'){
$gender ='หญิง';
}else{
$gender ='ชาย';
}
?>

                                <thead>
                                  <tr>
                                    <th width="200">
                                      <span class="tx-blue"><?php echo freetext('#staff')." (".$gender.") : "; ?></span>
                                      <?php echo $value['total']." คน"; ?>
                                    </th>
                                    <th>
                                      <span class="tx-blue">วันที่ทำงาน : </span><?php echo $value['total']." คน"; ?>
                                      <span class="tx-blue" style="margin-left:50px;"> เวลาเริ่ม </span><?php echo $value['time_in']; ?>
                                      <span class="tx-blue" style="margin-left:20px;"> ถึง </span><?php echo $value['time_out']; ?>
                                   </th>         
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>                    
                                    <td><?php echo freetext('work_hrs'); ?></td>
                                    <td><?php echo $value['work_hours']; ?></td>
                                  </tr>     
                                  <tr>                    
                                    <td><?php echo freetext('overtime_hrs'); ?></td>
                                    <td><?php echo $value['overtime_hours']; ?></td>
                                  </tr>     
                                  <tr>                    
                                    <td><?php echo freetext('work_day'); ?></td>
                                    <td><?php echo $value['work_day']; ?></td>
                                  </tr>
                                  <tr>                    
                                    <td><?php echo freetext('work_holiday'); ?></td>
                                    <td><?php echo $value['work_holiday']; ?></td>
                                  </tr>  
                                  <tr>                    
                                    <td><?php echo freetext('charge_ot'); ?></td>
                                    <td><?php echo $value['charge_overtime']; ?></td>
                                  </tr>
                                  <tr>                    
                                    <td><?php echo freetext('remark'); ?></td>
                                    <td><?php echo $value['remark']; ?></td>
                                  </tr> 
                                  <tr>                    
                                    <td><?php echo freetext('per_person'); ?></td>
                                    <td><?php echo $value['subtotal_per_person']; ?></td>
                                  </tr>  
                                  <tr>                    
                                    <td><?php echo freetext('per_group'); ?></td>
                                    <td><?php echo $value['subtotal_per_group']; ?></td>
                                  </tr>         
                                </tbody>
<?php
}//end foreach
}else{

}//end else
///////////////// END :: GET : MAN GROUP //////////////////////
?>

                        </table>
                        </section>
                        </div>
<?php
}//end foreach
}else{
  
}//end else
?>

<!-- form submit -->
<div class="form-group col-sm-12 ">
  <div class="pull-right">
    <a href="<?php echo site_url($this->page_controller.'/listview/'.$this->quotation_id); ?>"  class="btn btn-info" style="width:120px;"> <?php echo freetext('back'); ?></a>
   
  </div>
</div>
<!-- end : form submit -->


</div><!-- end : class div_detail -->


          











