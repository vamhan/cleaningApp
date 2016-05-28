<?php

// var_dump($query);
?>

<style type="text/css">

.accordion-toggle{
  color :#fff !important;
}
.accordion-toggle:hover{
  color :#ddd !important;
}


</style>

<section class="vbox">
<section class="scrollable padder">


<!-- start : top project  -->
<div class="panel panel-default  pos-rlt clearfix  no-border no-radius b-b b-light pull-in" style="z-index:9;">
    <!-- start : panel heading -->
    <div class="panel-heading fix-top">
       <ul class="nav nav-pills pull-right">        
          <li>
            <a data-toggle="collapse" data-parent="#accordion2" href="#collapseOne"  class="accordion-toggle text-muted togle-project"><i class="icon_project_down fa fa-caret-down text-active"></i><i class="icon_project_up fa fa-caret-up "></i></a>
          </li>
      </ul>
      <a class="accordion-toggle togle-project " data-toggle="collapse" data-parent="#accordion2" href="#collapseOne" style='text-transform:uppercase'>               
        <?php echo freetext('action_plan'); ?>
        <?php
          if (!empty($result) && array_key_exists('id', $result) && !empty($result['id'])) {
        ?>
            <span class="pull-right margin-right-medium tx-white">Project [ <?php echo $result['id']; ?> ]</span>
        <?php
          } 
        ?>
      </a>
    </div>
    <!-- end : panel heading -->


    <!-- start : collapse -->
    <div id="collapseOne" class="panel-collapse collapse">
      <?php echo $result['view']; ?>
    </div>
    <!-- end : collapse -->
</div>
 <!-- End : top project -->








