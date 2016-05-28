<style type="text/css">
.dt_header{
display: none  !important;
}

.dt_footer .row-fluid{
display: none  !important;
}

</style>
<?php

 $data_quotation = $query_quotation->row_array();    
 if(!empty($data_quotation)){
  $ship_to_industry = $data_quotation['ship_to_industry'];
}else{
   $ship_to_industry ='';
}
//echo $ship_to_industry;
$this->db->select('sap_tbm_industry.title');
$this->db->where('sap_tbm_industry.id', $ship_to_industry);
$query = $this->db->get('sap_tbm_industry');
$query_industry = $query->row_array();
$industry_title_ship = $query_industry['title']; 
?>


<div class="div_detail" style="padding-left:50px;padding-right:50px;padding-bottom:50px;">
<h4 class="page-header font-bold tx-black"><i class="fa fa-leaf h5"></i> รายละเอียดการบริการ (<?php echo $industry_title_ship; ?>) </h4>


<div class="col-sm-12">
<section class="panel panel-default">
  <!-- <header class="panel-heading">Detail Service</header> -->
  <table class="table table-striped m-b-none">
    <thead>
      <tr>
        <th class="table-head">ชื่อเอกสาร</th>
        <th class="table-head">วันที่อัพโหลด</th>
        <th class="table-head">ประเภทธุรกิจ</th>
        <th class="table-head"></th>
      </tr>
    </thead>
   <!--  <tbody>      
      <tr>                    
       <td>1. Database(Quotation)</td>
       <td class="tx-center">
        <a  href='<?php echo site_url('assets/upload/doc_detail_service/Database(Quotation).xlsx'); ?>' target="_blank" data-toggle="modal" class="btn btn-default" type="button"><i class="fa fa-expand h5"></i> <?php echo freetext('view'); //View?></a>
        <a href='<?php  echo site_url('assets/upload/doc_detail_service/Database(Quotation).xlsx'); ?>'  download="<?php echo "Database(Quotation).xlsx"; ?>" class="btn btn-default  margin-left-medium" type="button"><i class="fa fa-download"></i> <?php echo freetext('download'); //Download?></a>
      </td> 
      </tr>
      <tr>                    
       <td>2. QTA_development_specification</td>
       <td class="tx-center">
        <a  href='<?php echo site_url('assets/upload/doc_detail_service/QTA_development_specification.doc'); ?>' target="_blank" data-toggle="modal" class="btn btn-default" type="button"><i class="fa fa-expand h5"></i> <?php echo freetext('view'); //View?></a>
        <a href='<?php  echo site_url('assets/upload/doc_detail_service/QTA_development_specification.doc'); ?>'  download="<?php echo "QTA_development_specification.doc"; ?>" class="btn btn-default  margin-left-medium" type="button"><i class="fa fa-download"></i> <?php echo freetext('download'); //Download?></a>
      </td> 
      </tr>
      <tr>                    
       <td>3. QTA_development_specification_pdf</td>
       <td class="tx-center">
        <a  href='<?php echo site_url('assets/upload/doc_detail_service/QTA_development_specification_pdf.pdf'); ?>' target="_blank" data-toggle="modal" class="btn btn-default" type="button"><i class="fa fa-expand h5"></i> <?php echo freetext('view'); //View?></a>
        <a href='<?php  echo site_url('assets/upload/doc_detail_service/QTA_development_specification_pdf.pdf'); ?>'  download="<?php echo "QTA_development_specification_pdf.pdf"; ?>" class="btn btn-default  margin-left-medium" type="button"><i class="fa fa-download"></i> <?php echo freetext('download'); //Download?></a>
      </td> 
      </tr>

    </tbody> -->
    <tbody>
           <tr>
                <td>รายละเอียดพื้นที่</td>
                <td>-</td>
                <td>-</td>
                <td class="text-right">
                <a  href='<?php echo site_url('__ps_quotation/loadAreaDoc/'.$this->quotation_id);?>' target="_blank" data-toggle="modal" class="btn btn-default" type="button"><i class="fa fa-expand h5"></i> <?php echo freetext('view'); //View?></a>
                <a href='<?php echo site_url('__ps_quotation/loadAreaDoc/'.$this->quotation_id);?>'  download="<?php echo site_url($doc_obj['description']);?>" class="btn btn-default  margin-left-small" type="button"><i class="fa fa-download"></i> <?php echo freetext('download'); //Download?></a>                  
                </td>
            </tr>

          <?php
          //get industry title
            $this->db->select('sap_tbm_industry.title');
            $this->db->where('sap_tbm_industry.id',  $ship_to_industry);
            $query = $this->db->get('sap_tbm_industry');
            $query_industry = $query->row_array();
            $industry_title = $query_industry['title']; 
            $doc       = $this->__ps_project_query->getObj('cms_document_other', array('industry_id' => $ship_to_industry), false, null, 'id desc,create_date desc');
            $doc_en    = $this->__ps_project_query->getObj('cms_document_other_en', array('industry_id' => $ship_to_industry), false, null, 'id desc,create_date desc');
            // echo "<pre>";
            // print_r($doc);
            // echo "<pre>";
            // print_r($doc_en);
          ?>
           <tr class="back-color-gray"><td class="h6" colspan="4">เอกสารบริการ (TH)</td></tr>
            <?php
              if (!empty($doc)) {
            ?>
              <tr>
                <td><?php echo $doc['description']; ?></td>
                <td><?php echo $doc['create_date']; ?></td>
                <td><?php echo $industry_title; ?></td>
                <td class="text-right">
                <a  href='<?php echo site_url($doc['path']);?>' target="_blank" data-toggle="modal" class="btn btn-default" type="button"><i class="fa fa-expand h5"></i> <?php echo freetext('view'); //View?></a>
                <a href='<?php echo site_url($doc['path']);?>'  download="<?php echo site_url($doc['description']);?>" class="btn btn-default  margin-left-small" type="button"><i class="fa fa-download"></i> <?php echo freetext('download'); //Download?></a>                  
                </td>
              </tr>
            <?php }else{
                    echo "<tr><td class=' h5' colspan='4'>ไม่มีข้อมูล</td></tr>";
                  } 
            ?>
             <tr class="back-color-gray"><td class="h6" colspan="4">เอกสารบริการ (EN)</td></tr>
             <?php
              if (!empty($doc_en)) {
            ?>
              <tr>
                <td><?php echo $doc_en['description']; ?></td>
                <td><?php echo $doc_en['create_date']; ?></td>
                <td><?php echo $industry_title; ?></td>
                <td class="text-right">
                <a  href='<?php echo site_url($doc_en['path']);?>' target="_blank" data-toggle="modal" class="btn btn-default" type="button"><i class="fa fa-expand h5"></i> <?php echo freetext('view'); //View?></a>
                <a href='<?php echo site_url($doc_en['path']);?>'  download="<?php echo site_url($doc_en['description']);?>" class="btn btn-default  margin-left-small" type="button"><i class="fa fa-download"></i> <?php echo freetext('download'); //Download?></a>                  
                </td>
              </tr>
            <?php }else{
                    echo "<tr><td class=' h5' colspan='4'>ไม่มีข้อมูล</td></tr>";
                  } 
            ?>



          <?php
            // $row_count =0;
            // // echo $ship_to_industry;
            // // echo "<pre>";
            // // print_r($doc_list);
            // if (!empty($doc_list)) {
            //   foreach ($doc_list as $key => $obj) {                
            //     foreach ($obj as $key => $doc_obj) {
            //     if($ship_to_industry==$doc_obj['industry_id']){
            //     $row_count++;
            //     //get path
            //     $this->db->select('sap_tbm_industry.title');
            //     $this->db->where('sap_tbm_industry.id', $doc_obj['industry_id']);
            //     $query = $this->db->get('sap_tbm_industry');
            //     $query_industry = $query->row_array();
            //     $industry_title = $query_industry['title']; 
          ?>
             <!--  <tr>
                <td><?php //echo $doc_obj['description']; ?></td>
                <td><?php// echo $doc_obj['create_date']; ?></td>
                <td><?php //echo $industry_title; ?></td>
                <td class="text-right">
                <a  href='<?php //echo site_url($doc_obj['path']);?>' target="_blank" data-toggle="modal" class="btn btn-default" type="button"><i class="fa fa-expand h5"></i> <?php echo freetext('view'); //View?></a>
                <a href='<?php //echo site_url($doc_obj['path']);?>'  download="<?php echo site_url($doc_obj['description']);?>" class="btn btn-default  margin-left-small" type="button"><i class="fa fa-download"></i> <?php echo freetext('download'); //Download?></a>                  
                </td>
              </tr> -->
          <?php
            //     }//endif
            //   }
            //   }//end foreach
            //   if($row_count==0){
            //      echo "<tr><td class=' h5' colspan='4'>ไม่มีข้อมูล</td></tr>";
            //   }//end if row_count
            // } else {
          ?>
             <!--  <tr><td class="h5" colspan="4">ไม่มีข้อมูล</td></tr> -->
          <?php
           // }
          ?>


      </tbody>
  </table>
</section>
</div>



<!-- form submit -->
<div class="form-group col-sm-12 ">
  <div class="pull-right">
    <a href="<?php echo site_url($this->page_controller.'/listview/'.$this->quotation_id); ?>"  class="btn btn-info" style="width:120px;"> <?php echo freetext('back'); ?></a>
  </div>
</div>
<!-- end : form submit -->
</div><!-- end : class div_detail -->


          











