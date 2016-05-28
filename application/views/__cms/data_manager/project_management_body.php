<!-- start : content -->
<section class="vbox">
  <section class="scrollable padder">
    <section class="panel panel-default">
      <header class="panel-heading">
        <?php echo $this->page_title; ?>                  
      </header>
      <div class="table-responsive">
        <table id="user_permission_table" class="table table-striped datagrid m-b-sm">
          <thead>
            <tr>
              <th colspan="9">
                <div class="row">
                  <div class="col-sm-8 m-t-xs m-b-xs pull-right text-right">
                    <div class="input-group search datagrid-search">
                      <!-- <div class="input-group-btn">
                        <button class="btn btn-primary btn-sm" data-cms-action="create" data-toggle="modal" data-target="#create_holiday_year"><i class="fa fa-plus-circle"></i>&nbsp;&nbsp;<?php echo freetext('create_new_holiday'); ?></button>
                      </div> -->
                    </div>
                  </div>
                  <?=form_open('__cms_data_manager/quatationStaff_management');?>
                  <div class="col-sm-4 m-t-xs m-b-xs">
                    <div class="input-group search datagrid-search">
                      <input type="text" autocomplete="off" class="input-sm form-control" name="search" id="search" onkeypress="return isInt(event)" placeholder="ค้นหา จากเลขใบเสนอราคา">
                      <div class="input-group-btn">
                        <button class="btn btn-default btn-sm" ><i class="fa fa-search"></i></button>
                      </div>                          
                    </div>
                  </div>
                  <?=form_close();?>                      
                </div>
              </th>
            </tr>
            <tr>
              <th class="table-head text-center">เลขที่สัญญา</th>
              <th class="table-head text-center">เลขที่ใบเสนอราคา</th>
              <th class="table-head text-center">รหัสหน่วยงาน</th>
              <th class="table-head text-center">สถานที่ปฏิบัติการ</th>  
              <th class="table-head text-center">สถานะ</th>   
              <th class="table-head text-center">วันเริ่มโครงการ</th>
              <th class="table-head text-center">วันจบโครงการ</th>  
              <th class="table-head text-center">วันที่ยกเลิก</th>                
              <th class="table-head"></th>
            </tr>
          </thead>
          <tbody>
          <?php
          // echo "<pre>";
          // print_r($quotation);

            if (!empty($quotation)) {
              foreach ($quotation as $key => $value) {

                // $this->db->select('sap_tbm_ship_to.ship_to_name');
                // $this->db->where('id', $value['ship_to_id']);
                // $query = $this->db->get('sap_tbm_ship_to');          
                // $temp_shipto = $query->row_array();  
          ?>
              <tr>
                <td width="100" ><?php echo $value['contract_id']; ?></td>
                <td width="120" class="text-center"><?php echo $value['quotation_id']; ?></td>
                <td width="120" class="text-center"><?php echo $value['ship_to_id']; ?></td>
                <td width="250"><?php echo $value['ship_to_name']; ?></td>
                <td width="70"  class="text-center"><?php echo $value['status']?></td>
                <td width="120" class="text-center">
                 <?php print common_easyDateFormat($value['project_start']);?>
                </td> 
                <td width="120" class="text-center">
                 <?php print common_easyDateFormat($value['project_end']);?>
                </td> 
                <td width="100" class="text-center 
                <?php if($value['is_abort_date']!="0000-00-00" && !empty($value['is_abort_date']) ){ echo "tx-red"; } ?>
                ">
                 <?php if($value['is_abort_date']!="0000-00-00" && !empty($value['is_abort_date']) ){ print common_easyDateFormat($value['is_abort_date']); }else{ echo "-"; } ?>
                </td>                  
                <td class="text-right">
                  <a href="#" class="btn btn-default btn-edit-project" id="<?php echo $value['quotation_id'] ?>"
                    data-contract="<?php echo $value['contract_id'] ?>"
                    data-title="<?php echo $value['ship_to_name'] ?>"
                    data-shipto="<?php echo $value['ship_to_id'] ?>"
                    data-status="<?php echo $value['status'] ?>"
                    data-start="<?php echo $value['project_start'] ?>"
                    data-end="<?php echo $value['project_end'] ?>"
                    data-abort="<?php echo $value['is_abort_date'] ?>"
                    data-type="<?php echo $value['job_type'] ?>"  
                  ><i class="fa fa-pencil"></i></a>
                  <!-- <a href="#" class="btn btn-default"><i class="fa fa-trash-o"></i></a> -->
                </td>
              </tr>
          <?php
              }
            } else {
          ?>
              <tr><td class="text-center h6" colspan="3">ไม่มีข้อมูล</td></tr>
          <?php
            }
          ?>
          </tbody>
        </table>
      </div>
    </section>
  </section>
</section>
<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>        
