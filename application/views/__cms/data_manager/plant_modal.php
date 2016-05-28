
<?php
  // echo "<pre>";
  // print_r($year_list);
  // echo "</pre>";
  if (!empty($plant_list)) {
    foreach ($plant_list as $obj) {
?>  
    <div class="edit_plant modal fade" id="edit_plant_<?php echo $obj['plant_code'] ?>">
      <div class="modal-dialog" style="width:50%;">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title h4"><?php echo $obj['plant_code'].' - '.$obj['plant_name']; ?></h4>
          </div>
          <div class="modal-body" style="overflow-y:auto; max-height:300px;">
            <form method="post" action="<?php echo base_url().'index.php/__cms_data_manager/edit_plant/' ?>">
              <input type="hidden" name="plant_code" value="<?php echo $obj['plant_code']; ?>">
              <div class="row m-b-sm m-l-sm m-r-sm">
                <div class="col-sm-6 font-bold">Plant Code</div>
                <div class="col-sm-5"><?php echo $obj['plant_code']; ?></div>
              </div>
              <div class="row m-b-sm m-l-sm m-r-sm">
                <div class="col-sm-6 font-bold">Plant Name</div>
                <div class="col-sm-5"><?php echo $obj['plant_code']; ?></div>
              </div>
              <div class="row m-b-sm m-l-sm m-r-sm">
                <div class="col-sm-6 font-bold">Doc Code</div>
                <div class="col-sm-5">
                  <input type="text" class="form-control" name="doc_code" value="<?php echo $obj['doc_code']; ?>">
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer" style="margin-top:0px;">          
            <a href="#" class="btn btn-primary edit_plant_btn" data-parent="#edit_plant_<?php echo $obj['plant_code']; ?>"><i class="fa fa-save"></i> <?php echo freetext('save'); ?></a>
            <a href="#" class="btn btn-danger" data-dismiss="modal"><?php echo freetext('cancel'); ?></a>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->  
<?php
    }
  }
?>