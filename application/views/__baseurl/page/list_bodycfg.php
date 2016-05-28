<style type="text/css">
  .table-head,.table-division{ text-align: center }
  .panel-heading .btn-sm { margin-top: -6px}
</style>

<?php
//TODO : get position for sesion
$array = $this->session->userdata('function');
// echo "<pre>";
// print_r($array);
// echo "</pre>";

$temp_function= $array;
// echo "<pre>";
// print_r($temp_function);
// echo "</pre>";
//====start : get data quotation   =========
$data_quotation = $query_quotation->row_array(); 
if(!empty($data_quotation)){
$required_doc =  unserialize($data_quotation['required_doc']);
}else{
$required_doc =''; 
}

// echo "<br>";
// print_r($required_doc);

$temp_1 =  array("MK","CR","ST", "OP", "RC", "IC", "HR", "WF","IT", "TN", "AC", "FI");
$temp_2 =  array("MK","CR", "ST", "OP", "RC", "WF","IT","AC");
$temp_3 =  array("MK","CR", "ST", "OP", "RC", "IC", "HR", "WF","IT", "TN", "AC", "FI");
$temp_4 =  array("MK","CR", "ST", "OP", "IC", "AC");
$temp_5 =  array("MK","CR", "ST", "OP", "IC", "AC");
$temp_6 =  array("MK","CR", "ST", "OP", "IC", "AC");
$temp_7 =  array("MK","CR", "ST", "OP", "IC", "AC");
$temp_8 =  array("MK","CR", "ST", "OP", "RC", "TN", "AC");
$temp_9 =  array("MK","CR", "AC", "FI");
$temp_10 =  array("MK","CR","AC");
//$temp_11 =  array("MK","CR", "AC","FI");
$temp_12 =  array("MK","CR", "ST", "OP", "IC","WF","IT","AC", "FI");
$temp_13 =  array("MK","CR", "AC", "FI");

?>

<div class="div_detail">

<div class="col-sm-12">
    <section class="panel panel-default">
      <header class="panel-heading h4"><?php echo "งานที่กระจาย Quotation ID :".$this->quotation_id; ?></header>
      <table class="table table-striped m-b-none">
       <!--  <thead>
          <tr>
            <th>
               งานที่กระจาย
            </th>
          </tr>
        </thead> -->
        <tbody class="h5">

<?php
foreach($temp_function as $a => $a_value) {  
if(is_array($temp_1) && in_array($a_value, $temp_1)){ 
if(is_array($required_doc) && in_array('1', $required_doc)){   
?>
          <tr>                    
            <td>
              <a href="<?php echo site_url($this->page_controller.'/detail_url/data_customer/'.$this->quotation_id); ?>"  >
              1. ข้อมูลลูกค้า
              </a>
            </td>
          </tr>
<?php 
break;
}//end if 
}//end if position
}
?>

<?php
foreach($temp_function as $a => $a_value) {  
if(is_array($temp_2) && in_array($a_value, $temp_2)){      
if(is_array($required_doc) && in_array('2', $required_doc)){
?>
          <tr>                    
            <td>
              <a href="<?php echo site_url($this->page_controller.'/detail_url/data_wage/'.$this->quotation_id); ?>"  >
              2. ต้นทุนค่าแรง
              </a>
            </td>
          </tr>
<?php
break; 
}//end if 
}
}
?>


<?php
foreach($temp_function as $a => $a_value) {  
if(is_array($temp_3) && in_array($a_value, $temp_3)){   
if(is_array($required_doc) && in_array('3', $required_doc)){
?>
          <tr>                    
            <td>
              <a href="<?php echo site_url($this->page_controller.'/detail_url/data_staff/'.$this->quotation_id); ?>"  >
              3. จำนวนคน/ตำแหน่ง
            </a>
            </td>
          </tr>
<?php 
break;
}//end if 
}
}
?>          


<?php
foreach($temp_function as $a => $a_value) {    
if(is_array($temp_4) && in_array($a_value, $temp_4)){ 
if(is_array($required_doc) && in_array('4', $required_doc)){

?>
          <tr>                    
            <td>
              <a href="<?php echo site_url($this->page_controller.'/detail_url/data_chemical/'.$this->quotation_id); ?>"  >
              4. ต้นทุนน้ำยา
            </a>
            </td>
          </tr>
<?php
break; 
}//end if 
}
}
?>

<?php
foreach($temp_function as $a => $a_value) {    
if(is_array($temp_5) && in_array($a_value, $temp_5)){ 
if(is_array($required_doc) && in_array('5', $required_doc)){ 
?>
          <tr>                    
            <td>
              <a href="<?php echo site_url($this->page_controller.'/detail_url/data_tool/'.$this->quotation_id); ?>"  >
              5. ต้นทุนอุปกรณ์
            </a>
            </td>
          </tr>
<?php 
break;
}
}//end if
} 
?>

