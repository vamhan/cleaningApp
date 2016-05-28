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
          

          /*echo "<pre>";
          print_r($sap_data);
          echo "</pre>";*/
          //====end :  get actor name =========                      

          $output = $material_query->result_array();
          $material_list = array();
          foreach ($output as $key => $value) {
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
                <span class="input-group-addon"><?php echo '<div class="label-width-adon">'.freetext('doc_id').'</div>'; ?></span>
                <input type="text" autocomplete="off" class="form-control doc_id" readonly value="">
              </div>
            </div>                       

            <div class="col-md-4">
              <div class="input-group m-b">
                <span class="input-group-addon"><?php echo '<div class="label-width-adon">'.freetext('actual_date').'</div>'; ?></span>
                <input type="text" autocomplete="off" name="create_date" class="form-control" readonly value="<?php //if( $actual_date !='0000-00-00' ){ echo common_easyDateFormat($actual_date); }else{ echo "-"; } //$actual_date?> ">
              </div>
            </div>

            <div class="col-md-4">
              <div class="input-group m-b">
                <span class="input-group-addon">
                  <?php echo '<div class="label-width-adon">'.freetext('required_date').'</div>'; ?>
                </span>
                <div class='input-group date col-md-12' id='datetimepicker1' data-date-format="DD/MM/YYYY">
                  <input type='text' class="form-control required_date_input" readonly value="<?php echo date('d/m/Y') ?>"/>
                  <span class="input-group-addon">
                    <span class="glyphicon glyphicon-time"></span>
                  </span>
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
                <span class="input-group-addon"><?php echo '<div class="label-width-adon">'.freetext('site_inspector').'</div>'; ?></span>
                <input type="text" autocomplete="off" name="site_inspector" class="form-control" readonly value="<?php echo $this->session->userdata('actual_name');  ?>">
              </div>
            </div>                       

            <div class="col-md-4">
              <div class="input-group m-b">
                <span class="input-group-addon"><?php echo '<div class="label-width-adon">'.freetext('inspector').'</div>'; ?></span>
                <input type="text" autocomplete="off" name="inspector" class="form-control" readonly value="<?php echo $this->session->userdata('actual_name');  ?>">
              </div>
            </div>

            <div class="col-md-4">
              <div class="input-group m-b">
                <span class="input-group-addon"><?php echo '<div class="label-width-adon">'.freetext('last_requisition').'</div>'; ?></span>
                <input type="text" autocomplete="off" name="" class="form-control last_requisition_date" readonly  value="<?php  ?>">                             
              </div
            </div>
          </div>
        </div>
        <!-- End col-sm-12 -->

        <!-- Start col-sm-12 -->
        <div class="col-sm-12">
          <div class="row">    
            <div class="col-md-4">
              <div class="input-group m-b">
                <span class="input-group-addon"><?php echo '<div class="label-width-adon">'.freetext('type').'</div>'; ?></span>
                <select class="form-control date col-sm-4 job_type_id"  >                                 
                <?php
                  $map_type = array(
                    'ZOR1' => 'ZORX',
                    'ZOR2' => 'ZORY',
                    'ZOR4' => 'ZORZ'
                  );
                  $in_type = array('ZORX', 'ZORY', 'ZORZ');
                  $in_obj = array();
                  $item_cat = array();
                  foreach ($sale_order_list['ET_BREAKDOWN'] as $key => $material) {
                    if (!array_key_exists($material['AUART'], $item_cat)) {
                      $item_cat[$material['AUART']] = $material['PSTYV'];
                    }
                  }

                  foreach ($sale_order_list['ET_VBAK'] as $key => $sale_order) {
                    if (!in_array($sale_order['AUART'], $in_type)) {
                      $cat = $item_cat[$sale_order['AUART']];
                ?>
                      <option value='<?php echo $sale_order['AUART'].'_'.$cat; ?>' data-type="<?php echo $map_type[$sale_order['AUART']]; ?>" data-id="<?php echo $sale_order['VBELN']; ?>"><?php echo freetext($sale_order['AUART']."_".$cat); ?></option>
                <?php
                    } else {
                      if (!array_key_exists($sale_order['AUART'], $in_obj) || intval($in_obj[$sale_order['AUART']]) < intval($sale_order['VBELN'])) {
                        $in_obj[$sale_order['AUART']]['ID'] = $sale_order['VBELN'];
                        $date = $sale_order['ERDAT'];
                        $year = substr($date, 0, 4);
                        $month = substr($date, 4, 2);
                        $day = substr($date, 6, 2);
                        $date = date("d/m/Y", strtotime($year.'-'.$month.'-'.$day));
                        $in_obj[$sale_order['AUART']]['DATE'] = $date;
                      }
                      
                    }
                  }
                ?>         
                </select>
                <?php
                  foreach ($in_obj as $key => $value) {
                ?>
                  <input type="hidden" id="<?php echo $key; ?>_ID" value="<?php echo intval($value['ID'])+1; ?>" />
                  <input type="hidden" id="<?php echo $key; ?>_DATE" value="<?php echo $value['DATE']; ?>" />
                <?php
                  }
                ?>
              </div>
            </div>

            <div class="col-md-4">
              <div class="input-group m-b">
                <span class="input-group-addon"><?php echo '<div class="label-width-adon">'.freetext('sale_order_no').'</div>'; ?></span>
                <input type="text" autocomplete="off" class="form-control sale_order_id" readonly value="<?php  ?>">
              </div>
            </div>   

            <div class="col-md-4">
              <div class="input-group m-b">
                <span class="input-group-addon">
                  <?php echo '<div class="label-width-adon">'.freetext('remark').'</div>'; ?>
                </span>
                <div class='input-group col-md-12'>
                  <input type='text' class="form-control remark_input" readonly value=""/>
                  <a href="#" class="input-group-addon remark-btn-click">
                    <i class="fa fa-align-justify"></i>
                  </a>
                </div>
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
    <div class="panel-heading back-color-gray">Equipment Requisition for [<?php echo $project_id; ?>]</div>              
    <!-- Start panel-collapse -->
    <div class="panel-collapse in">               
      <!-- Start panel-body -->
      <div class="panel-body text-sm">                  
        <!-- Start form -->
        <form id="insert_equipment" method="post" action="<?php echo site_url('__ps_equipment_requisition/insert_requisition_document') ?>">                
          <input type="hidden" name="id" class="doc_id" />
          <input type="hidden" name="project_id" value="<?php echo $project_id; ?>" />
          <input type="hidden" name="ship_to_id" value="<?php echo $ship_to_id; ?>" />
          <input type="hidden" name="actor_id" value="<?php echo $actor_by_id; ?>" />
          <input type="hidden" name="job_type_out" class="job_type_out" value="" />
          <input type="hidden" name="job_type_id" class="job_type_id" value="" />
          <input type="hidden" name="job_cat_id" class="job_cat_id" value="" />
          <input type="hidden" name="sale_order_id" class="sale_order_id" value="" />
          <input type="hidden" name="required_date" class="required_date" value="<?php echo date('Y-m-d') ?>" />
          <input type="hidden" name="actual_date" class="actual_date" value="<?php echo date('Y-m-d') ?>" />
          <input type="hidden" name="remark" class="remark_input" value="" />
          <!-- Start section -->
          <section class="panel panel-default"> 
          <!-- Start table -->
          <?php
            if (!empty($material_list['Z001'])) {
          ?>
            <table id="table1" width="100%" class="table table_Z001">                   
              <thead>
                <tr class="back-color-gray">
                  <th style="width:200px;"><?php echo freetext('Chemicals_type'); ?></th>
                  <th style="width:300px;"><?php echo freetext('code'); ?></th>
                  <th><?php echo freetext('list'); ?></th>                    
                  <th><?php echo freetext('quantity'); ?></th>
                  <th><?php echo freetext('unit'); ?></th>                                                          
                  <th ><?php echo freetext('remark'); ?></th>                                                   
                  <th ><?php echo freetext('delete'); ?></th>
                </tr>
              </thead>
              <tbody class="data_list_asset">
              </tbody>    
              <tfoot>
                    <tr>                     
                        <th style=" visibility: hidden;"></th>
                        <th>  
                          <div class="input-group col-sm-12">
                              <div class="col-sm-8 pull-left no-padd">
                                  <input type="text" autocomplete="off" readonly class="h6 form-control" placeholder="<?php echo freetext('code'); ?>" />                                             
                              </div>
                              <a  class="btn btn-default add_tool pull-rigth" data-type="Z001" ><i class="fa fa-th"></i></a>                                           
                          </div>
                        </th>  
                        <th></th> 
                        <th></th> 
                        <th></th>     
                        <th></th>      
                        <th></th>                                  
                    </tr>
                </tfoot>  
            </table>          
          <?php
            }
          ?>
          <!-- End table -->
          <!-- Start table -->
          <?php
            if (!empty($material_list['Z002'])) {
          ?>
            <table id="table1" width="100%" class="table table_Z002">                   
              <thead>
                <tr class="back-color-gray">
                  <th style="width:200px;"><?php echo freetext('Chemicals_type'); ?></th>
                  <th style="width:300px;"><?php echo freetext('code'); ?></th>
                  <th><?php echo freetext('list'); ?></th>                    
                  <th><?php echo freetext('quantity'); ?></th>
                  <th><?php echo freetext('unit'); ?></th>                                                          
                  <th ><?php echo freetext('remark'); ?></th>                                                   
                  <th ><?php echo freetext('delete'); ?></th>
                </tr>
              </thead>
              <tbody class="data_list_asset">
              </tbody>    
              <tfoot>
                    <tr>                     
                        <th style=" visibility: hidden;"></th>
                        <th>  
                          <div class="input-group col-sm-12">
                              <div class="col-sm-8 pull-left no-padd">
                                  <input type="text" autocomplete="off" readonly class="h6 form-control" placeholder="<?php echo freetext('code'); ?>" />                                             
                              </div>
                              <a  class="btn btn-default add_tool pull-rigth" data-type="Z002" ><i class="fa fa-th"></i></a>                                           
                          </div>
                        </th>  
                        <th></th> 
                        <th></th> 
                        <th></th>     
                        <th></th>      
                        <th></th>                                  
                    </tr>
                </tfoot>  
            </table>          
          <?php
            }
          ?>
          <!-- End table -->
          <!-- Start table -->
          <?php
            if (!empty($material_list['Z013'])) {
          ?>
            <table id="table1" width="100%" class="table table_Z013">                   
              <thead>
                <tr class="back-color-gray">
                  <th style="width:200px;"><?php echo freetext('Tools_type'); ?></th>
                  <th style="width:300px;"><?php echo freetext('code'); ?></th>
                  <th><?php echo freetext('list'); ?></th>                    
                  <th><?php echo freetext('quantity'); ?></th>
                  <th><?php echo freetext('unit'); ?></th>                                                          
                  <th ><?php echo freetext('remark'); ?></th>                                                   
                  <th ><?php echo freetext('delete'); ?></th>
                </tr>
              </thead>
              <tbody class="data_list_asset">
              </tbody>    
              <tfoot>
                    <tr>                     
                        <th style=" visibility: hidden;"></th>
                        <th>  
                          <div class="input-group col-sm-12">
                              <div class="col-sm-8 pull-left no-padd">
                                  <input type="text" autocomplete="off" readonly class="h6 form-control" placeholder="<?php echo freetext('code'); ?>" />                                             
                              </div>
                              <a  class="btn btn-default add_tool pull-rigth" data-type="Z013" ><i class="fa fa-th"></i></a>                                           
                          </div>
                        </th>  
                        <th></th> 
                        <th></th> 
                        <th></th>     
                        <th></th>      
                        <th></th>                                  
                    </tr>
                </tfoot>  
            </table>          
          <?php
            }
          ?>
          <!-- End table -->
          <!-- Start table -->
          <?php
            if (!empty($material_list['Z014'])) {
          ?>
            <table id="table1" width="100%" class="table table_Z014">                   
              <thead>
                <tr class="back-color-gray">
                  <th style="width:200px;"><?php echo freetext('Tools_type'); ?></th>
                  <th style="width:300px;"><?php echo freetext('code'); ?></th>
                  <th><?php echo freetext('list'); ?></th>                    
                  <th><?php echo freetext('quantity'); ?></th>
                  <th><?php echo freetext('unit'); ?></th>                                                          
                  <th ><?php echo freetext('remark'); ?></th>                                                   
                  <th ><?php echo freetext('delete'); ?></th>
                </tr>
              </thead>
              <tbody class="data_list_asset">
              </tbody>    
              <tfoot>
                    <tr>                     
                        <th style=" visibility: hidden;"></th>
                        <th>  
                          <div class="input-group col-sm-12">
                              <div class="col-sm-8 pull-left no-padd">
                                  <input type="text" autocomplete="off" readonly class="h6 form-control" placeholder="<?php echo freetext('code'); ?>" />                                             
                              </div>
                              <a  class="btn btn-default add_tool pull-rigth" data-type="Z014" ><i class="fa fa-th"></i></a>                                           
                          </div>
                        </th>  
                        <th></th> 
                        <th></th> 
                        <th></th>     
                        <th></th>      
                        <th></th>                                  
                    </tr>
                </tfoot>  
            </table>          
          <?php
            }
          ?>
          <!-- End table -->
          </section>
          <!-- End section -->
          <div class="col-sm-12" >
            <br/>      
            <a href="<?php echo site_url($this->page_controller.'/listview/list/'.$project_id ); ?>" class="btn btn-s-md btn-default pull-right margin-left-small"><i class="fa fa-ban h5 tx-red"></i> <?php echo freetext('cancel'); ?></a>
            <button type="submit" class="btn btn-s-md btn-primary pull-right" data-toggle=""><i class="fa fa-save h5"></i> <?php echo freetext('save'); ?></button> 
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



          











