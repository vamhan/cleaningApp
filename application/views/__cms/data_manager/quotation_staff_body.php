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
              <th colspan="7">
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
              <th class="table-head">เลขที่ใบเสนอราคา</th>
              <th class="table-head">รายการใบเสนอราคา</th>
              <th class="table-head">สร้างโดย</th>   
              <th class="table-head">สถานะ</th>                   
              <th class="table-head"></th>
            </tr>
          </thead>
          <tbody>
          <?php
          // echo "<pre>";
          // print_r($quotation);

            if (!empty($quotation)) {
              foreach ($quotation as $key => $value) {

                $this->db->select('tbt_user.user_firstname,tbt_user.user_lastname');
                $this->db->where('employee_id', $value['project_owner_id']);
                $query = $this->db->get('tbt_user');          
                $tempuser = $query->row_array();  
          ?>
              <tr>
                <td width="200"><?php echo $value['id']; ?></td>
                <td width="500"><?php echo $value['title']; ?></td>
                <td><?php echo $tempuser['user_firstname'].' '.$tempuser['user_lastname']; ?></td>
                <td><?php echo $value['status']; ?></td>                 
                <td class="text-right">
                  <a href="#" class="btn btn-default btn-edit-staff" id="<?php echo $value['id'] ?>"
                    data-title="<?php echo $value['title'] ?>"  data-user="<?php echo $tempuser['user_firstname'].' '.$tempuser['user_lastname'] ?>" 
                    data-number="<?php echo  $value['project_owner_id'] ?>"  
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
