<section class="vbox">
  <section class="scrollable padder">
    <section class="panel panel-default">
      <header class="panel-heading">
        <?php echo $this->page_title; ?>                  
      </header>
      <div class="panel-body">
        <table id="user_permission_table" class="table table-striped datagrid m-b-sm">
          <thead>
            <tr>
              <th colspan="8">
                <div class="row">
                  <?=form_open('__cms_permission/department_module_list');?>
                  <div class="col-sm-12 m-t-xs m-b-xs">
                    <div class="input-group search datagrid-search">
                      <input type="text" class="input-sm form-control" name="search" id="search" placeholder="<?php echo freetext('search'); ?>">
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
              <th class="table-head"><?php echo freetext('module_name'); ?></th>
              <th class="table-head"></th>
            </tr>
          </thead>
          <tbody>
          <?php                      
          if(!empty($module_list)){  
            foreach ($module_list as $key => $value) {
          ?>
            <tr>
              <td class="table-division"><?php echo freetext($value['module_name']); ?></td>
              <!-- <START : ACTION SET> -->
              <td class="text-right">
                <a href="#" title="<?php echo freetext('edit'); ?>" data-toggle="modal" data-target="#edit_module_<?php echo $value['id']; ?>" class="btn btn-default btn-xs"><i class="fa fa-pencil"></i></a>                
                <a href="#" title="<?php echo freetext('department_mapping'); ?>" class="btn btn-default btn-xs mapping_btn" data-id="<?php echo $value['id']; ?>" data-txt="<?php echo freetext($value['module_name']); ?>"><i class="fa fa-sitemap"></i></a>
                <?php if( $this->session->userdata('username') == 'admin_bossup'){ ?>
                <a href="#" title="<?php echo freetext('delete'); ?>" data-id="<?php echo $value['id']; ?>" data-txt="<?php echo freetext($value['module_name']); ?>" class="btn btn-default btn-xs del_module"><i class="fa fa-trash-o"></i></a> 
                <?php } ?>
              </td>
              <!-- <END : ACTION SET> -->

            </tr>
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
