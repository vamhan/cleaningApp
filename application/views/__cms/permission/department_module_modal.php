<div class="module_create modal fade xxl" id="create_module">
  <div class="modal-dialog" style="width:50%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title h4"><?php echo freetext('create_module'); ?></h4>
      </div>
      <div class="modal-body">
        <form class="form_create_module" method="post" action="<?php echo base_url().'index.php/__cms_data_manager/module_create' ?>" data-validate="parsley">
          <div class="m-t-sm">         
            <div class="row m-b-sm m-l-sm m-r-sm">
              <div class="col-sm-6 font-bold"><?php echo freetext('module_name'); ?></div>
              <div class="col-sm-6"><input type="text" autocomplete="off" name="name" class="form-control" value="" data-required="true"></div>
            </div>   
            <div class="row m-b-sm m-l-sm m-r-sm">
              <div class="col-sm-6 font-bold"><?php echo freetext('description'); ?></div>
              <div class="col-sm-6">
                <textarea class="form-control" name="description"></textarea>
              </div>
            </div>         
            <div class="row m-b-sm m-l-sm m-r-sm">
              <div class="col-sm-6 font-bold"><?php echo freetext('table_name'); ?></div>
              <div class="col-sm-6"><input type="text" autocomplete="off" name="table" class="form-control" value=""></div>
            </div>   
            <div class="row m-b-sm m-l-sm m-r-sm">
              <div class="col-sm-6 font-bold"><?php echo freetext('url'); ?></div>
              <div class="col-sm-6"><input type="text" autocomplete="off" name="url" class="form-control" value=""></div>
            </div>    
            <div class="row m-b-sm m-l-sm m-r-sm">
              <div class="col-sm-6 font-bold"><?php echo freetext('bg-color'); ?></div>
              <div class="col-sm-6">
                <input type="hidden" name="color" value="">
                <div class="input-group-btn"> 
                  <button type="button" style="width:100px" class="form-control btn btn-default dropdown-toggle" data-toggle="dropdown">
                    <span class="caret pull-right"></span>
                  </button> 
                  <ul class="dropdown-menu color_picker" style="padding:0"> 
                    <li style="cursor:pointer;" data-color="">&nbsp;</li> 
                    <li style="cursor:pointer;" class="bg-info dker" data-color="bg-info dker">&nbsp;</li> 
                    <li style="cursor:pointer;" class="bg-info" data-color="bg-info">&nbsp;</li> 
                    <li style="cursor:pointer;" class="bg-info lter" data-color="bg-info lter">&nbsp;</li> 
                    <li style="cursor:pointer;" class="bg-warning dker" data-color="bg-warning dker">&nbsp;</li> 
                    <li style="cursor:pointer;" class="bg-warning" data-color="bg-warning">&nbsp;</li> 
                    <li style="cursor:pointer;" class="bg-warning lter" data-color="bg-warning lter">&nbsp;</li> 
                    <li style="cursor:pointer;" class="bg-success" data-color="bg-success">&nbsp;</li> 
                    <li style="cursor:pointer;" class="bg-danger dker" data-color="bg-danger dker">&nbsp;</li> 
                    <li style="cursor:pointer;" class="bg-danger" data-color="bg-danger">&nbsp;</li> 
                    <li style="cursor:pointer;" class="bg-danger lter" data-color="bg-danger lter">&nbsp;</li> 
                  </ul> 
                </div>
              </div>
            </div>
            <div class="row m-b-sm m-l-sm m-r-sm">
              <div class="col-sm-6 font-bold"><?php echo freetext('icon'); ?></div>
              <div class="col-sm-6">
                <input type="hidden" name="icon" value="">
                <div class="input-group-btn"> 
                  <button type="button" style="width:100px" class="form-control btn btn-default dropdown-toggle" data-toggle="dropdown">
                    <span class="caret pull-right"></span>
                    <span><i class="fa icon"></i></span>
                  </button> 
                  <div class="icon_picker dropdown-menu row" style="width:300px;height: 250px;overflow-y: auto;">
                    <div class="col-sm-2" style="cursor:pointer;">&nbsp;</div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-adjust"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-anchor"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-archive"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-arrows"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-arrows-h"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-arrows-v"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-asterisk"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-ban"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-bar-chart-o"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-barcode"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-bars"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-beer"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-bell"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-bell-o"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-bolt"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-book"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-bookmark"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-bookmark-o"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-briefcase"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-bug"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-building-o"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-bullhorn"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-bullseye"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-calendar"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-calendar-o"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-camera"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-camera-retro"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-caret-square-o-down"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-caret-square-o-left"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-caret-square-o-right"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-caret-square-o-up"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-certificate"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-check"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-check-circle"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-check-circle-o"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-check-square"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-check-square-o"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-circle"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-circle-o"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-clock-o"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-cloud"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-cloud-download"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-cloud-upload"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-code"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-code-fork"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-coffee"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-cog"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-cogs"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-comment"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-comment-o"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-comments"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-comments-o"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-compass"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-credit-card"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-crop"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-crosshairs"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-cutlery"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-dashboard"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-desktop"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-dot-circle-o"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-download"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-edit"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-ellipsis-h"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-ellipsis-v"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-envelope"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-envelope-o"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-eraser"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-exchange"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-exclamation"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-exclamation-circle"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-exclamation-triangle"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-external-link"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-external-link-square"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-eye"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-eye-slash"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-female"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-fighter-jet"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-film"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-filter"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-fire"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-fire-extinguisher"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-flag"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-flag-checkered"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-flag-o"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-flash"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-flask"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-folder"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-folder-o"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-folder-open"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-folder-open-o"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-frown-o"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-gamepad"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-gavel"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-gear"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-gears"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-gift"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-glass"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-globe"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-group"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-hdd-o"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-headphones"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-heart"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-heart-o"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-home"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-inbox"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-info"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-info-circle"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-key"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-keyboard-o"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-laptop"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-leaf"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-legal"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-lemon-o"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-level-down"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-level-up"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-lightbulb-o"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-location-arrow"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-lock"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-magic"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-magnet"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-mail-forward"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-mail-reply"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-mail-reply-all"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-male"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-map-marker"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-meh-o"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-microphone"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-microphone-slash"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-minus"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-minus-circle"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-minus-square"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-minus-square-o"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-mobile"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-mobile-phone"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-money"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-moon-o"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-music"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-pencil"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-pencil-square"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-pencil-square-o"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-phone"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-phone-square"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-picture-o"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-plane"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-plus"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-plus-circle"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-plus-square"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-plus-square-o"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-power-off"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-print"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-puzzle-piece"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-qrcode"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-question"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-question-circle"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-quote-left"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-quote-right"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-random"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-refresh"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-reply"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-reply-all"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-retweet"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-road"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-rocket"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-rss"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-rss-square"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-search"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-search-minus"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-search-plus"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-share"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-share-square"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-share-square-o"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-shield"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-shopping-cart"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-sign-in"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-sign-out"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-signal"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-sitemap"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-smile-o"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-sort"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-sort-alpha-asc"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-sort-alpha-desc"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-sort-amount-asc"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-sort-amount-desc"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-sort-asc"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-sort-desc"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-sort-down"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-sort-numeric-asc"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-sort-numeric-desc"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-sort-up"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-spinner"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-square"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-square-o"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-star"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-star-half"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-star-half-empty"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-star-half-full"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-star-half-o"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-star-o"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-subscript"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-suitcase"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-sun-o"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-superscript"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-tablet"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-tachometer"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-tag"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-tags"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-tasks"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-terminal"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-thumb-tack"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-thumbs-down"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-thumbs-o-down"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-thumbs-o-up"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-thumbs-up"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-ticket"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-times"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-times-circle"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-times-circle-o"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-tint"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-toggle-down"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-toggle-left"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-toggle-right"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-toggle-up"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-trash-o"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-trophy"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-truck"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-umbrella"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-unlock"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-unlock-alt"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-unsorted"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-upload"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-user"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-users"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-video-camera"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-volume-down"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-volume-off"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-volume-up"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-warning"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-wheelchair"></i></div>
                    <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-wrench"></i></div>
                  </div>
                </div>
              </div>
            </div>     
            <div class="row m-b-sm m-l-sm m-r-sm">
              <div class="col-sm-6 font-bold"><?php echo freetext('sequence_index'); ?></div>
              <div class="col-sm-6"><input type="text" autocomplete="off" name="sequence_index" data-type="number" class="form-control" value=""></div>
            </div> 
            <div class="row m-b-sm m-l-sm m-r-sm">
              <div class="col-sm-6">
                <input type="checkbox" name="is_active" value="1" checked>&nbsp;<?php echo freetext('is_active'); ?>
              </div>
              <div class="col-sm-6">
                <input type="checkbox" name="is_action_plan" value="1">&nbsp;<?php echo freetext('able_to_create_action_plan'); ?>
              </div>
              <div class="col-sm-6">
                <input type="checkbox" name="is_menu" value="1">&nbsp;<?php echo freetext('is_menu'); ?>
              </div>              
              <div class="col-sm-6">
                <input type="checkbox" name="is_main_menu" value="1" disabled>&nbsp;<?php echo freetext('is_main_menu'); ?>
              </div>
            </div> 
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <span type="button" class="btn btn-primary create_module_btn" data-parent="#create_module"><i class="fa fa-plus"></i> <?php echo freetext('create'); ?></span>
        <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo freetext('cancel'); ?></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php
    $user_login =  $this->session->userdata('username'); 
    $readonly = '';
    $disabled = '';
    if($user_login=='admin_psgen'){
        $readonly = 'readonly';
        $disabled = 'hide';
    }else{
         $readonly = '';
         $disabled = '';
    }
    if (!empty($module_list)) {
        foreach ($module_list as $key => $module) {
?>
    <div class="module_edit modal fade xxl" id="edit_module_<?php echo $module['id']; ?>">
      <div class="modal-dialog" style="width:50%;">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title h4"><?php echo freetext('edit_module');?></h4>
          </div>
          <div class="modal-body">
            <form class="form_create_module" method="post" action="<?php echo base_url().'index.php/__cms_data_manager/module_edit' ?>" data-validate="parsley">
              <input type="hidden" name="id" value="<?php echo $module['id']; ?>" >
              <div class="m-t-sm">         
                <div class="row m-b-sm m-l-sm m-r-sm">
                  <div class="col-sm-6 font-bold"><?php echo freetext('module_name'); ?></div>
                  <div class="col-sm-6"><input type="text" autocomplete="off" name="name" class="form-control" value="<?php echo $module['module_name']; ?>" data-required="true" <?php echo $readonly; ?> ></div>
                </div>   
                <div class="row m-b-sm m-l-sm m-r-sm">
                  <div class="col-sm-6 font-bold"><?php echo freetext('description'); ?></div>
                  <div class="col-sm-6">
                    <textarea class="form-control" name="description" <?php echo $readonly; ?>><?php echo $module['description']; ?></textarea>
                  </div>
                </div>         
                <div class="row m-b-sm m-l-sm m-r-sm">
                  <div class="col-sm-6 font-bold"><?php echo freetext('table_name'); ?></div>
                  <div class="col-sm-6"><input type="text" autocomplete="off" name="table" class="form-control" value="<?php echo $module['table']; ?>" <?php echo $readonly; ?>></div>
                </div>   
                <div class="row m-b-sm m-l-sm m-r-sm">
                  <div class="col-sm-6 font-bold"><?php echo freetext('url'); ?></div>
                  <div class="col-sm-6"><input type="text" autocomplete="off" name="url" class="form-control" value="<?php echo $module['url']; ?>" <?php echo $readonly; ?> ></div>
                </div>    
                <div class="row m-b-sm m-l-sm m-r-sm">
                  <div class="col-sm-6 font-bold"><?php echo freetext('bg-color'); ?></div>
                  <div class="col-sm-6">
                    <input type="hidden" name="color" value="<?php echo $module['color']; ?>">
                    <div class="input-group-btn"> 
                      <button type="button" style="width:100px" class="form-control btn btn-default dropdown-toggle <?php echo $module['color']; ?>" data-toggle="dropdown">
                        <span class="caret pull-right"></span>
                      </button> 
                      <ul class="dropdown-menu color_picker" style="padding:0"> 
                        <li style="cursor:pointer;" data-color="">&nbsp;</li> 
                        <li style="cursor:pointer;" class="bg-info dker" data-color="bg-info dker">&nbsp;</li> 
                        <li style="cursor:pointer;" class="bg-info" data-color="bg-info">&nbsp;</li> 
                        <li style="cursor:pointer;" class="bg-info lter" data-color="bg-info lter">&nbsp;</li> 
                        <li style="cursor:pointer;" class="bg-warning dker" data-color="bg-warning dker">&nbsp;</li> 
                        <li style="cursor:pointer;" class="bg-warning" data-color="bg-warning">&nbsp;</li> 
                        <li style="cursor:pointer;" class="bg-warning lter" data-color="bg-warning lter">&nbsp;</li> 
                        <li style="cursor:pointer;" class="bg-success" data-color="bg-success">&nbsp;</li> 
                        <li style="cursor:pointer;" class="bg-danger dker" data-color="bg-danger dker">&nbsp;</li> 
                        <li style="cursor:pointer;" class="bg-danger" data-color="bg-danger">&nbsp;</li> 
                        <li style="cursor:pointer;" class="bg-danger lter" data-color="bg-danger lter">&nbsp;</li> 
                      </ul> 
                    </div>
                  </div>
                </div>
                <div class="row m-b-sm m-l-sm m-r-sm">
                  <div class="col-sm-6 font-bold"><?php echo freetext('icon'); ?></div>
                  <div class="col-sm-6">
                    <input type="hidden" name="icon" value="<?php echo $module['icon']; ?>">
                    <div class="input-group-btn"> 
                      <button type="button" style="width:100px" class="form-control btn btn-default dropdown-toggle" data-toggle="dropdown">
                        <span class="caret pull-right"></span>
                        <span><i class="fa <?php echo $module['icon']; ?> icon"></i></span>
                      </button> 
                      <div class="icon_picker dropdown-menu row" style="width:300px;height: 250px;overflow-y: auto;">
                        <div class="col-sm-2" style="cursor:pointer;">&nbsp;</div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-adjust"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-anchor"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-archive"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-arrows"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-arrows-h"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-arrows-v"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-asterisk"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-ban"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-bar-chart-o"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-barcode"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-bars"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-beer"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-bell"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-bell-o"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-bolt"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-book"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-bookmark"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-bookmark-o"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-briefcase"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-bug"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-building-o"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-bullhorn"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-bullseye"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-calendar"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-calendar-o"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-camera"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-camera-retro"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-caret-square-o-down"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-caret-square-o-left"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-caret-square-o-right"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-caret-square-o-up"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-certificate"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-check"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-check-circle"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-check-circle-o"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-check-square"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-check-square-o"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-circle"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-circle-o"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-clock-o"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-cloud"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-cloud-download"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-cloud-upload"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-code"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-code-fork"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-coffee"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-cog"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-cogs"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-comment"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-comment-o"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-comments"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-comments-o"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-compass"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-credit-card"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-crop"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-crosshairs"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-cutlery"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-dashboard"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-desktop"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-dot-circle-o"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-download"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-edit"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-ellipsis-h"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-ellipsis-v"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-envelope"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-envelope-o"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-eraser"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-exchange"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-exclamation"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-exclamation-circle"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-exclamation-triangle"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-external-link"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-external-link-square"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-eye"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-eye-slash"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-female"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-fighter-jet"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-film"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-filter"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-fire"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-fire-extinguisher"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-flag"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-flag-checkered"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-flag-o"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-flash"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-flask"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-folder"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-folder-o"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-folder-open"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-folder-open-o"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-frown-o"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-gamepad"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-gavel"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-gear"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-gears"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-gift"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-glass"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-globe"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-group"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-hdd-o"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-headphones"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-heart"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-heart-o"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-home"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-inbox"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-info"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-info-circle"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-key"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-keyboard-o"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-laptop"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-leaf"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-legal"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-lemon-o"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-level-down"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-level-up"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-lightbulb-o"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-location-arrow"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-lock"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-magic"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-magnet"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-mail-forward"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-mail-reply"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-mail-reply-all"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-male"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-map-marker"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-meh-o"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-microphone"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-microphone-slash"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-minus"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-minus-circle"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-minus-square"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-minus-square-o"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-mobile"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-mobile-phone"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-money"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-moon-o"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-music"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-pencil"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-pencil-square"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-pencil-square-o"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-phone"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-phone-square"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-picture-o"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-plane"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-plus"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-plus-circle"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-plus-square"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-plus-square-o"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-power-off"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-print"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-puzzle-piece"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-qrcode"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-question"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-question-circle"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-quote-left"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-quote-right"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-random"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-refresh"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-reply"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-reply-all"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-retweet"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-road"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-rocket"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-rss"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-rss-square"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-search"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-search-minus"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-search-plus"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-share"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-share-square"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-share-square-o"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-shield"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-shopping-cart"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-sign-in"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-sign-out"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-signal"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-sitemap"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-smile-o"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-sort"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-sort-alpha-asc"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-sort-alpha-desc"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-sort-amount-asc"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-sort-amount-desc"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-sort-asc"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-sort-desc"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-sort-down"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-sort-numeric-asc"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-sort-numeric-desc"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-sort-up"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-spinner"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-square"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-square-o"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-star"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-star-half"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-star-half-empty"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-star-half-full"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-star-half-o"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-star-o"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-subscript"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-suitcase"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-sun-o"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-superscript"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-tablet"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-tachometer"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-tag"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-tags"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-tasks"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-terminal"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-thumb-tack"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-thumbs-down"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-thumbs-o-down"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-thumbs-o-up"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-thumbs-up"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-ticket"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-times"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-times-circle"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-times-circle-o"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-tint"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-toggle-down"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-toggle-left"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-toggle-right"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-toggle-up"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-trash-o"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-trophy"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-truck"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-umbrella"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-unlock"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-unlock-alt"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-unsorted"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-upload"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-user"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-users"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-video-camera"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-volume-down"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-volume-off"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-volume-up"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-warning"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-wheelchair"></i></div>
                        <div class="col-sm-2" style="cursor:pointer;"><i class="fa fa-wrench"></i></div>
                      </div>
                    </div>
                  </div>
                </div>     
                <div class="row m-b-sm m-l-sm m-r-sm">
                  <div class="col-sm-6 font-bold"><?php echo freetext('sequence_index'); ?></div>
                  <div class="col-sm-6"><input <?php echo $readonly; ?> type="text" autocomplete="off" name="sequence_index" data-type="number" class="form-control" value="<?php echo $module['sequence_index']; ?>"></div>
                </div>  
                <div class="row m-b-sm m-l-sm m-r-sm <?php echo $disabled; ?>">
                  <div class="col-sm-6">
                    <input type="checkbox" name="is_active" value="1" <?php if ($module['is_active'] == 1) { echo "checked"; } ?>>&nbsp;<?php echo freetext('is_active'); ?>
                  </div>
                  <div class="col-sm-6">
                    <input type="checkbox" name="is_action_plan" value="1" <?php if ($module['is_action_plan'] == 1) { echo "checked"; } ?>>&nbsp;<?php echo freetext('able_to_create_action_plan'); ?>
                  </div>
                  <div class="col-sm-6">
                    <input type="checkbox" name="is_menu" value="1" <?php if ($module['is_menu'] == 1) { echo "checked"; } ?>>&nbsp;<?php echo freetext('is_menu'); ?>
                  </div>              
                  <div class="col-sm-6">
                    <input type="checkbox" name="is_main_menu" value="1"<?php if ($module['is_menu'] != 1) { echo "disabled"; } ?><?php if ($module['is_main_menu'] == 1) { echo "checked"; } ?>>&nbsp;<?php echo freetext('is_main_menu'); ?>
                  </div>
                </div>  
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <span type="button" class="btn btn-primary edit_module_btn"><i class="fa fa-save"></i> <?php echo freetext('save'); ?></span>
            <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo freetext('cancel'); ?></button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

<?php
        }
    }
