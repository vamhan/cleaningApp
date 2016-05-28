DEBUG = false;
playlistSelDialog = {
	current_selected_playlist:undefined,
	current_selected_playlist_object:undefined,
	dlg_mode:'add',
	obj:$('#timeline-editor-modal'),
	init:function(){
		
		if(DEBUG)console.log('init : playlistSelDialog');

		var selBtn = this.obj.find('#select-playlist-btn');
		var addBtn = this.obj.find('#add-playlist-btn');
		var reSelBtn = this.obj.find('#re-select-playlist-btn');
		var context = this;
		selBtn.off();
			selBtn.on('click',function(){
				context.onDetailView();	
			});
		addBtn.off();
			addBtn.on('click',function(){
				// context.onPlaylistView();	
				// alert('add');
				if(current_selected_playlist == undefined || current_selected_playlist == null || current_selected_playlist == ''){
					playlistSelDialog.hide();
					return ;
				}
				
				var startTime = playlistSelDialog.obj.find('#start-time').val();
				var endTime = playlistSelDialog.obj.find('#end-time').val();
				var duration = playlistSelDialog.obj.find('#duration').val();
				var day = playlistSelDialog.obj.find('#day').val();

				//Validate time 
					validTime = false;
					t1 = startTime.split(':');
					t2 = endTime.split(':');
					//is time in proper range of hour and minutes
					if( ( parseInt(t1[0])>=0 && parseInt(t1[0])<24 &&  parseInt(t2[0])>=0 && parseInt(t2[0])<24 ) && ( parseInt(t1[1])>=0 && parseInt(t1[1])<60 &&  parseInt(t2[1])>=0 && parseInt(t2[1])<60 ) ){
						validTime = true;
					}
				//End : Validate time
			

				if(startTime.length == 5 && endTime.length == 5 && current_selected_playlist_object !=undefined && validTime){

					startTime +=':00';
					startTime = startTime.split(':');
	                var start_h = startTime[0];
	                var start_m = startTime[1];
	                var start_s = startTime[2];
	                startTime = ScheduleMan.forgeTime(start_h,start_m,start_s);

	                endTime +=':00';
	                endTime = endTime.split(':');
	                var end_h = endTime[0];
	                var end_m = endTime[1];
	                var end_s = endTime[2];
	                endTime = ScheduleMan.forgeTime(end_h,end_m,end_s);


					current_selected_playlist_object.start = startTime;
					current_selected_playlist_object.end = endTime;
					current_selected_playlist_object.duration = duration+'';
					current_selected_playlist_object.group = day+'';
				
					// alert('added');
					// console.log(current_selected_playlist_object);
					if(playlistSelDialog.dlg_mode == 'add'){
						global__currentTimeline.push(current_selected_playlist_object);
					}else if(playlistSelDialog.dlg_mode == 'edit'){
						//just don't add it 
					}

					timeline.redraw();
					playlistSelDialog.hide();	
					

				}else{
					alert('invalid start-end time parameter! ')
				}
				
			});
		reSelBtn.off();
			reSelBtn.on('click',function(){
				context.onPlaylistView();	
			});

	},

	show:function(mode,playlist_id){
		
		if(mode =='add'){
			this.obj.modal('show');
			playlistSelDialog.dlg_mode = 'add';
			this.onPlaylistView(playlist_id);

		}else if(mode=='edit'){
			
			if(playlist_id != undefined && playlist_id != 'undefined'){
				this.obj.modal('show');
				playlistSelDialog.dlg_mode = 'edit';
				
				for(var index in global__avialablePlaylist){
					var i = global__avialablePlaylist[index];
					if(i['id']==playlist_id){
						current_selected_playlist = playlist_id; 
						break;
					}
				}
				this.onDetailView();
				//TODO :: load Content id to panel	
			}
			

		}
		// else{
		// 	this.onPlaylistView();		
		// }	
	},

	hide:function(){
		this.obj.modal('hide');
	},

	onPlaylistView:function(playlist_id){
		// console.log('on playlist view ');
		this.obj.removeClass('on-detail');
		this.obj.addClass('on-playlist');

		this.renderPlaylist('');

		var searchbox = this.obj.find('input[type="search"]');
		searchbox.val('');
		searchbox.off();
		searchbox.on('keyup',function(e){
			if(e.keyCode == 13){
				// alert('key : '+searchbox.val())
				//Search 
				playlistSelDialog.renderPlaylist(searchbox.val());
			}else{
				if((searchbox.val()).length == 0){
					playlistSelDialog.renderPlaylist('');	
				}
			}

			
		})

	},

	onDetailView:function(){
		this.obj.removeClass('on-playlist');
		this.obj.addClass('on-detail');


		if(playlistSelDialog.dlg_mode == 'add'){
			playlistSelDialog.obj.find('#add-playlist-btn').html('<i class="fa fa-save"></i> Add</a>');
		}else if(playlistSelDialog.dlg_mode == 'edit'){
			playlistSelDialog.obj.find('#add-playlist-btn').html('<i class="fa fa-save"></i> Edit</a>')
		}

		if(current_selected_playlist !=undefined){
			datax = undefined;
			for(var index in global__avialablePlaylist){
				var i = global__avialablePlaylist[index];
				if(i['id']==current_selected_playlist){
					datax = i;
					current_selected_playlist_object = i; 
					break;
				}
			}

			console.log('log:');
			console.log(i);
			if(datax!=undefined){
				var objx = this.obj.find('.detail-content-wrap');
				objx.find('img').attr('src',('http://upload.wikimedia.org/wikipedia/commons/a/ac/No_image_available.svg'));
				
				objx = objx.find('.detail');
				objx.find('.title').html(i['title'])
				objx.find('.description').html(i['description'])
				objx.find('.actual_duration').html(i['actual_duration'])
				objx.find('.created_by').html(i['created_by'])
				objx.find('.created_date').html(i['created_date'])

				//Shuffle text and icon 
				if(parseInt(i['is_shuffle'])>0){
					$('.is_shuffle i').removeClass('fa-sort-numeric-asc');
					$('.is_shuffle i').addClass('fa-random');
					$('.is_shuffle .is_shuffle_text').html('shuffle');
				}else{
					$('.is_shuffle i').removeClass('fa-random');
					$('.is_shuffle i').addClass('fa-sort-numeric-asc');
					$('.is_shuffle .is_shuffle_text').html('sequence');
				}

				objx.find('.is_shuffle .is_shuffle_text').html()
				
				objx.parent().find('.editor .duration').val(i['duration'])
			}
		}
	},

	renderPlaylist:function(keyword){
		//render playlist 
		var playlist= this.obj.find('.playlist-view ul');
		playlist.empty();

		onSearch = true;
		if(keyword =='' || keyword == undefined){
			onSearch = false;
		}
			
		
		// console.log(global__avialablePlaylist)
		if(global__avialablePlaylist != undefined && global__avialablePlaylist != '' & global__avialablePlaylist != null){
			for(var index in global__avialablePlaylist){
				var i = global__avialablePlaylist[index];
				
				var is_hide = '';
				if(onSearch){
					is_hide = (i['title'].indexOf(keyword)>=0)?'':'hide';
				}
				
				var item = '<li class="playlist_item '+is_hide+'" content-editable="'+i['editable']+'" id="'+i['id']+'" content-start="'+i['start']+'" content-end="'+i['end']+'">';				
				item += '<img class="thumbs" src="'+i['image']+'" /><div class="content-wrap"><span class="title">'+i['title']+'</span><span class="created_date hide">'+i['created_date']+'</span><div class="content-wrap-inner0"><span class=""><span class="content-label">created by</span><span class="content-text created_by">'+i['created_by']+'</span></span></div><span class="is_shuffle hide">'+i['is_shuffle']+'</span><div  class="content-wrap-inner1"><span class=""><span class="content-label"><span class="content-label">Durartion</span><span class="content-text duration">'+i['duration']+'<span></span><span class=""><span class="content-label">Actual duration</span><span class="content-text actual_duration">'+i['actual_duration']+'</span></span></div></div>';
				item += '</li>';				
				playlist.append(item);
			}//end for
		}//end if
		

		var selectPlaylistBtn = $('.playlist_item');
		selectPlaylistBtn.off();
		selectPlaylistBtn.on('click',function(){
			$('.playlist_item').removeClass('active');
			$(this).addClass('active');
			current_selected_playlist = $(this).attr('id');
			// alert('select on : '+current_selected_playlist);
		});
	}





};


