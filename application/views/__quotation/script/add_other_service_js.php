<script type="text/javascript">
$(document).ready(function(){
var totol_of_top = $("#total_all").val();
totol_of_top = commaSeparateNumber(totol_of_top);
$("input[name='totol_of_top']").val(totol_of_top);



//<!--################## SLECTED other service ########################-->

var other_service_name = $("input[name='other_service_name']");
var other_service_id ='';

// other_service_id = $( "select[name='other_service']" ).val();
// alert(other_service_id);
//  $.ajax({
//               type: "GET",
//               url: '<?php echo site_url("__ps_quotation/get_other_service_by_id");?>'+'/'+other_service_id ,
//               data: {},
//               dataType: "json",
//               success: function(data){        
//                   data = data[0]; 
//                   if(data.material_no){          
//                   		other_service_name.val(data.material_description);  
//                  }else{
//                     alert('ไม่มีข้อมูล');
//                     other_service_name.val('');  
//                     //$(".previouse_insert_id").removeAttr("checked");
//                   }//end else
                
//                 },
//               error:function(err){
//                   alert('ผิดพลาด');
//                   other_service_name.val(''); 
//                   //$(".previouse_insert_id").removeAttr("checked");
//               },  
//               complete:function(){
//               }
// 	 })//end ajax function


//<!--################## to do chage other service ########################-->
$( "select[name='other_service']" ).change(function() {
	other_service_id = $(this).val();
	//alert(other_service_id);
  if (other_service_id != "" || other_service_id != 0 ) { 
    //$(".quantity").readOnly = false;
    $('.quantity').attr('readonly', false);
  }

  if(other_service_id==0){
    //$(".quantity").readOnly = true;
   
    $("input[name='quantity']").val('');
     $('.quantity').attr('readonly', true);
     other_service_name.val('');  
    $("input[name='total']").val('');
    $("input[name='price']").val('');
    $("input[name='quantity_code']").val('');
    $(".code_unit").html('หน่วย');   
  }

	 $.ajax({
              type: "GET",
              url: '<?php echo site_url("__ps_quotation/get_other_service_by_id");?>'+'/'+other_service_id ,
              data: {},
              dataType: "json",
              success: function(data){        
                  data = data[0]; 
                 if(data.material_no){         
                  		other_service_name.val(data.material_description);  
                      $("input[name='quantity_code']").val(data.unit_code);
                      $(".code_unit").html(data.unit_code);
                      $("input[name='price']").val(commaSeparateNumber(data.price));
                      $("input[name='quantity']").val('');
                      $("input[name='total']").val('');                      
                      $("input[name='quantity']").removeAttr('disabled');
                 }else{
                    alert('ไม่มีข้อมูล');
                    other_service_name.val('');  
                    //$(".previouse_insert_id").removeAttr("checked");
                  }//end else
                
                },
              error:function(err){
                  alert('ผิดพลาด');
                  other_service_name.val(''); 
                  //$(".previouse_insert_id").removeAttr("checked");
              },  
              complete:function(){
              }
	        })//end ajax function
});//end change

//##################End : SLECTED other service ########################-->


var total_price = 0;
var price =0;
var input_quantity =0;

// $( "input[name='quantity']" ).change(function() {
//   //alert('test');
//  input_quantity = $(this).val();
//  price = $("input[name='price']").val(); 
//  total_price = input_quantity*price;
//  $("input[name='total']").val(total_price); 

// });

$("input[name='quantity']").on('keyup', function() {
    if ($(this).val() != "") {        
        //alert('test');
       input_quantity = $(this).val();
       price = $("input[name='price']").val(); 
       price = replaceComma(price);
       total_price = input_quantity*price;
       total_price = total_price.toFixed(2); 
       total_price = commaSeparateNumber(total_price);
       $("input[name='total']").val(total_price);     
    }else{

       $("input[name='total']").val(''); 

    }//end else
});






//<!--################################ start :ADD other services tab 6 ############################-->

var first_count_other_service = '';

first_count_other_service = $("#other_service").find('.service_id').length;
$("#other_service").find('#first_conut_other_service').val(first_count_other_service);

//start add
$('.add_other_service').on('click',function(){
//alert('click add');
	 
	  var other_service = $(this).parents("tr").find("select[name='other_service']").val();
         //alert(other_service);

      var other_service_name =  $("input[name='other_service_name']").val();  
         //alert(other_service_name);

      var quantity = $(this).parents("tr").find("input[name='quantity']").val();
      //alert(quantity);

      var quantity_code = $(this).parents("tr").find("input[name='quantity_code']").val();
         //alert(quantity_unit);

      var price = $(this).parents("tr").find("input[name='price']").val();
      //alert(price);

      var total = $(this).parents("tr").find("input[name='total']").val();
      //alert(total);




       if (other_service == undefined || other_service == '' || other_service == 0 ){
            $('.text_msg1').html('กรุณากรอกข้อมูล');
       }

       if (quantity == undefined || quantity == '' || quantity == 0 ){
            $('.text_msg2').html('กรุณากรอกข้อมูล');
       }


       if (total == undefined || total == '' || total == 0 ){
            $('.text_msg3').html('กรุณากรอกข้อมูล');
       }



 if (other_service != undefined && other_service != '' && other_service != 0 && 
 	    other_service_name != undefined && other_service_name != '' && other_service_name != 0 && 
      quantity != undefined && quantity != '' && quantity != 0 &&
	    quantity_code != undefined && quantity_code != '' && quantity_code != 0 &&
      total != undefined && total != '' && total != 0 &&
	    price != undefined && price != '' && price != 0            
	    ){		
		
	  	
	  	if($("#count_other_service").val()==0){
	  		var count = $(this).parents("#other_service").find('.service_id').length;
	  		count++;	  		
	  	}else{
	  		var count = $("#count_other_service").val();
	  		count++;
	  	}	  	  
	 

	   var row = "<tr class='h5 service_id count_"+count+"'>" +
           "<td>" +
            parseInt(other_service)+' '+other_service_name+
            "<input type='hidden' name='service_"+count+"_"+"serviceID' value='"+other_service+"'>" +
          "</td>"+  

           "<td class='tx-center'>" +
              quantity+' '+quantity_code+
            "<input type='hidden' name='service_"+count+"_"+"quantity' value='"+quantity+"'>" +
            "<input type='hidden' name='service_"+count+"_"+"unit' value='"+quantity_code+"'>" +
          "</td>"+

          "<td>" +
            price+
            "<input type='hidden' class='service_price' name='service_"+count+"_"+"price' value='"+replaceComma(price)+"'>" +
          "</td>"+ 

          "<td>" +
            total+
            "<input type='hidden' class='add_total' name='service_"+count+"_"+"total' value='"+replaceComma(total)+"'>" +
          "</td>"+             

          "<td class='tx-center'>" +   
            "<span class='margin-left-small'><button type='button'  data-id='"+other_service+"' data-txt='"+parseInt(other_service)+" "+other_service_name+"' onclick='DeleteRowotherservice("+replaceComma(total)+", this);' class='btn btn-default'><i class='fa fa-trash-o'></i></button></span>"+
          "</td>"+  

        "</tr>";

        $(this).parents("#other_service").find("#count_other_service").val(count);        
       // alert('count : '+count);

        $(this).parents(".table_other_service").find("tbody").append(row);

        if(count!=0){
        	$('.empty_data').hide();
        }

  //TODO :: sum subtotal price
     total = replaceComma(total); 
     total = parseFloat(total);

    var total_all = $('#total_all').val();  
        total_all = replaceComma(total_all);    
      
        total_all = parseFloat(total_all);
        total_all = parseFloat(total_all +  total);
        //add function comma
        total_all = commaSeparateNumber(total_all);
      //alert(total_all);
      $('#total_all').val(total_all);
      $("input[name='totol_of_top']").val(total_all);
      $( "select[name='other_service'] option:first" ).prop("selected", true);
  

      

      $('tr .other_service').val('0');
      $('tr .other_service_name').val('');
      $('tr .quantity').val('');
      $('tr .quantity').attr('readonly', true);
      $('tr .quantity_code').val('');
      $('.code_unit').html("<?php echo freetext('unit'); ?>");      
      $('tr .total').val('');      
      $('tr .price').val('');

      $('.text_msg1').html('');
      $('.text_msg2').html('');
      $('.text_msg3').html('');
      
 	}//end if

    $(this).closest('table').find('input.quantity').attr('disabled', true);
    $(this).closest('table').find("select[name='other_service'] option[value='"+other_service+"']").remove();
    $(this).closest('table').find( "select[name='other_service'] option:first" ).prop("selected", true);

});//end click add



//<!--################################ END : ADD other services tab 6 ############################-->

})// end document



//############################ start : number   ##################################################
 function DeleteRowotherservice(total_y,btndel) { 

  
       var  total_of_top = $("#total_all").val();
            total_of_top = replaceComma(total_of_top);
       //alert('total_of_top '+total_of_top);       
       //remove tr
      if (typeof(btndel) == "object") {
        // $('#modal-delete-other-service').modal('show');  
        // $('.confirm-delete-service').on('click',function(){   
         
         total_y =  parseFloat(total_y);
         var total_delete =0;
         total_delete = parseFloat(total_of_top - total_y);
          //add function comma
          total_delete = commaSeparateNumber(total_delete);
         //alert('total_delete '+total_delete);
           $("#total_all").val(total_delete);
           $("input[name='totol_of_top']").val(total_delete);
        // //reset subtotal
        // $("#total_all").val(0);
        // $("input[name='totol_of_top']").val(0);
      
        var select = $(btndel).closest('table').find('select.other_service');

        var id = $(btndel).data('id');
        var txt = $(btndel).data('txt');  

        select.append('<option value="'+id+'">'+txt+'</option>');

        $(btndel).closest("tr").remove();     
       //});//end click

      }else{
        return false;
    }
  

}
//############################ END : number ##################################################





</script>