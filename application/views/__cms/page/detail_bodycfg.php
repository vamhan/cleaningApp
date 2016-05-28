<?php 

// echo '<pre>';
 // print(json_encode($pageConfig));
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
 </style>
          <section class="vbox">
            <section class="scrollable padder">
           
              <div class="m-b-md">
                <h3 class="m-b-none ">Page editor</h3>
              </div>

              <!-- start : form -->
              <!-- <form role="form" action="<?php //echo site_url('__cms_page_manager/detail/edit/1') ?>" method="POST"> -->
              <form role="form" action="<?php echo site_url('__cms_page_manager/update') ?>" method="POST">
              <input type='hidden' name='callback_url' value='<?php echo site_url('__cms_page_manager/detail/view/'.$fieldList["category_id"])?>' >
              <input type='hidden' name='category_id' value='<?php echo $fieldList["category_id"]; ?>' >
              <input type='hidden' name='id' value='<?php echo $fieldList["category_id"]; ?>' >
 
              <div class='pull-right' style='margin:4px 0px 0px 4px;'>
                <button type='submit' class="btn btn-default" data-toggle=""><i class="fa fa-pencil"></i> Save </button>
                <a class="btn btn-default" href="" data-toggle=""><i class="fa fa-trash-o"></i> Discard </a>
              </div>

              <!-- start : main-row -->
              <div class="row">
                
                 <section class="panel panel-default">

                  <!-- start : tab nav -->
                    <header class="panel-heading bg-light">
                      <ul class="nav nav-tabs nav-justified">
                        <li class="active"><a href="#info" data-toggle="tab">Info</a></li>
                        <li ><a href="#list-view" data-toggle="tab">ListView</a></li>
                        <li><a href="#detail-view" data-toggle="tab">DetailView</a></li>
                      </ul>
                    </header>
                  <!-- end : tab nav -->




                  <!-- start : tab body -->
                  
                    <div class="panel-body">
                      <div class="tab-content">

                        <!-- start : tab-pane -->
                        <div class="tab-pane active" id="info">
                          
                            <div class="form-group  col-sm-12">
                              <label>page_title</label>
                              <?php //$page_title = ( array_key_exists('page_title', $categoryDetail))?$categoryDetail['page_title']:""; ?>
                              <?php $page_title = !empty($pageConfig['page']['page_title'])?$pageConfig['page']['page_title']:""; ?>
                              <input type="text" autocomplete="off" name='page_title' class="form-control" placeholder="page_title" value="<?php echo $page_title; ?>">
                            </div>

                          

                            


                            <div class="form-group  col-sm-4">
                              <label>mod_id</label>
                              <!-- <select  name='mod_id' class="form-control" readonly> -->
                                <?php 
                                $currentModId = intval($pageConfig['page']['mod_id']);

                                $result = $this->db->get('cms_module');
                                $result = $result->result();
                                foreach ($result as $mod){
                                  $selected = ($currentModId!=$mod->id)?"":" selected='selected' ";

                                  if(empty($selected))continue;
                                  ?>
                                    <!-- <option data-table='<?php //echo $mod->main_table;?>' <?php  //echo $selected;?> value='<?php //echo $mod->id;?>'> <?php //echo $mod->module_name;?> </option>  -->
                                    <input disabled="disabled" type="text" autocomplete="off" name='module_alias' class="form-control" placeholder="module" value="<?php echo $mod->module_name; ?>">
                                    <input type="hidden" name='mod_id' value="<?php echo $currentModId; ?>">
                                    <?php  
                                 }
                                ?>
                              <!-- </select> -->
                            </div>


                            <div class="form-group  col-sm-4">
                              <label>table</label>
                              <!-- <select  name='table' class="form-control" readonly> -->
                                <!-- <option value=''></option> -->
                                <?php 
                                $currentTable = $pageConfig['page']['table'];

                                $tables = $this->db->list_tables();
                                foreach ($tables as $table){
                                  if(strpos('x'.$table, 'tb') == 1){//show only table name starting with 'tb'
                                    $selected = ($currentTable!=$table)?"":" selected='selected' ";

                                    if(empty($selected))continue;
                                    ?>
                                    <!-- <option value='<?php //echo $table;?>' <?php  //echo $selected;?> > <?php //echo $table;?> </option>  -->
                                    <input disabled="disabled" type="text" autocomplete="off" name='table_alias' class="form-control"  value="<?php echo $table; ?>">
                                    <input type="hidden" name='table' value="<?php echo $table; ?>">
                                    <?php  
                                  }
                                 }
                                ?>
                              <!-- </select> -->
                            </div>



                            <div class="form-group  col-sm-4">
                              <label>page type</label>

                              <select  name='page_type' class="form-control">
                                <option value='front_end' <?php echo ( "front_end" == $pageConfig["page"]["page_type"] )?"selected='selected'":""; ?> >Front End</option>
                                <option value='back_end' <?php echo ( "back_end" == $pageConfig["page"]["page_type"] )?"selected='selected'":""; ?> >Back End</option>
                              </select>

                            </div>



                            <div class="form-group  col-sm-4">
                              <label>sort index
                              </label>
                              <select  name='sort_index' class="form-control" >
                                <?php 
                                $currentSortIndex = $pageConfig['page']['sort_index'];
                                $fields = $this->db->list_fields($currentTable);
                                foreach ($fields as $key => $field){
                                    $selected = ($currentSortIndex!=$field)?"":" selected='selected' ";
                                    ?>
                                    <option value='<?php echo $field;?>' <?php  echo $selected;?> > <?php echo $field;?> </option>
                                    <?php  
                                }
                                ?>
                              </select>
                            </div>



                            <div class="form-group  col-sm-4">
                              <label>sort direction
                              </label>
                              <select  name='sort_direction' class="form-control" >
                                <option value='ASC' <?php echo ( "ASC" == $pageConfig["page"]["sort_direction"] )?"selected='selected'":""; ?> >ascending</option>
                                <option value='DESC' <?php echo ( "DESC" == $pageConfig["page"]["sort_direction"] )?"selected='selected'":""; ?> >descending</option>
                              </select>
                            </div>


                            <div class="form-group  col-sm-12">
                              <label>extend_dialog</label>
                              <?php $extend_dialog = !empty($pageConfig['page']['extend_dialog'])?$pageConfig['page']['extend_dialog']:""; ?>
                              <input type="text" autocomplete="off" name='extend_dialog' class="form-control" placeholder="extend_dialog" value="<?php echo $extend_dialog; ?>">
                            </div>

                            <div class="form-group  col-sm-12">
                              <label>permalink</label>
                              <input type="text" autocomplete="off" disabled name='page_permalink' class="form-control" placeholder="permalink">
                            </div>

                          
                        </div>
                        <!-- end : tab-pane -->

                        <!-- start : tab-pane -->
                        <div class="tab-pane" id="list-view">

                        <!-- start : listview config table -->
                        <table class='listview-config-table'>
                          <thead>
                          <!-- <tr><th>name</th><th>lable</th><th>visible</th><th>width</th><th>order_index</th></tr> -->
                          </thead>

                          <tbody>
                            <?php 

                            $fields = $this->db->list_fields($this->table);
                            foreach ($fields as $field)
                            {
                            ?>

                            <!-- START : SETUP TARGET OBJECT -->
                            <?php 
                                $targetObeject = array(
                                  'visible'=>0, 
                                  'label'=>'',
                                  'width'=>''
                                );

                                foreach ($pageConfig['listview']as $key => $value) {
                                  if($value['name']==$field ){
                                    $targetObeject = $value;
                                  }
                                }//end foreach 

                                $visible_row = '';
                                $sel_hide = $sel_show = 'selected="selected"';
                                if(intval($targetObeject['visible'])){
                                  $sel_show = '';
                                }else{
                                  $sel_hide = '';
                                  $visible_row = 'shadow';
                                }
                            ?>
                            <!-- END : SETUP TARGET OBJECT -->

                            <tr class='<?php echo $visible_row; ?> round ' >
                             <td style='width:98px'>
                              <select name="lv_<?php echo $field;?>[visible]" class="form-control visiblity_option">
                                <option value='1' <?php echo $sel_show;?> >Show</option>
                                <option value='0' <?php echo $sel_show;?> >Hide</option>
                              </select>

                              </td>
                              <td>
                              <input type="text" autocomplete="off" name="lv_<?php echo $field;?>[name]"  class="form-control" placeholder="name" readonly="readonly" value="<?php echo $field;?>">
                              </td>
                              <td>
                                <input type="text" autocomplete="off" name="lv_<?php echo $field;?>[label]"  class="form-control" placeholder="label" value="<?php echo (!empty($targetObeject['label']))?$targetObeject['label']:strtoupper($field);?>">
                              </td>
                             
                              <td class="col-sm-2">
                                <input type="text" autocomplete="off" name="lv_<?php echo $field;?>[width]"  class="form-control" placeholder="width" value="<?php echo (empty($targetObeject['width']))?'auto':$targetObeject['width']; ?>">
                              </td>
                            </tr>
                            <?php 
                            }
                            ?>


                          </tbody>
                        </table>
                        <!-- end : listview config table -->

                        </div>
                        <!-- end : tab-pane -->

                        <!-- start : tab-pane -->
                        <div class="tab-pane" id="detail-view">
                        <!-- start : listview config table -->
                        <table class='listview-config-table'>
                          <thead>
                          <!-- <tr><th>name</th><th>lable</th><th>visible</th><th>width</th><th>order_index</th></tr> -->
                          </thead>

                          <tbody>


                            


                            <?php 
                            $fields = $this->db->list_fields($this->table);
                            foreach ($fields as $field)
                            {
                            ?>



                            <!-- START : SETUP TARGET OBJECT -->
                            <?php 

                            $targetObeject = array(
                              "name" => "",
                              "label" => "",
                              "placeholder" => "",
                              "default_value" => "",
                              "width" => "",
                              "visiblity" => "",
                              "popover_info" => "",
                              "validation" => ""
                            );

                            foreach ($pageConfig['detailview']as $key => $value) {
                              if($value['name']==$field ){
                                $targetObeject = $value;
                              }
                            }//end foreach 

                            $visible_row = 'shadow';
                            if($targetObeject['visiblity'] != 'hidden'){
                              $visible_row = '';
                            }


                            ?>
                            <!-- END : SETUP TARGET OBJECT -->



                            <tr class='<?php echo $visible_row; ?> round ' >
                              <td>
                                <select name="dv_<?php echo $field;?>[visiblity]" class="form-control visiblity_option" style='width:98px'>
                                <?php 
                                $options = array('normal','readonly','disable','hidden');
                                foreach ($options as $key => $value) {
                                  $selected = ($targetObeject['visiblity']==$value)?"selected='selected'":"";
                                  echo "<option class='".$value."' ".$selected." >".$value."</option>";
                                }
                                ?>
                                </select>
                              </td>

                              <td>
                              <input type="text" autocomplete="off" name="dv_<?php echo $field;?>[name]"  class="form-control" placeholder="name" readonly="readonly" value="<?php echo $field;?>">
                              </td>
                              <td>
                                <input type="text" autocomplete="off" name="dv_<?php echo $field;?>[label]"  class="form-control" placeholder="label" value="<?php echo (!empty($targetObeject['label']))?$targetObeject['label']:strtoupper($field);?>">
                              </td>
                              <td>
                                <input type="text" autocomplete="off" name="dv_<?php echo $field;?>[placeholder]"  class="form-control" placeholder="placeholder" value="<?php echo $targetObeject['placeholder'];?>">
                              </td>
                              <td>
                                <input type="text" autocomplete="off" name="dv_<?php echo $field;?>[default_value]"  class="form-control" placeholder="default_value" value="<?php echo $targetObeject['default_value'];?>">
                              </td>
                             
                              <td class="col-sm-1">
                                <input type="text" autocomplete="off" name="dv_<?php echo $field;?>[width]"  class="form-control" placeholder="width" value="<?php echo !empty($targetObeject['width'])?$targetObeject['width']:"auto"; ?>">
                              </td>

                              <td class='hide'>
                                <input type="text" autocomplete="off" name="dv_<?php echo $field;?>[popover_info]"  class="form-control" placeholder="popover text" value="<?php echo $targetObeject['popover_info'];?>">
                              </td>

                              <td>
                                <select name="dv_<?php echo $field;?>[validation]" class="form-control dv_validation_selector">
                                 <?php 
                                $options = array('text','number','email','number_alphabet','phone_no','dropdown');
                                foreach ($options as $key => $value) {
                                  $selected = ($targetObeject['validation']==$value)?"selected='selected'":"";
                                  echo "<option value='".$value."' ".$selected." >".$value."</option>";
                                }
                                ?>
                                </select>
                              </td>

                              <td class='dv_content_list_index' >
                                 <select  name="dv_<?php echo $field;?>[content_list]" class="form-control">
                                 <option value=''>NONE</option>
                                  <?php 
                                  $tables = $this->db->list_tables();
                                  foreach ($tables as $table){
                                    if(strpos('x'.$table, 'tb') == 1){//show only table name starting with 'tb'
                                      $selected = '';
                                      if(array_key_exists('content_list', $targetObeject))
                                        $selected = ($targetObeject['content_list']==$table)?"selected='selected'":"";
                                      ?>
                                      <option value='<?php echo $table;?>' <?php echo $selected ?> > <?php echo $table;?> </option> 
                                      <?php  
                                    }
                                   }
                                  ?>
                                </select>
                              </td>


                            </tr>
                            <?php 
                            }
                            ?>
                          </tbody>
                        </table>
                          <!-- end : listview config table -->
                        </div>
                        <!-- end : tab-pane -->

                      </div>
                    </div>
                  
                  <!-- end : tab body -->

                   
                  </section>


              </div>
              <!-- end : main-row -->
              </form>
              <!-- end : form -->
             
            </section>
          </section>
          <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
        