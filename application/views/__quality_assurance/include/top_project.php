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
        <?php echo $this->page_title; ?>
        <span><a href="<?php echo site_url('__ps_complain/detail_complain/insert_complain/'.$detail['contract_id']); ?>" target="_blank" class="pull-right  margin-right-medium btn btn-xs btn-info btn-complain" style="width:120px;"> <?php echo freetext('complain'); ?></a></span>
        <span class="pull-right margin-right-medium tx-white"><?php echo $detail['customer_name'].' - '.$detail['shop_to_title'].' - '.$detail['ship_to_id']; ?></span>
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








