<style type="text/css">
.dt_header{
display: none  !important;
}

.dt_footer .row-fluid{
display: none  !important;
}

</style>




<div class="div_detail" style="padding-left:50px;padding-right:50px;padding-bottom:50px;">
<h4 class="page-header font-bold tx-black"><i class="fa fa-leaf h5"></i> สัญญา </h4>


<!--################################ start : download contact doc ############################-->
<section class="panel panel-default ">               
     <div class="panel-heading" style="padding-bottom :24px;">
       <font class="font-bold h5"> <?php echo freetext('contract_doc'); ?></font>
    </div>

    <div class="panel-body"> 
      <div class="form-group">
        <div class="col-sm-12 add-all-medium">
          <a href="#" class="btn btn-primary download_btn download_contract_th"><i class="fa fa-download"></i> สัญญาว่าจ้างทำความสะอาด</a>
        </div>                    
      </div><!--end : form-group -->
  </div><!--end : panel-body -->
</section>
 <!--################################ end : download contact doc ############################-->



 <!-- form submit -->
<div class="form-group col-sm-12 ">
  <div class="pull-right">
    <a href="<?php echo site_url($this->page_controller.'/listview/'.$this->quotation_id); ?>"  class="btn btn-info" style="width:120px;"> <?php echo freetext('back'); ?></a>
   
  </div>
</div>
<!-- end : form submit -->

</div><!-- end : class div_detail -->