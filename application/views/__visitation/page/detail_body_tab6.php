<?php
  // $data_document = $query_documet->row_array();  

  $not_visit_reason = '';

  if(!empty($data_document)){
    $id = $data_document['quotation_id'];

    $not_visit_reason = $data_document['not_visit_reason_id'];

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
  // foreach ($position_list as $key => $position) {
  //     $children = $this->__ps_project_query->getPositionChild($children, $position);
  // }
?>
<section>   
  <div class="panel-body">
    <div class="form-group">       
      <div class="col-sm-12 add-all-medium">
        <div class="col-md-12">
          <div class="input-group m-b">
            <span class="input-group-addon"><?php echo '<div class="label-width-adon"><span class="pull-left">'.freetext('reason_for_not_visit').'</span></div>'; ?></span>
            <select  name="not_visit_reason_id" class="form-control" <?php if (!empty($children)) { echo 'disabled'; } ?>>
                    <option value=''>--- กรุณาเลือก<?php echo freetext('reason_for_not_visit'); ?> ---</option>  
              <?php
                foreach ($not_visit_reason_list as $reason) {
                  $selected = '';
                  if ($not_visit_reason == $reason['id']) {
                    $selected = ' selected';
                  }
              ?>
                  <option value="<?php echo $reason['id']; ?>"<?php echo $selected; ?>><?php echo $reason['title']; ?></option>
              <?php
                }
              ?>
            </select>
          </div>
        </div>  
        <div class="col-md-12">
          <div class="input-group">
            <span class="input-group-addon" style="vertical-align:top; padding-top:15px;"><?php echo '<div class="label-width-adon"><span class="pull-left">'.freetext('other_reason_for_not_visit').'</span></div>'; ?></span>
            <textarea  name="not_visit_reason_other" rows="15" class="form-control" <?php if (!empty($children)) { echo 'disabled'; } ?>><?php echo $data_document['not_visit_reason_other']; ?></textarea>
          </div>
        </div>  
      </div>
    </div>               
  </div>
</section>