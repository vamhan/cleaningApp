var frontendModule = {
 
    init: function() {

    	frontendModule.initialLogo = '';
        frontendModule.uploadLogo();
   	 	frontendModule.bindMediaInfo();
        licenseControl.init();
        adminPanel.init();
        mediaModule.init();
        playlistModule.init();

    	if ($("#flot-chart").length > 0 ) {
        	chartModule.init();	
	    	var size = $(window).height() - 54.44;
	    	$('#header-box').height(size);
    	}else {
    		frontendModule.resizeWindow();
    	}
    },
    
	bindMediaInfo: function() {
		// console.log('bindMediaInfo');
	    $('input[type="checkbox"]').on('change', function() { 

	      var footer = $(this).closest('div.info-footer');
	      if($(this).is(':checked')) {
	        footer.removeClass('bg-success');
	        footer.addClass('bg-danger');
	      } else {
	        footer.removeClass('bg-danger');
	        footer.addClass('bg-success');
	      }
	    });

	    $('.grid').on('mouseout', function() { 
	        var footer = $(this).find('div.info-footer');
	        if(footer.find('input[type="checkbox"]:checked').length == 0) {
	          footer.hide();
	        }
	        var control_corner = $(this).find('div.control_corner');
	        if(control_corner.length > 0) {
	        	control_corner.hide();
	        }
	    });

	    $('.grid').on('mouseover', function() { 
	        var footer = $(this).find('div.info-footer');
	        footer.show();

	        var control_corner = $(this).find('div.control_corner');
	        if(control_corner.length > 0) {
	        	control_corner.show();
	        }
	    });

	    $('.info-box').on('click', function(event) {
	      event.preventDefault();

	      console.log(url);
	      var el   = $(this).closest('ul');
	      var id   = $(this).attr('id').split('_')[1];
	      var url  = $('#info_url').val();

	      $.ajax({
	          type: 'post',
	          url: url,
	          data: "id="+id,
	          success: function(data){
	            el.after(data);
	            $('#media_info').on('hidden.bs.modal', function () {
	              $(this).remove();
	            });
	            $('#media_info').modal();
	          }
	      }); 
	    });
	},

    resizeWindow: function() {
    	$(window).resize(function() {
	    	var size = $(window).height() - 54.44;
	    	$('#header-box').height(size);
	    	$('#content-list').height((size-133));
	    	$('#content-list').parent().height((size-133));
    	});

    	$(window).trigger('resize');
    },

    uploadLogo: function() {

	  	$("input[type='file']").change(function(evt){
	        	var ele_id 			= this.id;
	        	var id_parts		= ele_id.split('_');

			    var file_ele 	= document.getElementById(ele_id).files; // FileList object.
			    var file  		= file_ele[0];

				if(file.name != undefined){
		        	if (id_parts[1] != undefined){
			        	var company_id = id_parts[1];       

						var formdata = new FormData();
						formdata.append("userfile", file);
						formdata.append("company_id", company_id);
						var ajax = new XMLHttpRequest();
                    	ajax.addEventListener("load", function() {
                    		if($('#drop').length){
                    			$('#drop').children().attr('src', 'http://localhost/swa_dev/assets/images/Company/'+file.name);
                    		}else {
                    			$('#drop_'+company_id).children().attr('src', 'http://localhost/swa_dev/assets/images/Company/'+file.name);
                    		}
                    	}, false);
						ajax.open("POST", "http://localhost/swa_dev/licensecontrol/uploadLogo");
						ajax.send(formdata);
		        	}else {
			        	frontendModule.initialLogo = file;
					    var reader = new FileReader();
					    reader.onload = (function(theFile) {
		        			return function(e) {
		        				var src = e.target.result;
		        				$('#drop').children().attr('src', src);
		        			}
		        		})(file);
		        		// Read in the image file as a data URL.
		      			reader.readAsDataURL(file);	
			        }   
		        }
	  	});

	  	var drop_ele = document.getElementsByClassName('dropfile');
		for (var i = 0; i < drop_ele.length; ++i) {
		    var item = drop_ele[i];  
		    item.addEventListener('drop', function(evt){
		    	evt.stopPropagation();
			    evt.preventDefault();

	        	var ele_id 			= this.id;
	        	var id_parts		= ele_id.split('_');

			    var file_ele 	= evt.dataTransfer.files; // FileList object.
			    var file  		= file_ele[0];

				if(file.name != undefined){
		        	if (id_parts[1] != undefined){
			        	var company_id = id_parts[1];       

						var formdata = new FormData();
						formdata.append("userfile", file);
						formdata.append("company_id", company_id);

						var ajax = new XMLHttpRequest();
						ajax.open("POST", "http://localhost/swa_dev/licensecontrol/uploadLogo");
						ajax.send(formdata);
		        	}else {
			        	frontendModule.initialLogo = file;
			        }   
		        }
		    }, false);
		}
    }

};

