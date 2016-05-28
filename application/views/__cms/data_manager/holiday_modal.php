
<div class="create_holiday_year modal fade" id="create_holiday_year" data-url="<?php echo base_url().'index.php/__cms_data_manager/create_holiday_year/' ?>">
  <div class="modal-dialog" style="width:50%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title h4"><?php echo freetext('create_new_holiday'); ?></h4>
      </div>
      <div class="modal-body">
        <div class="row m-b-sm m-l-sm m-r-sm">
          <div class="col-sm-6 font-bold"><?php echo freetext('year'); ?></div>
          <div class="col-sm-6"><input type="text" autocomplete="off" name="year" class="form-control" value="" maxlength="4"></div>
        </div>
      </div>
      <div class="modal-footer">          
        <a href="#" class="btn btn-primary create_holiday_btn" data-parent="#create_holiday_year"><i class="fa fa-plus"></i> <?php echo freetext('create'); ?></a>
        <a href="#" class="btn btn-danger" data-dismiss="modal"><?php echo freetext('cancel'); ?></a>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->  

<?php
  // echo "<pre>";
  // print_r($year_list);
  // echo "</pre>";
  if (!empty($year_list)) {
    foreach ($year_list as $year_obj) {
?>  
    <div class="edit_holiday_year modal fade" id="edit_holiday_year_<?php echo $year_obj['year'] ?>" data-year="<?php echo $year_obj['year'] ?>">
      <div class="modal-dialog" style="width:50%;">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title h4"><?php echo freetext('edit_new_holiday'); ?></h4>
          </div>
          <div class="modal-body" style="overflow-y:auto; max-height:300px;">
            <form method="post" action="<?php echo base_url().'index.php/__cms_data_manager/edit_holiday_year/' ?>">
              <input type="hidden" name="year" value="<?php echo $year_obj['year']; ?>">
            <?php
              if (!empty($year_obj['holiday_list'])) {
                $count = 0;
                foreach ($year_obj['holiday_list'] as $holiday) {
            ?>
                <div class="row m-b-sm m-l-sm m-r-sm">
                  <div class="col-sm-6 font-bold"><?php echo $holiday['title']; ?></div>
                  <div class="col-sm-5">
                      <input type='hidden' name="title_<?php echo $count; ?>" value="<?php echo $holiday['title'] ?>"/>
                      <input type='hidden' class="holiday_date" name="date_<?php echo $count; ?>" value="<?php echo $holiday['date'] ?>"/>
                      <div class='input-group date datetimepicker_input' data-year="<?php echo $year_obj['year']; ?>" data-date-format="DD.MM.YYYY">
                          <input type='text' class="form-control" disabled/>
                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                      </div>
                  </div>
                  <div class="col-sm-1 text-right">
                      <a href="#" class="btn btn-default del_holiday"><i class="fa fa-trash-o"></i></a>
                  </div>
                </div>
            <?php
                  $count++;
                }
              }
            ?>
            </form>
          </div>
          <div class="bg-light wrapper">
            <div class="row m-t-sm m-l-sm m-r-sm">
              <div class="col-sm-5 font-bold"><input type="text" autocomplete="off" class="add_holiday_title form-control"></div>
              <div class="col-sm-5">
                  <input type='hidden' class="holiday_date add_holiday_date" value=""/>
                  <div class='input-group date datetimepicker_input' data-year="<?php echo $year_obj['year']; ?>" data-date-format="DD.MM.YYYY">
                      <input type='text' class="form-control" disabled/>
                      <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                  </div>
              </div>
              <div class="col-sm-2 text-right">
                <a href="#" class="btn btn-default add_more_holiday"><i class="fa fa-plus"></i>&nbsp; Add</a>
              </div>
            </div>
          </div>
          <div class="modal-footer" style="margin-top:0px;">          
            <a href="#" class="btn btn-primary edit_holiday_btn" data-parent="#edit_holiday_year_<?php echo $year_obj['year'] ?>"><i class="fa fa-save"></i> <?php echo freetext('save'); ?></a>
            <a href="#" class="btn btn-danger" data-dismiss="modal"><?php echo freetext('cancel'); ?></a>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->  
<?php
    }
  }
?>