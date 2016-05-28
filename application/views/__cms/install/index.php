
<!DOCTYPE html>
<html lang="en" class="app">
<head>
  <meta charset="utf-8" />
  <title>CMS - Installation</title>

  <meta name="description" content="app, web app, responsive, admin dashboard, admin, flat, flat ui, ui kit, off screen nav" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" /> 

  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" /> 

  <!-- TODO: Find solution for favicon -->
  <!--link rel="shortcut icon" href="<?php //theme_images().'favicon.ico'?>" type="image/x-icon"-->
  <link rel="icon" href="<?php echo theme_images().'favicon.ico'?>" type="image/x-icon">


  <link rel="stylesheet" href="<?php echo theme_css().'bootstrap.css';?>" type="text/css" />
  <link rel="stylesheet" href="<?php echo theme_css().'animate.css';?>" type="text/css" />
  <link rel="stylesheet" href="<?php echo theme_css().'font-awesome.min.css';?>" type="text/css" />
  <link rel="stylesheet" href="<?php echo theme_css().'font.css';?>" type="text/css" />
  <link rel="stylesheet" href="<?php echo theme_js().'nestable/nestable.css';?>" type="text/css" />
  <link rel="stylesheet" href="<?php echo theme_js().'fuelux/fuelux.css';?>" type="text/css"/>
  <!--
  <link rel="stylesheet" href="<?php //echo theme_js().'calendar/bootstrap_calendar.css';?>" type="text/css" />
  <link rel="stylesheet" href="<?php //echo theme_js().'js/fuelux/fuelux.css'?>" type="text/css"/>
  -->
  
  <link rel="stylesheet" href="<?php echo theme_css().'app.css';?>" type="text/css" />
  <link rel="stylesheet" href="<?php echo css_url().'main.css';?>" type="text/css" />

  <!--[if lt IE 9]>
    <script src="js/ie/html5shiv.js"></script>
    <script src="js/ie/respond.min.js"></script>
    <script src="js/ie/excanvas.js"></script>
  <![endif]-->
</head>

