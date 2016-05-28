<script type="text/javascript">

	$(document).ready(function(){

        var checkin = $('#from_date');
        var checkout = $('#to_date');

        var checkin = checkin.datepicker({
            format: 'dd.mm.yyyy'
        }).on('changeDate', function(ev) {
          var newDate = new Date(ev.date);
          newDate.setDate(newDate.getDate() + 1);
          checkout.setValue(newDate);
          checkin.hide();
        }).data('datepicker');

        var checkout = checkout.datepicker({
            format: 'dd.mm.yyyy',
            onRender: function(date) {
                return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
            }
        }).on('changeDate', function(ev) {
          checkout.hide();
        }).data('datepicker'); 

        $('.sort_btn').on('click', function() {
        	$('input[name="sort"]').val($(this).data('sort'));
        	$('#filter_form').submit();
        });
	});

</script>