 <?php 

// echo '<pre>';
//  print_r($backend_content_menu['navigation']['backend']);
// echo '</pre>';
 
$menu_list = $backend_content_menu['navigation']['backend'];

  ?>
 <!-- .aside -->
        <aside class="bg-dark lter aside-md hidden-print hidden-xs" id="nav">          
          <section class="vbox">
            <section class="w-f scrollable">
              <div class="slim-scroll" data-height="auto" data-disable-fade-out="true" data-distance="0" data-size="5px" data-color="#333333">
                 <!-- nav -->
                <nav class="nav-primary hidden-xs">
                  <ul class="nav">    
                  <?php
                    foreach ($menu_list as $menu) {
                      
                  ?>
                    <li class='menu-group-item'>
                      <a href="javascript:void()">
                        <i class="fa fa-key icon">
                          <b class="bg-danger"></b>
                        </i>
                      <?php
                        if (!empty($menu->pages)) {
                      ?>
                        <span class="pull-right">
                          <i class="fa fa-angle-down text"></i>
                          <i class="fa fa-angle-up text-active"></i>
                        </span>
                      <?php
                        }
                      ?>
                        <span>
                          <?php echo $menu->group_name; ?>
                        </span>
                      </a>

                      <?php
                        if (!empty($menu->pages)) {
                      ?>
                      <ul class="nav lt" style="min-height:0;">
                        <?php
                          foreach ($menu->pages as $page) {
                        ?>
                            <li class="menu-item <?php if ($this->page_id == $page->page_title) { echo 'active'; } ?>">
                              <a href="<?php echo site_url('__backend_content/listContent/'.$page->page_title); ?>">
                                  <i class="fa fa-user icon"></i>
                                <span>
                                  <?php echo $page->page_title; ?>
                                </span>
                              </a>
                            <li>
                        <?php
                          }
                        ?>
                      </ul>
                      <?php
                        }
                      ?>
                    </li>
                  <?php
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
                <button type="button" title="Chats" class="btn btn-icon btn-sm btn-dark" data-toggle="dropdown" data-target="#chat"><i class="fa fa-comment-o"></i></button>
                <button type="button" title="Contacts" class="btn btn-icon btn-sm btn-dark" data-toggle="dropdown" data-target="#invite"><i class="fa fa-facebook"></i></button>
              </div>
            </footer>
          </section>


        </aside>
        <!-- /.aside -->