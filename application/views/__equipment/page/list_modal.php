        <?php

          // get project id                
          if(!empty($result)){
              /*$content = $result['list']; 
              foreach ($content as $key => $value) {
                  $project_id =$value['project_id'];
                  $ship_to_id =$value['ship_to_id'];
              }*/
              $project_id = $result['quotation_id'];
              $ship_to_id = $result['project']['ship_to_id'];
              $sold_to_id = $result['project']['sold_to_id'];
          }
          
          //====end :   get actor name =========
        ?>
         <!--Start: modal confirm delete -->
        <div class="modal fade" id="modal-delete"  is-confirm='0'>                  
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h3 class="title"><?php echo freetext('delete_confirm'); ?></h3>
                </div>
                <div class="modal-body" style='overflow:auto'>                  
                  <!-- <p class='msg'>Do you confirm to delete this item</p> -->
                  <p class='msg h5'>คุณต้องการลบข้อมูลนี้หรือไม่</p> 
                </div>
                <div class='clear:both'></div>
                <div class="modal-footer">
                  <span class="btn cancel-delete  btn-default" data-dismiss="modal" aria-hidden="true"><?php echo freetext('cancel'); ?></span>
                  <span class="btn confirm-delete btn-primary" data-dismiss="modal" ><?php echo freetext('confirm'); ?></span>
                </div>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->        
        </div><!--end: modal confirm delete -->

        <div class="modal fade" id="modal-addListEquipment">
         <!-- #### remark-->
          <form id="create-doc-form" action='<?php echo site_url($this->page_controller.'/create_List_equipment_return');  ?>' method="POST">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title"><?php echo freetext('add_equipment_return');?> </h4>
                </div>
                <div class="modal-body" style='overflow:auto'>

                    <div class="form-group col-sm-12">
                      <label class="col-sm-3 control-label"><?php echo freetext('list_of_equipment_return'); ?></label>
                     <div class="col-sm-9">
                        <input type="text" autocomplete="off" class="form-control event_title" name="event_title"  value=""> 
                      </div>
                    </div>

                    <div class="form-group col-sm-12">
                       <label class="col-sm-3 control-label"><?php echo freetext('project_title'); ?></label>
                       <div class="col-sm-9">
                          <input type="text" autocomplete="off" class="form-control" value='<?php echo $contentInfo['ship_to_id']." : ".$contentInfo['shop_to_title']; ?>' disabled>   
                          <input type="hidden" name='project_id' class="form-control" value='<?php echo $project_id; ?>'>
                          <input type="hidden" name='ship_to_id' class="form-control" value='<?php echo $contentInfo['ship_to_id']; ?>'>
                          <input type="hidden" name='sold_to_id' class="form-control" value='<?php echo $contentInfo['sold_to_id']; ?>'>
                        </div>
                    </div>  
                  

                    <div class="form-group col-sm-12">
                      <label class="col-sm-3 control-label"><?php echo freetext('survey_officer'); ?></label>
                     <div class="col-sm-9">
                        <input type="text" autocomplete="off" class="form-control actor" name="actor" readonly value="<?php echo $this->session->userdata('actual_name');?>"> 
                        <input type="hidden" class="form-control actor_id" name="actor_id" value="<?php echo $this->session->userdata('id'); ?>"> 
                      </div>
                    </div>

                    <div class="form-group col-sm-12">
                       <label class="col-sm-3 control-label"><?php echo freetext('event_category'); ?></label>
                       <div class="col-sm-9">
                          <input type="hidden" class="order_type" name="order_type" value=''>
                          <input type="hidden" class="job_cat_id" name="job_cat_id" value=''>
                          <input type="hidden" class="equipment_sale_order_id" name="equipment_sale_order_id" value=''>
                          <input type="hidden" class="asset_sale_order_id" name="asset_sale_order_id" value=''>
                           <?php
                            $in_type = array('ZOR1', 'ZOR2', 'ZOR3');

                            $map_itemcat = array(
                              'ZOR1' => 'ZTAA',
                              'ZOR2' => 'ZTAB',
                              'ZOR3' => 'ZTAE'
                            );

                            $sale_order_no_list = array();
                            foreach ($sale_order_list['ET_BREAKDOWN'] as $key => $value) {

                              if (in_array($value['AUART'], $in_type) && (array_key_exists($value['AUART'], $map_itemcat) && $value['PSTYV'] == $map_itemcat[$value['AUART']]) ) {
                                
                                $type = $value['AUART'].'_'.$value['PSTYV'];

                                if (!array_key_exists($type, $sale_order_no_list)) {
                                  $sale_order_no_list[$type] = array();
                                  $sale_order_no_list[$type]['min'] = "";
                                  $sale_order_no_list[$type]['max'] = "";
                                }

                                if (empty($sale_order_no_list[$type]['min']) || $sale_order_no_list[$type]['min'] > $value['VBELN']) {
                                  $sale_order_no_list[$type]['min'] = $value['VBELN'];
                                }

                                if (empty($sale_order_no_list[$type]['max']) || $sale_order_no_list[$type]['max'] < $value['VBELN']) {
                                  $sale_order_no_list[$type]['max'] = $value['VBELN'];
                                }
                                
                              }
                            }

                            foreach ($sale_order_no_list as $type => $value) {
                            ?>
                                <input type="hidden" class="sale_order" value='<?php echo $value['min']; ?>' data-type="<?php echo 'min_'.$type; ?>">
                                <input type="hidden" class="sale_order" value='<?php echo $value['max']; ?>' data-type="<?php echo 'max_'.$type; ?>">
                            <?php
                            }
                            
                            foreach ($AllClearJob as $key => $job) {
                            ?>
                              <input type="hidden" class="sale_order" value='<?php echo $job['id'] ?>' data-type="<?php echo 'ZOR4_'.$job['item_category']; ?>">
                            <?php
                            }
                          ?> 
                          <select style="height:42px;" class="form-control col-sm-4 job_type_id"  >                                 
                          <?php
                            $map_type = array(
                              'ZOR1' => 'ZORX',
                              'ZOR2' => 'ZORY',
                              'ZOR3' => 'ZORW',
                              'ZOR4' => 'ZORZ'
                            );

                            $map_itemcat = array(
                              'ZOR1' => 'ZTAA',
                              'ZOR2' => 'ZTAB',
                              'ZOR3' => 'ZTAE'
                            );

                            $in_type = array('ZORX', 'ZORY', 'ZORW', 'ZORZ');
                            $item_cat = array();

                            foreach ($sale_order_list['ET_BREAKDOWN'] as $key => $material) {

                              if ($material['AUART'] == 'ZOR4' || (array_key_exists($material['AUART'], $map_itemcat) && $material['PSTYV'] == $map_itemcat[$material['AUART']]) ) {
                                if (!array_key_exists($material['AUART'], $item_cat)) {
                                  $item_cat[$material['AUART']] = array();
                                }

                                if (!array_key_exists($material['PSTYV'], $item_cat[$material['AUART']])) {
                                  $item_cat[$material['AUART']][$material['PSTYV']] = array();
                                }

                                if (!in_array($material['VBELN'], $item_cat[$material['AUART']][$material['PSTYV']])) {
                                  array_push($item_cat[$material['AUART']][$material['PSTYV']], $material['VBELN']);
                                }
                              }
                            }

                            foreach ($item_cat as $AUART => $value) {
                              if (!in_array($AUART, $in_type)) {
                                foreach ($value as $PSTYV => $value2) {
                          ?>
                                <option value='<?php echo $AUART.'_'.$PSTYV; ?>' data-type="<?php echo $map_type[$AUART]; ?>" ><?php echo freetext($AUART.'_'.$PSTYV); ?></option>
                          <?php
                                }
                              }
                            }
                          ?>         
                          </select>
                        </div>
                    </div>  
                    
                    <div class="form-group col-sm-12">
                            <label class="col-sm-3 control-label"><?php echo freetext('return_date'); ?></label>
                            <div class="col-sm-9">
                              <div class='input-group date' id='datetimepicker5' data-date-format="YYYY-MM-DD">
                                  <input type='text' class="form-control" name="plan_date"/>
                                  <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>
                                  </span>
                              </div>
                            </div>
                    </div>


                    <div class="form-group col-sm-12">
                      <label class="col-sm-3 control-label"><?php echo freetext('remark'); ?></label>
                      <div class="col-sm-9">
                         <textarea id="remark" name="remark"  style="width:370px;height:150px;" placeholder="Text input"></textarea>
                       </div>
                    </div>
                </div>

                <div class='clear:both'></div>
                <div class="modal-footer">
                  <a href="#" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban h5 tx-red"></i> <?php echo freetext('cancel'); ?></a>
                  <a type="submit" class="submit-create btn btn-primary" name="save"><i class="fa fa-save h5"></i> <?php echo freetext('save'); ?></a> 
                   <!-- <input type='hidden' name="callback_url"value="<?php //echo site_url($this->page_controller.'/listview'); ?>">
                  <input type='submit' class="btn btn-primary" value="Save"> -->
                                   
                </div>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
            </form>
      </div>

























