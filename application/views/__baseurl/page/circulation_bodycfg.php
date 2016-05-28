<style type="text/css">
.dt_header{
display: none  !important;
}

.dt_footer .row-fluid{
display: none  !important;
}

</style>

<div class="div_detail" style="padding-left:50px;padding-right:50px;padding-bottom:50px;">
<h4 class="page-header font-bold tx-black"><i class="fa fa-leaf h5"></i> ใบแจ้งยอดขาย</h4>


<?php

  if ($staffExist == 1) {
?>
<div class="panel panel-default ">
  <div class="panel-heading" style="padding-bottom :24px;">
    <h4 class="panel-title">
    <a data-toggle="collapse" data-parent="#accordion" href="#collapse_summary" class="toggle_tool">
      <i class="margin-top-small-toggle icon_tool_down fa fa-caret-down  text-active pull-right"></i>
      <i class="icon_tool_up fa fa-caret-up text  pull-right"></i>                                    
    </a>                               
    </h4>
  </div>
  <div id="collapse_summary" class="panel-collapse in">
    <!-- start :body detail table machine -->
    <div class="panel-body" style="padding:15px 0px 0px 0px;">
      <div class="form-group col-sm-12  no-padd" >
      <!-- end : table -->
        <div id="collapseOne" class="panel-collapse collapse in" style="height: 100%;"> 
          <div class="panel-heading" style="padding-bottom:0;">
            <h4>ต้นทุนค่าแรงพนักงาน</h4>
            <?php
              $staff_list = $get_staff->result_array();
              $staff_arr = array();
              $total_subgroup_staff = 0;
              $total_group_staff = array();
              if (!empty($staff_list)) {
                foreach ($staff_list as $key => $staff) {
                  if (!array_key_exists($staff['employee_level_id'],$staff_arr)) {
                    $this->db->where('id', $staff['employee_level_id']);
                    $query = $this->db->get('sap_tbm_employee_level');
                    $level = $query->row_array();

                    $staff_arr[$staff['employee_level_id']]['title'] = "";
                    if (!empty($level)) {
                      $staff_arr[$staff['employee_level_id']]['title'] = $level['description'];
                    }
                    $staff_arr[$staff['employee_level_id']]['subgroup'] = array();
                  }

                  array_push($staff_arr[$staff['employee_level_id']]['subgroup'], $staff);

                  if (!array_key_exists($staff['employee_level_id'],$total_group_staff)) {
                    $total_group_staff[$staff['employee_level_id']] = array();
                  }
                  if (!array_key_exists($staff['man_group_id'], $total_group_staff[$staff['employee_level_id']])) {
                    $total_group_staff[$staff['employee_level_id']]['total'] += $staff['total'];
                    $total_group_staff[$staff['employee_level_id']][$staff['man_group_id']] = 1;

                    $total_subgroup_staff += $staff['total'];

                  }

                }

              }

              foreach ($total_group_staff as $employee_level_id => $value) {
            ?>
                <input type="hidden" class="total_staff_<?php echo $employee_level_id; ?>" value="<?php echo $value['total']; ?>">
            <?php
              }
            ?>      
            <input type="hidden" class="total_subgroup_staff" value="<?php echo $total_subgroup_staff; ?>">
          </div> 
          <div class="panel-body h5" style="padding-top:0;"> 
            <div>
            <?php
            //get job_type from tbt_quotation
              $quotation_data = $query_quotation->row_array();
              // $quotation_data['job_type'] = 'ZQT2';

              $summary_percent_rate = array(
                'percent_social_security' => 0,
                'percent_operation'       => 0,
                'percent_margin'          => 0,
                'percent_buffer'          => 0,
                'percent_vat'             => 0
              );

              $this->db->where('tbm_summary.doc_type', $quotation_data['job_type']);
              $query = $this->db->get('tbm_summary');          
              $summary_percent_rate = $query->row_array();

              $day_mapping = array(
                'SUN' => 'อา',
                'MON' => 'จ',
                'TUE' => 'อ',
                'WED' => 'พ',
                'THU' => 'พฤ',
                'FRI' => 'ศ',
                'SAT' => 'ส',
                'HOL' => 'วันหยุด'
              );

              $total_level_share_benefit = array();
              $total_benefit = 0;
              if (!empty($staff_arr)) {
                foreach ($staff_arr as $employee_level_id => $level_value) {
                  $total_level_benefit = 0;
            ?>
                  <div class="row wrapper">
                    <div class="row col-sm-5"><?php echo $level_value['title'].' ('.$total_group_staff[$employee_level_id]['total'].' คน)'; ?></div>
                    <div class="col-sm-2 text-center">เงินเดือน</div>
                    <div class="col-sm-1 text-center">&nbsp;</div>
                    <div class="col-sm-1 text-center">จำนวนคน</div>
                    <div class="col-sm-1 text-center">&nbsp;</div>
                    <div class="col-sm-2 text-center">ค่าแรงรวม</div>
                  </div>
            <?php
                  if (!empty($level_value['subgroup'])) {
                    // echo "<pre>";
                    // print_r($level_value['subgroup']);
                    // echo "</pre>";
                    foreach ($level_value['subgroup'] as $index => $subgroup) {
                      $total_per_person  = floatval($subgroup['benefit'])+floatval($subgroup['subtotal_per_person']);

                      $total_subgroup_benefit = number_format((float)($total_per_person*intval($subgroup['subgroup_total'])), 2, '.', '');

                      $total_level_benefit += $total_subgroup_benefit;
                      $total_benefit       += $total_subgroup_benefit;
            ?>
                      <div class="row wrapper">
                        <div class="row col-sm-5">
                          <div class="col-sm-4"><?php echo $subgroup['position_title']; ?></div> 
                          <?php
                            $day_list = unserialize($subgroup['day']);
                            $day_txt = '';

                            if (!empty($day_list)) {
                              // echo "<pre>";
                              // print_r($day_list);
                              // echo "</pre>";
                              if (is_array($day_list)) {
                                foreach ($day_list as $day) {
                                  if (empty($day_txt)) {
                                    $day_txt = $day_mapping[$day];
                                  } else {
                                    $day_txt .= ', '.$day_mapping[$day];
                                  }
                                }
                              } else {
                                if (array_key_exists($day_list, $day_mapping)) {
                                  $day_txt = $day_mapping[$day_list];    
                                }                              
                              }
                            }
                          ?>
                          <div class="col-sm-4"><?php echo $day_txt; ?></div>
                          <div class="col-sm-4"><?php echo substr($subgroup['time_in'], 0, 5); ?>-<?php echo substr($subgroup['time_out'], 0, 5); ?></div>
                        </div>
                        <div class="col-sm-2 text-center">
                          <input type="text" autocomplete="off" class="form-control text-right" value="<?php  echo number_format((float)$total_per_person, 2);  ?>" disabled>
                        </div>
                        <div class="col-sm-1 text-center">X</div>
                        <div class="col-sm-1 text-center"><input type="text" autocomplete="off" class="form-control text-right" value="<?php echo $subgroup['subgroup_total']; ?>" disabled></div>
                        <div class="col-sm-1 text-center">=</div>
                        <div class="col-sm-2"><input type="text" autocomplete="off" class="form-control text-right" value="<?php echo number_format($total_subgroup_benefit,2); ?>" disabled></div>
                      </div>
            <?php
                    }
                  }

                  $total_level_share_benefit[$employee_level_id] = number_format((float)$total_level_benefit/intval($total_group_staff[$subgroup['employee_level_id']]['total']), 2, '.', '');
            ?>
                  <div class="row wrapper text-right m-r-lg">
                    <span class="h5">รวมค่าแรงพนักงาน</span>&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" autocomplete="off" class="pull-right form-control input-s text-right" value="<?php echo number_format($total_level_benefit,2); ?>" disabled>
                  </div>  
                  <div class="row wrapper text-right m-r-lg">
                    <span class="h5">ค่าแรงต่อคน</span>&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" autocomplete="off" class="pull-right form-control input-s text-right employee_level_price_per_person_<?php echo $employee_level_id; ?>" value="<?php echo number_format((float)$total_level_benefit/intval($total_group_staff[$subgroup['employee_level_id']]['total']), 2); ?>" disabled>
                  </div>
            <?php
                }
              }
            ?>      
            </div>
            <div>
              <div class="wrapper text-right m-r-lg bg-light dker col-sm-12 text-right">
                <span class="h5">รวมค่าแรงทั้งหมด</span>&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" autocomplete="off" class="pull-right form-control input-s text-right" value="<?php echo number_format($total_benefit,2); ?>" disabled>
              </div>
            </div>
          </div> 
        </div>
      </div><!-- end : col12-->
    </div><!-- end :body detail table machine -->
  </div>
</div>
<!-- <form id="summary_form" action="<?php //echo site_url('__ps_quotation/save_summary/'.$this->quotation_id); ?>" method="post"> -->
<!--################################ end :div detail tool ############################-->
<?php
  
  if (!empty($quotation_data) && ($quotation_data['job_type'] == 'ZQT2' || $quotation_data['job_type'] == 'ZQT3')){
?>
    <div class="panel panel-default h5" style="margin-bottom: 0;"> 
      <?php
        $social_security = number_format((float)($summary_percent_rate['percent_social_security']/100)*$total_benefit, 2, '.', '');

        $this->db->select_sum('total_price');
        $this->db->where('quotation_id', $this->quotation_id);
        $query = $this->db->get('tbt_equipment');
        $equipment = $query->row_array();
        if (!empty($equipment) && !empty($equipment['total_price'])) {
          $equipment_total = $equipment['total_price'];
        } else {
          $equipment_total = 0;
        }

        $total_6 = $total_benefit + $social_security + $equipment_total;
        if(!empty($summary_data)) { 
          $total_6 += $summary_data['transportation'];
          $total_6 += $summary_data['insurance'];
        }
        $operation = number_format((float)($summary_percent_rate['percent_operation']/100)*$total_6, 2, '.', '');
        $total_8 = $total_6 + $operation;
        $buffer = number_format((float)($summary_percent_rate['percent_buffer']/100)*$total_8, 2, '.', '');
        $total_10 = $total_8 + $buffer;
        $margin = number_format((float)($summary_percent_rate['percent_margin']/100)*$total_10, 2, '.', '');
        $final_total = $total_10 + $margin;

        $final_sale_quoted = $final_total;
        if(!empty($summary_data)) { 
          $final_sale_quoted -= $summary_data['maximum_discount'];
        }

        if (!empty($summary_data) && !empty($summary_data['total_variant_price'])) {
          $vat = $summary_data['vat'];
          $total_16 = $summary_data['total'];
        } else {
          $vat = number_format((float)($summary_percent_rate['percent_vat']/100)*$final_sale_quoted, 2, '.', '');
          $total_16 = $final_sale_quoted + $vat;     
        }
      ?>
      <div class="panel-heading" style="height: 100%; padding:0 15px;"> 
        <div class="row wrapper bg-light dker">
          <div class="row col-sm-8">&nbsp;</div>
          <div class="col-sm-2 text-center">ต้นทุนเฉลี่ยต่อคน</div>
          <div class="col-sm-2 text-center">ต้นทุนรวม</div>
        </div>
      </div> 
      <div class="panel-body bg-light" style="padding: 15px 15px 0px 15px;">
        <div class="row wrapper-sm">
          <div class="row col-sm-8">
            <span>ค่าแรงพนักงาน</span>
          </div>
          <div class="col-sm-2 text-center">&nbsp;</div>
          <div class="col-sm-2 text-center">
            <input type="hidden" name="employee_cost" class="employee_cost" value="<?php echo $total_benefit; ?>">
            <input type="text" autocomplete="off" class="form-control text-right employee_cost" disabled value="<?php echo number_format($total_benefit,2); ?>">
          </div>
        </div>
        <div class="row wrapper-sm bg-white">
          <div class="row col-sm-8">
            <div class="col-sm-4" style="padding-left:0;">
              <span class="">ค่าประกันสังคม</span>
            </div>
            <div class="col-sm-8">
            <input type="hidden" name="mpercent_social_security" class="" value="<?php echo $summary_percent_rate['percent_social_security']; ?>">
              <input type="text" autocomplete="off" class="form-control input-s-sm text-center" value="<?php echo $summary_percent_rate['percent_social_security']; ?>%" readonly>
            </div>
          </div>
          <div class="col-sm-2 text-center">&nbsp;</div>
          <div class="col-sm-2 text-center">
            <input type="hidden" name="social_security" class="social_security" value="<?php echo $social_security; ?>">
            <input type="text" autocomplete="off" class="form-control text-right social_security" disabled value="<?php echo number_format((float)$social_security, 2); ?>">
          </div>
        </div>
        <div class="row wrapper-sm">
          <div class="row col-sm-8">
            <span>ค่าน้ำยา, อุปกรณ์</span>
          </div>
          <div class="col-sm-2 text-center">&nbsp;</div>
          <div class="col-sm-2 text-center">
            <input type="hidden" name="equipment" class="equipment" value="<?php echo $equipment_total; ?>">
            <input type="text" autocomplete="off" class="form-control text-right equipment" disabled value="<?php echo number_format((float)$equipment_total, 2); ?>">
          </div>
        </div>
        <div class="row wrapper-sm bg-white">
          <div class="row col-sm-8">
            <span>ค่าพาหนะ</span>
          </div>
          <div class="col-sm-2 text-center">&nbsp;</div>
          <div class="col-sm-2 text-center">
            <input type="text" autocomplete="off" name="transportation" class="form-control text-right transportation" onkeypress="return isDouble(event)" value="<?php if(!empty($summary_data) && $summary_data['transportation'] != 0) { echo number_format((float)$summary_data['transportation'], 2); } else { echo ''; } ?>">
          </div>
        </div>
        <div class="row wrapper-sm">
          <div class="row col-sm-8">
            <span>ค่าประกันภัย</span>
          </div>
          <div class="col-sm-2 text-center">&nbsp;</div>
          <div class="col-sm-2 text-center">
            <input type="text" autocomplete="off" name="insurance" class="form-control text-right insurance" onkeypress="return isDouble(event)" value="<?php if(!empty($summary_data) && $summary_data['insurance'] != 0) { echo number_format((float)$summary_data['insurance'], 2); } else { echo ''; } ?>">
          </div>
        </div>
        <div class="row wrapper-sm bg-white">
          <div class="row col-sm-8">
            <span>รวมต้นทุน</span>
          </div>
          <div class="col-sm-2 text-center">&nbsp;</div>
          <div class="col-sm-2 text-center">
            <input type="hidden" name="subtotal" class="subtotal" value="<?php echo $equipment_total; ?>">
            <input type="text" autocomplete="off" class="form-control text-right subtotal" disabled value="<?php echo number_format($total_6,2); ?>">
          </div>
        </div>
        <div class="row wrapper-sm">
          <div class="row col-sm-8">
            <div class="col-sm-4" style="padding-left:0;">
              <span class="">ค่าดำเนินการ</span>
            </div>
            <div class="col-sm-8">
            <input type="hidden" name="mpercent_operation" class="" value="<?php echo $summary_percent_rate['percent_operation']; ?>">
              <input type="text" autocomplete="off" class="form-control input-s-sm text-center" value="<?php echo $summary_percent_rate['percent_operation']; ?>%" readonly>
            </div>
          </div>
          <div class="col-sm-2 text-center">&nbsp;</div>
          <div class="col-sm-2 text-center">
            <input type="hidden" name="operation_cost" class="operation_cost" value="<?php echo $operation; ?>">
            <input type="text" autocomplete="off" class="form-control text-right operation_cost" disabled value="<?php echo number_format($operation,2); ?>">
          </div>
        </div>
        <div class="row wrapper-sm bg-white">
          <div class="row col-sm-8">
            <span>รวมต้นทุนทั้งหมด</span>
          </div>
          <div class="col-sm-2 text-center">&nbsp;</div>
          <div class="col-sm-2 text-center">
            <input type="hidden" name="total_cost" class="total_cost" value="<?php echo $total_6; ?>">
            <input type="text" autocomplete="off" class="form-control text-right total_cost" disabled value="<?php echo number_format($total_8,2); ?>">
          </div>
        </div>
        <div class="row wrapper-sm">
          <div class="row col-sm-8">
            <div class="col-sm-4" style="padding-left:0;">
              <span class="">ค่ากันพลาด</span>
            </div>
            <div class="col-sm-8">
            <input type="hidden" name="mpercent_buffer" class="" value="<?php echo $summary_percent_rate['percent_buffer']; ?>">
              <input type="text" autocomplete="off" class="form-control input-s-sm text-center" value="<?php echo $summary_percent_rate['percent_buffer']; ?>%" readonly>
            </div>
          </div>
          <div class="col-sm-2 text-center">&nbsp;</div>
          <div class="col-sm-2 text-center">
            <input type="hidden" name="buffer" class="buffer" value="<?php echo $buffer; ?>">
            <input type="text" autocomplete="off" class="form-control text-right buffer" disabled value="<?php echo number_format($buffer,2); ?>">
          </div>
        </div>    
        <div class="row wrapper-sm bg-white">
          <div class="row col-sm-8">
            <span>รวมต้นทุนทั้งหมด</span>
          </div>
          <div class="col-sm-2 text-center">&nbsp;</div>
          <div class="col-sm-2 text-center">
            <input type="hidden" name="subtotal_buffer" class="subtotal_buffer" value="<?php echo $total_10; ?>">
            <input type="text" autocomplete="off" class="form-control text-right subtotal_buffer" disabled value="<?php echo number_format($total_10,2); ?>">
          </div>
        </div>
        <div class="row wrapper-sm">
          <div class="row col-sm-8">
            <div class="col-sm-4" style="padding-left:0;">
              <span class="">กำไร</span>
            </div>
            <div class="col-sm-8">
            <input type="hidden" name="mpercent_margin" class="" value="<?php echo $summary_percent_rate['percent_margin']; ?>">
              <input type="text" autocomplete="off" class="form-control input-s-sm text-center" value="<?php echo $summary_percent_rate['percent_margin']; ?>%" readonly>
            </div>
          </div>
          <div class="col-sm-2 text-center">&nbsp;</div>
          <div class="col-sm-2 text-center">
            <input type="hidden" name="margin" class="margin" value="<?php echo $margin; ?>">
            <input type="text" autocomplete="off" class="form-control text-right margin" disabled value="<?php echo number_format($margin,2); ?>">
          </div>
        </div>
        <div class="row wrapper-sm bg-white">
          <div class="row col-sm-8">
            <span>ราคาเสนอขาย</span>
          </div>
          <div class="col-sm-2 text-center">&nbsp;</div>
          <div class="col-sm-2 text-center">
            <input type="hidden" name="sale_quoted" class="sale_quoted" value="<?php echo $final_total; ?>">
            <input type="text" autocomplete="off" class="form-control text-right sale_quoted" disabled value="<?php echo number_format($final_total,2); ?>">
          </div>
        </div>
        <div class="row wrapper-sm">
          <div class="row col-sm-8">
            <span>ราคาที่ลดต่ำสุด</span>
          </div>
          <div class="col-sm-2 text-center">&nbsp;</div>
          <div class="col-sm-2 text-center">
            <input type="text" autocomplete="off" name="maximum_discount" class="form-control text-right maximum_discount" onkeypress="return isDouble(event)" value="<?php if(!empty($summary_data) && $summary_data['maximum_discount'] != 0) { echo number_format((float)$summary_data['maximum_discount'], 2); } else { echo ''; } ?>">
          </div>
        </div>
        <div class="row wrapper-sm bg-white">
          <div class="row col-sm-8">
            <span>ราคาเสนอขายสุทธิ</span>
          </div>
          <div class="col-sm-2 text-center">&nbsp;</div>
          <div class="col-sm-2 text-center">
            <input type="hidden" name="final_sale_quoted" class="final_sale_quoted" value="<?php echo $final_sale_quoted; ?>">
            <input type="text" autocomplete="off" class="form-control text-right final_sale_quoted" disabled value="<?php echo number_format($final_sale_quoted,2); ?>">
          </div>
        </div>
        <div class="row wrapper-sm">
          <div class="row col-sm-8">
            <div class="col-sm-4" style="padding-left:0;">
              <span class="">ภาษีมูลค่าเพิ่ม</span>
            </div>
            <div class="col-sm-8">
            <input type="hidden" name="mpercent_vat" class="" value="<?php echo $summary_percent_rate['percent_vat']; ?>">
              <input type="text" autocomplete="off" class="form-control input-s-sm text-center" value="<?php echo $summary_percent_rate['percent_vat']; ?>%" readonly>
            </div>
          </div>
          <div class="col-sm-2 text-center">&nbsp;</div>
          <div class="col-sm-2 text-center">
            <input type="hidden" name="vat" class="vat" value="<?php echo $vat; ?>">
            <input type="text" autocomplete="off" class="form-control text-right vat" disabled value="<?php echo number_format($vat,2); ?>" <?php if(!empty($summary_data) && !empty($summary_data['total_variant_price'])) { echo "style='border-color:red;'"; } ?>>
          </div>
        </div>
        <div class="row wrapper-sm bg-white">
          <div class="row col-sm-8">
            <span>ราคาสุทธิหลังบวกภาษี</span>
          </div>
          <div class="col-sm-2 text-center">&nbsp;</div>
          <div class="col-sm-2 text-center">
            <input type="hidden" name="total" class="total" value="<?php echo $total_16; ?>">
            <input type="text" autocomplete="off" class="form-control text-right total" disabled value="<?php echo number_format($total_16,2); ?>" <?php if(!empty($summary_data) && !empty($summary_data['total_variant_price'])) { echo "style='border-color:red;'"; } ?>>
          </div>
        </div>
      </div>
    </div>
<?php
  } else if (!empty($quotation_data) && $quotation_data['job_type'] == 'ZQT1') {
?>
    <div class="panel-heading h5" style="height: 100%; padding:0 15px;"> 
      <div class="row wrapper bg-light dker">
        <div class="row col-sm-8">&nbsp;</div>
        <div class="col-sm-2 text-center">ต้นทุนเฉลี่ยต่อคน</div>
        <div class="col-sm-2 text-center">ต้นทุนรวม</div>
      </div>
    </div> 
    <div class="panel-body bg-light h5" style="padding: 15px 15px 0 15px;">
      <?php

//get frequency    
$temp_area_clearing = $get_area->row_array();
$array_frequency =array();
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
// echo "<br>";
// print_r($array_frequency);



//get time from quotation
$this->db->select('tbt_quotation.time');
//$this->db->join('tbt_quotation', 'tbt_quotation.id = tbt_other_service.quotation_id','left');
$this->db->where('tbt_quotation.id', $this->quotation_id);
$query_time = $this->db->get('tbt_quotation');
$query_job_type = $query_time->row_array();

//$this->db->select_sum('total_price_staff_clear');
$this->db->select('tbt_area.id,tbt_area.total_price_staff_clear,tbt_area.frequency,tbt_area.clear_job_type_id');
$this->db->where('quotation_id', $this->quotation_id);
$query_area = $this->db->get('tbt_area');
$staff_clear = $query_area->row_array();
$staff_clear_total = 0;
$temp_staff_clear_total = 0;

$temp_clearing_type =array();
$temp_frequen= $array_frequency;
if(!empty($temp_frequen)){
foreach($array_frequency as $fre => $fre_value) { 
//echo "<br> **fre :".$fre_value;

foreach($get_area->result_array() as $value){ 
if($value['is_on_clearjob']==1 && $value['frequency']==$fre_value){
    // echo '<br>///// clear_job_type_id : '.$value['clear_job_type_id'].' //////////';
    // echo '<br>clearing_des : '.$value['clearing_des'];                  
  if(in_array( $value['clear_job_type_id'], $temp_clearing_type, TRUE)){                
          //echo "have";
  }else{
      //echo "nohave";
      array_push($temp_clearing_type,$value['clear_job_type_id']);  
      //$temp_clearing_name[$value['clear_job_type_id']] = $value['clearing_des'];          
  }//end else 
  //set : $count_space_for_clearing =0;               
}//end if check clearing
}//end foreach 
// echo "<br>";
// print_r($temp_clearing_type);

$temp_count_clearing = array();
foreach($temp_clearing_type as $clear_id => $clear_value) {  

        if (!empty($staff_clear)){//&& !empty($staff_clear['total_price_staff_clear'])
              foreach($query_area->result_array() as $value){ 
             //if($value['frequency']==$fre_value){
              if( $clear_value==$value['clear_job_type_id'] && $fre_value == $value['frequency']){
                if(in_array( $value['clear_job_type_id'], $temp_count_clearing, TRUE)){ 
                    //have
                  //echo "<br>have";
                }else{
                   array_push($temp_count_clearing,$value['clear_job_type_id']);  
                    // echo '<br>======'.$value['id'].'========<br>';
                    // echo $value['clear_job_type_id'].'<br>';
                    // echo $value['total_price_staff_clear'].'<br>';
                    // echo $value['frequency'].'<br>';
                    // echo $query_job_type['time'].'<br>';
                  $temp_staff_clear_total = (number_format((float)$query_job_type['time']/$value['frequency']))*$value['total_price_staff_clear'];
                  $temp_staff_clear_total =  number_format((float)($temp_staff_clear_total/$query_job_type['time']), 2, '.', '');
                  //echo 'temp_staff_clear_total :'.$temp_staff_clear_total.'<br>';
                  $staff_clear_total = $staff_clear_total+$temp_staff_clear_total;
                  //echo 'staff_clear_total :'.$staff_clear_total.'<br>';
                }//end else
                }//end clear_job_type             
              }//end foreach         
        }else{
          //$staff_clear_total = 0;
        }

         
}//foreach temp_clearing_type


}//end foreach array_frequency
}//end if temp_frequen



        $total_1 = $total_benefit + $staff_clear_total;
        $social_security = number_format((float)($summary_percent_rate['percent_social_security']/100)*$total_1, 2, '.', '');

        $this->db->select_sum('total_price');
        $this->db->where('quotation_id', $this->quotation_id);
        $query = $this->db->get('tbt_equipment');
        $equipment = $query->row_array();
        if (!empty($equipment) && !empty($equipment['total_price'])) {
          $equipment_total = $equipment['total_price'];
        } else {
          $equipment_total = 0;
        }

        //$this->db->select_sum('total_price');
        $this->db->select('tbt_equipment_clearjob.id,tbt_equipment_clearjob.total_price,tbt_equipment_clearjob.frequency');
        //$this->db->join('tbt_quotation', 'tbt_quotation.id = tbt_equipment_clearjob.quotation_id','left');
        $this->db->where('tbt_equipment_clearjob.quotation_id', $this->quotation_id);
        $query_eq = $this->db->get('tbt_equipment_clearjob');
        $equipment_clearjob = $query_eq->row_array();
        $equipment_clearjob_total = 0;
        $temp_clerjob = 0;
        if (!empty($equipment_clearjob) ) {//&& !empty($equipment_clearjob['total_price'])
           //$equipment_clearjob_total = $equipment_clearjob['total_price'];
          foreach($query_eq->result_array() as $value){ 
                // echo '======'.$value['id'].'========<br>';
                // echo $value['total_price'].'<br>';
                // echo $value['frequency'].'<br>';
                // echo $query_job_type['time'].'<br>';
                $temp_clerjob = (number_format((float)$query_job_type['time']/$value['frequency']))*$value['total_price'];
                $temp_clerjob =   number_format((float)($temp_clerjob/$query_job_type['time']), 2, '.', '');
                //echo 'total clear :'.$temp_clerjob.'<br>';
                $equipment_clearjob_total = $equipment_clearjob_total+$temp_clerjob;
                //echo 'equipment_clearjob_total :'.$equipment_clearjob_total.'<br>';
          }

        } else {
          $equipment_clearjob_total = 0;
          //$total_equipment_clearjob =0;
        }

        $total_5 = $total_1 + $social_security + $equipment_total +  $equipment_clearjob_total;
        if(!empty($summary_data)) { 
          $total_5 += $summary_data['insurance'];
        }

        $operation = number_format((float)($summary_percent_rate['percent_operation']/100)*$total_5, 2, '.', '');
        $total_7 = $total_5 + $operation;
        $margin = number_format((float)($summary_percent_rate['percent_margin']/100)*$total_7, 2, '.', '');
        $total_9 = $total_7 + $margin;
        

        $this->db->select_sum('tbt_other_service.total');       
        $this->db->where('tbt_other_service.quotation_id', $this->quotation_id);
        $query = $this->db->get('tbt_other_service');
        $other_service = $query->row_array();
        if (!empty($other_service) && !empty($other_service['total'])) {
          $other_service_total = $other_service['total'];
          $other_service_total =  number_format((float)($other_service_total/$query_job_type['time']), 2, '.', '');
        } else {
          $other_service_total = 0;
        }

        $total_11 = $total_9;
        if(!empty($summary_data)) { 
          $total_11 -= $summary_data['maximum_discount'];
        }

        $final_total = $total_11 + $other_service_total;

        if (!empty($summary_data) && !empty($summary_data['total_variant_price'])) {
          $vat = $summary_data['vat'];
          $total_15 = $summary_data['total'];
        } else {
          $vat = number_format((float)($summary_percent_rate['percent_vat']/100)*$final_total, 2, '.', '');
          $total_15 = $final_total + $vat;        
        }
      ?>


      <div class="row wrapper-sm">
        <div class="row col-sm-8">
          <span class="m-l-md">รวมต้นทุนค่าแรงพนักงาน</span>
        </div>
        <div class="col-sm-2 text-center">
          <input type="hidden" name="employee_cost_per_person" class="" value="<?php echo number_format((float)$total_benefit/$total_subgroup_staff, 2, '.', ''); ?>">
          <input type="text" autocomplete="off" class="form-control text-right" disabled value="<?php echo number_format((float)$total_benefit/$total_subgroup_staff, 2); ?>" >
        </div>
        <div class="col-sm-2 text-center">
          <input type="hidden" name="employee_cost" class="" value="<?php echo $total_benefit; ?>">
          <input type="text" autocomplete="off" class="form-control text-right" disabled value="<?php echo number_format($total_benefit,2); ?>">
        </div>
      </div>
      <div class="row wrapper-sm bg-white">
        <div class="row col-sm-8">
          <span class="m-l-md">ค่าแรงงานเคลียร์</span>
        </div>
        <div class="col-sm-2 text-center">
          <input type="hidden" name="clearjob_employee_cost_per_person" class="clearjob_employee_cost_per_person" value="<?php echo number_format((float)$staff_clear_total/$total_subgroup_staff, 2, '.', ''); ?>">
          <input type="text" autocomplete="off" class="form-control text-right clearjob_employee_cost_per_person" disabled value="<?php echo number_format((float)$staff_clear_total/$total_subgroup_staff, 2); ?>" >
        </div>
        <div class="col-sm-2 text-center">
          <input type="hidden" name="clearjob_employee_cost" class="clearjob_employee_cost" value="<?php echo $staff_clear_total; ?>">
          <input type="text" autocomplete="off" class="form-control text-right clearjob_employee_cost" disabled value="<?php echo number_format((float)$staff_clear_total, 2); ?>">
        </div>
      </div>
      <div class="row wrapper-sm">
        <div class="row col-sm-8">
          <span class="m-l-md">ต้นทุนค่าแรง</span>
        </div>
        <div class="col-sm-2 text-center">&nbsp;</div>
        <div class="col-sm-2 text-center">
          <input type="hidden" name="employee_cost_sum" class="" value="<?php echo $total_1; ?>">
          <input type="text" autocomplete="off" class="form-control text-right" disabled value="<?php echo number_format($total_1,2); ?>">
        </div>
      </div>
      <div class="row wrapper-sm bg-white">
        <div class="row col-sm-8">
          <div class="col-sm-4">
            <span class="m-l-xs">ประกันสังคม</span>
          </div> 
          <div class="col-sm-8">
            <input type="hidden" name="mpercent_social_security" class="" value="<?php echo $summary_percent_rate['percent_social_security']; ?>">
            <input type="text" autocomplete="off" class="form-control input-s-sm text-center" value="<?php echo $summary_percent_rate['percent_social_security']; ?>%" readonly>
          </div>
        </div>
        <div class="col-sm-2 text-center">
          <input type="hidden" name="social_security_per_person" class="" value="<?php echo number_format((float)$social_security/$total_subgroup_staff, 2, '.', ''); ?>">
          <input type="text" autocomplete="off" class="form-control text-right" disabled value="<?php echo number_format((float)$social_security/$total_subgroup_staff, 2); ?>">
        </div>
        <div class="col-sm-2 text-center">
          <input type="hidden" name="social_security" class="" value="<?php echo $social_security; ?>">
          <input type="text" autocomplete="off" class="form-control text-right" disabled value="<?php echo number_format((float)$social_security, 2); ?>">
        </div>
      </div>
      <div class="row wrapper-sm">
        <div class="row col-sm-8">
          <span>อุปกรณ์และผลิตภัณฑ์งานประจำ</span>
        </div>
        <div class="col-sm-2 text-center">
          <input type="hidden" name="equipment_per_person" class="" value="<?php echo number_format((float)$equipment_total/$total_subgroup_staff, 2, '.', ''); ?>">
          <input type="text" autocomplete="off" class="form-control text-right" disabled value="<?php echo number_format((float)$equipment_total/$total_subgroup_staff, 2); ?>">
        </div>
        <div class="col-sm-2 text-center">
          <input type="hidden" name="equipment" class="" value="<?php echo $equipment_total; ?>">
          <input type="text" autocomplete="off" class="form-control text-right" disabled value="<?php echo number_format((float)$equipment_total, 2); ?>">
        </div>
      </div>
      <div class="row wrapper-sm bg-white">
        <div class="row col-sm-8">
          <span>อุปกรณ์และผลิตภัณฑ์งานเคลียร์</span>
        </div>
        <div class="col-sm-2 text-center">
          <input type="hidden" name="equipment_clearjob_per_person" class="" value="<?php echo number_format((float)$equipment_clearjob_total/$total_subgroup_staff, 2, '.', ''); ?>">
          <input type="text" autocomplete="off" class="form-control text-right" disabled value="<?php echo number_format((float)$equipment_clearjob_total/$total_subgroup_staff, 2); ?>">
        </div>
        <div class="col-sm-2 text-center">
          <input type="hidden" name="equipment_clearjob" class="" value="<?php echo $equipment_clearjob_total; ?>">
          <input type="text" autocomplete="off" class="form-control text-right" disabled value="<?php echo number_format((float)$equipment_clearjob_total, 2); ?>">
        </div>
      </div>
     <!--  <div class="row wrapper-sm">
        <div class="row col-sm-8">
          <span>ค่าประกันภัย</span>
        </div>
        <div class="col-sm-2 text-center">
          <input type="hidden" name="insurance_per_person" class="insurance_per_person" value="<?php// if(!empty($summary_data)) { echo number_format((float)$summary_data['insurance']/$total_subgroup_staff, 2, '.', ''); }?>">
          <input type="text" autocomplete="off" class="form-control text-right insurance_per_person" disabled value="<?php// if(!empty($summary_data)) { echo number_format((float)$summary_data['insurance']/$total_subgroup_staff, 2, '.', ''); }?>">
        </div>
        <div class="col-sm-2 text-center">
          <input type="text" autocomplete="off" name="insurance" class="form-control text-right insurance" onkeypress="return isDouble(event)" value="<?php// if(!empty($summary_data) && $summary_data['insurance'] != 0) { echo number_format((float)$summary_data['insurance'], 2, '.', ''); } else { echo ''; } ?>">
        </div>
      </div> -->
      <div class="row wrapper-sm ">
        <div class="row col-sm-8">
          <span>รวมต้นทุน</span>
        </div>
        <div class="col-sm-2 text-center">&nbsp;</div>
        <div class="col-sm-2 text-center">
          <input type="hidden" name="subtotal" class="subtotal" value="<?php echo $total_5; ?>">
          <input type="text" autocomplete="off" class="form-control text-right subtotal" disabled value="<?php echo number_format($total_5,2); ?>">
        </div>
      </div>
      <div class="row wrapper-sm bg-white">
        <div class="row col-sm-8">
          <div class="col-sm-4" style="padding-left:0;">
            <span class="">ค่าดำเนินการ</span>
          </div>
          <div class="col-sm-8">
            <input type="hidden" name="mpercent_operation" class="" value="<?php echo $summary_percent_rate['percent_operation']; ?>">
            <input type="text" autocomplete="off" class="form-control input-s-sm text-center" value="<?php echo $summary_percent_rate['percent_operation']; ?>%" readonly>
          </div>
        </div>
        <div class="col-sm-2 text-center">
          <input type="hidden" name="operation_cost_per_person" class="operation_cost_per_person" value="<?php echo number_format((float)$operation/$total_subgroup_staff, 2, '.', ''); ?>">
          <input type="text" autocomplete="off" class="form-control text-right operation_cost_per_person" disabled value="<?php echo number_format((float)$operation/$total_subgroup_staff, 2); ?>">
        </div>
        <div class="col-sm-2 text-center">
          <input type="hidden" name="operation_cost" class="operation_cost" value="<?php echo $operation; ?>">
          <input type="text" autocomplete="off" class="form-control text-right operation_cost" disabled value="<?php echo number_format($operation,2); ?>">
        </div>
      </div>
      <div class="row wrapper-sm ">
        <div class="row col-sm-8">
          <span>รวมต้นทุนทั้งหมด</span>
        </div>
        <div class="col-sm-2 text-center">&nbsp;</div>
        <div class="col-sm-2 text-center">
          <input type="hidden" name="total_cost" class="total_cost" value="<?php echo $total_7; ?>">
          <input type="text" autocomplete="off" class="form-control text-right total_cost" disabled value="<?php echo number_format($total_7,2); ?>">
        </div>
      </div>
      <div class="row wrapper-sm bg-white">
        <div class="row col-sm-8">
          <div class="col-sm-4" style="padding-left:0;">
            <span class="">กำไร</span>
          </div>
          <div class="col-sm-8">
            <input type="hidden" name="mpercent_margin" class="" value="<?php echo $summary_percent_rate['percent_margin']; ?>">
            <input type="text" autocomplete="off" class="form-control input-s-sm text-center" value="<?php echo $summary_percent_rate['percent_margin']; ?>%" readonly>
          </div>
        </div>
        <div class="col-sm-2 text-center">
          <input type="hidden" name="margin_per_person" class="margin_per_person" value="<?php echo number_format((float)$margin/$total_subgroup_staff, 2, '.', ''); ?>">
          <input type="text" autocomplete="off" class="form-control text-right margin_per_person" disabled value="<?php echo number_format((float)$margin/$total_subgroup_staff, 2); ?>">
        </div>
        <div class="col-sm-2 text-center">
          <input type="hidden" name="margin" class="margin" value="<?php echo $margin; ?>">
          <input type="text" autocomplete="off" class="form-control text-right margin" disabled value="<?php echo number_format($margin,2); ?>">
        </div>
      </div>
      <div class="row wrapper-sm ">
        <div class="row col-sm-8">
          <span>ราคาเสนอขาย</span>
        </div>
        <div class="col-sm-2 text-center">&nbsp;</div>
        <div class="col-sm-2 text-center">
          <input type="hidden" name="sale_quoted" class="sale_quoted" value="<?php echo $total_9; ?>">
          <input type="text" autocomplete="off" class="form-control text-right sale_quoted" disabled value="<?php echo number_format($total_9,2); ?>">
        </div>
      </div>
      <div class="row wrapper-sm bg-white">
        <div class="row col-sm-8">
          <span>ราคาที่ลดต่ำสุด</span>
        </div>
        <div class="col-sm-2 text-center">
          <input type="hidden" name="maximum_discount_per_person" class="maximum_discount_per_person" value="<?php if(!empty($summary_data) && $summary_data['maximum_discount_per_person'] != 0) { echo $summary_data['maximum_discount_per_person']; } else { echo ''; } ?>">
          <input type="text" autocomplete="off" class="form-control text-right maximum_discount_per_person" disabled value="<?php if(!empty($summary_data) && $summary_data['maximum_discount_per_person'] != 0) { echo number_format((float)$summary_data['maximum_discount_per_person'], 2); } else { echo ''; } ?>">
        </div>
        <div class="col-sm-2 text-center">
          <input type="text" autocomplete="off" name="maximum_discount" class="form-control text-right maximum_discount" onkeypress="return isDouble(event)" value="<?php if(!empty($summary_data) && $summary_data['maximum_discount'] != 0) { echo number_format((float)$summary_data['maximum_discount'], 2); } else { echo ''; } ?>">
        </div>
      </div>
      <div class="row wrapper-sm ">
        <div class="row col-sm-8">
          <span>ราคาเสนอขายสุทธิ</span>
        </div>
        <div class="col-sm-2 text-center">&nbsp;</div>
        <div class="col-sm-2 text-center">
          <input type="hidden" name="final_sale_quoted" class="final_sale_quoted" value="<?php echo $total_11; ?>">
          <input type="text" autocomplete="off" class="form-control text-right final_sale_quoted" disabled value="<?php echo number_format($total_11,2); ?>">
        </div>
      </div>
      
      <div class="row wrapper-sm bg-white">
        <div class="row col-sm-8">
          <span>งานบริการอื่นๆ</span>
        </div>
        <div class="col-sm-2 text-center">
          <input type="hidden" name="other_service_per_person" class="other_service_per_person" value="<?php echo number_format((float)$other_service_total/$total_subgroup_staff, 2, '.', ''); ?>">
          <input type="text" autocomplete="off" class="form-control text-right other_service_per_person" disabled value="<?php echo number_format((float)$other_service_total/$total_subgroup_staff, 2); ?>">
        </div>
        <div class="col-sm-2 text-center">
          <input type="hidden" name="other_service" class="other_service" value="<?php echo $other_service_total; ?>">
          <input type="text" autocomplete="off" class="form-control text-right other_service" disabled value="<?php echo number_format((float)$other_service_total, 2);  ?>">
        </div>
      </div>

      <div class="row wrapper-sm ">
        <div class="row col-sm-8">
          <span>ราคาเสนอขายรวมกับงานบริการอื่นๆ</span>
        </div>
        <div class="col-sm-2 text-center">&nbsp;</div>
        <div class="col-sm-2 text-center">
          <input type="hidden" name="sale_quote_and_other_service" class="sale_quote_and_other_service" value="<?php echo $final_total; ?>">
          <input type="text" autocomplete="off" class="form-control text-right sale_quote_and_other_service" disabled value="<?php echo number_format($final_total,2); ?>">
        </div>
      </div>
      <div class="row wrapper-sm bg-white">
        <div class="row col-sm-8">
          <div class="col-sm-4" style="padding-left:0;">
            <span class="">ภาษีมูลค่าเพิ่ม</span>
          </div>
          <div class="col-sm-8">
            <input type="hidden" name="mpercent_vat" class="" value="<?php echo $summary_percent_rate['percent_vat']; ?>">
            <input type="text" autocomplete="off" class="form-control input-s-sm text-center" value="<?php echo $summary_percent_rate['percent_vat']; ?>%" readonly>
          </div>
        </div>
        <div class="col-sm-2 text-center">&nbsp;</div>
        <div class="col-sm-2 text-center">
          <input type="hidden" name="vat" class="vat" value="<?php echo $vat; ?>">
          <input type="text" autocomplete="off" class="form-control text-right vat" disabled value="<?php echo number_format((float)$vat, 2); ?>" <?php if(!empty($summary_data) && !empty($summary_data['total_variant_price'])) { echo "style='border-color:red;'"; } ?>>
        </div>
      </div>
      <div class="row wrapper-sm ">
        <div class="row col-sm-8">
          <span>ราคาสุทธิหลังบวกภาษี</span>
        </div>
        <div class="col-sm-2 text-center">&nbsp;</div>
        <div class="col-sm-2 text-center">
          <input type="hidden" name="total" class="total" value="<?php echo $total_15; ?>">
          <input type="text" autocomplete="off" class="form-control text-right total" disabled value="<?php echo number_format((float)$total_15, 2); ?>" <?php if(!empty($summary_data) && !empty($summary_data['total_variant_price'])) { echo "style='border-color:red;'"; } ?>>
        </div>
      </div>
    </div>
<?php
  } 
?>
  <div class="panel-body bg-light">
    <div class="wrapper bg-light dker">
      <div class="row wrapper-sm">
        <div class="col-sm-8">
          <span class="h4">ราคาตั้งต้น</span>
        </div>
        <div class="col-sm-4 h5">
          <input type="hidden" name="bottom_price_per_person" class="bottom_price_per_person" value="<?php echo number_format((float)$final_total/$total_subgroup_staff, 2, '.', ''); ?>">
          ราคาต่อคน&nbsp;&nbsp;<input type="text" autocomplete="off" class="pull-right form-control text-right bottom_price_per_person" style="width:80%;" value="<?php echo number_format((float)$final_total/$total_subgroup_staff, 2); ?>" disabled>
        </div>
      </div>
      <div class="row wrapper-sm">
        <div class="col-sm-8 text-center h5">
          กำไร&nbsp;&nbsp;<input type="text" autocomplete="off" class="form-control text-center input-s-sm inline" readonly value="<?php echo $summary_percent_rate['percent_margin']; ?>">&nbsp;&nbsp;%
        </div>
        <div class="col-sm-4 h5">
          <input type="hidden" name="total_bottom_price" class="total_bottom_price" value="<?php echo $final_total; ?>">
          ราคารวม&nbsp;&nbsp;<input type="text" autocomplete="off" class="pull-right form-control  total_bottom_price text-right" style="width:80%; " value="<?php  echo number_format((float)$final_total, 2); ?>" disabled>
        </div>
      </div>
    </div>
    <div class="wrapper bg-light dker m-t-sm">
      <div class="row wrapper-sm">
        <div class="col-sm-8">
          <span class="h4">ราคาที่ปรับเปลี่ยน</span>
        </div>
        <div class="col-sm-4 h5">
          ราคาต่อคน&nbsp;&nbsp;<input type="text" autocomplete="off" name="variant_price_per_person" onkeypress="return isDouble(event)" class="pull-right form-control text-right variant_price_per_person" style="width:80%;" value="<?php if(!empty($summary_data) && !empty($summary_data['variant_price_per_person'])) { echo number_format((float)$summary_data['variant_price_per_person'], 2); } ?>">
        </div>
      </div>
      <div class="row wrapper-sm">
        <div class="col-sm-8 text-center h5">
          กำไร&nbsp;&nbsp;<input type="text" name="percent_margin" onkeypress="return isDouble(event)" autocomplete="off" class="form-control text-center input-s-sm inline percent_margin" value="<?php if(!empty($summary_data) && !empty($summary_data['percent_margin'])) { echo number_format((float)$summary_data['percent_margin'], 2, '.', ''); } ?>">&nbsp;&nbsp;%
        </div>
        <div class="col-sm-4 h5">
          ราคารวม&nbsp;&nbsp;<input type="text" autocomplete="off" name="total_variant_price" onkeypress="return isDouble(event)" class="pull-right form-control text-right total_variant_price" style="width:80%;" value="<?php if(!empty($summary_data) && !empty($summary_data['total_variant_price'])) { echo number_format((float)$summary_data['total_variant_price'], 2); } ?>">
        </div>
      </div>
    </div>
  <?php
    if (!empty($quotation_data) && $quotation_data['job_type'] == 'ZQT1') {
  ?>
    <div class="wrapper bg-light dker m-t-sm">
    <?php
      if (!empty($staff_arr)) {
        $count = 0; 
        foreach ($staff_arr as $employee_level_id => $level_value) {
        $level_total = ($staff_clear_total/$total_subgroup_staff)
            + ($social_security/$total_subgroup_staff)
            + ($equipment_total/$total_subgroup_staff)
            + ($equipment_clearjob_total/$total_subgroup_staff)
            + ($operation/$total_subgroup_staff)
            + ($margin/$total_subgroup_staff)
            + ($other_service_total/$total_subgroup_staff)
            + $total_level_share_benefit[$employee_level_id];

        if(!empty($summary_data)) { 
          $level_total += $summary_data['insurance_per_person'];
          $level_total -= $summary_data['maximum_discount_per_person'];
        }

        $level_total = number_format((float)$level_total, 2, '.', '');
    ?>
        <div class="row wrapper-sm">
          <?php
            if ($count == 0) {
          ?>
            <div class="col-sm-8">
              <span class="h4">ราคาเฉลี่ยต่อคนแต่ละระดับพนักงาน</span>
            </div>
          <?php
            } else {
          ?>
            <div class="col-sm-8">&nbsp;</div>
          <?php
            }
          ?>
          <div class="col-sm-4">
            <?php echo $level_value['title']; ?>&nbsp;&nbsp;<input type="text" autocomplete="off" class="pull-right form-control text-right employee_level_price" data-id="<?php echo $employee_level_id; ?>" style="width:80%;" value="<?php echo number_format((float)$level_total, 2); ?>" disabled>
          </div>
        </div>
  <?php
          $count++;
        }
      }
  ?> 
    </div>    
  <?php
    } //end if ZQT1

    //else if (!empty($quotation_data) && ($quotation_data['job_type'] == 'ZQT2' || $quotation_data['job_type'] == 'ZQT3')) {
  ?>


<?php
  }else{
?>

<!-- stat : div tab7 empty -->
<div class="col-sm-12 no-padd" style="padding-top:30px;">
  <section class="panel panel-default">
    <header class="panel-heading bg-danger lt no-border">
      <div class="clearfix">
        <span class="pull-left thumb-sm tx-white"><i class="fa fa-warning fa-3x "></i></span>
        <div class="clear margin-left-medium " style="padding-left:25px;">
          <div class="h3 m-t-xs m-b-xs text-white">
             ผิดพลาด : ไม่มีข้อมูล
           <!--  <i class="fa fa-circle text-white pull-right text-xs m-t-sm"></i> -->
          </div>
          <small class="text-muted h5">ใบสัญญายังไม่มีข้อมูล</small>
        </div>                
      </div>
    </header>
    <ul class="list-group no-radius alt">
       <li class="list-group-item" href="#">
       <!--  <span class="badge bg-info">16</span> -->
        <i class="fa fa-circle icon-muted"></i> 
          <span class="h5 margin-left-medium">ไม่มีข้อมูล ยอดขาย</span>
      </li> 
      
    </ul>
  </section>
</div>
<!-- end : div tab7 empty -->

<?php
  }
?>









<!-- form submit -->
<br>
<div class="form-group col-sm-12 ">
  <div class="pull-right">
    <a href="<?php echo site_url($this->page_controller.'/listview/'.$this->quotation_id); ?>"  class="btn btn-info" style="width:120px;"> <?php echo freetext('back'); ?></a>
   
  </div>
</div>
<!-- end : form submit -->

</div><!-- end : class div_detail -->


          











