var mediaApp = {

	attr1:"String : mediaApp.js",
	attr2:true,
	attr3:3,
  mediaSelect: mediaSelect = new Array(),

	whoami:function(){
		console.log(this.attr1);
		//using JQuery example
		$('body').css('background','red');
	},

	init: function() {
		mediaApp.bindOpenPageSetting();
		mediaApp.bindOnClickFuntion();
		//alert('test script can work.');
	},

  setViewAllMediaClick: function(){

    /*------------------set favorite star display---------------------*/
    var favoriteArray = $("#mediaAll").find('.favorite-grid-hover');
      //q_ry ajax (refresh data eg,favorite status)
      for (var i = 0; i < favoriteArray.length ; i++) {
          if($(favoriteArray[i]).attr('status') == 't') {
              $(favoriteArray[i]).css({'display':'block', 'color':'rgb(255, 214, 0)'});
          }else{//empty "is_favorite field in db" and f
              $(favoriteArray[i]).attr('status','f');
          }
      }
      if(mediaSelect.length > 0){//mediaID1 pull-right
          $('input[type=checkbox]').attr('checked',false);
          mediaSelect.forEach(function(entry) {
              var media_checkBox = $('#mediaAll #item_media_'+entry).find('.mediaID'+entry);
              if($(media_checkBox).attr('checked') != 'checked'){
                $(media_checkBox).prop('checked',true);
              }
          });
      }

  },

  setViewFavoriteClick: function(){
    var favoriteArray = $("#mediaFavorite").find('.favorite-grid-hover');
      for (var i = 0; i < favoriteArray.length ; i++) {
          if($(favoriteArray[i]).attr('status') == 't') {
              $(favoriteArray[i]).css({'display':'block', 'color':'rgb(255, 214, 0)'});
          }else{//empty "is_favorite field in db" and f
              $(favoriteArray[i]).attr('status','f');
          }
      }

    if($('#showGrid').attr('class') == 'btn btn-default active') {
          $('.medaiDescription').css('display','none');
          $('.picThumbnail').removeClass('col-md-3').addClass('col-md-12');
          $('.list-group-item').removeClass('col-md-12').addClass('col-md-4');
          $('.gridCheckbox').css('display','block');
          $('.listCheckBox').css('display','none');
          $('#dsignage-media').attr('status','grid-item-view');
    }

    if(mediaSelect.length > 0){//mediaID1 pull-right
          $('input[type=checkbox]').attr('checked',false);
          mediaSelect.forEach(function(entry) {
            //alert(entry);
            var select_checkbox = $('#mediaFavorite #item_media_'+entry).find('.mediaID'+entry);
            if(select_checkbox.attr('checked') != 'checked'){
                select_checkbox.prop('checked',true);
            }

          });
      }
  },

	bindOpenPageSetting: function(){
		console.log('short script - js - loaded');
      	// $('.panel-body').slimScroll({ // set height slimscroll bar
      	//   height: '500px'
      	// });
      /*--------clikc tab hide newfolder---------*/
      $('body').on('click', '#folderTab', function(){
        //folder update favorite when data avaiable(after ajax)
          $('#bt_newFolder').css('visibility','visible');
          if($('#mediaFolder .panel-collapse.in').length > 0){
            $('#mediaFolder .panel-collapse.in').attr('class','panel-collapse collapse');
          }
      });

      $('body').on('click', '#allMediaTab', function(){
          $('#bt_newFolder').css('visibility','hidden');
          var select = $('#select-folder');
          $(select).empty();
          //reset all folder to option
          var url_2 = ($(this).attr('base-url'))+ 'media/loadOptionMediaMove';
                  $.post(
                    url_2, 
                    {'folderID' : '-1' },
                    function(data) {//html
                        select.append(data);
                    }
                  );
         mediaApp.setViewAllMediaClick();
      });



      $('body').on('click', '#favoraiteTab', function(){
          $('#bt_newFolder').css('visibility','hidden');
          mediaApp.setViewFavoriteClick();
      });  

      //alert('test');
      if($('#showGrid').attr('class') == 'btn btn-default active') {//firstime force
          $('.medaiDescription').css('display','none');
          $('.picThumbnail').removeClass('col-md-3').addClass('col-md-12');
          $('.list-group-item').removeClass('col-md-12').addClass('col-md-4');
          $('.gridCheckbox').css('display','block');
          $('.listCheckBox').css('display','none');
          $('#dsignage-media').attr('status','grid-item-view');
      }
      mediaApp.setViewAllMediaClick();//default first time
      
	},

	bindOnClickFuntion: function(){
		/*--------event list/grid view---------*/
      $('#showList').click(function() {
          $(this).toggleClass("active");
          $("#showGrid").removeClass("active");
          $('.gridCheckbox').css('display','none');
          $('.listCheckBox').css('display','block');
          $('.medaiDescription').css('display','block');
          $('.list-group-item').removeClass('col-md-4').addClass('col-md-12');
          $('.picThumbnail').removeClass('col-md-12').addClass('col-md-3');
          $('#dsignage-media').attr('status','list-item-view');
          //$('.tab-content').find('.col-md-4').removeClass('col-md-4').addClass('col-md-12');
      
      });

      $('#showGrid').click(function() {
          $(this).toggleClass("active");
          $("#showList").removeClass("active");
          $('.gridCheckbox').css('display','block');
          $('.listCheckBox').css('display','none');
          $('.medaiDescription').css('display','none');
          $('.list-group-item').removeClass('col-md-12').addClass('col-md-4');
          $('.picThumbnail').removeClass('col-md-3').addClass('col-md-12');
          $('#dsignage-media').attr('status','grid-item-view');
          //$('.tab-content').find('.col-md-12').removeClass('col-md-12').addClass('col-md-4');
      });

      
      /*--------event :  create new folder---------*/
      $('#bt_newFolder').click(function() {
          $('#madal-newfoler').modal('show');
          $('#save-newfolder').click(function() {
            var url = ($(this).attr('base-url'))+'media/createNewFolder';
            $.post(
              url, 
              { 'folderName' : $("#folderName").val() },
              function(data) {
                //alert(data);
                $('#media-folder').empty();
                var div = document.getElementById('media-folder');
                    div.innerHTML = data;


                $('#madal-newfoler').modal('hide');
                
                //$('#alert-competet').modal('hide');
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
                 $('#alert-competet').modal('show');
                window.setTimeout(function() {
                    $('#alert-competet').modal('hide');
                }, 2000 );
               
              }
            );
          
          
          });
            
      });
      //return false;

      /* ------------ select move media folder event --------- */
      $('body').on('change', 'input[name=mediaCheckbox]', function(){
        var selectClass;
        if($(this).is(":checked")){
             selectClass = $(this);
             //.attr('class');
             var value = $(this).attr('value');
             $(//'.'+
              selectClass).attr('checked',true);
             mediaSelect.push(value);
        }else{
              selectClass = $(this);
              //.attr('class');
              $(//'.'+
                selectClass).attr('checked',false);
              mediaSelect.pop(value);
        }
        
           console.log('member check ' +mediaSelect.length);
           // if(mediaSelect>0){
           // move foder bar show
        if(mediaSelect.length >0 ) {
              $('.move-to-folder-bar').css('display','block');
        }
        else{
            $('.move-to-folder-bar').css('display','none');
        }

      });


      /*--------event list/grid view---------*/
       $('body').on('change', '#select-folder', function(){
          //alert('asdkljalksd');
          var k = 0; var repeatValue = 0;
          var mediaMoveSelect = []; 
          var folderMoveID = $( "#select-folder option:selected" ).val();
          console.log("move to folderID "+folderMoveID);
          //alert(folderMoveID);
          if(folderMoveID == (-1))//-1 is -Choose folder-
            return ;

              $("input[name=mediaCheckbox]:checked").each(function() {
                 repeatValue = $(this).attr('value');
                 //if(mediaMoveSelect[k-1] != repeatValue) {                             
                    mediaMoveSelect[k] = repeatValue;                    
                    //console.log('select ID : '+mediaMoveSelect[k]);
                    k++;
                    //}
               // console.log('select ID : '+mediaMoveSelect[k]); 
              });


            $('#alert-move-folder').modal('show');
            $('#ans-ok').click(function() {

                  var url = ($(this).attr('base-url'))+ 'media/moveMediaToFolder';
                  console.log("ajax start");
                  $("input[name=mediaCheckbox]:checked").each(function() {
                      repeatValue = $(this).attr('value');
                        //if(mediaMoveSelect[k-1] != repeatValue) {                             
                        mediaMoveSelect[k] = repeatValue;                    
                        console.log('sending select ID : '+mediaMoveSelect[k]);
                        k++;
                    //}
                    // console.log('select ID : '+mediaMoveSelect[k]); 
                  });

                  $.post(
                    url, 
                    { 'mediaToFolderData' : mediaMoveSelect,
                      'folderID' : folderMoveID
                    },
                    function(data) {//remove error

                      if(data == "Success"){
                          for(var i=0;i < mediaMoveSelect.length; i++){
                            var div_id = "#item_media_"+mediaMoveSelect[i];
                            if($(div_id).parent().attr("class") == 'tab-pane fade'){//Tab Folder Delete only
                              $('#mediaFolder '+div_id).remove();
                            }

                          }
                      }

                      $('#alert-move-folder').modal('hide');
                      //clear all check
                      $("input[name=mediaCheckbox]").attr('checked',false);
                        mediaSelect = [];
                      $('.move-to-folder-bar').css('display','none');
                      $('#move-complete').modal('show');
                      window.setTimeout(function() {
                        $('#move-complete').modal('hide');
                      }, 2000 );

                      
                    }
                  );          
          
          });

        });


        /*--------event : click choose folder name---------*/
        $('body').on('click', '.get-folder', function(){
            var folderID = $(this).attr('value');
            var urlFromGetFolder = $(this).attr('base-url');
            //mediaSelect = 0;

            var url = urlFromGetFolder+'media/loadMediaToFolder';
                  $.post(
                    url, 
                    {'folderID' : folderID },
                    function(data) {
                        var selectID = "folderMediaID"+folderID;
                        //alert(selectID);
                        $('#'+selectID).empty();
                           var div = document.getElementById(selectID);
                              div.innerHTML = data;
                        //add data success
                        //alert('html available');
                        var favoriteFolderArray = $("#mediaFolder").find('.favorite-grid-hover');
                        //alert(favoriteFolderArray.length);
                        for (var i = 0; i < favoriteFolderArray.length ; i++) {
                            if($(favoriteFolderArray[i]).attr('status') == 't') {
                                $(favoriteFolderArray[i]).css({'display':'block', 'color':'rgb(255, 214, 0)'});
                            }else{//empty "is_favorite field in db" and f
                                $(favoriteFolderArray[i]).attr('status','f');
                            }
                        }
                        if($('#showGrid').attr('class') == 'btn btn-default active') {
                          //alert('showGrid Active');
                            $("#showList").removeClass("active");
                            //$('#showGrid').toggleClass("active");
                            $('.gridCheckbox').css('display','block');
                            $('.listCheckBox').css('display','none');
                            $('.medaiDescription').css('display','none');
                            $('.list-group-item').removeClass('col-md-12').addClass('col-md-4');
                            $('.picThumbnail').removeClass('col-md-3').addClass('col-md-12');

                        } else{
                            //alert('ListView Active');
                            $("#showGrid").removeClass("active");
                            //$('#showList').toggleClass("active");
                            $('.gridCheckbox').css('display','none');
                            $('.listCheckBox').css('display','block');
                            $('.medaiDescription').css('display','block');
                            $('.list-group-item').removeClass('col-md-4').addClass('col-md-12');
                            $('.picThumbnail').removeClass('col-md-12').addClass('col-md-3');
                        }


                        //changing folder move  
                        var url_2 = urlFromGetFolder +'media/loadOptionMediaMove';
                        $.post(
                            url_2, 
                            {'folderID' : folderID },
                            function(data) {//html
                              var select = $('#select-folder');
                              select.empty().append(data);
                            }
                        );

                        if(mediaSelect.length > 0){//mediaID1 pull-right
                            $('input[type=checkbox]').attr('checked',false);
                            mediaSelect.forEach(function(entry) {
                              //alert(entry);
                              var select_checkbox = $('#mediaFolder #item_media_'+entry).find('.mediaID'+entry);
                              if(select_checkbox.attr('checked') != 'checked'){
                                select_checkbox.prop('checked',true);
                              }
                            });
                        }
                    }
                  );

                  //var hostUrl = window.location;
                  $('.pic_dropdown').each(function() {

                       var child = $(this).children();
                       if(child.attr('class') == 'fa fa-chevron-up accordion-toggle get-folder collapsed'){
                          child.attr('class','fa fa-chevron-down accordion-toggle get-folder collapsed');
                       } 

                  });
                  var spanDiv = "span_folder_"+folderID;
                  var divClassName = "folder"+folderID;
                  var elementClass = document.getElementById(divClassName);
                  if( elementClass.className != 'panel-collapse in' ){//event click down
                      document.getElementById(spanDiv).className = "fa fa-chevron-up accordion-toggle get-folder collapsed";
                  }
        });


        $('body').on('click', '.is-del-foler', function(){

            var folderDelID = $(this).attr('value');
            $('#madal-confirm-delete').modal('show');
            $('#bt-del-folder').click(function() {
                var url = ($(this).attr('base-url'))+'media/deleteMediaFolder';
                      $.post(
                        url, 
                        { 'folderID' : folderDelID
                        },
                        function(data) {
                            
                            $('#media-folder').empty();
                            var div = document.getElementById('media-folder');
                            div.innerHTML = data;
                            $('#madal-confirm-delete').modal('hide');
                            $('body').removeClass('modal-open');
                            $('.modal-backdrop').remove();


                            $('#alert-delFolder-complete').modal('show');
                            window.setTimeout(function() {
                            $('#alert-delFolder-complete').modal('hide');
                            }, 2000 ); 

                          
                        }
                      ); 
            });
        });

        $('body').on('click', '.is-rename-folder', function(){
            var folderDelID = $(this).attr('value');
            var nowSelecter = $(this);
            $('#input-modal').modal('show');

            $('#input-modal .modal-title').html("Rename Folder?");
            $('#input-text').attr('placeholder','folder name');

            $('#confirm-save').click(function() {
                var url = ($('.is-rename-folder').attr('base-url'))+'media/renameFolder';
                var newname = $('#input-modal #input-text').val();
                $.post(
                        url, 
                        { 'folderID' : folderDelID,
                          'newName' : newname
                          
                        },
                        function(data) {
                               
                          $('#folder-nameID-'+folderDelID).html(data);
                          $('#input-modal').modal('hide');

                          

                          $('#alert-rename-competet').modal('show');
                            window.setTimeout(function() {
                            $('#alert-rename-competet').modal('hide');
                            }, 2000 );         
                          
                        }
                      );
            });

        });
        
        //----------Set Favorite event----------//

        $('body').on('mouseover', '.media', function() {

          var thisFavoriyeHover = $(this).find('.favorite-grid-hover');
          $(thisFavoriyeHover).css('display','block'); 

        })

        $('body').on('mouseout', '.media', function() {
          var thisFavoriyeHoverOut = $(this).find('.favorite-grid-hover');
          if((thisFavoriyeHoverOut).attr('status') == 'f') {
            $(thisFavoriyeHoverOut).css('display','none');
          }
          //if($('#mediaFolder')'tab-pane fade active in')

           // $(this).find('.favorite-grid-hover').css('display','none');
        });


        $('body').on('click', '.favorite-grid-hover', function() {

          var mediaID = $(this).attr('value');
          var favoriteStatus = $(this).attr('status');
          /*setting this tab view*/
           if(favoriteStatus == 'f') {//add favorite
            $(this).css('color','rgb(255, 214, 0)').attr('status','t');
            favoriteStatus = "t";
          }else {//remove favortie
            $(this).css('color','').attr('status','f');
            favoriteStatus = "f";
          }
            var url = ($(this).attr('base-url'))+'media/setFavoriteMedia';          
            $.post(
                url, 
                  { 'mediaID' : mediaID,
                    'setStatus' : favoriteStatus
                  },
                function(data) {
                    //console.log(data);            
                    $('#mediaFavorite').html(data);
                    if($('#mediaFolder').attr('class')=='tab-pane fade active in' || 
                       $('#mediaFavorite').attr('class')=='tab-pane fade active in'){
                        //for bug media all not refresh data 
                        //if you click favotite star in folder tab,or favorite tab
                        /*setting this other tab view*/
                        var selecter = $('#mediaAll #item_media_'+mediaID).find( "div.favorite-grid-hover" );//update all tab view
                        if(selecter.attr('status')=='t'){
                            selecter.css({'color':'','display':'none'}).attr('status','f');
                        }else{
                            selecter.css('color','rgb(255, 214, 0)').attr('status','t');
                        }

                        $('#mediaFavorite div[class="favorite-grid-hover"]').each(function() {
                          if($(this).attr('status') =='t'){
                            $(this).css({'color':'rgb(255, 214, 0)','display':'block'}).attr('status','t');
                          }
                        });
                    }

                    if($('#showGrid').attr('class') == 'btn btn-default active') {
                        $('.medaiDescription').css('display','none');
                        $('.picThumbnail').removeClass('col-md-3').addClass('col-md-12');
                        $('.list-group-item').removeClass('col-md-12').addClass('col-md-4');
                        $('.gridCheckbox').css('display','block');
                        $('.listCheckBox').css('display','none');
                        $('#dsignage-media').attr('status','grid-item-view');
                    }
                });



            /*
            }*/
        });

        /*----------remove media event----------*/
        $('body').on('click', '#remove-media', function(){
          var mediaRemoveSelect = [];
          var k =0;
          $("input[name=mediaCheckbox]:checked").each(function() {
                 repeatValue = $(this).attr('value');
                 //if(mediaMoveSelect[k-1] != repeatValue) {                             
                    mediaRemoveSelect[k] = repeatValue;                    
                    console.log('select ID : '+mediaRemoveSelect[k]);
                    k++;
                    //}
               // console.log('select ID : '+mediaMoveSelect[k]); 
              });
          $('#delete-modal').modal('show');
          $('#delete-modal .modal-title').html("Remove Media?");
          $('#delete-modal .modal-body').html("Do you want to remove media?");

          $('#confirm-delete').click(function(){
            var url = ($('#remove-media').attr('base-url'))+'media/reMoveMedia';            
            $.post(
            url, 
            { 'mediaRemoveID' : mediaRemoveSelect
              
            },
            function(data) {
              
              $('#delete-modal').modal('hide');

               if(data == "Success"){
                  for(var i=0;i < mediaRemoveSelect.length; i++){
                    $('#item_media_'+mediaRemoveSelect[i]).remove();
                  }
                  
                  $('#progress-modal').modal('show');
                  window.setTimeout(function() {
                  $('#progress-modal').modal('hide');
                  }, 2000 ); 
              } 
            }
          );

          });
            
        });

        

	},
	/*
	declarNextMethod:function(){
		//TODO : implement code here
	}
	*/
};
$(document).ready(mediaApp.init);