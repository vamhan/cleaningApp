 <a href="#facebook_content_ext" class="" data-toggle="modal"><button class='pull-right btn-sm btn-warning btn'><i class='fa fa-refresh'></i>&nbsp;&nbsp;Sync Facebook Content</button></a>

 <!--Start: modal add new category -->
<div class="modal fade" id="facebook_content_ext">
  <!-- <form action='<?php //echo site_url($this->page_controller.'/saveDetail'); #CMS?>' method="POST"> -->
    <div class="modal-dialog">
      <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"> Import Content <?php //echo 'New '.$this->page_object;#CMS ?> </h4>
                      </div>
                               <div class="modal-body" style='overflow:auto; min-height:400px; padding:0px !important'>



 <?php 
  //Existing video
    $this->db->select('fbc_id');
    $this->db->where('fbc_id <> ""');
    $result = $this->db->get('tbt_news'); 
    $result = $result->result_array();

    $global_existing_news_list = json_encode($result);

    // echo '<pre>';
    // print_r($output);
    // // print_r($result);
    // echo '</pre>';

  ?>




                                <div class='fb_panel-not-connect ' style='margin:20px'>
                                    <fb:login-button onlogin="checkLoginState();">
                                      Connect to facebook
                                    </fb:login-button>
                                    <div id="status">
                                    </div>
                                </div>


                                <!-- start : facebook connected  -->
                                <div class='fb_panel-connected hide '>

                                  <section class="panel panel-default">
                                          <header class="panel-heading">
                                            <div class="input-group text-sm">

                                            <!-- start : row -->
                                              <!-- start : dropdown -->
                                                <select class='form-control fanpage-selector' style="width:30%">
                                                <?php 
                                                  $listx = $this->db->get('tbt_fanpage_config'); 
                                                  $listx = $listx->result_array();
                                                  foreach ($listx as $key => $value) {
                                                    ?>
                                                     <option value='<?php echo $value["page_id"];?>'><?php echo $value["name"];?></option>
                                                    <?php
                                                  }
                                                ?>
                                                </select>
                                              <!-- end : dropdown -->


                                              <!-- start : input -->
                                              <input type="text" autocomplete="off" class="input-sm form-control" style="width:69%; margin:2px 0px 0px 4px" placeholder="Search">
                                              <!-- end : input -->


                                              <!-- start : button with caret -->
                                              <div class="input-group-btn">
                                                <span type="button" class="btn btn-sm btn-danger dropdown-toggle" data-toggle="dropdown">
                                                  <i class='fa fa-refresh'></i>&nbsp; Action <span class="caret"></span>
                                                </span>
                                                <ul class="dropdown-menu pull-right">
                                                  <li><a class='sync-selection-btn' href="#"> <i class='fa fa-list-ol'></i>&nbsp; Sync Selection</a></li>
                                                  <li><a class='sync-all-btn' href="#"> <i class='fa fa-list-ul'></i>&nbsp; Sync Entire Playlist</a></li>
                                                </ul>
                                              </div>
                                              <!-- end : button with caret -->
                                              
                                            </div>

                                          </header>
                                          <ul class="list-group alt">

                                          </ul>
                                          <center class='loading-image hide'>
                                            <img src="<?php echo asset_url().'images/loading.gif'?>">
                                          </center>
                                        </section>

                                </div>
                                <!-- end : facebook connected  -->



                              </div>

                      <div class='clear:both'></div>
                      <div class="modal-footer">
                        <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>

                        <input type='hidden' value='<?php echo $this->session->userdata("current_url"); ?>' name='callback_url' >
                        <input type='hidden' value='create' name='act'> 
                         <input type='hidden' value='<?php echo $category;?>' name='category'> 
    
                        <!-- <input type='submit' class="btn btn-primary" value="Save"> -->
                      </div>
                  </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
          <!-- </form> -->
</div>


<style type="text/css">
  article.media{ min-height: 120px}

</style>















