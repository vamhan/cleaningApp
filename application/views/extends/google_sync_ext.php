 <a href="#facebook_content_ext" class="" data-toggle="modal"><button class='pull-right btn-sm btn-warning btn'><i class='fa fa-refresh'></i>&nbsp;&nbsp;Sycn Google Channel</button></a>

 <!--Start: modal add new category -->
<div class="modal fade" id="facebook_content_ext">
  <!-- <form action='<?php //echo site_url($this->page_controller.'/saveDetail'); #CMS?>' method="POST"> -->
    <div class="modal-dialog">
      <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"> Import Content <?php //echo 'New '.$this->page_object;#CMS ?> </h4>
                      </div>
                              <div class="modal-body" style='overflow:auto; min-height:600px'>

                                




  
  <?php 
  //Existing video
    $this->db->select('tbt_vod.youtube_id,tbt_vod.vod_list_id,tbt_vod_list.playlist_id');
    $this->db->join('tbt_vod_list', 'tbt_vod.vod_list_id = tbt_vod_list.id ','LEFT');
    $result = $this->db->get('tbt_vod'); 
    $result = $result->result_array();

    $output = array();
    foreach ($result as $key => $value) {

      if (!array_key_exists($value['playlist_id'], $output)) {
        $output[$value['playlist_id']] = array();  
      }
      array_push( $output[$value['playlist_id']] , array( 'vod_list_id'=>$value['vod_list_id'], 'youtube_id'=> $value['youtube_id'] ));

    }


    $global_existing_vod_list = json_encode($output);
    unset($output);
    // echo '<pre>';
    // print_r($output);
    // // print_r($result);
    // echo '</pre>';

  ?>




                                        <section class="panel panel-default">
                                          <header class="panel-heading">
                                            


                                            <div class="input-group text-sm">
                                            <!-- start : row --><!-- <div class="row"> -->
                                              
                                              <!-- start : dropdown -->
                                                <select class='form-control playlist-selector' style="width:30%">
                                                <?php 
                                                  $this->db->select('name,playlist_id');
                                                  $listx = $this->db->get('tbt_vod_list');
                                                  $listx = $listx->result_array();
                                                  
                                                  foreach ($listx as $key => $value) {
                                                    ?>
                                                     <option value='<?php echo $value["playlist_id"];?>'><?php echo $value["name"];?></option>
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
                                              
                                              <!-- </div> --><!-- end : row -->
                                            </div>

                                          </header>
                                          <ul class="list-group alt">

                                          </ul>
                                          <center class='loading-image hide'>
                                            <img src="<?php echo asset_url().'images/loading.gif'?>">
                                          </center>
                                        </section>























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







<!-- <div class='hide page-post-item' id='page-post-proto'>

    <li class="list-group-item">
      <div class="media">
        <span class="pull-left thumb-sm"><img src="images/avatar.jpg" alt="John said" class="img-circle"></span>
        <div class="pull-right text-success m-t-sm">
          <i class="fa fa-circle"></i>
        </div>
        <div class="media-body">
          <div><a href="#">Chris Fox</a></div>
          <small class="text-muted">about 2 minutes ago</small>
        </div>
      </div>
    </li>

</div> -->



















<script type="text/javascript">



  var global_current_playlist_id = -1;// -1 is customized undefined
  var global_existing_vod_list = JSON.parse('<?php echo $global_existing_vod_list; ?>');
  var global_vod_list_to_sync = -1;



$(document).ready(function(){
  

  function loadChannel(channelId){

    //PLcymrTggwPvM5fnEqtiL77ppNSgQ82Wig
    var urlx = 'http://gdata.youtube.com/feeds/api/playlists/'+channelId+'?v=2&alt=json';
    var list = $('.list-group');

    $.ajax({
      type:"GET",
      url:urlx,
      data:"",
      contentType:"json",
      beforeSend:function(){
            list.empty();   
            $('.loading-image').removeClass('hide');
      },
      success:function(data){
        var entry  = data['feed']['entry'];
        var list = $('.list-group');
        $.each(entry,function(k,v){         
          // //Log
          // console.log(v['title']['$t']);
          // console.log(v['media$group']['media$description']['$t']);
          // $.each(v['media$group']['media$thumbnail'],function(kx,vx){
          //   if(vx['yt$name']=='hqdefault'){ console.log(vx['url']); }
          // })
          // console.log(v['yt$statistics']['viewCount']);
          // console.log('\n');
          // //End Log 

          //Render List 
            //page-post-item
            var photo = '';
            $.each(v['media$group']['media$thumbnail'],function(kx,vx){
              if(vx['yt$name']=='hqdefault'){ photo = (vx['url']); }
            })
            

            var title = v['title']['$t'];
            var url = v['media$group']['media$player']['url'];

            var vid = url.split('v=')[1];
            var ampersandPosition = vid.indexOf('&');
            if(ampersandPosition != -1) {
              vid = vid.substring(0, ampersandPosition);
            }
            var id = vid;
            // console.log(id)
            // --> Stop here 

            var description = v['media$group']['media$description']['$t'];
            var upload_date = v['media$group']['yt$uploaded']['$t'];
                upload_date = upload_date.substr(0,10);
            var view_count = v['yt$statistics']['viewCount'];

            var active = (isExistingVideo(id))?"active":"";

            var toggle_button = (isExistingVideo(id))?'<button class="toggle_sync_data btn btn-default btn-xs active" id="'+id+'" playlist-id="'+global_current_playlist_id+'" style="margin:2px" data-toggle="button"><i class="fa fa-circle-o text"></i><i class="fa fa-check-circle-o text-active text-success"></i></button>':'<button class="toggle_sync_data btn btn-default btn-xs" id="'+id+'" playlist-id="'+global_current_playlist_id+'" style="margin:2px" data-toggle="button"><i class="fa fa-circle-o text"></i><i class="fa fa-check-circle-o text-active text-success"></i></button>';
            var single_object = '<li class="list-group-item" > <div class="media">  <span class="pull-left"> '+toggle_button+' </span> <span class="pull-left thumb-sm"><img class="cover_photo" src="'+photo+'" alt="'+description+'" class="img-square"></span> <div class="pull-right text-success m-t-sm"> <!--i class="fa fa-circle"></i--> </div> <div class="media-body"> <div><a class="vod_url" href="'+url+'" target="_blank"  >'+title+'</a></div> <small class="text-muted"><i class="fa fa-cloud-upload"></i>&nbsp;Upload &nbsp; <span class="vod_upload" >'+upload_date+'</span> &nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp; <i class="fa fa-eye"></i>&nbsp;<span class="vod_view_count">'+view_count+'</span> View</small> </div> </div> </li>';

            list.append(single_object);
            
        })

      },
      error:function(err){
        alert('Unable to load data from youtube.com')
      },
      complete:function(){
        $('.loading-image').addClass('hide');
      }

    })//end ajax function 
  }//end function 

  // loadChannel('PLcymrTggwPvM5fnEqtiL77ppNSgQ82Wig');


  //Force load 1 playlist
  global_current_playlist_id = $('.playlist-selector').val()
  loadChannel( global_current_playlist_id );

  //On Playlist change 
  $('.playlist-selector').on('change',function(){
    global_current_playlist_id = $(this).val();
    loadChannel( global_current_playlist_id );
  })


  function isExistingVideo(vid){
            var currentExistingList = global_existing_vod_list[global_current_playlist_id];
            for(var index in currentExistingList){
              if(currentExistingList[index]['youtube_id'] == vid)
                return true;
            }
            return false;
  }//end function 




  $('.sync-selection-btn,.sync-all-btn').on('click',function(){

    if( $(this).hasClass('sync-all-btn') ){
      if(!confirm('You \'re going to sync all video in playlist to sso_mobile API , Do you confirm this action'))
        return ;
      $('.toggle_sync_data').addClass('active');
    }

    
    global_vod_list_to_sync = new Object();
    global_vod_list_to_sync_string = '';
    //Collect 
    $('.toggle_sync_data.active').each(function(){
    

      var enclosure = $(this);
      var objectData = enclosure.parent().parent();
      var data = new Object();

        data.vod_title = objectData.find('.vod_url').html();
        data.vod_url = objectData.find('.vod_url').attr('href');
        data.vod_upload = objectData.find('.vod_upload').html();
        data.vod_view_count = objectData.find('.vod_view_count').html();
        data.vod_cover_photo = objectData.find('.cover_photo').attr('src');
        data.vod_description = objectData.find('.cover_photo').attr('alt');
      

        if( global_vod_list_to_sync[enclosure.attr('playlist-id')] == undefined ){
        //New Array if array not exist 
          global_vod_list_to_sync[enclosure.attr('playlist-id')] = new Object();
        }
        global_vod_list_to_sync[enclosure.attr('playlist-id')][enclosure.attr('id')] = data;
        // global_current_playlist 
    });

    // JS
    // console.log(JSON.stringify(global_vod_list_to_sync));
       global_vod_list_to_sync_string = JSON.stringify(global_vod_list_to_sync);
       // console.log(global_vod_list_to_sync_string);

    //AJAX
      $.ajax({
        url:"<?php echo site_url('__proto_mobile_api/post_sync_gdata');?>",
        type:"POST",
        data:global_vod_list_to_sync,
        // dataType:"json",
        beforeSend:function(){

        },
        success:function(data){
          // console.log('Response');
          // console.log(data)
          $.gritter.add({
            title: 'Success',
            text: 'All video synced to sso_mobile API',
            image: '<?php echo asset_url()."/images/noti-ico.png" ?>',
            sticky: false,
            time: 4000
          });


        },

        error:function(err){
          $.gritter.add({
            title: 'Error',
            text: 'Video sync is not function ,try again later',
            image: '<?php echo asset_url()."/images/noti-ico.png" ?>',
            sticky: false,
            time: 4000
          });

        },
        complete:function(){

        }
      });

  })//end on click


})
 



</script>

