<!-- start : content -->
<section class="vbox">
  <section class="scrollable padder">
    <section class="panel panel-default">
      <header class="panel-heading">
        <?php echo $this->page_title; ?>                  
      </header>
      <div class="panel-body">
        <?php
          if (!empty($module_list)) {

            foreach ($module_list as $module) {
        ?>
            <div class="col-sm-12 m-t-sm">
              <div class="dd category_list" id="category_list_<?php echo $module['id']; ?>" data-url="<?php echo my_url('__cms_data_manager/reorder_category'); ?>">
                <ol id="root" class="dd-list">
                  <li class="dd-item" id="module_<?php echo $module['id']; ?>" data-id="<?php echo $module['id']; ?>">                    
                    <div class="dd3-content row bg-light dker">
                      <div class="col-sm-1 pull-right text-right">
                        <a href="#" data-module-id="<?php echo $module['id']; ?>" data-parent-id="0" title="create" class="create_category_child_btn btn btn-default btn-xs" data-toggle="modal" data-target="#create_category"><i class="fa fa-plus" style="padding:2px;"></i></a>
                      </div>
                      <div class="col-sm-9 font-bold" style="font-size:15px;">
                        <?php echo $module['module_name']; ?>
                      </div>
                    </div>
                    <?php
                      if (!empty($module['template_html'])) {
                        echo $module['template_html'];
                      }
                    ?>
                  </li>
                </ol>
              </div>
            </div>
        <?php
            }
          } else {
        ?>
            <div class="col-sm-12 well m-t-md"><?php echo freetext('empty_module'); ?></div>
        <?php
          }
        ?>
      </div>
    </section>
  </section>
</section>
<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>        