var adminPanel = {
	init: function() {
		adminPanel.bindCheckUsername();
		adminPanel.bindUserrole();
		adminPanel.createAccount();
		adminPanel.bindChangeEditForm();
		adminPanel.editProfile();
		adminPanel.editPassword();
		adminPanel.editRoleaccess();
		adminPanel.deleteAccount();
	},

	bindCheckUsername: function() {
		$('#username').change(function(){
			$.ajax({
		        type: 'post',
		        url: $(this).attr('data-check'),
		        data: 'username='+$(this).val(),
		        beforeSend :function(data){
		        	$('#load-username-check').show();
		        },
		        success: function(data){
		        	setTimeout(function() {
			        	$('#load-username-check').hide();
			        	if(data > 0) {
			        		$('#username-check').val(false);
			        	}else {
			        		$('#username-check').val($('#username').val());
			        	}
			        	$('#username').parsley('validate');
		        	}, 500);
		        }
		    });				
		});
	},

	bindUserrole: function() {
		$('#role').change(function() {
			var role_id = $(this).val();
			if (role_id == 3) {
				$('#access_div').show();
				$('#access_div :input[type="checkbox"]').attr('disabled', false);
			}else {
				$('#access_div').hide();
				$('#access_div :input[type="checkbox"]').attr('disabled', 'disabled');
			}
		});
	},

	bindChangeEditForm: function() {
		$("#edit-profile-form :input, #edit-profile-form select").change(function() {
		   $("#edit-profile-form").attr("data-changed",true);
		});

		$('#edit-tab li a').click(function(event){
			event.preventDefault();
			$('.alert-block').hide();
			var changed_form = $('form[data-changed="true"]');
			if(changed_form.length) {
				$('#save-change-modal').modal();
				$('#leave-btn').attr('data-previous-form', changed_form.attr('id'));
				$('#leave-btn').attr('data-previous', '#'+changed_form.closest('.tab-pane').attr('id'));
				$('#leave-btn').attr('data-selected', $(this).attr('href'));
			}
		});

		$('#leave-btn').click(function() {
			var form = $(this).attr('data-previous-form');
			var prev_tab = $(this).attr('data-previous');
			var selected_tab = $(this).attr('data-selected');

			$('#'+form).attr('data-changed', false);
			$('a[href="'+selected_tab+'"]').closest('li').addClass('active');
			$('a[href="'+prev_tab+'"]').closest('li').removeClass('active');

			$(selected_tab).addClass('active');
			$(prev_tab).removeClass('active');
			$('#save-change-modal').modal('hide');
		});
	},

	createAccount: function() {
		$('#create-account-btn').click(function(event) {
			event.preventDefault();
			var form = $('#create-account-form');
			var company_id = $('#company_id').val();
			if(form.parsley('validate')) {
				$.ajax({
			        type: 'post',
			        url: form.attr('action'),
			        data: form.serialize(),
			        success: function(data){
			        	window.location.href = "http://localhost/swa_dev/adminpanel/index/1/"+company_id;
			        }
			    });				
			}
			
		});
	},

	editProfile: function() {
		$('#edit-profile-btn').click(function(event) {
			event.preventDefault();
			var form = $('#edit-profile-form');

			if(form.parsley('validate')) {
				$.ajax({
			        type: 'post',
			        url: form.attr('action'),
			        data: form.serialize(),
			        beforeSend :function(data){
			        	$('#progress-modal').modal();
			        },
			        success: function(data){
			        	setTimeout(function() {
			        		$('#profile_done').show();
			        		form.attr('data-changed', false);
			        		$('#progress-modal').modal('hide')
			        	}, 1000);
			        }
			    });				
			}		});
	},

	editPassword: function() {
		$('#edit-password-btn').click(function(event) {
			event.preventDefault();
			var form = $('#edit-password-form');

			if(form.parsley('validate')) {
				$.ajax({
			        type: 'post',
			        url: form.attr('action'),
			        data: form.serialize(),
			        beforeSend :function(data){
			        	$('#progress-modal').modal();
			        },
			        success: function(data){
			        	setTimeout(function() {
			        		if(data == 'no_user') {
			        			$('.no_user_alert').show();
			        			$('#password_done').hide();
			        		}else {
			        			$('#password_done').show();
			        			$('.no_user_alert').hide();
			        		}
			        		$('input[type="password"]').val('');
			        		$('#progress-modal').modal('hide')
			        	}, 1000);
			        }
			    });				
			}
		});
	},

	editRoleaccess: function() {
		$('#edit-role-btn').click(function(event) {
			event.preventDefault();
			var form = $('#edit-role-form');

			if(form.parsley('validate')) {
				$.ajax({
			        type: 'post',
			        url: form.attr('action'),
			        data: form.serialize(),
			        beforeSend :function(data){
			        	$('#progress-modal').modal();
			        },
			        success: function(data){
			        	setTimeout(function() {
			        		$('#roleaccess').html(data);
			        		$('#role_done').show();
			        		frontendModule.init();
			        		$('#progress-modal').modal('hide');
			        		$('.modal-backdrop').hide();
			        	}, 1000);
			        }
			    });				
			}
		});
	},

	deleteAccount: function() {
		$('.delete-acc').click(function(event) {
			event.preventDefault();
			$('#delete-modal').modal()
			$('#adminpanel-confirm-delete').attr('data-url', $(this).attr('href'));
			$('#adminpanel-confirm-delete').attr('data-id', $(this).attr('id'));
		});

		$('#adminpanel-multi-trash').click(function(event) {
			event.preventDefault();
			var id_list = '';
			if($('.multiple-check:checked').length > 1) {
				$('.multiple-check:checked').each(function(){
					id_list += $(this).val()+',';
				});
				id_list = id_list.substring(0,id_list.length-1);
				$('#adminpanel-confirm-delete').attr('data-id-list', id_list);
			}else {
				$('#adminpanel-confirm-delete').attr('data-id', 'del_'+$('.multiple-check:checked').val());
			}
			$('#adminpanel-confirm-delete').attr('data-url', $(this).attr('href'));
			$('#delete-modal').modal();
		});

		$('#adminpanel-confirm-delete').click(function(event) {
			event.preventDefault();
			var id;
			if($(this).attr('data-id-list')) {
				id = $(this).attr('data-id-list');
				$('#adminpanel-confirm-delete').removeAttr('data-id-list');
			}else {
				var id_txt 	 = $(this).attr('data-id');
				var id_parts = id_txt.split('_');
				id 			 = id_parts[1];
			}

			var url 		= $(this).attr('data-url');

			$.ajax({
		        type: 'post',
		        url: url,
		        data: 'id='+id,
		        beforeSend :function(data){
					$('#delete-modal').modal('hide');
		        	$('#progress-modal').modal();
		        },
		        success: function(data){
		        	setTimeout(function() {
		        		var result = $.parseJSON(data);
		        		$('.admin-table').find('tbody').html(result.userlist);
		        		$('#pagination-panel').html(result.pagination);
		        		//frontendModule.init();
		        		$('#progress-modal').modal('hide');
		        		$('.modal-backdrop').hide();
		        	}, 1000);
		        }
		    });
		});
	}
};

