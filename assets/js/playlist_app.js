var playlistApp = {

	attr1: "String : playlistApp.js",
	action: '',
	init: function() {
		playlistApp.bindItemTool();
		playlistApp.bindEditorTool();
	},
	bindItemTool: function() {
		$('.item-tool .duplicate').click(function(e) {
				
		});
		$('.item-tool .delete').click(function(e) {
			e.preventDefault();
			playlistApp.action = 'deletePlaylist';
			$('#delete-modal').modal();
			$('#confirm-delete').attr('href', $(this).attr('href'));
			$('#confirm-delete').attr('data-id', $(this).attr('data-id'));	
		});
		$('#confirm-delete').click(function(e) {
			e.preventDefault();
			if(playlistApp.action == 'deletePlaylist') {
				var url = $(this).attr('href');
				var id = $(this).attr('data-id');
				$.ajax({
			        type: 'post',
			        url: url,
			        data: {'id' : id},
			        beforeSend: function(data){
						$('#delete-modal').modal('hide');
			        	$('#progress-modal').modal();
			        },
			        success: function(data) {
		        		//var result = $.parseJSON(data);
		        		// $('.admin-table').find('tbody').html(result.userlist);
		        		// $('#pagination-panel').html(result.pagination);
		        		//console.log(result.userlist);
		        		//frontendModule.init();
		        		alert(data);
		        		$('#progress-modal').modal('hide');
		        		$('.modal-backdrop').hide();
			        }
			    });
			}
		});
	},
	bindEditorTool: function() {
		$('.edit-text-btn').click(function(e) {
			e.preventDefault();
			$('#input-modal').modal();
			var target = $(this).attr('href');
			$('#input-modal #input-text').val($(target).html());
			$('#confirm-save').attr('href', $(this).attr('href'));
		});
		$('#input-modal #confirm-save').click(function(e) {
			e.preventDefault();
			var text = $('#input-modal #input-text').val();
			var target = $(this).attr('href');
			$(target).html(text);
			$('#input-modal').modal('hide');
		});

		$('#back-btn').click(function(e) {
			e.preventDefault();
			playlistApp.confirmModal(this);
		});
		$('#save-playlist-btn').click(function(e) {
			e.preventDefault();
			playlistApp.action = 'savePlaylist';
			//	 Check title if empty
			var title = $('#playlist-title-text').html();
			if(title == '') {
				playlistApp.alertModal('Please fill playlist title');
				return ;
			}
			if($('#media-list li').length == 0) {
				// playlistApp.alertModal('Please add media');
				// return ;
			}
			$('#delete-modal').modal();
			$('#delete-modal #confirm-delete').attr('href', $(this).attr('href'));
			$('#delete-modal #confirm-delete').attr('data-id', $(this).attr('data-id'));
		});
		$('#delete-modal #confirm-delete').click(function(e) {
			e.preventDefault();
			if(playlistApp.action == 'savePlaylist') {
				var url = $(this).attr('href');
				var id = $(this).attr('data-id');
				var title = $('#playlist-title-text').html();
				var desc = $('#playlist-desc-text').html();
				var duration = $('#input-duration').val();
				var isShuffle = $('#input-shuffle').is(":checked") ? '1' : '0';
				//	Count media
				var mediaArray = new Array(); 
			    $('#media-list li').each(function(index, value) {
			    	var mediaId = $(value).find('.expanded-item .media-checkbox').attr('data-id');
			    	var duration = $(value).find('.expanded-item .input-duration').val();
			    	var orderIndex = index;
					mediaArray[mediaArray.length] = {
						'mediaId' : mediaId,
						'duration' : duration,
						'orderIndex' : orderIndex
					};
			    });
			    console.log(id);
			    console.log(title);
			    console.log(desc);
			    console.log(duration);
			    console.log(isShuffle);
			    console.log(mediaArray);
			    //	Start request
				$.ajax({
			        type: 'post',
			        url: url,
			        data: {
			        	'id' : id,
			        	'title' : title,
			        	'desc' : desc,
			        	'duration' : duration,
			        	'isShuffle' : isShuffle,
			        	'mediaArray' : JSON.stringify(mediaArray)
			        },
			        beforeSend: function(data){
						$('#delete-modal').modal('hide');
			        	$('#progress-modal').modal();
			        },
			        error: function(xhr, status, error) {
						console.log(xhr);
					},
			        success: function(data) {
		        		//var result = $.parseJSON(data);
		        		// $('.admin-table').find('tbody').html(result.userlist);
		        		// $('#pagination-panel').html(result.pagination);
		        		//console.log(result.userlist);
		        		//frontendModule.init();
		        		console.log(data)
		        		$('#progress-modal').modal('hide');
		        		$('.modal-backdrop').hide();
			        }
			    });
			}
		});
		//	Add media
		$('#add-media-btn').click(function(e) {
			e.preventDefault();
			var url = $(this).attr('href');
			$.ajax({
		        type: 'post',
		        url: url,
		        beforeSend: function(data){
					$('#delete-modal').modal('hide');
		   //      	$('#progress-modal').modal();
		        },
		        error: function(xhr, status, error) {
					console.log(xhr);
				},
		        success: function(data) {
	        		$('#media-add-list').html(data);
	        		$('#progress-modal').modal('hide');
					$('#add-media-modal').modal();
		        }
		    });
		});
		//	Add media from modal
		$('#confirm-add-media-btn').click(function(e) {
			e.preventDefault();
			var mediaArray = new Array(); 
		    $('#media-add-list .gridCheckbox input:checkbox').each(function(index, value) {
		      	var isChecked = $(value).is(':checked');
		    	if(isChecked) {
		        	mediaArray[mediaArray.length] = $(value).val();
		    	}
		    });
		    var url = $(this).attr('href');
			$.ajax({
		        type: 'post',
		        url: url,
		        data: { 'mediaArray[]' : mediaArray },
		        beforeSend: function(data){
					$('#add-media-modal').modal('hide');
		        	$('#progress-modal').modal();
		        },
		        error: function(xhr, status, error) {
					console.log(xhr);
				},
		        success: function(data) {
		        	$('#media-list').append(data);
	        		$('#progress-modal').modal('hide');
		        	$('.modal-backdrop').hide();
		        }
		    });
		});

		//	Bind media item action
		//	Compress btn
		$('.edit-media-list-item .expanded-item').on('click', '.compress-btn', function(e) {
			e.preventDefault();
			var curItem = $(this).parents('.edit-media-list-item');
    		var curIndex = $('.edit-media-list-item').index(curItem);
    		curItem.find('.tiny-item').removeClass('hide');
      		curItem.find('.expanded-item').addClass('hide');
		});
		//	Expanded btn
		$('.edit-media-list-item .tiny-item').on('click', '.expanded-btn', function(e) {
			e.preventDefault();
			var curItem = $(this).parents('.edit-media-list-item');
    		var curIndex = $('.edit-media-list-item').index(curItem);
    		curItem.find('.tiny-item').addClass('hide');
      		curItem.find('.expanded-item').removeClass('hide');
		});
		//	Change index up
		$('.edit-media-list-item').on('click', '.index-up-btn', function(e) {
			e.preventDefault();
			var curItem = $(this).parents('.edit-media-list-item');
		    var curIndex = $('.edit-media-list-item').index(curItem);
		    if(curIndex != 0) {
		      var prevIndex = parseInt(curIndex) - 1;
		      var prevItem = $('.edit-media-list-item').eq(prevIndex);
		      $(prevItem).before(curItem);
		      //  Change index
		      curItem.find('.media-order-text').html(prevIndex);
		      curItem.find('.index-up-btn').val(prevIndex);
		      curItem.find('.index-down-btn').val(prevIndex);


		      prevItem.find('.media-order-text').html(curIndex);
		      prevItem.find('.index-up-btn').val(curIndex);
		      prevItem.find('.index-down-btn').val(curIndex);
		    }
		});
		//	Change index down
		$('.edit-media-list-item').on('click', '.index-down-btn', function(e) {
			e.preventDefault();
			var lastIndex = $('#media-list li').length - 1
		    var curItem = $(this).parents('.edit-media-list-item');
		    var curIndex = $('.edit-media-list-item').index(curItem);
		    if(curIndex != lastIndex) {
		      var nextIndex = parseInt(curIndex) + 1;
		      var nextItem = $('.edit-media-list-item').eq(nextIndex);
		      $(nextItem).after(curItem);
		      //  Change index
		      curItem.find('.media-order-text').html(nextIndex);
		      curItem.find('.index-up-btn').val(nextIndex);
		      curItem.find('.index-down-btn').val(nextIndex);

		      nextItem.find('.media-order-text').html(curIndex);
		      nextItem.find('.index-up-btn').val(curIndex);
		      nextItem.find('.index-down-btn').val(curIndex);
		    }
		});
		//	Check box
		$('.edit-media-list-item').on('click', '.media-checkbox', function(e) {
			e.preventDefault();
			var isActive = $(this).hasClass('active');
		    var curItem = $(this).parents('.edit-media-list-item');
		    if(isActive) {
		      curItem.find('.media-checkbox').removeClass('active');
		    } else {
		      curItem.find('.media-checkbox').addClass('active');
		    }
		});
	},
	alertModal: function(text) {
		$('#alert-modal').modal();
		$('#alert-modal .modal-body').html(text);
	},
	confirmModal: function(sender) {
		playlistApp.action = 'backToPlaylist';
		$('#save-change-modal').modal();
		$('#save-change-modal #leave-btn').click(function(e) {
			e.preventDefault();
			if(playlistApp.action == 'backToPlaylist') {
				//	Redirect
				window.location = $(sender).attr('href');
			}
		});
	}
};

$(document).ready(playlistApp.init);