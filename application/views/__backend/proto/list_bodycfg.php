<style type="text/css">
  .table-head,.table-division{ text-align: center }
  .panel-heading .btn-sm { margin-top: -6px}
  .page-action-panel .btn {margin: 0px 4px;}
</style>

<?php 
  // var_dump(count($config['listview']));
  //                     die('x');
              $col_length = 2;
              foreach ($config['listview'] as $key => $value) {
                if(intval($value['visible']))$col_length++;
              }//end foreach

?>

 <section class="vbox">
            <section class="scrollable padder">
              <ul class="breadcrumb no-border no-radius b-b b-light pull-in">
                <li><a href="index.html"><i class="fa fa-home"></i> Home</a></li>
                <li><a href="#">UI kit</a></li>
                <li><a href="#">Table</a></li>
                <li class="active">Datagrid</li>
              </ul>
              <!-- <div class="m-b-md">
                <h3 class="m-b-none">Datagrid</h3>
              </div> -->
              <section class="panel panel-default">
                <header class="panel-heading">
                  <?php 
                    #CMS
                    print($this->page_title);
                    #END_CMS
                  ?>
                  
                </header>
                <div class="table-responsive">
                  <table id="MyStretchGrid" class="table table-striped datagrid m-b-sm">
                    <thead>
                      <tr>
                        <th colspan="<?php echo $col_length; ?>">
                          <div class="row">
                            <!-- <div class="col-sm-8 m-t-xs m-b-xs">
                              <div class="select filter" data-resize="auto">
                                <button data-toggle="dropdown" class="btn btn-sm btn-default dropdown-toggle">
                                  <span class="dropdown-label"></span>
                                  <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                  <li data-value="all" data-selected="true"><a href="#">All</a></li>
                                  <li data-value="lt5m"><a href="#">Population &lt; 5M</a></li>
                                  <li data-value="gte5m"><a href="#">Population &gt;= 5M</a></li>
                                </ul>
                              </div>
                            </div> -->

                            <?php echo form_open($this->page_controller.'/listContent/'.$category.'/view/1',array('name'=>'submit-search'));?>
                            <div class="col-sm-4 m-t-xs m-b-xs">
                              <div class="input-group">
                                <?php 
                                  $keyword = $this->input->post('search');
                                  $keyword = (empty($keyword))?"":$keyword;
                                ?>
                                <!-- <input type="text" autocomplete="off" class="input-sm form-control" name="search" id="search" placeholder="Search" value='<?php //echo $keyword;?>'> -->
                                <input type="text" autocomplete="off" class="input-sm form-control" name="search" id="search" placeholder="<?php echo freetext('search'); ?>" value='<?php echo !empty($keyword)?$keyword:""; ?>'>
                                <div class="input-group-btn">
                                  <button class="submit-search btn btn-default btn-sm" ><i class="fa fa-search"></i></button>
                                </div>                          
                              </div>
                            </div>
                            <?=form_close();?>  


                            
                              <div class="col-sm-6 m-t-xs m-b-xs pull-right page-action-panel" >
                              <?php 
                              #CMS 
                              echo form_open($this->page_controller.'/group_delete/'.$this->content_table); 
                              #END_CMS 
                              ?>                  
                              <input type="submit" name="delete" class="pull-right btn-sm btn-dark btn" value="Delete" style="display:none;">                             
                              <a class='pull-right btn-sm btn-dark btn group-delete-button' style="margin-left:2px;">delete</a>
                              <a href="#modal-form" class="" data-toggle="modal"><button class='pull-right btn-sm btn-primary btn'><i class='fa fa-plus-circle'></i>&nbsp;&nbsp;Add new <?php echo $this->page_object;?></button></a>                                                   
                               <?php 
                                  #CMS
                                  // var_dump($extend_dialog);
                                  if(isset($extend_dialog)){
                                    echo $extend_dialog;
                                  } #END CMS
                              ?>
                            </div>


                          </div>
                        </th>
                      </tr>


                    <tr>
                    <?php if(!empty($config['listview']))
                    { 
                      $visible_col_name = array();
                      $th = '';

                      // $th .= '<th data-property="id" class="table-head"></th>';
                      //Display id ? 
                      $show_id = false;
                      foreach ($config['listview'] as $key => $value) {
                        if($value['visible']=='1' && $value['name']=='id'){
                          $show_id = true;
                          break ;
                        }
                      }//end foreach

                      $th .= ($show_id)?'<th data-property="id" class="table-head" style="width:16px"></th>':'<th class="table-head" style="width:16px">&nbsp;</th>';

                      foreach ($config['listview'] as $key => $value) {
                        if(!intval($value['visible']))continue;
                        $th .= '<th data-property="'.$value['name'].'" class="table-head">'.$value['label'].'</th>';
                        array_push($visible_col_name, $value['name']);
                      }//end foreach
                    }
                    if(!empty($th)){
                      $th .= '<th data-property="action" class="table-head">ACTION</th>';
                    }
                    echo $th;
                    ?>
                    </tr>

                    
                    </thead>


                    <tbody>
                      <?php                      
                      if(!empty($result)){
                      $content = $result['list'];
                      foreach ($content as $key => $value) {
                    ?>
                      <tr> 
                        <td><input type="checkbox" name="forms[]" id="forms[]" value="<?php print $value['id']; ?>"></td>

                        <?php //Rendering value 
                        if(!empty($value)){
                          $td = '';
                          foreach ($value as $keyx => $valuex) {
                            if(in_array($keyx, $visible_col_name) && $keyx != 'id' ){
                              $td .= '<td class="table-division"  data-property="'.$keyx.'">'.$valuex.'</td>';
                            }else if($keyx == 'id' && $show_id ){
                              $td .= '<td class="table-division"  data-property="'.$keyx.'">'.$valuex.'</td>';
                            }
                          }//end foreach
                          echo $td;
                        }//end if 


                        ?>

                        <!-- <START : ACTION SET> -->
                        <td style='text-align:right'>
                          <!-- <a> -->
                          <button class="btn btn-default hide" data-toggle="button">
                          <i class="fa fa-check-circle-o text-active"></i>
                          <i class="fa fa-check-circle text text-success"></i>
                          </button>
                          <!-- </a> -->
                          <a class="btn btn-default" href="<?php echo site_url($this->page_controller.'/detail/'.$this->cotnent_category.'/view/'.$value['id']) ?>" data-toggle=""><i class="fa fa-pencil"></i></a>
                          <a class="btn btn-default commit-delete-btn" id="<?php echo $value['id']; ?>" main-table="<?php echo $this->content_table;#CMS ?>" ><i class="fa fa-trash-o"></i></a>

                          <div class="btn-group hide">
                            <button class="btn btn-default  dropdown-toggle" data-toggle="dropdown">Action <span class="caret"></span></button>
                            <ul class="dropdown-menu">
                              <li><a href="#">Action</a></li>
                              <li><a href="#">Another action</a></li>
                              <li><a href="#">Something else here</a></li>
                              <li class="divider"></li>
                              <li><a href="#">Separated link</a></li>
                            </ul>
                          </div>

                        </td>
                        <!-- <END : ACTION SET> -->

                      </tr>
                    <?php 
                       }
                     }
                    ?>



                    </tbody>

                      <?=form_close();?> 
                    <!-- include : tfoot table -->
                    <?php $this->load->view('__backend/include/tfoot_list'); ?>

                  </table>

                </div>
              </section>
            </section>
          </section>
          <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>




         
        <div class="modal fade" id="modal-delete"  is-confirm='0'>          

            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>

                  <h3 class="title">Delete Confirm</h3>
                </div>
                <div class="modal-body" style='overflow:auto'>                  
                  <p class='msg'>Do you confirm to delete this item</p> 
                </div>
                <div class='clear:both'></div>
                <div class="modal-footer">
                  <span class="btn cancel-delete  btn-default" data-dismiss="modal" aria-hidden="true">Cancel</span>
                  <span class="btn confirm-delete btn-primary" data-dismiss="modal" >Confirm</span>
                </div>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->           
        </div><!--end: modal confirm delete -->




           
