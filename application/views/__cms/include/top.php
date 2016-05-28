    <header class="bg-dark dk header navbar navbar-fixed-top-xs">
      <!-- start : top-nav header -->
      <div class="navbar-header aside-md" style="height:45px;">
        <a class="btn btn-link visible-xs" data-toggle="class:nav-off-screen,open" data-target="#nav,html">
          <i class="fa fa-bars"></i>
        </a>
        <a href="<?php if($super_admin){ echo site_url('__ps_projects/listview'); }else{  echo ""; }  ?>" class=""><img style="max-height:60px;" src="<?php echo site_url('assets/images/psgen_icon.png');  ?>"></a>
        <a class="btn btn-link visible-xs" data-toggle="dropdown" data-target=".nav-user">
          <i class="fa fa-cog"></i>
        </a>
      </div>


      <ul class="nav navbar-nav navbar-right m-n hidden-xs nav-user">
       
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <span class="thumb-sm avatar pull-left">
             <img src="<?php echo theme_images().'avatar_default_female.jpg'?>" alt="John said" class="img-circle"> 
            </span>
            <?php echo $this->session->userdata('username'); ?> <b class="caret"></b>
          </a>
          <ul class="dropdown-menu animated fadeInRight">
            <span class="arrow top"></span>
            <li>
              <a href="<?php echo my_url('__cms_permission/logout'); ?>" >Logout</a>
            </li>
          </ul>
        </li>
      </ul>
      <!-- end : top-nav header -->

    </header>