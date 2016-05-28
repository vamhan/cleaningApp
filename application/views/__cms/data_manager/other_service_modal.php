<div class="upload_file_other modal fade" id="upload_file_other" >
  <div class="modal-dialog" style="width:50%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title h4">อัพโหลดไฟล์</h4>
      </div>
      <div class="modal-body">
        
      <section class="panel panel-default">
      <header class="panel-heading font-bold">
      อัพโหลดไฟล์รายละเอียดการบริการ
      </header>
      <form method="post" action="<?php echo site_url('__cms_data_manager/doc_otherservice_management/upload_file');?>" data-parsley-validate enctype="multipart/form-data" />  
      <div class="panel-body">

             

             <div class="form-group col-sm-12">
                <label class="col-sm-3 control-label">เลือกไฟล์อัพโหลด</label>
                <div class="col-sm-9">
                   <input type="file"  name="image"  class="filestyle" data-icon="false" data-classButton="btn btn-default col-sm-4 pull-left" data-classInput="pull-left h3 col-sm-8" >   
                </div>
              </div>  

             <div class="form-group col-sm-12">
                <label class="col-sm-3 control-label">Language</label>
                <div class="col-sm-9">
                  <select name="lang" class="form-control">
                      <option value="th">TH</option>
                      <option value="en">EN</option>
                  </select>
                </div>
              </div>  

               <div class="form-group col-sm-12">
                <label class="col-sm-3 control-label">ประเภทธุรกิจ</label>
                <div class="col-sm-9">
                    <select class="select2   no-padd h5 select_industry col-sm-12 " name="industry" data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>">
                        <option selected='selected' value=''>กรุณาเลือก</option>
                         <?php 
                              $temp_bapi_industry= $bapi_industry->result_array();
                              if(!empty($temp_bapi_industry)){
                              foreach($bapi_industry->result_array() as $value){                                                          
                           ?>
                               <option  value='<?php echo $value['id'] ?>'><?php echo  $value['id'].' '.$value['title'] ?></option> 
                          <?php                                   
                                
                              }//end foreach
                             }else{ ?>
                               <option value='0'>ไม่มีข้อมูล</option> 
                          <?php } ?>
                    </select>  
                </div>
              </div>  

      </div>
      </section>
         
      </div>
      <div class="modal-footer">  
        <button  id="submit" class="btn btn-s-md btn-info btn_upload_other"><?php  echo freetext('upload'); //Upload?></button>               
        <a href="#" class="btn btn-danger" data-dismiss="modal"><?php echo freetext('cancel'); ?></a>        
      </div>
    </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->  





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
          <span class="btn confirm-delete btn-primary" data-dismiss="modal" ><?php echo freetext('confirm'); ?></span>
          <span class="btn cancel-delete  btn-default" data-dismiss="modal" aria-hidden="true"><?php echo freetext('cancel'); ?></span>
          
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->        
</div><!--end: modal confirm delete -->