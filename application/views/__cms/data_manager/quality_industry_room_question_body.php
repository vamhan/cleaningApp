<!-- start : content -->
<section class="vbox">
  <section class="scrollable padder">
    <section class="panel panel-default">
      <header class="panel-heading" style="height:55px;">
        <div class="col-sm-4 pull-right text-right">
          <a href="<?php echo $this->back_url; ?>" class="btn btn-info"><i class="fa fa-reply"></i> กลับ</a>
          <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#create_area_question"><i class="fa fa-plus"></i> สร้าง</a>
        </div>
        <div class="col-sm-8">
          <?php echo $this->page_title; ?>
        </div>                  
      </header>
      <table class="table table-striped m-b-none">
        <thead>
          <tr>    
            <th width="20%">ข้อ</th>  
            <th width="70%">คำถาม</th>  
            <th>&nbsp;</th>                 
          </tr>
        </thead>
        <tbody>
        <?php
          if (!empty($industry_room_question_list)) {
            foreach ($industry_room_question_list as $key => $question) {
        ?>
            <tr>
              <td><?php echo $question['sequence_index']; ?></td>
              <td><?php echo $question['title']; ?></td>
              <td class="text-right">
                <a href="#" class="btn btn-default edit_btn" data-id="<?php echo $question['id']; ?>" data-index="<?php echo $question['sequence_index']; ?>" data-title="<?php echo $question['title']; ?>"><i class="fa fa-pencil"></i></a>
                <a href="#" class="btn btn-default del_btn" data-id="<?php echo $question['id']; ?>"><i class="fa fa-trash-o"></i></a>
              </td>
            </tr>
        <?php
            }
          } else {
        ?>
          <tr><td colspan="3" class="text-center"><?php echo freetext('empty_question'); ?></td></tr>
        <?php
          }
        ?>
        </tbody>
      </table>
    </section>
  </section>
</section>
<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>       