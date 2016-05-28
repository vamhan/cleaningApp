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
                  <form action="<?php echo site_url('__cms_data_manager/gps_log_list'); ?>" method="post" id="filter_form">
                  <?php
                    $p = $this->input->post();
                  ?>
                  <input type="hidden" name="sort" value="<?php if (empty($p['sort']) || $p['sort'] == 'desc') { echo 'asc'; } else { echo 'desc'; } ?>">
                  <div class="col-sm-3 m-t-xs m-b-xs">
                    <input type="text" autocomplete="off" class="input-sm form-control" name="from_date" id="from_date" value="<?php echo $p['from_date']; ?>" placeholder="From Date">
                  </div>
                  <div class="col-sm-3 m-t-xs m-b-xs">
                    <input type="text" autocomplete="off" class="input-sm form-control" name="to_date" id="to_date" value="<?php echo $p['to_date']; ?>" placeholder="To Date">
                  </div>
                  <div class="col-sm-6 m-t-xs m-b-xs">
                    <div class="input-group search datagrid-search">
                      <input type="text" autocomplete="off" class="input-sm form-control" name="search" id="search" value="<?php echo $p['search']; ?>" placeholder="Search">
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
              <th class="table-head" width="30%">วันที่</th>
              <th class="table-head" width="20%">เวลา <a class="sort_btn" href="#" data-sort="<?php if (empty($p['sort']) || $p['sort']=="desc") { echo 'asc'; } else { echo 'desc'; } ?>"><i class="fa fa-sort"></i></a></th>
              <th class="table-head" width="25%">ชื่อผู้ใช้</th>
              <th class="table-head " width="20%">Gps</th>
              <th class="table-head text-center" width="15%">สถานที่</th>              
            </tr>
          </thead>
          <tbody>
          <?php
          if(!empty($gps_list)){
            foreach ($gps_list as $key => $value) {
          ?>
            <tr>
              <td><?php echo date('d.m.Y', strtotime($value['create_datetime'])); ?></td>
              <td><?php echo date('H:i:s', strtotime($value['create_datetime'])); ?></td>
              <td><?php echo $value['user_firstname'].' '.$value['user_lastname']; ?></td>
              <td><?php echo $value['latitude'].','.$value['longitude']; ?></td>
              <td class="text-center"><a target="_blank" href="http://maps.google.com/maps?q=<?php echo $value['latitude'].','.$value['longitude'] ?>"><i class="fa fa-globe"></i></a></td>
            </tr>
          <?php
            }
          }else{
            echo "<tr><td colspan='5' class='h6'>ไม่มีข้อมูล GPS </td></tr>";
          }//end else
          ?>
          </tbody>
        </table>
      </div>
    </section>
  </section>
</section>
<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>        
