<script type="text/javascript">
$(document).ready(function(){







//################ START : select sold to prospect ###################

  $('.btn_soldTo_prospect').on('click',function(){

  		$('#modal-soldTo-prospect').modal('show');
      
    	 var sold_to_id  =  '';

    	 $('.btn-save-prospect').on('click',function(event){             

              sold_to_id =   $("select[name='prospect_customer']").val();
              //alert(sold_to_id);

	           $.ajax({
	              type: "GET",
	              url: '<?php echo site_url("__ps_quotation/get_prospect_by_id");?>'+'/'+sold_to_id ,
	              data: {},
	              dataType: "json",
	              success: function(data){        
	                  data = data[0]; 
	                  if(data.id){          
	                  	$("input[name='sold_to_id']").val(data.id);
	                    $("input[name='sold_to_name1']").val(data.sold_to_name1);
	                    $("input[name='sold_to_name2']").val(data.sold_to_name2);
	                    $("input[name='sold_to_address1']").val(data.sold_to_address1);
	                    $("input[name='sold_to_address2']").val(data.sold_to_address2);
	                    $("input[name='sold_to_address3']").val(data.sold_to_address3);
	                    $("input[name='sold_to_address4']").val(data.sold_to_address4);
	                    $("input[name='sold_to_district']").val(data.sold_to_district);   
	                    $("input[name='sold_to_city']").val(data.sold_to_city);
	                    $("input[name='sold_to_postal_code']").val(data.sold_to_postal_code);
	                    $("select[name='sold_to_customer_group']").val(data.sold_to_customer_group);

	                    $("input[name='sold_to_country']").val(data.sold_to_country);
	                    $("input[name='sold_to_country_title']").val(data.sold_to_country_title);

	                    $("input[name='sold_to_region']").val(data.sold_to_region);
	                    $("input[name='sold_to_region_title']").val(data.sold_to_region_title);

	                    $("input[name='sold_to_industry']").val(data.sold_to_industry);
	                    $("input[name='sold_to_industry_title']").val(data.sold_to_industry_title);

	                    $("input[name='sold_to_business_scale']").val(data.sold_to_business_scale);
	                    $("input[name='sold_to_business_scale_title']").val(data.sold_to_business_scale_title);

	                    $("input[name='sold_to_tel']").val(data.sold_to_tel);
	                    $("input[name='sold_to_tel_ext']").val(data.sold_to_tel_ext);
	                    $("input[name='sold_to_fax']").val(data.sold_to_fax);
	                    $("input[name='sold_to_fax_ext']").val(data.sold_to_fax_ext);
	                    $("input[name='sold_to_mobile']").val(data.sold_to_mobile);
	                    $("input[name='sold_to_email']").val(data.sold_to_email);

	                  }else{
	                    alert('ไม่มีข้อมูล');
	                    //$(".previouse_insert_id").removeAttr("checked");
	                  }//end else
	                
	                },
	              error:function(err){
	                  alert('ผิดพลาด');
	                  //$(".previouse_insert_id").removeAttr("checked");
	              },  
	              complete:function(){
	              }
	            })//end ajax function
	            


         });//end btn-save-prospect
      
       

    
});//end : on click change


//################ END : select sold to prospect ###################




//################ START : select sold to prospect ###################

$('.btn_select_sold_to').on('click',function(){

  	$('#modal-sold-to').modal('show');





});//end : on click 



//################ END : select sold to prospect ###################







//################ START : select sold to prospect ###################

$('.btn_select_shipTo').on('click',function(){

  	$('#modal-ship-to').modal('show');





});//end : on click 



//################ END : select sold to prospect ###################








})// end document

</script>