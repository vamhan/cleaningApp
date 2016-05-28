var playlistModule = {
  	init: function() {
    	$('#media-playlist').nestable();
	    playlistModule.bindChangeView();
	    playlistModule.playlistCallback();
		playlistModule.bindMoveMedia();
		playlistModule.bindMediaPlaylistInfo();
    	playlistModule.bindDeletePlaylist();
    	playlistModule.bindMediaList();
    	playlistModule.bindEditDetail();
    	playlistModule.bindDuplicate();
    	playlistModule.bindSave();
		playlistModule.bindCheckPlaylistname();
  	},

  	mediaCallback:function() {
    	frontendModule.bindMediaInfo();
		playlistModule.bindMediaList();
  	},

  	editorCallback:function() {
		playlistModule.bindMoveMedia();
		playlistModule.bindMediaPlaylistInfo();
		playlistModule.bindCheckPlaylistname();
		playlistModule.bindEditDetail();
  	},

  	playlistCallback:function() {
		frontendModule.bindMediaInfo();
		playlistModule.bindDuplicate();
		playlistModule.bindDeletePlaylist();
		playlistModule.bindCheckPlaylistname();
  	},

  	bindEditDetail: function() {
  		$('#edit-playlist-title').on('click', function() {
  			$('#playlist-title-text').hide();
  			$('#playlist_name').show();
  		});

  		$('#edit-playlist-desc').on('click', function() {
  			$('#playlist-desc-text').hide();
  			$('#playlist_desc').show();
  		});

	    $('#input-duration').on('change', function() {
	    	if ($(this).parsley('validate')) {
		    	var sum = $('#input-duration').val();

	      		var sum_time  = sum.split(':');
	      		var sum_hr    = parseInt(sum_time[0])*3600;
	      		var sum_min   = parseInt(sum_time[1])*60;
	      		var sum_sec   = parseInt(sum_time[2]);

	      		sum = sum_hr+sum_min+sum_sec;

		    	var current_sum = playlistModule.calculateFixduration();

	      		var current_sum_time  = current_sum.split(':');
	      		var current_sum_hr    = parseInt(current_sum_time[0])*3600;
	      		var current_sum_min   = parseInt(current_sum_time[1])*60;
	      		var current_sum_sec   = parseInt(current_sum_time[2]);

	      		current_sum = current_sum_hr+current_sum_min+current_sum_sec;

	      		console.log('sum: '+sum+' | cur: '+current_sum  );
		    	if (sum < current_sum) {
		    		var diff = current_sum - sum;

		    		var fix_duration = $('.fix_media_duration');
					for(var i = fix_duration.length-1; i >= 0; i--){
					 	var id = fix_duration[i].id;
					 	var duration = fix_duration[i].value;

			      		var duration_time  = duration.split(':');
			      		var duration_hr    = parseInt(duration_time[0])*3600;
			      		var duration_min   = parseInt(duration_time[1])*60;
			      		var duration_sec   = parseInt(duration_time[2]);

			      		duration =  duration_hr+ duration_min+ duration_sec;

			      		console.log(id+' : '+duration+' | '+diff);
			      		if (diff < duration) {
			      			duration = duration - diff;
			      			diff = 0;
			      		} else {
			      			diff = diff - duration;
			      			duration = 0;
			      		}
			      		console.log(id+' : '+duration+' | '+diff);

						var hours = Math.floor(duration / 3600).toString();
						if ( hours.length == 1 ) {
							hours = '0'+hours.toString();
						}

						var mins  = Math.floor((duration - (hours*3600)) / 60).toString();
						if ( mins.length == 1 ) {
							mins = '0'+mins.toString();
						}

						var secs  = Math.floor(duration % 60).toString();
						if ( secs.length == 1 ) {
							secs = '0'+secs.toString();
						}

						duration = hours+':'+mins+':'+secs;
						fix_duration[i].value = duration;

			      		if ( diff == 0 ) {
			      			break;
			      		}
					}
				} else {
		    		var diff = sum - current_sum;
					$('.media_duration').each(function(index, element) {
		    			//console.log(index+' | diff: '+diff);
						var media_id       = $(this).attr('id').split('_')[1];
						var duration_media = $(this).val();

			      		var duration_time  = duration_media.split(':');
			      		var duration_hr    = parseInt(duration_time[0])*3600;
			      		var duration_min   = parseInt(duration_time[1])*60;
			      		var duration_sec   = parseInt(duration_time[2]);

			      		var duration_media_sec =  duration_hr+ duration_min+ duration_sec;

			      		var fix_duration     = $('#fix_media_duration_'+media_id);
			      		var fix_duration_val = fix_duration.val();

			      		var fix_duration_time  = fix_duration_val.split(':');
			      		var fix_duration_hr    = parseInt(fix_duration_time[0])*3600;
			      		var fix_duration_min   = parseInt(fix_duration_time[1])*60;
			      		var fix_duration_sec   = parseInt(fix_duration_time[2]);

			      		var fix_duration_media_sec =  fix_duration_hr+ fix_duration_min+ fix_duration_sec;

			      		if ((fix_duration_media_sec < duration_media_sec) || (index == $('.media_duration').length-1 && diff > 0)) {
			      			console.log(index+' | '+diff);
			      			if (diff >= (duration_media_sec - fix_duration_media_sec) && index != $('.media_duration').length-1) {
			      				diff -= (duration_media_sec - fix_duration_media_sec);	
			      				fix_duration.val(duration_media);
			      			} else {				
			      				fix_duration_media_sec = fix_duration_media_sec+diff;
			      				diff -= fix_duration_media_sec;			
			      				var hours = Math.floor(fix_duration_media_sec / 3600).toString();
								if ( hours.length == 1 ) {
									hours = '0'+hours.toString();
								}

								var mins  = Math.floor((fix_duration_media_sec - (hours*3600)) / 60).toString();
								if ( mins.length == 1 ) {
									mins = '0'+mins.toString();
								}

								var secs  = Math.floor(fix_duration_media_sec % 60).toString();
								if ( secs.length == 1 ) {
									secs = '0'+secs.toString();
								}

								fix_duration_media_sec = hours+':'+mins+':'+secs;
			      				fix_duration.val(fix_duration_media_sec);
			      			}

			      			if(diff == 0) {
			      				return false;
			      			}

			      		}
					});
				}	    		
	    	}

	    });  		
  	},

  	bindMediaPlaylistInfo: function() {
	    $('.info-media i').on('click', function(event) {
	      event.preventDefault();

	      var el   = $(this).parent();
	      var id   = el.attr('id').split('_')[1];
	      var url  = $('#info_url').val();

	      $.ajax({
	          type: 'post',
	          url: url,
	          data: "id="+id,
	          success: function(data){
	            el.after(data);
	            $('#media_info').on('hidden.bs.modal', function () {
	              $('#media_info').remove();
	            });
	            $('#media_info').modal();
	          }
	      });
	    });

	    $('.del-media').on('click', function() {
	    	var li = $(this).closest('li');
	    	li.remove();

	    	if ($('li.playlist-media-list').length > 0) {
	            var i = 1;
	            $('li.playlist-media-list').each(function() {
	                if($('li.playlist-media-list').length > 1) {
	                    if(i == 1) {
	                        $(this).find('.handle').hide();
	                        $(this).find('.down-handle').show();
	                    }else if(i == $('li.playlist-media-list').length) {
	                        $(this).find('.down-handle').hide();
	                        $(this).find('.handle').show();
	                    }else {
	                        $(this).find('.handle').show();
	                        $(this).find('.down-handle').show();
	                    }
	                } else {
	                    $(this).find('.handle').hide();
	                    $(this).find('.down-handle').hide();
	                }

	                $(this).attr('data-priority', i);
	                i++;
	            });

	            var sum_duration = playlistModule.calculateFixduration();
	            $('#input-duration').val(sum_duration);
	    	} else {
	    		$('#input-duration').val('00:00:00');
	    		$('#media-list').append('<li id="empty_list" class="list-group-item text-center well col-sm-12 text-muted h4 text-uc" style="padding:20px;">There is no media</li>');
	    	}


	    });

	    $('.fix_media_duration').on('change', function() {
	    	if ( $(this).parsley('validate') ) {
		    	var sum = playlistModule.calculateFixduration();
		    	$('#input-duration').val(sum);
	    	}
	    });
  	},

  	bindMoveMedia: function() {
  		$('.handle').on('click', function() {
  			var li 		 = $(this).parent();
  			var priority = li.attr('data-priority');

  			var up_li       = li.prev();
  			var up_priority = up_li.attr('data-priority');
  			
  			li.attr('data-priority', up_priority);
  			up_li.attr('data-priority', priority);

			var max = 0;
			$('li[data-priority]').each(function() {
			   var pri = $(this).attr('data-priority');
			   if (pri > max) {
			     max = pri;
			   } 
			});

  			if (up_priority == 1) {
  				li.find('.handle').hide();
  				up_li.find('.handle').show();
  			}

			if(priority == max) {
				up_li.find('.down-handle').hide();
			}

  			li.find('.down-handle').show();

  			li.after(up_li);
  		});

  		$('.down-handle').on('click', function() {
  			var li 		 = $(this).parent();
  			var priority = li.attr('data-priority');

  			var down_li       = li.next();
  			var down_priority = down_li.attr('data-priority');
  			
  			li.attr('data-priority', down_priority);
  			down_li.attr('data-priority', priority);

			var max = 0;
			$('li[data-priority]').each(function() {
			   var pri = $(this).attr('data-priority');
			   if (pri > max) {
			     max = pri;
			   } 
			});

  			if (priority == 1) {
  				down_li.find('.handle').hide();
  				down_li.find('.down-handle').show();
  			}

			if(down_priority == max) {
				li.find('.down-handle').hide();
			}

  			down_li.find('.down-handle').show();
			li.find('.handle').show();

  			li.before(down_li);
  		});
  	},

  	bindMediaList: function() {
  		$('#playlist_allMediaTab, #playlist_favoriteTab').on('click', function() {
  			var id = $(this).attr('id');
  			$('#tab').val(id);
  		});
  	  	$('.media_page').on('click', function() {
	      	event.preventDefault();

	      	var url = $(this).attr('href');
		    var id  = $('#save-playlist-detail').data('id');
		    var tab = $('#tab').val();

		    $.ajax({
	            type: 'post',
	            url: url,
	            data: 'id='+id+'&load_tab='+tab,
	            success: function(data){
	            	if (tab == 'playlist_allMediaTab') {
	            		$('#playlist_mediaAll').html(data);
	            	} else if (tab == 'playlist_favoriteTab') {
	            		$('#playlist_mediaFavorite').html(data);
	            	} else {
	            		$('#media_list_modal .modal-body').html(data);
	            	}

	  				playlistModule.mediaCallback();
			  		$('.close-info').on('click', function() {
			  			$(this).closest('.modal').modal('hide');
			  		});
	            }
	        });
  	  	});

  		$('#add-media-btn').on('click', function() {
	      	event.preventDefault();

		    var url = $(this).attr('href');
		    var id  = $('#save-playlist-detail').data('id');
		    $.ajax({
	            type: 'post',
	            url: url,
	            data: 'id='+id,
	            success: function(data){
	            	$('#media_list_modal .modal-body').html(data);
	            	$('#media_list_modal').modal({
	            		backdrop:"static",
	            	 	keyboard:"false" 
	            	});

	  				playlistModule.mediaCallback();

			  		$('.close-info').on('click', function() {
			  			$(this).closest('.modal').modal('hide');
			  		});
	            }
	        });
  		});

  		$('.add_media').on('click', function() {
	      	event.preventDefault();

	        $('#media_list_modal').modal('hide');
	      	var url          = $(this).attr('href');

	      	var id           = '';
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
	            data: 'media_id='+id,
	            success: function(data){
	            	if ($('#empty_list').length > 0) {
	            		$('#media-list').html(data);
	            	} else {
	            		$('#media-list').append(data);
	            	}
	            	$('#media-playlist').nestable();

					var i = 1;
		            $('li.playlist-media-list').each(function() {
		                if($('li.playlist-media-list').length > 1) {
		                    if(i == 1) {
		                        $(this).find('.handle').hide();
		                        $(this).find('.down-handle').show();
		                    }else if(i == $('li.playlist-media-list').length) {
		                        $(this).find('.down-handle').hide();
		                        $(this).find('.handle').show();
		                    }else {
		                        $(this).find('.handle').show();
		                        $(this).find('.down-handle').show();
		                    }
		                } else {
		                    $(this).find('.handle').hide();
		                    $(this).find('.down-handle').hide();
		                }

		                $(this).attr('data-priority', i);
		                i++;
		            });

		            var sum_duration = playlistModule.calculateFixduration();
		            $('#input-duration').val(sum_duration);

		            playlistModule.editorCallback();
	            }
	        });

  		});
  	},

  	calculateFixduration: function() {
		var sum_duration   = 0;
      	$('.fix_media_duration').each(function(){

      		if($(this).val() == '') {
      			var media_id = $(this).attr('id').split('_')[3];
      			var duration = $('#duration_'+media_id).val();
      			$(this).val(duration);
      		}

      		if($(this).parsley('validate') == false) {
      			duration_valid = false;
      		}

      		var this_duration = $(this).val();
      		var time  = this_duration.split(':');
      		var hr    = parseInt(time[0])*3600;
      		var min   = parseInt(time[1])*60;
      		var sec   = parseInt(time[2]);

      		sum_duration += hr+min+sec;

  		});

		var hours = Math.floor(sum_duration / 3600).toString();
		if ( hours.length == 1 ) {
			hours = '0'+hours.toString();
		}

		var mins  = Math.floor((sum_duration - (hours*3600)) / 60).toString();
		if ( mins.length == 1 ) {
			mins = '0'+mins.toString();
		}

		var secs  = Math.floor(sum_duration % 60).toString();
		if ( secs.length == 1 ) {
			secs = '0'+secs.toString();
		}

		return hours+':'+mins+':'+secs;
  	},

  	bindSave: function() {
  		$('#input-shuffle').bootstrapSwitch();
  		$('#input-shuffle').on('switchChange', function (e, data) {
		  	var value = data.value;
		  	$(this).val(value);
		});
  		$('#save-playlist-btn').on('click', function() {
	      	event.preventDefault();	

	      	var form     = $('#save-playlist-detail'),
	      		id       = '',
	      		media_id = '';

			if($('.multiple-check:checked').length > 1) {
	        	$('.multiple-check:checked').each(function(){
	          		id += $(this).val()+',';
	        	});
	        	id = id.substring(0,id.length-1);
	      	}else {
	        	id = $('.multiple-check:checked').val();
	      	}

	      	var duration_valid = true;
	      	var sum_duration   = 0;
	      	$('.fix_media_duration').each(function(){

	      		if($(this).val() == '') {
	      			var media_id = $(this).attr('id').split('_')[3];
	      			var duration = $('#duration_'+media_id).val();
	      			$(this).val(duration);
	      		}

	      		if($(this).parsley('validate') == false) {
	      			duration_valid = false;
	      		}

      		});

  			if ( form.parsley('validate') && duration_valid ) {
		      	var title 		 = $('#playlist_name').val();
		      	var desc  		 = $('#playlist_desc').val();
		      	var fix_duration = $('#input-duration').val();
		      	var shuffle 	 = $('#input-shuffle').val();

		      	if(fix_duration == '' || fix_duration == '00:00:00') {
		      		fix_duration = playlistModule.calculateFixduration();
		      	}

		      	var playlist_id = form.data('id');
		      	var url         = $(this).attr('href');

				if($('.playlist-media-list').length > 1) {
		        	$('.playlist-media-list').each(function(){
		        		var duration_media = $(this).find('.fix_media_duration').val();
		        		duration_media = duration_media != '' ? duration_media : '00:00:00';

		        		var m_id  = $(this).data('id');
		        		var m_pri = $(this).data('priority')
		          		media_id += m_id+'_'+duration_media+'_'+m_pri+',';
		        	});
		        	media_id = media_id.substring(0,media_id.length-1);
		      	}else {
		        	var ele   = $('.playlist-media-list');
	        		var m_id  = ele.data('id');
	        		var m_pri = ele.data('priority')

	        		var duration_media = ele.find('.fix_media_duration').val();
	        		duration_media = duration_media != '' ? duration_media : '00:00:00';

	          		media_id += m_id+'_'+duration_media+'_'+m_pri;
		      	}

				$.ajax({
		            type: 'post',
		            url: url,
		            data: "id="+playlist_id+"&name="+title+"&desc="+desc+"&duration="+fix_duration+"&shuffle="+shuffle+"&mediaList="+media_id,
			        beforeSend :function(data){
			   			$('#progress-modal').modal();
			        },
		            success: function(data){
		              setTimeout(function() {
		            	$('#progress-modal').modal('hide');
		                var result = $.parseJSON(data);
		                $('#playlist-detail').html(result.detail);
		                $('#media-list').html(result.mediaListItems);

		                $('#input-shuffle').bootstrapSwitch();
	            		playlistModule.editorCallback();

		              }, 500);
		            }
		        });
  			}
  		});
  	},

  	bindChangeView: function() {
	    $('.playlist-view-btn').on('click', function() {
	      	$('.playlist-view-btn').removeClass('active');
	      	$(this).addClass('active');

	      	var view         = $(this).attr('id');
	      	var url          = $('#change_view_url').val();

	      	console.log(url);

	      	$.ajax({
	            type: 'post',
	            url: url,
	            data: "view="+view,
	            success: function(data){
              		var result = $.parseJSON(data);
	            	$('#playlist_list').html(result.playlist_html);
            		$('#pagination-panel').html(result.pagination);

            		playlistModule.playlistCallback();
	            }
	        });
	    });
  	},

  	bindDuplicate:function() {

  		$('.duplicate_btn').on('click', function() {
  			
			var url = $(this).data('url');
			var id  = $(this).data('id');
  			var el = $('#name_'+id);
  			console.log(el);

  			var valid = el.parsley('validate');

  			if (valid) {
  				var title = el.val();
  				var view  = $('.playlist-view-btn.active').attr('id');

				$('#duplicate_'+id).modal('hide');
  				$.ajax({
		            type: 'post',
		            url: url,
		            data: "view="+view+"&id="+id+"&title="+title,
			        beforeSend :function(data){
			   			$('#progress-modal').modal();
			        },		            
		            success: function(data){
		              	setTimeout(function() {
				   			$('#progress-modal').modal('hide');
		              		var result = $.parseJSON(data);
			            	$('#playlist_list').html(result.playlist_html);
		            		$('#pagination-panel').html(result.pagination);

            				playlistModule.playlistCallback();
		              	}, 500);
		            }
		        });
  			}
  		});

  		$('.duplicate_modal').on('hidden.bs.modal', function() {
  			var id = $(this).attr('id').split('_')[1];
  			var copy_name = 'Copy of '+$('#original_'+id).val();

  			$('#name_'+id).val(copy_name);
  		});
  	},

  	bindDeletePlaylist:function() {
	    $('.delete-playlist').on('click', function(event) {
	      event.preventDefault();

	      var id  = $(this).attr('id').split('_')[1];
	      var url = $('#playlist-multi-trash').attr('href');

	      $('#delete-modal').modal();
	      $('#playlist-confirm-delete').attr('data-url', url);
	      $('#playlist-confirm-delete').attr('data-id', id);
	    });

	    $('#playlist-multi-trash, #playlist-multi-trash i').on('click', function(event) {
	      	event.preventDefault();
	      	var id_list = '';
	      	if($('.multiple-check:checked').length > 1) {
		        $('.multiple-check:checked').each(function(){
		          id_list += $(this).val()+',';
		        });

		        id_list = id_list.substring(0,id_list.length-1);
		        $('#playlist-confirm-delete').attr('data-id', id_list);
	      	}else {
	        	$('#playlist-confirm-delete').attr('data-id', $('.multiple-check:checked').val());
	      	}

	      	$('#playlist-confirm-delete').attr('data-url', $('#playlist-multi-trash').attr('href'));
	      	$('#delete-modal').modal();

	      return false;
	    });

	    $('#playlist-confirm-delete').on('click', function() {

	      var url  = $(this).attr('data-url');
	      var id   = $(this).attr('data-id');
	      var view = $('.playlist-view-btn.active').attr('id');

	      $('#delete-modal').modal('hide');

	      $.ajax({
	          type: 'post',
	          url: url,
	          data: "playlist_id="+id+"&view="+view,
	          beforeSend :function(data){
	            $('#progress-modal').modal();
	          },
	          success: function(data){
	            setTimeout(function() {
	              	$('#progress-modal').modal('hide');
              		var result = $.parseJSON(data);
	            	$('#playlist_list').html(result.playlist_html);
            		$('#pagination-panel').html(result.pagination);

            		playlistModule.playlistCallback();
	            }, 1000);
	          }
	      });
	    });
	},

	bindCheckPlaylistname: function() {
		$('#playlist_name, .duplicate_name').change(function(){

			var origin = $('#playlist-name-origin').val();

			console.log(origin+' | '+$(this).val());

			var ele    = $(this);
			var check_ele = $(ele.attr('data-username'));

			if($('#playlist-name-origin').length == 0 || $(this).val() != origin) {
				$.ajax({
			        type: 'post',
			        url: $(this).attr('data-check'),
			        data: 'name='+$(this).val(),
			        beforeSend :function(data){
			        	$('#load-playlist-check').show();
			        	if($('#edit-playlist-title').length > 0) {
			        		$('#edit-playlist-title').hide();
			        	}
			        },
			        success: function(data){
			        	setTimeout(function() {
				        	$('#load-playlist-check').hide();
				        	if($('#edit-playlist-title').length > 0) {
				        		$('#edit-playlist-title').show();
				        	}
				        	if(data > 0) {
				        		check_ele.val(false);
				        	}else {
				        		check_ele.val(ele.val());
				        	}
				        	
				        	return ele.parsley('validate');
			        	}, 500);
			        }
			    });	
			} else {
				check_ele.val($(this).val());
				return ele.parsley('validate');
			}
			
		});
	}
}