<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
 -->
<style type="text/css">
  .table-head,.table-division{ text-align: center }
  .panel-heading .btn-sm { margin-top: -6px}
</style>


            <section class="vbox">
            <section class="scrollable padder">
            <div class="div_detail">

              <section class="panel panel-default">
                <div class="table-responsive">                  
                  <table id="MyStretchGrid" class="table table-striped datagrid m-b-sm">
                    <thead>
                      <tr>
                        <th colspan="9">
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
                          
                             <?php 
                              #CMS 
                              echo form_open($this->page_controller.'/listview_complain');
                              $keyword = $this->input->post("search");
                              #END_CMS 

                            ?>
                            <div class="col-sm-5 m-t-xs m-b-xs " >
                              <div class="input-group search datagrid-search">
                                <input type="text" autocomplete="off" class="input-sm form-control" name="search" id="search" placeholder="<?php echo freetext('search'); ?>" value='<?php echo !empty($keyword)?$keyword:""; ?>'>
                                <div class="input-group-btn">
                                  <button class="btn btn-default btn-sm sumbit-search" ><i class="fa fa-search"></i></button>
                                </div>                          
                              </div>
                            </div>
                            <?php 
                              echo form_close();
                            ?> 

                            <!-- <div class="col-sm-4 m-t-xs m-b-xs pull-right" >
                              <?php 
                              #CMS 
                              //echo form_open($this->page_controller.'/group_delete/');                               
                              #END_CMS 
                              ?>       

                              <input type="submit" name="delete" class="pull-right btn-sm btn-dark btn" value="Delete" style="display:none;">                             
                             </div> -->

                          </div>
                        </th>
                      </tr>


                      <tr>
                      <!-- <th></th> -->
                      <th ><?php echo freetext('id'); ?></th>
                      <th ><?php echo freetext('ship_to_id'); ?></th>
                      <th ><?php echo freetext('ship_to_name'); ?></th>
                      <th ><?php echo freetext('raise_by_id'); ?></th>  
                      <th class="tx-center"><?php echo freetext('create_date'); ?></th>
                      <th class="tx-center">Action</th>
                    </tr> 


                    
                    </thead>
                    
                    <tbody>   
<!-- ////////////////////////////////////// -->
                     <?php    
                      $userlogin  = $this->session->userdata('id'); 
                      if(!empty($result)){

                      $content = $result['list'];                  
                      foreach ($content as $key => $value) {                 
                      $raise_by_id = $value['raise_by_id'];
                    ?>
                           <tr>  
                              <!-- <td>
                                <input type="checkbox" name="forms[]" id="forms[]" value="<?php //print $value['id']; ?>">
                                  <span style='padding-left:12px'>
                                      <?php //print $value['plan_id'];?>
                                  </span>
                              </td> -->
                              <td> <?php echo $value['id'];?></td>
                              <td> <?php echo $value['ship_to_id'];?></td>
                              <td> <?php echo $value['ship_to_name1'];?></td>                           
                              <td> <?php echo $value['user_firstname'].' '.$value['user_lastname'];?></td>                                
                              <td class="tx-center"><?php if( $value['create_date'] !='0000-00-00' ){ echo common_easyDateFormat($value['create_date']); }else{ echo "-"; }  //print $value['plan_date'];?></td>
                            
                              <!-- <START : ACTION SET> -->
                                <td class="tx-center">
                                  <a  data-cms-visible="view" href="<?php echo site_url($this->page_controller.'/detail_complain/view_complain/0/'.$value['id']); ?>" class="btn btn-default">
                                      <i class="fa fa-check-square-o h5"></i>
                                  </a>   
                                
                                   <a  
                                   <?php if($userlogin!=$raise_by_id ){ echo "disabled"; }  ?>
                                   <?php if($value['submit_date_papyrus'] !='0000-00-00'){ echo "disabled"; }  ?>
                                    data-cms-visible="view" href="<?php echo site_url($this->page_controller.'/detail_complain/edit_complain/0/'.$value['id']); ?>" class="btn btn-default">
                                    <i class="fa fa-pencil h5"></i>
                                  </a>

                                   <a 
                                   <?php if( $userlogin!=$raise_by_id ){ echo "disabled"; }  ?>
                                   <?php if($value['submit_date_papyrus'] !='0000-00-00'){ echo "disabled"; }  ?>
                                     data-cms-visible="delete" class="btn btn-default commit-delete-btn"  id="<?php echo $value['id']; ?>"  >
                                    <i class="fa fa-trash-o"></i>
                                  </a>        

                                </td>                             
                           <!-- <END : ACTION SET> -->
                          </tr>
                        <?php 
                       }//end frech
                     }//end if
                    
                    //======= No data ===========
                      if(empty($result['list'])){
                        echo "<tr>
                                  <td>ไม่มีข้อมูล</td>
                              </tr>";
                      }
                    //======= No data ===========
                    
                    ?>         
<!-- ////////////////////////////////////////// -->

                    </tbody>

                     <?php 
                      echo form_close();
                     ?> 
                    <!-- include : tfoot table -->
                    <?php $this->load->view('__complain/include/tfoot_list'); ?>

                  </table>
                 
                </div>
              </section>
            </div><!-- end div -->
            </section>
          </section>
          <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
















