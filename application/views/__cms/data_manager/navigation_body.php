<!-- start : content -->
<section class="vbox">
  <section class="scrollable padder">
    <section class="panel panel-default"> 
      <header class="panel-heading bg-light"> 
        <?php echo $this->page_title; ?>   
      </header> 
      <ul class="nav nav-tabs nav-justified"> 
        <li class="active"><a href="#frontend" data-toggle="tab">Frontend</a></li> 
        <li class=""><a href="#backend" data-toggle="tab">Backend</a></li> 
      </ul> 
      <div class="panel-body"> 
        <div class="tab-content"> 
          <div class="tab-pane active" id="frontend">
            <div class="navigation_panel col-sm-12 m-t-xl">   
              <div class="dd panel panel-default" id="front_nav_list" data-url="<?php echo my_url('__cms_data_manager/update_nav_list'); ?>">
                <div class="header">
                  <div class="text-right pull-right">
                    <a href="#" title="<?php echo freetext('new_group'); ?>" data-cms-action="create" data-toggle="modal" data-target="#create_front_navigation_group_modal" class="btn btn-sm btn-primary"><i class="fa fa-plus icon"></i></a>
                  </div>
                  <div class="col-sm-9">
                    <h4>Navigation panel</h4>
                  </div>
                </div>
                <ol class="dd-list">
                <?php
                  if (!empty($navigation['frontend'])) {
                    foreach ($navigation['frontend'] as $group) {
                ?>
                    <li class="dd-item" data-level="1" data-id="<?php echo $group->group_id; ?>" data-name="<?php echo $group->group_name; ?>" data-page-type="<?php echo $group->page_type; ?>" data-url="<?php echo $group->url; ?>">
                        <div class="dd-handle row">
                          <div class="col-sm-4 text-right pull-right">
                            <a href="#" title="<?php echo freetext('delete'); ?>" class="del_btn" data-id="<?php echo $group->group_id; ?>"><i class="fa fa-trash-o icon"></i></a>
                          </div>
                          <div class="col-sm-7">
                            <?php echo $group->group_name; ?>
                          </div>
                        </div>
                <?php
                        if (!empty($group->pages)) {
                ?>
                          <ol class="dd-list">
                <?php
                          foreach ($group->pages as $page) {
                ?>
                            <li class="dd-item" data-level="2" data-id="<?php echo $page->id; ?>">
                              <div class="dd-handle row">
                                <div class="col-sm-4 text-right pull-right">
                                  <a href="#" title="<?php echo freetext('delete'); ?>" class="del_page_btn" data-id="<?php echo $page->id; ?>" data-priority="<?php echo $page->priority; ?>"><i class="fa fa-trash-o icon"></i></a>
                                </div>
                                <div class="col-sm-7">
                                  <?php echo $page->page_title; ?>
                                </div>
                              </div>
                            </li>
                <?php
                          }
                ?>
                          </ol>
                <?php
                        }
                ?>
                    </li>
                <?php
                    }
                  }
                ?>
                </ol>
              </div>
              <div class="dd panel panel-default" id="front_page_list">
                <div class="header">
                  <div class="col-sm-12">
                    <h4>Page list</h4>
                  </div>
                </div>
                <ol class="dd-list">
                <?php
                  if (!empty($page_list['frontend'])) {
                    foreach ($page_list['frontend'] as $page) {
                ?>
                    <li class="dd-item" data-id="<?php echo $page->id; ?>">
                        <div class="dd-handle"><?php echo $page->page_title; ?></div>
                    </li>
                <?php
                    }
                  }
                ?>
                </ol>
              </div>   
            </div>
          </div>  
          <div class="tab-pane" id="backend">
            <div class="navigation_panel col-sm-12 m-t-xl">
              <div class="dd panel panel-default" id="back_nav_list" data-url="<?php echo my_url('__cms_data_manager/update_nav_list'); ?>">
                <div class="header">
                  <div class="text-right pull-right">
                    <a href="#" title="<?php echo freetext('new_group'); ?>" data-cms-action="create" data-toggle="modal" data-target="#create_back_navigation_group_modal" class="btn btn-sm btn-primary"><i class="fa fa-plus icon"></i></a>
                  </div>
                  <div class="col-sm-9">
                    <h4>Navigation panel</h4>
                  </div>
                </div>
                <ol class="dd-list">
                <?php
                  if (!empty($navigation['backend'])) {
                    foreach ($navigation['backend'] as $group) {
                ?>
                    <li class="dd-item" data-level="1" data-id="<?php echo $group->group_id; ?>" data-name="<?php echo $group->group_name; ?>">
                        <div class="dd-handle"><?php echo $group->group_name; ?></div>
                <?php
                        if (!empty($group->pages)) {
                ?>
                          <ol class="dd-list">
                <?php
                          foreach ($group->pages as $page) {
                ?>
                            <li class="dd-item" data-level="2" data-id="<?php echo $page->id; ?>"><div class="dd-handle"><?php echo $page->page_title; ?></div></li>
                <?php
                          }
                ?>
                          </ol>
                <?php
                        }
                ?>
                    </li>
                <?php
                    }
                  }
                ?>
                </ol>
              </div>
              <div class="dd panel panel-default" id="back_page_list">
                <div class="header">
                  <div class="col-sm-12">
                    <h4>Page list</h4>
                  </div>
                </div>
                <ol class="dd-list">
                <?php
                  if (!empty($page_list['backend'])) {
                    foreach ($page_list['backend'] as $page) {
                ?>
                    <li class="dd-item" data-id="<?php echo $page->id; ?>">
                        <div class="dd-handle"><?php echo $page->page_title; ?></div>
                    </li>
                <?php
                    }
                  }
                ?>
                </ol>
              </div>      
            </div>
          </div> 
        </div> 
      </div> 
    </section>
  </section>
</section>

<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>    