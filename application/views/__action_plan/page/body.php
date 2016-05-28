<section id="content" style="height: 100%;">
  <section class="hbox stretch">          
    <!-- .aside -->
    <aside>
      <section class="vbox">
        <section class="scrollable">
          <section class="panel panel-default">
          <?php 
            // echo "<pre>";
            // print_r($event_category); 
          ?>
            <header class="panel-heading bg-light clearfix">
              <div class="btn-group pull-right" data-toggle="buttons">
                <label class="btn btn-sm btn-bg btn-default active" id="monthview">
                  <input type="radio" name="options">รายเดือน
                </label>
                <label class="btn btn-sm btn-bg btn-default" id="weekview">
                  <input type="radio" name="options">รายสัปดาห์
                </label>
                <label class="btn btn-sm btn-bg btn-default" id="dayview">
                  <input type="radio" name="options">รายวัน
                </label>
              </div>
              <div class="col-sm-10">
                <select id="sel_month" class="form-control col-sm-3" style="width:25%; margin:20px 5px; border-radius:4px;">
                  <option value="1">มกราคม</option>
                  <option value="2">กุมภาพันธ์</option>
                  <option value="3">มีนาคม</option>
                  <option value="4">เมษายน</option>
                  <option value="5">พฤษภาคม</option>
                  <option value="6">มิถุนายน</option>
                  <option value="7">กรกฎาคม</option>
                  <option value="8">สิงหาคม</option>
                  <option value="9">กันยายน</option>
                  <option value="10">ตุลาคม</option>
                  <option value="11">พฤศจิกายน</option>
                  <option value="12">ธันวาคม</option>
                </select>
                <select id="sel_year" class="form-control col-sm-3" style="width:15%; margin:20px 5px; border-radius:4px;">
                <?php
                  for ($year = 1900; $year < date('Y')+10; $year++) {
                    $selected = "";
                    if ( $year == date('Y') ){
                      $selected = "selected";
                    }
                ?>
                  <option value="<?php echo $year;?>" <?php echo $selected;?>><?php echo $year;?></option>
                <?php
                  }
                ?>
                </select>
                <ul class="pagination pagination-md inline"> 
                  <li><a id="prev_month" href="#" style="color:black;"><i class="fa fa-chevron-left"></i></a></li>
                  <li><a id="next_month" href="#" style="color:black;"><i class="fa fa-chevron-right"></i></a></li>                  
                </ul>
              </div>
            </header>
            <div class="calendar" id="calendar"></div>
          </section>
        </section>
      </section>
    </aside>
    <!-- /.aside -->
    <!-- .aside -->
    <aside class="aside-lg b-l">
      <div class="padder filter">
        <div class="m-t-md">
            <input type="text" autocomplete="off" class="form-control filter_search" placeholder="ค้นหา">
        </div>
        <div class="m-t-md">
            <select class="form-control filter_ship_to">
              <option value='0'><?php echo freetext('ship_to'); ?></option>
              <?php
                if (!empty($shipto_list)) {
                  foreach ($shipto_list as $key => $value) {
              ?>
                    <option value='<?php echo $value['id'] ?>'><?php echo freetext($value['name1']); ?></option>
              <?php
                  }
                }
              ?>
            </select>
        </div>
        <div class="m-t-md">
            <select class="form-control filter_department">
              <option value='0'><?php echo freetext('department'); ?></option>
              <?php
                foreach ($department_list as $department) {
              ?>
                  <option value="<?php echo $department['id']; ?>"><?php echo $department['title']; ?></option>
              <?php
                }
              ?>
            </select>
        </div>
        <div class="m-t-md">
            <select class="form-control filter_employee">
              <option value='0'><?php echo freetext('employee'); ?></option>
              <?php
                foreach ($employee_list as $employee) {
              ?>
                  <option value="<?php echo $employee['employee_id']; ?>" data-dept="<?php echo $employee['department']; ?>"><?php echo $employee['user_firstname'].' '.$employee['user_lastname']; ?></option>
              <?php
                }
              ?>
            </select>
        </div>
        <div class="m-t-md">
            <select class="form-control filter_category">
              <option value='0'><?php echo freetext('event_category'); ?></option> 
              <?php
                  $permission = $this->permission;
                  $visit_module_id = 4;
                  if (array_key_exists($visit_module_id, $permission) && array_key_exists('view', $permission[$visit_module_id])) {
              ?>
                    <option value='<?php echo $visit_module_id; ?>'><?php echo freetext('customer_visitation'); ?></option>
              <?php
                  }

                  $fix_claim_id = 9;
                  if (array_key_exists($fix_claim_id, $permission) && array_key_exists('view', $permission[$fix_claim_id])) {
              ?>
                    <option value='<?php echo $fix_claim_id; ?>'><?php echo freetext('fix_and_cliam'); ?></option>
              <?php
                  }
              ?>

               <?php                  
                  $asset_tracker = 2;
                  if (array_key_exists($asset_tracker, $permission) && array_key_exists('view', $permission[$asset_tracker])) {
              ?>
                    <option value='<?php echo $asset_tracker; ?>'><?php echo freetext('asset_tracker'); ?></option>
              <?php
                  }
              ?>

               <?php                  
                  $quality_assurance = 6;
                  if (array_key_exists($quality_assurance, $permission) && array_key_exists('view', $permission[$quality_assurance])) {
              ?>
                    <option value='<?php echo $quality_assurance; ?>'><?php echo freetext('quality_assurance'); ?></option>
              <?php
                  }
              ?>

              <?php                  
                  $employee_tracker = 7;
                  if (array_key_exists($employee_tracker, $permission) && array_key_exists('view', $permission[$employee_tracker])) {
              ?>
                    <option value='<?php echo $employee_tracker; ?>'><?php echo freetext('employee_tracker'); ?></option>
              <?php
                  }
              ?>

              <?php                  
                  $clear_job = 12;
                  if (array_key_exists($clear_job, $permission) && array_key_exists('view', $permission[$clear_job])) {
              ?>
                    <option value='<?php echo $clear_job; ?>'><?php echo freetext('clear_job'); ?></option>
              <?php
                  }
              ?>

              <?php
                  //foreach ($event_category as $key => $value) {
              ?>
                   <!--  <option value='<?php //echo $value['id'] ?>'><?php //echo freetext($value['module_name']); ?></option> -->
              <?php
                  //}
              ?>             
            </select>          
        </div>
        <div class="m-t-md">
            <select class="form-control filter_status">
              <option value='0'><?php echo freetext('status'); ?></option>
              <option value='plan'>Plan</option>
              <option value='unplan'>Unplan</option>
            </select>
        </div>
      </div>
    </aside>
    <!-- /.aside -->
  </section>
  <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
</section>