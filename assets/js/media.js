var mediaModule = {
  init: function() {
    mediaModule.bindTab();
    mediaModule.bindChangeView();
    mediaModule.mediaCallback();
    mediaModule.bindCreateFolder();
    mediaModule.bindAddToFolder();
  },

  mediaCallback: function() {
    mediaModule.bindDeleteMedia();
    mediaModule.bindDragDropFolder();
    mediaModule.bindRename();
    mediaModule.bindDeleteFolder();
    mediaModule.bindFavorite();
    mediaModule.bindPage();
  },

  bindChangeView: function() {
    $('.media-view-btn').on('click', function() {
      $('.media-view-btn').removeClass('active');
      $(this).addClass('active');

      var view         = $(this).attr('id');
      var url          = $('#change_view_url').val();
      var folder_panel = $('.panel-collapse.in').attr('id');

      $.ajax({
            type: 'post',
            url: url,
            data: "view="+view,
            success: function(data){
                var result = $.parseJSON(data);

                var active_tab = $('.tab-pane.active').attr('id');
                if(active_tab == 'mediaAll') {
                  $('#mediaAll').html(result.mediaHtml);
                  $('#pagination-panel').html(result.media_pagination);
                } else if (active_tab == 'mediaFolder') {
                  $('#mediaFolder').html(result.folderMedia.folderHtml);
                  $('#pagination-panel').html(result.folderMedia.folder_pagination);
                  if(folder_panel != 'folder0') {
                    $('.panel-collapse.in').collapse('hide');
                    $('#'+folder_panel).collapse();
                  }
                } else {
                    $('#mediaFavorite').html(result.favoriteHtml);
                    $('#pagination-panel').html(result.fav_pagination);
                } 

                mediaModule.mediaCallback();
            }
        }); 
    });
  },

  bindPage: function () {
    $('#pagination-panel .page-btn').on('click', function(event) {
      event.preventDefault();
      var url   = $(this).attr('href');
      var view  = $('.media-view-btn.active').attr('id');
      var tab   = $('#tab').val();

      $.ajax({
          type: 'post',
          url: url,
          data: 'view='+view+'&tab='+tab,
          beforeSend :function(data){
            $('#tab-load').show();
            if (tab == 'allMediaTab') {
              $('#mediaAll').hide();
            } else {
              $('#mediaFavorite').hide();
            }
          },
          success: function(data){
            setTimeout(function() {
              $('#tab-load').hide();
              var result = $.parseJSON(data);
              if (tab == 'allMediaTab') {
                $('#mediaAll').html(result.list_items);
                $('#mediaAll').show();
                $('#pagination-panel').html(result.pagination);
              } else {
                $('#mediaFavorite').html(result.list_items);
                $('#mediaFavorite').show();
                $('#pagination-panel').html(result.pagination);
              }

              $('#pagination-panel').show();
              mediaModule.mediaCallback();
              frontendModule.bindMediaInfo();
            }, 500);
          }
      }); 
    });
  },

  bindTab: function() {
    $('a[data-toggle="tab"]').on('click', function() {
      $('.alert-block').hide();
      $('.tab-pane').hide();
    });

    $('#allMediaTab').on('click', function() {
        var url  = $(this).data('url'),
            view = $('.media-view-btn.active').attr('id');

        $.ajax({
            type: 'post',
            url: url,
            data: 'view='+view,
            beforeSend :function(data){
              $('#tab-load').show();
            },
            success: function(data){
              setTimeout(function() {
                $('#tab-load').hide();
                var result = $.parseJSON(data);

                $('#mediaAll').html(result.mediaHtml);
                $('#mediaAll').show();
                $('#pagination-panel').html(result.media_pagination);

                $('#pagination-panel').show();
                mediaModule.mediaCallback();
                frontendModule.bindMediaInfo();
              }, 500);
            }
        }); 
    });

    $('#folderTab').on('click', function() {
        var view = $('.media-view-btn.active').attr('id');
        var url  = $(this).data('url');

        $.ajax({
            type: 'post',
            url: url+'/'+view,
            data: 'ajax=1',
            beforeSend :function(data){
              $('#tab-load').show();
            },
            success: function(data){
              setTimeout(function() {
                $('#tab-load').hide();
                var result = $.parseJSON(data);
                $('#mediaFolder').html(result.folderHtml);
                $('#mediaFolder').show();
                $('#pagination-panel').html(result.folder_pagination);
                $('#pagination-panel').show();
                mediaModule.mediaCallback();
                frontendModule.bindMediaInfo();
              }, 500);
            }
        }); 
    });
    
    $('#favoriteTab').on('click', function() {
        var url  = $(this).data('url');
        var view = $('.media-view-btn.active').attr('id');
        $.ajax({
            type: 'post',
            url: url+'/'+view,
            data: 'ajax=1',
            beforeSend :function(data){
              $('#tab-load').show();
            },
            success: function(data){
              setTimeout(function() {
                $('#tab-load').hide();
                var result = $.parseJSON(data);
                $('#mediaFavorite').html(result.favoriteHtml);
                $('#mediaFavorite').show();
                $('#pagination-panel').html(result.pagination);
                $('#pagination-panel').show();
                mediaModule.mediaCallback();
                frontendModule.bindMediaInfo();
              }, 500);
            }
        }); 
    });
  },

  bindRename:function() {
    $('.is-rename-folder').on('click', function() {
      $('.rename_panel a, .rename_panel input').hide();
      $('.rename_panel a.is-rename-folder').show();

      $(this).prev().show();
      $(this).siblings('a').show();
      $(this).hide();
    });

    $('.is-rename-yes').on('click', function() {
      var folder_id = $(this).data('id'),
          url       = $(this).data('url'),
          name      = $(this).siblings('input').val(),
          view = $('.media-view-btn.active').attr('id');

      $.ajax({
          type: 'post',
          url: url,
          data: 'folder_id='+folder_id+'&name='+name+'&view='+view,
          beforeSend :function(data){
            $('#progress-modal').modal();
          },
          success: function(data){
            setTimeout(function() {
              $('#progress-modal').modal('hide');
              var result = $.parseJSON(data);

              $('#mediaFolder').html(result.folder_html.folderHtml);
              $('#pagination-panel').html(result.folder_html.folder_pagination);
              $('#pagination-panel').show();
              $('#media_action_alert').find('p').text(result.alert_txt)
              $('#media_action_alert').show();

              if(folder_id != 0 ){
                $('.panel-collapse.in').collapse('hide');
                $('#folder'+folder_id).collapse();
              }

              frontendModule.bindMediaInfo();
              mediaModule.bindDragDropFolder(); 
              mediaModule.bindDeleteMedia();
              mediaModule.bindFavorite();
              mediaModule.bindRename();

            }, 1000);
          }
      }); 

    });
  },

  bindCreateFolder: function() {
    $('#new-folder-btn').on('click', function() {
      $('#modal-newfolder').modal();
    });

    $('#save-newfolder').on('click', function() {
      if($('#new-folder-form').parsley('validate')) {
        var url  = $(this).data('url'),
            name = $('#newFolderName').val();

        $('#modal-newfolder').modal('hide');

        $.ajax({
            type: 'post',
            url: url,
            data: 'name='+name,
            beforeSend :function(data){
              $('#progress-modal').modal();
            },
            success: function(data){
                setTimeout(function() {
                  $('#progress-modal').modal('hide');
                  var result = $.parseJSON(data);
                  var newfolderID = result.folder_id.ID;
                  var newFolder   = result.folder_name;

                  var new_opt = "<option value='"+newfolderID+"' selected>"+newFolder+"</option>";
                  $('#add-folder-select').append( new_opt );

                  $('#media_action_alert').find('p').text(result.folder_name+' folder has been created.');
                  $('#media_action_alert').show();
                }, 1000);
            }
        }); 
      }
    });
  },

  bindDeleteFolder:function() {
    $('.is-del-folder').on('click', function() {
      var id = $(this).data('id');
      $('#confirm-delete-folder').data('id', id);
      $('#confirm-delete-folder').modal();
    });

    $('#btn-del-content, #btn-del-folder').on('click', function() {

      var with_content = 1;

      if($(this).attr('id') == 'btn-del-folder') {
        with_content = 0;
      }

      var url          = $('#confirm-delete-folder').data('url'),
          folder_id    = $('#confirm-delete-folder').data('id');

      $('#confirm-delete-folder').modal('hide');
      $.ajax({
          type: 'post',
          url: url,
          data: 'folder_id='+folder_id+'&with_content='+with_content,
          beforeSend :function(data){
            $('#progress-modal').modal();
          },
          success: function(data){
            setTimeout(function() {
              $('#progress-modal').modal('hide');
              var result = $.parseJSON(data);

              $('#mediaFolder').html(result.folder_html.folderHtml);
              $('#pagination-panel').html(result.folder_html.folder_pagination);
              $('#pagination-panel').show();
              $('#media_action_alert').find('p').text(result.alert_txt)
              $('#media_action_alert').show();

              $('#folder0').collapse();

              mediaModule.mediaCallback();
            }, 1000);
          }
      });
    });
  },

  bindDragDropFolder:function() {
    $('.folder_panel li').draggable({
      appendTo: "ul"
    });
    $('.folder_panel .panel-default').droppable({
      accept: ".folder_panel li",
      activeClass: "ui-state-default",
      hoverClass: "ui-state-hover",
      drop: function( event, ui ) {
        var id        = this.id;
        var parent    = $(ui.draggable).parent();
        var parent_panel_id = parent.closest('.panel-default').attr('id');
        var media_id  = $(ui.draggable).attr('id').split('_')[2];
        var folder_id = id.split('_')[1];
        var url       = $('#add-folder-select').data('url');
        var view      = $('.media-view-btn.active').attr('id');

        if(parent_panel_id == id) {
          $('#mediaFolder #item_media_'+media_id).css('left', '');
          $('#mediaFolder #item_media_'+media_id).css('top', '');
          mediaModule.mediaCallback();
        } else {
          var empty = $(this).find('ul').find('#empty');
          if(empty.length > 0) {
            empty.remove();
          }

          var clone_media = $( '#'+$(ui.draggable).attr('id') );

          $(this).find('ul').append( clone_media );
          $('#'+parent_panel_id+' #'+$(ui.draggable).attr('id')).remove();

          $('#mediaFolder #item_media_'+media_id).css('left', '');
          $('#mediaFolder #item_media_'+media_id).css('top', '');

          var li_size = parent.find('li').length;
          if(li_size == 0) {
            parent.append('<li id="empty" class="list-group-item col-md-4" status="" style="border:none;">Empty Folder</li>');
          }

          $.ajax({
              type: 'post',
              url: url,
              data: "media_id="+media_id+"&folder_id="+folder_id+'&view='+view,
              success: function(data){
                  var result = $.parseJSON(data);
                  $('#mediaFolder').html(result.folder_html.folderHtml);
                  $('#pagination-panel').html(result.folder_html.folder_pagination);
                  $('#pagination-panel').show();
                  $('#media_action_alert').find('p').text(result.alert_txt)
                  $('#media_action_alert').show();

                  if(folder_id != 0) {
                    $('.panel-collapse.in').collapse('hide');
                    $('#folder'+folder_id).collapse('show');
                  }

                  frontendModule.bindMediaInfo();
                  mediaModule.bindDragDropFolder();
              }
          }); 
        }

        $('#'+id).find('.panel-heading').css('background-color', '#f5f5f5');

      },
      over: function(event, ui){
        var id = this.id;
        $('#'+id).find('.panel-heading').css('background-color', '#cccccc');
      },
      out: function(event, ui) {
        var id = this.id;
        $('#'+id).find('.panel-heading').css('background-color', '#f5f5f5');
      }
    });
  },

  bindAddToFolder:function() {
    $('#add-folder-btn').on('click', function() {
      var folder_id = $('#add-folder-select').val(),
          view      = $('.media-view-btn.active').attr('id');
          url       = $('#add-folder-select').data('url'),
          id        = '';

      if($('.multiple-check:checked').length > 1) {
        $('.multiple-check:checked').each(function(){
          id += $(this).val()+',';
        });
        id = id.substring(0,id.length-1);
      }else {
        id = $('.multiple-check:checked').val();
      }

      $.ajax({
          type: 'post',
          url: url,
          data: "media_id="+id+"&folder_id="+folder_id+"&view="+view,
          beforeSend :function(data){
            $('#progress-modal').modal();
          },
          success: function(data){
            setTimeout(function() {
              $('#progress-modal').modal('hide');
              var result = $.parseJSON(data);
              $('.media-info-footer').hide();
              $('.multiple-check').removeAttr('checked');

              if ($('#mediaFolder').hasClass('active')) {
                $('#mediaFolder').html(result.folder_html.folderHtml);
                $('#pagination-panel').html(result.folder_html.folder_pagination);
                $('#pagination-panel').show();
                if (folder_id != 0) {
                  $('.panel-collapse.in').collapse('hide');
                  $('#folder'+folder_id).collapse();
                }
                //mediaModule.mediaCallback();
              }
              $('#media_action_alert').find('p').text(result.alert_txt)
              $('#media_action_alert').show();

              frontendModule.bindMediaInfo();
              mediaModule.bindDragDropFolder(); 
              mediaModule.bindDeleteMedia();
              mediaModule.bindFavorite();
              mediaModule.bindRename();

              var footer = $('.media-info-footer.bg-danger');
              footer.removeClass('bg-danger');
              footer.addClass('bg-success');

            }, 1000);
          }
      }); 

    });

  },

  bindFavorite:function () {
    $('.media-favorite').on('mouseover', function() { 
        if($(this).data('status') == 'yes') {
          $(this).removeClass('fa-star');
          $(this).addClass('fa-star-o');
        } else {
          $(this).removeClass('fa-star-o');
          $(this).addClass('fa-star');
        }
    });

    $('.media-favorite').on('mouseout', function() { 
        if($(this).data('status') == 'yes') {
          $(this).removeClass('fa-star-o');
          $(this).addClass('fa-star');
        } else {
          $(this).removeClass('fa-star');
          $(this).addClass('fa-star-o');
        }
    });

    $('.media-favorite').on('click', function() { 
      var li          = $(this).closest('li'),
          id          = $(this).data('id'),
          status      = 'yes',
          icon        = 'fa-star',
          remove_icon = 'fa-star-o',
          url         = $(this).data('url');

      if( $(this).data('status') == 'yes' ) {
        status      = 'no';
        icon        = 'fa-star-o';
        remove_icon = 'fa-star';
      }

      var parent = $(this).closest('.tab-pane').attr('id');

      $.ajax({
          type: 'post',
          url: url,
          data: "media_id="+id+"&status="+status,
          success: function(data){
            console.log($('#'+parent+' #fav_'+id).data('status'));
            $('#'+parent+' #fav_'+id).data('status', status)
            console.log($('#'+parent+' #fav_'+id).data('status'));
            $('#'+parent+' #fav_'+id).find('i').removeClass(remove_icon);
            $('#'+parent+' #fav_'+id).find('i').addClass(icon);

            if(status == 'no') {
              $('#mediaFavorite #item_media_'+id).remove();
              $('#media_action_alert').find('p').text(data+' is unfavorited.');
              $('#media_action_alert').show();
            } else {
              $('#media_action_alert').find('p').text(data+' is favorited.');
              $('#media_action_alert').show();
            }
          }
      });
    });
  },

  bindDeleteMedia:function() {
    $('.delete-media').on('click', function(event) {
      event.preventDefault();

      var id  = $(this).attr('id').split('_')[1];
      var url = $('#media-multi-trash').attr('href');

      $('#delete-modal').modal();
      $('#media-confirm-delete').attr('data-url', url);
      $('#media-confirm-delete').attr('data-id', id);
    });

    $('#media-multi-trash, #media-multi-trash i').on('click', function(event) {
      event.preventDefault();
      var id_list = '';
      if($('.multiple-check:checked').length > 1) {
        $('.multiple-check:checked').each(function(){
          id_list += $(this).val()+',';
        });

        id_list = id_list.substring(0,id_list.length-1);
        $('#media-confirm-delete').attr('data-id', id_list);
      }else {
        $('#media-confirm-delete').attr('data-id', $('.multiple-check:checked').val());
      }

      $('#media-confirm-delete').attr('data-url', $('#media-multi-trash').attr('href'));
      $('#delete-modal').modal();

      return false;
    });

    $('#media-confirm-delete').on('click', function() {

      var url  = $(this).attr('data-url');
      var id   = $(this).attr('data-id');
      var view = $('.media-view-btn.active').attr('id');

      var folder_panel = $('.panel-collapse.in').attr('id');
      var active_tab = $('.tab-pane.active').attr('id');

      $('#delete-modal').modal('hide');
      $('#media_action_alert').hide();
      $.ajax({
          type: 'post',
          url: url,
          data: "media_id="+id+"&view="+view,
          beforeSend :function(data){
            $('#progress-modal').modal();
          },
          success: function(data){
            setTimeout(function() {
              $('#progress-modal').modal('hide');
              var result = $.parseJSON(data);
              
              if(active_tab == 'mediaAll') {
                $('#mediaAll').html(result.mediaHtml);
                $('#pagination-panel').html(result.media_pagination);
              } else if (active_tab == 'mediaFolder') {
                $('#mediaFolder').html(result.folderMedia.folderHtml);
                $('#pagination-panel').html(result.folderMedia.folder_pagination);
                if(folder_panel != 'folder0' ) {
                  $('.panel-collapse.in').collapse('hide');
                  $('#'+folder_panel).collapse();
                }
              } else {
                $('#mediaFavorite').html(result.favoriteHtml);
                $('#pagination-panel').html(result.fav_pagination);
              } 

              frontendModule.bindMediaInfo();
              mediaModule.bindDragDropFolder(); 
              mediaModule.bindDeleteMedia();
              mediaModule.bindFavorite();
              mediaModule.bindRename();

            }, 1000);
          }
      }); 
    });
  }
}