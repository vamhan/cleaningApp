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
	                    //$("input[name='sold_to_name2']").val(data.sold_to_name2);
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

  	var sold_to_id  =  '';

 $('.save-change-sold-to').on('click',function(event){  
  	sold_to_id =   $("select[name='sold_to']").val();
  	//alert(sold_to_id);

  		$.ajax({
	              type: "GET",
	              url: '<?php echo site_url("__ps_quotation/get_sold_to_by_id");?>'+'/'+sold_to_id ,
	              data: {},
	              dataType: "json",
	              success: function(data){        
	                  data = data[0]; 
	                  if(data.id){          
	                  	$("input[name='sold_to_id']").val(data.sold_to_id);
	                    $("input[name='sold_to_name1']").val(data.sold_to_name);
	                    //$("input[name='sold_to_name2']").val(data.sold_to_name2);
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
	                    $("input[name='sold_to_tax_id']").val(data.sold_to_tax_id);

	                    $("input[name='ship_to_id']").val('');
	                    $("input[name='ship_to_name1']").val('');
	                    //$("input[name='ship_to_name2']").val('');
	                    $("input[name='ship_to_address1']").val('');
	                    $("input[name='ship_to_address2']").val('');
	                    $("input[name='ship_to_address3']").val('');
	                    $("input[name='ship_to_address4']").val('');
	                    $("input[name='ship_to_district']").val('');  
	                    $("input[name='ship_to_city']").val('');
	                    $("input[name='ship_to_postal_code']").val('');
	                    $("select[name='ship_to_customer_group']").val('');

	                    $("input[name='ship_to_country']").val('');
	                    $("input[name='ship_to_country_title']").val('');

	                    $("input[name='ship_to_region']").val('');
	                    $("input[name='ship_to_region_title']").val('');

	                    $("input[name='ship_to_industry']").val('');
	                    $("input[name='ship_to_industry_title']").val('');

	                    $("input[name='ship_to_business_scale']").val('');
	                    $("input[name='ship_to_business_scale_title']").val('');

	                    $("input[name='ship_to_tel']").val('');
	                    $("input[name='ship_to_tel_ext']").val('');
	                    $("input[name='ship_to_fax']").val('');
	                    $("input[name='ship_to_fax_ext']").val('');
	                    $("input[name='ship_to_mobile']").val('');
	                    $("input[name='ship_to_email']").val('');
	                    $("input[name='ship_to_tax_id']").val('');

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

	});// onclick chabe


});//end : on click 



//################ END : select sold to prospect ###################







//################ START : select sold to prospect ###################

$('.btn_select_shipTo').on('click',function(){

  	
  	var ship_to_id  =  '';

  	var distribution_channel = $("input[name='distribution_channel']").val();
  	var sold_to_id =   $("input[name='sold_to_id']").val();
  	var type =   $("input[name='job_type']").val();
  	var account_group =   $("#tab1 .account_group").val();

  	if(type=='ZQT1'){
  		type='Z10';
  	}else if(type=='ZQT2'){
  		type='Z11';
  	}else{
  		type='Z12';
  	}

  	if(account_group=='Z16'){
  		type='Z16';
  	}

  	//alert('sold_to_id '+sold_to_id+'| type : '+type+'| distribution_channel :'+distribution_channel+'|'+'distribution_channel :'+distribution_channel);

  	 var obj = $("select[name='ship_to']"); 	

		  $.ajax({
		              type: "GET",
		              //url: '<?php echo site_url("__ps_quotation/get_sap_sold_to/");?>'+job_type,
		              url: '<?php echo site_url("__ps_quotation/get_ship_to_by_id_reset");?>'+'/'+sold_to_id+'/'+type+'/'+distribution_channel,
		              data: {},
		              dataType: "json",
		              success: function(data){
		                ////console.log('return data is : ');
		                ////console.log(data);                                       
		                  //alert('success');
		                 
                        obj.empty();
                        obj.append('<option value="0" >กรุณาเลือก</option>');
		                  var count = 0;
		                       for(var index in data){ 
		                       //alert('test');                        
		                          var i = data[index];
		                           if(i.ship_to_id && i.ship_to_account_group && i.ship_to_distribution_channel){
		                              count ++;
		                              obj.append('<option value="'+i.ship_to_id+'" >'+i.ship_to_id+' '+i.ship_to_name+'</option>');
		                           }//end if
		                           //break;
		                        }//end for
		                        
		                        if(count==0){
		                              obj.append('<option value="0" >ไม่มีข้อมูลf</option>');
		                        }//end if

		              },
		              error:function(err){
		               obj.append('<option value="0" >ไม่มีข้อมูลd</option>');
		                //console.log('error : ');
		                //console.log(err);
		              },
		              complete:function(){
		              }
		    })//end ajax function



$('#modal-ship-to').modal('show');


		$('.save-change-ship-to').on('click',function(event){  
			ship_to_id =   $("select[name='ship_to']").val();
			//alert(ship_to_id);

				$.ajax({
	              type: "GET",
	              url: '<?php echo site_url("__ps_quotation/get_ship_to_by_id");?>'+'/'+ship_to_id ,
	              data: {},
	              dataType: "json",
	              success: function(data){        
	                  data = data[0]; 
	                  if(data.id){          
	                  	$("input[name='ship_to_id']").val(data.ship_to_id);
	                    $("input[name='ship_to_name1']").val(data.ship_to_name);
	                   // $("input[name='ship_to_name2']").val(data.ship_to_name2);
	                    $("input[name='ship_to_address1']").val(data.ship_to_address1);
	                    $("input[name='ship_to_address2']").val(data.ship_to_address2);
	                    $("input[name='ship_to_address3']").val(data.ship_to_address3);
	                    $("input[name='ship_to_address4']").val(data.ship_to_address4);
	                    $("input[name='ship_to_district']").val(data.ship_to_district);   
	                    $("input[name='ship_to_city']").val(data.ship_to_city);
	                    $("input[name='ship_to_postal_code']").val(data.ship_to_postal_code);
	                    $("select[name='ship_to_customer_group']").val(data.ship_to_customer_group);

	                    $("input[name='ship_to_country']").val(data.ship_to_country);
	                    $("input[name='ship_to_country_title']").val(data.ship_to_country_title);

	                    $("input[name='ship_to_region']").val(data.ship_to_region);
	                    $("input[name='ship_to_region_title']").val(data.ship_to_region_title);

	                    $("input[name='ship_to_industry']").val(data.ship_to_industry);
	                    $("input[name='ship_to_industry_title']").val(data.ship_to_industry_title);

	                    $("input[name='ship_to_business_scale']").val(data.ship_to_business_scale);
	                    $("input[name='ship_to_business_scale_title']").val(data.ship_to_business_scale_title);

	                    $("input[name='ship_to_tel']").val(data.ship_to_tel);
	                    $("input[name='ship_to_tel_ext']").val(data.ship_to_tel_ext);
	                    $("input[name='ship_to_fax']").val(data.ship_to_fax);
	                    $("input[name='ship_to_fax_ext']").val(data.ship_to_fax_ext);
	                    $("input[name='ship_to_mobile']").val(data.ship_to_mobile);
	                    $("input[name='ship_to_email']").val(data.ship_to_email);

	                    $("input[name='ship_to_tax_id']").val(data.ship_to_tax_id);

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


		});// end : clickchage sipto




});//end : on click 



//################ END : select sold to prospect ###################
//################ START : select sold_to_country chage sold_to_region ###################
var  sold_to_country_id ='';

$( "#sold_to_country" ).change(function() {
	$( "#sold_to_region" ).attr('disabled', true);
	
 //first sold_to_country_id
 	sold_to_country_id =  $(this).val();
  		//alert(sold_to_country_id);

      $.ajax({
              type: "GET",
              url: '<?php echo site_url("__ps_quotation/get_sap_region");?>'+'/'+sold_to_country_id ,
              data: {},
              dataType: "json",
              success: function(data){
                ////console.log('return data is : ');
                ////console.log(data);                                    
                  //alert('success');
                  var obj = $('#sold_to_region');
                        obj.empty();
                        obj.append('<option value="all" >กรุณาเลือก</option>');                  	                 
                  var count = 0;                  
		                for(var index in data){                       	 
		                  var i = data[index];
		                   if(i.id){
		                     //obj.append('<option value="'+i.id+'" >'+i.title+'</option>');
		                      obj.append('<option value="'+i.id+'" >'+i.title+'</option>');
		                      count++
		                    }
		                }//end for		                
		                if(count==0){
		                	obj.append('<option value="0" >ไม่มีข้อมูล</option>');
		                }//end if 

		                $( "#sold_to_region" ).attr('disabled', false);
              },
              error:function(err){
                //console.log('error : ');
                //console.log(err);
              },
              complete:function(){
              }
    })//end ajax function
    //End : sold_to_country_id

});//end change


var  sold_to_region ='';
$( "#sold_to_region" ).change(function(){
	sold_to_region = $(this).val();
	//alert(sold_to_region);
	if(sold_to_region=='all' 
		//||  sold_to_region==0
		){
		$('#sold_to_region').css('border','1px solid red'); 
	}else{
		$('#sold_to_region').css('border','1px solid green'); 
	}
});

//################ End : select sold_to_country chage sold_to_region ###################




//################ START : select ship_to_country chage ship_to_region ###################
var  ship_to_country_id ='';
$( "#ship_to_country" ).change(function() {
	$( "#ship_to_region" ).attr('disabled', true);
 //first ship_to_country_id
 	ship_to_country_id =  $(this).val();
  		//alert(ship_to_country_id);

      $.ajax({
              type: "GET",
              url: '<?php echo site_url("__ps_quotation/get_sap_region");?>'+'/'+ship_to_country_id ,
              data: {},
              dataType: "json",
              success: function(data){
                ////console.log('return data is : ');
                ////console.log(data);                                    
                  //alert('success');
                  var obj = $('#ship_to_region');
                        obj.empty();
                        obj.append('<option value="all" >กรุณาเลือก</option>');                  	                 
                  var count = 0;                  
		                for(var index in data){                       	 
		                  var i = data[index];
		                   if(i.id){
		                     //obj.append('<option value="'+i.id+'" >'+i.title+'</option>');
		                      obj.append('<option value="'+i.id+'" >'+i.title+'</option>');
		                      count++
		                    }
		                }//end for		                
		                if(count==0){
		                	obj.append('<option value="0" >ไม่มีข้อมูล</option>');
		                }//end if 

		            $( "#ship_to_region" ).attr('disabled', false);
              },
              error:function(err){
                //console.log('error : ');
                //console.log(err);
              },
              complete:function(){
              }
    })//end ajax function
    //End : ship_to_country_id

});//end change




//====  check selected  ship_to_region ====================================================
var  ship_to_region ='';
$( "#ship_to_region" ).change(function(){
	ship_to_region = $(this).val();
	//alert(ship_to_region);
	if(ship_to_region=='all' 
		//||  ship_to_region==0
		){
		$('#ship_to_region').css('border','1px solid red'); 
	}else{
		$('#ship_to_region').css('border','1px solid green'); 
	}
});
//################ End : select ship_to_country chage ship_to_region ###################


////////////////////////////// check coppy address company ///////////////////////////////////////////////

$('.is_coppy_address').on('click',function(event){ 
var is_coopy_add = $('.is_coppy_address').val();
var sold_to_name1 = $("input[name='sold_to_name1']").val();
//var sold_to_name2 = $("input[name='sold_to_name2']").val();
var sold_to_address1 = $("input[name='sold_to_address1']").val();
var sold_to_address2 = $("input[name='sold_to_address2']").val();
var sold_to_address3 = $("input[name='sold_to_address3']").val();
var sold_to_address4 = $("input[name='sold_to_address4']").val();
var sold_to_district = $("input[name='sold_to_district']").val();
var sold_to_city = $("input[name='sold_to_city']").val();
var sold_to_postal_code = $("input[name='sold_to_postal_code']").val();
var sold_to_tax_id = $("input[name='sold_to_tax_id']").val();
var sold_to_tel = $("input[name='sold_to_tel']").val();
var sold_to_tel_ext = $("input[name='sold_to_tel_ext']").val();
var sold_to_fax = $("input[name='sold_to_fax']").val();
var sold_to_fax_ext = $("input[name='sold_to_fax_ext']").val();
var sold_to_mobile = $("input[name='sold_to_mobile']").val();
var sold_to_email = $("input[name='sold_to_email']").val();

var sold_to_country = $("input[name='sold_to_country']").val();
var sold_to_region = $("input[name='sold_to_region']").val();
var sold_to_industry = $("input[name='sold_to_industry']").val();
var sold_to_business_scale = $("input[name='sold_to_business_scale']").val();

//alert('test:'+is_coopy_add);

if(is_coopy_add==''){
	$('.is_coppy_address').val(1);

	// ===== set  ship_to prospect ===== 
	$("input[name='ship_to_name1']").val(sold_to_name1);
	//$("input[name='ship_to_name2']").val(sold_to_name2);
	$("input[name='ship_to_address1']").val(sold_to_address1);
	$("input[name='ship_to_address2']").val(sold_to_address2);
	$("input[name='ship_to_address3']").val(sold_to_address3);
	$("input[name='ship_to_address4']").val(sold_to_address4);
	$("input[name='ship_to_district']").val(sold_to_district);
	$("input[name='ship_to_city']").val(sold_to_city);
	$("input[name='ship_to_postal_code']").val(sold_to_postal_code);	
	$("input[name='ship_to_tax_id']").val(sold_to_tax_id);	
	$( "select[name='ship_to_country'] option[value='"+sold_to_country+"']" ).prop("selected", true);
	$( "select[name='ship_to_region'] option[value='"+sold_to_region+"']" ).prop("selected", true);
	$( "select[name='ship_to_industry'] option[value='"+sold_to_industry+"']" ).prop("selected", true);
	$( "select[name='ship_to_business_scale'] option[value='"+sold_to_business_scale+"']" ).prop("selected", true);	
	$("input[name='ship_to_tel']").val(sold_to_tel);
	$("input[name='ship_to_tel_ext']").val(sold_to_tel_ext);
	$("input[name='ship_to_fax']").val(sold_to_fax);
	$("input[name='ship_to_fax_ext']").val(sold_to_fax_ext);
	$("input[name='ship_to_mobile']").val(sold_to_mobile);
	$("input[name='ship_to_email']").val(sold_to_email);
	

}else{

	$('.is_coppy_address').val('');
	$("input[name='ship_to_name1']").val('');
	//$("input[name='ship_to_name2']").val('');
	$("input[name='ship_to_address1']").val('');
	$("input[name='ship_to_address2']").val('');
	$("input[name='ship_to_address3']").val('');
	$("input[name='ship_to_address4']").val('');
	$("input[name='ship_to_district']").val('');
	$("input[name='ship_to_city']").val('');
	$("input[name='ship_to_postal_code']").val('');
	$("input[name='ship_to_tax_id']").val('');
	$("input[name='ship_to_tel']").val('');
	$("input[name='ship_to_tel_ext']").val('');
	$("input[name='ship_to_fax']").val('');
	$("input[name='ship_to_fax_ext']").val('');
	$("input[name='ship_to_mobile']").val('');
	$("input[name='ship_to_email']").val('');
	$( "select[name='ship_to_business_scale']  option:first" ).prop("selected", true);
	$( "select[name='ship_to_industry']  option:first" ).prop("selected", true);	

}


});// end : clickchage sipto



})// end document

//################ start : check require data ship to and sold to >> slected ###################

  function fieldCheck(){
     
	//check sold to selected====================================
      if($('#sold_to_region').val() == 'all' ){
          $('#sold_to_region').css('border','1px solid red'); 
          $('#msg_sold_to_region').html('กรุณาเลือกข้อมูล');
          //alert('กรุณาเลือกข้อมูลจังหวัด')  
          return false;
        }
        
        if($('#sold_to_country').val() == 'all'){
        	 //$('#sold_to_country').css('border','1px solid red');
            $('#msg_sold_to_country').html('กรุณาเลือกข้อมูล'); 
         	return false;
        }//end if


        if($('#sold_to_industry').val() == 'all'){
        	//alert($('#sold_to_industry').val());
        	$('#sold_to_industry').css('border','1px solid red');
            //$('#msg_sold_to_industry').html('กรุณาเลือกข้อมูล'); 
         	return false;
        }//end if


         if($('#plan_code_prospect').val() == 'all'){
        	$('#plan_code_prospect').css('border','1px solid red');
            //$('#msg_plan_code_prospect').html('กรุณาเลือกข้อมูล'); 
         	return false;
        }//end if


        if($('#sold_to_business_scale').val() == 'all'){
        	$('#sold_to_business_scale').css('border','1px solid red');
            //$('#msg_sold_to_business_scale').html('กรุณาเลือกข้อมูล');  
         	return false;
        }//end if

	//=== check ship to selected===================================
        if($('#ship_to_region').val() == 'all'){
            $('#ship_to_region').css('border','1px solid red');
            $('#msg_ship_to_region').html('กรุณาเลือกข้อมูล');          
          return false;
        }//end if


        if($('#ship_to_country').val() == 'all'){
        	 //$('#ship_to_country').css('border','1px solid red');
            $('#msg_ship_to_country').html('กรุณาเลือกข้อมูล'); 
         	return false;
        }//end if

        if($('#ship_to_industry').val() == 'all'){
        	//$('#ship_to_industry').css('border','1px solid red');
            $('#msg_ship_to_industry').html('กรุณาเลือกข้อมูล'); 
         	return false;
        }//end if


        if($('#ship_to_business_scale').val() == 'all'){
        	 //$('#ship_to_business_scale').css('border','1px solid red');
            $('#msg_ship_to_business_scale').html('กรุณาเลือกข้อมูล');  
         	return false;
        }//end if

          if($('#distribution_channel').val() == 'all'){
        	$('#distribution_channel').css('border','1px solid red');
            $('#msg_distribution_channel').html('กรุณาเลือกข้อมูล');  
         	return false;
        }//end if


}
//################ end : check require data ship to and sold to >> slected ###################

</script>