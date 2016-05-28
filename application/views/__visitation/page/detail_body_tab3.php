<section>  
<?php 
  
  $function = $this->session->userdata('function');
  // $data_document = $query_documet->row_array();    

  $contact_id  = '';
  $conclusion  = '';
  $detail      = '';
  $comment     = '';

  $cpt_time    = '';
  $cpt_unit    = '';
  $cpt_start   = '';
  $cpt_end     = '';
  $cpt_price   = '';
  $cpt_comment = '';

  if(!empty($data_document)){
    $id = $data_document['quotation_id'];

    $contact_id  = $data_document['contact_id'];
    $conclusion  = $data_document['conclusion'];
    $detail      = $data_document['detail'];
    $comment     = $data_document['comment'];

    $cpt_time    = $data_document['cpt_time'];
    $cpt_unit    = $data_document['cpt_unit_time'];
    $cpt_start   = $data_document['cpt_start'];
    $cpt_end     = $data_document['cpt_end'];
    $cpt_price   = $data_document['cpt_price'];
    $cpt_comment = $data_document['cpt_comment'];

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

  $sap_contact_result = array();
  
  if (!$is_prospect) {
    $query_contact = $this->__quotation_model->get_contact_quotation($id);

    $this->db->where('id',$id); 
    $query = $this->db->get('tbt_quotation');
    $quotation = $query->row_array();

    $this->db->select('sap_tbm_contact.*, sap_tbm_department.title As department_title'); 
    $this->db->select('sap_tbm_function.description As function_title'); 
    $this->db->join('sap_tbm_department', 'sap_tbm_department.id = sap_tbm_contact.department','left');
    $this->db->join('sap_tbm_function', 'sap_tbm_function.id = sap_tbm_contact.function','left');
    $this->db->where('sap_tbm_contact.ship_to_id', $quotation['ship_to_id']); 
    $query = $this->db->get('sap_tbm_contact');
    $sap_contact_result = $query->result_array();

  } else {
    $query_contact = $this->__quotation_model->get_contact_prospect($id);
  }

  $temp_query_contact = $query_contact->result_array();

  // $competitor_name = '';
  // $this->db->where('competitor_id', $data_quotation['competitor_id']);
  // $query = $this->db->get('sap_tbm_competitor');
  // $competitor = $query->row_array();
  // if (!empty($competitor)) {
  //   $competitor_name = $competitor['competitor_name'];
  // }
 

  $position_list = $this->session->userdata('position');

  $children = array();
  // foreach ($position_list as $key => $position) {
  //     $children = $this->__ps_project_query->getPositionChild($children, $position);
  // }


?>   
  <div class="panel-body">
    <section class="panel panel-default ">               
      <div class="panel-heading" style="padding-bottom :24px;">
        <font class="font-bold"> <?php echo freetext('visitation'); ?></font>        
      </div>
      <div class="panel-body"> 
        <div class="form-group">
          <div class="col-sm-12 add-all-medium">
            <div class="col-md-12">
              <div class="input-group m-b">
                <span class="input-group-addon"><?php echo '<div class="label-width-adon"><span class="pull-left">'.freetext('contact').'</span></div>'; ?></span>
                <select class="form-control" name="contact_id" <?php if (!empty($children)) { echo 'disabled'; } ?>>
                    <option value="">-- กรุณาเลือกผู้ติดต่อ --</option>
                <?php
                  if (!empty($temp_query_contact)) {
                    foreach ($temp_query_contact as $key => $contact) {
                      $selected = '';
                      if ($contact_id == $contact['id']) {
                        $selected = ' selected';
                      }
                ?>
                      <option value="<?php echo $contact['id'] ?>"<?php echo $selected; ?>><?php echo $contact['title'].' '.$contact['firstname'].' '.$contact['lastname']; ?></option>
                <?php
                    }
                  }
                  if (!empty($sap_contact_result)) {
                    foreach ($sap_contact_result as $key => $contact) {
                      $selected = '';
                      if ($contact_id == $contact['id']) {
                        $selected = ' selected';
                      }
                ?>
                      <option value="<?php echo $contact['id'] ?>"<?php echo $selected; ?>><?php echo $contact['title'].' '.$contact['firstname'].' '.$contact['lastname']; ?></option>
                <?php
                    }
                  }
                ?>
                </select>
              </div>
            </div> 
            <div class="col-md-12">
              <div class="input-group m-b">
                <span class="input-group-addon"><?php echo '<div class="label-width-adon"><span class="pull-left">'.freetext('conclusion').'</span></div>'; ?></span>
                <input type="text" autocomplete="off" <?php if (!empty($children)) { echo 'disabled'; } ?> class="form-control" name="conclusion" value="<?php echo $conclusion; ?>" >
              </div>
            </div> 
            <div class="col-md-12">
              <div class="input-group m-b">
                <span class="input-group-addon" style="vertical-align:top; padding-top:15px;"><?php echo '<div class="label-width-adon"><span class="pull-left">'.freetext('detail').'</span></div>'; ?></span>
                <textarea rows="5" class="form-control" <?php if (!empty($children)) { echo 'disabled'; } ?> name="detail"><?php echo $detail; ?></textarea>
              </div>
            </div> 
            <div class="col-md-12">
              <div class="input-group m-b">
                <span class="input-group-addon" style="vertical-align:top; padding-top:15px;"><?php echo '<div class="label-width-adon"><span class="pull-left">'.freetext('comment').'</span></div>'; ?></span>
                <textarea rows="5" class="form-control" <?php if (!empty($children)) { echo 'disabled'; } ?> name="comment"><?php echo $comment; ?></textarea>
              </div>
            </div> 
          </div> <!-- end : col12 -->                        
        </div><!--end : form-group -->
      </div><!--end : panel-body -->
    </section>
  <?php
    if (in_array('CR', $function) || in_array('MK', $function)) {
  ?>
    <section class="panel panel-default ">   
      <?php
        $competitor = $data_document['competitor'];
        $competitor_name = '';
        if (!empty($competitor)) {
          $competitor_name = $competitor['competitor_name'];
        }

      ?>            
      <div class="panel-heading" style="padding-bottom :24px;">
        <font class="font-bold"> <?php echo freetext('competitor'); ?></font>        
      </div>
      <div class="panel-body"> 
        <div class="form-group">
          <div class="col-sm-12 add-all-medium"> 
            <div class="col-sm-12 no-padd"> 
              <div class="col-md-6 ">
                <div class="input-group m-b">
                  <span class="input-group-addon"><?php echo '<div class="label-width-adon"><span class="pull-left">'.freetext('competitor').'</span></div>'; ?></span>
                  <input type="text" autocomplete="off" <?php if (!empty($children)) { echo 'disabled'; } ?> class="form-control" disabled value="<?php echo $competitor_name; ?>" >
                </div>
              </div> 
              <div class="col-md-6">
                <div class="col-sm-7 no-padd">
                  <div class="input-group m-b">
                    <span class="input-group-addon"><?php echo '<div class="label-width-adon"><span class="pull-left">'.freetext('time').'</span></div>'; ?></span>
                    <input type="text" autocomplete="off" <?php if (!empty($children)) { echo 'disabled'; } ?> class="form-control" name="cpt_time" value="<?php echo $cpt_time; ?>" >
                  </div>
                </div>
                <div class="col-sm-5" style="padding-right:0px;">
                  <select class="form-control" name="cpt_unit_time"  <?php if (!empty($children)) { echo 'disabled'; } ?>>
                      <option value="">-- Unit --</option>
                      <option value="day"<?php if ($cpt_unit == 'day') { echo ' selected'; }?>>Day</option>
                      <option value="month"<?php if ($cpt_unit == 'month') { echo ' selected'; }?>>Month</option>
                  </select>
                </div>
              </div> 
            </div>  
            <div class="col-sm-12 no-padd"> 
              <div class="col-md-6 ">
                <div class="input-group m-b">
                  <span class="input-group-addon"><?php echo '<div class="label-width-adon"><span class="pull-left">'.freetext('start_project').'</span></div>'; ?></span>                    
                  <input type='hidden' class="cpt_start form-control" name="cpt_start" value="<?php echo $cpt_start; ?>"/>
                  <div class='input-group date' style="width:100%" id='cpt_start' data-date-format="DD.MM.YYYY">
                      <input type='text' class="form-control" disabled/>
                      <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                  </div>
                </div>
              </div> 
              <div class="col-md-6">
                <div class="input-group m-b">
                  <span class="input-group-addon"><?php echo '<div class="label-width-adon"><span class="pull-left">'.freetext('end_project').'</span></div>'; ?></span>
                  <input type='hidden' class="cpt_end form-control" name="cpt_end" value="<?php echo $cpt_end; ?>"/>
                  <div class='input-group date' style="width:100%" id='cpt_end' data-date-format="DD.MM.YYYY">
                      <input type='text' class="form-control" disabled/>
                      <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                  </div>
                </div>
              </div> 
            </div>  

            <div class="col-sm-12 no-padd"> 
              <div class="col-md-6 ">
                <div class="input-group m-b">
                  <span class="input-group-addon"><?php echo '<div class="label-width-adon"><span class="pull-left">'.freetext('price_month').'</span></div>'; ?></span>
                  <input type="text" autocomplete="off"  <?php if (!empty($children)) { echo 'disabled'; } ?> class="form-control text-right cpt_price" name="cpt_price"  value="<?php echo $cpt_price; ?>" >
                </div>
              </div> 
            </div>  
            
            <div class="col-md-12">
              <div class="input-group m-b">
                <span class="input-group-addon" style="vertical-align:top; padding-top:15px;"><?php echo '<div class="label-width-adon"><span class="pull-left">'.freetext('comment').'</span></div>'; ?></span>
                <textarea rows="5" class="form-control"  <?php if (!empty($children)) { echo 'disabled'; } ?> name="cpt_comment"><?php echo $cpt_comment; ?></textarea>
              </div>
            </div> 
          </div> <!-- end : col12 -->                        
        </div><!--end : form-group -->
      </div><!--end : panel-body -->
    </section>
  <?php
    }
  ?>
  </div>
</section>