<body class="">
  <section id="content" class="m-t-sm wrapper-md animated fadeInUp">    
    <div class="container">
      <a class="navbar-brand block" href="<?php  ?>">Welcome to Bossup Framework Installation</a>
      <section class="panel panel-default bg-white m-t-sm"> 
        <form id="setup_form" method="post" class="panel-body wrapper-lg">
          <div class="panel panel-default">
            <div class="wizard clearfix" id="form-wizard">
              <ul class="steps">
                <li data-target="#step1" class="active"><span class="badge badge-info">1</span>Step 1</li>
                <li data-target="#step2"><span class="badge">2</span>Step 2</li>
                <li data-target="#step3"><span class="badge">3</span>Step 3</li>
                <li data-target="#step4"><span class="badge">4</span>Step 4</li>
              </ul>
            </div>
            <div class="step-content">
              <form>
                <div class="step-pane active" id="step1">
                  <div class="m-b-sm">
                    <h4>Project configuration</h4>
                    <div class="row">
                      <div class="col-sm-6">
                        <p>Project name</p>
                        <input type="text" autocomplete="off" class="form-control" data-trigger="change" name="project_name" data-required="true" placeholder="project">
                      </div>
                      <div class="col-sm-6">
                        <p>Project abbv</p>
                        <input type="text" autocomplete="off" class="form-control" name="project_abbv" placeholder="project abbv">   
                      </div>
                    </div>
                    <p class="m-t">Project administrator's email</p>
                    <input type="text" autocomplete="off" class="form-control" name="admin_email" data-type="email">
                  </div>
                  <div>
                    <h4>Data configuration</h4>
                    <div class="row">
                      <div class="col-sm-6">
                        <input type="checkbox" name="backend"> Backend <br> 
                        <input type="checkbox" name="frontend"> Frontend <br> 
                        <input type="checkbox" name="mobile_api"> Mobile API <br>
                        <input type="checkbox" name="wysiwyg"> Allow WYSIWYG  editor <br> 
                        <input type="checkbox" name="sample_data"> Sample data <br>
                      </div>
                      <div class="col-sm-6">
                        <input type="checkbox" name="upload" id="upload_chk"> Allow upload<br>
                        <div class="upload_panel m-t-sm m-b-sm m-l-sm row hide">
                          <div class="col-sm-6">Upload path <input type="text" autocomplete="off" class="m-t-sm form-control" style="width:200px; height:25px;" name="upload_path" value="assets/upload" ></div>
                          <div class="col-sm-6">Upload size (M) <input type="text" autocomplete="off" class="m-t-sm form-control" style="width:100px; height:25px;" name="upload_size" value="256" > </div>
                          <span class="col-sm-12 m-t-sm text-muted text-sm">
                            Please remind that you have to change upload file size on php.ini file as well.<br>
                            Keyword: post_max_size and upload_max_filesize
                          </span>
                          <div class="col-sm-12 m-t-sm">Thumbnail folder limit (M) <input type="text" autocomplete="off" class="m-t-sm form-control" style="width:100px; height:25px;" name="folder_upload_size" value="3" > </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div>
                    <div class="row col-sm-12 m-b-sm">
                      <h4>Language</h4>
                      <p class="m-t">Default language</p>
                      <select class="form-control m-b-sm" data-trigger="change" data-required="true" name="default_lang">
                      <?php
                        foreach ($this->language_list as $key => $lang) {
                          if (!empty($lang)) {
                            foreach ($lang as $abbv => $name) {
                      ?>
                            <option value="<?php echo $abbv; ?>"><?php echo $name; ?></option>
                      <?php
                            }
                          }
                        }
                      ?>
                      </select>                          
                      <input type="checkbox" id="multi_lang"> Enable multiple language
                    </div>
                    <div class="row col-sm-12 m-b-md hide" id="accordion" style="max-height:100px; overflow:auto;">
                      <?php
                        foreach ($this->language_list as $key => $lang) {
                          if (!empty($lang)) {
                      ?>  
                      <div class="panel panel-default">
                        <div class="panel-heading" style="cursor:pointer;" data-toggle="collapse" data-parent="#accordion" href="#collapse_<?php echo $key; ?>">
                          <h4 class="panel-title">
                            <a>
                              <?php echo $key; ?>
                            </a>
                          </h4>
                        </div>
                        <div id="collapse_<?php echo $key; ?>" class="panel-collapse collapse">
                          <div class="panel-body">
                      <?php
                            foreach ($lang as $abbv => $name) {
                      ?>
                            <input type="checkbox" name="lang_<?php echo $abbv; ?>"> <?php echo $name; ?> <br>
                      <?php
                            }
                      ?>
                          </div>
                        </div>
                      </div>
                      <?php
                          }
                        }
                      ?>
                    </div>
                  </div>
                </div>
                <div class="step-pane" id="step2">
                  <h4>Database configuration</h4>
                  <p>Hostname</p>
                  <input type="text" autocomplete="off" class="form-control" data-trigger="change" name="db_hostname" data-required="true" placeholder="localhost">
                  <p class="m-t">Username</p>
                  <input type="text" autocomplete="off" class="form-control" data-trigger="change" name="db_username" data-required="true" placeholder="username">
                  <p class="m-t">Password</p>
                  <input type="password" class="form-control" name="db_password" placeholder="password">
                  <p class="m-t">Database name</p>
                  <input type="text" autocomplete="off" class="form-control" data-trigger="change" name="db_name"  data-required="true" placeholder="database name">
                  <p class="m-t">Database prefix</p>
                  <input type="text" autocomplete="off" class="form-control" name="db_tbprefix">                  
                </div>
                <div class="step-pane" id="step3">
                  <h4>Admin configuration</h4>
                  <p>Username</p>
                  <input type="text" autocomplete="off" class="form-control" data-trigger="change" name="admin_username" data-required="true" placeholder="username">
                  <p class="m-t">Password</p>
                  <input type="password" class="form-control" name="admin_password" data-required="true" placeholder="password">
                  <p class="m-t">Email</p>
                  <input type="text" autocomplete="off" class="form-control" data-trigger="change" name="admin_email"  data-required="true" data-type="email" placeholder="email">                  
                  <p class="m-t">Password recovery method</p>
                  <select class="form-control" name="password_recovery_method">
                    <option value="email">Email only</option>
                    <option value="admin">Admin only</option>
                    <option value="both">Both</option>
                  </select>
                  <p class="m-t">Authentication type</p>
                  <select class="form-control" name="authentication_type">
                    <option value="internal">Internal user</option>
                    <option value="external">External user</option>
                    <option value="both">Both</option>
                  </select>  
                  <p class="m-t"><input type="checkbox" name="enable_cookie" > Enable cookie</p>
                  <p class="m-t"><input type="checkbox" name="system_log" > System log (keep system log for 90 days)</p>

                </div>
                <div class="step-pane" id="step4">
                  <h4>Email configuration</h4>
                  <p>Protocol</p>
                  <input type="text" autocomplete="off" class="form-control" data-trigger="change" name="email_protocol" data-required="true" placeholder="smtp">
                  <p>Host</p>
                  <input type="text" autocomplete="off" class="form-control" data-trigger="change" name="email_host" data-required="true">
                  <p>Port</p>
                  <input type="text" autocomplete="off" class="form-control" data-trigger="change" name="email_port" data-required="true" data-type="number">
                  <p>Username</p>
                  <input type="text" autocomplete="off" class="form-control" data-trigger="change" name="email_username" data-required="true" data-type="email">
                  <p>Password</p>
                  <input type="text" autocomplete="off" class="form-control" data-trigger="change" name="email_password" data-required="true">                                   
                </div>                
              </form>
              <div class="actions m-t-lg">
                <button type="button" class="btn btn-default btn-sm btn-prev" data-target="#form-wizard" data-wizard="previous" disabled="disabled">Prev</button>
                <button type="button" class="btn btn-default btn-sm btn-next" data-target="#form-wizard" data-wizard="next" data-last="Finish">Next</button>
              </div>
            </div>
          </div>
        </form>
      </section>
    </div>
  </section>
