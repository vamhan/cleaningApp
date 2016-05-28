<style type="text/css">
.dt_header{
display: none  !important;
}

.dt_footer .row-fluid{
display: none  !important;
}

</style>

<div class="div_detail" style="padding-left:50px;padding-right:50px;padding-bottom:50px;">
<h4 class="page-header font-bold tx-black"><i class="fa fa-leaf h5"></i>ไฟล์ที่จะแนบ (ส่วนบริการ) </h4>


<!--################################ start : important docment ############################-->
<section class="panel panel-default ">               
     <div class="panel-heading" style="padding-bottom :24px;">
       <font class="font-bold h5">เอกสาร</font>
    </div>

    <div class="panel-body"> 
      <div class="form-group">
        <div class="col-sm-12 add-all-medium">
          <div class="col-sm-12">
            <section class="panel panel-default">
                  <table  class=" table  m-b-none ">
                      <thead>
                        <tr class="back-color-gray">
                          <th width="55%"><?php echo freetext('name_file_upload'); //name?></th>
                          <th class="tx-center">Action</th>                          
                        </tr>
                      </thead>
                      <tbody>
                         <?php 
                            $temp_ohter = $query_doc_other->result_array();
                           if(!empty($temp_ohter)){
                             foreach($query_doc_other->result_array() as $value){                               
                          ?>
                            
                              <tr id="<?php echo $value['id'];?>">
                              <td><?php echo $value['description'];?></td>
                              <td class="tx-center">
                                <a  href='<?php echo site_url($value['path']);?>' target="_blank" data-toggle="modal" class="btn btn-default" type="button"><i class="fa fa-expand h5"></i> <?php echo freetext('view'); //View?></a>
                                <a href='<?php echo site_url($value['path']);?>'  download="<?php echo site_url($value['description']);?>" class="btn btn-default  margin-left-small" type="button"><i class="fa fa-download"></i> <?php echo freetext('download'); //Download?></a>                                
                              </td> 
                            </tr>
                            <?php
                               }
                              }else{ echo '<tr><td colspan="3">ไม่มีข้อมูล</td></tr>'; }
                            ?>
                           
                      </tbody> 
                  </table>
               </section> 
             </div>
             <div class='clear:both'></div>
        

          </div> <!-- end : col12 -->                        
      </div><!--end : form-group -->
  </div><!--end : panel-body -->
</section>
 <!--################################ end : important docment ############################-->







<!-- form submit -->
<div class="form-group col-sm-12 ">
  <div class="pull-right">
    <a href="<?php echo site_url($this->page_controller.'/listview/'.$this->quotation_id); ?>"  class="btn btn-info" style="width:120px;"> <?php echo freetext('back'); ?></a>
   
  </div>
</div>
<!-- end : form submit -->

</div><!-- end : class div_detail -->