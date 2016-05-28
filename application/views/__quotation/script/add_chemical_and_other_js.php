<script type="text/javascript">
$(document).ready(function(){

	var check_data_from_DB_input = $(".check_data_from_DB_input").val();
	//alert(check_data_from_DB_input);
//<!--################## START ::  SET sub_total_price DB  ########################-->

	if(check_data_from_DB_input==1){
			//totol_of_chemical_top_DB
			var sub_total_chemical_DB = $(".sub_total_chemical_DB").val();
      sub_total_chemical_DB = commaSeparateNumber(sub_total_chemical_DB);      
			$('.totol_of_chemical_top_DB').val(sub_total_chemical_DB);
			
			//== type : Z001 ==
			var sub_total_price_Z001 = $(".sub_total_price_Z001").val();//alert(sub_total_price_Z014);
      sub_total_price_Z001 = commaSeparateNumber(sub_total_price_Z001);	
			$(".sub_total_Z001_DB").val(sub_total_price_Z001);

			//== type : Z013 ==
			var sub_total_price_Z013 = $(".sub_total_price_Z013").val();//alert(sub_total_price_Z014);
      sub_total_price_Z013 = commaSeparateNumber(sub_total_price_Z013); 	
			$(".sub_total_Z013_DB").val(sub_total_price_Z013);

			//== type : Z005 ==
			var sub_total_price_Z005 = $(".sub_total_price_Z005").val();//alert(sub_total_price_Z014);
      sub_total_price_Z005 = commaSeparateNumber(sub_total_price_Z005); 	
			$(".sub_total_Z005_DB").val(sub_total_price_Z005);			

			//== type : Z002 ==
			var sub_total_price_Z002 = $(".sub_total_price_Z002").val();//alert(sub_total_price_Z014);
      sub_total_price_Z002 = commaSeparateNumber(sub_total_price_Z002); 	
			$(".sub_total_Z002_DB").val(sub_total_price_Z002);

			//== type : Z014 ==
			var sub_total_price_Z014 = $(".sub_total_price_Z014").val();//alert(sub_total_price_Z014);	
      sub_total_price_Z014 = commaSeparateNumber(sub_total_price_Z014); 
			$(".sub_total_Z014_DB").val(sub_total_price_Z014);

      var total_all =  $(".total_all").val();
          total_all = commaSeparateNumber(total_all); 
          $(".total_all").val(total_all);
	

	}else if(check_data_from_DB_input==0){
		
			//totol_of_chemical_top_DB_bomb
			var sub_total_chemical_DB_bomb = $(".sub_total_chemical_DB_bomb").val();
      sub_total_chemical_DB_bomb = commaSeparateNumber(sub_total_chemical_DB_bomb); 
			$('.totol_of_chemical_top_DB_bomb').val(sub_total_chemical_DB_bomb);
			
			//== type : Z001 ==
			var sub_total_price_Z001_bomb = $(".sub_total_price_Z001_bomb").val();//alert(sub_total_price_Z014);
      sub_total_price_Z001_bomb = commaSeparateNumber(sub_total_price_Z001_bomb); 	
			$(".sub_total_Z001_DB_bomb").val(sub_total_price_Z001_bomb);

			//== type : Z013 ==
			var sub_total_price_Z013_bomb = $(".sub_total_price_Z013_bomb").val();//alert(sub_total_price_Z014);
      sub_total_price_Z013_bomb = commaSeparateNumber(sub_total_price_Z013_bomb); 	
			$(".sub_total_Z013_DB_bomb").val(sub_total_price_Z013_bomb);

			//== type : Z005 ==
			var sub_total_price_Z005_bomb = $(".sub_total_price_Z005_bomb").val();//alert(sub_total_price_Z014);
      sub_total_price_Z005_bomb = commaSeparateNumber(sub_total_price_Z005_bomb); 	
			$(".sub_total_Z005_DB_bomb").val(sub_total_price_Z005_bomb);
			

			//== type : Z002 ==
			var sub_total_price_Z002_bomb = $(".sub_total_price_Z002_bomb").val();//alert(sub_total_price_Z014);
      sub_total_price_Z002_bomb = commaSeparateNumber(sub_total_price_Z002_bomb); 	
			$(".sub_total_Z002_DB_bomb").val(sub_total_price_Z002_bomb);

			//== type : Z014 ==
			var sub_total_price_Z014_bomb = $(".sub_total_price_Z014_bomb").val();//alert(sub_total_price_Z014);	
      sub_total_price_Z014_bomb = commaSeparateNumber(sub_total_price_Z014_bomb); 
			$(".sub_total_Z014_DB_bomb").val(sub_total_price_Z014_bomb);

      var total_all_bomb =  $(".total_all_bomb").val();
          total_all_bomb = commaSeparateNumber(total_all_bomb); 
          $(".total_all_bomb").val(total_all_bomb);
      

	}//end else check check_data_from_DB_input 

//<!--################## END ::  SET sub_total_price DB  ########################-->


//<!--################## START ::  SET sub_total_price request  ########################-->

	//totol_of_chemical_top_DB
	 var sub_total_request_chemical_top = $(".sub_total_request_chemical_top").val();
   sub_total_request_chemical_top = commaSeparateNumber(sub_total_request_chemical_top); 
	 $('.sub_total_request_chemical_input').val(sub_total_request_chemical_top);
	
	//== type : Z001 ==
	var sub_total_request_Z001 = $(".sub_total_request_Z001").val();//alert(sub_total_price_Z014);
  sub_total_request_Z001 = commaSeparateNumber(sub_total_request_Z001); 	
	$(".sub_total_request_Z001_input").val(sub_total_request_Z001);

	//== type : Z013 ==
	var sub_total_request_Z013 = $(".sub_total_request_Z013").val();//alert(sub_total_price_Z014);	
  sub_total_request_Z013 = commaSeparateNumber(sub_total_request_Z013); 
	$(".sub_total_request_Z013_input").val(sub_total_request_Z013);

	//== type : Z005 ==
	var sub_total_request_Z005 = $(".sub_total_request_Z005").val();//alert(sub_total_price_Z014);	
  sub_total_request_Z005 = commaSeparateNumber(sub_total_request_Z005);
	$(".sub_total_request_Z005_input").val(sub_total_request_Z005);
	

	//== type : Z002 ==
	var sub_total_request_Z002 = $(".sub_total_request_Z002").val();//alert(sub_total_price_Z014);
  sub_total_request_Z002 = commaSeparateNumber(sub_total_request_Z002);	
	$(".sub_total_request_Z002_input").val(sub_total_request_Z002);

	//== type : Z014 ==
	var sub_total_request_Z014 = $(".sub_total_request_Z014").val();//alert(sub_total_price_Z014);	
  sub_total_request_Z014 = commaSeparateNumber(sub_total_request_Z014); 
	$(".sub_total_request_Z014_input").val(sub_total_request_Z014);

  var total_all_request =  $(".total_all_request").val();
      total_all_request = commaSeparateNumber(total_all_request); 
      $(".total_all_request").val(total_all_request);


//<!--################## END ::  SET sub_total_price request  ########################-->




//################## START : group_machines ########################-->
var group_machines ='';
$( "select[name='group_machines_slected']" ).change(function() {
//alert('test');
var job_type = $(".job_type_chemical").val();
//alert(job_type);
group_machines = $(this).val();
var group_machines_name = group_machines;
var res = group_machines_name.split("|");
//set input machine group name
 $(this).parents("tr").find(".group_machines_name").val(res[1]);

//alert('group_machines :'+group_machines);

var btn_add  = $(this).parents("tr").find("select[name='select_chemical']");
    btn_add.attr('disabled', true);

 //$(this).parents("tr").find("select[name='select_chemical']").attr('disabled', false);

var obj =  $(this).parents("tr").find("select[name='select_chemical']");

//set selected
$(this).parents("tr").find('.select_chemical .select2-chosen').html('กรุณาเลือก');
$(this).parents("tr").find( "select[name='select_chemical'] option:first" ).prop("selected", true);

$(this).parents("tr").find('.select_chemical_name').val(''); 
$(this).parents("tr").find('.temp_mat_group').val('');

$(this).parents("tr").find('.temp_quantity').val('');
$(this).parents("tr").find('.temp_quantity').attr('readonly', true);
$(this).parents("tr").find('.text_unit').html('หน่วย');
$(this).parents("tr").find('.temp_unit').val('');
$(this).parents("tr").find('.price_chemical').val('');
$(this).parents("tr").find('.temp_total_price').val('');


 $.ajax({
              type: "GET",
              url: '<?php echo site_url("__ps_quotation/get_ajax_sap_tbm_mat_group");?>'+'/'+res[0]+'/'+job_type ,
              data: {},
              dataType: "json",
              success: function(data){
              var form = obj.closest('form').attr('id');
                ////console.log('return data is : ');
                ////console.log(data);                                    
                  //alert('success');
                       obj.empty();
                       obj.append('<option value="0" >กรุณาเลือก</option>');  
                 //alert('test group');                                  
                   var count = 0;                  
                    for(var index in data){                          
                      var i = data[index];
                       if(i.material_no){
                          if(i.price!=''){
                             var table = obj.closest('table');
                             if (form == "form_clearing" || (form != "form_clearing" && table.find('tr#'+i.material_no).length == 0)) {
                              obj.append('<option value="'+i.material_no+'" >'+parseInt(i.material_no)+' '+i.material_description+'</option>');
                             }
                             //obj.append('<option value="'+i.material_no+'" >'+i.material_description+' '+i.price+'</option>');
                            count++
                          }
                        }
                    }//end for                    
                    if(count==0){
                      obj.append('<option value="0" >ไม่มีข้อมูล</option>');
                    }//end if 

                     btn_add.attr('disabled', false);
              },
              error:function(err){
                //console.log('error : ');
                //console.log(err);
              },
              complete:function(){
              }
    })//end ajax function



});//end change
//################## END : group_machines ########################-->



//################## START : SLECTED chemical ########################-->

var temp_mat_id ='';
var temp_mat_type ='';
var btn_add ='';
var btn_add_request ='';
var btn_add_clearing ='';
//$(".select_chemical").change(function() {
// $('.select_chemical').on('change',function(){
$( "select[name='select_chemical']" ).change(function() {

var job_type = $(".job_type_chemical").val();
//alert(job_type);

var clearing_mach = $(this).data('type');
//alert('clearing_mach :'+clearing_mach);
//set selected
//$(this).parents(".table_chemical").find('tr .temp_mat_group').val('');
$(this).parents(".table_chemical").find('tr .temp_quantity').val('');
$(this).parents(".table_chemical").find('tr .temp_unit').val('');
$(this).parents(".table_chemical").find('tr .price_chemical').val('');
$(this).parents(".table_chemical").find('tr .temp_total_price').val('');

//disabled btn add
var input_mat_type = $(this).parents("tr").find(".temp_mat_type").val();
//alert(input_mat_type);

if(input_mat_type=='Z001' ){

 btn_add  = $(this).parents("tr").find(".add_chemical");
 btn_add_clearing = $(this).closest("table").find(".add_chimical_clearing");

}else if(input_mat_type=='Z013'){

  btn_add  = $(this).parents("tr").find(".add_chemical");
 btn_add_clearing = $(this).closest("table").find(".add_chimical_clearing");


}else if(input_mat_type=='Z002'){

  btn_add  = $(this).parents("tr").find(".add_tool");
 btn_add_clearing = $(this).closest("table").find(".add_clearing_tool");


}else if(input_mat_type=='Z014'){

  btn_add  = $(this).parents("tr").find(".add_tool");
 btn_add_clearing = $(this).closest("table").find(".add_clearing_tool");


}else if(input_mat_type=='Z005'){

  btn_add  = $(this).parents("tr").find(".add_machine");
 btn_add_clearing = $(this).closest("table").find(".add_clearing_machine");


}

 btn_add.attr('disabled', true);
 
 btn_add_request = $(this).parents("tr").find(".add_request");
 btn_add_request.attr('disabled', true);
 btn_add_clearing.attr('disabled', true);

//alert('test');

temp_mat_id = $(this).val();
temp_mat_type =  $(this).parents("tr").find('.temp_mat_type').val();

//alert(temp_mat_id+' '+temp_mat_type);

if(temp_mat_id==0){
    //$(".quantity").readOnly = true;   
    $(this).parents("tr").find(".select_chemical_name").val('');
    $(this).parents("tr").find(".temp_mat_group").val(''); 

    $(this).parents("tr").find("input[name='temp_quantity']").val('');
    $(this).parents("tr").find(".temp_quantity").attr('readonly', true);
    $(this).parents("tr").find(".temp_unit").val('');
    $(this).parents("tr").find(".text_unit").html('หน่วย'); 
     
    $(this).parents("tr").find(".temp_total_price").val('');
    $(this).parents("tr").find(".price_chemical").val('');    

  }//end if

  var select_chemical_name = $(this).parents("tr").find(".select_chemical_name");
  var temp_mat_group = $(this).parents("tr").find(".temp_mat_group");
  var temp_unit = $(this).parents("tr").find(".temp_unit");
  var text_unit = $(this).parents("tr").find(".text_unit");
  var price_chemical = $(this).parents("tr").find(".price_chemical");

  var temp_quantity =$(this).parents("tr").find("input[name='temp_quantity']");
  var temp_total_price =$(this).parents("tr").find(".temp_total_price");
  if(clearing_mach!='clearing_mach'){
    var url = '<?php echo site_url("__ps_quotation/get_chemical_and_other");?>'+'/'+temp_mat_id+'/'+temp_mat_type+'/'+job_type;
  }else{
   var url = '<?php echo site_url("__ps_quotation/get_chemical_and_other_clearing");?>'+'/'+temp_mat_id+'/'+temp_mat_type;
 }

  $.ajax({
      type: "GET",   
     // url: '<?php echo site_url("__ps_quotation/get_chemical_and_other");?>'+'/'+temp_mat_id+'/'+temp_mat_type+'/'+job_type ,
      url: url,
      data: {},
      dataType: "json",
      success: function(data){        
          data = data[0]; 
         if(data.material_no){  

         	temp_quantity.attr('readonly', false);
         	//alert(data.material_description);

         	select_chemical_name.val(data.material_description);
         	temp_mat_group.val(data.mat_group);
         	temp_unit.val(data.unit_code);
         	text_unit.html(data.unit_code);
          //set comma
         	price_chemical.val(commaSeparateNumber(data.price));	 
  
                         
         }else{
            alert('ไม่มีข้อมูล');
            select_chemical_name.val('');
         	temp_mat_group.val('');

         	temp_quantity.val('');
         	temp_quantity.attr('readonly', true);

         	temp_unit.val('');
         	text_unit.html('หน่วย');

         	price_chemical.val(''); 
         	temp_total_price.val('');
            //$(".previouse_insert_id").removeAttr("checked");
          }//end else

          btn_add.attr('disabled', false);
          btn_add_request.attr('disabled', false);
          btn_add_clearing.attr('disabled', false);
        
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
/////////////////////////////////////////////////////



///////////////  START :: CaLCULATE TOTAL_PRICE /////////////////
var call_total_price = 0;
var mat_price =0;
var input_quantity =0;
var job_type = $(".job_type_chemical").val();
var time_qt = $(".time_chemical").val();

$("input[name='temp_quantity']").on('keyup', function() {
var mat_type = $(this).parents("tr").find(".temp_mat_type").val();

//alert('job_type :'+job_type+' time:'+time_qt+' mat_type :'+mat_type);

    if ($(this).val() != "") {        
       
       if( (job_type=='ZQT2' || job_type=='ZQT3') && mat_type=='Z005'){
        //alert('test if');
       input_quantity = $(this).val();
       //alert('input_quantity :'+input_quantity);
       mat_price = $(this).parents("tr").find(".price_chemical").val();
       mat_price = replaceComma(mat_price);
       input_quantity =parseInt(input_quantity);  
       mat_price =parseFloat(mat_price);  
       time_qt =parseInt(time_qt);        
       call_total_price = input_quantity*mat_price*time_qt;       
       //2 double up
       call_total_price = call_total_price.toFixed(2);
       call_total_price = commaSeparateNumber(call_total_price);
       //alert("call_total_price :"+call_total_price);
       $(this).parents("tr").find(".temp_total_price").val(call_total_price);       

     }else{     
      //alert('test else');
      input_quantity = $(this).val();
       //alert('input_quantity :'+input_quantity);
       mat_price = $(this).parents("tr").find(".price_chemical").val();
       mat_price = replaceComma(mat_price);
       input_quantity =parseFloat(input_quantity);  
       mat_price =parseFloat(mat_price);         
       call_total_price = input_quantity*mat_price;       
       //2 double up
       call_total_price = call_total_price.toFixed(2); 
       call_total_price = commaSeparateNumber(call_total_price); 
       //alert("call_total_price :"+call_total_price);
       $(this).parents("tr").find(".temp_total_price").val(call_total_price);  

     }//end else


    }else{

       $(this).parents("tr").find(".temp_total_price").val('');      

    }//end else
});


///////////////  END :: CaLCULATE TOTAL_PRICE /////////////////






//##################End : SLECTED chemical ########################-->


//<!--################################ START :ADD chemical ############################-->

	$('.add_chemical').on('click',function(){


		var temp_space_no = $(this).parents(".div-table").find(".temp_space_no").val();
		//alert('temp_space_no ::'+temp_space_no);
		
		
        var select_chemical = $(this).parents("tr").find("select[name='select_chemical']").val();
        //alert(select_chemical);

        var select_chemical_name = $(this).parents("tr").find(".select_chemical_name").val();
        //alert(select_chemical_name);

        var texture_id = $(this).parents("tr").find(".temp_texture_id").val();
        //alert(texture_id);        	

        var mat_type = $(this).parents("tr").find(".temp_mat_type").val();
        //alert(mat_type);

        var mat_group = $(this).parents("tr").find(".temp_mat_group").val();
        //alert(mat_group);

        var  quantity = $(this).parents("tr").find(".temp_quantity").val();
        //alert(quantity);

        var  unit = $(this).parents("tr").find(".temp_unit").val();
        //alert(unit);

        var  space = $(this).parents("tr").find(".temp_space").val();
        //alert(space);

        var  price = $(this).parents("tr").find(".price_chemical").val();
        //alert(price);

        var  total_price = $(this).parents("tr").find(".temp_total_price").val();

        //alert(total_price);

          // if(mat_type=='Z013'){
          //     quantity = -1;
          //     unit = -1;
          //     price = -1;
          //     space = -1;
          // }//end if



        if (select_chemical == undefined || select_chemical == '' || select_chemical == 0 ||
        	select_chemical_name == undefined || select_chemical_name == '' || select_chemical_name == 0 ||
        	texture_id == undefined || texture_id == '' || texture_id == 0 ||
        	mat_type == undefined || mat_type == '' || mat_type == 0
        	){
            
           $(this).parents("tr").find('.text_msg1').html('กรุณากรอกข้อมูล');
       }

       if (quantity == undefined || quantity == '' || quantity == 0 ||
       		unit == undefined || unit == '' || unit == 0 ||
       		space == undefined || space == '' || space == 0
       	 ){
            $(this).parents("tr").find('.text_msg2').html('กรุณากรอกข้อมูล');
       }


       if (price == undefined || price == '' || price == 0 ){
            $(this).parents("tr").find('.text_msg3').html('กรุณากรอกข้อมูล');
       }

       if (total_price == undefined || total_price == '' || total_price == 0 ){
            $(this).parents("tr").find('.text_msg4').html('กรุณากรอกข้อมูล');
       }


    if (select_chemical != undefined && select_chemical != '' && select_chemical != 0 && 
    	select_chemical_name != undefined && select_chemical_name != '' && select_chemical_name != 0 && 
	    texture_id != undefined && texture_id != '' && texture_id != 0 && 
	  	mat_type != undefined && mat_type != '' && mat_type != 0 &&
	  	quantity != undefined && quantity != '' && quantity != 0 &&
	    unit != undefined && unit != '' && unit != 0 &&
	    space != undefined && space != '' && space != 0 &&
	    price != undefined && price != '' && price != 0 &&
	    total_price != undefined && total_price != '' && total_price != 0 && 
	    //first_count_chemical != undefined && first_count_chemical != '' && first_count_chemical != 0 && 
	    temp_space_no != undefined && temp_space_no != '' && temp_space_no != 0         
	    ){

    	//set count
    	var count = $(this).parents(".div-table").find("input[name='temp_count_chemical_"+temp_space_no+"']").val();

    		if(count==0){
    			//alert('empty');
    			$(this).parents(".table_chemical").find('tbody').empty();
    		}
	  		count++; 


      var row ='';
	  	 row = "<tr class='tx-green h5' id='"+select_chemical+"'>" +
	  	   "<td></td>" +
           "<td>" +
            parseInt(select_chemical)+' '+select_chemical_name+
            "<input type='hidden' readonly class='form-control texture_id' name='texture_id_"+temp_space_no+"_"+count+"' value='"+texture_id+"'>" +
            "<input type='hidden' readonly class='form-control material_no' name='material_no_"+temp_space_no+"_"+count+"' value='"+select_chemical+"'>" +
            "<input type='hidden' readonly class='form-control mat_type' name='mat_type_"+temp_space_no+"_"+count+"' value='"+mat_type+"'>" +
            "<input type='hidden' readonly class='form-control mat_group' name='mat_group_"+temp_space_no+"_"+count+"' value='"+mat_group+"'>" +
          "</td>"+  

           "<td class='tx-center'>" +
              quantity+' '+unit+        
            "<input type='hidden' readonly class='form-control space' name='space_"+temp_space_no+"_"+count+"' value='"+space+"'>" +
            "<input type='hidden' readonly class='form-control quantity' name='quantity_"+temp_space_no+"_"+count+"' value='"+quantity+"'>" +
            "<input type='hidden' readonly class='form-control unit_code' name='unit_code_"+temp_space_no+"_"+count+"' value='"+unit+"'>" +
          "</td>"+

          "<td class='text-right'>" +
            price+
            "<input type='hidden' readonly class='form-control price' name='price_"+temp_space_no+"_"+count+"' value='"+replaceComma(price)+"'>" +
          "</td>"+

          "<td class='text-right'>" +
            total_price+
            "<input type='hidden' readonly class='form-control total_price' name='total_price_"+temp_space_no+"_"+count+"' value='"+replaceComma(total_price)+"'>" +
          "</td>"+             

          "<td class='tx-center'>" +                      
           "<span class='margin-left-small'><button type='button'  data-id='"+select_chemical+"' data-txt='"+parseInt(select_chemical)+" "+select_chemical_name+"' onclick='SomeDeleteRowFunction_total("+replaceComma(total_price)+",this);' class='btn btn-default '><i class='fa fa-trash-o'></i></button></span>"+
          "</td>"+  

        "</tr>";

     

        //ADD : row to table
        $(this).parents(".table_chemical").find("tbody").append(row);

        //== set temp_count_chemical ===
			//alert(temp_space_no+' '+count);
			$(this).parents(".div-table").find("input[name='temp_count_chemical_"+temp_space_no+"']").val(count);

      // var mat_no = $(this).closest('table').data('id');
      // var old_total = $(this).closest('table').find('.sub_total_'+mat_type+'_'+mat_no+'_DB').val();
      // var new_total = parseFloat(old_total) + parseFloat(total_price);
      // $(this).closest('table').find('.sub_total_'+mat_type+'_'+mat_no+'_DB').val(new_total);

        //==  set : null
          // $('.select_building option:first').prop('selected', true);
          // $('.select_floor option:not(:first)').remove();
          // $('.select_area option:not(:first)').remove();

		  //$(this).parents(".table_chemical").find('tr .select_chemical option[value="'+select_chemical+'"]').remove();
          $(this).parents(".table_chemical").find('tr .select_chemical .select2-chosen').html('กรุณาเลือก');
	      //$(this).parents(".table_chemical").find('tr .select_chemical').val('0');

	      $(this).parents(".table_chemical").find('tr .select_chemical_name').val('');
	      $(this).parents(".table_chemical").find('tr .temp_mat_group').val('');

	      $(this).parents(".table_chemical").find('tr .temp_quantity').val('');
	      $(this).parents(".table_chemical").find('tr .temp_quantity').attr('readonly', true);
	      $(this).parents(".table_chemical").find('tr .text_unit').html('หน่วย');
	      $(this).parents(".table_chemical").find('tr .temp_unit').val('');
	      $(this).parents(".table_chemical").find('tr .price_chemical').val('');
	      $(this).parents(".table_chemical").find('tr .temp_total_price').val('');

	      $(this).parents(".table_chemical").find('.text_msg1').html('');
	      $(this).parents(".table_chemical").find('.text_msg2').html('');
	      $(this).parents(".table_chemical").find('.text_msg3').html('');
	      $(this).parents(".table_chemical").find('.text_msg4').html('');

			//////////////////////////// START : SET TOTAL //////////////////////////////////// 	     
				var check_data_from_DB_input = $(".check_data_from_DB_input").val();
				//	alert(check_data_from_DB_input);
        total_price = replaceComma(total_price); 

				if(check_data_from_DB_input==1){
						if(mat_type=='Z001'){	
						//== SET SUB_TOTAL_Z001 =======
                 //total_price = replaceComma(total_price);  
						     total_price = parseFloat(total_price);
                 //alert("total_price :"+total_price);                 		     
						     var sub_total_price_Z001 =  $(".sub_total_price_Z001").val();
						     	   sub_total_price_Z001 = parseFloat(sub_total_price_Z001);
						     //alert(sub_total_price_Z001);
						     sub_total_price_Z001 = parseFloat(sub_total_price_Z001+total_price);
						   	 sub_total_price_Z001 = sub_total_price_Z001.toFixed(2);  
						     $(".sub_total_price_Z001").val(sub_total_price_Z001);
                //add function comma
                 sub_total_price_Z001 = commaSeparateNumber(sub_total_price_Z001);
						     $(".sub_total_Z001_DB").val(sub_total_price_Z001);		

                 var temp_ft_total = $(".sub_total_Z001_"+texture_id+"_DB").val();
                 //alert("temp_ft_total : "+temp_ft_total);
                     temp_ft_total = replaceComma(temp_ft_total);
                     temp_ft_total = parseFloat(temp_ft_total);
                     temp_ft_total = parseFloat(temp_ft_total+total_price);
                     temp_ft_total = temp_ft_total.toFixed(2);
                  //add function comma
                  temp_ft_total = commaSeparateNumber(temp_ft_total);
                 $(".sub_total_Z001_"+texture_id+"_DB").val(temp_ft_total);				
						}

						if(mat_type=='Z013'){
							//== SET SUB_TOTAL_Z013 =======
                // total_price = replaceComma(total_price);
						     total_price = parseFloat(total_price);			     
						     var  sub_total_price_Z013 =  $(".sub_total_price_Z013").val();
						     	    sub_total_price_Z013 = parseFloat(sub_total_price_Z013);
						     //alert(sub_total_price_Z014+'  '+total_price);
						     sub_total_price_Z013 = parseFloat(sub_total_price_Z013+total_price);
						   	 sub_total_price_Z013 = sub_total_price_Z013.toFixed(2);
                 $(".sub_total_price_Z013").val(sub_total_price_Z013);
                //add function comma
                 sub_total_price_Z013 = commaSeparateNumber(sub_total_price_Z013);						     
						     $(".sub_total_Z013_DB").val(sub_total_price_Z013);

                  var temp_ft_total = $(".sub_total_Z013_"+texture_id+"_DB").val();
                     temp_ft_total = replaceComma(temp_ft_total);
                     temp_ft_total = parseFloat(temp_ft_total);
                     temp_ft_total = parseFloat(temp_ft_total+total_price);
                     temp_ft_total = temp_ft_total.toFixed(2);
                  //add function comma
                  temp_ft_total = commaSeparateNumber(temp_ft_total);
                 $(".sub_total_Z013_"+texture_id+"_DB").val(temp_ft_total);     
						}

						//== SET : totol_of_chemical_top_DB =======

                // total_price = replaceComma(total_price);
						     total_price = parseFloat(total_price);			     
						     var  totol_of_chemical_top_DB =  $(".totol_of_chemical_top_DB").val();
                      totol_of_chemical_top_DB = replaceComma(totol_of_chemical_top_DB);
						     	    totol_of_chemical_top_DB = parseFloat(totol_of_chemical_top_DB);
						     //alert(sub_total_price_Z014+'  '+total_price);
						     totol_of_chemical_top_DB = parseFloat(totol_of_chemical_top_DB+total_price);
						   	 totol_of_chemical_top_DB = totol_of_chemical_top_DB.toFixed(2);
                 $(".sub_total_chemical_DB").val(totol_of_chemical_top_DB); 
                 //add function comma
                 totol_of_chemical_top_DB = commaSeparateNumber(totol_of_chemical_top_DB);						     
						     $(".totol_of_chemical_top_DB").val(totol_of_chemical_top_DB);
						     					     

						//== SET : SUB_TOTAL_ALL =======

                 //total_price = replaceComma(total_price);
						     total_price = parseFloat(total_price);			     
						     var  sub_total_all =  $(".total_all").val();
                      sub_total_all = replaceComma(sub_total_all);
						     	    sub_total_all = parseFloat(sub_total_all);
						     //alert(sub_total_price_Z014+'  '+total_price);
						     sub_total_all = parseFloat(sub_total_all+total_price);
						   	 sub_total_all = sub_total_all.toFixed(2);
                 //add function comma
                 sub_total_all = commaSeparateNumber(sub_total_all);						     
						     $(".total_all").val(sub_total_all);		     	

				}else{

					if(mat_type=='Z001'){	
						//== SET SUB_TOTAL_Z001 =======
                // total_price = replaceComma(total_price);
						     total_price = parseFloat(total_price);			     
						     var sub_total_price_Z001 =  $(".sub_total_price_Z001_bomb").val();
						     sub_total_price_Z001 = parseFloat(sub_total_price_Z001);
						    // alert(sub_total_price_Z001);

						     sub_total_price_Z001 = parseFloat(sub_total_price_Z001+total_price);
						   	 sub_total_price_Z001 = sub_total_price_Z001.toFixed(2); 
						     $(".sub_total_price_Z001_bomb").val(sub_total_price_Z001);
                 //add function comma
                 sub_total_price_Z001 = commaSeparateNumber(sub_total_price_Z001);
						     $(".sub_total_Z001_DB_bomb").val(sub_total_price_Z001);

                 var temp_ft_total = $(".sub_total_Z001_"+texture_id+"_DB_bomb").val();
                     temp_ft_total = replaceComma(temp_ft_total);
                     temp_ft_total = parseFloat(temp_ft_total);
                     temp_ft_total = parseFloat(temp_ft_total+total_price);
                     temp_ft_total = temp_ft_total.toFixed(2);
                  //add function comma
                  temp_ft_total = commaSeparateNumber(temp_ft_total);
                 $(".sub_total_Z001_"+texture_id+"_DB_bomb").val(temp_ft_total);		
						}

						if(mat_type=='Z013'){

							//== SET SUB_TOTAL_Z013 =======

                // total_price = replaceComma(total_price);
						     total_price = parseFloat(total_price);			     
						     var  sub_total_price_Z013 =  $(".sub_total_price_Z013_bomb").val();
						     	    sub_total_price_Z013 = parseFloat(sub_total_price_Z013);
						     //alert(' sub_total_price_Z013 '+sub_total_price_Z013);
						     sub_total_price_Z013 = parseFloat(sub_total_price_Z013+total_price);
						   	 sub_total_price_Z013 = sub_total_price_Z013.toFixed(2);   
						     $(".sub_total_price_Z013_bomb").val(sub_total_price_Z013);
                 //add function comma
                 sub_total_price_Z013 = commaSeparateNumber(sub_total_price_Z013);
						     $(".sub_total_Z013_DB_bomb").val(sub_total_price_Z013);

                 var temp_ft_total = $(".sub_total_Z013_"+texture_id+"_DB_bomb").val();
                     temp_ft_total = replaceComma(temp_ft_total);
                     temp_ft_total = parseFloat(temp_ft_total);
                     temp_ft_total = parseFloat(temp_ft_total+total_price);
                     temp_ft_total = temp_ft_total.toFixed(2);
                  //add function comma
                  temp_ft_total = commaSeparateNumber(temp_ft_total);
                 $(".sub_total_Z013_"+texture_id+"_DB_bomb").val(temp_ft_total);

                 
						}

						//== SET : totol_of_chemical_top_DB ======= 
						     total_price = parseFloat(total_price);
						     var  totol_of_chemical_top_DB =  $(".totol_of_chemical_top_DB_bomb").val();
                      totol_of_chemical_top_DB = replaceComma(totol_of_chemical_top_DB);
						     	    totol_of_chemical_top_DB = parseFloat(totol_of_chemical_top_DB);
						     //alert(totol_of_chemical_top_DB);

						     totol_of_chemical_top_DB = parseFloat(totol_of_chemical_top_DB+total_price);
						   	 totol_of_chemical_top_DB = totol_of_chemical_top_DB.toFixed(2);
                 
                 $(".sub_total_chemical_DB_bomb").val(totol_of_chemical_top_DB);
                 //add function comma
                 totol_of_chemical_top_DB = commaSeparateNumber(totol_of_chemical_top_DB);						     
						     $(".totol_of_chemical_top_DB_bomb").val(totol_of_chemical_top_DB);
						     		     

						//== SET : SUB_TOTAL_ALL =======
						     total_price = parseFloat(total_price);		     
						     var  sub_total_all =  $(".total_all_bomb").val();
                      sub_total_all = replaceComma(sub_total_all);
						     	    sub_total_all = parseFloat(sub_total_all);
						     //alert(sub_total_price_Z014+'  '+total_price);

						     sub_total_all = parseFloat(sub_total_all+total_price);
						   	 sub_total_all = sub_total_all.toFixed(2);
                 
                 //add function comma
                 sub_total_all = commaSeparateNumber(sub_total_all);						     
						     $(".total_all_bomb").val(sub_total_all);

				}//chec get bomb or DB

			//////////////////////////// END : SET TOTAL //////////////////////////////////// 



    }//end if

    $(this).closest('table').find("select[name='select_chemical'] option[value='"+select_chemical+"']").remove();
		$(this).closest('table').find( "select[name='select_chemical'] option:first" ).prop("selected", true);

});//end click add
//<!--################################ END :ADD chemical ############################-->




//<!--################################ START :ADD TOOL ############################-->

	$('.add_tool').on('click',function(){

	
		
        var select_chemical = $(this).parents("tr").find("select[name='select_chemical']").val();
        //alert(select_chemical);

        var select_chemical_name = $(this).parents("tr").find(".select_chemical_name").val();
        //alert(select_chemical_name);

        var texture_id = $(this).parents("tr").find(".temp_texture_id").val();
        //alert(texture_id);        	

        var mat_type = $(this).parents("tr").find(".temp_mat_type").val();
       // alert(mat_type);

        var mat_group = $(this).parents("tr").find(".temp_mat_group").val();
        //alert(mat_group);

        var  quantity = $(this).parents("tr").find(".temp_quantity").val();
        //alert(quantity);

        var  unit = $(this).parents("tr").find(".temp_unit").val();
        //alert(unit);

        var  space = $(this).parents("tr").find(".temp_space").val();
        //alert(space);

        var  price = $(this).parents("tr").find(".price_chemical").val();
        //alert(price);

        var  total_price = $(this).parents("tr").find(".temp_total_price").val();
        //alert(total_price);


          // if(mat_type=='Z014'){
          //     quantity = -1;
          //     unit = -1;
          //     price = -1;
          //     space = -1;

          //   }//end if



        if (select_chemical == undefined || select_chemical == '' || select_chemical == 0 ||
        	select_chemical_name == undefined || select_chemical_name == '' || select_chemical_name == 0 ||
        	texture_id == undefined || texture_id == '' || texture_id == 0 ||
        	mat_type == undefined || mat_type == '' || mat_type == 0
        	){
            
           $(this).parents("tr").find('.text_msg1').html('กรุณากรอกข้อมูล');
       }

       if (quantity == undefined || quantity == '' || quantity == 0 ||
       		unit == undefined || unit == '' || unit == 0 ||
       		space == undefined || space == '' || space == 0
       	 ){
            $(this).parents("tr").find('.text_msg2').html('กรุณากรอกข้อมูล');
       }


       if (price == undefined || price == '' || price == 0 ){
            $(this).parents("tr").find('.text_msg3').html('กรุณากรอกข้อมูล');
       }

       if (total_price == undefined || total_price == '' || total_price == 0 ){
            $(this).parents("tr").find('.text_msg4').html('กรุณากรอกข้อมูล');
       }


    if (select_chemical != undefined && select_chemical != '' && select_chemical != 0 && 
    	select_chemical_name != undefined && select_chemical_name != '' && select_chemical_name != 0 && 
	    texture_id != undefined && texture_id != '' && texture_id != 0 && 
	  	mat_type != undefined && mat_type != '' && mat_type != 0 &&
	  	quantity != undefined && quantity != '' && quantity != 0 &&
	    unit != undefined && unit != '' && unit != 0 &&
	    space != undefined && space != '' && space != 0 &&
	    price != undefined && price != '' && price != 0 &&
	    total_price != undefined && total_price != '' && total_price != 0   
	    ){


    	var count = '';
    	//set count
    	if(mat_type =='Z002'){
    		count = $(this).parents(".div-table").find(".temp_count_tool_Z002").val();
    		//alert(count);
    		
    	}else if(mat_type =='Z014'){
    		count = $(this).parents(".div-table").find(".temp_count_tool_Z014").val();
    		//alert(count);
    		
    	}//end else

    	if(count==0){
			//alert('empty');
			$(this).parents(".table_chemical").find('tbody').empty();
		}//end if
		
	  		
	  	count++; 
      var row =''; 

	  	 row = "<tr class='tx-green h5' id='"+select_chemical+"'>" +
           "<td>" +
            parseInt(select_chemical)+' '+select_chemical_name+
            "<input type='hidden' readonly class='form-control texture_id' name='texture_id_"+count+"_"+mat_type+"' value='"+texture_id+"'>" +
            "<input type='hidden' readonly class='form-control material_no' name='material_no_"+count+"_"+mat_type+"' value='"+select_chemical+"'>" +
            "<input type='hidden' readonly class='form-control mat_type' name='mat_type_"+count+"_"+mat_type+"' value='"+mat_type+"'>" +
            "<input type='hidden' readonly class='form-control mat_group' name='mat_group_"+count+"_"+mat_type+"' value='"+mat_group+"'>" +
          "</td>"+  

           "<td class='tx-center'>" +
              quantity+' '+unit+        
            "<input type='hidden' readonly class='form-control space' name='space_"+count+"_"+mat_type+"' value='"+space+"'>" +
            "<input type='hidden' readonly class='form-control quantity' name='quantity_"+count+"_"+mat_type+"' value='"+quantity+"'>" +
            "<input type='hidden' readonly class='form-control unit_code' name='unit_code_"+count+"_"+mat_type+"' value='"+unit+"'>" +
          "</td>"+

          "<td class='text-right'>" +
             price+
            "<input type='hidden' readonly class='form-control price ' name='price_"+count+"_"+mat_type+"' value='"+replaceComma(price)+"'>" +
          "</td>"+


          "<td class='text-right'>" +
            total_price+
            "<input type='hidden' readonly class='form-control total_price' name='total_price_"+count+"_"+mat_type+"' value='"+replaceComma(total_price)+"'>" +
          "</td>"+             

          // "<td class='tx-center'>" +                      
          //  "<span class='margin-left-small'><button type='button' onclick='SomeDeleteRowFunction_total("+total_price+",this);' class='btn btn-default '><i class='fa fa-trash-o'></i></button></span>"+
          // "</td>"+  

          "<td class='tx-center'>" +                      
           "<span class='margin-left-small'><button type='button'  data-id='"+select_chemical+"' data-txt='"+parseInt(select_chemical)+" "+select_chemical_name+"' onclick='SomeDeleteRowFunction_total("+replaceComma(total_price)+",this);' class='btn btn-default '><i class='fa fa-trash-o'></i></button></span>"+
          "</td>"+  

        "</tr>";
   



        //ADD : row to table
        $(this).parents(".table_chemical").find("tbody").append(row);

        if(mat_type=='Z002'){
	      	$(this).parents(".div-table").find("input[name='temp_count_tool_Z002']").val(count);

	      }else if(mat_type=='Z014'){
	      	$(this).parents(".div-table").find("input[name='temp_count_tool_Z014']").val(count);
	      }


         //==  set : null
	      //$(this).parents(".table_chemical").find('tr .select_chemical').val('0');
	      //$(this).parents(".table_chemical").find('tr .select_chemical option[value="'+select_chemical+'"]').remove();
        $(this).parents(".table_chemical").find('tr .select_chemical .select2-chosen').html('กรุณาเลือก');

	      $(this).parents(".table_chemical").find('tr .select_chemical_name').val('');
	      $(this).parents(".table_chemical").find('tr .temp_mat_group').val('');

	      $(this).parents(".table_chemical").find('tr .temp_quantity').val('');
	      $(this).parents(".table_chemical").find('tr .temp_quantity').attr('readonly', true);
	      $(this).parents(".table_chemical").find('tr .text_unit').html('หน่วย');
	      $(this).parents(".table_chemical").find('tr .temp_unit').val('');
	      $(this).parents(".table_chemical").find('tr .price_chemical').val('');
	      $(this).parents(".table_chemical").find('tr .temp_total_price').val('');

	      $(this).parents(".table_chemical").find('.text_msg1').html('');
	      $(this).parents(".table_chemical").find('.text_msg2').html('');
	      $(this).parents(".table_chemical").find('.text_msg3').html('');
	      $(this).parents(".table_chemical").find('.text_msg4').html('');

	      



			//////////////////////////// START : SET TOTAL //////////////////////////////////// 
				var check_data_from_DB_input = $(".check_data_from_DB_input").val();
					//alert(check_data_from_DB_input);

        total_price = replaceComma(total_price);
				if(check_data_from_DB_input==1){
				        //== set temp_count_chemical ===
							//alert(temp_space_no+' '+count);
						if(mat_type=='Z002'){			
							//== SET SUB_TOTAL_TOOL =======
						     total_price = parseFloat(total_price);			     
						     var  sub_total_price_Z002 =  $(".sub_total_price_Z002").val();
						     	    sub_total_price_Z002 = parseFloat(sub_total_price_Z002);
						     //alert(sub_total_price_Z002+'  '+total_price);
						     sub_total_price_Z002 = parseFloat(sub_total_price_Z002+total_price);
						   	 sub_total_price_Z002 = sub_total_price_Z002.toFixed(2);
						     $(".sub_total_price_Z002").val(sub_total_price_Z002);
                 //add function comma
                 sub_total_price_Z002 = commaSeparateNumber(sub_total_price_Z002);
						     $(".sub_total_Z002_DB").val(sub_total_price_Z002);

						}else if(mat_type=='Z014'){
							
							//== SET SUB_TOTAL_TOOL =======
						     total_price = parseFloat(total_price);			     
						     var  sub_total_price_Z014 =  $(".sub_total_price_Z014").val();
						     	    sub_total_price_Z014 = parseFloat(sub_total_price_Z014);
						     //alert(sub_total_price_Z014+'  '+total_price);
						     sub_total_price_Z014 = parseFloat(sub_total_price_Z014+total_price);
						   	 sub_total_price_Z014 = sub_total_price_Z014.toFixed(2);
						     $(".sub_total_price_Z014").val(sub_total_price_Z014);
                 //add function comma
                 sub_total_price_Z014 = commaSeparateNumber(sub_total_price_Z014);
						     $(".sub_total_Z014_DB").val(sub_total_price_Z014);
						}

						//== SET : SUB_TOTAL_ALL =======
						     total_price = parseFloat(total_price);			     
						     var  sub_total_all =  $(".total_all").val();
                      sub_total_all = replaceComma(sub_total_all);
						     	    sub_total_all = parseFloat(sub_total_all);
						     //alert(sub_total_price_Z014+'  '+total_price);
						     sub_total_all = parseFloat(sub_total_all+total_price);
						   	 sub_total_all = sub_total_all.toFixed(2);
                 //add function comma
                 sub_total_all = commaSeparateNumber(sub_total_all);		     
						     $(".total_all").val(sub_total_all);
				}else{

					if(mat_type=='Z002'){			
							//== SET SUB_TOTAL_TOOL =======
						     total_price = parseFloat(total_price);			     
						     var  sub_total_price_Z002 =  $(".sub_total_price_Z002_bomb").val();
						     	    sub_total_price_Z002 = parseFloat(sub_total_price_Z002);
						     //alert(sub_total_price_Z002+'  '+total_price);
						     sub_total_price_Z002 = parseFloat(sub_total_price_Z002+total_price);
						   	 sub_total_price_Z002 = sub_total_price_Z002.toFixed(2);
						     $(".sub_total_price_Z002_bomb").val(sub_total_price_Z002);
                  //add function comma
                  sub_total_price_Z002 = commaSeparateNumber(sub_total_price_Z002);						     
                 $(".sub_total_Z002_DB_bomb").val(sub_total_price_Z002);

						}else if(mat_type=='Z014'){

							//== SET SUB_TOTAL_TOOL =======
						     total_price = parseFloat(total_price);			     
						     var sub_total_price_Z014 =  $(".sub_total_price_Z014_bomb").val();
						     	   sub_total_price_Z014 = parseFloat(sub_total_price_Z014);
						     //alert(sub_total_price_Z014+'  '+total_price);
						     sub_total_price_Z014 = parseFloat(sub_total_price_Z014+total_price);
						   	 sub_total_price_Z014 = sub_total_price_Z014.toFixed(2);
						     $(".sub_total_price_Z014_bomb").val(sub_total_price_Z014);
                 //add function comma
                  sub_total_price_Z014 = commaSeparateNumber(sub_total_price_Z014); 
						     $(".sub_total_Z014_DB_bomb").val(sub_total_price_Z014);
						}

						//== SET : SUB_TOTAL_ALL =======
						     total_price = parseFloat(total_price);			     
						     var sub_total_all =  $(".total_all_bomb").val();
                     sub_total_all = replaceComma(sub_total_all);
						     	   sub_total_all = parseFloat(sub_total_all);
						     //alert(sub_total_price_Z014+'  '+total_price);
						     sub_total_all = parseFloat(sub_total_all+total_price);
						   	 sub_total_all = sub_total_all.toFixed(2);
                //add function comma
                sub_total_all = commaSeparateNumber(sub_total_all);		     
						    $(".total_all_bomb").val(sub_total_all);

				}//end check bomb or DB

			//////////////////////////// END : SET TOTAL ////////////////////////////////////     

	     


    }//end if

    $(this).closest('table').find("select[name='select_chemical'] option[value='"+select_chemical+"']").remove();
    $(this).closest('table').find( "select[name='select_chemical'] option:first" ).prop("selected", true);

		

});//end click add
//<!--################################ END :ADD TOOL ############################-->




//<!--################################ START :ADD machine ############################-->

	$('.add_machine').on('click',function(){

			
    var group_machines_sel = $(this).parents("tr").find("select.group_machines").val();

		var group_machines = $(this).parents("tr").find("input[name='group_machines']").val();
        //alert(group_machines);

        var select_chemical = $(this).parents("tr").find("select[name='select_chemical']").val();
        //alert(select_chemical);

        var select_chemical_name = $(this).parents("tr").find(".select_chemical_name").val();
        //alert(select_chemical_name);

        var texture_id = $(this).parents("tr").find(".temp_texture_id").val();
        //alert(texture_id);        	

        var mat_type = $(this).parents("tr").find(".temp_mat_type").val();
       // alert(mat_type);

        var mat_group = $(this).parents("tr").find(".temp_mat_group").val();
        //alert(mat_group);

        var  quantity = $(this).parents("tr").find(".temp_quantity").val();
        //alert(quantity);

        var  unit = $(this).parents("tr").find(".temp_unit").val();
        //alert(unit);

        var  space = $(this).parents("tr").find(".temp_space").val();
        //alert(space);

        var  price = $(this).parents("tr").find(".price_chemical").val();
        //alert(price);

        var  total_price = $(this).parents("tr").find(".temp_total_price").val();
        //alert(total_price);



        if (select_chemical == undefined || select_chemical == '' || select_chemical == 0 ||
        	select_chemical_name == undefined || select_chemical_name == '' || select_chemical_name == 0 ||
        	texture_id == undefined || texture_id == '' || texture_id == 0 ||
        	mat_type == undefined || mat_type == '' || mat_type == 0
        	){
            
           $(this).parents("tr").find('.text_msg1').html('กรุณากรอกข้อมูล');
       }

       if (quantity == undefined || quantity == '' || quantity == 0 ||
       		unit == undefined || unit == '' || unit == 0 ||
       		space == undefined || space == '' || space == 0
       	 ){
            $(this).parents("tr").find('.text_msg2').html('กรุณากรอกข้อมูล');
       }


       if (price == undefined || price == '' || price == 0 ){
            $(this).parents("tr").find('.text_msg3').html('กรุณากรอกข้อมูล');
       }

       if (total_price == undefined || total_price == '' || total_price == 0 ){
            $(this).parents("tr").find('.text_msg4').html('กรุณากรอกข้อมูล');
       }

        if (group_machines == undefined || group_machines == '' || group_machines == 0 ){
            $(this).parents("tr").find('.text_msg5').html('กรุณากรอกข้อมูล');
       }


    if (group_machines != undefined && group_machines != '' && group_machines != 0 && 
    	select_chemical != undefined && select_chemical != '' && select_chemical != 0 && 
    	select_chemical_name != undefined && select_chemical_name != '' && select_chemical_name != 0 && 
	    texture_id != undefined && texture_id != '' && texture_id != 0 && 
	  	mat_type != undefined && mat_type != '' && mat_type != 0 &&
	  	quantity != undefined && quantity != '' && quantity != 0 &&
	    unit != undefined && unit != '' && unit != 0 &&
	    space != undefined && space != '' && space != 0 &&
	    price != undefined && price != '' && price != 0 &&
	    total_price != undefined && total_price != '' && total_price != 0   
	    ){

    	//set count
    	var count = $(this).parents(".div-table").find(".temp_count_machine").val();
    		//alert(count);
    	    	
    	if(count==0){
			//alert('empty');
			$(this).parents(".table_chemical").find('tbody').empty();
		}//end if
		
	  		
	  	count++; 

	  	var row = "<tr class='tx-green h5' id='"+select_chemical+"'>" +
	  	   "<td>" +
		  	   group_machines+
		  	   "<input type='hidden' readonly class='form-control mat_group_des' name='mach_mat_group_des_"+count+"' value='"+group_machines+"'>" +
	  	   "</td>" +

           "<td>" +
            parseInt(select_chemical)+' '+select_chemical_name+
            "<input type='hidden' readonly class='form-control texture_id' name='mach_texture_id_"+count+"' value='"+texture_id+"'>" +
            "<input type='hidden' readonly class='form-control material_no' name='mach_material_no_"+count+"' value='"+select_chemical+"'>" +
            "<input type='hidden' readonly class='form-control mat_type' name='mach_mat_type_"+count+"' value='"+mat_type+"'>" +
            "<input type='hidden' readonly class='form-control mat_group' name='mach_mat_group_"+count+"' value='"+mat_group+"'>" +
          "</td>"+  

           "<td class='tx-center'>" +
              quantity+' '+unit+        
            "<input type='hidden' readonly class='form-control space' name='mach_space_"+count+"' value='"+space+"'>" +
            "<input type='hidden' readonly class='form-control quantity' name='mach_quantity_"+count+"' value='"+quantity+"'>" +
            "<input type='hidden' readonly class='form-control unit_code' name='mach_unit_code_"+count+"' value='"+unit+"'>" +
          "</td>"+

          "<td class='text-right'>" +
            price+
            "<input type='hidden' readonly class='form-control price' name='mach_price_"+count+"' value='"+replaceComma(price)+"'>" +
          "</td>"+

          "<td class='text-right'>" +
            total_price+
            "<input type='hidden' readonly class='form-control total_price' name='mach_total_price_"+count+"' value='"+replaceComma(total_price)+"'>" +
          "</td>"+             

          "<td class='tx-center'>" +                      
           "<span class='margin-left-small'><button type='button' data-id='"+select_chemical+"' data-txt='"+parseInt(select_chemical)+" "+select_chemical_name+"' data-group='"+group_machines_sel+"' onclick='SomeDeleteRowFunction_total("+replaceComma(total_price)+",this);' class='btn btn-default '><i class='fa fa-trash-o'></i></button></span>"+
          "</td>"+  

        "</tr>";

        //ADD : row to table
        $(this).parents(".table_chemical").find("tbody").append(row);


        //== set temp_count_chemical ===
		//alert(count);
		$(this).parents(".div-table").find(".temp_count_machine").val(count);


		 //==  set : null
          //$(this).parents(".table_chemical").find('tr .group_machines').val('0');
          $(this).parents(".table_chemical").find('tr .group_machines .select2-chosen').html('กรุณาเลือก');

	      //$(this).parents(".table_chemical").find('tr .select_chemical').val('0');
	      //$(this).parents(".table_chemical").find('tr .select_chemical option[value="'+select_chemical+'"]').remove();
          $(this).parents(".table_chemical").find('tr .select_chemical .select2-chosen').html('กรุณาเลือก');


	      $(this).parents(".table_chemical").find('tr .select_chemical_name').val('');
	      $(this).parents(".table_chemical").find('tr .temp_mat_group').val('');

	      $(this).parents(".table_chemical").find('tr .temp_quantity').val('');
	      $(this).parents(".table_chemical").find('tr .temp_quantity').attr('readonly', true);
	      $(this).parents(".table_chemical").find('tr .text_unit').html('หน่วย');
	      $(this).parents(".table_chemical").find('tr .temp_unit').val('');
	      $(this).parents(".table_chemical").find('tr .price_chemical').val('');
	      $(this).parents(".table_chemical").find('tr .temp_total_price').val('');

	      $(this).parents(".table_chemical").find('.text_msg1').html('');
	      $(this).parents(".table_chemical").find('.text_msg2').html('');
	      $(this).parents(".table_chemical").find('.text_msg3').html('');
	      $(this).parents(".table_chemical").find('.text_msg4').html('');
	      $(this).parents(".table_chemical").find('.text_msg5').html('');


		//////////////////////////// START : SET TOTAL ////////////////////////////////////   
			var check_data_from_DB_input = $(".check_data_from_DB_input").val();
				//alert(check_data_from_DB_input);
      total_price = replaceComma(total_price);
			if(check_data_from_DB_input==1){
					//== SET SUB_TOTAL_MACHiE =======
					     total_price = parseFloat(total_price);			     
					     var sub_total_price_Z005 =  $(".sub_total_price_Z005").val();
					     	 sub_total_price_Z005 = parseFloat(sub_total_price_Z005);
					     //alert(sub_total_price_Z014+'  '+total_price);
					     sub_total_price_Z005 = parseFloat(sub_total_price_Z005+total_price);
					   	 sub_total_price_Z005 = sub_total_price_Z005.toFixed(2);
					     $(".sub_total_price_Z005").val(sub_total_price_Z005);
               //add function comma
               sub_total_price_Z005 = commaSeparateNumber(sub_total_price_Z005);
					     $(".sub_total_Z005_DB").val(sub_total_price_Z005);

					//== SET : SUB_TOTAL_ALL =======
					     total_price = parseFloat(total_price);			     
					     var sub_total_all =  $(".total_all").val();
                   sub_total_all = replaceComma(sub_total_all);
					     	   sub_total_all = parseFloat(sub_total_all);
					     //alert(sub_total_price_Z014+'  '+total_price);
					     sub_total_all = parseFloat(sub_total_all+total_price);
					   	 sub_total_all = sub_total_all.toFixed(2);
               //add function comma
               sub_total_all = commaSeparateNumber(sub_total_all);	     
					     $(".total_all").val(sub_total_all);
			}else{

				//== SET SUB_TOTAL_MACHiE =======
					     total_price = parseFloat(total_price);			     
					     var sub_total_price_Z005 =  $(".sub_total_price_Z005_bomb").val();
					     	   sub_total_price_Z005 = parseFloat(sub_total_price_Z005);
					     //alert(sub_total_price_Z014+'  '+total_price);

					     sub_total_price_Z005 = parseFloat(sub_total_price_Z005+total_price);
					   	 sub_total_price_Z005 = sub_total_price_Z005.toFixed(2);  
					     $(".sub_total_price_Z005_bomb").val(sub_total_price_Z005);
               //add function comma
               sub_total_price_Z005 = commaSeparateNumber(sub_total_price_Z005);
					     $(".sub_total_Z005_DB_bomb").val(sub_total_price_Z005);

					//== SET : SUB_TOTAL_ALL =======
					     total_price = parseFloat(total_price);			     
					     var sub_total_all =  $(".total_all_bomb").val();
                   sub_total_all = replaceComma(sub_total_all);
					     	   sub_total_all = parseFloat(sub_total_all);
					     //alert(sub_total_price_Z014+'  '+total_price);
					     sub_total_all = parseFloat(sub_total_all+total_price);
					   	 sub_total_all = sub_total_all.toFixed(2);
               //add function comma
               sub_total_all = commaSeparateNumber(sub_total_all);
					     $(".total_all_bomb").val(sub_total_all);

			}//end check bomb or DB	

		//////////////////////////// END : SET TOTAL ////////////////////////////////////      

	     


    }//end if

    $(this).closest('table').find("select[name='select_chemical']").attr('disabled', true);
    $(this).closest('table').find( "select[name='select_chemical'] option:first" ).prop("selected", true);
    $(this).closest('table').find( "select[name='group_machines_slected'] option:first" ).prop("selected", true);

		

});//end click add
//<!--################################ END :ADD machine ############################-->




//<!--################################ START :ADD chemical request ############################-->

	$('.add_request').on('click',function(){

		//alert('test');
		
		
        var select_chemical = $(this).parents("tr").find("select[name='select_chemical']").val();
        //alert(select_chemical);

        var select_chemical_name = $(this).parents("tr").find(".select_chemical_name").val();
        //alert(select_chemical_name);    	

        var mat_type = $(this).parents("tr").find(".temp_mat_type").val();
        //alert(mat_type);

        var mat_group = $(this).parents("tr").find(".temp_mat_group").val();
        //alert(mat_group);

        var  quantity = $(this).parents("tr").find(".temp_quantity").val();
        //alert(quantity);

        var  unit = $(this).parents("tr").find(".temp_unit").val();
        //alert(unit);


        var  price = $(this).parents("tr").find(".price_chemical").val();
        //alert(price);

        var  total_price = $(this).parents("tr").find(".temp_total_price").val();
        //alert(total_price);

        // //set no data
        // if(mat_type=='Z013' || mat_type=='Z014'){
        //       quantity = -1;
        //       unit = -1;
        //       price = -1;

        // }//end if


        var group_machines_sel = '';
        var group_machines = '';
        if(mat_type=='Z005'){
          group_machines_sel = $(this).parents("tr").find("select[name='group_machines_slected']").val();
        	group_machines = $(this).parents("tr").find("input[name='group_machines']").val();
        }else{
        	group_machines='no_data';
        }//end else
        //alert(group_machines);


        if(mat_type=='Z005'){
        	if ( group_machines == undefined || group_machines == '' || group_machines == 0 ){            
           		$(this).parents("tr").find('.text_msg5').html('กรุณากรอกข้อมูล');
       		}//end if
       	}//end if


        if (select_chemical == undefined || select_chemical == '' || select_chemical == 0 ||
        	select_chemical_name == undefined || select_chemical_name == '' || select_chemical_name == 0 ||        	
        	mat_type == undefined || mat_type == '' || mat_type == 0
        	){
            
           $(this).parents("tr").find('.text_msg1').html('กรุณากรอกข้อมูล');
       }

       if (quantity == undefined || quantity == '' || quantity == 0 ||
       		unit == undefined || unit == '' || unit == 0        		
       	 ){
            $(this).parents("tr").find('.text_msg2').html('กรุณากรอกข้อมูล');
       }


       if (price == undefined || price == '' || price == 0 ){
            $(this).parents("tr").find('.text_msg3').html('กรุณากรอกข้อมูล');
       }

       if (total_price == undefined || total_price == '' || total_price == 0 ){
            $(this).parents("tr").find('.text_msg4').html('กรุณากรอกข้อมูล');
       }


    if (select_chemical != undefined && select_chemical != '' && select_chemical != 0 && 
    	select_chemical_name != undefined && select_chemical_name != '' && select_chemical_name != 0 && 
	    mat_type != undefined && mat_type != '' && mat_type != 0 &&
	  	quantity != undefined && quantity != '' && quantity != 0 &&
	    unit != undefined && unit != '' && unit != 0 &&
	    price != undefined && price != '' && price != 0 &&
	    total_price != undefined && total_price != '' && total_price != 0   &&
	    group_machines != undefined && group_machines != '' && group_machines != 0       
	    ){

    	//set count
    	var count = $(".count_request").val();
    	var check_data = $(this).parents(".div-table").find(".check_data").val();

    		if(check_data==0){
    			//alert('empty');
    			$(this).parents(".table_chemical").find('tbody').empty();
    			$(this).parents(".div-table").find(".check_data").val(1);
    		}else{
    			$(this).parents(".div-table").find(".check_data").val(1);
    		}

	  	count++; 

	  	var row = "<tr class='tx-green h5' id='"+select_chemical+"'>";

	  	if(mat_type =="Z005"){
	  		row += "<td>";
	  		row += group_machines;
	  		row += "<input type='hidden' readonly class='form-control mat_group_des' name='mat_group_des_"+count+"' value='"+group_machines+"'>";
	  		row += "</td>";
	  	}//end if
	  			  		
	  		row += "<td>";
	  		row += parseInt(select_chemical)+' '+select_chemical_name;
	  		row += "<input type='hidden' readonly class='form-control material_no' name='material_no_"+count+"' value='"+select_chemical+"'>";
	  		row += "<input type='hidden' readonly class='form-control mat_type' name='mat_type_"+count+"' value='"+mat_type+"'>";
	  		row += "<input type='hidden' readonly class='form-control mat_group' name='mat_group_"+count+"' value='"+mat_group+"'>";
	  		row += "</td>";
      
        //if(mat_type!='Z013' && mat_type!='Z014'){ }//end if
  	  		row += "<td class='tx-center'>";
  	  		row += quantity+' '+unit;
  	  		row += "<input type='hidden' readonly class='form-control quantity' name='quantity_"+count+"' value='"+quantity+"'>";
  	  		row += "<input type='hidden' readonly class='form-control unit_code' name='unit_code_"+count+"' value='"+unit+"'>";
  	  		row += "</td>";

  	  		row += "<td class='text-right'>";
  	  		row += price;
  	  		row +=  "<input type='hidden' readonly class='form-control price' name='price_"+count+"' value='"+replaceComma(price)+"'>";
  	  		row += "</td>";
       

	  		row += "<td class='text-right'>";
	  		row += total_price;
	  		row += "<input type='hidden' readonly class='form-control total_price' name='total_price_"+count+"' value='"+replaceComma(total_price)+"'>";
	  		row += "</td>";

	  		row += "<td class='tx-center'>";
	  		row += "<span class='margin-left-small'><button type='button' data-id='"+select_chemical+"' data-txt='"+parseInt(select_chemical)+" "+select_chemical_name+"'";

        if(mat_type =="Z005"){
          row += " data-group='"+group_machines_sel+"'";
        }

        row += " onclick='SomeDeleteRowFunction_totalRequest("+replaceComma(total_price)+",this);' class='btn btn-default '><i class='fa fa-trash-o'></i></button></span>";
	  		row += "</td>";

        //ADD : row to table
        $(this).parents(".table_chemical").find("tbody").append(row);

        //== set temp_count_chemical ===
			//alert(temp_space_no+' '+count);
			$(".count_request").val(count);

        //==  set : null
	      //$(this).parents(".table_chemical").find('tr .select_chemical').val('0');
	      //$(this).parents(".table_chemical").find('tr .select_chemical option[value="'+select_chemical+'"]').remove();
          $(this).parents(".table_chemical").find('tr .select_chemical .select2-chosen').html('กรุณาเลือก');

	      $(this).parents(".table_chemical").find('tr .select_chemical_name').val('');
	      $(this).parents(".table_chemical").find('tr .temp_mat_group').val('');

	      $(this).parents(".table_chemical").find('tr .temp_quantity').val('');
	      $(this).parents(".table_chemical").find('tr .temp_quantity').attr('readonly', true);
	      $(this).parents(".table_chemical").find('tr .text_unit').html('หน่วย');
	      $(this).parents(".table_chemical").find('tr .temp_unit').val('');
	      $(this).parents(".table_chemical").find('tr .price_chemical').val('');
	      $(this).parents(".table_chemical").find('tr .temp_total_price').val('');

	      $(this).parents(".table_chemical").find('.text_msg1').html('');
	      $(this).parents(".table_chemical").find('.text_msg2').html('');
	      $(this).parents(".table_chemical").find('.text_msg3').html('');
	      $(this).parents(".table_chemical").find('.text_msg4').html('');

	    if(mat_type=='Z005'){

	    	  //$(this).parents(".table_chemical").find('tr .select_chemical option[value="'+select_chemical+'"]').remove();
              $(this).parents(".table_chemical").find('tr .group_machines .select2-chosen').html('กรุณาเลือก');
	    	  $(this).parents(".table_chemical").find('.text_msg5').html('');
	  	}//end if
	     
			//////////////////////// START : SET TOTAL //////////////////////////////////

				  	////////////////  SUMMARY TOTAL //////////////////
            total_price = replaceComma(total_price);    
				  	if(mat_type=='Z001'){
              //alert("Z001");
				  		//== SET SUB_TOTAL_Z001 =======
					     total_price = parseFloat(total_price);			     
					     var sub_total_request_Z001 =  $(".sub_total_request_Z001").val();
					     	   sub_total_request_Z001 = parseFloat(sub_total_request_Z001);
					     //alert(sub_total_price_Z014+'  '+total_price);

					     sub_total_request_Z001 = parseFloat(sub_total_request_Z001+total_price);
					   	 sub_total_request_Z001 = sub_total_request_Z001.toFixed(2);
					     $(".sub_total_request_Z001").val(sub_total_request_Z001);
                //add function comma
               sub_total_request_Z001 = commaSeparateNumber(sub_total_request_Z001);
					     $(".sub_total_request_Z001_input").val(sub_total_request_Z001);


					     //== SET : totol_of_chemical_top_DB =======		     
					     var sub_total_request_chemical_top =  $(".sub_total_request_chemical_top").val();
					     	   sub_total_request_chemical_top = parseFloat(sub_total_request_chemical_top);
					     //alert(sub_total_price_Z014+'  '+total_price);

					     sub_total_request_chemical_top = parseFloat(sub_total_request_chemical_top+total_price);
					   	 sub_total_request_chemical_top = sub_total_request_chemical_top.toFixed(2);
               $(".sub_total_request_chemical_top").val(sub_total_request_chemical_top);
					     //add function comma
               sub_total_request_chemical_top = commaSeparateNumber(sub_total_request_chemical_top);
					     $(".sub_total_request_chemical_input").val(sub_total_request_chemical_top);
					    
				  	}

				  	if(mat_type=='Z013'){
				  		//== SET SUB_TOTAL_Z0013 =======
					     total_price = parseFloat(total_price);			     
					     var sub_total_request_Z013 =  $(".sub_total_request_Z013").val();
					     	   sub_total_request_Z013 = parseFloat(sub_total_request_Z013);
					     //alert(sub_total_price_Z014+'  '+total_price);
					     sub_total_request_Z013 = parseFloat(sub_total_request_Z013+total_price);
					   	 sub_total_request_Z013 = sub_total_request_Z013.toFixed(2);
					     $(".sub_total_request_Z013").val(sub_total_request_Z013);
               //add function comma
               sub_total_request_Z013 = commaSeparateNumber(sub_total_request_Z013);
					     $(".sub_total_request_Z013_input").val(sub_total_request_Z013);
					     

					     //== SET : totol_of_chemical_top_DB =======		     
					     var sub_total_request_chemical_top =  $(".sub_total_request_chemical_top").val();
					     	   sub_total_request_chemical_top = parseFloat(sub_total_request_chemical_top);
					     //alert(sub_total_price_Z014+'  '+total_price);

					     sub_total_request_chemical_top = parseFloat(sub_total_request_chemical_top+total_price);
					   	 sub_total_request_chemical_top = sub_total_request_chemical_top.toFixed(2);
               $(".sub_total_request_chemical_top").val(sub_total_request_chemical_top);
					     //add function comma
               sub_total_request_chemical_top = commaSeparateNumber(sub_total_request_chemical_top);
					     $(".sub_total_request_chemical_input").val(sub_total_request_chemical_top);
					    
				  	}

				  	if(mat_type=='Z005'){
				  		//== SET SUB_TOTAL_Z005 =======
					     total_price = parseFloat(total_price);			     
					     var sub_total_request_Z005 =  $(".sub_total_request_Z005").val();
					     	   sub_total_request_Z005 = parseFloat(sub_total_request_Z005);
					     //alert(sub_total_price_Z014+'  '+total_price);
					     sub_total_request_Z005 = parseFloat(sub_total_request_Z005+total_price);
					   	 sub_total_request_Z005 = sub_total_request_Z005.toFixed(2);
					     $(".sub_total_request_Z005").val(sub_total_request_Z005);
               //add function comma
               sub_total_request_Z005 = commaSeparateNumber(sub_total_request_Z005);
					     $(".sub_total_request_Z005_input").val(sub_total_request_Z005);		   
				  	}

				  	if(mat_type=='Z002'){
				  		//== SET SUB_TOTAL_Z002 =======
					     total_price = parseFloat(total_price);			     
					     var sub_total_request_Z002 =  $(".sub_total_request_Z002").val();
					     	   sub_total_request_Z002 = parseFloat(sub_total_request_Z002);
					     //alert(sub_total_price_Z014+'  '+total_price);
					     sub_total_request_Z002 = parseFloat(sub_total_request_Z002+total_price);
					   	 sub_total_request_Z002 = sub_total_request_Z002.toFixed(2);
					     $(".sub_total_request_Z002").val(sub_total_request_Z002);
               //add function comma
               sub_total_request_Z002 = commaSeparateNumber(sub_total_request_Z002);
					     $(".sub_total_request_Z002_input").val(sub_total_request_Z002);		   
				  	}

				  	if(mat_type=='Z014'){
				  		//== SET SUB_TOTAL_Z002 =======
					     total_price = parseFloat(total_price);			     
					     var sub_total_request_Z014 =  $(".sub_total_request_Z014").val();
					     	   sub_total_request_Z014 = parseFloat(sub_total_request_Z014);
					     //alert(sub_total_price_Z014+'  '+total_price);
					     sub_total_request_Z014 = parseFloat(sub_total_request_Z014+total_price);
					   	 sub_total_request_Z014 = sub_total_request_Z014.toFixed(2);
					     $(".sub_total_request_Z014").val(sub_total_request_Z014);
                //add function comma
               sub_total_request_Z014 = commaSeparateNumber(sub_total_request_Z014);
					     $(".sub_total_request_Z014_input").val(sub_total_request_Z014);		   
				  	}
				
					//== SET : SUB_TOTAL_ALL =======
					     total_price = parseFloat(total_price);			     
					     var total_all_request =  $(".total_all_request").val();
                   total_all_request = replaceComma(total_all_request);
					     	   total_all_request = parseFloat(total_all_request);
					     //alert(sub_total_price_Z014+'  '+total_price);
					     total_all_request = parseFloat(total_all_request+total_price);
					   	 total_all_request = total_all_request.toFixed(2);
               //add function comma
               total_all_request = commaSeparateNumber(total_all_request);					     
					     $(".total_all_request").val(total_all_request);

				//////////////////////// START : SET TOTAL //////////////////////////////////	

    }//end if


    if(mat_type=='Z005'){
      $(this).closest('table').find("select[name='select_chemical']").attr('disabled', true);
      $(this).closest('table').find( "select[name='select_chemical'] option:first" ).prop("selected", true);
      $(this).closest('table').find( "select[name='group_machines_slected'] option:first" ).prop("selected", true);
    } else {
      $(this).closest('table').find("select[name='select_chemical'] option[value='"+select_chemical+"']").remove();
      $(this).closest('table').find( "select[name='select_chemical'] option:first" ).prop("selected", true);
    }
		

});//end click add
//<!--################################ END :ADD chemical request ############################-->







})// end document
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////








//############################ start : delete row   ##################################################
 function SomeDeleteRowFunction_total(total_price,btndel) {

 	var check_data_from_DB_input = $(".check_data_from_DB_input").val();
 	
    if (typeof(btndel) == "object") {

    $('#modal-delete-area').modal();
    $('.del_area_confirm').off();
    $('.del_area_confirm').on('click', function () {
	
	  total_price = parseFloat(total_price);
	//alert(total_price);		
   	var mat_type = $(btndel).parents("tr").find(".mat_type").val();
    //alert(mat_type);
    var texture_id = $(btndel).parents("tr").find(".texture_id").val();

    // var mat_no = $(btndel).closest('table').data('id');
    // var old_total = $(btndel).closest('table').find('.sub_total_'+mat_type+'_'+mat_no+'_DB').val();
    // var new_total = parseFloat(old_total) - parseFloat(total_price);
    // $(btndel).closest('table').find('.sub_total_'+mat_type+'_'+mat_no+'_DB').val(new_total);
//////////////////////// START : SET DELETE SUB TOTAL ///////////////////////////////////////////
    if(check_data_from_DB_input==1){

    	if(mat_type=='Z001'){	
		//== SET SUB_TOTAL_Z001 =======		     
		     var sub_total_price_Z001 =  $(".sub_total_price_Z001").val();
		     	   sub_total_price_Z001 = parseFloat(sub_total_price_Z001);
		     //alert(sub_total_price_Z014+'  '+total_price);
		     sub_total_price_Z001 = parseFloat(sub_total_price_Z001-total_price);
		   	 sub_total_price_Z001 = sub_total_price_Z001.toFixed(2);
		     $(".sub_total_price_Z001").val(sub_total_price_Z001);
         // add function comma
          sub_total_price_Z001 = commaSeparateNumber(sub_total_price_Z001);
		     $(".sub_total_Z001_DB").val(sub_total_price_Z001);

         var temp_ft_total = $(".sub_total_Z001_"+texture_id+"_DB").val();
             temp_ft_total = replaceComma(temp_ft_total);
             temp_ft_total = parseFloat(temp_ft_total);
             temp_ft_total = parseFloat(temp_ft_total-total_price);
             temp_ft_total = temp_ft_total.toFixed(2);
          //add function comma
          temp_ft_total = commaSeparateNumber(temp_ft_total);
         $(".sub_total_Z001_"+texture_id+"_DB").val(temp_ft_total);

		 //== SET : totol_of_chemical_top_DB =======		     
		  var totol_of_chemical_top_DB =  $(".totol_of_chemical_top_DB").val();
          totol_of_chemical_top_DB = replaceComma(totol_of_chemical_top_DB);
		     	totol_of_chemical_top_DB = parseFloat(totol_of_chemical_top_DB);
		     //alert(sub_total_price_Z014+'  '+total_price);
		     totol_of_chemical_top_DB = parseFloat(totol_of_chemical_top_DB-total_price);
		   	 totol_of_chemical_top_DB = totol_of_chemical_top_DB.toFixed(2);
         $(".sub_total_chemical_DB").val(totol_of_chemical_top_DB);
          //add function comma
          totol_of_chemical_top_DB = commaSeparateNumber(totol_of_chemical_top_DB);
          $(".totol_of_chemical_top_DB").val(totol_of_chemical_top_DB);
		
		}else if(mat_type=='Z013'){

			//== SET SUB_TOTAL_Z013 =======			     
		     var  sub_total_price_Z013 =  $(".sub_total_price_Z013").val();
		     	    sub_total_price_Z013 = parseFloat(sub_total_price_Z013);
		     //alert(sub_total_price_Z014+'  '+total_price);
		     sub_total_price_Z013 = parseFloat(sub_total_price_Z013-total_price);
		   	 sub_total_price_Z013 = sub_total_price_Z013.toFixed(2);
		     $(".sub_total_price_Z013").val(sub_total_price_Z013);
         // add function comma
         sub_total_price_Z013 = commaSeparateNumber(sub_total_price_Z013);
		     $(".sub_total_Z013_DB").val(sub_total_price_Z013);

          var temp_ft_total = $(".sub_total_Z013_"+texture_id+"_DB").val();
             temp_ft_total = replaceComma(temp_ft_total);
             temp_ft_total = parseFloat(temp_ft_total);
             temp_ft_total = parseFloat(temp_ft_total-total_price);
             temp_ft_total = temp_ft_total.toFixed(2);
          //add function comma
          temp_ft_total = commaSeparateNumber(temp_ft_total);
         $(".sub_total_Z013_"+texture_id+"_DB").val(temp_ft_total);

		  //== SET : totol_of_chemical_top_DB =======		     
		     var totol_of_chemical_top_DB =  $(".totol_of_chemical_top_DB").val();
             totol_of_chemical_top_DB = replaceComma(totol_of_chemical_top_DB);
		     	   totol_of_chemical_top_DB = parseFloat(totol_of_chemical_top_DB);
		     //alert(sub_total_price_Z014+'  '+total_price);
		     totol_of_chemical_top_DB = parseFloat(totol_of_chemical_top_DB-total_price);
		   	 totol_of_chemical_top_DB = totol_of_chemical_top_DB.toFixed(2);
         $(".sub_total_chemical_DB").val(totol_of_chemical_top_DB);
		     //add function comma
         totol_of_chemical_top_DB = commaSeparateNumber(totol_of_chemical_top_DB);
		     $(".totol_of_chemical_top_DB").val(totol_of_chemical_top_DB);
		     

		}else if(mat_type=='Z005'){

    		//== SET SUB_TOTAL_MACHiE =======		     
		     var sub_total_price_Z005 =  $(".sub_total_price_Z005").val();
		     	 sub_total_price_Z005 = parseFloat(sub_total_price_Z005);
		     //alert(sub_total_price_Z014+'  '+total_price);
		     sub_total_price_Z005 = parseFloat(sub_total_price_Z005-total_price);
		   	 sub_total_price_Z005 = sub_total_price_Z005.toFixed(2);
		     $(".sub_total_price_Z005").val(sub_total_price_Z005);
          //add function comma
         sub_total_price_Z005 = commaSeparateNumber(sub_total_price_Z005);
		     $(".sub_total_Z005_DB").val(sub_total_price_Z005);		 

		 }else if(mat_type=='Z002'){
		
			//== SET SUB_TOTAL_TOOL =======		     
		     var  sub_total_price_Z002 =  $(".sub_total_price_Z002").val();
		     	    sub_total_price_Z002 = parseFloat(sub_total_price_Z002);
		     //alert(sub_total_price_Z002+'  '+total_price);
		     sub_total_price_Z002 = parseFloat(sub_total_price_Z002-total_price);
		   	 sub_total_price_Z002 = sub_total_price_Z002.toFixed(2);
		   	 //alert('total_price :'+sub_total_price_Z002);
		     $(".sub_total_price_Z002").val(sub_total_price_Z002);
          //add function comma
         sub_total_price_Z002 = commaSeparateNumber(sub_total_price_Z002);
		     $(".sub_total_Z002_DB").val(sub_total_price_Z002);

		}else if(mat_type=='Z014'){
			
			//== SET SUB_TOTAL_TOOL =======		     
		     var sub_total_price_Z014 =  $(".sub_total_price_Z014").val();
		     	 sub_total_price_Z014 = parseFloat(sub_total_price_Z014);
		     //alert(sub_total_price_Z014+'  '+total_price);
		     sub_total_price_Z014 = parseFloat(sub_total_price_Z014-total_price);
		   	 sub_total_price_Z014 = sub_total_price_Z014.toFixed(2);
		     $(".sub_total_price_Z014").val(sub_total_price_Z014);
         //add function comma
         sub_total_price_Z014 = commaSeparateNumber(sub_total_price_Z014);
		     $(".sub_total_Z014_DB").val(sub_total_price_Z014);
		}


		//== SET : SUB_TOTAL_ALL =======		     
		     var  sub_total_all =  $(".total_all").val();
              sub_total_all = replaceComma(sub_total_all);
		     	    sub_total_all = parseFloat(sub_total_all);
		     //alert(sub_total_price_Z014+'  '+total_price);
		     sub_total_all = parseFloat(sub_total_all-total_price);
		   	 sub_total_all = sub_total_all.toFixed(2);	
         //add function comma
         sub_total_all = commaSeparateNumber(sub_total_all);	     
		     $(".total_all").val(sub_total_all);

	}else{

		if(mat_type=='Z001'){	
		//== SET SUB_TOTAL_Z001 =======		     
		     var sub_total_price_Z001 =  $(".sub_total_price_Z001_bomb").val();
		     	 sub_total_price_Z001 = parseFloat(sub_total_price_Z001);
		     //alert(sub_total_price_Z014+'  '+total_price);

		     sub_total_price_Z001 = parseFloat(sub_total_price_Z001-total_price);
		   	 sub_total_price_Z001 = sub_total_price_Z001.toFixed(2);
		     $(".sub_total_price_Z001_bomb").val(sub_total_price_Z001);
         //add function comma
         sub_total_price_Z001 = commaSeparateNumber(sub_total_price_Z001);
		     $(".sub_total_Z001_DB_bomb").val(sub_total_price_Z001);

         var temp_ft_total = $(".sub_total_Z001_"+texture_id+"_DB_bomb").val();
             temp_ft_total = replaceComma(temp_ft_total);
             temp_ft_total = parseFloat(temp_ft_total);
             temp_ft_total = parseFloat(temp_ft_total-total_price);
             temp_ft_total = temp_ft_total.toFixed(2);
          //add function comma
          temp_ft_total = commaSeparateNumber(temp_ft_total);
         $(".sub_total_Z001_"+texture_id+"_DB_bomb").val(temp_ft_total);

		 //== SET : totol_of_chemical_top_DB =======		     
		    var totol_of_chemical_top_DB =  $(".totol_of_chemical_top_DB_bomb").val();
            totol_of_chemical_top_DB = replaceComma(totol_of_chemical_top_DB);
		     	  totol_of_chemical_top_DB = parseFloat(totol_of_chemical_top_DB);
		     //alert(sub_total_price_Z014+'  '+total_price);

		     totol_of_chemical_top_DB = parseFloat(totol_of_chemical_top_DB-total_price);
		   	 totol_of_chemical_top_DB = totol_of_chemical_top_DB.toFixed(2);
		     $(".sub_total_chemical_DB_bomb").val(totol_of_chemical_top_DB);
         //add function comma
         totol_of_chemical_top_DB = commaSeparateNumber(totol_of_chemical_top_DB);
		     $(".totol_of_chemical_top_DB_bomb").val(totol_of_chemical_top_DB);
		     
         
		
		}else if(mat_type=='Z013'){

			//== SET SUB_TOTAL_Z013 =======			     
		     var  sub_total_price_Z013 =  $(".sub_total_price_Z013_bomb").val();
		     	    sub_total_price_Z013 = parseFloat(sub_total_price_Z013);
		     //alert(sub_total_price_Z014+'  '+total_price);

		     sub_total_price_Z013 = parseFloat(sub_total_price_Z013-total_price);
		   	 sub_total_price_Z013 = sub_total_price_Z013.toFixed(2);
		     $(".sub_total_price_Z013_bomb").val(sub_total_price_Z013);
         //add function comma
         sub_total_price_Z013 = commaSeparateNumber(sub_total_price_Z013);
		     $(".sub_total_Z013_DB_bomb").val(sub_total_price_Z013);

         var temp_ft_total = $(".sub_total_Z013_"+texture_id+"_DB_bomb").val();
             temp_ft_total = replaceComma(temp_ft_total);
             temp_ft_total = parseFloat(temp_ft_total);
             temp_ft_total = parseFloat(temp_ft_total-total_price);
             temp_ft_total = temp_ft_total.toFixed(2);
          //add function comma
          temp_ft_total = commaSeparateNumber(temp_ft_total);
         $(".sub_total_Z013_"+texture_id+"_DB_bomb").val(temp_ft_total);

		  //== SET : totol_of_chemical_top_DB =======		     
		     var  totol_of_chemical_top_DB =  $(".totol_of_chemical_top_DB_bomb").val();
              totol_of_chemical_top_DB = replaceComma(totol_of_chemical_top_DB);
		     	    totol_of_chemical_top_DB = parseFloat(totol_of_chemical_top_DB);
		     //alert(sub_total_price_Z014+'  '+total_price);

		     totol_of_chemical_top_DB = parseFloat(totol_of_chemical_top_DB-total_price);
		   	 totol_of_chemical_top_DB = totol_of_chemical_top_DB.toFixed(2);
         $(".sub_total_chemical_DB_bomb").val(totol_of_chemical_top_DB);		     
         //add function comma
         totol_of_chemical_top_DB = commaSeparateNumber(totol_of_chemical_top_DB);
		     $(".totol_of_chemical_top_DB_bomb").val(totol_of_chemical_top_DB);
		     

		}else if(mat_type=='Z005'){

    		//== SET SUB_TOTAL_MACHiE =======		     
		     var  sub_total_price_Z005 =  $(".sub_total_price_Z005_bomb").val();
		     	    sub_total_price_Z005 = parseFloat(sub_total_price_Z005);
		     //alert(sub_total_price_Z014+'  '+total_price);
		     sub_total_price_Z005 = parseFloat(sub_total_price_Z005-total_price);
		   	 sub_total_price_Z005 = sub_total_price_Z005.toFixed(2);
		     $(".sub_total_price_Z005_bomb").val(sub_total_price_Z005);
          //add function comma
          sub_total_price_Z005 = commaSeparateNumber(sub_total_price_Z005);
		     $(".sub_total_Z005_DB_bomb").val(sub_total_price_Z005);		 

		 }else if(mat_type=='Z002'){
		
			//== SET SUB_TOTAL_TOOL =======		     
		     var  sub_total_price_Z002 =  $(".sub_total_price_Z002_bomb").val();
		     	    sub_total_price_Z002 = parseFloat(sub_total_price_Z002);
		     //alert(sub_total_price_Z002+'  '+total_price);
		     sub_total_price_Z002 = parseFloat(sub_total_price_Z002-total_price);
		   	 sub_total_price_Z002 = sub_total_price_Z002.toFixed(2);
		   	 //alert('total_price :'+sub_total_price_Z002);
		     $(".sub_total_price_Z002_bomb").val(sub_total_price_Z002);
         //add function comma
         sub_total_price_Z002 = commaSeparateNumber(sub_total_price_Z002);
		     $(".sub_total_Z002_DB_bomb").val(sub_total_price_Z002);

		}else if(mat_type=='Z014'){
			
			//== SET SUB_TOTAL_TOOL =======		     
		     var  sub_total_price_Z014 =  $(".sub_total_price_Z014_bomb").val();
		     	    sub_total_price_Z014 = parseFloat(sub_total_price_Z014);
		     //alert(sub_total_price_Z014+'  '+total_price);
		     sub_total_price_Z014 = parseFloat(sub_total_price_Z014-total_price);
		   	 sub_total_price_Z014 = sub_total_price_Z014.toFixed(2);
		     $(".sub_total_price_Z014_bomb").val(sub_total_price_Z014);
          //add function comma
         sub_total_price_Z014 = commaSeparateNumber(sub_total_price_Z014);
		     $(".sub_total_Z014_DB_bomb").val(sub_total_price_Z014);
		}


		//== SET : SUB_TOTAL_ALL =======		     
		     var  sub_total_all =  $(".total_all_bomb").val();
              sub_total_all = replaceComma(sub_total_all);
		     	    sub_total_all = parseFloat(sub_total_all);
		     //alert(sub_total_price_Z014+'  '+total_price);

		     sub_total_all = parseFloat(sub_total_all-total_price);
		   	 sub_total_all = sub_total_all.toFixed(2);
        //add function comma
        sub_total_all = commaSeparateNumber(sub_total_all);		     
		    $(".total_all_bomb").val(sub_total_all);


	}//end check bomb or DB

//////////////////////// END : SET DELETE SUB TOTAL ///////////////////////////////////////////
	
      var select = $(btndel).closest('table').find('select.select_chemical');

      var id = $(btndel).data('id');
      var txt = $(btndel).data('txt');  

      var group = $(btndel).data('group'); 

      if (group == undefined) {
        select.append('<option value="'+id+'">'+txt+'</option>');
      } else  {
        var machine_select = $(btndel).closest('table').find('select.group_machines'); 
        if (machine_select.val() == group) {
          select.append('<option value="'+id+'">'+txt+'</option>');
        }
      }

	// === REMOVE ROW =====
    $(btndel).closest("tr").remove();

     });//end confirm

    } else {
        return false;
    }
}
//############################ END : delete row ##################################################




//############################ start : delete row  request  ##################################################
 function SomeDeleteRowFunction_totalRequest(total_price,btndel) {
 	
    if (typeof(btndel) == "object") {

    $('#modal-delete-area').modal();
    $('.del_area_confirm').off();
    $('.del_area_confirm').on('click', function () {

    	total_price = parseFloat(total_price);
		//alert(total_price);		

	   	var mat_type = $(btndel).parents("tr").find(".mat_type").val();
	    //alert(mat_type);


	    ////////////////  SUMMARY TOTAL //////////////////
	  	if(mat_type=='Z001'){
	  		//== SET SUB_TOTAL_Z001 =======		     
		     var  sub_total_request_Z001 =  $(".sub_total_request_Z001").val();
		     	    sub_total_request_Z001 = parseFloat(sub_total_request_Z001);
		     //alert(sub_total_price_Z014+'  '+total_price);
		     sub_total_request_Z001 = parseFloat(sub_total_request_Z001-total_price);
		   	 sub_total_request_Z001 = sub_total_request_Z001.toFixed(2);
		     $(".sub_total_request_Z001").val(sub_total_request_Z001);
         //add function comma
         sub_total_request_Z001 = commaSeparateNumber(sub_total_request_Z001);
		     $(".sub_total_request_Z001_input").val(sub_total_request_Z001);


		     //== SET : totol_of_chemical_top_DB =======		     
		     var  sub_total_request_chemical_top =  $(".sub_total_request_chemical_top").val();
		     	    sub_total_request_chemical_top = parseFloat(sub_total_request_chemical_top);
		     //alert(sub_total_request_chemical_top+'  '+total_price);
		     sub_total_request_chemical_top = parseFloat(sub_total_request_chemical_top-total_price);
		   	 sub_total_request_chemical_top = sub_total_request_chemical_top.toFixed(2);
         $(".sub_total_request_chemical_top").val(sub_total_request_chemical_top);
		     //add function comma
         sub_total_request_chemical_top = commaSeparateNumber(sub_total_request_chemical_top);
		     //alert('total : '+sub_total_request_chemical_top);
		     $(".sub_total_request_chemical_input").val(sub_total_request_chemical_top);
		     

	  	}else 	if(mat_type=='Z013'){

	  		//== SET SUB_TOTAL_Z0013 =======		     
		     var sub_total_request_Z013 =  $(".sub_total_request_Z013").val();
		     	   sub_total_request_Z013 = parseFloat(sub_total_request_Z013);
		     //alert(sub_total_price_Z014+'  '+total_price);
		     sub_total_request_Z013 = parseFloat(sub_total_request_Z013-total_price);
		   	 sub_total_request_Z013 = sub_total_request_Z013.toFixed(2);
		     $(".sub_total_request_Z013").val(sub_total_request_Z013);
         //add function comma
         sub_total_request_Z013 = commaSeparateNumber(sub_total_request_Z013);
		     $(".sub_total_request_Z013_input").val(sub_total_request_Z013);
		     

		     //== SET : totol_of_chemical_top_DB =======		     
		     var  sub_total_request_chemical_top =  $(".sub_total_request_chemical_top").val();
		     	    sub_total_request_chemical_top = parseFloat(sub_total_request_chemical_top);
		     //alert(sub_total_request_chemical_top+'  '+total_price);
		     sub_total_request_chemical_top = parseFloat(sub_total_request_chemical_top-total_price);
		   	 sub_total_request_chemical_top = sub_total_request_chemical_top.toFixed(2);	
          $(".sub_total_request_chemical_top").val(sub_total_request_chemical_top);	     
		     //alert('total : '+sub_total_request_chemical_top);
         //add function comma
         sub_total_request_chemical_top = commaSeparateNumber(sub_total_request_chemical_top);
		     $(".sub_total_request_chemical_input").val(sub_total_request_chemical_top);
		    
	  	

	  	}else if(mat_type=='Z005'){

	  		//== SET SUB_TOTAL_Z005 =======		     
		     var  sub_total_request_Z005 =  $(".sub_total_request_Z005").val();
		     	    sub_total_request_Z005 = parseFloat(sub_total_request_Z005);
		     //alert(sub_total_price_Z014+'  '+total_price);
		     sub_total_request_Z005 = parseFloat(sub_total_request_Z005-total_price);
		   	 sub_total_request_Z005 = sub_total_request_Z005.toFixed(2);
		     $(".sub_total_request_Z005").val(sub_total_request_Z005);
         //add function comma
         sub_total_request_Z005 = commaSeparateNumber(sub_total_request_Z005);
		     $(".sub_total_request_Z005_input").val(sub_total_request_Z005);		   
	  	
	  	}else 	if(mat_type=='Z002'){

	  		//== SET SUB_TOTAL_Z002 =======			     
		     var  sub_total_request_Z002 =  $(".sub_total_request_Z002").val();
		     	    sub_total_request_Z002 = parseFloat(sub_total_request_Z002);
		     //alert(sub_total_price_Z014+'  '+total_price);
		     sub_total_request_Z002 = parseFloat(sub_total_request_Z002-total_price);
		   	 sub_total_request_Z002 = sub_total_request_Z002.toFixed(2);
		     $(".sub_total_request_Z002").val(sub_total_request_Z002);
         //add function comma
         sub_total_request_Z002 = commaSeparateNumber(sub_total_request_Z002);
		     $(".sub_total_request_Z002_input").val(sub_total_request_Z002);		   
	  	
	  	}else if(mat_type=='Z014'){

	  		//== SET SUB_TOTAL_Z002 =======		     
		     var sub_total_request_Z014 =  $(".sub_total_request_Z014").val();
		     	 sub_total_request_Z014 = parseFloat(sub_total_request_Z014);
		     //alert(sub_total_price_Z014+'  '+total_price);
		     sub_total_request_Z014 = parseFloat(sub_total_request_Z014-total_price);
		   	 sub_total_request_Z014 = sub_total_request_Z014.toFixed(2);
		     $(".sub_total_request_Z014").val(sub_total_request_Z014);
         //add function comma
         sub_total_request_Z014 = commaSeparateNumber(sub_total_request_Z014);
		     $(".sub_total_request_Z014_input").val(sub_total_request_Z014);		   
	  	}
	
		//== SET : SUB_TOTAL_ALL =======		     
		     var total_all_request =  $(".total_all_request").val();
             total_all_request = replaceComma(total_all_request);
		     	   total_all_request = parseFloat(total_all_request);
		     //alert(sub_total_price_Z014+'  '+total_price);
		     total_all_request = parseFloat(total_all_request-total_price);
		   	 total_all_request = total_all_request.toFixed(2);
   		  //add function comma
         total_all_request = commaSeparateNumber(total_all_request);   
		     $(".total_all_request").val(total_all_request);		

      var select = $(btndel).closest('table').find('select.select_chemical');

      var id = $(btndel).data('id');
      var txt = $(btndel).data('txt');
      //alert(txt);  

      var group = $(btndel).data('group'); 

      if (group == undefined) {
        select.append('<option value="'+id+'">'+txt+'</option>');
      } else  {
        var machine_select = $(btndel).closest('table').find('select.group_machines'); 
        if (machine_select.val() == group) {
          select.append('<option value="'+id+'">'+txt+'</option>');
        }
      }
    	$(btndel).closest("tr").remove();

     });//eind confirme

	}else{
        return false;
    }
}

//############################ END : delete row  request ##################################################




//################### start : confirme recalcurate  ##########

    function confirme_recal(target){   
                      
        $(target).on('click',function(event){ 
            //alert('delete_importance_file');     

            $('#modal-confirm-recal').modal('show');        

            $('.confirm').on('click',function(event){
              //alert('confirm');
                 $('.get_data_form_DB').addClass('hide');
                 $('.get_data_form_DB').empty();
                 $(".check_data_from_DB_input").val(0);      

                 $('.get_data_form_bombe').removeClass('hide'); 

               /////////////////////////////// SET SUB TOTAL ///////////////////////////////////////
                 var check_data_from_DB_input = $(".check_data_from_DB_input").val();
					//alert(check_data_from_DB_input);

					if(check_data_from_DB_input==0){
						//totol_of_chemical_top_DB_bomb
							var sub_total_chemical_DB_bomb = $(".sub_total_chemical_DB_bomb").val();
							$('.totol_of_chemical_top_DB_bomb').val(sub_total_chemical_DB_bomb);
							
							//== type : Z001 ==
							var sub_total_price_Z001_bomb = $(".sub_total_price_Z001_bomb").val();//alert(sub_total_price_Z014);	
							$(".sub_total_Z001_DB_bomb").val(sub_total_price_Z001_bomb);

							//== type : Z013 ==
							var sub_total_price_Z013_bomb = $(".sub_total_price_Z013_bomb").val();//alert(sub_total_price_Z014);	
							$(".sub_total_Z013_DB_bomb").val(sub_total_price_Z013_bomb);

							//== type : Z005 ==
							var sub_total_price_Z005_bomb = $(".sub_total_price_Z005_bomb").val();//alert(sub_total_price_Z014);	
							$(".sub_total_Z005_DB_bomb").val(sub_total_price_Z005_bomb);
							

							//== type : Z002 ==
							var sub_total_price_Z002_bomb = $(".sub_total_price_Z002_bomb").val();//alert(sub_total_price_Z014);	
							$(".sub_total_Z002_DB_bomb").val(sub_total_price_Z002_bomb);

							//== type : Z014 ==
							var sub_total_price_Z014_bomb = $(".sub_total_price_Z014_bomb").val();//alert(sub_total_price_Z014);	
							$(".sub_total_Z014_DB_bomb").val(sub_total_price_Z014_bomb);

					}//end else check check_data_from_DB_input 

			/////////////////////////////// SET SUB TOTAL ///////////////////////////////////////


             });//end click confirm
        });//end click taget
                

    }//Raise dialog           

    confirme_recal('#recalcurate');



//################### END :  :confirme recalcurate ##########





</script>