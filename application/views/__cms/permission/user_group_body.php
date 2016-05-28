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
                        <button class="btn btn-primary btn-sm" data-cms-action="create" data-toggle="modal" data-target="#create_group"><i class="fa fa-plus-circle"></i>&nbsp;&nbsp;<?php echo freetext('create_group_btn'); ?></button>
                      </div>
                    </div>
                  </div>
                  <?=form_open('__cms_permission/group_list');?>
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
              <?php if(!empty($config['visible_column']))
              { 
                $visible_col_name = array();
                $th = '';
                foreach ($config['visible_column'] as $key => $value) {
                  if ($key != 'id') {
                    $th .= '<th data-property="'.$value['name'].'" class="table-head">'.$value['label'].'</th>';
                    array_push($visible_col_name, $value['name']);
                  } else {
                    $th .= '<th class="table-head"></th>';
                  }
                }//end foreach
              }
              if(!empty($th)){
                $th .= '<th class="table-head"></th>';
              }
              echo $th;
              ?>
            </tr>
          </thead>
          <tbody>
          <?php                      
          if(!empty($result)){
            $content = $result['list'];                  
            foreach ($content as $key => $value) {
          ?>
            <tr>
              <td><input type="checkbox" name="post[]" value="<?php echo $value['id'] ?>"></td>
              <?php //Rendering value 
              if(!empty($value)){
                $td = '';
                foreach ($value as $keyx => $valuex) {
                  if(in_array($keyx, $visible_col_name) ){
                    $td .= '<td class="table-division"  data-property="'.$keyx.'">'.$valuex.'</td>';
                  }
                }//end foreach
                echo $td;
              }//end if 
              ?>
              <!-- <START : ACTION SET> -->
              <td class="text-right">
                <a href="#" data-cms-action="update" title="<?php echo freetext('edit'); ?>" data-toggle="modal" data-target="#edit_group_<?php echo $value['id']; ?>" class="btn btn-default btn-xs"><i class="fa fa-pencil"></i></a>
                <a href="#" data-cms-action="delete" title="<?php echo freetext('delete'); ?>" data-toggle="modal" data-target="#delete_group_<?php echo $value['id']; ?>" class="btn btn-default btn-xs"><i class="fa fa-trash-o"></i></a>
              </td>
              <!-- <END : ACTION SET> -->

            </tr>
          <?php 
            }
          }
          ?>
          </tbody>
          <tfoot>
          <?php 
            $page = $result['page']; 
            $total_page = $result['total_page'];
            $disabled='';
            $items= $result['total_item']; 
            $pageSize=$result['page_size'];
          ?>  
            <input class="input-totalPage" type="hidden" value="<?php echo  $total_page; ?>"/>
            <tr>
              <th class="row" colspan="7">
                <div class="datagrid-footer-left col-sm-6 text-center-xs m-l-n" style="visibility: visible;">
                  <div class="grid-controls pull-left" style="">
                    <div class="pull-left" style="padding:4px 4px 0px 0px">
                      <span class="grid-start"><?php if($page==1){echo "1";}else{ $start_page =$page-1; echo ($pageSize*$start_page)+1;}?></span> -
                      <span class="grid-end"><?php $end_page = $pageSize*$page; if($end_page>$items){ echo $items; }else{echo $end_page;}?><input class="pg_size" type="hidden" value="<?php echo $pageSize;?>"></span> <?php echo freetext('page_of'); ?>
                      <span class="grid-count"><?php echo $items.' '.freetext('page_items'); ?></span>
                    </div>
                    <div class="dropup" data-resize="auto" style="float: left;">
                      <button data-toggle="dropdown" class="btn btn-sm btn-default dropdown-toggle">
                        <span class="dropdown-label" style="width: 1280px;"><?php echo $pageSize;?></span>
                        <span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu">
                        <li data-value="10"><a href="<?php echo site_url("__cms_permission/changePageSize/10"); ?>" >10</a></li>
                        <li data-value="20"><a href="<?php echo site_url("__cms_permission/changePageSize/20"); ?>">20</a></li>
                        <li data-value="50"><a href="<?php echo site_url("__cms_permission/changePageSize/50"); ?>">50</a></li>
                        <li data-value="100"><a href="<?php echo site_url("__cms_permission/changePageSize/100"); ?>">100</a></li>
                      </ul>
                    </div>
                    <div class="pull-left" style="padding: 4px 0px 0px 4px;"><?php echo freetext('per_page'); ?></div>
                  </div>
                </div>
                <div class="datagrid-footer-right col-sm-4 text-right text-center-xs pull-right" style="visibility: visible;">
                  <div class="grid-pager m-r-n">
                     <?php 
                     if($page > 1) {                               
                      $back_page=intval($page)-1;  
                       $disabled="";                              
                     }else{ $back_page="#";$disabled="disabled"; } 
                    ?> 
                    <a href="<?php echo site_url("__cms_permission/group_list/".$back_page  ); ?>"><button type="button" <?php echo $disabled; ?> class="btn btn-sm btn-default grid-prevpage pull-left" ><i class="fa fa-chevron-left"></i></button></a>
                    <span class="pull-left" style="padding:4px 0px 0px 12px"><?php echo freetext('u_page'); ?></span>
                    <div class="inline pull-left col-sm-5">
                      <div class="input-group dropdown ">
                        <input class="input-sm form-control input-page col-sm-4" type="text" autocomplete="off" value="<?php echo $page ;?>">
                        <div class="input-group-btn dropup">
                          <button class="btn btn-sm btn-default" data-toggle="dropdown"><i class="caret"></i></button>
                          <ul class="dropdown-menu pull-right">
                          <?php for ($i = 1; $i <= $total_page; $i++) { ?>                                        
                                   <li><a href="<?php echo site_url("__cms_permission/group_list/".$i);?>"><?php echo $i;?></a></li>
                          <?php } ?> 
                          </ul>
                        </div>
                      </div>
                    </div>
                    <span class="pull-left" style="padding:4px 12px 0px 0px"><?php echo freetext('page_of'); ?> <span class="grid-pages"><?php echo $total_page; ?></span></span>
                    <?php 
                     if($page < $total_page) {
                      $next_page=intval($result['page'])+1;
                       $disabled="";
                     }else{ $next_page="#"; $disabled="disabled";} 
                   ?> 
                    <a href="<?php echo site_url("__cms_permission/group_list/".$next_page ); ?>"><button type="button"  <?php echo $disabled; ?> class="btn btn-sm btn-default grid-nextpage pull-left"><i class="fa fa-chevron-right"></i></button></a>
                  </div>
                </div>
              </th>
            </tr>
          </tfoot>
        </table>
      </div>
    </section>
  </section>
</section>
<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>        