var licenseControl = {
 
    init: function() {
        licenseControl.stepTrigger();
        licenseControl.bindChangeEditForm();
        licenseControl.editProfile();
        licenseControl.addLicense();
        licenseControl.deleteLicense();
        licenseControl.deleteCompany();
        licenseControl.bindSelectCategory();
        licenseControl.bindCheckCompanyname();
        licenseControl.hidePagination();
    },

    hidePagination: function() {
    	if($('#edit-company-form').length > 0) {
    		$('#pagination-panel').hide();
    	}

    	$('a[href="#profile"]').on('click', function(){
    		$('#pagination-panel').hide();
    	});

    	$('a[href="#license"], .page-btn').on('click', function(){
    		$('#pagination-panel').show();
    	});

    	if($('a[href="#license"]').parent().hasClass('active')) {
    		$('#pagination-panel').show();
    	}
    },
	bindCheckCompanyname: function() {
		$('#name').change(function(){
			var company_id = $('input[name="company_id"]').val();
			var check_val  = $(this).val();
			$.ajax({
		        type: 'post',
		        url: $(this).attr('data-check'),
		        data: 'name='+check_val+'&id='+company_id,
		        beforeSend :function(data){
		        	$('#load-name-check').show();
		        },
		        success: function(data){
		        	setTimeout(function() {
			        	$('#load-name-check').hide();
			        	
			        	if(data > 0) {
			        		$('#name-check').val(false);
			        	} else {
			        		$('#name-check').val($('#name').val());
			        	}

			        	$('#name').parsley('validate');
		        	}, 500);
		        }
		    });				
		});
	},

  	bindSelectCategory: function() {
		if( $('#edit-company-form').length > 0 ) {
			var category = $('#category-selected').val();
			$('option[value="'+category+'"]').attr('selected', 'selected');
			$('.select2-chosen').text(category);
		}
  	},

	bindChangeEditForm: function() {
		$("#edit-company-form :input, #edit-company-form select").change(function() {
		   $("#edit-company-form").attr("data-changed",true);
		});

		$('#edit-tab li a').click(function(event){
			event.preventDefault();
			$('.alert-block').hide();
			var changed_form = $('form[data-changed="true"]');
			if(changed_form.length) {
				$('#save-change-modal').modal();
				$('#leave-btn').attr('data-previous-form', changed_form.attr('id'));
				$('#leave-btn').attr('data-previous', '#'+changed_form.closest('.tab-pane').attr('id'));
				$('#leave-btn').attr('data-selected', $(this).attr('href'));
			}
		});

		$('#leave-btn').click(function(event) {
			event.preventDefault();

			var form = $(this).attr('data-previous-form');
			var prev_tab = $(this).attr('data-previous');
			var selected_tab = $(this).attr('data-selected');

			$('#'+form).attr('data-changed', false);
			$('a[href="'+selected_tab+'"]').closest('li').addClass('active');
			$('a[href="'+prev_tab+'"]').closest('li').removeClass('active');

			$(selected_tab).addClass('active');
			$(prev_tab).removeClass('active');
			$('#save-change-modal').modal('hide');
		});
	},

	editProfile: function() {
		$('#edit-company-btn').click(function(event) {
			event.preventDefault();

			var form = $('#edit-company-form');

			if(form.parsley('validate')) {
				$.ajax({
			        type: 'post',
			        url: $(this).attr('href'),
			        data: form.serialize(),
			        beforeSend :function(data){
			        	$('#progress-modal').modal();
			        },
			        success: function(data){
			        	company_id = data;
			            var file = frontendModule.initialLogo;
			            var formdata = new FormData();
						formdata.append("userfile", file);
						formdata.append("company_id", company_id);

						var ajax = new XMLHttpRequest();
		              	ajax.addEventListener("load", function(){
		              		//window.location.href = "http://localhost/swa_dev/licensecontrol";
		              	}, false);
						ajax.open("POST", 'http://localhost/swa_dev/licensecontrol/uploadLogo');
						ajax.send(formdata);	

			        	setTimeout(function() {
			        		$('#profile_done').show();
			        		form.attr('data-changed', false);
			        		$('#progress-modal').modal('hide');
			        	}, 1000);
			        }
			    });				
			}
		});
	},

	addLicense: function() {
		$('#add-license-btn').click(function(event) {
			event.preventDefault();

			var add_no = $("input[name='add_license']");
			var added_val = add_no.val();
			var company_id = $("input[name='company_id']").val();
			if(add_no.parsley('validate')) {
				$.ajax({
			        type: 'post',
			        url: $(this).attr('href'),
			        data: 'company_id='+company_id+'&added_no='+added_val+'&action=add_license',
			        beforeSend :function(data){
			        	$('#progress-modal').modal();
			        },
			        success: function(data){
			        	setTimeout(function() {
			        		var result = $.parseJSON(data);
			        		$('#license').html(result.licenseTable);
			        		$('#pagination-panel').html(result.pagination);
			        		console.log($('#pagination-panel'));

			        		if($('#add_license_done').length > 0) {
			        			$('#add_license_done').show();
			        		}else {
			        			$('#error_license').show();
			        		}

			    			frontendModule.init();
			        		$('#progress-modal').modal('hide');
    						$('#pagination-panel').show();
			        	}, 1000);
			        }
			    });		
			}
		});
	},

	deleteLicense: function() {
		$('.delete-license-btn').click(function(event) {
			event.preventDefault();

			$('#delete-modal').modal();
			$('#licensecontrol-confirm-delete').attr('data-url', $(this).attr('href'));
			$('#licensecontrol-confirm-delete').attr('data-id', $(this).attr('id'));
		});


		$('#licensecontrol-multi-trash').click(function(event) {
			event.preventDefault();
			var id_list = '';
			if($('.multiple-check:checked').length > 1) {
				$('.multiple-check:checked').each(function(){
					id_list += $(this).val()+',';
				});
				id_list = id_list.substring(0,id_list.length-1);
				$('#licensecontrol-confirm-delete').attr('data-id-list', id_list);
			}else {
				$('#licensecontrol-confirm-delete').attr('data-id', $('.multiple-check:checked').val());
			}
			$('#licensecontrol-confirm-delete').attr('data-url', $(this).attr('href'));
			$('#delete-modal').modal();
		});


		$('#licensecontrol-confirm-delete').click(function(event){
			event.preventDefault();
			$('#delete-modal').modal('hide')		
			var company_id = $("input[name='company_id']").val();

			var productkey_id = '', player_id = '';
			if($(this).attr('data-id-list')) {
				var id_list = $(this).attr('data-id-list');
				var id_ele  = id_list.split(',');
				for(var i=0; i<id_ele.length; i++){
					var id_parts = id_ele[i].split('_');
					productkey_id += id_parts[0];

					if(id_parts[1]) {
						player_id     += id_parts[1];
					}

					if (i < id_ele.length-1) {
						productkey_id += ',';

						if(id_parts[1]) {
							player_id += ',';
						}						
					}
				}

				$('#licensecontrol-confirm-delete').removeAttr('data-id-list');
			}else {
				var id = $(this).attr('data-id');
				var id_parts = id.split('_');

				productkey_id = id_parts[0];
				player_id     = id_parts[1];
			}
			var url 		= $(this).attr('data-url');	

			$.ajax({
			    type: 'post',
			    url: url,
			    data: 'company_id='+company_id+'&key_id='+productkey_id+'&player_id='+player_id+'&action=del_license',
			    beforeSend :function(data){
			    	$('#progress-modal').modal();
			    },
			    success: function(data){
			    	setTimeout(function() {
		        		var result = $.parseJSON(data);
		        		$('#license').html(result.licenseTable);
		        		$('#pagination-panel').html(result.pagination);

			    		$('#del_license_done').show();
			    		frontendModule.init();
			    		$('#progress-modal').modal('hide');
    					$('#pagination-panel').show();
			    	}, 1000);
			    }
			});
		});
	},

    saveCompany: function() {

    	var form1 = $("#initial-1-form"),
    		form2 = $("#initial-2-form"),
    		form3 = $("#initial-3-form"),
	    	formData1 = form1.serialize(),
	    	formData2 = form2.serialize(),
	    	formData3 = form3.serialize();

	    var formData = formData1+'&'+formData2+'&'+formData3;

		$.ajax({
	        type: 'post',
	        url: 'createCompany',
	        data: formData,
		    beforeSend :function(data){
		    	$('#progress-modal').modal();
		    },
	        success: function(data){
			    setTimeout(function() {
		        	var company_id = data;
		            var file = frontendModule.initialLogo;
		            var formdata = new FormData();
					formdata.append("userfile", file);
					formdata.append("company_id", company_id);

					var ajax = new XMLHttpRequest();
	              	ajax.addEventListener("load", function(){
						$('#progress-modal').modal('hide');
	              		window.location.href = "http://localhost/swa_dev/licensecontrol";
	              	}, false);
					ajax.open("POST", 'uploadLogo');
					ajax.send(formdata);
				}, 1000);
	        }
	    });
    },

    deleteCompany: function() {
    	$('.delete-company').on('click', function(event) {
			event.preventDefault();

			$('#delete-modal').modal();
			$('#companycontrol-confirm-delete').attr('data-url', $(this).parent().attr('href'));
			$('#companycontrol-confirm-delete').attr('data-id', $(this).parent().attr('id'));
    	});

		$('#companycontrol-multi-trash').click(function(event) {
			event.preventDefault();
			var id_list = '';
			if($('.multiple-check:checked').length > 1) {
				$('.multiple-check:checked').each(function(){
					id_list += $(this).val()+',';
				});
				id_list = id_list.substring(0,id_list.length-1);
				$('#companycontrol-confirm-delete').attr('data-id-list', id_list);
			}else {
				$('#companycontrol-confirm-delete').attr('data-id', $('.multiple-check:checked').val());
			}
			$('#companycontrol-confirm-delete').attr('data-url', $(this).attr('href'));
			$('#delete-modal').modal();
		});

    	$('#companycontrol-confirm-delete').on('click', function(event) {
			event.preventDefault();

			var id;
			if($(this).attr('data-id-list')) {
				id = $(this).attr('data-id-list');
				id = encodeURIComponent(id);
				$('#companycontrol-confirm-delete').removeAttr('data-id-list');
			}else {
				id 			 = $(this).attr('data-id');
			}

			var url = $(this).attr('data-url')+id;
    		$('#delete-modal').modal('hide');

			$.ajax({
			    type: 'post',
			    url: url,
			    beforeSend :function(data){
			    	$('#progress-modal').modal();
			    },
			    success: function(data){
			    	setTimeout(function() {
		        		var result = $.parseJSON(data);
		        		$('#company-list').html(result.companylist);
		        		$('#pagination-panel').html(result.pagination);

		        		$('#del_company_done p').text(result.company+' has been deleted.');
			    		$('#del_company_done').show();
			    		frontendModule.init();
			    		$('#progress-modal').modal('hide');
			    	}, 1000);
			    }
			}); 	
    	});
    },

    stepTrigger: function() {
    	$('.btn-next').on('click', function(event){
			event.preventDefault();
    		//$('.wizard').wizard('next','foo');
    		var step  = $('.wizard').wizard('selectedItem').step;
			var form  = $("#initial-"+step+"-form");
			if(form.parsley('validate')) {
				$('.wizard').wizard('next','foo');
				if( step == 3 ){
					licenseControl.saveCompany();
				}
			}

    	});
    },
};
	
$( document ).ready( frontendModule.init );