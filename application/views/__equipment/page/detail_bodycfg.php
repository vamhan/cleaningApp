<style type="text/css">
.dt_header{
display: none  !important;
}

.dt_footer .row-fluid{
display: none  !important;
}

</style>
<!-- Start div_detail -->
<div class="div_detail">
  <!-- Start panel -->
  <section class="panel panel-default ">               
    <!-- Start panel-body -->
    <div class="panel-body"> 
      <!-- Start form-group -->
      <div class="form-group">
        <?php 

          $project_id = $this->project_id;                         
          $actor_by_id = $this->session->userdata('id');

          $project_result = $query_owner->row_array();
          if (!empty($project_result)) {
            $ship_to_id = $project_result['ship_to_id'];
          } else {
            $ship_to_id = 0;
          }
          
          if (!empty($equipment_doc)) {
            $this->db->where('employee_id', $equipment_doc['site_inspector_id']);
            $query_actor=$this->db->get('tbt_user');
            $data_actor = $query_actor->row_array();  

            if(!empty($data_actor)){
              $site_inspector_actor = $data_actor['user_firstname']." ". $data_actor['user_lastname'];
            } else { 
              $site_inspector_actor='-'; 
            }

            $this->db->where('employee_id', $equipment_doc['inspector_id']);
            $query_actor=$this->db->get('tbt_user');
            $data_actor = $query_actor->row_array();  

            if(!empty($data_actor)){
              $inspector_actor = $data_actor['user_firstname']." ". $data_actor['user_lastname'];
            } else { 
              $inspector_actor='-'; 
            }
          }

          /*echo "<pre>";
          print_r($sap_data);
          echo "</pre>";*/
          //====end :  get actor name =========                      

          $material_list = array();
          foreach ($project_material_list as $key => $value) {
            if (!array_key_exists($value['material_type'], $material_list)) {
              $material_list[$value['material_type']] = array();
            }
            array_push($material_list[$value['material_type']], $value);
          }
        ?>     
        <!-- Start col-sm-12 -->
        <div class="col-sm-12">
          <div class="row">
            <div class="col-md-4">
              <div class="input-group m-b">
                <span style="white-space:normal; height:60px;" class="input-group-addon"><?php echo '<div class="label-width-adon text-left" style="font-size:0.9em;">'.freetext('part').'</div>'; ?></span>
                <input type="text" autocomplete="off" style="height:60px;" class="form-control doc_id" readonly value="<?php echo $equipment_doc['part']; ?>">
              </div>
            </div>                       

            <div class="col-md-4">
              <div class="input-group m-b">
                <span style="white-space:normal; height:60px;" class="input-group-addon"><?php echo '<div class="label-width-adon text-left" style="font-size:0.9em;">'.freetext('create_date').'</div>'; ?></span>
                <input type="text" autocomplete="off" name="create_date" style="height:60px;" class="form-control" readonly value="<?php if( $equipment_doc['actual_date'] !='0000-00-00' ){ echo common_easyDateFormat($equipment_doc['actual_date']); }else{ echo "-"; } //$equipment_doc['actual_date']?> ">
              </div>
            </div>

            <div class="col-md-4">
              <div class="input-group m-b">
                <span style="white-space:normal; height:60px;" class="input-group-addon">
                  <?php echo '<div class="label-width-adon text-left" style="font-size:0.9em;">'.freetext('return_date').'</div>'; ?>
                </span>
                <div class='input-group date col-md-12' id='datetimepicker1' data-date-format="DD.MM.YYYY">
                  <input type='text' style="height:60px;" class="form-control return_date_input" readonly value="<?php if( $equipment_doc['return_date'] !='0000-00-00' ){ echo common_easyDateFormat($equipment_doc['return_date']); }else{ echo '-'; } ?>"/>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- End col-sm-12 -->

        <!-- Start col-sm-12 -->
        <div class="col-sm-12">
          <div class="row">
            <div class="col-md-4">
              <div class="input-group m-b">
                <span style="white-space:normal; height:60px;" class="input-group-addon"><?php echo '<div class="label-width-adon text-left" style="font-size:0.9em;">'.freetext('site_inspector').'</div>'; ?></span>
                <input type="text" autocomplete="off" style="height:60px;" class="form-control" readonly value="<?php echo $site_inspector_actor;  ?>">
              </div>
            </div>                       

            <div class="col-md-4">
              <div class="input-group m-b">
                <span style="white-space:normal; height:60px;" class="input-group-addon"><?php echo '<div class="label-width-adon text-left" style="font-size:0.9em;">'.freetext('return_inspector').'</div>'; ?></span>
                <input type="text" autocomplete="off" style="height:60px;" class="form-control" readonly value="<?php echo $inspector_actor;  ?>">
              </div>
            </div>

            <div class="col-md-4">
              <div class="input-group m-b">
                <span style="white-space:normal; height:60px;" class="input-group-addon">
                  <?php echo '<div class="label-width-adon text-left" style="font-size:0.9em;">'.freetext('remark').'</div>'; ?>
                </span>
                <div class='input-group col-md-12'>
                  <input type='text' style="height:60px;" class="form-control remark_input" readonly value="<?php echo $equipment_doc['remark']; ?>"/>
                  <a href="#" style="white-space:normal; height:60px;" class="input-group-addon remark-btn-click">
                    <i class="fa fa-align-justify"></i>
                  </a>
                </div>
              </div>
            </div>   
          </div>
        </div>
        <!-- End col-sm-12 -->

        <!-- Start col-sm-12 -->
        <div class="col-sm-12">
          <div class="row">    
            <div class="col-md-4">
              <div class="input-group m-b">
                <span style="white-space:normal; height:60px;" class="input-group-addon"><?php echo '<div class="label-width-adon text-left" style="font-size:0.9em;">'.freetext('type').'</div>'; ?></span>
                <input type="text" autocomplete="off" style="height:60px;" class="form-control col-sm-4 job_type_id" readonly data-val="<?php echo $equipment_doc['order_type']; ?>" value="<?php echo freetext($equipment_doc['order_type']); ?>" >                                                 
              </div>
            </div>

            <div class="col-md-4">
              <div class="input-group m-b">
                <span style="white-space:normal; height:60px;" class="input-group-addon equipment_sale_order_label"><?php echo '<div class="label-width-adon text-left" style="font-size:0.9em;"></div>'; ?></span>
                <input style="height:60px;" class="form-control col-sm-4 equipment_sale_order_id" type="text" autocomplete="off" name="equipment_sale_order_id"  value="<?php echo $equipment_doc['equipment_sale_order_id']; ?>" readonly >
              </div>
            </div>   
             
            <div class="col-md-4">
              <div class="input-group m-b">
                <span style="white-space:normal; height:60px;" class="input-group-addon asset_sale_order_label"><?php echo '<div class="label-width-adon text-left" style="font-size:0.9em;"></div>'; ?></span>
                <input style="height:60px;" class="form-control col-sm-4 asset_sale_order_id" type="text" autocomplete="off"  name="asset_sale_order_id"  value="<?php echo $equipment_doc['asset_sale_order_id']; ?>" readonly >
              </div>
            </div> 

          </div>
        </div>
        <!-- End col-sm-12 -->
      </div>   
      <!-- End form-group -->                
    </div>            
    <!-- End panel-body -->
  </section>
  <!-- End panel -->

  <!-- Start panel row -->
  <div class="panel row">              
    <!-- Start panel-collapse -->
    <div class="panel-collapse in">               
      <!-- Start panel-body -->
      <div class="panel-body text-sm">                  
        <!-- Start form -->
        <form id="insert_equipment" method="post" action="<?php echo site_url('__ps_equipment/update_return_document') ?>">                
          <input type="hidden" name="id" class="doc_id" value="<?php echo $equipment_doc['equipment_doc_id']; ?>" />
          <input type="hidden" name="project_id" value="<?php echo $project_id; ?>" />
          <input type="hidden" name="ship_to_id" value="<?php echo $ship_to_id; ?>" />
          <input type="hidden" name="actor_id" value="<?php echo $actor_by_id; ?>" />
          <input type="hidden" name="job_type_id" class="order_type" value="<?php echo $equipment_doc['order_type']; ?>" />
          <input type="hidden" name="job_cat_id" class="job_cat_id" value="<?php echo $equipment_doc['item_category']; ?>" />
          <input type="hidden" class="equipment_sale_order_id" name="equipment_sale_order_id" value='<?php echo $equipment_doc['equipment_sale_order_id']; ?>'>
          <input type="hidden" class="asset_sale_order_id" name="asset_sale_order_id" value='<?php echo $equipment_doc['asset_sale_order_id']; ?>'>
          <input type="hidden" name="return_date" class="return_date" value="<?php if ($equipment_doc['return_date'] != '0000-00-00') { echo $equipment_doc['return_date']; } ?>" />
          <input type="hidden" name="actual_date" class="actual_date" value="<?php echo date('Y-m-d'); ?>" />
          <input type="hidden" name="remark" class="remark_input" value="<?php echo $equipment_doc['remark'] ?>" />
          <!-- Start section -->
          <section class="panel panel-default"> 
          <!-- Start table -->
            <table id="table1" width="100%" class="table text-center table_Z001">                   
              <thead>
                <tr class="back-color-gray">
                  <th style="width:10%"><?php echo freetext('Z001_type'); ?></th>
                  <th class="text-center" style="width:5%"><?php echo freetext('code'); ?></th>
                  <th class="text-center" style="width:15%"><?php echo freetext('list'); ?></th>             
                  <th class="text-center" style="width:5%"><?php echo freetext('quantity'); ?></th>
                  <th class="text-center" style="width:5%"><?php echo freetext('unit'); ?></th>                                                          
                  <th class="text-center" style="width:5%"><?php echo freetext('remark'); ?></th>                                                   
                  <th class="text-center" style="width:5%"><?php echo freetext('delete'); ?></th>
                </tr>
              </thead>
              <tbody class="data_list_asset">
              <?php
              if (!empty($equipment_items['Z001'])) {
                foreach ($equipment_items['Z001'] as $equip) {              
              ?>
                  <tr class="<?php echo defill($equip['material_no']); ?>"> 
                    <td></td>                                                             
                    <td><?php echo defill($equip['material_no']); ?></td>
                    <td><?php echo $equip['material_description']; ?><input type="hidden" name="desc_<?php echo $equip['material_type'].'_'.defill($equip['material_no']); ?>"  value="<?php echo $equip['material_description'] ?>" /></td>                    
                    <td>
                      <input type="text" autocomplete="off" class="form-control inline text-right" name="quantity_<?php echo $equip['material_type'].'_'.defill($equip['material_no']); ?>"  value="<?php echo $equip['quantity']; ?>" style="width:100%;font-size:1em;"/>                      
                    </td>
                    <td>
                      <?php echo $equip['unit_text']; ?>
                      <input type="hidden" name="unit_code_<?php echo $equip['material_type'].'_'.defill($equip['material_no']); ?>"  value="<?php echo $equip['unit_code']; ?>"/>                      
                      <input type="hidden" name="unit_text_<?php echo $equip['material_type'].'_'.defill($equip['material_no']); ?>"  value="<?php echo $equip['unit_text']; ?>"/>                      
                    </td> 
                    <td>
                      <?php
                        $remark_color = "muted";
                        if (!empty($equip['remark'])) {
                          $remark_color = "primary";
                        }
                      ?>
                      <input type="hidden" class="form-control" name="remark_<?php echo $equip['material_type'].'_'.defill($equip['material_no']); ?>" value="<?php echo $equip['remark'] ?>" >
                      <a  class="btn btn-default remark-btn-click" data-type="<?php echo $equip['material_type']; ?>" data-code="<?php echo defill($equip['material_no']); ?>" > 
                        <i class="fa fa-align-justify"></i>
                        &nbsp;                      
                        <i class="fa fa-circle text-<?php echo $remark_color; ?> text-xs v-middle remark_icon_<?php echo $equip['material_type'].'_'.defill($equip['material_no']); ?>"></i>
                      </a>
                    </td>    
                    <td>
                      <a class="btn btn-default del-row" data-type="<?php echo $equip['material_type']; ?>" data-code="<?php echo defill($equip['material_no']); ?>"> 
                        <i class="fa fa-trash-o"></i>
                      </a>
                    </td>                                                             
                  </tr>
              <?php
                }
              } else {
              ?>                
                <tr class="empty-row"><td colspan="7">Empty</td></tr>
              <?php
              }
              ?>
              </tbody>    
              <tfoot>
                    <tr>                     
                        <th style=" visibility: hidden;"></th>
                        <th></th> 
                        <th></th>    
                        <th></th>    
                        <th></th>    
                        <th></th>     
                        <th colspan="2">  
                          <a  class="btn btn-primary add_tool pull-right" data-type="Z001" ><i class="fa fa-th"></i> <?php echo freetext('add'); ?></a>                                                                     
                        </th>                                
                    </tr>
                </tfoot>  
            </table>   
          <!-- End table -->
          <!-- Start table -->
            <table id="table1" width="100%" class="table text-center table_Z013">                   
              <thead>
                <tr class="back-color-gray">
                  <th style="width:10%"><?php echo freetext('Z013_type'); ?></th>
                  <th class="text-center" style="width:5%"><?php echo freetext('code'); ?></th>
                  <th class="text-center" style="width:15%"><?php echo freetext('list'); ?></th>                 
                  <th class="text-center" style="width:5%"><?php echo freetext('quantity'); ?></th>
                  <th class="text-center" style="width:5%"><?php echo freetext('unit'); ?></th>                                                          
                  <th class="text-center" style="width:5%"><?php echo freetext('remark'); ?></th>                                                   
                  <th class="text-center" style="width:5%"><?php echo freetext('delete'); ?></th>
                </tr>
              </thead>
              <tbody class="data_list_asset">
              <?php
              if (!empty($equipment_items['Z013'])) {
                foreach ($equipment_items['Z013'] as $equip) {              
              ?>
                  <tr class="<?php echo defill($equip['material_no']); ?>"> 
                    <td></td>                                                             
                    <td><?php echo defill($equip['material_no']); ?></td>
                    <td><?php echo $equip['material_description']; ?><input type="hidden" name="desc_<?php echo $equip['material_type'].'_'.defill($equip['material_no']); ?>"  value="<?php echo $equip['material_description'] ?>" /></td>                    
                    <td>
                      <input type="text" autocomplete="off" class="form-control inline text-right" name="quantity_<?php echo $equip['material_type'].'_'.defill($equip['material_no']); ?>"  value="<?php echo $equip['quantity']; ?>" style="width:100%;font-size:1em;"/>                      
                    </td>
                    <td>
                      <?php echo $equip['unit_text']; ?>
                      <input type="hidden" name="unit_code_<?php echo $equip['material_type'].'_'.defill($equip['material_no']); ?>"  value="<?php echo $equip['unit_code']; ?>"/>                      
                      <input type="hidden" name="unit_text_<?php echo $equip['material_type'].'_'.defill($equip['material_no']); ?>"  value="<?php echo $equip['unit_text']; ?>"/>                      
                    </td> 
                    <td>
                      <?php
                        $remark_color = "muted";
                        if (!empty($equip['remark'])) {
                          $remark_color = "primary";
                        }
                      ?>
                      <input type="hidden" class="form-control" name="remark_<?php echo $equip['material_type'].'_'.defill($equip['material_no']); ?>" value="<?php echo $equip['remark'] ?>" >
                      <a  class="btn btn-default remark-btn-click" data-type="<?php echo $equip['material_type']; ?>" data-code="<?php echo defill($equip['material_no']); ?>" > 
                        <i class="fa fa-align-justify"></i>
                        &nbsp;                      
                        <i class="fa fa-circle text-<?php echo $remark_color; ?> text-xs v-middle remark_icon_<?php echo $equip['material_type'].'_'.defill($equip['material_no']); ?>"></i>
                      </a>
                    </td>    
                    <td>
                      <a class="btn btn-default del-row" data-type="<?php echo $equip['material_type']; ?>" data-code="<?php echo defill($equip['material_no']); ?>"> 
                        <i class="fa fa-trash-o"></i>
                      </a>
                    </td>                                                             
                  </tr>
              <?php
                }
              } else {
              ?>                
                <tr class="empty-row"><td colspan="7">Empty</td></tr>
              <?php
              }
              ?>
              </tbody>    
              <tfoot>
                    <tr>                     
                        <th style=" visibility: hidden;"></th>
                        <th></th> 
                        <th></th>   
                        <th></th>  
                        <th></th>    
                        <th></th> 
                        <th colspan="2">  
                          <a  class="btn btn-primary add_tool pull-right" data-type="Z013" ><i class="fa fa-th"></i> <?php echo freetext('add'); ?></a>                                                                     
                        </th>                              
                    </tr>
                </tfoot>  
            </table>      
          <!-- End table -->
          <!-- Start table -->
            <table id="table1" width="100%" class="table text-center table_Z002">                   
              <thead>
                <tr class="back-color-gray">
                  <th style="width:10%"><?php echo freetext('Z002_type'); ?></th>
                  <th class="text-center" style="width:5%"><?php echo freetext('code'); ?></th>
                  <th class="text-center" style="width:15%"><?php echo freetext('list'); ?></th>                 
                  <th class="text-center" style="width:5%"><?php echo freetext('quantity'); ?></th>
                  <th class="text-center" style="width:5%"><?php echo freetext('unit'); ?></th>                                                          
                  <th class="text-center" style="width:5%"><?php echo freetext('remark'); ?></th>                                                   
                  <th class="text-center" style="width:5%"><?php echo freetext('delete'); ?></th>
                </tr>
              </thead>
              <tbody class="data_list_asset">
              <?php
              if (!empty($equipment_items['Z002'])) {
                foreach ($equipment_items['Z002'] as $equip) {              
              ?>
                  <tr class="<?php echo defill($equip['material_no']); ?>"> 
                    <td></td>                                                             
                    <td><?php echo defill($equip['material_no']); ?></td>
                    <td><?php echo $equip['material_description']; ?><input type="hidden" name="desc_<?php echo $equip['material_type'].'_'.defill($equip['material_no']); ?>"  value="<?php echo $equip['material_description'] ?>" /></td>                    
                    <td>
                      <input type="text" autocomplete="off" class="form-control inline text-right" name="quantity_<?php echo $equip['material_type'].'_'.defill($equip['material_no']); ?>"  value="<?php echo $equip['quantity']; ?>" style="width:100%;font-size:1em;"/>                      
                    </td>
                    <td>
                      <?php echo $equip['unit_text']; ?>
                      <input type="hidden" name="unit_code_<?php echo $equip['material_type'].'_'.defill($equip['material_no']); ?>"  value="<?php echo $equip['unit_code']; ?>"/>                      
                      <input type="hidden" name="unit_text_<?php echo $equip['material_type'].'_'.defill($equip['material_no']); ?>"  value="<?php echo $equip['unit_text']; ?>"/>                      
                    </td> 
                    <td>
                      <?php
                        $remark_color = "muted";
                        if (!empty($equip['remark'])) {
                          $remark_color = "primary";
                        }
                      ?>
                      <input type="hidden" class="form-control" name="remark_<?php echo $equip['material_type'].'_'.defill($equip['material_no']); ?>" value="<?php echo $equip['remark'] ?>" >
                      <a  class="btn btn-default remark-btn-click" data-type="<?php echo $equip['material_type']; ?>" data-code="<?php echo defill($equip['material_no']); ?>" > 
                        <i class="fa fa-align-justify"></i>
                        &nbsp;                      
                        <i class="fa fa-circle text-<?php echo $remark_color; ?> text-xs v-middle remark_icon_<?php echo $equip['material_type'].'_'.defill($equip['material_no']); ?>"></i>
                      </a>
                    </td>    
                    <td>
                      <a class="btn btn-default del-row" data-type="<?php echo $equip['material_type']; ?>" data-code="<?php echo defill($equip['material_no']); ?>"> 
                        <i class="fa fa-trash-o"></i>
                      </a>
                    </td>                                                             
                  </tr>
              <?php
                }
              } else {
              ?>                
                <tr class="empty-row"><td colspan="7">Empty</td></tr>
              <?php
              }
              ?>
              </tbody>    
              <tfoot>
                    <tr>                     
                        <th style=" visibility: hidden;"></th>
                        <th></th> 
                        <th></th>
                        <th></th>    
                        <th></th>   
                        <th></th>   
                        <th colspan="2">  
                          <a  class="btn btn-primary add_tool pull-right" data-type="Z002" ><i class="fa fa-th"></i> <?php echo freetext('add'); ?></a>                                                                     
                        </th>                              
                    </tr>
                </tfoot>  
            </table>    
          <!-- End table -->
          <!-- Start table -->
            <table id="table1" width="100%" class="table text-center table_Z014">                   
              <thead>
                <tr class="back-color-gray">
                  <th style="width:10%"><?php echo freetext('Z014_type'); ?></th>
                  <th class="text-center" style="width:5%"><?php echo freetext('code'); ?></th>
                  <th class="text-center" style="width:15%"><?php echo freetext('list'); ?></th>                 
                  <th class="text-center" style="width:5%"><?php echo freetext('quantity'); ?></th>
                  <th class="text-center" style="width:5%"><?php echo freetext('unit'); ?></th>                                                          
                  <th class="text-center" style="width:5%"><?php echo freetext('remark'); ?></th>                                                   
                  <th class="text-center" style="width:5%"><?php echo freetext('delete'); ?></th>
                </tr>
              </thead>
              <tbody class="data_list_asset">
              <?php
              if (!empty($equipment_items['Z014'])) {
                foreach ($equipment_items['Z014'] as $equip) {              
              ?>
                  <tr class="<?php echo defill($equip['material_no']); ?>"> 
                    <td></td>                                                             
                    <td><?php echo defill($equip['material_no']); ?></td>
                    <td><?php echo $equip['material_description']; ?><input type="hidden" name="desc_<?php echo $equip['material_type'].'_'.defill($equip['material_no']); ?>"  value="<?php echo $equip['material_description'] ?>" /></td>                    
                    <td>
                      <input type="text" autocomplete="off" class="form-control inline text-right" name="quantity_<?php echo $equip['material_type'].'_'.defill($equip['material_no']); ?>"  value="<?php echo $equip['quantity']; ?>" style="width:100%;font-size:1em;"/>                      
                    </td>
                    <td>
                      <?php echo $equip['unit_text']; ?>
                      <input type="hidden" name="unit_code_<?php echo $equip['material_type'].'_'.defill($equip['material_no']); ?>"  value="<?php echo $equip['unit_code']; ?>"/>                      
                      <input type="hidden" name="unit_text_<?php echo $equip['material_type'].'_'.defill($equip['material_no']); ?>"  value="<?php echo $equip['unit_text']; ?>"/>                      
                    </td> 
                    <td>
                      <?php
                        $remark_color = "muted";
                        if (!empty($equip['remark'])) {
                          $remark_color = "primary";
                        }
                      ?>
                      <input type="hidden" class="form-control" name="remark_<?php echo $equip['material_type'].'_'.defill($equip['material_no']); ?>" value="<?php echo $equip['remark'] ?>" >
                      <a  class="btn btn-default remark-btn-click" data-type="<?php echo $equip['material_type']; ?>" data-code="<?php echo defill($equip['material_no']); ?>" > 
                        <i class="fa fa-align-justify"></i>
                        &nbsp;                      
                        <i class="fa fa-circle text-<?php echo $remark_color; ?> text-xs v-middle remark_icon_<?php echo $equip['material_type'].'_'.defill($equip['material_no']); ?>"></i>
                      </a>
                    </td>    
                    <td>
                      <a class="btn btn-default del-row" data-type="<?php echo $equip['material_type']; ?>" data-code="<?php echo defill($equip['material_no']); ?>"> 
                        <i class="fa fa-trash-o"></i>
                      </a>
                    </td>                                                             
                  </tr>
              <?php
                }
              } else {
              ?>                
                <tr class="empty-row"><td colspan="7">Empty</td></tr>
              <?php
              }
              ?>
              </tbody>    
              <tfoot>
                    <tr>                     
                        <th style=" visibility: hidden;"></th>
                        <th></th>    
                        <th></th>  
                        <th></th>    
                        <th></th>   
                        <th></th>    
                        <th colspan="2">  
                          <a  class="btn btn-primary add_tool pull-right" data-type="Z014" ><i class="fa fa-th"></i> <?php echo freetext('add'); ?></a>                                                                     
                        </th>                            
                    </tr>
                </tfoot>  
            </table>     
          <!-- End table -->
          <!-- Start table -->
            <table id="table1" width="100%" class="table text-center table_asset">                   
              <thead>
                <tr class="back-color-gray">
                  <th style="width:10%"><?php echo freetext('Asset_type'); ?></th>
                  <th class="text-center" style="width:5%"><?php echo freetext('code'); ?></th>
                  <th class="text-center" style="width:15%"><?php echo freetext('list'); ?></th>                 
                  <th class="text-center" style="width:5%"><?php echo freetext('quantity'); ?></th>
                  <th class="text-center" style="width:5%"><?php echo freetext('unit'); ?></th>                                                          
                  <th class="text-center" style="width:5%"><?php echo freetext('remark'); ?></th>                                                   
                  <th class="text-center" style="width:5%"><?php echo freetext('delete'); ?></th>
                </tr>
              </thead>
              <tbody class="data_list_asset">
              <?php
              if (!empty($equipment_items['asset'])) {
                foreach ($equipment_items['asset'] as $equip) {              
              ?>
                  <tr class="<?php echo str_replace('.', '-', $equip['material_no']); ?>"> 
                    <td></td>                                                             
                    <td><?php echo defill($equip['material_no']); ?></td>
                    <td><?php echo $equip['material_description']; ?><input type="hidden" name="desc_<?php echo $equip['material_type'].'_'.str_replace('.', '-', $equip['material_no']); ?>"  value="<?php echo $equip['material_description'] ?>" /></td>                    
                    <td>
                      <input type="hidden" name="quantity_<?php echo $equip['material_type'].'_'.str_replace('.', '-', $equip['material_no']); ?>"  value="<?php echo $equip['quantity']; ?>"/>
                      <input type="text" autocomplete="off" class="form-control inline text-right" name="quantity_<?php echo $equip['material_type'].'_'.str_replace('.', '-', $equip['material_no']); ?>"  value="<?php echo $equip['quantity']; ?>" style="width:100%;font-size:1em;" disabled/>                      
                    </td>
                    <td>
                      <?php echo $equip['unit_text']; ?>
                      <input type="hidden" name="unit_code_<?php echo $equip['material_type'].'_'.str_replace('.', '-', $equip['material_no']); ?>"  value="<?php echo $equip['unit_code']; ?>"/>                      
                      <input type="hidden" name="unit_text_<?php echo $equip['material_type'].'_'.str_replace('.', '-', $equip['material_no']); ?>"  value="<?php echo $equip['unit_text']; ?>"/>                      
                    </td> 
                    <td>
                      <?php
                        $remark_color = "muted";
                        if (!empty($equip['remark'])) {
                          $remark_color = "primary";
                        }
                      ?>
                      <input type="hidden" class="form-control" name="remark_<?php echo $equip['material_type'].'_'.str_replace('.', '-', $equip['material_no']); ?>" value="<?php echo $equip['remark'] ?>" >
                      <a  class="btn btn-default remark-btn-click" data-type="<?php echo $equip['material_type']; ?>" data-code="<?php echo str_replace('.', '-', $equip['material_no']); ?>" > 
                        <i class="fa fa-align-justify"></i>
                        &nbsp;                      
                        <i class="fa fa-circle text-<?php echo $remark_color; ?> text-xs v-middle remark_icon_<?php echo $equip['material_type'].'_'.str_replace('.', '-', $equip['material_no']); ?>"></i>
                      </a>
                    </td>    
                    <td>
                      <a class="btn btn-default del-row" data-type="asset" data-code="<?php echo str_replace('.', '-', $equip['material_no']); ?>"> 
                        <i class="fa fa-trash-o"></i>
                      </a>
                    </td>                                                             
                  </tr>
              <?php
                }
              } else {
              ?>                
                <tr class="empty-row"><td colspan="7">Empty</td></tr>
              <?php
              }
              ?>
              </tbody>    
              <tfoot>
                    <tr>                     
                        <th style=" visibility: hidden;"></th>
                        <th></th>    
                        <th></th>   
                        <th></th>    
                        <th></th>   
                        <th></th>    
                        <th colspan="2">  
                          <a  class="btn btn-primary add_tool pull-right" data-type="asset" ><i class="fa fa-th"></i> <?php echo freetext('add'); ?></a>                                                                     
                        </th>                            
                    </tr>
                </tfoot>  
            </table>     
          <!-- End table -->
          </section>
          <!-- End section -->
          <div class="col-sm-12" >
            <input type="hidden" class="submit_input" name="submit" value="0" />
            <a class="btn btn-s-md btn-info pull-left submit-to-sap" project-id="<?php echo $project_id; ?>" >
              <i class="fa fa-mail-forward h5"></i> <?php echo freetext('submit_return'); ?>
            </a>
            <a href="<?php echo site_url($this->page_controller.'/listview/list/'.$project_id ); ?>" class="btn btn-s-md btn-default pull-right margin-left-small"><i class="fa fa-ban h5 tx-red"></i> <?php echo freetext('cancel'); ?></a>
            <button type="submit" class="btn btn-s-md btn-primary save-btn pull-right" data-toggle=""><i class="fa fa-save h5"></i> <?php echo freetext('save'); ?></button> 
          </div>
        </form>               
        <!-- End form -->  
      </div>           
      <!-- End panel-body -->
    </div>           
    <!-- End panel-collapse -->
  </div>
  <!-- End panel row -->
</div>
<!-- End div_detail -->
<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>



          











