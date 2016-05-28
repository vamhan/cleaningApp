<?php //print($page_id); ?>
 <!-- .aside -->
        <aside class="bg-dark lter aside-md hidden-print hidden-xs" id="nav">          
          <section class="vbox">
            <section class="w-f scrollable">
              <div class="slim-scroll" data-height="auto" data-disable-fade-out="true" data-distance="0" data-size="5px" data-color="#333333">
                <!-- nav -->
                <nav class="nav-primary hidden-xs">
                  <ul class="nav">                      
                    <?php if($this->session->userdata('username') == 'admin_psgen'){ ?>
                    <li<?php if ($this->page_id == 'user' || $this->page_id == 'group') { echo " class='active'"; } ?>>

                      <a href="javascript:void()">
                        <i class="fa fa-users icon">
                          <b class="bg-danger"></b>
                        </i>
                        <span class="pull-right">
                          <i class="fa fa-angle-down text"></i>
                          <i class="fa fa-angle-up text-active"></i>
                        </span>
                        <span>
                          User Management
                        </span>
                      </a>

                      <ul class="nav lt" style="min-height:0;">

                        <li<?php if ($this->page_id == 'user') { echo " class='active'"; } ?>>
                          <a href="<?php echo my_url('__cms_permission/user_list'); ?>">
                            <i class="fa fa-user icon"></i>
                            <span>
                                User
                            </span>
                          </a>
                        <li>

                        <!-- <li<?php //if ($this->page_id == 'department_list') { echo " class='active'"; } ?>>
                          <a href="<?php //echo my_url('__cms_permission/department_list'); ?>">
                            <i class="fa fa-building-o icon"></i>
                            <span>
                                Department
                            </span>
                          </a>
                        <li> -->

                        <li<?php if ($this->page_id == 'departmentMapping') { echo " class='active'"; } ?>>
                          <a href="<?php echo my_url('__cms_permission/department_module_list'); ?>">
                            <i class="fa fa-dashboard icon"></i>
                            <span>
                                Department Module
                            </span>
                          </a>
                        <li>
                      </ul>

                    </li> 
                    <?php }//end ?>        
                    <li<?php if ($this->page_id == 'module' || $this->page_id == 'category' || $this->session->userdata('username') == 'admin_gps') { echo " class='active'"; } ?>>

                      <a href="javascript:void()">
                        <i class="fa fa-edit icon">
                          <b class="bg-success"></b>
                        </i>
                        <span class="pull-right">
                          <i class="fa fa-angle-down text"></i>
                          <i class="fa fa-angle-up text-active"></i>
                        </span>
                        <span>
                          Data Management
                        </span>
                      </a>

                      <ul class="nav lt" style="min-height:0;">

                        <li<?php if ($this->page_id == 'gps_login') { echo " class='active'"; } ?>>
                          <a href="<?php echo my_url('__cms_data_manager/gps_log_list'); ?>">
                              <i class="fa fa-location-arrow icon"></i>
                            <span>
                                GPS Login Log
                            </span>
                          </a>
                        </li>

                        <?php if($this->session->userdata('username') == 'admin_psgen'){ ?>
                        <li<?php if ($this->page_id == 'actionplan') { echo " class='active'"; } ?>>
                          <a href="<?php echo my_url('__cms_data_manager/action_plan_management'); ?>">
                              <i class="fa fa-calendar icon"></i>
                            <span>
                                Action Plan
                            </span>
                          </a>
                        </li>

                        <li<?php if ($this->page_id == 'holiday') { echo " class='active'"; } ?>>
                          <a href="<?php echo my_url('__cms_data_manager/holiday_management'); ?>">
                              <i class="fa fa-bell icon"></i>
                            <span>
                                Holiday
                            </span>
                          </a>
                        </li>

                        

                        <li<?php if ($this->page_id == 'employee_question') { echo " class='active'"; } ?>>
                          <a href="<?php echo my_url('__cms_data_manager/employee_question_management'); ?>">
                              <i class="fa fa-users icon"></i>
                            <span>
                                Employee Question
                            </span>
                          </a>
                        </li>

                        <li<?php if ($this->page_id == 'quality_question') { echo " class='active'"; } ?>>
                          <a href="<?php echo my_url('__cms_data_manager/quality_question_management'); ?>">
                              <i class="fa fa-question icon"></i>
                            <span>
                                QA Question
                            </span>
                          </a>
                        </li>

                        <li<?php if ($this->page_id == 'quotation_summary') { echo " class='active'"; } ?>>
                          <a href="<?php echo my_url('__cms_data_manager/quotation_summary_management'); ?>">
                              <i class="fa fa-file-text icon"></i>
                            <span>
                                Quotation Summary
                            </span>
                          </a>
                        </li>

                         <li<?php if ($this->page_id == 'quotation_staff') { echo " class='active'"; } ?>>
                          <a href="<?php echo my_url('__cms_data_manager/quatationStaff_management'); ?>">
                              <i class="fa fa-file-text icon"></i>
                            <span>
                                Quotation Staff
                            </span>
                          </a>
                        </li>

                        <li<?php if ($this->page_id == 'other_service') { echo " class='active'"; } ?>>
                          <a href="<?php echo my_url('__cms_data_manager/doc_otherservice_management'); ?>">
                              <i class="fa fa-bell icon"></i>
                            <span>
                                Doc Other Service
                            </span>
                          </a>
                        </li>

                        <li<?php if ($this->page_id == 'other_service') { echo " class='active'"; } ?>>
                          <a href="<?php echo my_url('__cms_data_manager/contract_project_management'); ?>">
                              <i class="fa fa-folder icon"></i>
                            <span>
                                Project Management 
                            </span>
                          </a>
                        </li>
                        <?php }//end admin psgen ?>

                       <!--  <li<?php //f ($this->page_id == 'plant_manage') { echo " class='active'"; } ?>>
                          <a href="<?php //echo my_url('__cms_data_manager/plant_management'); ?>">
                              <i class="fa fa-code-fork icon"></i>
                            <span>
                                Plant Management
                            </span>
                          </a>
                        </li> -->
                        
                      </ul>

                    </li>

                  </ul>
                </nav>
                <!-- / nav -->
              </div>
            </section>
            
            <footer class="footer lt hidden-xs b-t b-dark">
             
              <!-- <div id="chat" class="dropup">
                <section class="dropdown-menu on aside-md m-l-n">
                  <section class="panel bg-white">
                    <header class="panel-heading b-b b-light">Active chats</header>
                    <div class="panel-body animated fadeInRight">
                      <p class="text-sm">No active chats.</p>
                      <p><a href="#" class="btn btn-sm btn-default">Start a chat</a></p>
                    </div>
                  </section>
                </section>
              </div>
              <div id="invite" class="dropup">                
                <section class="dropdown-menu on aside-md m-l-n">
                  <section class="panel bg-white">
                    <header class="panel-heading b-b b-light">
                      John <i class="fa fa-circle text-success"></i>
                    </header>
                    <div class="panel-body animated fadeInRight">
                      <p class="text-sm">No contacts in your lists.</p>
                      <p><a href="#" class="btn btn-sm btn-facebook"><i class="fa fa-fw fa-facebook"></i> Invite from Facebook</a></p>
                    </div>
                  </section>
                </section>
              </div> -->

              <a href="#nav" data-toggle="class:nav-xs" class="pull-right btn btn-sm btn-dark btn-icon">
                <i class="fa fa-angle-left text"></i>
                <i class="fa fa-angle-right text-active"></i>
              </a>
             <!--  <div class="btn-group hidden-nav-xs">
                <button type="button" title="Chats" class="btn btn-icon btn-sm btn-dark" data-toggle="dropdown" data-target="#chat"><i class="fa fa-comment-o"></i></button>
                <button type="button" title="Contacts" class="btn btn-icon btn-sm btn-dark" data-toggle="dropdown" data-target="#invite"><i class="fa fa-facebook"></i></button>
              </div> -->
            </footer>
          </section>


        </aside>
        <!-- /.aside -->