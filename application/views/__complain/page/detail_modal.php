  
         <!--Start: modal confirm delete -->
        <div class="modal fade" id="modal-confirm"  is-confirm='0'>                  
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h3 class="title">ยืนยันการส่งข้อรองเรียน</h3>
                </div>
                <div class="modal-body" style='overflow:auto'>                  
                  <!-- <p class='msg'>Do you confirm to delete this item</p> -->
                  <p class='msg h5'>คุณต้องการส่งข้อร้องเรียนหรือไม่</p> 
                </div>
                <div class='clear:both'></div>
                <div class="modal-footer">
                  <span class="btn cancel-confirm  btn-default" data-dismiss="modal" aria-hidden="true"><?php echo freetext('cancel'); ?></span>
                  <span class="btn confirm btn-primary" data-dismiss="modal" ><?php echo freetext('confirm'); ?></span>
                </div>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->        
        </div><!--end: modal confirm delete -->




         <!-- start : photos-modal -->
                  <!--Start: modal add new category -->
                  <div class="modal fade" id="modal-photo-form">
                    <form action='<?php echo site_url($this->page_controller.'/upload_photo'); #CMS?>' method="POST" enctype="multipart/form-data" data-parsley-validate>
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"><?php echo 'New '.$this->page_object;#CMS ?> </h4>
                          </div>
                          <!-- start : modal-body -->
                          <div class="modal-body" style='overflow:auto'>

                            <div class="form-group" style='padding-bottom:4px !important; overflow:auto'>
                              <label class="col-lg-2 control-label">Title</label>
                              <div class="col-lg-10">
                                <input type="text" name='title' class="form-control" placeholder="title" data-parsley-required="true">
                                <!-- <span class="help-block m-b-none">Example block-level help text here.</span> -->
                              </div>
                            </div>

                           <!--  <div class="form-group" style='padding-bottom:4px !important; overflow:auto'>
                              <label class="col-lg-2 control-label">Sequence</label>
                              <div class="col-lg-10">
                                <input type="text" name='sequence' class="form-control" placeholder="sequence">
                              </div>
                            </div> -->


                            <div class="form-group " style='padding-bottom:4px !important; overflow:auto'>
                              <label class="col-sm-2 control-label">File</label>
                              <div class="col-sm-10">
                              <!--   <input type='hidden' name='upload_act' value='create'/>
                                <input type='hidden' name='client_name[obj1]' value='obj1'/> -->
                                <input type="file" name="image" class="file-upload-image_flag" data-icon="false" data-classbutton="btn btn-default" data-classinput="form-control inline input-s" id="filestyle-0" style=""/>                                
                                <!-- <div class="bootstrap-filestyle" style="display: inline;"><input type="text" class="form-control inline input-s" disabled=""> <label for="filestyle-0" class="btn btn-default"><span>Choose file</span></label></div> -->
                                <span class="help-block m-b-none tx-red">Allowed only .jpg/.gif/.png less than 10 mb</span>
                              </div>
                            </div>

                          </div>
                          <!-- end : modal-body -->
                          <div class='clear:both'></div>
                          <div class="modal-footer">
                            <a href="#" class="btn btn-default" data-dismiss="modal">Cancel</a>

                          
                            <input type='hidden' value='<?php echo $this->complain_id; ?>' name='object_id'>
                            <input type='hidden' value='' name='temp_contract_id'> 

                            <input type='submit' class="btn btn-primary save_images" value="Save">
                          </div>
                        </div><!-- /.modal-content -->
                      </div><!-- /.modal-dialog -->
                    </form>
                  </div>

                  <!-- end : photos-modal -->



      <!--Start: modal confirm delete -->
        <div class="modal fade" id="modal-delete-images"  is-confirm='0'>                  
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h3 class="title">ยืนยันการลบ</h3>
                </div>
                <div class="modal-body" style='overflow:auto'>                  
                  <!-- <p class='msg'>Do you confirm to delete this item</p> -->
                  <p class='msg h5'>คุณต้องการลบภาพหรือไม่</p> 
                  <input type='hidden' value='<?php echo $this->complain_id; ?>' name='object_id'>
                  <input type='hidden' value='' name='temp_contract_id'> 
                </div>
                <div class='clear:both'></div>
                <div class="modal-footer">
                  <span class="btn cancel-delete  btn-default" data-dismiss="modal" aria-hidden="true"><?php echo freetext('cancel'); ?></span>
                  <span class="btn confirm-delete btn-primary" data-dismiss="modal" ><?php echo freetext('confirm'); ?></span>
                </div>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->        
        </div><!--end: modal confirm delete -->