</body>
  <script src=<?php echo theme_js()."jquery.min.js";?>></script>
  <!-- Bootstrap -->
  <script src=<?php echo theme_js()."bootstrap.js";?>></script>
  <!-- App -->
  <script src=<?php echo theme_js()."app.js";?>></script> 
  <script src=<?php echo theme_js()."slimscroll/jquery.slimscroll.min.js";?>></script>
  <!-- fuelux -->
  <script src=<?php echo theme_js()."fuelux/fuelux.js";?>></script>
  <script src=<?php echo theme_js()."parsley/parsley.min.js";?>></script>
  <script src=<?php echo theme_js()."app.plugin.js";?>></script>

  <script type="text/javascript">
    $('#multi_lang').on('change', function() {
      if ($(this).is(':checked')) {
          $('#accordion').removeClass('hide');
      } else {
          $('#accordion').addClass('hide');
      }
      //$('#accordion').show();
    });

    $('#upload_chk').on('change', function() {
      if ($(this).is(':checked')) {
          $('.upload_panel').removeClass('hide');
      } else {
          $('.upload_panel').addClass('hide');
      }
      //$('#accordion').show();
    });

    $('#form-wizard').on('finished', function(e, data) {

        if ( $('input[name="backend"]').is(':checked') == false ) {
          $('input[name="backend"]').prop('checked', 'checked');
          $('input[name="backend"]').val('off');
        }

        if ( $('input[name="frontend"]').is(':checked') == false ) {
          $('input[name="frontend"]').prop('checked', 'checked');
          $('input[name="frontend"]').val('off');
        }

        if ( $('input[name="mobile_api"]').is(':checked') == false ) {
          $('input[name="mobile_api"]').prop('checked', 'checked');
          $('input[name="mobile_api"]').val('off');
        }

        if ( $('input[name="wysiwyg"]').is(':checked') == false ) {
          $('input[name="wysiwyg"]').prop('checked', 'checked');
          $('input[name="wysiwyg"]').val('off');
        }

        if ( $('input[name="sample_data"]').is(':checked') == false ) {
          $('input[name="sample_data"]').prop('checked', 'checked');
          $('input[name="sample_data"]').val('off');
        }

        if ( $('input[name="enable_cookie"]').is(':checked') == false ) {
          $('input[name="enable_cookie"]').prop('checked', 'checked');
          $('input[name="enable_cookie"]').val('off');
        }

        if ( $('input[name="system_log"]').is(':checked') == false ) {
          $('input[name="system_log"]').prop('checked', 'checked');
          $('input[name="system_log"]').val('off');
        }

        if ( $('input[name="upload"]').is(':checked') == false ) {

          $('input[name="system_log"]').prop('checked', 'checked');
          $('input[name="system_log"]').val('off');

          if ($('input[name="upload_path"]').val() == '') {
            $('input[name="upload_path"]').val('');
          }
          if ($('input[name="upload_size"]').val() == '') {
            $('input[name="upload_size"]').val('');
          }
        } else {
          
          if ($('input[name="upload_path"]').val() == '') {
            $('input[name="upload_path"]').val('assets/upload');
          }
          if ($('input[name="upload_size"]').val() == '') {
            $('input[name="upload_size"]').val('256');
          }
        }

        $('#setup_form').submit();
    });
  </script>
</html>