<script type="text/javascript">

  // var global_page_content = [];
  var global_current_fanpage_id = -1;
  var global_post_to_sync = new Array();
  var global_post_to_sync_string = '';
  var global_existing_news_list = JSON.parse('<?php echo $global_existing_news_list; ?>');
  

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));
  //end Load the SDK asynchronously




  //fb Asyn init
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '1454818964777251',
      cookie     : true, 
      xfbml      : true, 
      version    : 'v2.0'
    });
    //On page Loaded
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  };//end fb Asyn init



 

 
  

  //Facebook connect callback 
  function statusChangeCallback(response) {
    if (response.status === 'connected') {
      //Force load 1 playlist
      global_current_fanpage_id = $('.fanpage-selector').val()
      loadFanpageContent(global_current_fanpage_id);
    } else if (response.status === 'not_authorized') {
      document.getElementById('status').innerHTML = 'กรุณา Login facebook และอนุญาตให้แอพเข้าถึง บัญชี facebook ของคุณ เพื่อเลือกเนื้อหาจาก fanpage';
    } else {
      document.getElementById('status').innerHTML = 'กรุณา Login facebook เพื่อเลือกเนื้อหาจาก fanpage';
    }
  }
  //End Facebook connect callback 
  




  //On Click 
  function checkLoginState() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }



  
  function loadFanpageContent(page_id) {
    FB.api('/me', function(response) {
      //console.log('me');
      //console.log(response);

      $('.fb_panel-not-connect,.fb_panel-connected').removeClass('hide');
      $('.fb_panel-not-connect').addClass('hide');

      $('.fb_panel-connected').show();
      
      var list = $('.fb_panel-connected ul.list-group');
      list.empty();
      $('.loading-image').removeClass('hide');

      FB.api(
      // "/527866103915691/feed",
      "/"+page_id+"/feed",
      function (response) {

        $('.loading-image').addClass('hide');
      //console.log('page content loaded');


        if (response && !response.error) {
          //console.log(response.data);
          $('.fb_panel-connected ul.list-group').empty();
          var dx = response.data;

          $.each(dx,function(k,v){
            var obj = v;
            //console.log('trace object : ');
            //console.log(obj);
                      
            if(obj.name !=undefined)
            {
                var datax = {};
                var viewx = undefined;

                
                var id = obj.id;
                var title = obj.name;
                var url = obj.link;
                var photo = obj.picture;
                var description = '';
                if(obj.message != undefined && obj.message !='' && obj.message != null){
                  description = obj.message;
                }else if(obj.description != undefined && obj.description !='' && obj.description != null){
                  description = obj.description;
                }

                var publish_date = ISODateString(new Date(fbDateFix(obj.created_time))).substring(0,11);//fbDateFix(obj.created_time)
                var like_count = 1;//v['yt$statistics']['viewCount'];
                var active = (isExistingVideo(id))?"active":"";

                var toggle_button = (isExistingVideo(id))?'<button class="toggle_sync_data btn btn-default btn-xs active" id="'+id+'" page-id="'+global_current_fanpage_id+'" style="margin:2px" data-toggle="button"><i class="fa fa-circle-o text"></i><i class="fa fa-check-circle-o text-active text-success"></i></button>':'<button class="toggle_sync_data btn btn-default btn-xs" id="'+id+'" page-id="'+global_current_fanpage_id+'" style="margin:2px" data-toggle="button"><i class="fa fa-circle-o text"></i><i class="fa fa-check-circle-o text-active text-success"></i></button>'
                var single_object = '<li class="list-group-item" ><div class="media"><span class="pull-left"> '+toggle_button+' </span> <span class="pull-left thumb-sm"><img class="fbc_photo" src="'+photo+'" class="img-square"></span> <div class="pull-right text-success m-t-sm"></div><div class="media-body"><div><a class="fbc_title" href="'+url+'" target="_blank"  >'+title+'</a></div><div><p class="fbc_description">'+description+'</p></div><small class="text-muted"><i class="fa fa-cloud-upload"></i>&nbsp;Publish &nbsp; <span class="fbc_publish" >'+publish_date+'</span> &nbsp;&nbsp;&nbsp;&nbsp;<!--:&nbsp;&nbsp;&nbsp;&nbsp; <i class="fa fa-thumbs-o-up"></i>&nbsp;<span class="fbc_like_count">'+like_count+'</span> View --> </small> </div></div></li>';




                
                list.append(single_object);
                
            }
            


          })//end each 



          //Bind Event 
          $('.page-post-impornt-btn').off()
          $('.page-post-impornt-btn').on('click',function(){
            var vx = getPageItem($(this).attr('id'))
          })


        }
      }
      );


    },{scope: 'publish_actions,public_profile,email',return_scopes: true} );
    //end function





  var isExistingVideo = function(vid){
            var currentExistingList = global_existing_news_list[global_current_fanpage_id];
            for(var index in currentExistingList){
              if(currentExistingList[index]['fbc_id'] == vid)
                return true;
            }
            return false;
  }//end function 




    var fbDateFix = function(date){ 
    var local = new Date(date.replace(/-/g,'/').replace('T',' ').replace('+0000',''));
      local.setSeconds(local.getSeconds() + 19800);
      // //console.log('>>'+);
      local+='';
      local = local.substring(4,21);
      return local;
    }
      var padZero = function(t){
        if(t<10){
           return '0' + t;
        }
        return t;
      }
    }//end function



    var ISODateString = function(d){
      function pad(n){return n<10 ? '0'+n : n}
        return d.getUTCFullYear()+'-'
          + pad(d.getUTCMonth()+1)+'-'
          + pad(d.getUTCDate()) +' '
          + pad(d.getUTCHours())+':'
          + pad(d.getUTCMinutes())+':'
          + pad(d.getUTCSeconds())
    }
    // var d = new Date();
    // //console.log(ISODateString(d));


    var getPageItem = function(id){
              // return ;
              // //console.log('test');
      for(var index in global_page_content){

        if(global_page_content[index].id+'' == id+''){

           // //console.log('find > '+global_page_content[index].id);
              obj = global_page_content[index];
              var detail = (obj.name);

                if(obj.message != undefined && obj.message !='' && obj.message != null){
                  detail = obj.message;
                }else if(obj.description != undefined && obj.description !='' && obj.description != null){
                  detail = obj.description;
                }

                // `id`, `name`, `image_path`, `description`, `url`, `create_date`, `update_date`, `is_enable`, `delete_flag`
                $.ajax({
                  url:"<?php echo site_url('/terminal/updateFacebookPost') ?>",
                  type:'post',
                  data: {
                     'id':obj.id,
                     'name':obj.name,
                     'image_path':obj.picture,
                     'description':detail,
                     'url':obj.link,
                     'create_date':obj.created_date,
                     'update_date':0,
                     'is_enable':1,
                     'delete_flag':0,
                  },
                  beforeSend:function(){},
                  success:function(data){
                    //console.log(data);
                  },
                  error:function(){},
                  complete:function(){}

                });
                

        }//end if

          return global_page_content[index];
      }//end for
      return false;



    }//end function 



    










  //On Fan page change 
  $('.fanpage-selector').on('change',function(){
    global_current_fanpage_id = $(this).val();
    loadFanpageContent( global_current_fanpage_id );
  })




  //On click sync
  $('.sync-selection-btn,.sync-all-btn').on('click',function(){

    if( $(this).hasClass('sync-all-btn') ){
      if(!confirm('You \'re going to sync all post on current fanpage to sso_mobile API , Do you confirm this action'))
        return ;
      $('.toggle_sync_data').addClass('active');
      // alert('debug : on sync all');
    }else{
      // alert('debug : on sync selection');
    }

    
    global_post_to_sync = new Object();
    global_post_to_sync_string = '';
    //Collect 
    $('.toggle_sync_data.active').each(function(){
    

      var enclosure = $(this);
      var objectData = enclosure.parent().parent();
      var data = new Object();

        data.fbc_id = enclosure.attr('id');
        data.fbc_title = objectData.find('.fbc_title').html();
        data.fbc_link = objectData.find('.fbc_title').attr('href');
        data.fbc_publish = objectData.find('.fbc_publish').html();
        // data.fbc_view_count = objectData.find('.fbc_view_count').html();
        data.fbc_photo = objectData.find('.fbc_photo').attr('src');
        data.fbc_description = objectData.find('.fbc_description').html();
      

        if( global_post_to_sync[enclosure.attr('page-id')] == undefined ){
          //New Array if array not exist 
          global_post_to_sync[enclosure.attr('page-id')] = new Object();
        }
          global_post_to_sync[enclosure.attr('page-id')][enclosure.attr('id')] = data;
          //global_current_playlist 
    });



    // JS
    // console.log(JSON.stringify(global_post_to_sync));
       global_post_to_sync_string = JSON.stringify(global_post_to_sync);
       console.log(global_post_to_sync_string);
       console.log(global_post_to_sync);

    //AJAX
      $.ajax({
        url:"<?php echo site_url('__proto_mobile_api/post_sync_fbdata');?>",
        type:"POST",
        data:global_post_to_sync,
        // dataType:"json",
        beforeSend:function(){

        },
        success:function(data){
          // console.log('Response');
          // console.log(data)
          $.gritter.add({
            title: 'Success',
            text: 'All post synced to sso_mobile API',
            image: '<?php echo asset_url()."/images/noti-ico.png" ?>',
            sticky: false,
            time: 4000
          });


        },

        error:function(err){
          $.gritter.add({
            title: 'Error',
            text: 'Post sync is not function ,try again later',
            image: '<?php echo asset_url()."/images/noti-ico.png" ?>',
            sticky: false,
            time: 4000
          });

        },
        complete:function(){

        }
      });

  })//end on click









</script>

<!--
  Below we include the Login Button social plugin. This button uses
  the JavaScript SDK to present a graphical Login button that triggers
  the FB.login() function when clicked.
-->

