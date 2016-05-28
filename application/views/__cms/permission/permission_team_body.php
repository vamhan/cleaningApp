<!-- start : content -->
<section class="vbox">
  <section class="scrollable padder">
    <section class="panel panel-default">
      <header class="panel-heading">
        <?php echo $this->page_title; ?>                  
      </header>
      <div class="table-responsive">
        <table id="group_permission_table" class="table table-striped datagrid m-b-sm">
          <thead>
            <tr>
              <th colspan="7">
                <div class="row">
                  <div class="col-sm-8 m-t-xs m-b-xs pull-right text-right">
                    <div class="input-group search datagrid-search">
                      <div class="input-group-btn">
                        <button class="btn btn-primary btn-sm" data-cms-action="create" data-toggle="modal" data-target="#create_permission_team_modal"><i class="fa fa-plus-circle"></i>&nbsp;&nbsp;<?php echo freetext('create_team_button'); ?></button>
                      </div>
                    </div>
                  </div>
                  <?=form_open('__cms_permission/permission_area_list');?>
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
              <th>Department</th>
              <th>Title</th>
              <th>&nbsp;</th>
            </tr>      
          </thead>
          <tbody>
          <?php                      
          if(!empty($team_list)) {
            foreach ($team_list as $key => $value) {
          ?>
              <tr data-toggle="collapse" data-target=".area_<?php echo $value['id']; ?> " class="accordion-toggle" style="cursor:pointer;">
                <td><?php echo $value['dept_name']; ?></td>
                <td><?php echo $value['title']; ?></td>
                <td class="text-right">
                  <a href="#" class="btn btn-sm btn-default m-r-sm" data-toggle="modal" data-target="#edit_permission_team_<?php echo $value['id']; ?>">
                    <i class="fa fa-pencil"></i>
                  </a>
                  <a href="#" class="btn btn-sm btn-default del_team_btn" data-title="<?php echo $value['title']; ?>">
                    <form class="del_team_form" method="post" action="<?php echo base_url().'index.php/__cms_permission/permission_team_delete' ?>">
                      <input type="hidden"  name="id" value="<?php echo $value['id']; ?>">
                    </form>
                    <i class="fa fa-trash-o"></i>
                  </a>
                </td>
              </tr>
          <?php
            if (!empty($value['team_list'])) {
              foreach ($value['team_list'] as $key2 => $team) {
          ?>
              <tr class="area_<?php echo $value['id']; ?> collapse">
                <td colspan="2">&nbsp;</td>
                <td class="text-right">
                  <span class="m-r-md"><?php echo $team['code']; ?></span>
                  <a href="#" class="btn btn-sm btn-default m-r-sm group_member_btn" data-team="<?php echo $value['id']; ?>" data-code="<?php echo $team['code']; ?>">
                    <i class="fa fa-users"></i>
                  </a>
                </td>
              </tr>
          <?php
              }
            } 
          ?>
          <?php
          ?>
          <?php 
            }
          }
          ?>
          </tbody>
        </table>
      </div>
    </section>
  </section>
</section>
<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>        
