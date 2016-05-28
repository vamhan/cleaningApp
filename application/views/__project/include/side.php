 <!-- .aside -->
        <aside class="bg-dark lter aside-md hidden-print hidden-xs nav-xs" id="nav">          
          <section class="vbox">
            <section class="w-f scrollable">
              <div class="slim-scroll" data-height="auto" data-disable-fade-out="true" data-distance="0" data-size="5px" data-color="#333333">
                <!-- nav -->
                <nav class="nav-primary hidden-xs">
                  <ul class="nav">   
                  <?php

                    //Load side menu
                    $menu_list = array();
                    $module_list = $this->module_model->getModuleList();
                    $permission  = $this->permission;

                    if (!empty($module_list)) {
                      foreach ($module_list as $key => $module) {

                        if ($module['is_main_menu'] == 0 && !empty($module['url']) && array_key_exists($module['id'], $permission) && array_key_exists('view', $permission[$module['id']])) {
                          $menu_list[$module['id']] = $module;
                        }
                      }
                    }

                    if (!empty($menu_list)) {
                      foreach ($menu_list as $key => $module) {                        

                        $controller = '';
                        if (!empty($module['url'])) {
                          $url_parts = explode('/', $module['url']);
                          if (!empty($url_parts)) {
                            $controller = $url_parts[0];
                          }
                        }
                  ?>                  
                        <li <?php echo ($this->page_controller==$controller)?"class='active'":""; ?>>
                          <a href="<?php echo site_url($module['url']).'/'.$pid; ?>" target='_self'  >
                            <i class="fa <?php echo $module['icon']; ?> icon">
                              <b class="<?php echo $module['color']; ?>"></b>
                            </i>
                            <span><?php echo freetext($module['module_name']); ?></span>
                          </a>
                        </li>
                  <?php
                      }
                    }
                  ?>
                  </ul>
                </nav>
                <!-- / nav -->
              </div>
            </section>
            
            <footer class="footer lt hidden-xs b-t b-dark">
              <div id="chat" class="dropup">
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
              </div>
              <a href="#nav" data-toggle="class:nav-xs" class="pull-right btn btn-sm btn-dark btn-icon">
                <i class="fa fa-angle-left text"></i>
                <i class="fa fa-angle-right text-active"></i>
              </a>
              <div class="btn-group hidden-nav-xs">
                <!-- <button type="button" title="Chats" class="btn btn-icon btn-sm btn-dark" data-toggle="dropdown" data-target="#chat"><i class="fa fa-comment-o"></i></button>
                <button type="button" title="Contacts" class="btn btn-icon btn-sm btn-dark" data-toggle="dropdown" data-target="#invite"><i class="fa fa-facebook"></i></button> -->
              </div>
            </footer>
          </section>


        </aside>
        <!-- /.aside -->