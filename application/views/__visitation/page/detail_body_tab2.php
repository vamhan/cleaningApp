<?php
  // $data_document = $query_documet->row_array();  

  $comment_before = "";
  $comment_after  = "";  

  if(!empty($data_document)){
    $id = $data_document['quotation_id'];

    $comment_before = $data_document['comment_before'];
    $comment_after  = $data_document['comment_after'];

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

  $position_list = $this->session->userdata('position');

  $children = array();
  foreach ($position_list as $key => $position) {
      $children = $this->__ps_project_query->getPositionChild($children, $position);
  }
?>
<section>    
  <div class="panel-body">
    <div class="form-group">       
      <div class="col-sm-12 add-all-medium">
        <div class="col-md-12">
          <div class="input-group m-b">
            <span class="input-group-addon" style="vertical-align:top; padding-top:15px;"><?php echo '<div class="label-width-adon"><span>'.freetext('comment_before_visit').'</span></div>'; ?></span>
            <textarea rows="10" class="form-control" name="comment_before" <?php if (empty($children) || (!empty($data_document['submit_date_sap']) && $data_document['submit_date_sap'] != '0000-00-00')) { echo 'disabled'; } ?> ><?php echo $comment_before; ?></textarea>
            <?php if (empty($children)) { ?><input type="hidden" name="comment_before" value="<?php echo $comment_before; ?>" ><?php } ?>
          </div>
        </div> 
        <div class="col-md-12">
          <div class="input-group m-b">
            <span class="input-group-addon" style="vertical-align:top; padding-top:15px;"><?php echo '<div class="label-width-adon"><span>'.freetext('comment_after_visit').'</span></div>'; ?></span>
            <textarea rows="10" class="form-control" name="comment_after" <?php if (empty($children)) { echo 'disabled'; } ?> ><?php echo $comment_after; ?></textarea>
            <?php if (empty($children)) { ?><input type="hidden" name="comment_after" value="<?php echo $comment_after; ?>" ><?php } ?>
          </div>
        </div> 
      </div>
    </div>
  </div>
</section>