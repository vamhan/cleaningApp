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
                  <?=form_open('__cms_data_manager/plant_management');?>
                  <div class="col-sm-4 m-t-xs m-b-xs">
                    <div class="input-group search datagrid-search">
                      <input type="text" autocomplete="off" class="input-sm form-control" name="search" id="search" placeholder="Search">
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
              <th class="table-head">Plant Code</th>
              <th class="table-head">Plant Name</th>
              <th class="table-head">Doc Code</th>
              <th class="table-head"></th>
            </tr>
          </thead>
          <tbody>
          <?php
            if (!empty($plant_list)) {
              foreach ($plant_list as $key => $obj) {
          ?>
              <tr>
                <td><?php echo $obj['plant_code']; ?></td>
                <td><?php echo $obj['plant_name']; ?></td>
                <td><?php echo $obj['doc_code']; ?></td>
                <td class="text-right">
                  <a href="#" class="btn btn-default" data-toggle="modal" data-target="#edit_plant_<?php echo $obj['plant_code'] ?>"><i class="fa fa-pencil"></i></a>
                </td>
              </tr>
          <?php
              }
            } else {
          ?>
              <tr><td class="text-center" colspan="2">Empty</td></tr>
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
