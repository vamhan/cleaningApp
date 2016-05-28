<script type="text/javascript">

	function bindFrequency () {

	    $('.minus_freq, .plus_freq').off();

	    $('.minus_freq').on('click', function() {
	      var parent = $(this).closest('div');
	      var input  = parent.find('input');
	      var freq   = input.val();

	      if (freq == '' || freq == 1) {
	        input.val('');
	      } else if (freq > 1) {
	        input.val(parseInt(freq)-1);
	      }

	    });

	    $('.plus_freq').on('click', function() {
	      var parent = $(this).closest('div');
	      var input  = parent.find('input');
	      var freq   = input.val();

	      if (freq == '') {
	        input.val(1);
	      } else if (freq >= 1 && freq < 28) {
	        input.val(parseInt(freq)+1);
	      }

	    });
	}

	bindFrequency();

	if ( $('.is_auto').length > 0 ) {
		$('.is_auto').on('change', function () {
			if ($(this).is(':checked')) {
				$('input.manual_field').val('');
				$('.manual_field').attr('disabled', 'disabled');
			} else {
				$('.manual_field').removeAttr('disabled');
			}
		});
	}

	$('.save_btn').on('click', function( ){
		$('#form_ele').submit();
	});

	<?php if (!empty($threshold) && $threshold['is_auto'] == 1) { ?>
		$('input.manual_field').val('');
		$('.manual_field').attr('disabled', 'disabled');
	<?php } ?>

</script>