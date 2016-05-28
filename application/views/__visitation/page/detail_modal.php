<!--Start: modal confirm delete_uploadfile  -->
<div class="modal fade" id="visit_image_modal"  is-confirm='0'>                  
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body text-center" style='overflow:auto'>                  
      <!-- <p class='msg'>Do you confirm to delete this item</p> -->
        <img src="" style="max-width:550px;">
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->        
</div><!--end: modal confirm delete_uploadfile -->


<!--Start: modal confirm delete -->
<div class="modal fade" id="delete_image"  is-confirm='0'>                  
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
          <span class="btn confirm-delete-image btn-primary" data-dismiss="modal" ><?php echo freetext('confirm'); ?></span>
          <form id="image_del_form" action="<?php echo site_url('__ps_visitation/delete_image'); ?>" method="post">
              <input type='hidden' value='<?php echo current_url(); ?>' name='callback_url' >
              <input type="hidden" name="id" value="">
          </form>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->        
</div><!--end: modal confirm delete -->