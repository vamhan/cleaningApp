<script type="text/javascript">

	function preventNumber(evt) {
		var theEvent = evt || window.event;
		var key = theEvent.keyCode || theEvent.which;
		key = String.fromCharCode( key );
		var regex = /[0-9]|\./;
		if( !regex.test(key) ) {
		  theEvent.returnValue = false;
		  if(theEvent.preventDefault) theEvent.preventDefault();
		}
	}

	function del_holiday () {
		$('.del_holiday').off();
		$('.del_holiday').on('click', function() {
			$(this).closest('.row').remove();
		});
	}

	$(document).ready(function(){
		$('.datetimepicker_input').each(function() {
			var year = $(this).data('year');
			var mindate = new Date((year-1)+'-12-31');
			var maxdate = new Date(year+'-12-31');

		    $(this).datetimepicker({
		    	useCurrent: false,
		        pickTime: false,
		        defaultDate : '01/01/'+year,
		        minDate : mindate,
		        maxDate : maxdate,
		        icons: {
					time: "fa fa-clock-o",
					date: "fa fa-calendar",
					up: "fa fa-arrow-up",
					down: "fa fa-arrow-down"
			    }
		    });

		    $(this).find('input').val('')

		});

	    $('.datetimepicker_input').on("dp.change",function (e) {
	      var dateObj = new Date(e.date);

	      var year  = dateObj.getFullYear();
	      var month = (dateObj.getMonth()+1).toString();
	      if (month.length == 1) {
	        month = '0'+month;
	      }
	      var day   = dateObj.getDate().toString();
	      if (day.length == 1) {
	        day = '0'+day;
	      }

	      $(this).prev().val(year+'-'+month+'-'+day);

	    });

	    $('.holiday_date').each(function() {
	    	if ($(this).val() != '0000-00-00') {

	    		var date = new Date($(this).val());
	    		$(this).next().data("DateTimePicker").setDate(date.getDate()+"."+(date.getMonth()+1)+"."+date.getFullYear());
	    	}
	    });

	    del_holiday();
	});

	$('.add_more_holiday').on('click', function () {

		var modal = $(this).closest('.modal');
		var year  = modal.data('year');
		var form  = modal.find('form');

		var title = modal.find('.add_holiday_title').val();
		var date  = modal.find('.add_holiday_date').val();

		var count = form.find('.row').length;

		var row = 	'<div class="row m-b-sm m-l-sm m-r-sm">'+
	                  	'<div class="col-sm-6 font-bold">'+title+'</div>' +
	              		'<div class="col-sm-5">'+
	                  		'<input type="hidden" name="title_'+count+'" value="'+title+'"/>'+
	                  		'<input type="hidden" class="holiday_date" name="date_'+count+'" value="'+date+'"/>'+
	                  		'<div class="input-group date datetimepicker_input" data-count="'+count+'" data-year="'+year+'" data-date-format="DD.MM.YYYY">'+
	                      		'<input type="text" autocomplete="off" class="form-control" disabled/>'+
	                      		'<span class="input-group-addon"><i class="fa fa-calendar"></i></span>'+
	                  		'</div>'+
	              		'</div>'+
	              		'<div class="col-sm-1 text-right">'+
	                  		'<a href="#" class="btn btn-default del_holiday"><i class="fa fa-trash-o"></i></a>'+
	              		'</div>'+
	            	'</div>';

	    form.append(row);
	    del_holiday();

	    var date_obj = $('.datetimepicker_input[data-count="'+count+'"]');
	    var dateVal = new Date(date);
		var year = date_obj.data('year');
		var mindate = new Date((year-1)+'-12-31');
		var maxdate = new Date(year+'-12-31');

	    date_obj.datetimepicker({
	    	useCurrent: false,
	        pickTime: false,
	        minDate : mindate,
	        maxDate : maxdate,
	        icons: {
				time: "fa fa-clock-o",
				date: "fa fa-calendar",
				up: "fa fa-arrow-up",
				down: "fa fa-arrow-down"
		    }
	    });

	    date_obj.data("DateTimePicker").setDate(dateVal.getDate()+"."+(dateVal.getMonth()+1)+"."+dateVal.getFullYear());

		modal.find('.add_holiday_title').val('');
	    modal.find('.add_holiday_date').next().data("DateTimePicker").setDate("01.01."+year);
	    modal.find('.add_holiday_date').val('0000-00-00');
	    modal.find('.add_holiday_date').next().find('input').val('');
	});

	$('#create_holiday_year input[name="year"]').on('keypress', function() {
		preventNumber(event);
	});

	$('#create_holiday_year input[name="year"]').on('keyup', function() {
		if ($(this).val() != '' && $(this).val().length == 4) {
			$(this).css('border-color', '#d4d4d4');
			$('.create_holiday_btn').removeAttr('disabled');
		}
	});

	$('.create_holiday_btn').on('click', function() {

		var modal = $($(this).data('parent'));
		var url   = modal.data('url');
		var year  = modal.find('input[name="year"]').val();

		if (year != '' && year.length == 4) {
			console.log(url);
			$.ajax(url , {
				type: 'post',
				data: 'year='+year
			}).done(function (data) {

				if (data == 'exist') {
					$('.create_holiday_btn').attr('disabled', true);
					modal.find('input[name="year"]').css('border-color', 'red');
				} else {
					window.location.href = "<?php echo base_url('__cms_data_manager/holiday_management'); ?>";
				} 
			});

			$(this).attr('disabled', true);
		} else {
			modal.find('input[name="year"]').css('border-color', 'red');
		}

		return false;
  	});

  	$('.edit_holiday_btn').on('click', function () {
  		$(this).attr('disabled', true);
  		var parent_id = $(this).data('parent');
  		var parent    = $(parent_id);
  		var form      = parent.find('form');

  		form.submit();
  	});
</script>