<?php
  $project_id = $this->project_id;

?>

<div class="modal fade" id="modal-remark">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo 'Remark';?> </h4>
      </div>
      <div class="modal-body" style='overflow:auto'>              
        <div class="form-group  col-sm-12">
          <textarea id="remark_area" name="remark_area"  style="width:500px;height:150px;" placeholder="Text input" ></textarea>
        </div>     
      </div>      
      <div class='clear:both'></div>
      <div class="modal-footer">
        <a href="#" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban h5 tx-red"></i> <?php echo freetext('cancel'); ?></a>
        <button type="submit" class="btn btn-primary" name="save" id="remark_save"><i class="fa fa-save h5"></i> <?php echo freetext('save'); ?></button>                  
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->            
</div>

<div class="modal fade" id="modal-select_tool">         
  <form action='' method="POST"> 
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><?php echo freetext('modal-select_equip_tool'); ?> </h4>
        </div>
        <div class="modal-body" style='overflow:auto'>
          <div class="row wrapper">              
              <div class="col-sm-6"><input type="text" autocomplete="off" id="search_modal_tool_col1" class="h6 form-control" placeholder="<?php echo freetext('serial'); ?>" /></div>                                   
              <div class="col-sm-6"><input type="text" autocomplete="off" id="search_modal_tool_col2" class="h6 form-control" placeholder="<?php echo freetext('list'); ?>" /></div>   
          </div> 
          <section class="panel panel-default" style="overflow-y: auto;max-height: 350px;">
            <table  class="table" id="table-modal-tool">                 
              <thead>
                <tr class="back-color-gray">
                  <th><?php echo freetext('select'); ?></th>
                  <th><?php echo freetext('serial'); ?></th>                    
                  <th><?php echo freetext('list'); ?></th>                                                        
                </tr>
              </thead>
              <?php
              $material_list = array();
              foreach ($project_material_list as $key => $value) {
                if (!array_key_exists($value['material_type'], $material_list)) {
                  if (!array_key_exists('last_update_date', $material_list) || strtotime($material_list['last_update_date']) > strtotime(reSAPDate($value['update_date'])) ) {
                    $material_list['last_update_date'] = reSAPDate($value['update_date']);
                    $material_list['last_update_time'] = date('h:i:s', $value['update_time']);
                  }
                  $material_list[$value['material_type']] = array();
                }

                array_push($material_list[$value['material_type']], $value);
              }
              ?>
              <!-- Start : Z001 -->
              <?php
              if (!empty($material_list['Z001'])) {
              ?>
              <tbody class="Z001" style="display:none;">  
              <?php
                foreach ($material_list['Z001'] as $key => $mat) {
                  if (!array_key_exists($mat['material_no'], $budget_info)) {
                    $budget_info[$mat['material_no']]['Budget'] = 0;
                  }

                  if (in_array($mat['material_no'], $customer_request_list)) {
                    $mat['is_customer_request'] = 1;
                  }
              ?>
                <tr class="<?php echo defill($mat['material_no']); ?>">
                  <td>         
                    <div class='radio'>
                      <label>
                        <input type='checkbox' class='radio_tool' name='radio_asset' value="<?php echo defill($mat['material_no']); ?>" data-desc="<?php echo $mat['material_description']; ?>" data-last="<?php echo $mat['last_count'] ?>" data-this="<?php echo $mat['this_count'] ?>" data-budget="<?php echo $budget_info[$mat['material_no']]['Budget']; ?>" data-unit="<?php echo $mat['unit_text']; ?>" data-unitcode="<?php echo $mat['unit_code']; ?>"  data-request="<?php echo $mat['is_customer_request'] ?>">
                      </label>
                    </div>
                  </td>
                  <td style="padding-top: 15px;"><?php echo defill($mat['material_no']); ?></td>                    
                  <td style="padding-top: 15px;"><?php echo $mat['material_description']; ?></td>                                                                                                            
                </tr>
              <?php
                }
              ?>
              </tbody>
              <?php
              }
              ?>
              <!-- End : Z001 -->
              <!-- Start : Z002 -->
              <?php
              if (!empty($material_list['Z002'])) {
              ?>
              <tbody class="Z002" style="display:none;">  
              <?php
                foreach ($material_list['Z002'] as $key => $mat) {
                  if (!array_key_exists($mat['material_no'], $budget_info)) {
                    $budget_info[$mat['material_no']]['Budget'] = 0;
                  }

                  if (in_array($mat['material_no'], $customer_request_list)) {
                    $mat['is_customer_request'] = 1;
                  }
                ?>
                  <tr class="<?php echo defill($mat['material_no']); ?>">
                    <td>         
                      <div class='radio'>
                        <label>
                          <input type='checkbox' class='radio_tool' name='radio_asset' value="<?php echo defill($mat['material_no']); ?>" data-desc="<?php echo $mat['material_description']; ?>"  data-last="<?php echo $mat['last_count'] ?>" data-this="<?php echo $mat['this_count'] ?>" data-budget="<?php echo $budget_info[$mat['material_no']]['Budget']; ?>"  data-unit="<?php echo $mat['unit_text']; ?>" data-unitcode="<?php echo $mat['unit_code']; ?>"  data-request="<?php echo $mat['is_customer_request'] ?>">
                        </label>
                      </div>
                    </td>
                    <td style="padding-top: 15px;"><?php echo defill($mat['material_no']); ?></td>                    
                    <td style="padding-top: 15px;"><?php echo $mat['material_description']; ?></td>                                                                                                            
                  </tr>
              <?php
                }
              ?>
              </tbody>
              <?php
              }
              ?>
              <!-- End : Z002 -->
              <!-- Start : Z013 -->
              <?php
              if (!empty($material_list['Z013'])) {
              ?>
              <tbody class="Z013" style="display:none;">  
              <?php
                foreach ($material_list['Z013'] as $key => $mat) {

                  if (in_array($mat['material_no'], $customer_request_list)) {
                    $mat['is_customer_request'] = 1;
                  }
                ?>
                  <tr class="<?php echo defill($mat['material_no']); ?>">
                    <td>         
                      <div class='radio'>
                        <label>
                          <input type='checkbox' class='radio_tool' name='radio_asset' value="<?php echo defill($mat['material_no']); ?>" data-desc="<?php echo $mat['material_description']; ?>"  data-last="<?php echo $mat['last_count'] ?>" data-this="<?php echo $mat['this_count'] ?>" data-budget="<?php if (!empty($mat_peak_info[$mat['material_no']])) { echo $mat_peak_info[$mat['material_no']]; } else { echo '0'; } ?>"  data-unit="<?php echo $mat['unit_text']; ?>" data-unitcode="<?php echo $mat['unit_code']; ?>"  data-request="<?php echo $mat['is_customer_request'] ?>">
                        </label>
                      </div>
                    </td>
                    <td style="padding-top: 15px;"><?php echo defill($mat['material_no']); ?></td>                    
                    <td style="padding-top: 15px;"><?php echo $mat['material_description']; ?></td>                                                                                                            
                  </tr>
              <?php
                }
              ?>
              </tbody>
              <?php
              }
              ?>
              <!-- End : Z013 -->
              <!-- Start : Z014 -->
              <?php
              if (!empty($material_list['Z014'])) {
              ?>
              <tbody class="Z014" style="display:none;">  
              <?php
                foreach ($material_list['Z014'] as $key => $mat) {

                  if (in_array($mat['material_no'], $customer_request_list)) {
                    $mat['is_customer_request'] = 1;
                  }
                ?>
                  <tr class="<?php echo defill($mat['material_no']); ?>">
                    <td>         
                      <div class='radio'>
                        <label>
                          <input type='checkbox' class='radio_tool' name='radio_asset' value="<?php echo defill($mat['material_no']); ?>" data-desc="<?php echo $mat['material_description']; ?>"  data-last="<?php echo $mat['last_count'] ?>" data-this="<?php echo $mat['this_count'] ?>" data-budget="<?php if (!empty($mat_peak_info[$mat['material_no']])) { echo $mat_peak_info[$mat['material_no']]; } else { echo '0'; } ?>"  data-unit="<?php echo $mat['unit_text']; ?>" data-unitcode="<?php echo $mat['unit_code']; ?>"  data-request="<?php echo $mat['is_customer_request'] ?>">
                        </label>
                      </div>
                    </td>
                    <td style="padding-top: 15px;"><?php echo defill($mat['material_no']); ?></td>                    
                    <td style="padding-top: 15px;"><?php echo $mat['material_description']; ?></td>                                                                                                            
                  </tr>
              <?php
                }
              ?>
              </tbody>
              <?php
              }
              ?>
              <!-- End : Z014 -->
            </table>      
          </section>   
          <div class="row wrapper">              
              <?php
                if (array_key_exists('last_update_date', $material_list)) {
              ?>
                <small>Last update: <?php echo $material_list['last_update_date'].' '.$material_list['last_update_time']; ?></small>
              <?php
                }
              ?>
          </div>  
        </div>
        <div class='clear:both'></div>
        <div class="modal-footer">
          <span class="btn select-tool-cancel btn-default" data-dismiss="modal" aria-hidden="true"><?php echo freetext('cancel'); ?></span>
          <span class="btn select-tool-save btn-primary add-btn" data-type="" data-dismiss="modal" ><?php echo freetext('add'); ?></span>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </form>
</div>




















