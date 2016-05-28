<script type="text/javascript">
	$(document).ready(function(){
		$('.visiblity_option').on('change',function(){

			if($(this).val() == 'hidden' || $(this).val() == 0 ){
				$(this).parent().parent().addClass('shadow');
			}else{
				$(this).parent().parent().removeClass('shadow');
			}
			
		})//end event binding 


		$('.dv_validation_selector').on('change',function(){

			var obj = $(this).parent().parent().find('.dv_content_list_index');
			if($(this).val() == 'dropdown'){
				obj.removeClass('hide');
				obj.find('select').prop('disabled',false);
			}else{
				obj.addClass('hide');
				obj.find('select').prop('disabled',true);
			}

		})//end event binding 


	})



</script>