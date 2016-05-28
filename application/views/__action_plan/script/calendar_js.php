<script type="text/javascript">

!function ($) {

  /**************************************************************/
  /******************* Done Typing Function**********************/
  /**************************************************************/
  $.fn.extend({
      donetyping: function(callback,timeout){
          timeout = timeout || 1e3; // 1 second default timeout
          var timeoutReference,
              doneTyping = function(el){
                  if (!timeoutReference) return;
                  timeoutReference = null;
                  callback.call(el);
              };
          return this.each(function(i,el){
              var $el = $(el);
              // Chrome Fix (Use keyup over keypress to detect backspace)
              // thank you @palerdot
              $el.is(':input') && $el.on('keyup keypress',function(e){
                  // This catches the backspace button in chrome, but also prevents
                  // the event from triggering too premptively. Without this line,
                  // using tab/shift+tab will make the focused element fire the callback.
                  if (e.type=='keyup' && e.keyCode!=8) return;
                  
                  // Check if timeout has been set. If it has, "reset" the clock and
                  // start over again.
                  if (timeoutReference) clearTimeout(timeoutReference);
                  timeoutReference = setTimeout(function(){
                      // if we made it here, our timeout has elapsed. Fire the
                      // callback
                      doneTyping(el);
                  }, timeout);
              }).on('blur',function(){
                  // If we can, fire the event since we're leaving the field
                  doneTyping(el);
              });
          });
      }
  });

  $(function(){

    var months = ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];

    /**************************************************************/
    /*************** Add Action Plan to Calendar ******************/
    /**************************************************************/
    var holidayArray = []; 
    var holydayTitleArray = [];
    var actionArray = [];
    <?php
      if (!empty($action_list)) {
        foreach ($action_list as $action) {
          $text_class = 'text-danger';
          if ($action['status'] == 'plan') {
            $text_class = 'text-primary';
          }

          $blue_label = "";
          if ($action['blue_label'] == 1) {
            $blue_label = "<i class='fa fa-circle text-info'>&nbsp;</i>";
          }
    ?>  
          actionArray.push({title:"<span data-title='<?php echo strtolower($action['title']); ?>' data-actor='<?php echo $action['actor_id']; ?>' data-ismanager='<?php echo $action['is_manager']; ?>' data-actor='<?php echo strtolower($action['actor_name']); ?>'  data-shipto='<?php echo $action['ship_to_id']; ?>' data-deptid='<?php echo $action['department_id']; ?>' data-moduleid='<?php echo $action['event_category_id']; ?>'  data-status='<?php echo $action['status']; ?>'><i class='fa fa-circle <?php echo $text_class; ?>'>&nbsp;</i><?php echo $blue_label; ?> <?php if (!empty($action['ship_to_id'])) { echo $action['ship_to_id'].' ( '.$action['actor_name'].' ) : '; } echo $action['title']; ?></span>", start: new Date('<?php echo $action["plan_date"]; ?>'), action_id: '<?php echo $action["id"].'_'.$action["is_manager"]; ?>'});
    <?php
        }
      }
    ?>

    /**************************************************************/
    /***************** Add Holiday to Calendar ********************/
    /**************************************************************/
    <?php
      if (!empty($holiday_list)) {
        foreach ($holiday_list as $holiday) {
    ?>  
          holidayArray.push('<?php echo $holiday["date"]; ?>');
          holydayTitleArray.push('<?php echo $holiday["title"]; ?>');
    <?php
        }
      }
    ?>

    // fullcalendar
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();

    $('#sel_month option[value="'+(m+1)+'"]').prop('selected', 'selected');
    var addDragEvent = function($this){
      var eventObject = {
        title: $.trim($this.text()),
        className: $this.attr('class').replace('label','')
      };
      
      $this.data('eventObject', eventObject);
      
      $this.draggable({
        zIndex: 999,
        revert: true,     
        revertDuration: 0 
      });
    };


    /**************************************************************/
    /********************* Initial Calendar ***********************/
    /**************************************************************/
    $('.calendar').each(function() {
      $(this).fullCalendar({
        header: false ,
        dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
        dayNamesShort: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
        dayClick: function(date, jsEvent, view) {
          var today = new Date();

          if ( ( date.getFullYear() > today.getFullYear() ) || ( date.getFullYear() == today.getFullYear() && date.getMonth() > today.getMonth() ) || (  date.getFullYear() == today.getFullYear() && date.getMonth() == today.getMonth() && date.getDate() >= today.getDate() )) {

            var list = $('#modal-addActionplan ul.prospect_list');
            list.find('li').remove();
            list.parent().removeClass('open');

            /**************************************************************/
            /************************ Clear Modal *************************/
            /**************************************************************/
            var select_part = $('#modal-addActionplan select[name="sequence"]');
            select_part.find('option').remove();
            select_part.attr('disabled', true);
            $('#modal-addActionplan .all_parts').text('');
            $('#modal-addActionplan .type_alert').hide();
            $('#modal-addActionplan select[name="event_category_id"] option:first').prop('selected', true);

            $('#modal-addActionplan .event_title').val('');
            $('#modal-addActionplan .event_title').data('default', 1);
            $('#modal-addActionplan .event_title').css('border-color', '#d4d4d4');
            $('#modal-addActionplan .ship_to_id').val('');
            $('#modal-addActionplan .clear_job_category option:first').prop('selected', true);
            $('#modal-addActionplan .clear_job_type option:first').prop('selected', true);
            $('#modal-addActionplan .staff_input').val('');
            $('#modal-addActionplan .total_staff_input').val('');
            $('#modal-addActionplan .remark').val('');

            $('#modal-addActionplan .visitation_reason option:first').prop('selected', true);
            $('#modal-addActionplan .contact_type option:first').prop('selected', true);
            $('#modal-addActionplan .action_tab li').removeClass('active');
            $('#modal-addActionplan .action_tab li:first').addClass('active');

            $('#modal-addActionplan .tab-pane').removeClass('active');
            $('#modal-addActionplan .tab-pane:first').addClass('active');

            $('#modal-addActionplan .part_alert').hide();
            $('#modal-addActionplan .event_category').css('border-color', '#d4d4d4');


            $('#modal-addActionplan .clear_job_category_div, #modal-addActionplan .clear_job_type_div, #modal-addActionplan .staff_div').hide();

            /**************************************************************/
            /********************** Set Create Time ***********************/
            /**************************************************************/
            // console.log(date);
            $('#datetimepicker5').data("DateTimePicker").setDate(date.getDate()+"."+(date.getMonth()+1)+"."+date.getFullYear());
            if ($('#datetimepicker30').length > 0) {
              $('#datetimepicker30').data("DateTimePicker").setDate(date.getDate()+"."+(date.getMonth()+1)+"."+date.getFullYear());
            }

            $('#modal-addActionplan').modal();
          }

        },
        events: actionArray
      });

      /**************************************************************/
      /********************* Open session month *********************/
      /**************************************************************/
      <?php
        if ($this->session->userdata('calendar_month') != '' && $this->session->userdata('calendar_year') != '') {
      ?>
          var month = "<?php echo $this->session->userdata('calendar_month'); ?>";

          if (month.length == 1) {
            month = '0'+month;
          }
          var year = "<?php echo $this->session->userdata('calendar_year'); ?>";
          $('.calendar').fullCalendar( 'gotoDate', new Date(year+'-'+month+'-01') );
          var date = $('.calendar').fullCalendar( 'getDate' );
          $('#current_month').text(months[date.getMonth()]);
          $('#current_month').data('id', date.getMonth()+1)
          $('#sel_month option[value="'+(date.getMonth()+1)+'"]').prop('selected', 'selected');
          $('#sel_year option[value="'+date.getFullYear()+'"]').prop('selected', 'selected');
          bindEvent();
          bindFilter();
          renderCalendarView();
      <?php
        }
      ?>

    });

    $(document).on('click', '#dayview', function() {
      $('.calendar').fullCalendar('changeView', 'agendaDay');
      bindEvent();
      bindFilter();
      renderCalendarView();
    });

    function renderCalendarView () {
      $('.fc-day').each(function() {
        var today = new Date();
        var date  = new Date($(this).data('date'));

        if ( ( date.getFullYear() > today.getFullYear() ) || ( date.getFullYear() == today.getFullYear() && date.getMonth() > today.getMonth() ) || (  date.getFullYear() == today.getFullYear() && date.getMonth() == today.getMonth() && date.getDate() >= today.getDate() )) {
          $(this).css('background-color', 'white'); 
          $(this).css('cursor', 'pointer');
          if (date.getFullYear() == today.getFullYear() && date.getMonth() == today.getMonth() && date.getDate() == today.getDate()) {
            $(this).css('background-color', '#FFF1F1');
          }
        } else {
          $(this).css('background-color', '#F2F2F5');
        }


        if (holidayArray.indexOf($(this).data('date')) > 0) {
          var index = holidayArray.indexOf($(this).data('date'));
          $(this).css('background-color', 'red');
          $(this).attr('title', holydayTitleArray[index]);
        } 
      });
    }

    function bindFilter () {

      var search_text_title = $('.filter_search').val()!='' ? '[data-title*="'+$('.filter_search').val().toLowerCase()+'"]' : '';
      var search_text_actor = $('.filter_search').val()!='' ? '[data-actor*="'+$('.filter_search').val().toLowerCase()+'"]' : '';
      var search_ship_to    = $('.filter_ship_to').val()!='0' ? '[data-shipto="'+$('.filter_ship_to').val()+'"]' : '';
      var search_department = $('.filter_department').val()!='0' ? '[data-deptid="'+$('.filter_department').val()+'"]' : '';
      var search_employee   = $('.filter_employee').val()!='0' ? '[data-actor="'+$('.filter_employee').val()+'"]' : '';
      var search_category   = $('.filter_category').val()!='0' ? '[data-moduleid="'+$('.filter_category').val()+'"]' : '';
      var search_status     = $('.filter_status').val()!='0' ? '[data-status="'+$('.filter_status').val()+'"]' : '';

      if ($('.filter_category').val() == 'manager') {
        search_category = '[data-ismanager="1"]';
      }

      $('.fc-event-title span').closest('.fc-event').hide();
      $('.fc-event-title span'+search_text_title+search_ship_to+search_department+search_employee+search_category+search_status).closest('.fc-event').show();


      $('.filter select').off();
      $('.filter select').on('change', function() {
        var search_text_title = $('.filter_search').val()!='' ? '[data-title*="'+$('.filter_search').val().toLowerCase()+'"]' : '';
        var search_text_actor = $('.filter_search').val()!='' ? '[data-actor*="'+$('.filter_search').val().toLowerCase()+'"]' : '';
        var search_ship_to    = $('.filter_ship_to').val()!='0' ? '[data-shipto="'+$('.filter_ship_to').val()+'"]' : '';
        var search_department = $('.filter_department').val()!='0' ? '[data-deptid="'+$('.filter_department').val()+'"]' : '';
        var search_employee   = $('.filter_employee').val()!='0' ? '[data-actor="'+$('.filter_employee').val()+'"]' : '';
        var search_category   = $('.filter_category').val()!='0' ? '[data-moduleid="'+$('.filter_category').val()+'"]' : '';
        var search_status     = $('.filter_status').val()!='0' ? '[data-status="'+$('.filter_status').val()+'"]' : '';

        if ($(this).hasClass('filter_department') && $('.filter_department').val() != 0) {
          $('.filter_employee option:first').prop('selected', 'selected');
          $('.filter_employee option:not(:first)').hide();
          $('.filter_employee option[data-dept*="'+$('.filter_department').val()+'"]').show();
        } else if ($(this).hasClass('filter_department') && $('.filter_department').val() == 0) {
          $('.filter_employee option:first').prop('selected', 'selected');
          $('.filter_employee option').show();
        }

        $('.fc-event-title span').closest('.fc-event').hide();
        $('.fc-event-title span'+search_text_title+search_ship_to+search_department+search_employee+search_category+search_status).closest('.fc-event').show();
      });

      $('.filter_search').off();
      $('.filter_search').on('keyup', function() {
        var search_text_title = $('.filter_search').val()!='' ? '[data-title*="'+$('.filter_search').val().toLowerCase()+'"]' : '';
        var search_text_actor = $('.filter_search').val()!='' ? '[data-actor*="'+$('.filter_search').val().toLowerCase()+'"]' : '';
        var search_ship_to    = $('.filter_ship_to').val()!='0' ? '[data-shipto="'+$('.filter_ship_to').val()+'"]' : '';
        var search_department = $('.filter_department').val()!='0' ? '[data-deptid="'+$('.filter_department').val()+'"]' : '';
        var search_employee   = $('.filter_employee').val()!='0' ? '[data-actor="'+$('.filter_employee').val()+'"]' : '';
        var search_category   = $('.filter_category').val()!='0' ? '[data-moduleid="'+$('.filter_category').val()+'"]' : '';
        var search_status     = $('.filter_status').val()!='0' ? '[data-status="'+$('.filter_status').val()+'"]' : '';

        if ($('.filter_category').val() == 'manager') {
          search_category = '[data-ismanager="1"]';
        }

        $('.fc-event-title span').closest('.fc-event').hide();
        $('.fc-event-title span'+search_text_title+search_ship_to+search_department+search_employee+search_category+search_status).closest('.fc-event').show();
      });
    }

    function bindEvent() {

      $('.fc-event').css('cursor', 'pointer');
      $('.fc-event').off();
      $('.fc-event').on('click', function() {
        var parts = $(this).data('id');
            parts = parts.split('_');
        var id    = parts[0];
        $.ajax("<?php echo site_url($this->page_controller.'/get_action_info');  ?>", {
          type: 'post',
          data: 'id='+id,
          beforeSend: function() {
            $('#modal-editActionplan').modal();
            $('#modal-editActionplan > div').hide();
            $('#modal-editActionplan .loading_div').show();
          }
        }).done(function (data) {
          if (data.length > 0) {
            var result_list = JSON.parse(data);
                result = result_list['action_plan'];

            <?php
              $emp_id = $this->session->userdata('id');
            ?>
            var emp_id = '<?php echo $emp_id; ?>';

            //Stop Loading
            $('#modal-editActionplan .loading_div').hide();
            $('#modal-editActionplan .view_data').show();

            //Declare Plan Date
            var plan_date   = new Date(result['plan_date']);
            plan_date.setHours(0);
            plan_date.setMinutes(0);
            plan_date.setSeconds(0);
            plan_date.setMilliseconds(0);
            // Declare Today
            var today  = new Date();
            today.setHours(0);
            today.setMinutes(0);
            today.setSeconds(0);
            today.setMilliseconds(0);

            var edit_plan = $('#modal-editActionplan #edit_plan');
            var duplicate_panel = $('#modal-editActionplan #duplicate_panel');
            var project_end = result['project_end'];

            //Assign Value
            $('#modal-delActionplan form .id').val(result['id']);
            $('#modal-editActionplan .id').val(result['id']);
            $('#modal-editActionplan .actor').val(result['actor_name']);
            $('#modal-editActionplan .department').val(result['department_name']);
            $('#modal-editActionplan input.event_category').val(result['event_category_id']);
            $('#modal-editActionplan .event_category option[value="'+result['event_category_id']+'"]').prop('selected', true);
            $('#modal-editActionplan .remark').val(result['remark']);
            $('#modal-editActionplan .event_title').val(result['title']);
            $('#modal-editActionplan #duplicate_plan .event_title').val("Copy of "+result['title']);

            //Action Plan Sequence
            if (result['sequence'] != undefined) {
                $('#modal-editActionplan .sequence').val(result['sequence']);
                $('#modal-editActionplan .sequence').closest('.form-group').show();

                $('#modal-editActionplan #duplicate_plan select[name="sequence"]').closest('.form-group').show();
                var select_part = $('#duplicate_plan select[name="sequence"]');
                select_part.find('option').remove();
                select_part.attr('disabled', true);
                $('#modal-editActionplan #duplicate_plan .all_parts').text('');

                var part_list = result_list['user_marked'];
                var all_user_marked = result_list['all_user_marked'];
                if (part_list != 0) {
                  select_part.removeAttr('disabled');
                  for (var i in part_list) {
                    var part = part_list[i];
                    select_part.append('<option value="'+part['sequence']+'">'+part['sequence']+'</option>');
                  }
                  $('#modal-editActionplan #duplicate_plan .all_parts').text('/ '+all_user_marked);
                  $('#modal-editActionplan .duplicate_btn').removeAttr('disabled');
                } else {
                  $('#modal-editActionplan .duplicate_btn').attr('disabled', true);
                  select_part.attr('disabled', true);
                  $('#modal-editActionplan #duplicate_plan .all_parts').text('ไม่สามารถเพิ่มแผนการตรวจได้');
                }
            } else {
                $('#modal-editActionplan .sequence').closest('.form-group').hide();
                $('#modal-editActionplan #duplicate_plan select[name="sequence"]').closest('.form-group').hide();
            }

            //If event is visitation, Append visitation event to dropdown
            if (result['event_category_id'] == 4) {
                $('#modal-editActionplan .event_category').append('<option value="'+result['event_category_id']+'"><?php echo freetext("customer_visitation"); ?></option>');
                $('#modal-editActionplan .event_category option[value="'+result['event_category_id']+'"]').prop('selected', true);
                $('#modal-editActionplan .visit_reason_div').show();
                $('#modal-editActionplan .visitation_reason option[value="'+result['visitation_reason_id']+'"]').prop('selected', true);
                $('#modal-editActionplan .contact_type option[value="'+result['contact_type']+'"]').prop('selected', true);
            } else {
                $('#modal-editActionplan .event_category option[value="4"]').remove();
                $('#modal-editActionplan .visit_reason_div').hide();
                $('#modal-editActionplan .visitation_reason option:first').prop('selected', true);
                $('#modal-editActionplan .contact_type option:first').prop('selected', true);
            }

            //If Prospect action plan
            if (result['ship_to_id'] == 0) {
                $('#modal-editActionplan .ship_to_name').val('');
                $('#modal-editActionplan .contract_id').val('');
                if (result['prospect_id'] != undefined) {
                  $('#modal-editActionplan input[name="prospect_id"]').val(result['prospect_id']);
                  if (result['prospect_name'] != undefined) {
                    $('#modal-editActionplan .prospect_id').val(result['prospect_name']);
                  }
                }
                $('#modal-editActionplan .ship_to_name').closest('.form-group').hide();
                $('#modal-editActionplan .prospect_id').closest('.form-group').show();
            } else {
              $('#modal-editActionplan .ship_to_name').val(result['ship_to_id']+' : '+result['ship_to_name']);
              $('#modal-editActionplan .contract_id').val(result['contract_id']);

              $('#modal-editActionplan input[name="prospect_id"]').val('');
              $('#modal-editActionplan .prospect_id').val('');

              $('#modal-editActionplan .ship_to_name').closest('.form-group').show();
              $('#modal-editActionplan .prospect_id').closest('.form-group').hide();
            }

            //If Clear Job
            if (result['clear_job_type_id'] != 0) {
              $('#modal-editActionplan .go_to_btn').hide();

              //Reset element
              $('#modal-editActionplan .clear_job_category').css('border-color', '#d4d4d4');

              //Hide duplicate Panel
              $('#modal-editActionplan a[href="#duplicate_panel"]').closest('li').hide();

              //Show actual date input
              $('.edit_actual_date_div').show();      

              //IF Category is not null
              if (result['clear_job_category_id'] != 0) {
                $('#modal-editActionplan .clear_job_category option[value="'+result['clear_job_category_id']+'"]').prop('selected', true);
              }

              //IF Type is not null
              if (result['clear_job_type_id'] != 0 && result['clearjob_frequency'] != 0) {
                var clear_job_text = result['clear_type_title']+' '+result['clearjob_frequency']+' เดือน';
                $('#modal-editActionplan .clear_job_type_input').val(result['clear_job_type_id']);
                $('#modal-editActionplan .clear_job_type').val(clear_job_text);
                $('#modal-editActionplan .frequency_input').val(result['clearjob_frequency']);
              }

              //IF Staff is not null
              if (result['staff'] != '') {
                $('#modal-editActionplan .staff_input').attr('disabled', true);
                $('#modal-editActionplan .staff_input').val(result['staff']);
              }

              //IF Total Staff is not null
              if (result['total_staff'] != '') {
                $('#modal-editActionplan .total_staff_input').val(result['total_staff']);
              }

              //Show Clear Job Panel
              $('#modal-editActionplan .clear_job_category_div, #modal-editActionplan .clear_job_type_div, #modal-editActionplan .staff_div, #modal-editActionplan .total_staff_div').show();
              $('#modal-editActionplan .clear_job_type, #modal-editActionplan .staff_input').attr('disabled', true);

            } else {
              //Show duplicate panel
              $('#modal-editActionplan a[href="#duplicate_panel"]').closest('li').show();

              //Reset Duplicate Datepicker
              var plan_date_obj = duplicate_panel.find('.plan_date');
              var plan_date_val = new Date(result['plan_date']);
              var datepicker = plan_date_obj.next();
              var date_picker_id = datepicker.attr('id');

              if (project_end != "") {
                datepicker.remove();

                plan_date_obj.after('<div class="input-group date" id="'+date_picker_id+'" data-date-format="DD.MM.YYYY"><input type="text" class="form-control" disabled/><span class="input-group-addon"><i class="fa fa-calendar"></i></span></div>');

                var today_date =new Date();
                var min_date = new Date();
                min_date.setDate(today_date.getDate() - 1);
                $('#'+date_picker_id).datetimepicker({
                    pickTime: false,
                    minDate: min_date,
                    maxDate: new Date(project_end),
                    icons: {
                    time: "fa fa-clock-o",
                    date: "fa fa-calendar",
                    up: "fa fa-arrow-up",
                    down: "fa fa-arrow-down"
                  }
                });

                $('#'+date_picker_id).on("dp.change",function (e) {
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

                  $(this).find('input').css('border-color', '#d4d4d4');
                  $(this).parent().find('.plan_date').val(year+'-'+month+'-'+day);

                  var form = $(this).closest('form');
                  var is_default = form.find('.event_title').data('default');
                  var title = form.find('.event_title').val();
                  var event_cat_id = form.find('.event_category').val();
                  if (is_default == 1 && (event_cat_id != 0 && event_cat_id != 12 && event_cat_id != undefined)) {
                    var event_cat    = form.find('.event_category option[value="'+event_cat_id+'"]').text();
                    form.find('.event_title').val(event_cat+' ['+months[dateObj.getMonth()]+' '+dateObj.getFullYear()+']');
                  }
                  if (event_cat_id == 12) {

                    var area_id     = form.find('.clear_job_type').val();
                    if (is_default == 1 && (area_id != 0 && area_id != undefined)) {
                      var area_name    = form.find('.clear_job_type option[value="'+area_id+'"]').text();
                      form.find('.event_title').val(area_name+' ['+months[dateObj.getMonth()]+' '+dateObj.getFullYear()+']');
                    } else if (is_default == 1) {
                      form.find('.event_title').val('');
                    }
                  }
                });

              }

              var plan_month = (plan_date_val.getMonth()+1).toString();
              if (plan_month.length == 1) {
                plan_month = '0'+plan_month;
              }

              $('#'+date_picker_id).data("DateTimePicker").setDate(plan_date_val.getDate()+"."+plan_month+"."+plan_date_val.getFullYear());

              //Hide actual date
              $('.edit_actual_date_div').hide();

              //Reset Clear Job Value
              $('#modal-editActionplan .clear_job_category option:first').prop('selected', true);
              $('#modal-editActionplan .clear_job_type option:first').prop('selected', true);
              $('#modal-editActionplan .staff_input').val('');
              $('#modal-editActionplan .total_staff_input').val('');
              $('#modal-editActionplan .clear_job_category_div, #modal-editActionplan .clear_job_type_div, #modal-editActionplan .staff_div, #modal-editActionplan .total_staff_div').hide();
            }

            //Already has actual_date
            if (result['object_table'] == 'tbt_fix_claim' || (plan_date.getMonth() != today.getMonth() && plan_date.getFullYear() != today.getFullYear()) || result['actor_id'] != emp_id || (result['actual_date'] != undefined && result['actual_date'] != '0000-00-00' && result['actual_date'] != '' && result['actual_date'] !=  null)){                                               

                if (result['actual_date'] != null && result['actual_date'] != undefined && result['actual_date'] != '0000-00-00') {

                  var actual_date   = new Date(result['actual_date']);
                  var date = actual_date.getDate().toString();
                  if (date.length == 1) {
                    date = '0'+date;
                  }
                  var month = (actual_date.getMonth()+1).toString();
                  if (month.length == 1) {
                    month = '0'+month;
                  }
                  var year = actual_date.getFullYear();

                  $('#modal-editActionplan #edit_plan input[name="actual_date"]').val(date+"."+month+"."+year);

                  //Hide datepicker
                  $('#modal-editActionplan #edit_plan input[name="actual_date"]').attr('type', 'text');
                  $('#modal-editActionplan #edit_plan input[name="actual_date"]').prop('disabled', true);
                  $('.edit_actual_date_div').show();
                  $('#edit_actual_date').hide();

                }

                //Hide datepicker    
                var datepicker = $('#modal-editActionplan #edit_plan input[name="plan_date"]').next();
                datepicker.hide();
                var date = plan_date.getDate().toString();
                if (date.length == 1) {
                  date = '0'+date;
                }
                var month = (plan_date.getMonth()+1).toString();
                if (month.length == 1) {
                  month = '0'+month;
                }

                var year = plan_date.getFullYear();
                $('#modal-editActionplan #edit_plan input[name="plan_date"]').val(date+"."+month+"."+year);
                $('#modal-editActionplan #edit_plan input[name="plan_date"]').attr('type', 'text');
                $('#modal-editActionplan #edit_plan input[name="plan_date"]').prop('disabled', true);
              
                $('#modal-editActionplan #edit_plan .visitation_reason, #modal-editActionplan #edit_plan .contact_type, #modal-editActionplan .edit_btn, #modal-editActionplan #edit_plan .event_title, #modal-editActionplan #edit_plan .remark, #modal-editActionplan .clear_job_category, #modal-editActionplan .total_staff_input').attr('disabled', true);
                $('#modal-editActionplan .del_btn').closest('li').hide();
                $('#modal-editActionplan .action_tab').hide();

                $('#modal-editActionplan #edit_plan .event_category').hide();
                $('#modal-editActionplan #edit_plan .module_name').val(result['module_name']);
                $('#modal-editActionplan #edit_plan .module_name').attr('type', 'text');
            } else {

                $('#modal-editActionplan #edit_plan input[name="actual_date"]').attr('type', 'hidden');
                $('#modal-editActionplan #edit_plan input[name="actual_date"]').removeAttr('disabled');
                $('#edit_actual_date').show();
                
                $('#modal-editActionplan #edit_plan input[name="plan_date"]').attr('type', 'hidden');
                $('#modal-editActionplan #edit_plan input[name="plan_date"]').removeAttr('disabled');

                $('#modal-editActionplan #edit_plan .visitation_reason, #modal-editActionplan #edit_plan .contact_type, #modal-editActionplan .edit_btn, #modal-editActionplan #edit_plan .event_title, #modal-editActionplan #edit_plan .remark, #modal-editActionplan .clear_job_category, #modal-editActionplan .total_staff_input').removeAttr('disabled');
                $('#modal-editActionplan .del_btn').closest('li').show();
                $('#modal-editActionplan .action_tab').show();

                $('#modal-editActionplan #edit_plan .event_category').show();
                $('#modal-editActionplan #edit_plan .module_name').attr('type', 'hidden');

                var plan_date_ele = edit_plan.find('.plan_date');
                var plan_date_val = new Date(result['plan_date']);
                
                var datepicker = plan_date_ele.next();
                var date_picker_id = datepicker.attr('id');

                var this_month = new Date().getMonth();
                var this_year  = new Date().getFullYear();
                var plan_month = new Date(plan_date_val).getMonth();
                var plan_year  = new Date(plan_date_val).getFullYear();

                var today_date = new Date();
                var min_date   = new Date();
                min_date.setDate(today_date.getDate() - 1);
                
                if ( (this_month < plan_month && this_year == plan_year) || plan_year > this_year ) {
                  min_date = new Date(plan_year, plan_month, 0);
                  min_date.setDate(min_date.getDate() + 1);
                }

                var max_date = new Date(plan_year, plan_month +1, 0);
                datepicker.remove();
                plan_date_ele.after('<div class="input-group date" id="'+date_picker_id+'" data-date-format="DD.MM.YYYY"><input type="text" class="form-control" disabled/><span class="input-group-addon"><i class="fa fa-calendar"></i></span></div>');

                $('#'+date_picker_id).datetimepicker({
                    pickTime: false,
                    minDate: min_date,
                    maxDate: max_date,
                    icons: {
                      time: "fa fa-clock-o",
                      date: "fa fa-calendar",
                      up: "fa fa-arrow-up",
                      down: "fa fa-arrow-down"
                    }
                });

                $('#'+date_picker_id).on("dp.change",function (e) {
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

                  $(this).find('input').css('border-color', '#d4d4d4');
                  $(this).parent().find('.plan_date').val(year+'-'+month+'-'+day);

                  var form = $(this).closest('form');
                  var is_default = form.find('.event_title').data('default');
                  var title = form.find('.event_title').val();
                  var event_cat_id = form.find('.event_category').val();
                  if (is_default == 1 && (event_cat_id != 0 && event_cat_id != 12 && event_cat_id != undefined)) {
                    var event_cat    = form.find('.event_category option[value="'+event_cat_id+'"]').text();
                    form.find('.event_title').val(event_cat+' ['+months[dateObj.getMonth()]+' '+dateObj.getFullYear()+']');
                  }
                  if (event_cat_id == 12) {

                    var area_id     = form.find('.clear_job_type').val();
                    if (is_default == 1 && (area_id != 0 && area_id != undefined)) {
                      var area_name    = form.find('.clear_job_type option[value="'+area_id+'"]').text();
                      form.find('.event_title').val(area_name+' ['+months[dateObj.getMonth()]+' '+dateObj.getFullYear()+']');
                    } else if (is_default == 1) {
                      form.find('.event_title').val('');
                    }
                  }
                });

                var plan_month = (plan_date_val.getMonth()+1).toString();
                if (plan_month.length == 1) {
                  plan_month = '0'+plan_month;
                }
                $('#'+date_picker_id).data("DateTimePicker").setDate(plan_date_val.getDate()+"."+plan_month+"."+plan_date_val.getFullYear()); 

                //Reset actual_date datepicker
                if (result['clear_job_type_id'] != 0 || result['object_id'] == null || result['object_id'] == "" || result['object_id'] == undefined) {
                  
                  $('.edit_actual_date_div').show();
                  var actual_date  = edit_plan.find('.actual_date');
                  var actual_date_val = new Date(result['actual_date']);
                  var datepicker = actual_date.next();
                  var date_picker_id = datepicker.attr('id');

                  if (project_end != "") {
                    datepicker.remove();
                    actual_date.after('<div class="input-group date" id="'+date_picker_id+'" data-date-format="DD.MM.YYYY"><input type="text" class="form-control" disabled/><span class="input-group-addon"><i class="fa fa-calendar"></i></span></div>');
                    var today_date =new Date();
                    var min_date = new Date();
                    min_date.setDate(today_date.getDate() - 1);
                    $('#'+date_picker_id).datetimepicker({
                        pickTime: false,
                        minDate: min_date,
                        maxDate: new Date(project_end),
                        icons: {
                          time: "fa fa-clock-o",
                          date: "fa fa-calendar",
                          up: "fa fa-arrow-up",
                          down: "fa fa-arrow-down"
                        }
                    });
                    
                    $('#'+date_picker_id).on("dp.change",function (e) {
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

                      $(this).parent().find('.actual_date').val(year+'-'+month+'-'+day);

                    });            
                  }
                  $('#modal-editActionplan #edit_plan .event_category').hide();
                  $('#modal-editActionplan #edit_plan .module_name').val(result['module_name']);
                  $('#modal-editActionplan #edit_plan .module_name').attr('type', 'text');

                  $('#modal-editActionplan .action_tab').hide();
                } else {

                  $('#modal-editActionplan #edit_plan .event_category').show();
                  $('#modal-editActionplan #edit_plan .module_name').attr('type', 'hidden');

                  $('#modal-editActionplan .action_tab').show();
                }
            }

            //Edit btn
            <?php
              $function_list = $this->session->userdata('function');
              if (!empty($function_list)) {

                $position_list = $this->session->userdata('position');

                $children = array();
                foreach ($position_list as $key => $position) {
                    $children = $this->__ps_project_query->getPositionChild($children, $position);
                }

                $is_member = 1;
                if (!empty($children)) {
                  $is_member = 0;
                }

                $all_shipto = $this->action_plan->allShipTo();
                $all_ship_to_id = array();
                if (!empty($all_shipto)) {
                  foreach ($all_shipto as $key => $shipto) {
                    if (!in_array($shipto['ship_to_id'], $all_ship_to_id)) {
                      array_push($all_ship_to_id, $shipto['ship_to_id']);
                    }
                  }
                }
                $all_ship_to_id = json_encode($all_ship_to_id);
                $function_list = json_encode($function_list);  
                
                $permission = $this->permission;
                $quality_module_id = 6;
                $allow_view_qa = 0;
                $allow_create_qa = 0;
                $allow_edit_qa = 0;
                $allow_approve_qa = 0;
                if (array_key_exists($quality_module_id, $permission)) {
                  if (array_key_exists('view', $permission[$quality_module_id])) {
                    $allow_view_qa = 1;
                  } else if (array_key_exists('create', $permission[$quality_module_id])) {
                    $allow_create_qa = 1;
                  } else if (array_key_exists('edit', $permission[$quality_module_id])) {
                    $allow_edit_qa = 1;
                  } else if (array_key_exists('approve', $permission[$quality_module_id])) {
                    $allow_approve_qa = 1;
                  }
                }
            ?>
                var function_list = JSON.parse('<?php echo $function_list; ?>');
                var all_shipto = JSON.parse('<?php echo $all_ship_to_id; ?>');
                var is_member = '<?php echo $is_member; ?>';

                var allow_view_qa = '<?php echo $allow_view_qa; ?>';
                var allow_edit_qa = '<?php echo $allow_edit_qa; ?>';
                var allow_approve_qa = '<?php echo $allow_approve_qa; ?>';
                
                if (
                  (result['object_table'] == 'tbt_quality_survey' && is_member == 0 && all_shipto.indexOf(result['ship_to_id']) >= 0 && allow_view_qa ==1) || 
                  result['actor_id'] == emp_id || 
                  (function_list.indexOf('MK') >= 0 && result['object_table'] == 'tbt_quality_survey') || 
                  (function_list.indexOf('IC') >= 0 && result['object_table'] == 'tbt_fix_claim') 
                ) {
         
                  $('#modal-editActionplan .go_to_btn').show();

                  //Initial btn and link
                  var view_link = "";
                  var edit_link = "";
                  $('#modal-editActionplan .go_to_btn').removeAttr('disabled');

                  if (result['object_table'] == 'tbt_asset_track_document') {
                    view_link = "<?php echo site_url('__ps_asset_track/detail/view'); ?>"+'/'+result['quotation_id']+'/'+result['object_id'];
                    edit_link = "<?php echo site_url('__ps_asset_track/detail/save'); ?>"+'/'+result['quotation_id']+'/'+result['object_id'];
                  } else if (result['object_table'] == 'tbt_visitation_document') {
                    if (result['prospect_id'] != 0 && result['prospect_id'] != "") {
                      view_link = "<?php echo site_url('__ps_visitation/view_quotation/edit_prospect'); ?>"+'/'+result['object_id'];
                      edit_link = "<?php echo site_url('__ps_visitation/detail_quotation/edit_prospect'); ?>"+'/'+result['object_id'];
                    } else {
                      view_link = "<?php echo site_url('__ps_visitation/view_quotation/edit_quotation'); ?>"+'/'+result['object_id'];
                      edit_link = "<?php echo site_url('__ps_visitation/detail_quotation/edit_quotation'); ?>"+'/'+result['object_id'];
                    }
                  } else if (result['object_table'] == 'tbt_quality_survey') {

                    view_link = "<?php echo site_url('__ps_quality_assurance/detail/view'); ?>"+'/'+result['quotation_id']+'/'+result['object_id'];
                    edit_link = "<?php echo site_url('__ps_quality_assurance/detail/save'); ?>"+'/'+result['quotation_id']+'/'+result['object_id'];

                    if (is_member == 0 && all_shipto.indexOf(result['ship_to_id']) >= 0 && result['manager_btn_disabled'] != 1 && allow_approve_qa == 1) {
                      view_link = "<?php echo site_url('__ps_quality_assurance/manager_edit'); ?>"+'/'+result['quotation_id']+'/'+result['object_id'];
                    }       

                  } else if (result['object_table'] == 'tbt_employee_track_document') {
                    view_link = "<?php echo site_url('__ps_employee_track/detail/view'); ?>"+'/'+result['quotation_id']+'/'+result['object_id'];
                    edit_link = "<?php echo site_url('__ps_employee_track/detail/save'); ?>"+'/'+result['quotation_id']+'/'+result['object_id'];

                  } else if (result['object_table'] == 'tbt_fix_claim') {

                    view_link = "<?php echo site_url('__ps_fix_claim/detail/view'); ?>"+'/'+result['quotation_id']+'/'+result['object_id'];
                    edit_link = "<?php echo site_url('__ps_fix_claim/detail/edit'); ?>"+'/'+result['quotation_id']+'/'+result['object_id'];

                  }

                  if (view_link != "" && edit_link != "") { 
                
                    var this_month = new Date().getMonth();
                    var this_year  = new Date().getFullYear();
                    var plan_month = new Date(plan_date_val).getMonth();
                    var plan_year  = new Date(plan_date_val).getFullYear();

                    if ( 
                          (
                              !(this_year == plan_year && this_month == plan_month) || 
                              (function_list.indexOf('MK') >= 0 && result['object_table'] == 'tbt_quality_survey' && all_shipto.indexOf(result['ship_to_id']) >= 0) ||
                              (result['object_table'] == 'tbt_quality_survey' && is_member == 0 && all_shipto.indexOf(result['ship_to_id']) >= 0 && allow_view_qa == 1) ||
                              (result['object_table'] == 'tbt_fix_claim' && result['fix_claim_is_close'] == 1) ||
                              (
                                result['object_table'] != 'tbt_fix_claim' &&
                                result['submit_date_sap'] != "" && 
                                result['submit_date_sap'] != null && 
                                result['submit_date_sap'] != "0000-00-00"
                              )
                          )
                    ) {

                      if (plan_date.valueOf() > today.valueOf() && !(this_year == plan_year && this_month == plan_month)) {
                          $('#modal-editActionplan .go_to_btn').attr('disabled', true);
                      }

                      $('#modal-editActionplan .go_to_btn').attr('href', view_link);

                      if (
                          result['object_table'] == 'tbt_visitation_document' && 
                          (
                              result['submit_date_sap'] == "" || 
                              result['submit_date_sap'] == null || 
                              result['submit_date_sap'] == "0000-00-00"
                          )
                      ) {
                        $('#modal-editActionplan .go_to_btn').attr('href', edit_link);
                      }

                    } else if ( 
                      (
                        result['object_table'] == 'tbt_fix_claim' && 
                        result['fix_claim_is_close'] == 0
                      ) ||
                      (
                        this_year == plan_year && this_month == plan_month &&                       
                        (
                          result['submit_date_sap'] == "" || 
                          result['submit_date_sap'] == null || 
                          result['submit_date_sap'] == "0000-00-00"
                        ) 
                      )
                    ) {
                      $('#modal-editActionplan .go_to_btn').attr('href', edit_link);
                    }
                  } else {
                    $('#modal-editActionplan .go_to_btn').hide();
                  }

                } else {
                  $('#modal-editActionplan .go_to_btn').hide();
                }
            <?php
              }
            ?>

            if (result['object_table'] == 'tbt_fix_claim') {
              $('.plan_date_label, .actual_date_label').hide();
              $('.estimate_fix_date_label, .actual_fix_date_label').show();
            } else {
              $('.plan_date_label, .actual_date_label').show();
              $('.estimate_fix_date_label, .actual_fix_date_label').hide();
            }

            //Assign Shift Date
            $('#modal-editActionplan .shift_date_div').hide();
            if (result['pre_id'] != 0) {
              $('#modal-editActionplan .shift_date').val(result['pre_plan_date']);
              $('#modal-editActionplan .shift_date_div').show();
            }

            //Set Status Icon
            if (result['status'] == 'plan') {
              $('#modal-editActionplan .status_icon').removeClass('text-danger');
              $('#modal-editActionplan .status_icon').addClass('text-primary');
              $('#modal-editActionplan .status').text('Plan');
            } else { 
              $('#modal-editActionplan .status_icon').addClass('text-danger');
              $('#modal-editActionplan .status_icon').removeClass('text-primary');
              $('#modal-editActionplan .status').text('Unplan');
            }

            //Set Delete Parameter
            $('#modal-delActionplan .event_title').text(result['title']);
            $('#modal-delActionplan .id').val(result['id']);

            //Reset tab
            $('#modal-editActionplan .tab-pane').removeClass('active');
            $('#modal-editActionplan .action_tab li').removeClass('active');
            $('#modal-editActionplan #edit_panel').addClass('active');
            $('#modal-editActionplan .action_tab li:first').addClass('active');
          }
        });

        bindEvent();
        bindFilter();
      });
    }

    bindEvent();
    bindFilter();
    renderCalendarView();
    $('#weekview').on('click', function() {
      $('.calendar').fullCalendar('changeView', 'agendaWeek');
      bindEvent();
      bindFilter();
      renderCalendarView();
    });

    $('#monthview').on('click', function() {
      $('.calendar').fullCalendar('changeView', 'month');
      bindEvent();
      bindFilter();
      renderCalendarView();
    });

    $('#prev_month').on('click', function () {
      $('.calendar').fullCalendar( 'prev' );
      var date = $('.calendar').fullCalendar( 'getDate' );

      $('#sel_month option[value="'+(date.getMonth()+1)+'"]').prop('selected', 'selected');

      $('#current_month').text(months[date.getMonth()]);
      $('#current_month').data('id', date.getMonth()+1)
      $('#sel_year option[value="'+date.getFullYear()+'"]').prop('selected', 'selected');

      bindEvent();
      bindFilter();
      renderCalendarView();

      $.ajax('<?php echo site_url("__ps_action_plan/updateMonthSession") ?>', {
        type: 'post',
        data: 'month='+(date.getMonth()+1)+'&year='+date.getFullYear()
      });
    });
    $('#next_month').on('click', function () {
      $('.calendar').fullCalendar( 'next' );
      var date = $('.calendar').fullCalendar( 'getDate' );

      // console.log(date.getMonth()+1);
      $('#sel_month option[value="'+(date.getMonth()+1)+'"]').prop('selected', 'selected');

      $('#current_month').text(months[date.getMonth()]);
      $('#current_month').data('id', date.getMonth()+1)
      $('#sel_year option[value="'+date.getFullYear()+'"]').prop('selected', 'selected');

      bindEvent();
      bindFilter();
      renderCalendarView();

      $.ajax('<?php echo site_url("__ps_action_plan/updateMonthSession") ?>', {
        type: 'post',
        data: 'month='+(date.getMonth()+1)+'&year='+date.getFullYear()
      });
    });


    $('#sel_month').on('change', function() {
      var month = $('#sel_month').val();
      if (month.length == 1) {
        month = '0'+month;
      }
      var year = $('#sel_year').val();
      $('.calendar').fullCalendar( 'gotoDate', new Date(year+'-'+month+'-01') );
      bindEvent();
      bindFilter();
      renderCalendarView();

      $.ajax('<?php echo site_url("__ps_action_plan/updateMonthSession") ?>', {
        type: 'post',
        data: 'month='+($('#sel_month').val())+'&year='+$('#sel_year').val()
      });
    });

    $('#sel_year').on('change', function() {
      var month = $('#sel_month').val();
      if (month.length == 1) {
        month = '0'+month;
      }
      var year = $('#sel_year').val();
      $('.calendar').fullCalendar( 'gotoDate', new Date(year+'-'+month+'-01') );
      bindEvent();
      bindFilter();
      renderCalendarView();
      
      $.ajax('<?php echo site_url("__ps_action_plan/updateMonthSession") ?>', {
        type: 'post',
        data: 'month='+($('#sel_month').val())+'&year='+$('#sel_year').val()
      });
    });

    $('#edit_actual_date').on("dp.change",function (e) {
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

      $(this).parent().find('.actual_date').val(year+'-'+month+'-'+day);

    });

    $("#datetimepicker5, #datetimepicker10, #datetimepicker15, #datetimepicker20").on("dp.change",function (e) {
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

      $(this).find('input').css('border-color', '#d4d4d4');
      $(this).parent().find('.plan_date').val(year+'-'+month+'-'+day);

      var form = $(this).closest('form');
      var is_default = form.find('.event_title').data('default');
      var title = form.find('.event_title').val();
      var event_cat_id = form.find('.event_category').val();
      if (is_default == 1 && (event_cat_id != 0 && event_cat_id != 12 && event_cat_id != undefined)) {
        var event_cat    = form.find('.event_category option[value="'+event_cat_id+'"]').text();
        form.find('.event_title').val(event_cat+' ['+months[dateObj.getMonth()]+' '+dateObj.getFullYear()+']');
      }
      if (event_cat_id == 12) {

        var area_id     = form.find('.clear_job_type').val();
        if (is_default == 1 && (area_id != 0 && area_id != undefined)) {
          var area_name    = form.find('.clear_job_type option[value="'+area_id+'"]').text();
          form.find('.event_title').val(area_name+' ['+months[dateObj.getMonth()]+' '+dateObj.getFullYear()+']');
        } else if (is_default == 1) {
          form.find('.event_title').val('');
        }
      }
    });

  });

  function fetch_visit_slot() {

    $('.sel-ship-to').off();
    $('.sel-ship-to').on('click', function() {
      
      var modal      = $(this).closest('.modal').find('#visitation_panel');
      var contract_id = $(this).data('id');
      var project_end = $(this).data('end');
      var ship_to    = $(this).text();

      modal.find('.ship_to_id').val(ship_to);
      modal.find('.ship_to_id').css('border-color', '#d4d4d4');
      modal.find('input[name="contract_id"]').val(contract_id);
      modal.find('div.open').removeClass('open');    
      
      var select_part = modal.find('select[name="sequence"]');
      select_part.find('option').remove();
      select_part.attr('disabled', true);
      modal.find('.all_parts').text('');

      var plan_date  = modal.find('.plan_date');
      var plan_date_val  = plan_date.val();
      var datepicker = plan_date.next();
      var date_picker_id = datepicker.attr('id');
      datepicker.remove();

      plan_date.after('<div class="input-group date" id="'+date_picker_id+'" data-date-format="DD.MM.YYYY"><input type="text" class="form-control" disabled/><span class="input-group-addon"><i class="fa fa-calendar"></i></span></div>');

      var date = new Date();
      date.setDate(date.getDate() - 1);
      $('#'+date_picker_id).datetimepicker({
          pickTime: false,
          minDate: date,
          maxDate: new Date(project_end),
          icons: {
          time: "fa fa-clock-o",
          date: "fa fa-calendar",
          up: "fa fa-arrow-up",
          down: "fa fa-arrow-down"
        }
      });

      $('#'+date_picker_id).on("dp.change",function (e) {
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

        $(this).find('input').css('border-color', '#d4d4d4');
        $(this).parent().find('.plan_date').val(year+'-'+month+'-'+day);

        var form = $(this).closest('form');
        var is_default = form.find('.event_title').data('default');
        var title = form.find('.event_title').val();
        var event_cat_id = form.find('.event_category').val();
        if (is_default == 1 && (event_cat_id != 0 && event_cat_id != 12 && event_cat_id != undefined)) {
          var event_cat    = form.find('.event_category option[value="'+event_cat_id+'"]').text();
          form.find('.event_title').val(event_cat+' ['+months[dateObj.getMonth()]+' '+dateObj.getFullYear()+']');
        }
      });

      plan_date.val('');
      
      if (new Date(project_end).getTime() > new Date(plan_date_val).getTime()) {     
        $('#'+date_picker_id).data("DateTimePicker").setDate(new Date(plan_date_val).getDate()+"."+(new Date(plan_date_val).getMonth()+1)+"."+new Date(plan_date_val).getFullYear());
      }

      return false;
    });
  }

  function fetch_slot() {

    $('.sel-ship-to').off();
    $('.sel-ship-to').on('click', function() {
        
      var modal      = $(this).closest('.modal').find('#general_panel');
      var contract_id = $(this).data('id');
      var project_end = $(this).data('end');
      var ship_to    = $(this).text();

      modal.find('.ship_to_id').val(ship_to);
      modal.find('.ship_to_id').css('border-color', '#d4d4d4');
      modal.find('input[name="contract_id"]').val(contract_id);
      modal.find('div.open').removeClass('open');

      modal.find('.clear_job_category option:first').prop('selected', true);
      modal.find('.clear_job_type option:first').prop('selected', true);
      modal.find('.clear_job_type option:not(:first)').remove();
      modal.find('.staff_input').val('');
      modal.find('.total_staff_input').val('');
      modal.find('.clear_job_category_div, .clear_job_type_div, .staff_div').hide();
      // modal.find('.visit_reason_div').hide();
      // modal.find('.visitation_reason option:first').prop('selected', true);
      
      var select_part = modal.find('select[name="sequence"]');
      select_part.find('option').remove();
      select_part.attr('disabled', true);
      modal.find('.all_parts').text('');

      var plan_date  = modal.find('.plan_date');
      var plan_date_val = plan_date.val();
      var datepicker = plan_date.next();
      var date_picker_id = datepicker.attr('id');
      datepicker.remove();

      plan_date.after('<div class="input-group date" id="'+date_picker_id+'" data-date-format="DD.MM.YYYY"><input type="text" class="form-control" disabled/><span class="input-group-addon"><i class="fa fa-calendar"></i></span></div>');

      var date = new Date();
      date.setDate(date.getDate() - 1);
      $('#'+date_picker_id).datetimepicker({
          pickTime: false,
          minDate: date,
          maxDate: new Date(project_end),
          icons: {
          time: "fa fa-clock-o",
          date: "fa fa-calendar",
          up: "fa fa-arrow-up",
          down: "fa fa-arrow-down"
        }
      });

      $('#'+date_picker_id).on("dp.change",function (e) {
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

        $(this).find('input').css('border-color', '#d4d4d4');
        $(this).parent().find('.plan_date').val(year+'-'+month+'-'+day);

        var form = $(this).closest('form');
        var is_default = form.find('.event_title').data('default');
        var title = form.find('.event_title').val();
        var event_cat_id = form.find('.event_category').val();
        if (is_default == 1 && (event_cat_id != 0 && event_cat_id != 12 && event_cat_id != undefined)) {
          var event_cat    = form.find('.event_category option[value="'+event_cat_id+'"]').text();
          form.find('.event_title').val(event_cat+' ['+months[dateObj.getMonth()]+' '+dateObj.getFullYear()+']');
        }
        if (event_cat_id == 12) {

          var area_id     = form.find('.clear_job_type').val();
          if (is_default == 1 && (area_id != 0 && area_id != undefined)) {
            var area_name    = form.find('.clear_job_type option[value="'+area_id+'"]').text();
            form.find('.event_title').val(area_name+' ['+months[dateObj.getMonth()]+' '+dateObj.getFullYear()+']');
          } else if (is_default == 1) {
            form.find('.event_title').val('');
          }
        }
      });

      if (new Date(project_end).getTime() > new Date(plan_date_val).getTime()) {     
        $('#'+date_picker_id).data("DateTimePicker").setDate(new Date(plan_date_val).getDate()+"."+(new Date(plan_date_val).getMonth()+1)+"."+new Date(plan_date_val).getFullYear());
      }
      

      if (modal.find('.event_category').length > 0 && contract_id != "") {
        $.ajax('<?php echo site_url("__ps_action_plan/fetch_category") ?>', {
          type: 'post',
          data: 'contract_id='+contract_id,
          beforeSend: function() {
            modal.find('.event_loading').show();
            modal.find('.event_category').attr('disabled', true);
          }
        }).done(function (data) {

          modal.find('.event_loading').hide();
          modal.find('.event_category').removeAttr('disabled');
          if (data != 0) {
            modal.find('.event_category option:not(:first)').remove();

            var result_list = JSON.parse(data);
                result      = result_list['module_list'];
            var eventresult = result_list['event_list'];

            if (result.length != 0) {
              for (var i in result) {
                var module = result[i];
                modal.find('.event_category').append('<option value="'+module['id']+'" data-event="0">'+module['name']+'</option>');

                if (module['clearjob_list'] != undefined) {
                  for (var j in module['clearjob_list']) {
                    var clearjob = module['clearjob_list'][j];
                    modal.find('.clear_job_type').append('<option value="'+clearjob['id']+'" data-event="0">'+clearjob['title']+'</option>');
                  }
                }
              }
            }

            if (eventresult.length != 0) {
              for (var i in eventresult) {
                var module = eventresult[i];
                modal.find('.event_category').append('<option value="'+module['id']+'" data-event="1">'+module['name']+'</option>');
              }
            }

            modal.find('.event_category option:first').prop('selected', 'selected');

            var title_ele = modal.find('.event_title');
            if (title_ele.data('default') == 1) {
              title_ele.val('');
            }
          }
        });
      }

      return false;
    });
  }

  $('.project_type_radio').on('change', function() {
    var type = $(this).val();
    if (type == 'prospect') {
      $('.prospect_div').show();
      $('.ship_to_div').hide();
    } else {
      $('.prospect_div').hide();
      $('.ship_to_div').show();
    }


    $('.prospect_id, .ship_to_id').css('border-color', '#d4d4d4');
    $('input[name="prospect_id"], .prospect_id, input[name="contract_id"], .ship_to_id').val('');

    var modal = $(this).closest('.modal').find('#visitation_panel');
    var list = modal.find('ul.prospect_list');
    list.find('li').remove();
    list.parent().removeClass('open');

    var select_part = modal.find('select[name="sequence"]');
    select_part.find('option').remove();
    select_part.attr('disabled', true);
    modal.find('.all_parts').text('');

    modal.find('.type_alert').hide();
  });

  $('.prospect_id').donetyping(function() {

    var modal = $(this).closest('.modal').find('#visitation_panel');
    var prospect_id = modal.find('.prospect_id').val();
    var distribution_channel = "-1";
  if(modal.find('.distribution_channel').length > 0){
    distribution_channel = modal.find('.distribution_channel').val();
  }
  param = {prospect_id:prospect_id, distribution_channel:distribution_channel};


    if (prospect_id != "") {
      $.ajax('<?php echo site_url("__ps_action_plan/fetch_prospect") ?>', {
        type: 'post',
        data: param,
        beforeSend: function() {
          modal.find('.prospect_loading').show();
          // modal.find('.event_category').attr('disabled', true);
        }
      }).done(function (data) {

        modal.find('.prospect_loading').hide();
        // modal.find('.event_category').removeAttr('disabled');
        var result_list = JSON.parse(data);
            result      = result_list['prospect'];

        var list = modal.find('ul.prospect_list');
        list.find('li').remove();
        list.parent().removeClass('open');
        if (result.length > 0) {
          list.parent().addClass('open');
          for (var i in result) {
            var obj = result[i];
            list.append('<li><a href="#" class="sel-prospect-to" data-id="'+obj['id']+'" data-end="'+obj['project_end']+'">'+obj['id']+' : '+obj['title']+'</a></li>');
          }

          $('.sel-prospect-to').off();
          $('.sel-prospect-to').on('click', function () {
            var modal      = $(this).closest('.modal');
            var prospect_id = $(this).data('id');
            var project_end = $(this).data('end');
            var prospect     = $(this).text();

            modal.find('.prospect_id').val(prospect);
            modal.find('.prospect_id').css('border-color', '#d4d4d4');
            modal.find('input[name="prospect_id"]').val(prospect_id);
            modal.find('div.open').removeClass('open');   
          });
        }

        modal.find('.ship_to_loading').hide();
      });
    } else {
      var list = modal.find('ul.prospect_list');
      list.find('li').remove();
      list.parent().removeClass('open');
      modal.find('input[name="prospect_id"]').val('');
    }
  });

  $('.visit_ship_to_id').donetyping(function() {

    var modal = $(this).closest('.modal').find('#visitation_panel');
    var ship_to_id = modal.find('.visit_ship_to_id').val();

    var distribution_channel = '-1';
    if(modal.find('.distribution_channel').length > 0){
      distribution_channel = modal.find('.distribution_channel').val();
    }
    param = {ship_to_id:ship_to_id, distribution_channel:distribution_channel};

    if (ship_to_id != "") {
      $.ajax('<?php echo site_url("__ps_action_plan/fetch_visit_project") ?>', {
        type: 'post',
        data: param,
        beforeSend: function() {
          modal.find('.ship_to_loading').show();
          // modal.find('.event_category').attr('disabled', true);
        }
      }).done(function (data) {

        // modal.find('.event_category').removeAttr('disabled');
        var result_list = JSON.parse(data);
            result      = result_list['project'];

        var list = modal.find('ul.ship_to_list');
        list.find('li').remove();
        list.parent().removeClass('open');
        if (result.length > 0) {
          list.parent().addClass('open');
          for (var i in result) {
            var obj = result[i];
            list.append('<li><a href="#" class="sel-ship-to" data-id="'+obj['contract_id']+'" data-end="'+obj['project_end']+'">'+obj['id']+' : '+obj['name1']+'</a></li>');
          }
          fetch_visit_slot();
        }

        modal.find('.ship_to_loading').hide();
      });
    } else {
      var list = modal.find('ul.ship_to_list');
      list.find('li').remove();
      list.parent().removeClass('open');
      modal.find('input[name="ship_to_id"]').val('');
    }
  });

  $('.ship_to_id').donetyping(function() {

    var modal = $(this).closest('.modal').find('#general_panel');
    var ship_to_id = modal.find('.ship_to_id').val();
   
    if (ship_to_id != "") {
      $.ajax('<?php echo site_url("__ps_action_plan/fetch_project") ?>', {
        type: 'post',
        data: 'ship_to_id='+ship_to_id,
        beforeSend: function() {
          modal.find('.ship_to_loading').show();
          modal.find('.event_category').attr('disabled', true);
        }
      }).done(function (data) {

        modal.find('.event_category').removeAttr('disabled');
        var result_list = JSON.parse(data);
            result      = result_list['project'];

        var list = modal.find('ul.ship_to_list');
        list.find('li').remove();
        list.parent().removeClass('open');

        if (result.length > 0) {
          list.parent().addClass('open');
          for (var i in result) {
            var obj = result[i];
            list.append('<li><a href="#" class="sel-ship-to" data-id="'+obj['contract_id']+'" data-end="'+obj['project_end']+'">'+obj['id']+' : '+obj['name1']+'</a></li>');
          }
          fetch_slot();
        }

        modal.find('.ship_to_loading').hide();
      });
    } else {
      var list = modal.find('ul.ship_to_list');
      list.find('li').remove();
      list.parent().removeClass('open');
      modal.find('input[name="ship_to_id"]').val('');
    }
  });
  

  $('.event_category').on('change', function() {
    
    var months = ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];
    var parent = $(this).closest('.modal').find('#general_panel');
    var parent_id = parent.attr('id');
        
    var form = $(this).closest('form');
    var is_default = form.find('.event_title').data('default');
    var title = form.find('.event_title').val();
    var event_cat_id = form.find('.event_category').val();
    var date = form.find('.plan_date').val();
    var dateObj = new Date(date);

    if (is_default == 1 && (event_cat_id != 0 && event_cat_id != 12 && event_cat_id != undefined)) {
      var event_cat    = form.find('.event_category option[value="'+event_cat_id+'"]').text();
      form.find('.event_title').val(event_cat+' ['+months[dateObj.getMonth()]+' '+dateObj.getFullYear()+']');
    } else if ( (event_cat_id == 0 || event_cat_id == 12) && is_default == 1) {
      form.find('.event_title').val('');
    }

    // var cat = $('#'+parent_id+' .event_category option[value="'+cat_id+'"]').text();

    var modal      = $(this).closest('.modal').find('#general_panel');;
    var contract_id = modal.find('input[name="contract_id"]').val();
    var module_id  = modal.find('.event_category').val();
    var is_event   = modal.find('.event_category option[value="'+module_id+'"]').data('event');
    var select_part = modal.find('select[name="sequence"]');

    select_part.closest('div.form-group').show();
    select_part.find('option').remove();
    select_part.attr('disabled', true);
    modal.find('.all_parts').text('');
    $(this).css('border-color', '#d9d9d9');

    $('#modal-addActionplan .clear_job_category option:first').prop('selected', true);
    $('#modal-addActionplan .clear_job_type option:first').prop('selected', true);
    $('#modal-addActionplan .staff_input').val('');
    $('#modal-addActionplan .total_staff_input').val('');
    $('#modal-addActionplan .clear_job_category_div, #modal-addActionplan .clear_job_type_div, #modal-addActionplan .staff_div').hide();
    // $('#modal-addActionplan .visit_reason_div').hide();
    // $('#modal-addActionplan .visitation_reason option:first').prop('selected', true);

    if (is_event == '1') {
      select_part.closest('div.form-group').hide();
    } else if (contract_id != "" && module_id != 0 && module_id != 12) {    
      $.ajax('<?php echo site_url("__ps_action_plan/fetch_slot") ?>', {
        type: 'post',
        data: 'contract_id='+contract_id+'&module_id='+module_id,
        beforeSend: function() {
          modal.find('.sequence_loading').show();
          select_part.attr('disabled', true);
          modal.find('.event_category').attr('disabled', true);
        }
      }).done(function (data) {

        select_part.removeAttr('disabled');
        modal.find('.event_category').removeAttr('disabled');
        $('.sequence_loading').hide();
        var result_list = JSON.parse(data);
            result      = result_list['project'];

        if (data != 0) {
          var result_list = JSON.parse(data);

          var part_list = result_list['user_marked'];
          var all_user_marked = result_list['all_user_marked'];
          if (part_list != 0) {
            select_part.removeAttr('disabled');
            for (var i in part_list) {
              var part = part_list[i];
              select_part.append('<option value="'+part['sequence']+'">'+part['sequence']+'</option>');
            }

            modal.find('.all_parts').text('/ '+all_user_marked);
            modal.find('.part_alert').hide();
          } else {
            select_part.attr('disabled', true);
            modal.find('.all_parts').text('ไม่สามารถเพิ่มแผนการตรวจได้');
          }
        }
      });
    } else if (module_id == 12) {
      $.ajax('<?php echo site_url("__ps_action_plan/fetch_clearjob_area") ?>', {
        type: 'post',
        data: 'contract_id='+contract_id,
        beforeSend: function () {
          modal.find('.clear_job_type').attr('disabled', true);
        }
      }).done(function (data) {
        modal.find('.clear_job_type').attr('disabled', false);
        modal.find('.clear_job_type > option:not(:first)').remove();
        if (data != 0) {
          var result_list = JSON.parse(data);
          // console.log(result_list);
          // console.log(modal.find('.clear_job_type'));
          for (var i in result_list) {
            var area = result_list[i];
            var option = "<option value='"+area['clear_job_type_id']+"_"+area['frequency']+"'>"+area['clearjob_title']+" "+area['frequency']+" เดือน</option>";
            modal.find('.clear_job_type').append(option);
          }
        }
      });

      $('#modal-addActionplan .clear_job_category_div, #modal-addActionplan .clear_job_type_div, #modal-addActionplan .staff_div').show();
    }
  });
  
  $('.clear_job_type').on('change', function() {

    var modal      = $(this).closest('.modal').find('#general_panel');
    var contract_id = modal.find('input[name="contract_id"]').val();
    var module_id  = modal.find('.event_category').val();
    var select_part = modal.find('select[name="sequence"]');

    var months = ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];
    var parent = $(this).closest('.modal');
    var parent_id = parent.attr('id');
        
    var form        = $(this).closest('form');
    var is_default  = form.find('.event_title').data('default');
    var title       = form.find('.event_title').val();
    var area_id     = form.find('.clear_job_type').val();
    var date        = form.find('.plan_date').val();
    var dateObj     = new Date(date);

    if ((area_id != 0 && area_id != undefined)) {
      if (is_default == 1) {

        form.find('.event_title').css('border-color', '#d9d9d9');

        var area_name    = form.find('.clear_job_type option[value="'+area_id+'"]').text();
        form.find('.event_title').val(area_name+' ['+months[dateObj.getMonth()]+' '+dateObj.getFullYear()+']');

      } else if (is_default == 1) {
        form.find('.event_title').val('');
      }

      var area_parts = area_id.split('_');
      var clear_job_type_id = area_parts[0];
      var frequency         = area_parts[1];

      modal.find('.clear_job_type_input').val(clear_job_type_id);
      modal.find('.frequency_input').val(frequency);
    }

    select_part.find('option').remove();
    select_part.attr('disabled', true);
    modal.find('.all_parts').text('');
    modal.find('.staff_input').val('');
    $(this).css('border-color', '#d9d9d9');

    if (contract_id != "" && module_id != 0 && area_id != 0) {

        var area_parts = area_id.split('_');
        var clear_job_type_id = area_parts[0];
        var frequency         = area_parts[1];

      $.ajax('<?php echo site_url("__ps_action_plan/fetch_clearjob_slot") ?>', {
        type: 'post',
        data: 'contract_id='+contract_id+'&module_id='+module_id+'&clear_job_type_id='+clear_job_type_id+'&frequency='+frequency,
        beforeSend: function() {
          $('.sequence_loading').show();
          $('.clear_job_type').attr('disabled', true);
          select_part.attr('disabled', true);
          modal.find('.event_category').attr('disabled', true);
        }
      }).done(function (data) {

        $('.clear_job_type').removeAttr('disabled');
        select_part.removeAttr('disabled');
        modal.find('.event_category').removeAttr('disabled');
        $('.sequence_loading').hide();
        var result_list = JSON.parse(data);
            result      = result_list['project'];

        if (data != 0) {
          var result_list = JSON.parse(data);

          var part_list = result_list['user_marked'];
          var all_user_marked = result_list['all_user_marked'];
          if (part_list != 0) {
            select_part.removeAttr('disabled');
            for (var i in part_list) {
              var part = part_list[i];
              select_part.append('<option value="'+part['sequence']+'">'+part['sequence']+'</option>');
            }

            if (result_list['staff'] != '') {
              $('#modal-addActionplan .staff_input').val(result_list['staff']);
            }

            modal.find('.all_parts').text('/ '+all_user_marked);
            modal.find('.part_alert').hide();
          } else {

            $('#modal-addActionplan .staff_input').val('');
            select_part.attr('disabled', true);
            modal.find('.all_parts').text('ไม่สามารถเพิ่มแผนการตรวจได้');
          }
        }
      });
    }
  });


  $('.event_title').on('keyup', function() {
    if ($(this).val() != "") {
     $(this).data('default', 0);
      $(this).css('border-color', '#d9d9d9');
    }
  });

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

  $('.total_staff_input, .staff_input').on('keypress', function() {
    preventNumber(event);
  });
  $('.total_staff_input').on('keyup', function() {
    if ($(this).val() != "" && $(this).val() != 0) {
     $(this).data('default', 0);
      $(this).css('border-color', '#d9d9d9');
    }
  });

  $('.clear_job_category').on('change', function (){
    if ($(this).val() != 0) {
      $(this).css('border-color', '#d9d9d9');
    }
  });

  $('.manager-create_btn').on('click', function() {
    var form       = $('#modal-addActionplan form');
    var contract_id = form.find('input[name="contract_id"]');
    var plan_date  = form.find('input[name="plan_date"]');
    var title      = form.find('input[name="title"]');

    var pass = true;
    if (contract_id.val() == "") {
      pass = false;
      $('#modal-addActionplan form .ship_to_id').css('border-color', 'red');
    }
    if (plan_date.val() == "") {
      pass = false;
      $('#datetimepicker5 input').css('border-color', 'red');
    }
    if (title.val() == "") {
      pass = false;
      title.css('border-color', 'red');
    }

    if (!pass) {
      return false
    }

    $(this).attr('disabled', true);
    form.submit();
  });

  var months = ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];
  $("#datetimepicker30").on("dp.change",function (e) {
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

    $(this).find('input').css('border-color', '#d4d4d4');
    $(this).parent().find('.plan_date').val(year+'-'+month+'-'+day);

    var form = $(this).closest('form');
    var is_default = form.find('.event_title').data('default');
    var title = form.find('.event_title').val();
    var event_cat_id = form.find('.event_category').val();
    if (is_default == 1 && (event_cat_id != 0 && event_cat_id != 12 && event_cat_id != undefined)) {
      var event_cat    = form.find('.event_category option[value="'+event_cat_id+'"]').text();
      form.find('.event_title').val(event_cat+' ['+months[dateObj.getMonth()]+' '+dateObj.getFullYear()+']');
      form.find('.event_title').css('border-color', '#d4d4d4');
    }

  });

  $('.create_btn').on('click', function() {

    var form = $('#modal-addActionplan #general_form');
    if ($('#visitation_panel').hasClass('active')) {
      form = $('#modal-addActionplan #visitation_form');

      // console.log(form.attr('id'));
      var type       = form.find('.project_type_radio:checked').val()
      var plan_date  = form.find('input[name="plan_date"]');
      var title      = form.find('input[name="title"]');
      var check_type = form.find('.project_type_radio:checked');

      var pass = true;
      if (plan_date.val() == "") {
        pass = false;
        plan_date.next().find('input').css('border-color', 'red');
      }
      if (title.val() == "") {
        pass = false;
        title.css('border-color', 'red');
      }

      if (form.find('.project_type_radio').length > 0 && check_type.length == 0) {
        pass = false;
        form.find('.type_alert').show();
      } else {
        var type = check_type.val();
        if (form.find('.project_type_radio').length > 0 && type == 'prospect') {
          var prospect_ele = form.find('.prospect_id');
          if (prospect_ele.val() == '') {
            pass = false;
            prospect_ele.css('border-color', 'red');
          }
        } else {
          var ship_to_ele = form.find('.ship_to_id');
          if (ship_to_ele.val() == '') {
            pass = false;
            ship_to_ele.css('border-color', 'red');
          }
        }
      }

      // console.log(pass);
      if (!pass) {
        return false
      }

      $(this).attr('disabled', true);
      form.submit();

    } else {

      // console.log(form.attr('id'));

      var sequence   = form.find('select[name="sequence"]');
      var contract_id = form.find('input[name="contract_id"]');
      var plan_date  = form.find('input[name="plan_date"]');
      var title      = form.find('input[name="title"]');
      var event_category = form.find('select[name="event_category_id"]');
      var is_event = form.find('select[name="event_category_id"] option[value="'+event_category+'"]').data('event');

      var pass = true;
      if (contract_id.val() == "") {
        pass = false;
        $('#modal-addActionplan form .ship_to_id').css('border-color', 'red');
      }
      if (plan_date.val() == "") {
        pass = false;
        $('#datetimepicker5 input').css('border-color', 'red');
      }
      if (title.val() == "") {
        pass = false;
        title.css('border-color', 'red');
      }
      if ((sequence.val() == "" || sequence.val() == null) && is_event == '0') {
        pass = false;
        $('#modal-addActionplan form .part_alert').show();
      }
      if (event_category.val() == 0 || event_category.val() == null) {
        pass = false;
        event_category.css('border-color', 'red');
      }

      if (event_category.val() == 12) {
        var area_sel = form.find('select.clear_job_type');
        if (area_sel.val() == 0 || area_sel.val() == null) {
          pass = false;
          form.find('select.clear_job_type').css('border-color', 'red');
        }
      }

      // console.log(pass);
      if (!pass) {
        return false
      }

      $(this).attr('disabled', true);
      form.submit();
    }


  });

  $('.duplicate_btn').on('click', function() {
    var form       = $('#modal-editActionplan #duplicate_plan');
    var sequence   = form.find('select[name="sequence"]');
    var project_id = form.find('input[name="project_id"]');
    var plan_date  = form.find('input[name="plan_date"]');
    var title      = form.find('input[name="title"]');

    var pass = true;
    if (project_id.val() == "") {
      pass = false;
      $('#modal-editActionplan #duplicate_plan .project_alert').show();
    }
    if (plan_date.val() == "") {
      pass = false;
      $('#datetimepicker15 input').css('border-color', 'red');
    }
    if (title.val() == "") {
      pass = false;
      title.css('border-color', 'red');
    }
    if (sequence.val() == "" || sequence.val() == null) {
      pass = false;
      $('#modal-editActionplan #duplicate_plan .part_alert').show();n
    }

    if (!pass) {
      return false
    }

    $(this).attr('disabled', true);
    form.submit();
  });

  $('.manager_edit_btn').on('click', function() {
    var form       = $('#modal-editManagerActionplan #manager_edit_plan');
    var plan_date  = form.find('input[name="plan_date"]');
    var title      = form.find('input[name="title"]');

    var pass = true;
    if (plan_date.val() == "") {
      pass = false;
      plan_date.css('border-color', 'red');
    }
    if (title.val() == "") {
      pass = false;
      title.css('border-color', 'red');
    }

    if (!pass) {
      return false
    }

    $(this).attr('disabled', true);
    form.submit();
  });

  $('.edit_btn').on('click', function() {
    var form       = $('#modal-editActionplan #edit_plan');

    if (form.find('input[name="prospect_id"]').val() != 0 && form.find('input[name="prospect_id"]').val() != '' && form.find('input[name="prospect_id"]').val() != undefined) {

      var plan_date  = form.find('input[name="plan_date"]');
      var title      = form.find('input[name="title"]');

      var pass = true;
      if (plan_date.val() == "") {
        pass = false;
        plan_date.next().find('input').css('border-color', 'red');
      }
      if (title.val() == "") {
        pass = false;
        title.css('border-color', 'red');
      }

      // console.log(pass);
      if (!pass) {
        return false
      }

      $(this).attr('disabled', true);
      form.submit();

    } else {
      var plan_date  = form.find('input[name="plan_date"]');
      var title      = form.find('input[name="title"]');

      var clearjob_category = form.find('.clear_job_category:not(:hidden)');
      var actual_date  = form.find('input[name="actual_date"]');
      var total_staff  = form.find('input[name="total_staff"]:not(:hidden)');

      var pass = true;
      if (plan_date.val() == "") {
        console.log('plan date not pass');
        pass = false;
        plan_date.css('border-color', 'red');
      }
      if (title.val() == "") {
        console.log('title not pass');
        pass = false;
        title.css('border-color', 'red');
      }

      if (total_staff.length > 0) {
        if (actual_date.val() != "" &&  (total_staff.val() == '0' || total_staff.val() == '')) {
          console.log('actual date not pass');
          pass = false;
          total_staff.css('border-color', 'red');
        }
      }

      if (clearjob_category.length > 0 && clearjob_category.val() == 0) {
        console.log('clear job not pass');
        pass = false;
        clearjob_category.css('border-color', 'red');
      }

      if (!pass) {
        return false
      }

      console.log(pass);

      $(this).attr('disabled', true);
      form.submit();
    }
  });

  $('.del_btn').on('click', function() {
    if ($('#modal-editActionplan').is(':visible')) {
      $('#modal-editActionplan').modal('hide');
    }
    if ($('#modal-editManagerActionplan').is(':visible')) {
      $('#modal-editManagerActionplan').modal('hide');
    }

    $('#modal-delActionplan').modal();
    return false;
  });

  $('.confirm_del_btn').on('click', function() {
    $('.confirm_del_btn').attr('disabled', true);
    $('#modal-delActionplan form').submit();
    return false;
  });

  $('.save-assign, .submit-untrack, .submit-track').on('click', function(){
    $(this).attr('disabled', true);
  });

}(window.jQuery);
</script>