<?php
foreach($temp_function as $a => $a_value) {    
if(is_array($temp_6) && in_array($a_value, $temp_6)){ 
if(is_array($required_doc) && in_array('6', $required_doc)){ 
?>
          <tr>                    
            <td>
              <a href="<?php echo site_url($this->page_controller.'/detail_url/data_asset/'.$this->quotation_id); ?>"  >
              6. รายการทรัพย์สิน
            </a>
            </td>
          </tr>
<?php
break; 
}
}//end if
} 
?>

<?php
foreach($temp_function as $a => $a_value) {    
if(is_array($temp_7) && in_array($a_value, $temp_7)){ 
if(is_array($required_doc) && in_array('7', $required_doc)){ ?>
          <tr>                    
            <td>
              <a href="<?php echo site_url($this->page_controller.'/detail_url/data_consumable/'.$this->quotation_id); ?>"  >
              7. รายการและจำนวนวัสดุสิ้นเปลือง
            </a>
            </td>
          </tr>
<?php 
break;
}//end if 
}
}
?>

<?php
foreach($temp_function as $a => $a_value) {    
if(is_array($temp_8) && in_array($a_value, $temp_8)){ 
if(is_array($required_doc) && in_array('8', $required_doc)){ ?>
          <tr>                    
            <td>
              <a href="<?php echo site_url($this->page_controller.'/detail_url/data_detailService/'.$this->quotation_id); ?>"  >
              8. รายละเอียดการบริการ
            </a>
            </td>
          </tr>
<?php
break; 
}//end if 
}
}
?>

<?php
foreach($temp_function as $a => $a_value) {    
if(is_array($temp_9) && in_array($a_value, $temp_9)){ 
if(is_array($required_doc) && in_array('9', $required_doc)){ ?>
          <tr>                    
            <td>
              <a href="<?php echo site_url($this->page_controller.'/detail_url/data_circulation/'.$this->quotation_id); ?>"  >
              9. ใบแจ้งยอดขาย
            </a>
            </td>
          </tr>
<?php
break; 
}//end if 
}
}
?>

<?php
foreach($temp_function as $a => $a_value) {    
if(is_array($temp_10) && in_array($a_value, $temp_10)){ 
if(is_array($required_doc) && in_array('10', $required_doc)){ ?>
          <tr>                    
            <td>
              <a href="<?php echo site_url($this->page_controller.'/detail_url/data_doc_contract/'.$this->quotation_id); ?>"  >
              10. สัญญา
            </a>
            </td>
          </tr>
<?php 
break;
}//end if 
}
}
?>

<?php
//foreach($temp_function as $a => $a_value) {    
//if(is_array($temp_11) && in_array($a_value, $temp_11)){ 
//if(is_array($required_doc) && in_array('11', $required_doc)){ ?>
        <!--   <tr>                    
            <td>
              <a href="<?php //echo site_url($this->page_controller.'/detail_url/data_contract/'.$this->quotation_id); ?>"  >
              11. ระบุข้อมูลการวางบิล + รับเช็ค
            </a>
            </td>
          </tr> -->
<?php 
//break;
//}
//}//end if 
//}
?>

<?php
foreach($temp_function as $a => $a_value) {  
if(is_array($temp_12) && in_array($a_value, $temp_12)){ 
if(is_array($required_doc) && in_array('12', $required_doc)){ 
?>
          <tr>                    
            <td>
              <a href="<?php echo site_url($this->page_controller.'/detail_url/data_file_docservice/'.$this->quotation_id); ?>"  >
              11. ไฟล์ที่จะแนบ(ส่วนการบริการ)
            </a>
            </td>
          </tr>
<?php 
break;
}//end if 
}
}
?>

<?php  
foreach($temp_function as $a => $a_value) {
if(is_array($temp_13) && in_array($a_value, $temp_13)){ 
if(is_array($required_doc) && in_array('13', $required_doc)){
?>
          <tr>                    
            <td>
              <a href="<?php echo site_url($this->page_controller.'/detail_url/data_file_doccustomer/'.$this->quotation_id); ?>"  >
              12. ไฟล์ที่จะแนบ(ส่วนข้อมูลบริษัทลูกค้า)
            </a>
            </td>
          </tr>
<?php 
break;
}
}//end if 
}//end foreach

//check :: empty required_doc
if(empty($required_doc)){
?>

<tr>                    
  <td>
    <span class="h5 tx-red">ไม่มีข้อมูลการกระจายงาน</span>
  </a>
  </td>
</tr>

<? } ?>


        </tbody>
      </table>
    </section>
  </div>

</div><!-- end div -->
          





