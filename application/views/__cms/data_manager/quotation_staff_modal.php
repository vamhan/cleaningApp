
<div class="edit_staff_quotation modal fade" >
  <form action='<?php echo site_url($this->page_controller.'/update_staff_quotation'); #CMS?>' method="POST" enctype="multipart/form-data" data-parsley-validate>
  <div class="modal-dialog" style="width:50%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title h4">แก้ไขผู้รับผิดชอบ ใบเสนอราคา</h4>
      </div>
      <div class="modal-body">
        <div class="row m-b-sm m-l-sm m-r-sm">
          <div class="col-sm-6 font-bold">เลขที่ใบเสนอราคา</div>
          <div class="col-sm-6"><input type="text" autocomplete="off" name="quotation_id" class="form-control quotation_id" readonly="readonly"></div>
        </div>

        <div class="row m-b-sm m-l-sm m-r-sm">
          <div class="col-sm-6 font-bold">รายการใบเสนอราคา</div>
          <div class="col-sm-6"><input type="text" autocomplete="off" name="title" class="form-control title" readonly="readonly"></div>
        </div>

        <div class="row m-b-sm m-l-sm m-r-sm">
          <div class="col-sm-6 font-bold">สร้างโดย</div>
          <div class="col-sm-6">
            <input  type="hidden"  class="staff_id"/>
            <select  name='project_owner_id' class='form-control' id="mySelect">
            <!-- <select  name='staff_id' class='select2  form-control no-padd h6' id="mySelect" style="height:31px;"> -->
              <?php      
               if (!empty($user)) {
                foreach ($user as $key => $value) { 
                  if($value['employee_id']!=-1 &&  $value['employee_id']!=0){
               ?>
                  <option value='<?php echo $value['employee_id'] ?>'><?php echo $value['user_firstname'].' '.$value['user_lastname']; ?></option> 
          <?php }//end foreach
              }
            }
           ?>
            </select>
          </div>
        </div>

      </div>
      <div class="modal-footer">          
         <input type='submit' class="btn btn-primary save_images" value="Save">
        <a href="#" class="btn btn-danger" data-dismiss="modal"><?php echo freetext('cancel'); ?></a>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</form>
</div><!-- /.modal -->  


