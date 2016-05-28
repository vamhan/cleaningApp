<script type="text/javascript">

$('.delete_file_btn').on('click', function() {

var id =  $(this).attr('id');    
//alert('delete file:'+id);      

$('#modal-delete').modal('show'); 

	$('.confirm-delete').on('click',function(event){
	  //alert('delete');
	     window.top.location.href = '<?php echo site_url("__cms_data_manager/doc_otherservice_management/delete_file")?>'+'/'+id;    
	});//end click confirm        

});


</script>