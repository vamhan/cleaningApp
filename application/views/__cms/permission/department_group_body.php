<!-- start : content -->
<section class="vbox">
  <section class="scrollable padder">
    <section class="panel panel-default">
      <header class="panel-heading">
        <?php echo $this->page_title; ?>                  
      </header>
      <div class="table-responsive">
        <table id="group_permission_table" class="table datagrid m-b-sm" style="overflow-y:auto;">
          <tbody>
          <?php                      
          if(!empty($result)){
            $content = $result['list']; 
            $current = "";
            foreach ($content as $key => $value) {
              if ($current != $value['deptname']) {
          ?>
                <tr data-toggle="collapse" data-target=".<?php echo $value['deptname']; ?>" class="accordion-toggle bg-light">
                  <th colspan="2" class="b-b b-light"><?php echo $value['deptname']; ?></th>
                  <th class="b-b b-light text-right">
                    <a href="#" class="btn btn-default btn-sm"><i class="fa fa-pencil"></i></a>
                    <a href="#" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
                    <a href="#" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></a>
                  </th>
                </tr>
          <?php
                $current = $value['deptname'];
              }
          ?>

            <tr class="<?php echo $value['deptname']; ?> collapse">
              <td class="table-division" data-property="groupname"><?php echo $value['groupname']; ?></td><!-- <START : ACTION SET> -->
              <td colspan="2" class="text-right">
                <a href="#" data-cms-action="update" title="<?php echo freetext('edit'); ?>" data-toggle="modal" data-target="#edit_department_group_<?php echo $value['dept_id']."_".$value['group_id']; ?>" class="btn btn-default btn-xs"><i class="fa fa-pencil"></i></a>
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
