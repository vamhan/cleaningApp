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
                      <div class="input-group-btn">
                        <button class="btn btn-primary btn-sm" data-cms-action="create" data-toggle="modal" data-target="#create_holiday_year"><i class="fa fa-plus-circle"></i>&nbsp;&nbsp;<?php echo freetext('create_new_holiday'); ?></button>
                      </div>
                    </div>
                  </div>
                  <?=form_open('__cms_data_manager/holiday_management');?>
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
              <th class="table-head">ปี</th>
              <th class="table-head"></th>
            </tr>
          </thead>
          <tbody>
          <?php
            if (!empty($year_list)) {
              foreach ($year_list as $key => $year_obj) {
          ?>
              <tr>
                <td><?php echo $year_obj['year']; ?></td>
                <td class="text-right">
                  <a href="#" class="btn btn-default" data-toggle="modal" data-target="#edit_holiday_year_<?php echo $year_obj['year'] ?>"><i class="fa fa-pencil"></i></a>
                  <a href="#" class="btn btn-default"><i class="fa fa-trash-o"></i></a>
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
