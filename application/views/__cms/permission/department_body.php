<!-- start : content -->
<section class="vbox">
  <section class="scrollable padder">
    <section class="panel panel-default">
      <header class="panel-heading">
        <div class="row">
          <a href="#" class="btn btn-primary m-r-md pull-right save_btn"><i class="fa fa-save"></i>&nbsp;<?php echo freetext('save'); ?></a>
          <?php echo $this->page_title; ?>                  
        </div>
      </header>
      <div class="panel-body">
        <form id="form_save" method="post" action="<?php echo site_url('__cms_permission/map_dept_function'); ?>">
          <div class="dd nestable">
          <?php
            if (!empty($department_html)) {
              echo $department_html;
            }
          ?>
          </div>
        </form>
      </div>
    </section>
  </section>
</section>
<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>        
