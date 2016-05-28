<!-- start : content -->
<section class="vbox">
  <section class="scrollable padder">
    <section class="panel panel-default">
      <header class="panel-heading">
        <?php echo $this->page_title; ?>       
      </header>
      <div class="panel-body">
        <form id="form_ele" method="post" action="<?php echo site_url('__cms_data_manager/update_threshold'); ?>">
          <div style="padding-top:15px;padding-right:5px;">
            ตัดรอบแผนงานทุกวันที่&nbsp;&nbsp;
            <a href="#" class="btn btn-default btn-xs minus_freq manual_field"><i class="fa fa-minus"></i></a>
            <input type="text" autocomplete="off" onkeypress="return false;" onkeydown="return false;" name="threshold" class="form-control inline m-l-xs m-r-xs manual_field" style="width:60px;"  value="<?php if (!empty($threshold) && $threshold['is_auto'] == 0 && !empty($threshold['threshold'])) { echo $threshold['threshold']; } ?>">
            <a href="#" class="btn btn-default btn-xs plus_freq manual_field"><i class="fa fa-plus"></i></a>
            &nbsp;&nbsp;ของเดือน</div>        
          <div style="padding-top:15px;padding-right:5px;"><input type="checkbox" class="is_auto" name="is_auto" value="1" <?php if (!empty($threshold) && $threshold['is_auto'] == 1) { echo 'checked; } ?>> วันสุดท้ายของเดือน</div>
        </form>
      </div>
      <div class="panel-footer text-right">
        <a href="#" class="btn btn-primary save_btn"><i class="fa fa-save"></i>&nbsp;บันทึก</a>
      </div>
    </section>
  </section>
</section>