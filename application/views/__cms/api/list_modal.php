      <div class="modal fade" id="modal-form">
          <form action='<?php echo site_url($this->page_controller.'/create'); #CMS ?>' method="POST">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title"><?php echo 'New '.$this->page_object;#CMS ?> </h4>
                </div>
                <div class="modal-body" style='overflow:auto'>
                            <!--  #CMS  -->
                            <div class="form-group  col-sm-12">
                              <label>Object name</label>
                              <input type="text" autocomplete="off" name='name' class="form-control" placeholder="method name">
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
                              <label>Category</label>
                              <select  name='cat_id' class="form-control">
                                <?php 
                                $result = $this->db->get('cms_category');
                                $result = $result->result();
                                foreach ($result as $cat){
                                  if($cat->module_id == 1 )continue;#CMS - Skip Category on  CMS Module
                                  ?><option data-table='<?php echo $cat->table;?>' value='<?php echo $cat->id;?>'> <?php echo $cat->name;?> </option> <?php  
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
                                  //Exception for API
                                  // if(strpos('x'.$table, 'tb') == 1){//show only table name starting with 'tb'
                                    ?><option value='<?php echo $table;?>'> <?php echo $table;?> </option> <?php  
                                  // }
                                 }
                                ?>
                              </select>
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



















          <div class="modal fade" id="modal-auth">
          <form action='<?php echo site_url($this->page_controller.'/update_auth'); #CMS ?>' method="POST">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Authentication Management</h4>
                </div>
                <div class="modal-body" style='overflow:auto'>
                            <!--  #CMS  -->


                            <!-- start : auth demo -->
                            <div class="form-group  col-sm-12">
                              <label>API KEY (Fixed : <?php echo strlen($api_key); ?> )</label>
                              <input type="text" autocomplete="off" name='api_key' class="form-control" placeholder="" readonly="readonly" value="<?php echo $api_key; ?>" >
                              <label>API SECRET (Fixed : <?php echo strlen($secret_key); ?>)</label>
                              <input type="text" autocomplete="off" name='secret_key' class="form-control" placeholder="" readonly="readonly" value="<?php echo $secret_key; ?>">
                              <a target='_blank' href="<?php echo site_url('__cms_api_manager/resetAPIKEY/1'); ?>">Reset</a>
                            </div>

                            <div class="form-group  col-sm-12">
                              <label>SAMPLE FBID ( <?php $fbid = 100000610723387; echo strlen($fbid); ?> ) </label>
                              <input type="text" autocomplete="off" name='fbid' class="form-control" placeholder="" readonly="readonly" value="<?php echo $fbid; ?>">
                              <label>Sample User Digest [ by md5(secret_key + fbid )+fbid ] (<?php $user_digest = md5($secret_key.$fbid).$fbid;  echo strlen($user_digest) ?>)</label>
                              <input type="text" autocomplete="off" name='user_digest' class="form-control" placeholder="" readonly="readonly" value="<?php echo $user_digest; ?>" >
                              
                              <label>Sample Server Digest [ by zip( md5(dayTimeString + secret_key )+user_digest ) ] (<?php 
                                  
                                  date_default_timezone_set('Asia/Bangkok');
                                  //Half of server digest
                                  $input1 = md5(date('Y-m-d',time()).$secret_key);
                                  //Another half of server digest
                                  $input2 = $user_digest;
                                  
                                  //Start zip
                                  $server_digest = '';
                                  $len = strlen($input1);
                                  while($len--){
                                    $server_digest .=$input1[$len];
                                    $server_digest .=$input2[$len];
                                  }
                                    // $server_digest;
                                  //End zip
                                  echo strlen($server_digest);

                                ?>)</label>
                              <input type="text" autocomplete="off" name='server_digest' class="form-control" placeholder="" readonly="readonly" value="<?php echo $server_digest; ?>" >

                               <label>User Digest [ unzip($server_digest)[1] ] (<?php 
                                  
                                  //Start unzip
                                  $output = array();
                                  $output['output1'] = $output['output2'] = '';
                                  $len = strlen($server_digest);

                                  while($len--){
                                    $output['output1'] .=$server_digest[$len];
                                    $output['output2'] .=$server_digest[$len-1];
                                    $len--;
                                  }
                                  $de_user_digest = $output['output1'];;
                                  //End unzip

                                  echo strlen($de_user_digest);

                                ?>)</label>
                              <input type="text" autocomplete="off" name='server_digest' class="form-control" placeholder="" readonly="readonly" value="<?php echo $de_user_digest; ?>" >
                            </div>




                            <!-- start : auth-console element -->
                            <div class="form-group  col-sm-12">
                               
                              <div class="alert alert-success auth-console">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <i class="fa fa-ok-sign"></i><strong>Regsiter</strong> 
                                  User must register to API server right after first logged in to facebook with sso mobile application.
                                <!-- <a href="#" class="alert-link">this important alert message</a>. -->
                                <p>
                                  <!-- 'fbid','user_email','user_firstname','user_lastname' -->
                                <input type="text" autocomplete="off" name='fbid' class="form-control" placeholder="Facebook ID" >
                                <input type="text" autocomplete="off" name='user_firstname' class="form-control" placeholder="Firstname" >
                                <input type="text" autocomplete="off" name='user_lastname' class="form-control" placeholder="Lastname" >
                                <input type="text" autocomplete="off" name='user_email' class="form-control" placeholder="Email" >
                                <input type="text" autocomplete="off" name='api_key' class="form-control" placeholder="Your API key" >
                                <div class="auth-console-result">
                                  
                                </div>
                                <div class='btn btn-success pull-right'>Submit</div>

                                </p>
                            </div>
                          </div>
                          <!-- end : auth-console element -->


                            
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



























