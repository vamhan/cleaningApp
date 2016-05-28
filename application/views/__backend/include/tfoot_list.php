<tfoot>
                       <?php 
                       // echo '<pre>';
                       // var_dump($result);
                       // echo '</pre><hr/>';
                              $page = $result['page']; 
                              $total_page = $result['total_page'];
                              $disabled='';
                              $items= empty($result['total_item'])?0:$result['total_item']; 
                              $pageSize=$this->pageSize;//$result['page_size'];
                              //echo .$count = $result->num_rows();
                      ?>  
                      <input class="input-totalPage" type="hidden" value="<?php echo  $total_page; ?>"/>
                      <tr>
                        <th class="row" colspan="7">
                          <div class="datagrid-footer-left col-sm-6 text-center-xs m-l-n" style="visibility: visible;">
                            <div class="grid-controls pull-left" style="">
                              <div class="pull-left" style="padding:4px 4px 0px 0px">
                                <span class="grid-start"><?php if($page==1){echo "1";}else{ $start_page =$page-1; echo ($pageSize*$start_page)+1;}?></span> -
                                <span class="grid-end"><?php $end_page = $pageSize*$page; if($end_page>$items){ echo $items; }else{echo $end_page;}?><input class="pg_size" type="hidden" value="<?php echo $pageSize;?>"></span> of
                                <span class="grid-count"><?php echo $items; ?> items</span>
                              </div>
                              <div class="dropup" data-resize="auto" style="float: left;">
                                <button data-toggle="dropdown" class="btn btn-sm btn-default dropdown-toggle">
                                  <span class="dropdown-label" style="width: 1280px;"><?php echo $pageSize;?></span>
                                  <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                  <li data-value="10"><a href="<?php echo site_url($this->page_controller."/changePageSize/10"); ?>" >10</a></li>
                                  <li data-value="20"><a href="<?php echo site_url($this->page_controller."/changePageSize/20"); ?>">20</a></li>
                                  <li data-value="50"><a href="<?php echo site_url($this->page_controller."/changePageSize/50"); ?>">50</a></li>
                                  <li data-value="100"><a href="<?php echo site_url($this->page_controller."/changePageSize/100"); ?>">100</a></li>
                                </ul>
                              </div>
                              <div class="pull-left" style="padding: 4px 0px 0px 4px;">Per Page</div>
                            </div>
                          </div>
                          <div class="datagrid-footer-right col-sm-4 text-right text-center-xs pull-right" style="visibility: visible;">
                            <div class="grid-pager m-r-n">
                               <?php 
                               if($page > 1) {                               
                                $back_page=intval($page)-1;  
                                 $disabled="";                              
                               }else{ $back_page="#";$disabled="disabled"; } 
                              ?> 
                              <a href="<?php echo site_url($this->page_controller."/listContent/".$this->page_id."/view/".$back_page  ); ?>"><button type="button" <?php echo $disabled; ?> class="btn btn-sm btn-default grid-prevpage pull-left" ><i class="fa fa-chevron-left"></i></button></a>
                              <span class="pull-left" style="padding:4px 0px 0px 12px">Page</span>
                              <div class="inline pull-left col-sm-5">
                                <div class="input-group dropdown ">
                                  <input class="input-sm form-control input-page col-sm-4" type="text" autocomplete="off" value="<?php echo $page ;?>">
                                  <div class="input-group-btn dropup">
                                    <button class="btn btn-sm btn-default" data-toggle="dropdown"><i class="caret"></i></button>
                                    <ul class="dropdown-menu pull-right">
                                    <?php for ($i = 1; $i <= $total_page; $i++) { ?>                                        
                                             <li><a href="<?php echo site_url($this->page_controller."/listContent/".$this->page_id."/view/".$i);?>"><?php echo $i;?></a></li>
                                    <?php } ?> 
                                    </ul>
                                  </div>
                                </div>
                              </div>
                              <span class="pull-left" style="padding:4px 12px 0px 0px">of <span class="grid-pages"><?php echo $total_page; ?></span></span>
                              <?php 
                               if($page < $total_page) {
                                $next_page=intval($result['page'])+1;
                                 $disabled="";
                               }else{ $next_page="#"; $disabled="disabled";} 
                             ?> 
                              <a href="<?php echo site_url($this->page_controller."/listContent/".$this->page_id."/view/".$next_page ); ?>"><button type="button"  <?php echo $disabled; ?> class="btn btn-sm btn-default grid-nextpage pull-left"><i class="fa fa-chevron-right"></i></button></a>
                            </div>
                          </div>
                        </th>
                      </tr>
                    </tfoot>