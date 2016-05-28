<?php 

// echo '<pre>';
//  print(json_encode($pageConfig));
//  print(json_encode($gameConfig));
// echo '</pre>';

?>

 <style type="text/css">
 .listview-config-table th{ text-transform: uppercase; text-align: center}
 .listview-config-table tr td{ text-align: center; padding:2px 4px;}
 /*.listview-config-table tr.shadow,*/
 .listview-config-table tr.shadow input{ display: none}
 .listview-config-table tr.shadow select{ display: none}

 .listview-config-table tr.shadow select.visiblity_option,
 .listview-config-table tr.shadow input[readonly="readonly"]{display: inline; background: none;border: none; color:#ccc;}

 .api-result{max-height: 200px !important; overflow: auto;margin :4px 0px ; padding:2px;}
 .api-request{background: rgba(58, 56, 56, 0.06); line-height: 32px; border: none !important;}
 </style>
          <section class="vbox">
            <section class="scrollable padder">
           
              <div class="m-b-md">
                <h3 class="m-b-none ">API editor</h3>
              </div>

              <!-- start : form -->
              <!-- <form role="form" action="<?php //echo site_url('__cms_page_manager/detail/edit/1') ?>" method="POST"> -->
              <form role="form" action="<?php echo site_url('__cms_api_manager/update') ?>" method="POST">
              <input type='hidden' name='callback_url' value='<?php echo site_url('__cms_api_manager/detail/view/'.$fieldList["category_id"])?>' >
              <input type='hidden' name='category_id' value='<?php echo $fieldList["category_id"]; ?>' >
 
              <div class='pull-right' style='margin:4px 0px 0px 4px;'>
                <button type='submit' class="btn btn-default" data-toggle=""><i class="fa fa-pencil"></i> Save </button>
                <a class="btn btn-default" href="" data-toggle=""><i class="fa fa-trash-o"></i> Discard </a>
              </div>
              <div class="clear" style='clear:both'></div>

              <!-- START : MAIN - ROW -->
              <div class="row">

              <?php 
              // echo '<pre>';
              //   print_r($pageConfig);
              // echo '</pre>';

               ?>
              <!-- START : LEFT PANEL -->
              <div class="col-sm-6">
               <section class="panel panel-default">
                    <header class="panel-heading font-bold">META</header>
                    <div class="panel-body">
                      
                        <div class="form-group">
                          <label>Name</label>
                          <?php 
                          $name = '';
                            if(!empty($pageConfig['meta']) && array_key_exists('name', $pageConfig['meta']))$name = $pageConfig['meta']['name'] 
                           ?>
                          <input name="meta[name]" class="form-control" placeholder="method" readonly="readonly" value='<?php echo $name; ?>'>
                        </div>
                        <div class="form-group" class="">
                          <label>Table</label>
                          <?php 
                            $table = '';
                            if(!empty($pageConfig['meta']) && array_key_exists('table', $pageConfig['meta']))$table = $pageConfig['meta']['table'] 
                          ?>
                          <input name="meta[table]" class="form-control" placeholder="method" readonly="readonly" value='<?php echo $table; ?>'>
                        </div>


                         <div class="form-group" class="">
                          <label>Description</label><br>
                            <?php 
                            $description = '';
                            if(!empty($pageConfig['meta']) && array_key_exists('description', $pageConfig['meta']))$description = $pageConfig['meta']['description'] 
                          ?>
                          <textarea name="meta[description]" style='min-width:0px' class='col-sm-12'><?php echo $description;?></textarea>
                        </div>




                          <?php 
                            $cat_id = '';
                            if(!empty($pageConfig['meta']) && array_key_exists('cat_id', $pageConfig['meta']))$cat_id = $pageConfig['meta']['cat_id'] 
                          ?>
                          <input type='hidden' name="meta[cat_id]" value='<?php echo $cat_id; ?>'>

                          <?php 
                            $mod_id = '';
                            if(!empty($pageConfig['meta']) && array_key_exists('mod_id', $pageConfig['meta']))$mod_id = $pageConfig['meta']['mod_id'] 
                          ?>
                          <input type='hidden' name="meta[mod_id]" value='<?php echo $mod_id; ?>'>

                       
                          
                      
                        <!-- <div class="checkbox">
                          <label>
                            <input type="checkbox"> Check me out
                          </label>
                        </div>
                        <button type="submit" class="btn btn-sm btn-default">Submit</button> -->
                      
                    </div>
                  </section>
                </div>
                <!-- END : LEFT PANEL -->


                <!-- START : RIGTH PANEL -->
                  <div class="col-sm-6">
               <section class="panel panel-default">
                    <header class="panel-heading font-bold">CONFIG</header>
                    <div class="panel-body">
                      
                        <div class="form-group">
                          <label>AUTH TYPE</label>

                          <select name="body[auth_type]" class="form-control visiblity_option" >
                                <?php 
                                $options = array('PUBLIC_TOKEN','PRIVATE_TOKEN','NONE');
                                foreach ($options as $key => $value) {
                                  $selected = ($pageConfig['body']['auth_type']==$value)?"selected='selected'":"";
                                  echo "<option class='".$value."' ".$selected." >".$value."</option>";
                                }
                                ?>
                          </select>


                          <!-- <select class="form-control" name='auth_type'>
                            <option value='NONE'>NONE</option>
                            <option value='PUBLIC_TOKEN'>PUBLIC_TOKEN</option>
                            <option value='PRIVATE_TOKEN'>PRIVATE_TOKEN</option>
                          </select> -->
                        </div>
                        <div class="form-group">
                          <label>Method</label>
                          
                           <select name="body[method]" class="form-control visiblity_option" >
                                <?php 
                                $options = array('GET','POST');
                                foreach ($options as $key => $value) {
                                  $selected = ($pageConfig['body']['method']==$value)?"selected='selected'":"";
                                  echo "<option class='".$value."' ".$selected." >".$value."</option>";
                                }
                                ?>
                          </select>

                        </div>


                         <div class="form-group">
                          <label>API READY</label>
                          <?php 
                          $api_ready = '';
                            if(!empty($pageConfig['meta']) && array_key_exists('is_ready_to_use', $pageConfig['meta']))$api_ready = $pageConfig['meta']['is_ready_to_use'] 
                           ?>
                          <input name="meta[is_ready_to_use]" class="form-control" placeholder="IS READY TO USE" value='<?php echo $api_ready; ?>'>
                        </div>
                      


                        <!-- <div class="checkbox">
                          <label>
                            <input type="checkbox"> Check me out
                          </label>
                        </div>
                        <button type="submit" class="btn btn-sm btn-default">Submit</button> -->
                    </div>
                  </section>
                </div>
                <!-- END : RIGHT PANEL -->





                 <!-- START : CONSOLE PANEL -->
              <div class="col-sm-12">
             

                <!-- .dropdown -->
                  <section class="panel panel-default pos-rlt clearfix">
                    <header class="panel-heading">
                      <ul class="nav nav-pills pull-right">
                        <li>
                          <a href="#" class="panel-toggle text-muted"><i class="fa fa-caret-down text-active"></i><i class="fa fa-caret-up text"></i></a>
                        </li>
                      </ul>
                      <span class="label bg-primary">GET</span> List
                    </header>
                    <!-- <div class="panel-body clearfix collapse"> -->
                    <div class="panel-body clearfix collapse">
                      <!-- SEARCH INDEX  - DEFAULT PAGE SIZE - SORT -->

                              <!-- start : config row -->
                               <div class='row'>
                                  <div class="form-group col-sm-3">
                                  <label>Search Index</label>
                                  <select class="form-control" name='body[list][search_index]'>
                                   <?php 
                                   $fields = $this->db->list_fields($this->config_table);
                                   foreach ($fields as $field){
                                    $selected = ($pageConfig['body']['list']['search_index']==$field)?"selected='selected'":"";
                                    echo "<option class='".$field."' ".$selected." >".$field."</option>";
                                  } ?>
                                </select>
                              </div>

                              <div class="form-group col-sm-3">
                                <label>Page size</label>
                                <?php 
                                if(empty($pageConfig['body']['default_page_size']) || intval($pageConfig['body']['default_page_size'] < 10))
                                  $pageConfig['body']['default_page_size'] = 10;
                                ?>
                                <input name="body[list][default_page_size]" class="form-control" placeholder="default Page Size" value="<?php echo $pageConfig['body']['default_page_size']?> " >
                                <!-- <input name="api_name" class="form-control" placeholder="method" readonly="readonly" value='<?php //echo $name; ?>'> -->
                              </div>

                              <div class="form-group col-sm-3">
                                <label>Sort Index</label>
                                <select class="form-control" name='body[list][sort_index]'>
                                  <?php 
                                  $fields = $this->db->list_fields($this->config_table);
                                  foreach ($fields as $field){
                                    $selected = ($pageConfig['body']['list']['sort_index']==$field)?"selected='selected'":"";
                                    echo "<option class='".$field."' ".$selected." >".$field."</option>";
                                  } ?>
                                </select>
                              </div>

                              <div class="form-group col-sm-3">
                                <label>Sort Direction</label>
                                <select class="form-control" name='body[list][sort_direction]'>
                                  <?php 
                                  $options = array('ASC','DESC');
                                  foreach ($options as $key => $value) {
                                    $selected = ($pageConfig['body']['list']['sort_direction']==$value)?"selected='selected'":"";
                                    echo "<option class='".$value."' ".$selected." >".$value."</option>";
                                  }
                                  ?>
                                </select>
                              </div>
                               </div>
                               <!-- end : config row -->




                                <!-- start : api console row -->
                                <div class="alert alert-warning alert-block api-console" style='overflow:auto' api-method='get_commonList' api-name='<?php echo $pageConfig['meta']['name']; ?>'>
                                  
                                  <!-- start : filter row -->
                                  <div class="row">
                                    <div class="form-group col-sm-3">
                                      <label>Keyword</label>
                                      <input class="form-control api-keyword" >
                                    </div>
                                    <div class="form-group col-sm-3">
                                      <label>Page </label>
                                      <input class="form-control api-page" value='1' >
                                    </div>
                                    
                                  </div>

                                  <div class='col-sm-12 api-result round' placceholder='API response' readonly="readonly"></div>

                                  <!-- <div class="row"> -->
                                  <div class="clear" class='clear:both'></div>
                                  <hr>
                                    <div class="api-request round-small col-sm-10 pull-left" style='display:none'></div>
                                    <a class='btn-danger btn btn-small pull-right api-console-submit'>Request</a>
                                  <!-- </div> -->
                                </div>
                                <!-- start :  api console row -->
                    </div>
                  </section>
                  <!-- / .dropmenu -->

              </div>
                <!-- END : CONSOLE PANEL -->




                 <!-- START : CONSOLE PANEL -->
              <div class="col-sm-12">
             
                  <section class="panel panel-default pos-rlt clearfix">
                    <header class="panel-heading">
                      <ul class="nav nav-pills pull-right">
                        <li>
                          <a href="#" class="panel-toggle text-muted"><i class="fa fa-caret-down text-active"></i><i class="fa fa-caret-up text"></i></a>
                        </li>
                      </ul>
                      <span class="label bg-primary">GET</span> Detail
                    </header>
                    <div class="panel-body clearfix collapse">
                      <!-- start : config row -->
                      <input type='hidden' name="body[detail]" class="form-control" placeholder="" readonly="readonly" value=''>
                      <!-- end : config row -->
                               


                                <!-- start : api console row -->
                                <div class="alert alert-warning alert-block api-console" style='overflow:auto' api-method='get_commonDetail' api-name='<?php echo $pageConfig['meta']['name']; ?>' >
                                  
                                  <!-- start : filter row -->
                                  <div class="row">
                                    <div class="form-group col-sm-3">
                                      <label>Object Id</label>
                                      <input class="form-control api-object-id" >
                                    </div>
                                    <!-- <div class="form-group col-sm-3">
                                      <label>Page </label>
                                      <input class="form-control api-page" value='1' >
                                    </div> -->
                                    
                                  </div>

                                  <div class='col-sm-12 api-result' placceholder='API response' readonly="readonly"></div>

                                  <!-- <div class="row"> -->
                                  <div class="clear" class='clear:both'></div>
                                  <hr>
                                    <div class="api-request round-small col-sm-10 pull-left" style='display:none'></div>
                                    <a class='btn-danger btn btn-small pull-right api-console-submit'>Request</a>
                                  <!-- </div> -->
                                </div>
                                <!-- start :  apiconsole row -->

                      
                    </div>
                  </section>

              </div>
                <!-- END : CONSOLE PANEL -->











              <!-- START : CONSOLE PANEL -->
              <div class="col-sm-12">
             

                <!-- .dropdown -->
                  <section class="panel panel-default pos-rlt clearfix">
                    <header class="panel-heading">
                      <ul class="nav nav-pills pull-right">
                        <li>
                          <a href="#" class="panel-toggle text-muted"><i class="fa fa-caret-down text-active"></i><i class="fa fa-caret-up text"></i></a>
                        </li>
                      </ul>
                      <span class="label bg-warning">SET</span> Insert
                    </header>
                    <div class="panel-body clearfix collapse">
                      <!-- start : config row -->
                      <div class="form-group col-sm-8">
                        <label>Required Field</label>
                        <input name="body[insert][required_field]" class="form-control" placeholder="required field" value="<?php echo $pageConfig['body']['insert']['required_field'] ?>">
                      </div>

                      <div class="form-group col-sm-4">
                          <label>Where Index</label>
                          <select class="form-control" name='body[insert][where_index]'>
                             <?php 
                             $fields = $this->db->list_fields($this->config_table);
                             foreach ($fields as $field){
                                $selected = ($pageConfig['body']['insert']['where_index']==$field)?"selected='selected'":"";
                                  echo "<option class='".$field."' ".$selected." >".$field."</option>";
                              } ?>
                          </select>


                      </div>
                      <!-- end : config row -->
                      <div class='clear' style='clear:both'></div>

                        <!-- start : api console row -->
                                <div class="alert alert-warning alert-block api-console" style='overflow:auto' api-method='set_commonInsert' api-name='<?php echo $pageConfig['meta']['name']; ?>' >
                                  <!-- start : filter row -->
                                  <div class="row">
                                   <?php  
                                    $list = explode(',', $pageConfig['body']['insert']['required_field']);
                                    foreach ( $list as $key => $value) { ?>

                                    <div class="form-group col-sm-3">
                                      <label><?php echo $value?></label>
                                      <input class="form-control api-object-field" object-name="<?php echo $value?>">
                                    </div>

                                   <?php
                                    }
                                   ?>

                                    <!-- <div class="form-group col-sm-3">
                                      <label>Where [<?php //echo $pageConfig['body']['insert']['where_index']; ?>]</label>
                                      <input class="form-control api-object-where" object-name="<?php //echo $pageConfig['body']['insert']['where_index']?>" >
                                    </div>-->

                                    

                                  </div>

                                  <div class='col-sm-12 api-result' placceholder='API response' readonly="readonly"></div>

                                  <!-- <div class="row"> -->
                                  <div class="clear" class='clear:both'></div>
                                  <hr>
                                    <div class="api-request round-small col-sm-10 pull-left" style='display:none'></div>
                                    <a class='btn-danger btn btn-small pull-right api-console-submit'>Request</a>
                                  <!-- </div> -->
                                </div>
                        <!-- start :  apiconsole row -->



                    </div>
                  </section>
                  <!-- / .dropmenu -->

              </div>
                <!-- END : CONSOLE PANEL -->


                 <!-- START : CONSOLE PANEL -->
              <div class="col-sm-12">
             

                <!-- .dropdown -->
                  <section class="panel panel-default pos-rlt clearfix">
                    <header class="panel-heading">
                      <ul class="nav nav-pills pull-right">
                        <li>
                          <a href="#" class="panel-toggle text-muted"><i class="fa fa-caret-down text-active"></i><i class="fa fa-caret-up text"></i></a>
                        </li>
                      </ul>
                      <span class="label bg-warning">SET</span> Update
                    </header>
                    <div class="panel-body clearfix collapse">

                    <!-- start : config row -->
                      <div class="form-group col-sm-8">
                        <label>Required Field</label>
                        <input name="body[update][required_field]" class="form-control" placeholder="required field"  value="<?php echo $pageConfig['body']['update']['required_field'] ?>">
                      </div>

                      <div class="form-group col-sm-4">
                          <label>Where Index</label>
                            <select class="form-control" name='body[update][where_index]'>
                             <?php 
                             $fields = $this->db->list_fields($this->config_table);
                             foreach ($fields as $field){
                                $selected = ($pageConfig['body']['update']['where_index']==$field)?"selected='selected'":"";
                                  echo "<option class='".$field."' ".$selected." >".$field."</option>";
                              } ?>
                          </select>
                      </div>
                    <!-- end : config row -->


                     <div class='clear' style='clear:both'></div>

                        <!-- start : api console row -->
                                <div class="alert alert-warning alert-block api-console" style='overflow:auto' api-method='set_commonUpdate' api-name='<?php echo $pageConfig['meta']['name']; ?>' >
                                  <!-- start : filter row -->
                                  <div class="row">
                                   <?php  
                                    $list = explode(',', $pageConfig['body']['update']['required_field']);
                                    foreach ( $list as $key => $value) { ?>

                                    <div class="form-group col-sm-3">
                                      <label><?php echo $value?></label>
                                      <input class="form-control api-object-field" object-name="<?php echo $value?>">
                                    </div>

                                   <?php
                                    }
                                   ?>

                                     <div class="form-group col-sm-3">
                                      <label>Where [<?php echo $pageConfig['body']['update']['where_index']; ?>]</label>
                                      <input class="form-control api-object-where" object-name="<?php echo $pageConfig['body']['update']['where_index']?>" >
                                    </div>

                                    

                                  </div>

                                  <div class='col-sm-12 api-result' placceholder='API response' readonly="readonly"></div>

                                  <!-- <div class="row"> -->
                                  <div class="clear" class='clear:both'></div>
                                  <hr>
                                    <div class="api-request round-small col-sm-10 pull-left" style='display:none'></div>
                                    <a class='btn-danger btn btn-small pull-right api-console-submit'>Request</a>
                                  <!-- </div> -->
                                </div>
                        <!-- start :  apiconsole row -->




                    </div>
                  </section>
                  <!-- / .dropmenu -->

              </div>
                <!-- END : CONSOLE PANEL -->


                 <!-- START : CONSOLE PANEL -->
              <div class="col-sm-12">
             

                <!-- .dropdown -->
                  <section class="panel panel-default pos-rlt clearfix">
                    <header class="panel-heading">
                      <ul class="nav nav-pills pull-right">
                        <li>
                          <a href="#" class="panel-toggle text-muted"><i class="fa fa-caret-down text-active"></i><i class="fa fa-caret-up text"></i></a>
                        </li>
                      </ul>
                      <span class="label bg-warning">SET</span> Delete
                    </header>
                    <div class="panel-body clearfix collapse">
                      <!-- start : config row -->
                      <!-- <div class="form-group col-sm-12">
                        <label>Required Field</label>
                        <input name="body[delete][required_field]" class="form-control" placeholder="required field" >
                      </div>
 -->
                      <div class="form-group col-sm-3">
                          <label>Where Index</label>
                           <!-- <select class="form-control" name='delete[where_index]'>
                            <option value='item1'>item1</option>
                            <option value='item2'>item2</option>
                            <option value='item3'>item3</option>
                            <option value='item4'>item4</option>
                          </select> -->

                          <select class="form-control" name='body[delete][where_index]'>
                             <?php 
                             $fields = $this->db->list_fields($this->config_table);
                             foreach ($fields as $field){
                                $selected = ($pageConfig['body']['delete']['where_index']==$field)?"selected='selected'":"";
                                  echo "<option class='".$field."' ".$selected." >".$field."</option>";
                              } ?>
                          </select>
                      </div>
                      <!-- end : config row -->



                     <div class='clear' style='clear:both'></div>

                        <!-- start : api console row -->
                                <div class="alert alert-warning alert-block api-console" style='overflow:auto' api-method='set_commonDelete' api-name='<?php echo $pageConfig['meta']['name']; ?>' >
                                  <!-- start : filter row -->
                                  <div class="row">
                                  
                                     <div class="form-group col-sm-3">
                                      <label>Where [<?php echo $pageConfig['body']['delete']['where_index']; ?>]</label>
                                      <input class="form-control api-object-where" object-name="<?php echo $pageConfig['body']['delete']['where_index']?>" >
                                    </div>

                                    

                                  </div>

                                  <div class='col-sm-12 api-result' placceholder='API response' readonly="readonly"></div>

                                  <!-- <div class="row"> -->
                                  <div class="clear" class='clear:both'></div>
                                  <hr>
                                    <div class="api-request round-small col-sm-10 pull-left" style='display:none'></div>
                                    <a class='btn-danger btn btn-small pull-right api-console-submit'>Request</a>
                                  <!-- </div> -->
                                </div>
                        <!-- start :  apiconsole row -->


                    
                    </div>
                  </section>
                  <!-- / .dropmenu -->

              </div>
                <!-- END : CONSOLE PANEL -->











                 </div>
                 <!-- END : MAIN - ROW -->







              </form>
              <!-- end : form -->
             
            </section>
          </section>
          <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
        