timelineMan = {//Timeline manager
	dlg:playlistSelDialog,

	add:function(){
		this.dlg.show('add');
	},
	edit:function(playlist_id)
	{	
		this.dlg.show('edit',playlist_id);
	},
	delete:function(){
		this.dlg.hide();
	},
	getData:function(){
		var data = timeline.getData();
		var output = new Array();
		for(var index in data){
			var i = data[index];
			if(i.id != undefined && i.id != 'undefined'){
				output.push(i);
			}
		}
		console.log(output);
	}

};


ScheduleMan = {//Schedule manager
	errMsg:'',
	timelineMan:timelineMan,
	forgeTime:function(hour,minute,second){
		//fix format :: new Date(year, month, day, hours, minutes, seconds, milliseconds);
		if(hour==undefined || minute==undefined)
			return new Date(1970, 1, 1, 0, 0, 0, 0);//new Date('01-01-1970 00:00:00');
		// return new Date('01-01-1970 '+hour+':'+minute+':'+second);
		return new Date(1970, 1, 1, parseInt(hour), parseInt(minute), parseInt(second), 0);
	},

	saveSchHead:function(){
		ScheduleMan.errMsg = '';
		return false;
	},
	saveEvtId:function(){
		ScheduleMan.errMsg = '';
		return false;
	},
	savePlaylistSch:function(){
		ScheduleMan.errMsg = '';
		return false;
	},
	saveCommandSch:function(){
		ScheduleMan.errMsg = '';
		return false;
	},
};


// TODO:: remove it later , hacked -> unable to solved onload firing twice
firstInit_scheduleApp = false;
$(function(){
	if(!firstInit_scheduleApp){
		firstInit_scheduleApp = true;
		return;
	}else{
		console.log('init scheduleApp.js')
		//init data 	
		
		//init function 
		ScheduleMan.timelineMan.dlg.init();

		$('#timeline-add-btn').on('click',function(){
	            // $('#timeline-editor-modal').modal('show');
	            ScheduleMan.timelineMan.add();//dlg.show('add','');

	    })

	    // $('#schedule-save-btn').on('click',function(){

	    // })
		$('form[name="schedule"]').on('submit',function(){

			if( 
				ScheduleMan.saveSchHead() 
				&& ScheduleMan.saveEvtId() 
				&& ScheduleMan.savePlaylistSch() 
				&& ScheduleMan.saveCommandSch() 
			){
				//TODO :: implement things before submiting form

			}else{
				alert('Unable to save schedule : '+ScheduleMan.errMsg);
				return false;
			}

			// alert('x')
		})
	}
})
