<script type="text/javascript">
$(document).ready(function(){






///////////////   photho ////////////////////////////


$('.photo-add').on('click',function(){
    var contract_id = $('input[name="contract_id"]').val();
      $('#modal-photo-form').modal('show')
      var obj = $('#modal-photo-form');   
      obj.find('input[name="temp_contract_id"]').val(contract_id);

        // obj.find('.save_images').on('click',function(){
        //     obj.find('.save_images').attr('disabled', true);
        // });
      
  })



$('.photo-delete').on('click',function(){
      var contract_id = $('input[name="contract_id"]').val();
      $('#modal-delete-images').modal('show')
      var obj = $('#modal-delete-images');   
      obj.find('input[name="temp_contract_id"]').val(contract_id);
      var complain_id =  obj.find('input[name="object_id"]').val();
      var id = $(this).attr('id');
      //alert('con :'+contract_id+' id :'+id);
      
         obj.find('.confirm-delete').on('click',function(){
               window.location = '<?php echo site_url($this->page_controller."/delete_file/'+id+'/'+contract_id+'/'+complain_id+' ");?>';
         });
  })

//////////////////////// CHAGE : PLANT CODE ////////////////
var plant_code ='';
$( ".plant_code" ).change(function() {
plant_code = $(this).val();
//set plant_name
 $( ".ship_to_id" ).attr('disabled', true);
var plant_name = $('#s2id_autogen2').find('.select2-chosen').html();
$(".plant_name").val(plant_name);

    $.ajax({
            type: "GET",
            url: '<?php echo site_url("__ps_complain/get_ship_to_by_plant");?>'+'/'+plant_code ,
            data: {},
            dataType: "json",
            success: function(data){
              ////console.log('return data is : ');
              ////console.log(data);                                    
                //alert('success');
              var obj = $('#ship_to_id');
                  obj.empty();
                  obj.append('<option value="" >กรุณาเลือก</option>');                                     
                var count = 0;                  
                
                  for(var index in data){                          
                    var i = data[index];
                     if(i.id){
                        obj.append('<option value="'+i.ship_to_id+'" >'+i.ship_to_id+' '+i.ship_to_name+'</option>');
                        //obj.append('<option value="'+i.ship_to_id+'" >'+count+': '+i.ship_to_id+' '+i.ship_to_name1+'('+i.project_start+' , '+i.project_end+')'+'</option>');
                        count++
                      }
                  }//end for                    
                  if(count==0){
                    obj.append('<option value="0" >ไม่มีข้อมูล</option>');
                  }//end if 

                  //SET : selected customer
                  $( ".ship_to_id" ).attr('disabled', false);
                  //$("select[name='ship_to_id'] option[value='"+select_chemical+"']").remove();
                  $('#s2id_ship_to_id').find('.select2-chosen').html('กรุณาเลือก');
                  $("select[name='ship_to_id'] option:first" ).prop("selected", true);
                  $( "#ship_to_id" ).attr('disabled', false);
                  $("input[name='ship_to_name']").val('');
                  $("input[name='ship_to_distribution_channel']").val('');
                  $("input[name='ship_to_branch_id']").val('');
                  $("input[name='ship_to_branch_des']").val('');
                  $("input[name='ship_to_city']").val('');
                  $("input[name='examiner_name']").val('');
                  $("input[name='examiner_id']").val('');

                  $( "#customer_id" ).attr('disabled', true);
                  $( ".is_contact_db" ).attr('disabled', true);
                  $('#s2id_customer_id').find('.select2-chosen').html('กรุณาเลือก');
                  $("select[name='customer_id'] option:first" ).prop("selected", true);
                  $("input[name='name_contact']").val('');
                  $("input[name='lastname_contact']").val('');
                  $("input[name='ship_to_department']").val('');
                  $("input[name='ship_to_function']").val('');   
            },
            error:function(err){
              //console.log('error : ');
              //console.log(err);
            },
            complete:function(){
            }
      })//end ajax function



});//end chang









//////////////////////// CHAGE : SHIP TO ID ////////////////
var ship_to_id ='';
$( ".ship_to_id" ).change(function() {
ship_to_id = $(this).val();

	$.ajax({
      type: "GET",
      url: '<?php echo site_url("__ps_complain/get_ship_to_by_id");?>'+'/'+ship_to_id ,
      data: {},
      dataType: "json",
      success: function(data){        
          data = data[0]; 
          if(data.id){          
          	//$("input[name='ship_to_id']").val(data.ship_to_id);
            $("input[name='ship_to_name']").val(data.ship_to_name);
            $("input[name='ship_to_distribution_channel']").val(data.ship_to_distribution_channel);
            $("input[name='ship_to_branch_id']").val(data.ship_to_branch_id);
            $("input[name='ship_to_branch_des']").val(data.ship_to_branch_des);
            $("input[name='ship_to_city']").val(data.ship_to_city);
            $("input[name='examiner_name']").val(data.ins_name);
            $("input[name='examiner_id']").val(data.ins_id);

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


	//// TODO : append selected customer
	$( "#customer_id" ).attr('disabled', true);
  $( ".is_contact_db" ).attr('disabled', true);
	   $.ajax({
	      	  type: "GET",
	          url: '<?php echo site_url("__ps_complain/get_sap_tbm_contact");?>'+'/'+ship_to_id ,
	          data: {},
	          dataType: "json",
	          success: function(data){
	            ////console.log('return data is : ');
	            ////console.log(data);                                    
	              //alert('success');
	            var obj = $('#customer_id');
	                obj.empty();
	                obj.append('<option value="" >กรุณาเลือก</option>');                  	                 
              	var count = 0;                  
	                for(var index in data){                       	 
	                  var i = data[index];
	                   if(i.id){
	                     //obj.append('<option value="'+i.id+'" >'+i.title+'</option>');
	                      obj.append('<option value="'+i.contact_id+'" >'+i.firstname+'  '+i.lastname+'</option>');
	                      count++
	                    }
	                }//end for              

	                //SET : selected customer
                  if(click_contact==1){ $( "#customer_id" ).attr('disabled', false); }
	                $( ".is_contact_db" ).attr('disabled', false);
                  $('#s2id_customer_id').find('.select2-chosen').html('กรุณาเลือก');
                  $("select[name='customer_id'] option:first" ).prop("selected", true);
                  $("input[name='name_contact']").val('');
                  $("input[name='lastname_contact']").val('');
	                $("input[name='ship_to_department']").val('');
            		  $("input[name='ship_to_function']").val('');   

                   if(count==0){
                    $( "#is_contact_db" ).attr('disabled', true);
                    $( "#customer_id" ).attr('disabled', true);
                    obj.append('<option value="0" >ไม่มีข้อมูล</option>'); 
                    $("input[name='name_contact']").attr('readonly', false);
                    $("input[name='lastname_contact']").attr('readonly', false);
                    $("input[name='ship_to_department']").attr('readonly', false);
                    $("input[name='ship_to_function']").attr('readonly', false);                 
                                       
                  }//end if 
	          },
	          error:function(err){
	            //console.log('error : ');
	            //console.log(err);
	          },
	          complete:function(){
	          }
    	})//end ajax function


});//end chage

//////////////////////////// check is contact from db ///////////////////
var click_contact = 0;
$("input[name='is_contact_db']").on('click',function(){ 
//var contact = $(this).val();
//alert(contact);
//alert(click_contact);
if(click_contact==0){
 $( "#customer_id" ).attr('disabled', false);

$("input[name='name_contact']").val('');
$("input[name='lastname_contact']").val('');
$("input[name='ship_to_department']").val('');
$("input[name='ship_to_function']").val('');
$("input[name='name_contact']").attr('readonly', true);
$("input[name='lastname_contact']").attr('readonly', true);
$("input[name='ship_to_department']").attr('readonly', true);
$("input[name='ship_to_function']").attr('readonly', true);
  
click_contact=1;
}else{
$( "#customer_id" ).attr('disabled', true);
$('#s2id_customer_id').find('.select2-chosen').html('กรุณาเลือก');
$("select[name='customer_id'] option:first" ).prop("selected", true);
$("input[name='name_contact']").val('');
$("input[name='lastname_contact']").val('');
$("input[name='ship_to_department']").val('');
$("input[name='ship_to_function']").val('');   
$("input[name='name_contact']").attr('readonly', false);
$("input[name='lastname_contact']").attr('readonly', false);
$("input[name='ship_to_department']").attr('readonly', false);
$("input[name='ship_to_function']").attr('readonly', false);

click_contact=0;
}


});





//////////////////////// CHAGE : SELECTED CUSTOMER ////////////////
var customer_id ='';
$( "#customer_id" ).change(function() {
customer_id = $(this).val();

	$.ajax({
      type: "GET",
      url: '<?php echo site_url("__ps_complain/get_customer_detail");?>'+'/'+customer_id ,
      data: {},
      dataType: "json",
      success: function(data){        
          data = data[0]; 
          if(data.id){          
          	//$("input[name='ship_to_id']").val(data.ship_to_id);
            $("input[name='name_contact']").val(data.firstname);
            $("input[name='lastname_contact']").val(data.lastname);
            $("input[name='ship_to_department']").val(data.department_des);
            $("input[name='ship_to_function']").val(data.function_des);           

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

});//end chage



/////////////////////////// SELECT problem_type_id /////////////////

var problem_type_id ='';
$( "#problem_type_id" ).change(function() {
problem_type_id = $(this).val();
var problem_type_title = $('#s2id_problem_type_id').find('.select2-chosen').html();
//alert(problem_type_title);
//set : problem_type_title
$("input[name='problem_type_title']").val(problem_type_title);
 $( "#problem_list_id" ).attr('disabled', true);
$.ajax({
        type: "GET",
        url: '<?php echo site_url("__ps_complain/get_problem_list");?>'+'/'+problem_type_id ,
        data: {},
        dataType: "json",
        success: function(data){
          ////console.log('return data is : ');
          ////console.log(data);                                    
            //alert('success');
          var obj = $('#problem_list_id');
              obj.empty();
              obj.append('<option value="" >กรุณาเลือก</option>');                                     
            var count = 0;                  
              for(var index in data){                          
                var i = data[index];
                 if(i.id){
                    obj.append('<option value="'+i.id+'" >'+i.title+'</option>');
                    count++
                  }
              }//end for                    
              if(count==0){
                obj.append('<option value="0" >ไม่มีข้อมูล</option>');
              }//end if 

              //SET : selected customer
               $( "#problem_list_id" ).attr('disabled', false);
               $('#s2id_problem_list_id').find('.select2-chosen').html('กรุณาเลือก');
               $("select[name='problem_list_id'] option:first" ).prop("selected", true);
               $("input[name='problem_list_title']").val('');
               $(".completedate_text").val('');
               $("input[name='completedate']").val('');
        },
        error:function(err){
          //console.log('error : ');
          //console.log(err);
        },
        complete:function(){
        }
})//end ajax function

});//end chage



$( "#problem_list_id" ).change(function() {
    var problem_list_id = $(this).val();
    var problem_list_title = $('#s2id_problem_list_id').find('.select2-chosen').html();
    //set : problem_list_title
    $("input[name='problem_list_title']").val(problem_list_title);

    //var dateToday = "<?php echo date('D-m-y')  ?>"

    $.ajax({
        type: "GET",
        url: '<?php echo site_url("__ps_complain/get_problem_list_day");?>'+'/'+problem_list_id ,
        data: {},
        dataType: "json",
        success: function(data){
          ////console.log('return data is : ');
          ////console.log(data);                                    
            //alert('success');
       
          data = data[0]; 
          if(data.id){          

              var date = new Date();
              date.setDate(date.getDate() + parseInt(data.day));
              
              
              var month = (date.getMonth()+1).toString();
              if (month.length == 1) {
                month = '0'+month;
              }
              var day   = date.getDate().toString();
              if (day.length ==1) {
                day = '0'+day;
              }

              var year  = date.getFullYear();

            var completedate = [year, month, day].join('-');
            var completedate_show = [day, month, year].join('.'); 
            //set completedate
            // alert(data.day);
            // alert(completedate);            
            $(".completedate_text").val(completedate_show);
            $("input[name='completedate']").val(completedate);
               
          }else{
            alert('ไม่มีข้อมูล');
            //$(".previouse_insert_id").removeAttr("checked");
          }//end else

        },
        error:function(err){
          //console.log('error : ');
          //console.log(err);
        },
        complete:function(){
          }
  })//end ajax function
});//end chage


})// end document


///////////////// CONFIRM SUBMIT TO PAPYRUS ///////////////////////////////////////
function setSumitPapyrus(target){
    $(target).on('click',function(event){
      $('#modal-confirm').modal('show');

      $('#modal-confirm').find('.confirm').on('click',function(){
         //alert('clicked');
         var input_method = $("select[name='input_method']").val();
         var place = $(".place_problem").val();
         var detail = $(".detail_problem").val();
         var problem = $(".complain_problem").val();
         var problem_type_id = $("select[name='problem_type_id']").val();
         var problem_list_id = $("select[name='problem_list_id']").val();
         var completedate = $(".completedate").val();
         var problem_level = $(".problem_level:checked").val();
         //alert(problem_level);     

        if(target=='.submit-papyrus'){
       
           window.location = "<?php echo site_url($this->page_controller.'/submit_to_papyrus/'.$this->complain_id); ?>"
          +"/"+input_method+"/"+place
          +"/"+detail+"/"+problem
          +"/"+problem_type_id+"/"+problem_list_id
          +"/"+problem_level+"/"+completedate;

        }
    
    });//end click

})
}//end function

setSumitPapyrus('.submit-papyrus');

</script>