<?php
  $emp_id = $this->session->userdata('id');
?>
<style type="text/css">
  .table-head,.table-division{ text-align: center }
  .panel-heading .btn-sm { margin-top: -6px}
</style>
<div class="div_detail">
  <section class="panel panel-default">
    <div class="table-responsive">                  
      <table id="MyStretchGrid" class="table table-striped datagrid m-b-sm">
        <thead>
          <tr>
            <th colspan="10">
              <div class="row">
                <?php 
                  #CMS 
                  echo form_open('');
                  $keyword = $this->input->post("search");
                  #END_CMS 
                ?>
                <div class="col-sm-12 m-t-xs m-b-xs " >
                  <div class="input-group search datagrid-search">
                    <input type="text" autocomplete="off" class="input-sm form-control" name="search" id="search" placeholder="<?php echo freetext('search'); ?>" value='<?php echo !empty($keyword)?$keyword:""; ?>'>
                    <div class="input-group-btn">
                      <button class="btn btn-default btn-sm sumbit-search" ><i class="fa fa-search"></i></button>
                    </div>                          
                  </div>
                </div>
                <?php 
                  echo form_close();
                ?> 
              </div>
            </th>
          </tr>
          <tr>
            <th><?php echo freetext('list_of_quality_assurance'); ?></th>
            <th class="tx-center"><?php echo freetext('plan_date'); ?></th>
            <th class="tx-center"><?php echo freetext('actual_date'); ?></th>
            <th class="tx-center"><?php echo freetext('status'); ?></th>
            <th class="tx-center"><?php echo freetext('pass_status'); ?></th>
            <?php 
              if (array_key_exists('approve', $permission)) { 
            ?>
                <th class="tx-center"><?php echo freetext('manager_view_label'); ?></th>
            <?php
              } 
            ?>
            <th class="tx-center"><?php echo freetext('view_label'); ?></th>
            <?php 
              if (array_key_exists('approve', $permission)) { 
            ?>
              <th class="tx-center"><?php echo freetext('manager_edit_label'); ?></th>
            <?php
              } 
            ?>
            <?php
              if (array_key_exists('edit', $permission)) {
            ?>
            <th class="tx-center"><?php echo freetext('edit_label'); ?></th>
            <?php
              } 
            ?>
            <th class="tx-center"><?php echo freetext('del_label'); ?></th>
          </tr>
        </thead>
        <tbody>   
        <?php 
          if(!empty($result)){
            $emp_id = $this->session->userdata('id');
            $content = $result['list'];                  
            foreach ($content as $key => $value) {
        ?>
              <tr>  
                <td><?php echo $value['title']; ?></td>
                <td class="tx-center"><?php if( $value['plan_date'] !='0000-00-00' ){ echo common_easyDateFormat($value['plan_date']); }else{ echo "-"; }  //print $value['plan_date'];?></td>
                <td class="tx-center"><?php if( $value['actual_date'] !='0000-00-00' ){ echo common_easyDateFormat($value['actual_date']); }else{ echo "-"; } // print $value['actual_date'];?></td>
                <td class="tx-center">
                <?php 
                  if (!empty($value['status']) && $value['next_disabled'] == 0) {

                    if (array_key_exists('edit', $permission)) {
                      $complete = $this->__ps_project_query->getObj('tbt_quality_survey', array('status' => 'complete', 'quotation_id' => $value['quotation_id'], 'site_inspector_id' => $value['site_inspector_id']));
                      $approved = $this->__ps_project_query->getObj('tbt_quality_survey', array('status' => 'approved', 'quotation_id' => $value['quotation_id'], 'site_inspector_id' => $value['site_inspector_id']));
                 
                      if (((empty($complete) && empty($approved)) || $value['status'] == 'complete') || ($emp_id != $value['site_inspector_id'] && array_key_exists('approve', $permission))) {
                        echo freetext($value['status']); 
                      } else {
                        echo freetext('approved'); 
                      }
                    } else {
                      echo freetext($value['status']); 
                    }

                  } else if ($value['next_disabled'] == 1) { 
                    echo "ไม่สามารถอนุมัติแผนงานได้"; 
                  } else { 
                    echo '-'; 
                  } 
                ?>
                </td>
                <td class="tx-center">
                  <?php if( $value['status'] == 'complete' && $value['all_area_question'] != 0 ){ if (round((intval($value['all_pass'])/intval($value['all_area_question']))*100, 2) >= intval($value['min_pass_score'])) { echo '<span class="text-primary">'.freetext('pass').' ('.round((intval($value['all_pass'])/intval($value['all_area_question']))*100, 2).'/'.intval($value['min_pass_score']).')'.'</span>'; } else { echo '<span class="text-danger">'.freetext('not_pass').' ('.round((intval($value['all_pass'])/intval($value['all_area_question']))*100, 2).'/'.intval($value['min_pass_score']).')'.'</span>'; } } else{ echo "-"; } // print $value['actual_date'];?>
                </td>
                <?php 
                  if (array_key_exists('approve', $permission)) { 
                ?>
                    <td class="tx-center">
                      <a 
                      <?php 
                        if( 
                            !array_key_exists('approve', $permission) ||
                            $value['status'] != 'complete' 
                        ){ 
                          echo 'disabled'; 
                        } 
                      ?> 
                      href="<?php echo site_url($this->page_controller.'/manager_view/'.$value['quotation_id'].'/'.$value['id']); ?>" class="btn btn-default">
                        <i class="fa fa-certificate h5"></i>
                      </a>   
                    </td>  
                <?php
                  } 
                ?>
                <td class="tx-center">
                  <a  data-cms-visible="view" 
                  <?php 
                    if( 
                        !array_key_exists('view', $permission) ||
                        (
                          $value['actual_date'] == '0000-00-00' ||
                          empty($value['actual_date'])
                        )
                    ){ 
                      echo 'disabled'; 
                    } 
                  ?> 
                  href="<?php echo site_url($this->page_controller.'/detail/view/'.$value['quotation_id'].'/'.$value['id']); ?>" class="btn btn-default">
                    <i class="fa fa-check-square-o h5"></i>
                  </a>   
                </td>    
                <?php 
                  if (array_key_exists('approve', $permission)) { 
                ?>
                    <td class="tx-center">   
                      <a 
                      <?php 
                        if( 
                          !array_key_exists('approve', $permission) ||
                          $value['status'] == 'approved' || 
                          $value['status'] == 'complete' || 
                          $value['manager_btn_disabled'] == 1 || 
                          $value['next_disabled'] == 1 ||
                          ($this->is_abort !='0000-00-00' && $this->is_abort <= date('Y-m-d'))                           
                        ){ 
                            echo 'disabled'; 
                        } 
                      ?> 
                      href="<?php echo site_url($this->page_controller.'/manager_edit/'.$value['quotation_id'].'/'.$value['id']); ?>" class="btn btn-default">
                        <i class="fa fa-pencil h5"></i>
                      </a>
                    </td>  
                <?php
                  } 
                ?> 
                <?php
                  $function = $this->session->userdata('function');
                  if (array_key_exists('edit', $permission)) {
                    $complete = $this->__ps_project_query->getObj('tbt_quality_survey', array('status' => 'complete', 'quotation_id' => $value['quotation_id'], 'site_inspector_id' => $value['site_inspector_id']));
                    $approved = $this->__ps_project_query->getObj('tbt_quality_survey', array('status' => 'approved', 'quotation_id' => $value['quotation_id'], 'site_inspector_id' => $value['site_inspector_id']));
                    $edit_disable = 0;
                    if ((empty($complete) && empty($approved)) || (!in_array('HR', $function) && $value['site_inspector_id'] != $emp_id)) {
                      $edit_disable = 1;
                    }
                ?>
                <td class="tx-center">
                  <a  data-cms-visible="edit" 
                  <?php 
                    if(!array_key_exists('edit', $permission) ||
                        $edit_disable == 1 || 
                        $value['btn_disabled'] == 1 || 
                        date('m Y', strtotime($value['plan_date'])) != date('m Y') ||
                        (!in_array('HR', $function) && $value['status'] == 'complete' && $value['submit_date_sap'] != "0000-00-00") ||
                        (in_array('HR', $function) &&$value['hr_submit_date_sap'] != "0000-00-00") ||
                        ($this->is_abort !='0000-00-00' && $this->is_abort <= date('Y-m-d'))
                    ) { 
                      echo 'disabled'; 
                    } 
                  ?> 
                  href="<?php echo site_url($this->page_controller.'/detail/save/'.$value['quotation_id'].'/'.$value['id']); ?>" class="btn btn-default">     
                    <i class="fa fa-list-alt h5"></i>
                  </a>
                </td> 
                <?php
                  }
                ?>  
                <td class="tx-center">
                  <a  data-cms-visible="delete" 
                    <?php 
                      if(!array_key_exists('delete', $permission) ||
                          $value['submit_date_sap'] != "0000-00-00" || 
                          $value['status'] == 'complete' || 
                          ($value['status'] == "approved" && $value['actual_date'] != '0000-00-00') ||
                          ($this->is_abort !='0000-00-00' && $this->is_abort <= date('Y-m-d'))
                        ){ 
                        echo 'disabled'; 
                      } 
                    ?> 
                    class="btn btn-default commit-delete-btn" id="<?php echo $value['id']; ?>"  actionplan-id="<?php echo $value['action_plan_id']; ?>" project-id="<?php echo $this->project_id; ?>" main-table="<?php echo $this->table;#CMS?>">
                    <i class="fa fa-trash-o h5"></i>
                  </a>
                </td>  
              </tr>
        <?php 
            }
          }
        ?>
        </tbody>
        <?php 
          echo form_close();
        ?> 

          <tfoot>
          <?php 
            $page = $result['page']; 
            $total_page = $result['total_page'];
            $disabled='';
            $items= $result['total_item']; 
            $pageSize=$result['page_size'];
            $project_id =$result['quotation_id'];
          ?>  
            <input class="input-totalPage" type="hidden" value="<?php echo  $total_page; ?>"/>
            <tr>
              <?php 
                if (array_key_exists('approve', $permission)) { 
              ?>
                  <th class="row" colspan="10">
              <?php
                } else {
              ?>
                  <th class="row" colspan="8">
              <?php
                }
              ?>
                <div class="datagrid-footer-left col-sm-4 text-center-xs m-l-n" style="visibility: visible;">
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
                        <li data-value="10"><a href="<?php echo site_url("__ps_quality_assurance/changePageSize/10"); ?>" >10</a></li>
                        <li data-value="20"><a href="<?php echo site_url("__ps_quality_assurance/changePageSize/20"); ?>">20</a></li>
                        <li data-value="50"><a href="<?php echo site_url("__ps_quality_assurance/changePageSize/50"); ?>">50</a></li>
                        <li data-value="100"><a href="<?php echo site_url("__ps_quality_assurance/changePageSize/100"); ?>">100</a></li>
                      </ul>
                    </div>
                    <div class="pull-left" style="padding: 4px 0px 0px 4px;"><?php echo freetext('per_page'); ?></div>
                  </div>
                </div>
                <div class="datagrid-footer-right col-sm-8 text-right text-center-xs pull-right" style="visibility: visible;">
                  <div class="grid-pager m-r-n change-page-ft" >

                     <?php 
                     if($page > 1) {                               
                      $back_page=intval($page)-1;  
                       $disabled="";                              
                     }else{ $back_page="#";$disabled="disabled"; } 
                    ?> 
                    <a href="<?php echo site_url("__ps_quality_assurance/listview/list/".$project_id."/".$back_page  ); ?>"><button type="button" <?php echo $disabled; ?> class="btn btn-sm btn-default grid-prevpage pull-left" ><i class="fa fa-chevron-left"></i></button></a>
                    <span class="pull-left" style="padding:4px 0px 0px 12px"><?php echo freetext('u_page'); ?></span>
                    
                    <div class="inline pull-left col-sm-5">
                      <div class="input-group dropdown ">
                        <input class="input-sm form-control input-page col-sm-4" type="text" autocomplete="off" value="<?php echo $page ;?>">
                        <div class="input-group-btn dropup">
                          <button class="btn btn-sm btn-default" data-toggle="dropdown"><i class="caret"></i></button>
                          <ul class="dropdown-menu pull-right">
                          <?php for ($i = 1; $i <= $total_page; $i++) { ?>                                        
                                   <li><a href="<?php echo site_url("__ps_quality_assurance/listview/list/".$project_id."/".$i);?>"><?php echo $i;?></a></li>
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
                    <a href="<?php echo site_url("__ps_quality_assurance/listview/list/".$project_id."/".$next_page ); ?>"><button type="button"  <?php echo $disabled; ?> class="btn btn-sm btn-default grid-nextpage pull-left"><i class="fa fa-chevron-right"></i></button></a>
                 
                    </div>
                    <?php  
                    //check abort contract
                      $is_abort = "";
                      if($this->is_abort !='0000-00-00' && $this->is_abort <= date('Y-m-d')){                       
                          $is_abort = "disabled";                        
                      }

                    ?>
                    <?php if ( ( isset($isAllowToCreate) && $isAllowToCreate == 1) || array_key_exists('create', $permission)) { ?><a <?php echo $is_abort; ?> data-cms-visible="create" href="#modal-addListEmployee" data-toggle="modal" class="btn btn-default" ><i class="fa fa-plus"></i> <?php echo freetext('add'); ?></a><?php  } ?>
                                      
                </div>
              </th>
            </tr>
          </tfoot>
      </table>
    </div>
  </section>
</div><!-- end div -->
<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>