?>

<div class="module_department modal fade xxl" id="department_module_modal">
  <div class="modal-dialog" style="width:50%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title h4"><?php echo freetext('department_mapping'); ?> : <span class="module_name"></span></h4>
      </div>
      <div class="modal-body loading_div text-center">
        <img style="max-width: 20%;" src="http://fc07.deviantart.net/fs70/f/2011/299/d/9/simple_loading_wheel_by_candirokz1-d4e1shx.gif">
      </div>
      <div class="modal-body data_div" style="max-height:500px; overflow-y:auto; display:none;">
        <form id="form_map_module" method="post" action="<?php echo site_url('__cms_data_manager/module_mapping'); ?>" data-validate="parsley">
            <input type="hidden" name="id" value="">
            <div class="dd nestable">
                <?php
                    if (!empty($department_html)) {
                        echo $department_html;
                    }
                ?>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <span type="button" class="btn btn-primary map_module_btn"><i class="fa fa-save"></i> <?php echo freetext('save'); ?></span>
        <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo freetext('cancel'); ?></button>
      </div>
    </div>
</div>
<div class="module_delete modal fade xxl" id="delete_module">
  <div class="modal-dialog" style="width:50%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title h4"><?php echo freetext('delete_module'); ?></h4>
      </div>
      <div class="modal-body">
        <form id="delete_module_form" method="post" action="<?php echo site_url('__cms_data_manager/module_delete'); ?>">
            <input type="hidden" name="id" value="">
        </form>
        คุณต้องการลบ <span class="obj_text"></span> ใช่หรือไม่
      </div>
      <div class="modal-footer">
        <span type="button" class="btn btn-primary delete_module_btn"><i class="fa fa-trash-o"></i> <?php echo freetext('delete'); ?></span>
        <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo freetext('cancel'); ?></button>
      </div>
    </div>
</div>