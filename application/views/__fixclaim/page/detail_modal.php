    <?php
    // $data = $query_track->row_array();
    // $actor_id =$data['actor_id'];
    // $actor_name =$data['actor_name'];
    // $actor_surname =$data['actor_surname'];

    // //get asset
    // $track_doc_id = $data['asset_track_document_id'];
    // $project_id=$data['project_id'];
    // $ship_to_id=$data['ship_to_id'];
    $project_id = $this->project_id;

    $fixclaim = $query_fixclaim->row_array();
    if (!array_key_exists('id', $fixclaim)) {
      $fixclaim['id'] = 0;
    }
    if (!array_key_exists('ship_to_id', $fixclaim)) {
      $fixclaim['ship_to_id'] = "";
    }
    ?>



        <div class="modal fade" id="modal-select-asset">
          <!-- #### add asset-->

          <form action='' method="POST">        
            <input type="hidden" name="untrack_doc_id" value="<?php echo $fixclaim['id']; ?>"/>
            <input type="hidden" name="untrack_project_id" value="<?php echo $project_id; ?>"/>
            <input type="hidden" name="untrack_ship_to_id" value="<?php echo $fixclaim['ship_to_id']; ?>"/>

            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title"><?php echo freetext('select_asset'); ?> </h4>
                </div>
                <div class="modal-body" style='overflow:auto'>

                <div style="height:500px; !important;">
                  <section class="panel panel-default">
                   
                    <table id="table1" class="table" height>
                     
                                    <thead>
                                        <tr class="back-color-gray">
                                            <th><?php //echo freetext('select'); ?></th>
                                            <th><?php echo freetext('serial'); ?></th>                    
                                            <th><?php echo freetext('asset_name'); ?></th>                                                        
                                        </tr>
                                    </thead>
                                    <tbody class="">  

                                      <?php 
                                      $disable_fixing = '';
                                       


                                        foreach ($query_asset->result_array() as $row){ 
                                          $asset_no = $row['ASSET_NO'];
                                          $asset_name =$row['ASSET_NAME'];

                                           $this->db->where('material_no',$row['ASSET_NO']);
                                           $this->db->where('is_close',0);
                                           $this->db->order_by("id", "desc"); 
                                           $result = $this->db->get('tbt_fix_claim');      
                                            $count = $result->num_rows();
                                            $output = array();
                                            if($count > 0 ){  $disable_fixing = 'disabled'; }else{ $disable_fixing = ''; } 

                                          // $fixed_asset_no = str_replace('.', '_', $asset_no);
                                            $fixed_asset_no = $asset_no;
                                         if($disable_fixing !='disabled'){
                                             echo "<tr>
                                                   <td class='tx-center'>
                                                     <div class='radio-$asset_no'>
                                                       <label>
                                                          <input type='radio'  class='radio_$fixed_asset_no radio_asset' name='radio_asset' asset_name='$asset_name' asset_no='$asset_no' value='$asset_no'>
                                                       </label>
                                                     </div>
                                                  </td>                                         
                                                  <td>".defill($asset_no)."</td>
                                                  <td>$asset_name</td>                                                                                      
                                              </tr>";
                                              // <input $disable_fixing type='radio'  class='radio_$fixed_asset_no radio_asset' name='radio_asset' asset_name='$asset_name' asset_no='$asset_no' value='$asset_no'>

                                        }//check fixing

                                        //$disable_fixing='';

                                      }//end foreach

                                      ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                          <th></th>
                                          <th><input type='text' class='form-control' id="search_col1_table1" placeholder="<?php echo freetext('serial'); ?>"/></th>
                                          <th><input type='text' class='form-control' id="search_col2_table1" placeholder="<?php echo freetext('asset_name'); ?>"/></th>                                          
                                            <!-- <th style=" visibility: hidden;"></th>
                                            <th><?php //echo freetext('serial'); ?></th>                    
                                            <th><?php //echo freetext('Asset_name'); ?></th>  -->                                                                                                           
                                        </tr>
                                    </tfoot>
                                </table>   
                               
                      </section>
                    </div>   


                    <div class="form-group col-sm-12 hide">
                      <label class="col-sm-3 control-label"><?php echo freetext('serial'); ?></label>
                      <div class="col-sm-9">
                       <!--   <select  name='untrack_serial' class="form-control "  id="have_serial" > -->
                          
                         <?php 
                            // foreach ($query_asset_no->result_array() as $row){
                            //   $asset_no=$row['ASSET_NO'];
                            //   $asset_name=$row['ASSET_NAME'];
                          ?>
                           <!--  <option class="select_asset" unName="<?php //echo $asset_name;?>" value='<?php //echo $asset_no;?>'>
                                <?php //echo "ASSET ID : ".$asset_no." , NAME : ".$asset_name;?> 
                            </option> -->
                          <?php 
                            //}
                          ?> 
                       <!--  </select>  -->                   
                      </div>
                    </div>
                            
                </div><!-- END scoll -->

                <div class='clear:both'></div>
                <div class="modal-footer">
                  <span class="btn select-asset-cancel  btn-default" data-dismiss="modal" aria-hidden="true"><?php echo freetext('cancel'); ?></span>
                  <span class="btn select-asset-save btn-primary" data-dismiss="modal" ><?php echo freetext('save'); ?></span>
                </div>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
            </form>
            </div>






















