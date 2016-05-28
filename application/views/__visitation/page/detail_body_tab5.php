<?php
  // $data_document = $query_documet->row_array();    

  $notice_to_cr       = '';
  $notice_to_oper     = '';
  $notice_to_hr       = '';
  $notice_to_training = '';
  $notice_to_store    = '';
  $notice_to_sale     = '';

  $email_to_cr       = '';
  $email_to_oper     = '';
  $email_to_hr       = '';
  $email_to_training = '';
  $email_to_store    = '';
  $email_to_sale     = '';

  if(!empty($data_document)){

    $notice_to_cr       = $data_document['notice_to_cr'];
    $notice_to_oper     = $data_document['notice_to_oper'];
    $notice_to_hr       = $data_document['notice_to_hr'];
    $notice_to_training = $data_document['notice_to_training'];
    $notice_to_store    = $data_document['notice_to_store'];
    $notice_to_sale     = $data_document['notice_to_sale'];

    $email_to_cr       = $data_document['email_notice_cr'];
    $email_to_oper     = $data_document['email_notice_op'];
    $email_to_hr       = $data_document['email_notice_hr'];
    $email_to_training = $data_document['email_notice_training'];
    $email_to_store    = $data_document['email_notice_store'];
    $email_to_sale     = $data_document['email_notice_sales'];

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

  $position_list = $this->session->userdata('position');

  $children = array();
  // foreach ($position_list as $key => $position) {
  //     $children = $this->__ps_project_query->getPositionChild($children, $position);
  // }
?>
<section>   
  <div class="panel-body">
    <div class="form-group">       
        <div class="col-sm-12 add-all-medium email_panel m-b-md">
          <div class="col-md-12">
            <div class="input-group m-b">
              <span class="input-group-addon" style="vertical-align:top; padding-top:15px;">
                <?php echo '<div class="label-width-adon m-b-md" style="width:300px!important;"><span>'.freetext('cr').'</span></div>'; ?>
                <div class="label_div">
                  <a class="btn btn-primary btn-sm pull-right add_email"><i class="fa fa-plus"></i></a>
                  <select class="select2-option email_selection" <?php if (!empty($children)) { echo 'disabled'; } ?> style="width:270px;">
                    <option value="0">---------- เลือก<?php echo freetext('cr'); ?> ----------</option>
                  <?php
                    if (!empty($user_list['CR'])) {
                      foreach ($user_list['CR'] as $key => $user) {
                  ?>
                    <option value="<?php echo $user['user_email']; ?>"><?php echo $user['user_firstname'].' '.$user['user_lastname']; ?></option>
                  <?php
                      }
                    }
                  ?>
                  </select>
                  <div id="CR_email" data-field="email_notice_cr" class="pillbox clearfix" style="max-height:110px; overflow-y:auto; overflow-x:hidden;">
                    <ul>                          
                      <input type="text" data-name="" onkeypress="return false;" <?php if (!empty($children)) { echo 'disabled'; } ?>>
                    </ul>
                  </div>
                </div>
              </span>
              <textarea <?php if (!empty($children)) { echo 'disabled'; } ?> rows="10" class="form-control" name="notice_to_cr" ><?php echo $notice_to_cr; ?></textarea>
            </div>
          </div>                   
          <div class="col-md-12 text-right">
            <a href='#' class="btn btn-primary send_email" data-id="<?php echo $this->track_doc_id; ?>" data-email="#CR_email"<?php if (!empty($children)) { echo " disabled"; } ?>><?php echo freetext('send_email'); ?></a>
          </div>
        </div>
        <div class="col-sm-12 add-all-medium email_panel m-b-md">
          <div class="col-md-12">
            <div class="input-group m-b">
              <span class="input-group-addon" style="vertical-align:top; padding-top:15px;">
                <?php echo '<div class="label-width-adon m-b-md" style="width:300px!important;"><span>'.freetext('operation').'</span></div>'; ?>
                <div class="label_div">                    
                  <a class="btn btn-primary btn-sm pull-right add_email"><i class="fa fa-plus"></i></a>
                  <select class="select2-option email_selection" <?php if (!empty($children)) { echo 'disabled'; } ?> style="width:270px;">
                    <option value="0">------- เลือก<?php echo freetext('operation'); ?> -------</option>
                  <?php
                    if (!empty($user_list['OP'])) {
                      foreach ($user_list['OP'] as $key => $user) {
                  ?>
                    <option value="<?php echo $user['user_email']; ?>"><?php echo $user['user_firstname'].' '.$user['user_lastname']; ?></option>
                  <?php
                      }
                    }
                  ?>
                  </select>      
                  <div id="OP_email" data-field="email_notice_op" class="pillbox clearfix" style="max-height:110px; overflow-y:auto; overflow-x:hidden;">
                    <ul>                          
                      <input type="text" data-name="" onkeypress="return false;" <?php if (!empty($children)) { echo 'disabled'; } ?>>
                    </ul>
                  </div>                                      
                </div>                    
              </span>
              <textarea <?php if (!empty($children)) { echo 'disabled'; } ?> rows="10" class="form-control" name="notice_to_oper" ><?php echo $notice_to_oper; ?></textarea>
            </div>
          </div>                   
          <div class="col-md-12 text-right">
            <a href='#' class="btn btn-primary send_email" data-id="<?php echo $this->track_doc_id; ?>" data-email="#OP_email"<?php if (!empty($children)) { echo " disabled"; } ?>><?php echo freetext('send_email'); ?></a>
          </div>
        </div>
        <div class="col-sm-12 add-all-medium email_panel m-b-md">
          <div class="col-md-12">
            <div class="input-group m-b">
              <span class="input-group-addon" style="vertical-align:top; padding-top:15px;">
                <?php echo '<div class="label-width-adon m-b-md" style="width:300px!important;"><span>'.freetext('hr').'</span></div>'; ?>
                <div class="label_div">                    
                  <a class="btn btn-primary btn-sm pull-right add_email"><i class="fa fa-plus"></i></a>
                  <select class="select2-option email_selection" <?php if (!empty($children)) { echo 'disabled'; } ?> style="width:270px;">
                    <option value="0">-------- เลือก<?php echo freetext('hr'); ?> --------</option>
                  <?php
                    if (!empty($user_list['HR'])) {
                      foreach ($user_list['HR'] as $key => $user) {
                  ?>
                    <option value="<?php echo $user['user_email']; ?>"><?php echo $user['user_firstname'].' '.$user['user_lastname']; ?></option>
                  <?php
                      }
                    }
                  ?>
                  </select>  
                  <div id="HR_email" data-field="email_notice_hr" class="pillbox clearfix" style="max-height:110px; overflow-y:auto; overflow-x:hidden;">
                    <ul>                          
                      <input type="text" data-name="" onkeypress="return false;" <?php if (!empty($children)) { echo 'disabled'; } ?>>
                    </ul>
                  </div>                                    
                </div>                    
              </span>
              <textarea <?php if (!empty($children)) { echo 'disabled'; } ?> rows="10" class="form-control" name="notice_to_hr" ><?php echo $notice_to_hr; ?></textarea>
            </div>
          </div>                   
          <div class="col-md-12 text-right">
            <a href='#' class="btn btn-primary send_email" data-id="<?php echo $this->track_doc_id; ?>" data-email="#HR_email"<?php if (!empty($children)) { echo " disabled"; } ?>><?php echo freetext('send_email'); ?></a>
          </div>
        </div>
        <div class="col-sm-12 add-all-medium email_panel m-b-md">
          <div class="col-md-12">
            <div class="input-group m-b">
              <span class="input-group-addon" style="vertical-align:top; padding-top:15px;">
                <?php echo '<div class="label-width-adon m-b-md" style="width:300px!important;"><span>'.freetext('training').'</span></div>'; ?>
                <div class="label_div">                    
                  <a class="btn btn-primary btn-sm pull-right add_email"><i class="fa fa-plus"></i></a>
                  <select class="select2-option email_selection" <?php if (!empty($children)) { echo 'disabled'; } ?> style="width:270px;">
                    <option value="0">-------- เลือก<?php echo freetext('training'); ?> --------</option>
                  <?php
                    if (!empty($user_list['TN'])) {
                      foreach ($user_list['TN'] as $key => $user) {
                  ?>
                    <option value="<?php echo $user['user_email']; ?>"><?php echo $user['user_firstname'].' '.$user['user_lastname']; ?></option>
                  <?php
                      }
                    }
                  ?>
                  </select>  
                  <div id="TN_email" data-field="email_notice_training" class="pillbox clearfix" style="max-height:110px; overflow-y:auto; overflow-x:hidden;">
                    <ul>                          
                      <input type="text" data-name="" onkeypress="return false;" <?php if (!empty($children)) { echo 'disabled'; } ?>>
                    </ul>
                  </div>                                            
                </div>                    
              </span>
              <textarea <?php if (!empty($children)) { echo 'disabled'; } ?> rows="10" class="form-control" name="notice_to_training" ><?php echo $notice_to_training; ?></textarea>
            </div>
          </div>                   
          <div class="col-md-12 text-right">
            <a href='#' class="btn btn-primary send_email" data-id="<?php echo $this->track_doc_id; ?>" data-email="#TN_email"<?php if (!empty($children)) { echo " disabled"; } ?>><?php echo freetext('send_email'); ?></a>
          </div>
        </div>
        <div class="col-sm-12 add-all-medium email_panel m-b-md">
          <div class="col-md-12">
            <div class="input-group m-b">
              <span class="input-group-addon" style="vertical-align:top; padding-top:15px;">
                <?php echo '<div class="label-width-adon m-b-md" style="width:300px!important;"><span>'.freetext('store').'</span></div>'; ?>
                <div class="label_div">                    
                  <a class="btn btn-primary btn-sm pull-right add_email"><i class="fa fa-plus"></i></a>
                  <select class="select2-option email_selection" <?php if (!empty($children)) { echo 'disabled'; } ?> style="width:270px;">
                    <option value="0">---------- เลือก<?php echo freetext('store'); ?> ----------</option>
                  <?php
                    if (!empty($user_list['IC'])) {
                      foreach ($user_list['IC'] as $key => $user) {
                  ?>
                    <option value="<?php echo $user['user_email']; ?>"><?php echo $user['user_firstname'].' '.$user['user_lastname']; ?></option>
                  <?php
                      }
                    }
                  ?>
                  </select>     
                  <div id="IC_email" data-field="email_notice_store" class="pillbox clearfix" style="max-height:110px; overflow-y:auto; overflow-x:hidden;">
                    <ul>                          
                      <input type="text" data-name="" onkeypress="return false;" <?php if (!empty($children)) { echo 'disabled'; } ?>>
                    </ul>
                  </div>                                       
                </div>                    
              </span>
              <textarea <?php if (!empty($children)) { echo 'disabled'; } ?> rows="10" class="form-control" name="notice_to_store" ><?php echo $notice_to_store; ?></textarea>
            </div>
          </div>                   
          <div class="col-md-12 text-right">
            <a href='#' class="btn btn-primary send_email" data-id="<?php echo $this->track_doc_id; ?>" data-email="#IC_email"<?php if (!empty($children)) { echo " disabled"; } ?>><?php echo freetext('send_email'); ?></a>
          </div>
        </div>
        <div class="col-sm-12 add-all-medium email_panel m-b-md">
          <div class="col-md-12">
            <div class="input-group m-b">
              <span class="input-group-addon" style="vertical-align:top; padding-top:15px;">
                <?php echo '<div class="label-width-adon m-b-md" style="width:300px!important;"><span>'.freetext('sale').'</span></div>'; ?>
                <div class="label_div">                    
                  <a class="btn btn-primary btn-sm pull-right add_email"><i class="fa fa-plus"></i></a>
                  <select class="select2-option email_selection" <?php if (!empty($children)) { echo 'disabled'; } ?> style="width:270px;">
                    <option value="0">--- เลือก<?php echo freetext('sale'); ?> ---</option>
                  <?php
                    if (!empty($user_list['MK'])) {
                      foreach ($user_list['MK'] as $key => $user) {
                  ?>
                    <option value="<?php echo $user['user_email']; ?>"><?php echo $user['user_firstname'].' '.$user['user_lastname']; ?></option>
                  <?php
                      }
                    }
                  ?>
                  </select>    
                  <div id="MK_email" data-field="email_notice_sales" class="pillbox clearfix" style="max-height:110px; overflow-y:auto; overflow-x:hidden;">
                    <ul>                          
                      <input type="text" data-name="" onkeypress="return false;" <?php if (!empty($children)) { echo 'disabled'; } ?>>
                    </ul>
                  </div>                    
                </div>                    
              </span>
              <textarea <?php if (!empty($children)) { echo 'disabled'; } ?> rows="10" class="form-control" name="notice_to_sale" ><?php echo $notice_to_sale; ?></textarea>
            </div>
          </div>                   
          <div class="col-md-12 text-right">
            <a href='#' class="btn btn-primary send_email" data-id="<?php echo $this->track_doc_id; ?>" data-email="#MK_email"<?php if (!empty($children)) { echo " disabled"; } ?>><?php echo freetext('send_email'); ?></a>
          </div>
        </div>
    </div>
  </div>
</section>