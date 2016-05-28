
<div class="edit_project modal fade" >
  <form action='<?php echo site_url($this->page_controller.'/update_project_management'); #CMS?>' method="POST" enctype="multipart/form-data" data-parsley-validate>
  <div class="modal-dialog" style="width:50%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title h4">แก้ไขผู้รับผิดชอบ ใบเสนอราคา</h4>
      </div>
      <div class="modal-body">

        <div class="row m-b-sm m-l-sm m-r-sm">
          <div class="col-sm-6 font-bold">เลขที่สัญญา</div>
          <div class="col-sm-6"><input type="text" autocomplete="off" name="contract_id" class="form-control contract_id" readonly="readonly"></div>
        </div>  

        <div class="row m-b-sm m-l-sm m-r-sm">
          <div class="col-sm-6 font-bold">เลขที่ใบเสนอราคา</div>
          <div class="col-sm-6"><input type="text" autocomplete="off" name="quotation_id" class="form-control quotation_id" readonly="readonly"></div>
        </div>

        <div class="row m-b-sm m-l-sm m-r-sm">
          <div class="col-sm-6 font-bold">สถานที่ปฏิบัติการ</div>
          <div class="col-sm-6"><input type="text" autocomplete="off" name="title" class="form-control title" readonly="readonly"></div>
        </div> 

        <div class="row m-b-sm m-l-sm m-r-sm">
          <div class="col-sm-6 font-bold">รหัสหน่วยงาน</div>
          <div class="col-sm-6"><input type="text" autocomplete="off" name="ship_to_id" class="form-control ship_to_id" readonly="readonly"></div>
        </div>

        <div class="row m-b-sm m-l-sm m-r-sm">
          <div class="col-sm-6 font-bold">สถานะ</div>
          <div class="col-sm-6"><input type="text" autocomplete="off" name="status" class="form-control status" readonly="readonly"></div>
        </div> 

        <div class="row m-b-sm m-l-sm m-r-sm">
          <div class="col-sm-6 font-bold">ประเภทงาน</div>
          <div class="col-sm-6"><input type="text" autocomplete="off" name="job_type" class="form-control job_type" readonly="readonly"></div>
        </div> 

        <div class="row m-b-sm m-l-sm m-r-sm">
          <div class="col-sm-6 font-bold">วันเริ่มโครงการ</div>
          <div class="col-sm-6"><input type="text" autocomplete="off" name="project_start" class="form-control project_start" readonly="readonly"></div>
        </div> 

        <div class="row m-b-sm m-l-sm m-r-sm">
          <div class="col-sm-6 font-bold">วันจบโครงการ</div>
          <div class="col-sm-6"><input type="text" autocomplete="off" name="project_end" class="form-control project_end" readonly="readonly"></div>
        </div> 

        <div class="row m-b-sm m-l-sm m-r-sm">
             <div class="col-sm-6 font-bold">วันที่ยกเลิกโครงการ</div>
             <div class="input-group col-md-6 " id="datetimepicker1" data-date-format="DD.MM.YYYY" style="padding-left:15px;padding-right:15px;">
                <input type="text" class="form-control abort_date" name="abort_date" readonly  value=""/>
                <span class="input-group-addon btn btn_abort_date" data-cms-visible="manage">
                    <span class="glyphicon glyphicon-time"></span>
                </span>
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


