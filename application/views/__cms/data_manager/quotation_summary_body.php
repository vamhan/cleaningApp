<!-- start : content -->
<section class="vbox">
  <section class="scrollable padder">
    <section class="panel panel-default">
      <header class="panel-heading">
        <?php echo $this->page_title; ?>                  
      </header>
      <div class="panel-body">
        <section class="panel panel-default" style="min-height:50px;" >
          
            <form id="plant_form" method="post" action="<?php echo site_url('__cms_data_manager/insert_summary_data'); ?>">
              <div class="col-sm-3" style="margin-top:8px;" >
                 <?php echo form_dropdown('plant_code', $plant_not_list, '', 'class="form-control"'); ?>
              </div>
             
                <button style="margin-top:10px;" type="submit" href="#" class="btn btn-primary btn-sm"><i class="fa fa-insert"></i> <?php echo freetext('add'); ?></button>
            </form>
        
        </section>

        <?php if (!empty($plant_list)): ?>
          <section class="panel panel-default">
            <?php foreach ($plant_list as $plant_key => $plant): ?>
              <?php $summary_data = $summary_data_list[$plant['plant_code']]; ?>
              
              <?php if (!empty($summary_data)): ?>

                <div class="panel">
                  <div class="panel-heading">

                    <h5 style="font-weight:bold;font-size:20px;" class="col-sm-11">
                    <?php echo $plant['plant_code'].'-'.$plant['plant_name'] ?></h5>
                    <span class="">
                      <a class="btn btn-default delete_summary_btn margin-left-small" type="button" data-id="<?php echo $plant['plant_code']; ?>" ><i class="fa fa-trash-o"></i> <?php echo freetext('delete'); ?></a>
                    </span>
                    
                  </div>
                  <header class="panel-heading bg-light">
                    <ul class="nav nav-tabs nav-justified">
                      <?php
                      if (!empty($job_type_list)) {
                        foreach ($job_type_list as $key => $job_type) {
                          ?>
                          <li class="<?php if ($tab == $job_type['id']) { echo "active"; } ?>"><a href="#<?php echo $plant['plant_code'].'_'.$job_type['id'] ;?>_tab" data-toggle="tab"><?php echo $job_type['title']; ?></a></li>
                          <?php
                        }
                      }
                      ?>
                    </ul>
                  </header>
                  <div class="panel">

                    <div class="tab-content">    
                      <?php
                      if (!empty($summary_data)) {
                        foreach ($summary_data as $doc_type => $summary) {
                          ?>
                          <div class="tab-pane <?php if ($tab == $doc_type) { echo "active"; } ?>" id="<?php echo $plant['plant_code'].'_'.$doc_type; ?>_tab" style="max-height: 418px;overflow-y: auto;">
                            <form id="<?php echo $plant['plant_code'].'_'.$doc_type; ?>_form" method="post" action="<?php echo site_url('__cms_data_manager/update_summary_data'); ?>">
                              <input type="hidden" name="plant_code" value="<?php echo $plant['plant_code']; ?>">
                              <input type="hidden" name="doc_type" value="<?php echo $doc_type; ?>">
                              <table class="table table-striped m-b-none">
                                <tbody>
                                  <tr>
                                    <td width="90%"><?php echo freetext('field_social_security'); ?></td>
                                    <td><input type="text" class="form-control input-s-sm" name="percent_social_security" value="<?php if (!empty($summary)) echo $summary['percent_social_security']; ?>"></td>
                                  </tr>
                                  <tr>
                                    <td width="90%"><?php echo freetext('field_operation'); ?></td>
                                    <td><input type="text" class="form-control input-s-sm" name="percent_operation" value="<?php if (!empty($summary)) echo $summary['percent_operation']; ?>"></td>
                                  </tr>
                                  <tr>
                                    <td width="90%"><?php echo freetext('field_margin'); ?></td>
                                    <td><input type="text" class="form-control input-s-sm" name="percent_margin" value="<?php  if (!empty($summary)) echo $summary['percent_margin']; ?>"></td>
                                  </tr>
                                  <tr>
                                    <td width="90%"><?php echo freetext('field_buffer'); ?></td>
                                    <td><input type="text" class="form-control input-s-sm" name="percent_buffer" value="<?php  if (!empty($summary)) echo $summary['percent_buffer']; ?>"></td>
                                  </tr>
                                  <tr>
                                    <td width="90%"><?php echo freetext('field_vat'); ?></td>
                                    <td><input type="text" class="form-control input-s-sm" name="percent_vat" value="<?php  if (!empty($summary)) echo $summary['percent_vat']; ?>"></td>
                                  </tr>
                                </tbody>
                                <tfoot>
                                  <tr>
                                    <td colspan="2" class="text-right">
                                      <a href="#" class="btn btn-primary save_summary" data-parent="#<?php echo $plant['plant_code'].'_'.$doc_type; ?>_form"><i class="fa fa-save"></i> <?php echo freetext('save'); ?></a>
                                    </td>
                                  </tr>
                                </tfoot>
                              </table>
                            </form>
                          </div>
                          <?php
                        }
                      }
                      ?>
                    </div>
                  </div>
                </div>

              <?php endif ?>
            <?php endforeach ?>
          </section>
        <?php endif ?>
      </div>
    </section>
  </section>
</section>
<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>       

<!--Start: modal confirm delete -->
<div class="modal fade" id="modal-delete"  is-confirm='0'>                  
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 class="title"><?php echo freetext('delete_confirm'); ?></h3>
      </div>
      <div class="modal-body" style='overflow:auto'>                  
        <!-- <p class='msg'>Do you confirm to delete this item</p> -->
        <p class='msg h5'>คุณต้องการลบข้อมูลนี้หรือไม่</p> 
      </div>
      <div class='clear:both'></div>
      <div class="modal-footer">
        <span class="btn cancel-delete  btn-default" data-dismiss="modal" aria-hidden="true"><?php echo freetext('cancel'); ?></span>
        <span class="btn confirm-delete btn-primary" data-dismiss="modal" ><?php echo freetext('confirm'); ?></span>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->        
</div><!--end: modal confirm delete -->






