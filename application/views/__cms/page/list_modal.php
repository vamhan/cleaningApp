


        <div class="modal fade" id="modal-date-asset-1">
         <!-- #### select date asset 1-->
          <form action='<?php echo site_url($this->page_controller.'/create');  ?>' method="POST">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title"><?php echo 'Select date';?> </h4>
                </div>
                <div class="modal-body" style='overflow:auto'>              
                  

                  <div class="col-sm-12 add-all-medium">
                    <div class="row no-padd">
                      <div class="col-md-4 no-padd">                        
                          <select  name='date' class="form-control date col-sm-4"  >                                 
                          <option value='1'>day 1</option>        
                          </select>
                      </div>
                      <div class="col-md-4">
                         <div class="input-group m-b">
                          <input type="text" autocomplete="off" class="form-control" readonly value="january">
                        </div>
                      </div>
                      <div class="col-md-4 no-padd">
                         <div class="input-group m-b">
                          <input type="text" autocomplete="off" class="form-control" value="24 Regular" readonly value="2014">
                        </div>
                      </div>
                    </div>
                </div>

                </div>

                <div class='clear:both'></div>
                <div class="modal-footer">
                  <a href="#" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban h5 tx-red"></i> Cancel</a>
                  <button type="submit" class="btn btn-primary" name="save"><i class="fa fa-save h5"></i> Save</button> 
                   <!-- <input type='hidden' name="callback_url"value="<?php echo site_url($this->page_controller.'/listview'); ?>">
                  <input type='submit' class="btn btn-primary" value="Save"> -->                                   
                </div>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
            </form>
      </div>



      <div class="modal fade" id="modal-date-asset-2">
         <!-- #### select date asset 2-->
          <form action='<?php echo site_url($this->page_controller.'/create');  ?>' method="POST">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title"><?php echo 'Select date';?> </h4>
                </div>
                <div class="modal-body" style='overflow:auto'>              
                  

                  <div class="col-sm-12 add-all-medium">
                    <div class="row no-padd">
                      <div class="col-md-4 no-padd">                        
                          <select  name='date' class="form-control date col-sm-4"  >                                 
                          <option value='1'>day 1</option>        
                          </select>
                      </div>
                      <div class="col-md-4">
                         <div class="input-group m-b">
                          <input type="text" autocomplete="off" class="form-control" readonly value="febuary">
                        </div>
                      </div>
                      <div class="col-md-4 no-padd">
                         <div class="input-group m-b">
                          <input type="text" autocomplete="off" class="form-control" value="24 Regular" readonly value="2014">
                        </div>
                      </div>
                    </div>
                </div>

                </div>

                <div class='clear:both'></div>
                <div class="modal-footer">
                  <a href="#" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban h5 tx-red"></i> Cancel</a>
                  <button type="submit" class="btn btn-primary" name="save"><i class="fa fa-save h5"></i> Save</button> 
                   <!-- <input type='hidden' name="callback_url"value="<?php echo site_url($this->page_controller.'/listview'); ?>">
                  <input type='submit' class="btn btn-primary" value="Save"> -->                                   
                </div>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
            </form>
      </div>









          <!--Start: modal add new category -->

          <div class="modal fade" id="modal-form">
          <form action='<?php echo site_url($this->page_controller.'/create'); #CMS?>' method="POST">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title"><?php echo 'New '.$this->page_object;#CMS ?> </h4>
                </div>
                <div class="modal-body" style='overflow:auto'>
                            <!--  #CMS  -->
                            <div class="form-group  col-sm-12">
                              <label>Page title</label>
                              <input type="text" autocomplete="off" name='page_title' class="form-control" placeholder="page_title">
                            </div>


                            <div class="form-group  col-sm-6">
                              <label>on Module</label>
                              <select  name='mod_id' class="form-control">
                                <!-- <option value=''></option> -->
                                <?php 
                                $result = $this->db->get('cms_module');
                                $result = $result->result();
                                foreach ($result as $mod){
                                  #CMS
                                  // if($mod->id == 1 )continue; #Skip CMS Module

                                  ?><option data-table='<?php echo $mod->main_table;?>' value='<?php echo $mod->id;?>'> <?php echo $mod->module_name;?> </option> <?php  
                                 }
                                ?>
                              </select>
                            </div>


                            <div class="form-group  col-sm-6">
                              <label>Table</label>
                              <select  name='table' class="form-control">
                                <!-- <option value=''></option> -->
                                <?php 
                                $tables = $this->db->list_tables();
                                foreach ($tables as $table){
                                  if(strpos('x'.$table, 'tb') == 1){//show only table name starting with 'tb'
                                    ?><option value='<?php echo $table;?>'> <?php echo $table;?> </option> <?php  
                                  }
                                 }
                                ?>
                              </select>
                            </div>



                            <div class="form-group  col-sm-6">
                              <label>Category</label>
                              <select  name='cat_id' class="form-control">
                              <!-- <option value='undefined'>Undefined</option> -->
                                <?php 
                                $result = $this->db->get('cms_category');
                                $result = $result->result();
                                foreach ($result as $cat){
                                  // if($cat->module_id == 1 )continue;#CMS - Skip Category on  CMS Module
                                  ?><option data-table='<?php echo $cat->table;?>' value='<?php echo $cat->id;?>'> <?php echo $cat->name;?> </option> <?php  
                                 }
                                ?>
                                <!-- <option value='new_category'>Add New Category</option> -->
                              </select>
                            </div>


                            <div class="form-group  col-sm-6">
                              <label>Category</label>
                              <select  name='page_type' class="form-control">
                              	<option value='front_end'>Front End</option>
                              	<option value='back_end' selected="selected">Back End</option>
                              </select>
                            </div>

                            

                            <input type='hidden' name='sort_index' value='id' />
                            <input type='hidden' name='sort_direction' value='DESC' />
                            <input type='hidden' name='content_list' value='' />

                            
                            <div class="form-group  col-sm-12">
                              <label>Extend dialog</label>
                              <input type="text" autocomplete="off" name='extend_dialog' class="form-control" placeholder="extend_dialog">
                            </div>

                            <div class="form-group  col-sm-12">
                              <label>permalink</label>
                              <input type="text" autocomplete="off" disabled name='page_permalink' class="form-control" placeholder="permalink">
                            </div>                        
                          
                </div>

                <div class='clear:both'></div>
                <div class="modal-footer">
                  <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
                  <input type='hidden' name="callback_url"value="<?php echo site_url($this->page_controller.'/listview'); ?>">
                  <input type='submit' class="btn btn-primary" value="Save">
                </div>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
            </form>
            </div>
