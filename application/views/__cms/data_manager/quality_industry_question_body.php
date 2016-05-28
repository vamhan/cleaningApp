<!-- start : content -->
<section class="vbox">
  <section class="scrollable padder">
    <section class="panel panel-default">
      <header class="panel-heading" style="height:55px;">
        <div class="col-sm-4 pull-right text-right">
          <a href="<?php echo site_url('__cms_data_manager/quality_question_management'); ?>" class="btn btn-info"><i class="fa fa-reply"></i> กลับ</a>
        </div>
        <div class="col-sm-8">
          <?php echo $this->page_title; ?>
        </div>                  
      </header>
      <table class="table table-striped m-b-none">
          <thead>
            <tr>    
              <th width="20%">รหัส</th>
              <th width="70%">ชื่อ</th>    
              <th>&nbsp;</th>                 
            </tr>
          </thead>
          <tbody>
          <?php
            if (!empty($industry_room_list)) {
              foreach ($industry_room_list as $key => $industry_room) {
          ?>
              <tr>
                <td><?php echo $industry_room['id']; ?></td>
                <td><?php echo $industry_room['title']; ?></td>
                <td class="text-right">
                  <a href="<?php echo site_url('__cms_data_manager/quality_industry_room_question/'.$industry_room['industry_id'].'/'.$industry_room['id']); ?>" class="btn btn-default"><i class="fa fa-pencil"></i></a>
                </td>
              </tr>
          <?php
              }
            } else {
          ?>
            <tr><td colspan="3" class="text-center"><?php echo freetext('empty'); ?></td></tr>
          <?php
            }
          ?>
          </tbody>
      </table>
    </section>
  </section>
</section>
<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>       