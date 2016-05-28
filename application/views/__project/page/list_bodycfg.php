<style type="text/css">
  .table-head,.table-division{ text-align: center }
  .panel-heading .btn-sm { margin-top: -6px}
</style>



 <section class="vbox">
            <section class="scrollable padder">
            
              <section class="panel panel-default">
                <header class="panel-heading">
                  <?php 
                    #CMS 
                    echo $this->page_title_ico;
                    print($this->page_title);
                    #END_CMS 
                  ?>
                   </header>
                <div class="table-responsive">                  
                  <table id="MyStretchGrid" class="table table-striped datagrid m-b-sm">
                    <thead>
                      <tr>
                        <th colspan="8">
                          <div class="row">

                           
                          
                            <?php 
                              #CMS 
                              echo form_open($this->page_controller.'/listview');
                              $keyword = $this->input->post("search");
                              #END_CMS 

                            ?>
                            <div class="col-sm-12 m-t-xs m-b-xs " >
                              <!-- start : search-options -->
                              <div class="input-group col-sm-10 search datagrid-search pull-left">
                                <input type="text" autocomplete="off" class="input-sm form-control" name="search" id="search" placeholder="<?php echo freetext('search'); ?>" value='<?php echo !empty($keyword)?$keyword:""; ?>'>
                                <div class="input-group-btn">
                                  <button class="btn btn-default btn-sm sumbit-search" ><i class="fa fa-search"></i></button>
                                </div>                       
                              </div>
                              <!-- end  : search-options -->

                              <!-- start : year-options -->
                              <div class="col-sm-2 pull-left">
                              <select class="input-sm form-control">
                                  <?php 
                                    $init_year = 2009;
                                    $current_year = intval(date('Y',time()));
                                    while($current_year > $init_year){
                                      ?>
                                      <option value='<?php echo $current_year; ?>'><?php echo $current_year--; ?></option>
                                      <?php
                                    }
                                  ?>
                                  <option value='any'>any</option>
                              </select>
                              </div>
                              <!-- end : year-options -->


                            </div>
                            <?php 
                              echo form_close();
                            ?> 

                            <div class="col-sm-4 m-t-xs m-b-xs pull-right" >
                              <?php 
                              #CMS 
                              echo form_open($this->page_controller.'/group_delete/'); 
                              #END_CMS 
                              ?>                  
                              <!-- <input type="submit" name="delete" class="pull-right btn-sm btn-dark btn" value="Delete" style="display:none;">                              -->
                              <!-- <a class='pull-right btn-sm btn-dark btn group-delete-button' style="margin-left:2px;"><?php //echo freetext('delete'); ?></a>
                              <a href="#modal-form" class="pull-right" data-toggle="modal"><button class='btn-sm btn-primary btn'><i class='fa fa-plus-circle'></i>&nbsp;&nbsp;<?php echo freetext('create_new_page'); ?></button></a>                                -->
                            </div>

                          </div>
                        </th>
                      </tr>


                    <tr>
                      <th class='table-head'>ID</th>
                      <th class='table-head'>Project</th>
                      <th class='table-head'>Customer</th>
                      <th class='table-head'>Ship To</th>
                      <th class='table-head'>Start Project</th>
                      <th class='table-head'>End Project</th>
                      <th class='table-head'>Type</th>
                      <!-- <th class='table-head'>Project owner</th> -->
                      <th class='table-head'>Actions</th>
                    </tr>
                    
                    </thead>
                    
                    <tbody>
                      <?php                      
                      if(!empty($result)){
                      $content = $result['list'];                  
                      foreach ($content as $key => $value) {
                    ?>
                      <tr>
                        <td>
                          <input type="checkbox" class='hide' name="forms[]" id="forms[]" value="<?php print $value['id']; ?>">
                            <span style='padding-left:12px'>
                                <?php print $value['id'];?>
                            </span>
                        </td>
                        
                       <td>
                         <?php print $value['title'];?>
                       </td>

                       <td>
                         <?php print $value['customer_name'];?>
                       </td>

                       <td>
                         <?php print $value['shop_to_title'];?>
                       </td>

                       <td>
                         <?php print $value['project_start'];?>
                       </td>

                       <td>
                         <?php print $value['project_end'];?>
                       </td>

                       <td>
                         <?php print $value['job_type_title'];?>
                       </td>

                       <!-- <td>
                         <?php //print $value['project_owner'];?>
                       </td> -->

                        <!-- <START : ACTION SET> -->
                        <td style='text-align:right'>
                          <a class="btn btn-default" target='_blank' href="<?php echo site_url('__ps_project/detail/'.$value['id']) ?>" data-toggle=""><i class="fa fa-eye"></i></a>
                        </td>
                        <!-- <END : ACTION SET> -->

                      </tr>
                    <?php 
                       }
                     }
                    ?>

                    </tbody>

                     <?php 
                      echo form_close();
                     ?> 
                    <!-- include : tfoot table -->
                    <?php $this->load->view('__project/include/tfoot_list'); ?>

                  </table>
                 
                </div>
              </section>
            </section>
          </section>
          <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>





        <!--Start: modal confirm delete -->
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


