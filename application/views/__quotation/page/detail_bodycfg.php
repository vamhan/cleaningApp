<style type="text/css">
.dt_header{
display: none  !important;
}

.dt_footer .row-fluid{
display: none  !important;
}

</style>
          
<?php 

 if( $this->act =='edit_quotation' ||  $this->act =='view_quotation'){ 
    $data_type = $query_quotation->row_array();
     if(!empty($data_type)){      
         $job_type_tab  = $data_type['job_type']; 
         $acc_gr  = $data_type['account_group'];     
         //echo $job_type_tab;
      }else{
        $job_type_tab =''; 
        $acc_gr='';   
      }
}

?>
<div class="div_detail">         
<!-- href="<?php //echo site_url($this->page_controller.'/convert_to_quotation/'. $this->prospect_id); ?>"  -->
<!-- ###########################33 start : tab contact or other #########################-->
             <?php  if( $this->act !='edit_quotation' &&  $this->act !='view_quotation'){ ?>
             <div class="col-sm-12 padd-all-medium">
               <!--  <form role="form" action="<?php //echo site_url($this->page_controller.'/convert_to_quotation/'. $this->prospect_id); ?>" method="POST" onSubmit="return fieldCheck_convert();"> 
               -->  <a href="<?php echo site_url($this->page_controller.'/listview_quotation'); //site_url($this->page_controller.'/create_to_quotation/'. $this->prospect_id); ?>" disabled class="btn btn-s-md btn-info pull-right create_to_quotation"><i class="fa fa-share h5"></i> <?php echo freetext('create_to_quotation'); ?></a>
                <!-- </form> -->
             </div>
             <?php } ?>
              <div class="panel row">               
                  <div class="panel-collapse in"> 
                    <div class="panel-body text-sm">                        
                     <!-- .nav-justified -->
                      <section class="panel panel-default">
                        <header class="panel-heading bg-light">
                          <ul class="nav nav-tabs nav-justified" id="tabs">
                            <?php  
                              if( $this->act =='edit_quotation' ||  $this->act =='view_quotation'){                                 
                              ?>
                              <li class="h5  tab1"><a href="#tab1" data-toggle="tab"><?php echo freetext('customer');?></a></li>
                              <?php //if( $job_type_tab !='ZQT3' && $job_type_tab !='ZQT2_extra' ){ ?> 
                              <li class="h5  tab2"><a href="#tab2" data-toggle="tab"><?php echo freetext('area');?></a></li>  
                              <?php //} ?>                          
                              <li class="h5  tab3"><a href="#tab3" data-toggle="tab"><?php echo freetext('chemical_others'); ?></a></li>                              
                              <li class="h5  tab4"><a href="#tab4" data-toggle="tab"><?php echo freetext('staff_quotation');?></a></li> 
                               <?php if( $job_type_tab =='ZQT1'){ ?> 
                              <li class="h5  tab5"><a href="#tab5" data-toggle="tab"><?php echo freetext('clearing_job');?></a></li> 
                              <li class="h5  tab6"><a href="#tab6" data-toggle="tab"><?php echo freetext('other_service');?></a></li>                                <?php }//end if ?> 
                               
                              <li class="h5  tab7"><a href="#tab7" data-toggle="tab"><?php echo freetext('summary');?></a></li>                                
                            <?php }else{?>
                              <li class="h5 active tab1_p" ><a href="#tab1" data-toggle="tab"><?php echo freetext('customer');?></a></li>
                              <li class="h5"></li>
                            <?php } ?>
                          </ul>
                        </header>
                        <div class="panel-body">
                          <div class="tab-content">

                             <?php if( $this->act =='edit_quotation' ||  $this->act =='view_quotation'){ ?>
                            <!--################## start : tab1 ################## -->
                            <div class="tab-pane " id="tab1">
                              <!-- tab1 -->
                               <?php $this->load->view('__quotation/page/detail_body_tab1'); ?>                              
                            </div><!-- end : div tab1 -->
                            <!--################## End : tab1 ################## -->


                            <!--################## start : tab2 ################## -->
                            <div class="tab-pane" id="tab2" >
                              <!-- tab2 -->
                               <?php $this->load->view('__quotation/page/detail_body_tab2'); ?> 
                            </div>
                            <!--################## END : tab2 ################## -->

                             <!--################## start : tab3 ################## -->
                            <div class="tab-pane" id="tab3">
                             <!--  tab3 -->
                                <?php $this->load->view('__quotation/page/detail_body_tab3'); ?> 
                            </div>
                            <!--################## END : tab3 ################## -->

                             <!--################## start : tab4 ################## -->
                            <div class="tab-pane " id="tab4">
                              <!-- tab4 -->
                              <?php $this->load->view('__quotation/page/detail_body_tab4'); ?> 
                            </div>
                            <!--################## END : tab4 ################## -->

                            <!--################## start : tab5 ################## -->
                            <div class="tab-pane " id="tab5">
                              <!-- tab5 -->
                              <?php $this->load->view('__quotation/page/detail_body_tab5'); ?> 
                            </div>
                            <!--################## END : tab5 ################## -->

                            <!--################## start : tab6 ################## -->
                            <div class="tab-pane" id="tab6">
                              <!-- tab6 -->
                               <?php $this->load->view('__quotation/page/detail_body_tab6'); ?> 
                            </div>
                            <!--################## END : tab6 ################## -->

                            <!--################## start : tab7 ################## -->
                            <div class="tab-pane " id="tab7">
                              <!-- tab7 -->
                               <?php $this->load->view('__quotation/page/detail_body_tab7'); ?> 
                            </div>
                            <!--################## END : tab7 ################## -->   
                             <?php }else{?>
                                  <!--################## start : tab1 ################## -->
                                  <div class="tab-pane active" id="tab1_p">
                                   <!--  tab1 -->
                                     <?php $this->load->view('__quotation/page/detail_body_prospect_tab1'); ?>                              
                                  </div><!-- end : div tab1 -->
                                  <!--################## End : tab1 ################## -->
                            <?php } ?>


                  </div>
              </div><!-- end : class div_detail -->
            </section><!-- end : scrollable padder -->
          </section><!-- end : class vbox -->
          <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>



          











