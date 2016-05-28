<section>  
<?php 

  // $data_document = $query_documet->row_array();    

  $doc_id = 0;

  if(!empty($data_document)){
    $doc_id = $data_document['id'];

    $id = $data_document['quotation_id'];
    if (empty($id)) {
      $id = $data_document['prospect_id'];
      $this->db->where('id', $id);
      $query_quotation = $this->db->get('tbt_prospect');
      $data_quotation = $query_quotation->row_array(); 
      $is_prospect  = 1;
    } else {
      $query_quotation = $this->__quotation_model->get_quotationByid($id);
      $data_quotation = $query_quotation->row_array(); 
      $is_prospect  = 0;
    }
  }  

  if (!$is_prospect) {
    $query_contact = $this->__quotation_model->get_contact_quotation($id);
  } else {
    $query_contact = $this->__quotation_model->get_contact_prospect($id);
  }

  $temp_query_contact = $query_contact->result_array();

?>   
  <form id="upload_form" action="<?php echo site_url('__ps_visitation/upload_image/'.$doc_id ); ?>" method="post" enctype="multipart/form-data"> 
    <div class="panel-body">
      <section class="panel panel-default ">               
        <div class="panel-heading" style="padding-bottom :24px;">
          <font class="font-bold"> <?php echo freetext('attach_file'); ?></font>        
        </div>
        <div class="panel-body"> 
            <table  class=" table">
                <thead>
                    <tr class="back-color-gray">
                        <th width="70%"><?php echo freetext('name_file_upload'); //name?></th>
                        <th>&nbsp;</th>                          
                    </tr>
                </thead>
                <tbody>
                <?php
                  if (!empty($image_list)) {
                    foreach ($image_list as $key => $image) {
                      $image_path = site_url($image['path']);
                      $ext = strtolower(pathinfo($image_path, PATHINFO_EXTENSION));
                ?>
                    <tr>
                      <td width='70%'><?php echo $image['file_name']; ?></td>
                      <td class="text-right">
                      <?php
                        if ($ext == 'jpg' || $ext == 'png' || $ext == 'gif') {
                      ?>
                        <a href="#" class="btn btn-default view_image" data-image="<?php echo $image_path; ?>"><i class="fa fa-eye"></i>&nbsp;<?php echo freetext('view'); ?></a>
                      <?php
                        }
                      ?>
                        <a href="<?php echo site_url('__ps_visitation/download/?img='.urlencode($image['path'])); ?>" class="btn btn-default download_image"><i class="fa fa-download"></i>&nbsp;<?php echo freetext('download'); ?></a>
                        <a href="#" class="btn btn-default delete_image" data-id="<?php echo $image['id']; ?>"><i class="fa fa-trash-o"></i>&nbsp;<?php echo freetext('delete'); ?></a>
                      </td>
                    </tr>
                <?php
                    }
                  } else {
                ?>
                    <tr>
                      <td colspan="2">ไม่มีข้อมูล</td>
                    </tr>
                <?php
                  }
                ?>
                </tbody> 
            </table>
            <div class="col-sm-12 upload_panel" style="border-top: 1px solid #d4d4d4;padding-top: 20px;">                                               
                <div class="col-sm-10">
                    <input type="file" name="uploadFile" class="filestyle" data-icon="false" data-classButton="btn btn-default btn-sm col-sm-2 pull-left" data-classInput="pull-left h3 col-sm-10">
                </div>
                <div class="col-sm-2 ">
                    <a href="#" id="upload_btn" class="btn btn-s-md btn-info pull-left btn-sm"><i class="fa fa-upload h5"></i>  <?php echo freetext('upload'); //Upload?></a> 
                </div>
            </div>   
        </div><!--end : panel-body -->
      </section>
    </div>
  </form>
</section>