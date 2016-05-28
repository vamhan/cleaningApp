<!-- start : content -->
<section class="vbox">
    <section class="panel panel-default">
      <header class="panel-heading">
        <?php echo $this->page_title; ?>                  
      </header>
      <div class="panel-body">
        <section class="panel panel-default">
          <header class="panel-heading bg-light">
            <?php
              if (!empty($group_list)) {
            ?>
              <ul class="nav nav-tabs nav-justified">
              <?php
                foreach ($group_list as $key => $group) {
                  $active = '';
                  if ( (empty($tab) && $key == 0) || (!empty($tab) && $tab == $group['id']) ) {
                    $active = 'active';
                  }
              ?>
                  <li class="<?php echo $active; ?>"><a href="#group_<?php echo $group['id']; ?>" data-toggle="tab"><?php echo $group['title']; ?></a></li>
              <?php
                }
              ?>
              </ul>
            <?php
              }
            ?>
          </header>
          <div class="panel-body">
            <div class="tab-content">
              <?php
                foreach ($group_list as $key => $group) {
                  $active = '';
                  if ( (empty($tab) && $key == 0) || (!empty($tab) && $tab == $group['id']) ) {
                    $active = 'active';
                  }
              ?>                
                <div class="tab-pane <?php echo $active; ?>" id="group_<?php echo $group['id']; ?>" style="max-height: 560px;overflow-y: auto;">
                  <form method="post" action="<?php echo site_url('__cms_permission/user_position_list/'.$group['id']); ?>">
                    <div class="col-sm-12 m-t-xs m-b-sm">
                      <div class="input-group search datagrid-search">
                        <?php
                          $search = '';
                          $p = $this->input->post();
                          if (!empty($p['search']) && $active=="active") {
                            $search = $p['search'];
                          }
                        ?>
                        <input type="text" class="input-sm form-control" name="search" id="search" placeholder="ค้นหา" value="<?php echo $search; ?>">
                        <div class="input-group-btn">
                          <button class="btn btn-default btn-sm"><i class="fa fa-search"></i></button>
                        </div>                          
                      </div>
                    </div>
                  </form>
                <?php
                  if (!empty($position_list)) {
                ?>
                <form method="post" action="<?php echo site_url('__cms_permission/save_position/'.$group['id']); ?>">
                  <table class="table table-striped m-b-none" data-id="<?php echo $group['id']; ?>">
                    <thead>
                      <tr>
                        <th><input type="checkbox" class="check_all" ></th>     
                        <th>Department</th>
                        <th>Position</th>                   
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ($active == 'active') {
                      foreach ($tab_result as $key => $position) {
                        $disabled = "";
                        if (!empty($position['group_id'])) {
                          $disabled = " disabled";
                        }

                        $checked = "";
                        if ($position['group_id'] == $group['id']) {
                          $checked = " checked";
                          $disabled = "";
                        }                    
                    
                    ?>
                      <tr>
                        <td><?php if (empty($disabled)) { ?> <input type="checkbox" name="group_<?php echo $group['id'] ?>[]" value="<?php echo $position['id']; ?>"<?php echo $checked; ?>> <?php } else { ?> <a href="#" title="<?php echo $position['group_name']; ?>"><i class="fa fa-info-circle text-info"></i></a> <?php } ?></td>     
                        <td><?php echo $position['dept_name']; ?></td>
                        <td><?php echo $position['title']; ?></td>
                      </tr>
                    <?php
                      }
                    } else {
                      foreach ($position_list as $key => $position) {
                        $disabled = "";
                        if (!empty($position['group_id'])) {
                          $disabled = " disabled";
                        }

                        $checked = "";
                        if ($position['group_id'] == $group['id']) {
                          $checked = " checked";
                          $disabled = "";
                        }                    
                    
                    ?>
                      <tr>
                        <td><?php if (empty($disabled)) { ?> <input type="checkbox" name="group_<?php echo $group['id'] ?>[]" value="<?php echo $position['id']; ?>"<?php echo $checked; ?>> <?php } else { ?> <a href="#" title="<?php echo $position['group_name']; ?>"><i class="fa fa-info-circle text-info"></i></a> <?php } ?></td>     
                        <td><?php echo $position['dept_name']; ?></td>
                        <td><?php echo $position['title']; ?></td>
                      </tr>
                    <?php
                      }
                    }
                    ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <td colspan="3" class="text-right">
                          <a href="#" class="btn btn-primary save_btn"><i class="fa fa-save"></i>&nbsp;<?php echo freetext('save'); ?></a>
                        </td>
                      </tr>
                    </tfoot>
                  </table>
                </form>
                <?php
                  } else {
                ?>
                    <div class="wrapper text-center">Empty Position</div>
                <?php
                  }
                ?>
                </div>
              <?php
                }
              ?>
            </div>
          </div>
        </section>
      </div>
    </section>
  </section>
</section>
<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>       