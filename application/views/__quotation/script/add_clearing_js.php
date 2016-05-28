<script type="text/javascript">
$(document).ready(function(){


///////////////////////////// FRIST TOTAL GET FROM DB ////////////////////

//===============  Total clearing frequency all ========================
 <?php    

$temp_area_clearing = $get_area->row_array();
$array_frequency =array('');
if(!empty($temp_area_clearing)){ 
foreach($get_area->result_array() as $value){ 
  if($value['is_on_clearjob']==1){
    if (in_array( $value['frequency'], $array_frequency, TRUE)){                
            //echo "have";
    }else{
        //echo "nohave";
        array_push($array_frequency,$value['frequency']);            
    }//end else 
  }//end if check clearing
}//end foreach
}//end if 

      $temp_frequency= $array_frequency;
      if(!empty($temp_frequency)){
       foreach($array_frequency as $a => $a_value) { 
        if($a != 0){
?>		
	   var a_value = "<?php echo $a_value; ?>";
	   var sub_total_frequency_clearing = $(".total_clearing_frequency_"+a_value).val();
	  // alert(a_value+'sub_total_frequency_clearing :'+sub_total_frequency_clearing);
	  sub_total_frequency_clearing = commaSeparateNumber(sub_total_frequency_clearing);
	   $(".sub_total_frequency_"+a_value).val(sub_total_frequency_clearing);
<?php 
    }//end if
  }//end foreach
 }else{ ?>
   //<option value='0'>ไม่มีข้อมูล</option> 
<?php } ?>


//===============  Total clearing chemical ========================
// var total_chemical_clearing = $(".total_chemical_clearing").val();
// 	//alert('total_chemical_clearing :'+total_chemical_clearing);
// //=== set : total_clearing_tool ==
// $(".sub_total_chemical_clearing").val(total_chemical_clearing);

//===============  Total machince ========================
// var total_tfoot_Z005 = $(".total_tfoot_Z005").val();
// 	//alert('total_tfoot_Z005 :'+total_tfoot_Z005);
// //=== set : total_clearing_tool ==
// $(".total_macheine_clearing").val(total_tfoot_Z005);

//===============  Total tool ========================
// var total_tfoot_Z002 = $(".total_tfoot_Z002").val();
// 	//alert('total_tfoot_Z002 :'+total_tfoot_Z002);

// var total_tfoot_Z014 = $(".total_tfoot_Z014").val();
// 	//alert('total_tfoot_Z014 :'+total_tfoot_Z014);	

// var total_clearing_tool = $(".total_clearing_tool").val();
// 	//alert('total_clearing_tool :'+total_clearing_tool);	

// total_tfoot_Z002 = replaceComma(total_tfoot_Z002);
// total_tfoot_Z014 = replaceComma(total_tfoot_Z014);
// // total_clearing_tool = replaceComma(total_clearing_tool);


// total_tfoot_Z002 = parseFloat(total_tfoot_Z002);
// total_tfoot_Z014 = parseFloat(total_tfoot_Z014);
// total_clearing_tool = parseFloat(total_clearing_tool);

// total_clearing_tool = parseFloat(total_tfoot_Z002+total_tfoot_Z014);
// total_clearing_tool = total_clearing_tool.toFixed(2);
// total_clearing_tool = commaSeparateNumber(total_clearing_tool);
// //=== set : total_clearing_tool ==
// $(".total_clearing_tool").val(total_clearing_tool);


//== set total_all ==================
// var total_all_db =0;  
// total_chemical_clearing = replaceComma(total_chemical_clearing);
// total_tfoot_Z005 = replaceComma(total_tfoot_Z005);
// total_clearing_tool = replaceComma(total_clearing_tool);

// total_chemical_clearing =parseFloat(total_chemical_clearing);
// total_tfoot_Z005 =parseFloat(total_tfoot_Z005);
// total_clearing_tool =parseFloat(total_clearing_tool);
// total_all_db = parseFloat(total_chemical_clearing+total_tfoot_Z005+total_clearing_tool);
// total_all_db = total_all_db.toFixed(2);
// total_all_db = commaSeparateNumber(total_all_db);
// $("input[name='total_all_clearing']").val(total_all_db);

///////////////////////////////////////////////////////////////////////////////


//<!--################################ START :ADD chemical  ############################-->

	$('.add_chimical_clearing').on('click',function(){

		//alert('test');

		//hide tr no-data
		$(this).parents(".table_chemical").find(".data_null").hide();
		
        var select_chemical = $(this).parents("tr").find("select[name='select_chemical']").val();
        //alert(select_chemical);

        var select_chemical_name = $(this).parents("tr").find(".select_chemical_name").val();
        //alert(select_chemical_name);    	

        var mat_type = $(this).parents("tr").find(".temp_mat_type").val();
        //alert(mat_type);

        var mat_group = $(this).parents("tr").find(".temp_mat_group").val();
        //alert(mat_group);

        var  temp_frequency = $(this).parents("tr").find(".temp_frequency").val();
        //alert(temp_frequency);

        var  clearing_type = $(this).parents("tr").find(".clearing_type").val();
        //alert(clearing_type);

        var  quantity = $(this).parents("tr").find(".temp_quantity").val();
        //alert(quantity);

        var  unit = $(this).parents("tr").find(".temp_unit").val();
        //alert(unit);


        var  price = $(this).parents("tr").find(".price_chemical").val();
        //alert(price);

        var  total_price = $(this).parents("tr").find(".temp_total_price").val();
        //alert(total_price);


        // if(mat_type=='Z013'){
        //       quantity = -1;
        //       unit = -1;
        //       price = -1;

        // }//end if


        if (select_chemical == undefined || select_chemical == '' || select_chemical == 0 ||
        	select_chemical_name == undefined || select_chemical_name == '' || select_chemical_name == 0 ||        	
        	mat_type == undefined || mat_type == '' || mat_type == 0 ||
        	temp_frequency == undefined || temp_frequency == '' || temp_frequency == 0||
        	clearing_type == undefined || clearing_type == '' || clearing_type == 0
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
	    temp_frequency != undefined && temp_frequency != '' && temp_frequency != 0 &&
	    clearing_type != undefined && clearing_type != '' && clearing_type != 0 &&
	  	quantity != undefined && quantity != '' && quantity != 0 &&
	    unit != undefined && unit != '' && unit != 0 &&
	    price != undefined && price != '' && price != 0 &&
	    total_price != undefined && total_price != '' && total_price != 0 	          
	    ){

    	//set count
    	var count = $(".count_row_frequency").val();
    	count++; 



	  	var row = "<tr class='h5 tx-green' id='"+select_chemical+"'>";	 
	  		row += "<td></td>";   			  		
	  		row += "<td>";
	  		row +=  parseInt(select_chemical)+' '+select_chemical_name;
	  		row += "<input type='hidden' readonly class='form-control material_no' name='material_no_"+count+"' value='"+select_chemical+"'>";
	  		row += "<input type='hidden' readonly class='form-control mat_type' name='mat_type_"+count+"' value='"+mat_type+"'>";
	  		row += "<input type='hidden' readonly class='form-control mat_group' name='mat_group_"+count+"' value='"+mat_group+"'>";
	  		row += "<input type='hidden' readonly class='form-control frequency' name='frequency_"+count+"' value='"+temp_frequency+"'>";
	  		row += "<input type='hidden' readonly class='form-control clearing_type' name='clearing_type_"+count+"' value='"+clearing_type+"'>";
	  		row += "</td>";


	  		row += "<td class='tx-center'>";
	  		row += quantity+' '+unit;
	  		row += "<input type='hidden' readonly class='form-control quantity' name='quantity_"+count+"' value='"+quantity+"'>";
	  		row += "<input type='hidden' readonly class='form-control unit_code' name='unit_code_"+count+"' value='"+unit+"'>";
	  		row += "</td>";

	  		row += "<td>";
	  		row += price;
	  		row +=  "<input type='hidden' readonly class='form-control price' name='price_"+count+"' value='"+replaceComma(price)+"'>";
	  		row += "</td>";


	  		row += "<td>";
	  		row += total_price;
	  		row += "<input type='hidden' readonly class='form-control total_price' name='total_price_"+count+"' value='"+replaceComma(total_price)+"'>";
	  		row += "</td>";

	  		row += "<td class='tx-center'>";
	  		row += "<span class='margin-left-small'><button type='button'  data-id='"+select_chemical+"' data-txt='"+select_chemical+" "+select_chemical_name+"' onclick='SomeDeleteRowFunction_clearing("+replaceComma(total_price)+",this);' class='btn btn-default '><i class='fa fa-trash-o'></i></button></span>";
	  		row += "</td>";
	  	row += "</tr>";
        //ADD : row to table
        $(this).parents(".table_chemical").find("tbody").append(row);

        //== set : count_row_frequency ===
			//alert(temp_space_no+' '+count);
			$(".count_row_frequency").val(count);

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
		

	      //////////////////////// START : SET TOTAL //////////////////////////////////
				total_price = replaceComma(total_price);	
		  	////////////////   TOTAL TFOOT //////////////////		  		
			     total_price = parseFloat(total_price);			     
			     var total_tfoot = $(this).parents(".table_chemical").find('.total_tfoot').val();
			     	total_tfoot = replaceComma(total_tfoot);
			     	total_tfoot = parseFloat(total_tfoot);
			     //alert(total_tfoot+'  '+total_tfoot);
			     total_tfoot = parseFloat(total_tfoot+total_price);
			   	 total_tfoot = total_tfoot.toFixed(2);
			   	//add function comma
               	total_tfoot = commaSeparateNumber(total_tfoot);
			    $(this).parents(".table_chemical").find('tr .total_tfoot').val(total_tfoot);

		////////////////   TOTAL div-frequency-clearing //////////////////
				total_price = parseFloat(total_price);			     
			     var subtotal_fre = $(this).parents(".div-frequency-clearing").find('.sub_total_frequency_'+temp_frequency).val();
			     	 subtotal_fre = replaceComma(subtotal_fre);
			     	 subtotal_fre = parseFloat(subtotal_fre);
			     //alert(subtotal_fre+'  '+total_price);
			     subtotal_fre = parseFloat(subtotal_fre+total_price);
			   	 subtotal_fre = subtotal_fre.toFixed(2);
			   	 //add function comma
               	 subtotal_fre = commaSeparateNumber(subtotal_fre);
			     $(this).parents(".div-frequency-clearing").find('.sub_total_frequency_'+temp_frequency).val(subtotal_fre);

	   //////////////////////////  SUB_TOTAL CHEMICAL ////////////////////////////
	   			// total_price = parseFloat(total_price);			     
			    //  var total_clearing_chemical = $(".sub_total_chemical_clearing").val();
			    //  	 total_clearing_chemical = replaceComma(total_clearing_chemical);
			    //  	 total_clearing_chemical = parseFloat(total_clearing_chemical);
			    //  //alert(total_clearing_chemical+'  '+total_price);
			    //  total_clearing_chemical = parseFloat(total_clearing_chemical+total_price);
			   	//  total_clearing_chemical = total_clearing_chemical.toFixed(2);
			   	//  //add function comma
       //         	 total_clearing_chemical = commaSeparateNumber(total_clearing_chemical);
			   	//  $(".sub_total_chemical_clearing").val(total_clearing_chemical);


          //  var sub_total_chemical_clearing = $('.sub_total_chemical_clearing').val();
          //  	   sub_total_chemical_clearing = replaceComma(sub_total_chemical_clearing);
          //  var total_macheine_clearing = $('.total_macheine_clearing').val();
          //  	   total_macheine_clearing = replaceComma(total_macheine_clearing);
          //  var total_clearing_tool = $('.total_clearing_tool').val();
          //  	   total_clearing_tool = replaceComma(total_clearing_tool);

          // var all_total = parseFloat(sub_total_chemical_clearing) + parseFloat(total_macheine_clearing) + parseFloat(total_clearing_tool);
          // //add function comma
          // all_total = commaSeparateNumber(all_total);
          // $('input[name="total_all_clearing"]').val(all_total);


          //////////////////////////  SET :: TOTAL ALL PAGE ////////////////////////////
            var all_total = $("input[name='total_all_clearing']").val();
		    all_total = replaceComma(all_total); 
		    all_total = parseFloat(all_total); 
		    
		    all_total = parseFloat(all_total+total_price);  
		    //add function comma
			all_total = commaSeparateNumber(all_total);
		    $("input[name='total_all_clearing']").val(all_total);


    }//end if

		
    $(this).closest('table').find("select[name='select_chemical'] option[value='"+select_chemical+"']").remove();
    $(this).closest('table').find( "select[name='select_chemical'] option:first" ).prop("selected", true);

});//end click add
//<!--################################ END :ADD chemical  ############################-->








//<!--################################ START :ADD machine cleraing ############################-->

	$('.add_clearing_machine_news').on('click',function(){

		//alert('test');

		//hide tr no-data
		$(this).parents(".table_chemical").find(".data_null").hide();

		 var group_machines_sel = $(this).parents("tr").find("select.group_machines").val();

		var group_machines = $(this).parents("tr").find("input[name='group_machines']").val();
        //alert(group_machines);
		
        var select_chemical = $(this).parents("tr").find("select[name='select_chemical']").val();
        //alert(select_chemical);

        var select_chemical_name = $(this).parents("tr").find(".select_chemical_name").val();
        //alert(select_chemical_name);    	

        var mat_type = $(this).parents("tr").find(".temp_mat_type").val();
        //alert(mat_type);

        var mat_group = $(this).parents("tr").find(".temp_mat_group").val();
        //alert(mat_group);

        var  temp_frequency = $(this).parents("tr").find(".temp_frequency").val();
        //alert(temp_frequency);

        var  clearing_type = $(this).parents("tr").find(".clearing_type").val();
        //alert(clearing_type);

        var  quantity = $(this).parents("tr").find(".temp_quantity").val();
        //alert(quantity);

        var  unit = $(this).parents("tr").find(".temp_unit").val();
        //alert(unit);


        var  price = $(this).parents("tr").find(".price_chemical").val();
        //alert(price);

        var  total_price = $(this).parents("tr").find(".temp_total_price").val();
        //alert(total_price);


        // if(mat_type=='Z013'){
        //       quantity = -1;
        //       unit = -1;
        //       price = -1;

        // }//end if


        if (select_chemical == undefined || select_chemical == '' || select_chemical == 0 ||
        	select_chemical_name == undefined || select_chemical_name == '' || select_chemical_name == 0 ||        	
        	mat_type == undefined || mat_type == '' || mat_type == 0 ||
        	temp_frequency == undefined || temp_frequency == '' || temp_frequency == 0||
        	clearing_type == undefined || clearing_type == '' || clearing_type == 0
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

        if (group_machines == undefined || group_machines == '' || group_machines == 0 ){
            $(this).parents("tr").find('.text_msg5').html('กรุณากรอกข้อมูล');
       }


    if (group_machines != undefined && group_machines != '' && group_machines != 0 && 
    	select_chemical != undefined && select_chemical != '' && select_chemical != 0 && 
    	select_chemical_name != undefined && select_chemical_name != '' && select_chemical_name != 0 && 
	    mat_type != undefined && mat_type != '' && mat_type != 0 &&
	    temp_frequency != undefined && temp_frequency != '' && temp_frequency != 0 &&
	    clearing_type != undefined && clearing_type != '' && clearing_type != 0 &&
	  	quantity != undefined && quantity != '' && quantity != 0 &&
	    unit != undefined && unit != '' && unit != 0 &&
	    price != undefined && price != '' && price != 0 &&
	    total_price != undefined && total_price != '' && total_price != 0 	          
	    ){

    	//set count
    	var count = $(".count_row_frequency").val();
    	count++; 



	  	var row = "<tr class='h5 tx-green' id='"+select_chemical+"'>";	 
	  		//row += "<td></td>";  

	  		row +="<td>";
		  	row += group_machines;
		  	row += "<input type='hidden' readonly class='form-control mat_group_des' name='mach_mat_group_des_"+count+"' value='"+group_machines+"'>";
	  	    row +="</td>"; 	

	  		row += "<td>";
	  		row +=  parseInt(select_chemical)+' '+select_chemical_name;
	  		row += "<input type='hidden' readonly class='form-control material_no' name='material_no_"+count+"' value='"+select_chemical+"'>";
	  		row += "<input type='hidden' readonly class='form-control mat_type' name='mat_type_"+count+"' value='"+mat_type+"'>";
	  		row += "<input type='hidden' readonly class='form-control mat_group' name='mat_group_"+count+"' value='"+mat_group+"'>";
	  		row += "<input type='hidden' readonly class='form-control frequency' name='frequency_"+count+"' value='"+temp_frequency+"'>";
	  		row += "<input type='hidden' readonly class='form-control clearing_type' name='clearing_type_"+count+"' value='"+clearing_type+"'>";
	  		row += "</td>";


	  		row += "<td class='tx-center'>";
	  		row += quantity+' '+unit;
	  		row += "<input type='hidden' readonly class='form-control quantity' name='quantity_"+count+"' value='"+quantity+"'>";
	  		row += "<input type='hidden' readonly class='form-control unit_code' name='unit_code_"+count+"' value='"+unit+"'>";
	  		row += "</td>";

	  		row += "<td>";
	  		row += price;
	  		row +=  "<input type='hidden' readonly class='form-control price' name='price_"+count+"' value='"+replaceComma(price)+"'>";
	  		row += "</td>";


	  		row += "<td>";
	  		row += total_price;
	  		row += "<input type='hidden' readonly class='form-control total_price' name='total_price_"+count+"' value='"+replaceComma(total_price)+"'>";
	  		row += "</td>";

	  		// row += "<td class='tx-center'>";
	  		// row += "<span class='margin-left-small'><button type='button'  data-id='"+select_chemical+"' data-txt='"+select_chemical+" "+select_chemical_name+"' onclick='SomeDeleteRowFunction_clearing("+replaceComma(total_price)+",this);' class='btn btn-default '><i class='fa fa-trash-o'></i></button></span>";
	  		// row += "</td>";

	  		row += "<td class='tx-center'>";
	  		row += "<span class='margin-left-small'><button type='button' data-id='"+select_chemical+"' data-txt='"+select_chemical+" "+select_chemical_name+"' data-group='"+group_machines_sel+"' onclick='SomeDeleteRowFunction_clearing("+replaceComma(total_price)+",this);' class='btn btn-default '><i class='fa fa-trash-o'></i></button></span>";
	  		row += "</td>";
	  		row += "</tr>"


	  	row += "</tr>";
        //ADD : row to table
        $(this).parents(".table_chemical").find("tbody").append(row);

        //== set : count_row_frequency ===
			//alert(temp_space_no+' '+count);
			$(".count_row_frequency").val(count);

        //==  set : null
	      //$(this).parents(".table_chemical").find('tr .select_chemical').val('0');
	      //$(this).parents(".table_chemical").find('tr .select_chemical option[value="'+select_chemical+'"]').remove();
	      $(this).parents(".table_chemical").find('tr .group_machines .select2-chosen').html('กรุณาเลือก');

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

	     //////////////////////// START : SET TOTAL //////////////////////////////////
				total_price = replaceComma(total_price);	
		  	////////////////   TOTAL TFOOT //////////////////		  		
			     total_price = parseFloat(total_price);			     
			     var total_tfoot = $(this).parents(".table_chemical").find('.total_tfoot').val();
			     	total_tfoot = replaceComma(total_tfoot);
			     	total_tfoot = parseFloat(total_tfoot);
			     //alert(total_tfoot+'  '+total_tfoot);
			     total_tfoot = parseFloat(total_tfoot+total_price);
			   	 total_tfoot = total_tfoot.toFixed(2);
			   	//add function comma
               	total_tfoot = commaSeparateNumber(total_tfoot);
			    $(this).parents(".table_chemical").find('tr .total_tfoot').val(total_tfoot);

		////////////////   TOTAL div-frequency-clearing //////////////////
				total_price = parseFloat(total_price);			     
			     var subtotal_fre = $(this).parents(".div-frequency-clearing").find('.sub_total_frequency_'+temp_frequency).val();
			     	 subtotal_fre = replaceComma(subtotal_fre);
			     	 subtotal_fre = parseFloat(subtotal_fre);
			     //alert(subtotal_fre+'  '+total_price);
			     subtotal_fre = parseFloat(subtotal_fre+total_price);
			   	 subtotal_fre = subtotal_fre.toFixed(2);
			   	 //add function comma
               	 subtotal_fre = commaSeparateNumber(subtotal_fre);
			     $(this).parents(".div-frequency-clearing").find('.sub_total_frequency_'+temp_frequency).val(subtotal_fre);

	   //////////////////////////  SUB_TOTAL CHEMICAL ////////////////////////////
	   			// total_price = parseFloat(total_price);			     
			    //  var total_clearing_chemical = $(".sub_total_chemical_clearing").val();
			    //  	 total_clearing_chemical = replaceComma(total_clearing_chemical);
			    //  	 total_clearing_chemical = parseFloat(total_clearing_chemical);
			    //  //alert(total_clearing_chemical+'  '+total_price);
			    //  total_clearing_chemical = parseFloat(total_clearing_chemical+total_price);
			   	//  total_clearing_chemical = total_clearing_chemical.toFixed(2);
			   	//  //add function comma
       //         	 total_clearing_chemical = commaSeparateNumber(total_clearing_chemical);
			   	//  $(".sub_total_chemical_clearing").val(total_clearing_chemical);

          //  var sub_total_chemical_clearing = $('.sub_total_chemical_clearing').val();
          //  	   sub_total_chemical_clearing = replaceComma(sub_total_chemical_clearing);
          //  var total_macheine_clearing = $('.total_macheine_clearing').val();
          //  	   total_macheine_clearing = replaceComma(total_macheine_clearing);
          //  var total_clearing_tool = $('.total_clearing_tool').val();
          //  	   total_clearing_tool = replaceComma(total_clearing_tool);

          // var all_total = parseFloat(sub_total_chemical_clearing) + parseFloat(total_macheine_clearing) + parseFloat(total_clearing_tool);
          // //add function comma
          // all_total = commaSeparateNumber(all_total);
          // $('input[name="total_all_clearing"]').val(all_total);

           //////////////////////////  SET :: TOTAL ALL PAGE ////////////////////////////
            var all_total = $("input[name='total_all_clearing']").val();
		    all_total = replaceComma(all_total); 
		    all_total = parseFloat(all_total); 
		    
		    all_total = parseFloat(all_total+total_price);  
		    //add function comma
			all_total = commaSeparateNumber(all_total);
		    $("input[name='total_all_clearing']").val(all_total);

    }//end if

		
    // $(this).closest('table').find("select[name='select_chemical'] option[value='"+select_chemical+"']").remove();
    // $(this).closest('table').find( "select[name='select_chemical'] option:first" ).prop("selected", true);

    $(this).closest('table').find("select[name='select_chemical']").attr('disabled', true);
    $(this).closest('table').find( "select[name='select_chemical'] option:first" ).prop("selected", true);
    $(this).closest('table').find( "select[name='group_machines_slected'] option:first" ).prop("selected", true);

});//end click add




////// end new machine /////
	// $('.add_clearing_machine').on('click',function(){

	// 	//alert('test');
	// 	//hide tr no-data
	// 	$(this).parents(".table_clearing_machine").find(".data_null").hide();

 //    var group_machines_sel = $(this).parents("tr").find("select.group_machines").val();

	// 	var group_machines = $(this).parents("tr").find("input[name='group_machines']").val();
 //        //alert(group_machines);

 //        var select_chemical = $(this).parents("tr").find("select[name='select_chemical']").val();
 //        //alert(select_chemical);

 //        var select_chemical_name = $(this).parents("tr").find(".select_chemical_name").val();
 //        //alert(select_chemical_name);

 //        var mat_type = $(this).parents("tr").find(".temp_mat_type").val();
 //        //alert(mat_type);

 //        var mat_group = $(this).parents("tr").find(".temp_mat_group").val();
 //        //alert(mat_group);

 //        var  quantity = $(this).parents("tr").find(".temp_quantity").val();
 //        //alert(quantity);

 //        var  unit = $(this).parents("tr").find(".temp_unit").val();
 //        //alert(unit);

        
 //        var  price = $(this).parents("tr").find(".price_chemical").val();
 //        //alert(price);

 //        var  total_price = $(this).parents("tr").find(".temp_total_price").val();
 //        //alert(total_price);


 //         if (select_chemical == undefined || select_chemical == '' || select_chemical == 0 ||
 //        	select_chemical_name == undefined || select_chemical_name == '' || select_chemical_name == 0 ||        	
 //        	mat_type == undefined || mat_type == '' || mat_type == 0
 //        	){
            
 //           $(this).parents("tr").find('.text_msg1').html('กรุณากรอกข้อมูล');
 //       }

 //       if (quantity == undefined || quantity == '' || quantity == 0 ||
 //       		unit == undefined || unit == '' || unit == 0 
       		
 //       	 ){
 //            $(this).parents("tr").find('.text_msg2').html('กรุณากรอกข้อมูล');
 //       }


 //       if (price == undefined || price == '' || price == 0 ){
 //            $(this).parents("tr").find('.text_msg3').html('กรุณากรอกข้อมูล');
 //       }

 //       if (total_price == undefined || total_price == '' || total_price == 0 ){
 //            $(this).parents("tr").find('.text_msg4').html('กรุณากรอกข้อมูล');
 //       }

 //        if (group_machines == undefined || group_machines == '' || group_machines == 0 ){
 //            $(this).parents("tr").find('.text_msg5').html('กรุณากรอกข้อมูล');
 //       }


 //    if (group_machines != undefined && group_machines != '' && group_machines != 0 && 
 //    	select_chemical != undefined && select_chemical != '' && select_chemical != 0 && 
 //    	select_chemical_name != undefined && select_chemical_name != '' && select_chemical_name != 0 && 	   
	//   	mat_type != undefined && mat_type != '' && mat_type != 0 &&
	//   	quantity != undefined && quantity != '' && quantity != 0 &&
	//     unit != undefined && unit != '' && unit != 0 &&	   
	//     price != undefined && price != '' && price != 0 &&
	//     total_price != undefined && total_price != '' && total_price != 0   
	//     ){

 //    	//set count
 //    	var count = $(".count_clearing_machine").val();
 //    	count++; 

                                                   
                                                    

	//   	var row = "<tr class='h5 tx-green' id='"+select_chemical+"'>";	

	//   		row += "<td  style='width:260px;'>";  
	//   		row += "<div class='input-group m-b'>"; 
	//   		row += "<span class='input-group-addon'><font class='pull-left'>frequency</font></span>" 
	//   		row += "<select data-parsley-required='true' data-parsley-error-message=''  class='form-control frequency' name='mach_frequency_"+count+"' >";
	//   		//row += "<option seleted='seleted' value='0'>กรุณาเลือกบริการ</option>";
<?php 
	// $temp_area_clearing = $get_area->row_array();
	// $array_frequency =array('');
	// if(!empty($temp_area_clearing)){ 
	// foreach($get_area->result_array() as $value){ 
	//   if($value['is_on_clearjob']==1){
	//     if (in_array( $value['frequency'], $array_frequency, TRUE)){                
	//             //echo "have";
	//     }else{
	//         //echo "nohave";
	//         array_push($array_frequency,$value['frequency']);            
	//     }//end else 
	//   }//end if check clearing
	// }//end foreach
	// }//end if 
	// $temp_frequency= $array_frequency;
	// if(!empty($temp_frequency)){
	// foreach($array_frequency as $a => $a_value) { 
	// if($a != 0){
?>
	   		// var a_value ="<?php echo $a_value; ?>"
	     //    row += "<option  value='"+a_value+"'>Every "+a_value+" m</option>"; 
<?php 
// 		}//end if
// 	}//end foreach
// }else{ 
?>
           // row+="<option value='0'>ไม่มีข้อมูล</option>" ;
<?php //} ?>	  		
// 	  		row += "</select>";  
// 	  		row += "</td>";     

// 	  		row +="<td>";
// 		  	row += group_machines;
// 		  	row += "<input type='hidden' readonly class='form-control mat_group_des' name='mach_mat_group_des_"+count+"' value='"+group_machines+"'>";
// 	  	    row +="</td>"; 		

// 	  		row += "<td>";
// 	  		row += parseInt(select_chemical)+' '+select_chemical_name;
// 	  		row += "<input type='hidden' readonly class='form-control material_no' name='mach_material_no_"+count+"' value='"+select_chemical+"'>";
// 	  		row += "<input type='hidden' readonly class='form-control mat_type' name='mach_mat_type_"+count+"' value='"+mat_type+"'>";
// 	  		row += "<input type='hidden' readonly class='form-control mat_group' name='mach_mat_group_"+count+"' value='"+mat_group+"'>";
// 	  		row += "</td>";

// 	  		row += "<td class='tx-center'>";
// 	  		row += quantity+' '+unit;
// 	  		row += "<input type='hidden' readonly class='form-control quantity' name='mach_quantity_"+count+"' value='"+quantity+"'>";
// 	  		row += "<input type='hidden' readonly class='form-control unit_code' name='mach_unit_code_"+count+"' value='"+unit+"'>";
// 	  		row += "</td>";

// 	  		row += "<td>";
// 	  		row += price;
// 	  		row +=  "<input type='hidden' readonly class='form-control price' name='mach_price_"+count+"' value='"+replaceComma(price)+"'>";
// 	  		row += "</td>";

// 	  		row += "<td>";
// 	  		row += total_price;
// 	  		row += "<input type='hidden' readonly class='form-control total_price' name='mach_total_price_"+count+"' value='"+replaceComma(total_price)+"'>";
// 	  		row += "</td>";

// 	  		row += "<td class='tx-center'>";
// 	  		row += "<span class='margin-left-small'><button type='button' data-id='"+select_chemical+"' data-txt='"+select_chemical+" "+select_chemical_name+"' data-group='"+group_machines_sel+"' onclick='SomeDeleteRowFunction_clearing("+replaceComma(total_price)+",this);' class='btn btn-default '><i class='fa fa-trash-o'></i></button></span>";
// 	  		row += "</td>";
// 	  		row += "</tr>"

//         //ADD : row to table
//         $(this).parents(".table_clearing_machine").find("tbody").append(row);
//        // save_clearing();
//         //== set : count_row_frequency ===
// 			//alert(temp_space_no+' '+count);
// 			$(".count_clearing_machine").val(count);

//         //==  set : null
//           //$(this).parents(".table_chemical").find('tr .group_machines').val('0');
//           $(this).parents(".table_clearing_machine").find('tr .group_machines .select2-chosen').html('กรุณาเลือก');

// 	      //$(this).parents(".table_chemical").find('tr .select_chemical').val('0');
// 	      //$(this).parents(".table_chemical").find('tr .select_chemical option[value="'+select_chemical+'"]').remove();
//           $(this).parents(".table_clearing_machine").find('tr .select_chemical .select2-chosen').html('กรุณาเลือก');

// 	      $(this).parents(".table_clearing_machine").find('tr .select_chemical_name').val('');
// 	      $(this).parents(".table_clearing_machine").find('tr .temp_mat_group').val('');

// 	      $(this).parents(".table_clearing_machine").find('tr .temp_quantity').val('');
// 	      $(this).parents(".table_clearing_machine").find('tr .temp_quantity').attr('readonly', true);
// 	      $(this).parents(".table_clearing_machine").find('tr .text_unit').html('หน่วย');
// 	      $(this).parents(".table_clearing_machine").find('tr .temp_unit').val('');
// 	      $(this).parents(".table_clearing_machine").find('tr .price_chemical').val('');
// 	      $(this).parents(".table_clearing_machine").find('tr .temp_total_price').val('');

// 	      $(this).parents(".table_clearing_machine").find('.text_msg1').html('');
// 	      $(this).parents(".table_clearing_machine").find('.text_msg2').html('');
// 	      $(this).parents(".table_clearing_machine").find('.text_msg3').html('');
// 	      $(this).parents(".table_clearing_machine").find('.text_msg4').html('');
// 	      $(this).parents(".table_clearing_machine").find('.text_msg5').html('');
			
// 		//////////////////////// START : SET TOTAL //////////////////////////////////
// 			total_price = replaceComma(total_price);
// 			////////////////   TOTAL TFOOT Z005 //////////////////				  			
// 		    total_price = parseFloat(total_price);	
// 		    //alert("test"+total_price);  
// 		    var total_tfoot_Z005 =  $(".total_tfoot_Z005").val();
// 		    	total_tfoot_Z005 = replaceComma(total_tfoot_Z005);
//             	total_tfoot_Z005 = parseFloat(total_tfoot_Z005); 			     
// 			//alert(total_tfoot_Z005+' '+total_price);
// 				 total_tfoot_Z005 = parseFloat(total_tfoot_Z005+total_price);
// 			   	 total_tfoot_Z005 = total_tfoot_Z005.toFixed(2);
// 			   	//add function comma
//               	total_tfoot_Z005 = commaSeparateNumber(total_tfoot_Z005);
// 			    $('.total_tfoot_Z005').val(total_tfoot_Z005);

// 			 ////////////////   TOTAL totol_macheine_clearing //////////////////
				
// 				 total_price = parseFloat(total_price);			     
// 			     var total_macheine_clearing = $('.total_macheine_clearing').val();
// 			     	 total_macheine_clearing = replaceComma(total_macheine_clearing);
// 			     	 total_macheine_clearing = parseFloat(total_macheine_clearing);
// 			     //alert(total_macheine_clearing+'  '+total_price);
// 			     total_macheine_clearing = parseFloat(total_macheine_clearing+total_price);
// 			   	 total_macheine_clearing = total_macheine_clearing.toFixed(2);

// 			   	//add function comma
//               	total_macheine_clearing = commaSeparateNumber(total_macheine_clearing);
// 			    $('.total_macheine_clearing').val(total_macheine_clearing);

//            var  sub_total_chemical_clearing = $('.sub_total_chemical_clearing').val();
//            		sub_total_chemical_clearing = replaceComma(sub_total_chemical_clearing);
//            var  total_macheine_clearing = $('.total_macheine_clearing').val();
//            		total_macheine_clearing = replaceComma(total_macheine_clearing);
//            var total_clearing_tool = $('.total_clearing_tool').val();
//            		total_clearing_tool = replaceComma(total_clearing_tool);

//           var all_total = parseFloat(sub_total_chemical_clearing) + parseFloat(total_macheine_clearing) + parseFloat(total_clearing_tool);
//       		//add function comma
//           	all_total = commaSeparateNumber(all_total);
//           	$('input[name="total_all_clearing"]').val(all_total);

//     }//end if

		

//     $(this).closest('table').find("select[name='select_chemical']").attr('disabled', true);
//     $(this).closest('table').find( "select[name='select_chemical'] option:first" ).prop("selected", true);
//     $(this).closest('table').find( "select[name='group_machines_slected'] option:first" ).prop("selected", true);


//      //save_clearing();
// });//end click add
//<!--################################ END :ADD machine cleraing ############################-->





//<!--################################ START :ADD tool  ############################-->


	$('.add_clearing_tool_news').on('click',function(){

		//alert('test');

		//hide tr no-data
		$(this).parents(".table_chemical").find(".data_null").hide();
		
        var select_chemical = $(this).parents("tr").find("select[name='select_chemical']").val();
        //alert(select_chemical);

        var select_chemical_name = $(this).parents("tr").find(".select_chemical_name").val();
        //alert(select_chemical_name);    	

        var mat_type = $(this).parents("tr").find(".temp_mat_type").val();
        //alert(mat_type);

        var mat_group = $(this).parents("tr").find(".temp_mat_group").val();
        //alert(mat_group);

        var  temp_frequency = $(this).parents("tr").find(".temp_frequency").val();
        //alert(temp_frequency);

        var  clearing_type = $(this).parents("tr").find(".clearing_type").val();
        //alert(clearing_type);

        var  quantity = $(this).parents("tr").find(".temp_quantity").val();
        //alert(quantity);

        var  unit = $(this).parents("tr").find(".temp_unit").val();
        //alert(unit);


        var  price = $(this).parents("tr").find(".price_chemical").val();
        //alert(price);

        var  total_price = $(this).parents("tr").find(".temp_total_price").val();
        //alert(total_price);


        // if(mat_type=='Z013'){
        //       quantity = -1;
        //       unit = -1;
        //       price = -1;

        // }//end if


        if (select_chemical == undefined || select_chemical == '' || select_chemical == 0 ||
        	select_chemical_name == undefined || select_chemical_name == '' || select_chemical_name == 0 ||        	
        	mat_type == undefined || mat_type == '' || mat_type == 0 ||
        	temp_frequency == undefined || temp_frequency == '' || temp_frequency == 0||
        	clearing_type == undefined || clearing_type == '' || clearing_type == 0
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
	    temp_frequency != undefined && temp_frequency != '' && temp_frequency != 0 &&
	    clearing_type != undefined && clearing_type != '' && clearing_type != 0 &&
	  	quantity != undefined && quantity != '' && quantity != 0 &&
	    unit != undefined && unit != '' && unit != 0 &&
	    price != undefined && price != '' && price != 0 &&
	    total_price != undefined && total_price != '' && total_price != 0 	          
	    ){

    	//set count
    	var count = $(".count_row_frequency").val();
    	count++; 



	  	var row = "<tr class='h5 tx-green' id='"+select_chemical+"'>";	 
	  		row += "<td></td>";   			  		
	  		row += "<td>";
	  		row +=  parseInt(select_chemical)+' '+select_chemical_name;
	  		row += "<input type='hidden' readonly class='form-control material_no' name='material_no_"+count+"' value='"+select_chemical+"'>";
	  		row += "<input type='hidden' readonly class='form-control mat_type' name='mat_type_"+count+"' value='"+mat_type+"'>";
	  		row += "<input type='hidden' readonly class='form-control mat_group' name='mat_group_"+count+"' value='"+mat_group+"'>";
	  		row += "<input type='hidden' readonly class='form-control frequency' name='frequency_"+count+"' value='"+temp_frequency+"'>";
	  		row += "<input type='hidden' readonly class='form-control clearing_type' name='clearing_type_"+count+"' value='"+clearing_type+"'>";
	  		row += "</td>";


	  		row += "<td class='tx-center'>";
	  		row += quantity+' '+unit;
	  		row += "<input type='hidden' readonly class='form-control quantity' name='quantity_"+count+"' value='"+quantity+"'>";
	  		row += "<input type='hidden' readonly class='form-control unit_code' name='unit_code_"+count+"' value='"+unit+"'>";
	  		row += "</td>";

	  		row += "<td>";
	  		row += price;
	  		row +=  "<input type='hidden' readonly class='form-control price' name='price_"+count+"' value='"+replaceComma(price)+"'>";
	  		row += "</td>";


	  		row += "<td>";
	  		row += total_price;
	  		row += "<input type='hidden' readonly class='form-control total_price' name='total_price_"+count+"' value='"+replaceComma(total_price)+"'>";
	  		row += "</td>";

	  		row += "<td class='tx-center'>";
	  		row += "<span class='margin-left-small'><button type='button'  data-id='"+select_chemical+"' data-txt='"+select_chemical+" "+select_chemical_name+"' onclick='SomeDeleteRowFunction_clearing("+replaceComma(total_price)+",this);' class='btn btn-default '><i class='fa fa-trash-o'></i></button></span>";
	  		row += "</td>";
	  	row += "</tr>";
        //ADD : row to table
        $(this).parents(".table_chemical").find("tbody").append(row);

        //== set : count_row_frequency ===
			//alert(temp_space_no+' '+count);
			$(".count_row_frequency").val(count);

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
		

	      //////////////////////// START : SET TOTAL //////////////////////////////////
				total_price = replaceComma(total_price);	
		  	////////////////   TOTAL TFOOT //////////////////		  		
			     total_price = parseFloat(total_price);			     
			     var total_tfoot = $(this).parents(".table_chemical").find('.total_tfoot').val();
			     	total_tfoot = replaceComma(total_tfoot);
			     	total_tfoot = parseFloat(total_tfoot);
			     //alert(total_tfoot+'  '+total_tfoot);
			     total_tfoot = parseFloat(total_tfoot+total_price);
			   	 total_tfoot = total_tfoot.toFixed(2);
			   	//add function comma
               	total_tfoot = commaSeparateNumber(total_tfoot);
			    $(this).parents(".table_chemical").find('tr .total_tfoot').val(total_tfoot);

		////////////////   TOTAL div-frequency-clearing //////////////////
				total_price = parseFloat(total_price);			     
			     var subtotal_fre = $(this).parents(".div-frequency-clearing").find('.sub_total_frequency_'+temp_frequency).val();
			     	 subtotal_fre = replaceComma(subtotal_fre);
			     	 subtotal_fre = parseFloat(subtotal_fre);
			     //alert(subtotal_fre+'  '+total_price);
			     subtotal_fre = parseFloat(subtotal_fre+total_price);
			   	 subtotal_fre = subtotal_fre.toFixed(2);
			   	 //add function comma
               	 subtotal_fre = commaSeparateNumber(subtotal_fre);
			     $(this).parents(".div-frequency-clearing").find('.sub_total_frequency_'+temp_frequency).val(subtotal_fre);

	   //////////////////////////  SUB_TOTAL CHEMICAL ////////////////////////////
	   			// total_price = parseFloat(total_price);			     
			    //  var total_clearing_chemical = $(".sub_total_chemical_clearing").val();
			    //  	 total_clearing_chemical = replaceComma(total_clearing_chemical);
			    //  	 total_clearing_chemical = parseFloat(total_clearing_chemical);
			    //  //alert(total_clearing_chemical+'  '+total_price);
			    //  total_clearing_chemical = parseFloat(total_clearing_chemical+total_price);
			   	//  total_clearing_chemical = total_clearing_chemical.toFixed(2);
			   	//  //add function comma
       //         	 total_clearing_chemical = commaSeparateNumber(total_clearing_chemical);
			   	//  $(".sub_total_chemical_clearing").val(total_clearing_chemical);


          //  var sub_total_chemical_clearing = $('.sub_total_chemical_clearing').val();
          //  	   sub_total_chemical_clearing = replaceComma(sub_total_chemical_clearing);
          //  var total_macheine_clearing = $('.total_macheine_clearing').val();
          //  	   total_macheine_clearing = replaceComma(total_macheine_clearing);
          //  var total_clearing_tool = $('.total_clearing_tool').val();
          //  	   total_clearing_tool = replaceComma(total_clearing_tool);

          // var all_total = parseFloat(sub_total_chemical_clearing) + parseFloat(total_macheine_clearing) + parseFloat(total_clearing_tool);
          // //add function comma
          // all_total = commaSeparateNumber(all_total);
          // $('input[name="total_all_clearing"]').val(all_total);

           //////////////////////////  SET :: TOTAL ALL PAGE ////////////////////////////
            var all_total = $("input[name='total_all_clearing']").val();
		    all_total = replaceComma(all_total); 
		    all_total = parseFloat(all_total); 
		    
		    all_total = parseFloat(all_total+total_price);  
		    //add function comma
			all_total = commaSeparateNumber(all_total);
		    $("input[name='total_all_clearing']").val(all_total);

    }//end if

		
    $(this).closest('table').find("select[name='select_chemical'] option[value='"+select_chemical+"']").remove();
    $(this).closest('table').find( "select[name='select_chemical'] option:first" ).prop("selected", true);


});//end click add





	// $('.add_clearing_tool').on('click',function(){

	// 	//alert('test');

	// 	//hide tr no-data
	// 	$(this).parents(".table_clearing_tool").find(".data_null").hide();
		
 //        var select_chemical = $(this).parents("tr").find("select[name='select_chemical']").val();
 //        //alert(select_chemical);

 //        var select_chemical_name = $(this).parents("tr").find(".select_chemical_name").val();
 //        //alert(select_chemical_name);    	

 //        var mat_type = $(this).parents("tr").find(".temp_mat_type").val();
 //        //alert(mat_type);

 //        var mat_group = $(this).parents("tr").find(".temp_mat_group").val();
 //        //alert(mat_group);

 //        var  quantity = $(this).parents("tr").find(".temp_quantity").val();
 //        //alert(quantity);

 //        var  unit = $(this).parents("tr").find(".temp_unit").val();
 //        //alert(unit);


 //        var  price = $(this).parents("tr").find(".price_chemical").val();
 //        //alert(price);

 //        var  total_price = $(this).parents("tr").find(".temp_total_price").val();
 //        //alert(total_price);


 //        // if(mat_type=='Z014'){
 //        //     quantity = -1;
 //        //     unit = -1;
 //        //     price = -1;

 //        // }//end if


 //        if (select_chemical == undefined || select_chemical == '' || select_chemical == 0 ||
 //        	select_chemical_name == undefined || select_chemical_name == '' || select_chemical_name == 0 ||        	
 //        	mat_type == undefined || mat_type == '' || mat_type == 0
 //        	){
            
 //           $(this).parents("tr").find('.text_msg1').html('กรุณากรอกข้อมูล');
 //       }

 //       if (quantity == undefined || quantity == '' || quantity == 0 ||
 //       		unit == undefined || unit == '' || unit == 0        		
 //       	 ){
 //            $(this).parents("tr").find('.text_msg2').html('กรุณากรอกข้อมูล');
 //       }


 //       if (price == undefined || price == '' || price == 0 ){
 //            $(this).parents("tr").find('.text_msg3').html('กรุณากรอกข้อมูล');
 //       }

 //       if (total_price == undefined || total_price == '' || total_price == 0 ){
 //            $(this).parents("tr").find('.text_msg4').html('กรุณากรอกข้อมูล');
 //       }


 //    if (select_chemical != undefined && select_chemical != '' && select_chemical != 0 && 
 //    	select_chemical_name != undefined && select_chemical_name != '' && select_chemical_name != 0 && 
	//     mat_type != undefined && mat_type != '' && mat_type != 0 &&
	//   	quantity != undefined && quantity != '' && quantity != 0 &&
	//     unit != undefined && unit != '' && unit != 0 &&
	//     price != undefined && price != '' && price != 0 &&
	//     total_price != undefined && total_price != '' && total_price != 0 	          
	//     ){

 //    	//set count
 //    	var count = $(".count_clearing_tool").val();
 //    	count++; 
 //    	//alert(count);

	//   	var row = "<tr class='h5 tx-green' id='"+select_chemical+"'>";	   


	//  		row += "<td style='width:260px;'>";  
	//   		row += "<div class='input-group m-b'>"; 
	//   		row += "<span class='input-group-addon'><font class='pull-left'>frequency</font></span>" 
	//   		row += "<select data-parsley-required='true' data-parsley-error-message='' class='form-control frequency' name='tool_frequency_"+count+"' >";
	//   		//row += "<option seleted='seleted' value=' '>กรุณาเลือกบริการ</option>";
<?php 
	// $temp_area_clearing = $get_area->row_array();
	// $array_frequency =array('');
	// if(!empty($temp_area_clearing)){ 
	// foreach($get_area->result_array() as $value){ 
	//   if($value['is_on_clearjob']==1){
	//     if (in_array( $value['frequency'], $array_frequency, TRUE)){                
	//             //echo "have";
	//     }else{
	//         //echo "nohave";
	//         array_push($array_frequency,$value['frequency']);            
	//     }//end else 
	//   }//end if check clearing
	// }//end foreach
	// }//end if 
	// $temp_frequency= $array_frequency;
	// if(!empty($temp_frequency)){
	// foreach($array_frequency as $a => $a_value) { 
	// if($a != 0){
?>
	   		// var a_value ="<?php echo $a_value; ?>"
	     //    row += "<option  value='"+a_value+"'>Every "+a_value+" m</option>"; 
<?php 
// 		}//end if
// 	}//end foreach
// }else{ 
?>
            //row+="<option value='0'>ไม่มีข้อมูล</option>" ;
<?php //} ?>	  		
// 	  		row += "</select>";  
// 	  		row += "</td>";  


// 	  		row += "<td>";
// 	  		row += parseInt(select_chemical)+' '+select_chemical_name;
// 	  		row += "<input type='hidden' readonly class='form-control material_no' name='tool_material_no_"+count+"' value='"+select_chemical+"'>";
// 	  		row += "<input type='hidden' readonly class='form-control mat_type' name='tool_mat_type_"+count+"' value='"+mat_type+"'>";
// 	  		row += "<input type='hidden' readonly class='form-control mat_group' name='tool_mat_group_"+count+"' value='"+mat_group+"'>";
// 	  		row += "</td>";


// 	  		row += "<td class='tx-center'>";
// 	  		row += quantity+' '+unit;
// 	  		row += "<input type='hidden' readonly class='form-control quantity' name='tool_quantity_"+count+"' value='"+quantity+"'>";
// 	  		row += "<input type='hidden' readonly class='form-control unit_code' name='tool_unit_code_"+count+"' value='"+unit+"'>";
// 	  		row += "</td>";

// 	  		row += "<td>";
// 	  		row += price;
// 	  		row +=  "<input type='hidden' readonly class='form-control price' name='tool_price_"+count+"' value='"+replaceComma(price)+"'>";
// 	  		row += "</td>";


// 	  		row += "<td>";
// 	  		row += total_price;
// 	  		row += "<input type='hidden' readonly class='form-control total_price' name='tool_total_price_"+count+"' value='"+replaceComma(total_price)+"'>";
// 	  		row += "</td>";

// 	  		row += "<td class='tx-center'>";																																
// 	  		row += "<span class='margin-left-small'><button type='button' data-id='"+select_chemical+"' data-txt='"+select_chemical+" "+select_chemical_name+"' onclick='SomeDeleteRowFunction_clearing("+replaceComma(total_price)+",this);' class='btn btn-default '><i class='fa fa-trash-o'></i></button></span>";
// 	  		row += "</td>";

// 	  		row += "</tr>"

//         //ADD : row to table
//         $(this).parents(".table_clearing_tool").find("tbody").append(row);

//         //== set : count_row_frequency ===
// 			//alert(temp_space_no+' '+count);	
// 			$(".count_clearing_tool").val(count);

//         //==  set : null
// 	      //$(this).parents(".table_chemical").find('tr .select_chemical').val('0');
// 	      //$(this).parents(".table_chemical").find('tr .select_chemical option[value="'+select_chemical+'"]').remove();
//           $(this).parents(".table_clearing_tool").find('tr .select_chemical .select2-chosen').html('กรุณาเลือก');

// 	      $(this).parents(".table_clearing_tool").find('tr .select_chemical_name').val('');
// 	      $(this).parents(".table_clearing_tool").find('tr .temp_mat_group').val('');

// 	      $(this).parents(".table_clearing_tool").find('tr .temp_quantity').val('');
// 	      $(this).parents(".table_clearing_tool").find('tr .temp_quantity').attr('readonly', true);
// 	      $(this).parents(".table_clearing_tool").find('tr .text_unit').html('หน่วย');
// 	      $(this).parents(".table_clearing_tool").find('tr .temp_unit').val('');
// 	      $(this).parents(".table_clearing_tool").find('tr .price_chemical').val('');
// 	      $(this).parents(".table_clearing_tool").find('tr .temp_total_price').val('');

// 	      $(this).parents(".table_clearing_tool").find('.text_msg1').html('');
// 	      $(this).parents(".table_clearing_tool").find('.text_msg2').html('');
// 	      $(this).parents(".table_clearing_tool").find('.text_msg3').html('');
// 	      $(this).parents(".table_clearing_tool").find('.text_msg4').html('');


// 	      //////////////////////// START : SET TOTAL  //////////////////////////////////
// 			total_price = replaceComma(total_price);
// 			////////////////   TOTAL TFOOT Z005 //////////////////				  			
// 		    total_price = parseFloat(total_price);	
// 		    //alert("test"+total_price);  
// 		    var total_tfoot =  $(this).parents(".table_clearing_tool").find(".total_tfoot").val();	
// 		    	total_tfoot = replaceComma(total_tfoot);		     
// 			//alert(total_tfoot+' '+total_price);
//          	   	total_tfoot = parseFloat(total_tfoot);
// 			   	total_tfoot = parseFloat(total_tfoot+total_price);
// 			   	total_tfoot = total_tfoot.toFixed(2);
// 			   	//add function comma
//                	total_tfoot = commaSeparateNumber(total_tfoot);
// 			    $(this).parents(".table_clearing_tool").find(".total_tfoot").val(total_tfoot);

// 			 ////////////////   TOTAL total_clearing_tool //////////////////				
// 				 total_price = parseFloat(total_price);			     
// 			     var total_clearing_tool = $('.total_clearing_tool').val();
// 			     	 total_clearing_tool = replaceComma(total_clearing_tool);
// 			     	 total_clearing_tool = parseFloat(total_clearing_tool);
// 			     //alert(total_clearing_tool+'  '+total_price);
// 			     total_clearing_tool = parseFloat(total_clearing_tool+total_price);
// 			   	 total_clearing_tool = total_clearing_tool.toFixed(2);
// 			   	//add function comma
//                	total_clearing_tool = commaSeparateNumber(total_clearing_tool);
// 			    $('.total_clearing_tool').val(total_clearing_tool);
		
//            var  sub_total_chemical_clearing = $('.sub_total_chemical_clearing').val();
//            		sub_total_chemical_clearing = replaceComma(sub_total_chemical_clearing);
//            var  total_macheine_clearing = $('.total_macheine_clearing').val();
//            		total_macheine_clearing = replaceComma(total_macheine_clearing);
//            var  total_clearing_tool = $('.total_clearing_tool').val();
//            		total_clearing_tool = replaceComma(total_clearing_tool);

//           var all_total = parseFloat(sub_total_chemical_clearing) + parseFloat(total_macheine_clearing) + parseFloat(total_clearing_tool);
//           //add function comma
//           all_total = commaSeparateNumber(all_total);
//           $('input[name="total_all_clearing"]').val(all_total);

//     }//end if

		
//     //$(this).closest('table').find("select[name='select_chemical'] option[value='"+select_chemical+"']").remove();
//     $(this).closest('table').find( "select[name='select_chemical'] option:first" ).prop("selected", true);

// });//end click add
//<!--################################ END :ADD tool   ############################-->







/////////////////////////// START :  CALCURATE STAFF CLEARING JOB /////////////////////////////////////////

//==== start : keyup staff_clearing,rate_job  price staff =========
$(".staff_clearing,.rate_job").on('keyup', function() {

var staff_clearing = $(this).parents(".div-calcurate-clearing").find('.staff_clearing').val();			
	//alert('staff_clearing:'+staff_clearing);

var rate_job = $(this).parents(".div-calcurate-clearing").find('.rate_job').val();
	rate_job = replaceComma(rate_job);		
	//alert('rate_job:'+rate_job);		


if(staff_clearing=='' || staff_clearing==undefined){ 
	staff_clearing='0'; 
 // $(this).parents(".div-calcurate-clearing").find('.staff_clearing').val(staff_clearing);
}
if(rate_job=='' || rate_job==undefined){ 
	rate_job='0';  
// $(this).parents(".div-calcurate-clearing").find('.rate_job').val(rate_job);
}


staff_clearing = parseFloat(staff_clearing);
rate_job = parseFloat(rate_job);



//=== benefit ====
var price_job = 0;
	price_job = parseFloat(price_job);
	price_job = parseFloat(staff_clearing*rate_job);
	//set : 2 double
	price_job = price_job.toFixed(2);

//add function comma
price_job = commaSeparateNumber(price_job);
//== push data ==
$(this).parents(".div-calcurate-clearing").find('.price_job').val(price_job);


///////////////// calcurate  total_price //////////////////

var other_price = $(this).parents(".div-calcurate-clearing").find('.other_price').val();		
		
	//alert('other_price:'+other_price);


if(other_price=='' || other_price==undefined){ 
	other_price='0'; 
 // $(this).parents(".div-calcurate-clearing").find('.other_price').val(other_price);
}
if(price_job=='' || price_job==undefined){ 
	price_job='0';  
// $(this).parents(".div-calcurate-clearing").find('.price_job').val(price_job);
}

other_price = replaceComma(other_price);
other_price = parseFloat(other_price);
price_job = replaceComma(price_job);
price_job = parseFloat(price_job);



//=== total_price ====
var total_price = 0;
	total_price = parseFloat(total_price);
	total_price = parseFloat(price_job+other_price);
	//set : 2 double
	total_price = total_price.toFixed(2);

//add function comma
total_price = commaSeparateNumber(total_price);
//== push data ==
$(this).parents(".div-calcurate-clearing").find('.total_price').val(total_price);




});//==== end : keyup staff_clearing,rate_job  price staff =========





//==== start : keyup staff_clearing   =========
$(".staff_clearing").on('keyup', function() {
var staff_clearing = $(this).val();

var other_price_man =  $(this).parents(".div-calcurate-clearing").find('.other_price_man').val();		
//alert('other_price_man:'+other_price_man);

var price_job = $(this).parents(".div-calcurate-clearing").find('.price_job').val();		
	//alert('price_job:'+price_job);


if(staff_clearing=='' || staff_clearing==undefined){ 
	staff_clearing='0'; 
 // $(this).parents(".div-calcurate-clearing").find('.other_price').val(other_price);
}

if(other_price_man=='' || other_price_man==undefined){ 
	other_price_man='0'; 
 // $(this).parents(".div-calcurate-clearing").find('.other_price').val(other_price);
}

if(price_job=='' || price_job==undefined){ 
	price_job='0';  
// $(this).parents(".div-calcurate-clearing").find('.price_job').val(price_job);
}


staff_clearing = parseFloat(staff_clearing);
other_price_man = replaceComma(other_price_man);
other_price_man = parseFloat(other_price_man);
price_job = replaceComma(price_job);
price_job = parseFloat(price_job);


//=== other_price =====
var other_price = 0;
	other_price = parseFloat(other_price);
	other_price = parseFloat(other_price_man*staff_clearing);
	//set : 2 double
	other_price = other_price.toFixed(2);
	//alert(other_price);

//add function comma
other_price = commaSeparateNumber(other_price);	
//== push data other price==
$(this).parents(".div-calcurate-clearing").find('.other_price').val(other_price);



//=== total_price ====
var total_price = 0;
	other_price = replaceComma(other_price);
	other_price = parseFloat(other_price);
	total_price = parseFloat(total_price);
	total_price = parseFloat(price_job+other_price);
	//set : 2 double
	total_price = total_price.toFixed(2);

//add function comma
total_price = commaSeparateNumber(total_price);	
//== push data ==
$(this).parents(".div-calcurate-clearing").find('.total_price').val(total_price);



});
//==== End : keyup staff_clearing   ========= 

//==== start : keyup other_price_man  total_price =========
$(".other_price_man").on('keyup', function() {
var other_price_man = $(this).val();		
	//alert('other_price_man:'+other_price_man);

var staff_clearing = $(this).parents(".div-calcurate-clearing").find('.staff_clearing').val();		
	//alert('staff_clearing:'+staff_clearing);

var price_job = $(this).parents(".div-calcurate-clearing").find('.price_job').val();		
	//alert('price_job:'+price_job);

if(other_price_man=='' || other_price_man==undefined){ 
	//alert("hell");
	other_price_man='0'; 
 // $(this).parents(".div-calcurate-clearing").find('.other_price').val(other_price);
}

if(staff_clearing=='' || staff_clearing==undefined){ 
	staff_clearing='0';  
// $(this).parents(".div-calcurate-clearing").find('.price_job').val(price_job);
}


if(price_job=='' || price_job==undefined){ 
  price_job='0';  
// $(this).parents(".div-calcurate-clearing").find('.price_job').val(price_job);
}


other_price_man = replaceComma(other_price_man);
other_price_man = parseFloat(other_price_man);
staff_clearing = parseFloat(staff_clearing);
price_job = replaceComma(price_job);
price_job = parseFloat(price_job);

//=== other_price =====
var other_price = 0;
	other_price = parseFloat(other_price);
	other_price = parseFloat(other_price_man*staff_clearing);
	//set : 2 double
	other_price = other_price.toFixed(2);
	//alert(other_price);

//add function comma
other_price = commaSeparateNumber(other_price);		
//== push data other price==
$(this).parents(".div-calcurate-clearing").find('.other_price').val(other_price);


//=== total_price ====
var total_price = 0;
	other_price = replaceComma(other_price);
	other_price = parseFloat(other_price);
	total_price = parseFloat(total_price);
	total_price = parseFloat(price_job+other_price);
	//set : 2 double
	total_price = total_price.toFixed(2);

//add function comma
total_price = commaSeparateNumber(total_price);	
//== push data ==
$(this).parents(".div-calcurate-clearing").find('.total_price').val(total_price);


});//==== end : keyup other_price_man  total_price =========


/////////////////////////// END :  CALCURATE STAFF CLEARING JOB /////////////////////////////////////////



save_clearing();


})// end document
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////








//############################ start : delete row  chemical  ##################################################
 function SomeDeleteRowFunction_clearing(total_price,btndel) {
 	
    if (typeof(btndel) == "object") {

    	total_price = parseFloat(total_price);
		//alert(total_price);		

	   	var mat_type = $(btndel).parents("tr").find(".mat_type").val();
	   //alert(mat_type);

	    var temp_frequency = $(btndel).parents("tr").find(".frequency").val();
	   // alert(temp_frequency);
		

		if(mat_type=='Z001' || mat_type =='Z013' || mat_type=='Z005' || mat_type=='Z002' || mat_type=='Z014'){

			////////////////   TOTAL TFOOT //////////////////		  		
			     total_price = parseFloat(total_price);			     
			     var total_tfoot = $(btndel).parents(".table_chemical").find('.total_tfoot').val();
			     	 total_tfoot = replaceComma(total_tfoot);
			     	 total_tfoot = parseFloat(total_tfoot);
			     //alert(total_tfoot+'  '+total_tfoot);
			     total_tfoot = parseFloat(total_tfoot-total_price);
			   	 total_tfoot = total_tfoot.toFixed(2);
			   	//add function comma
				total_tfoot = commaSeparateNumber(total_tfoot);
			    $(btndel).parents(".table_chemical").find('tr .total_tfoot').val(total_tfoot);

		////////////////   TOTAL div-frequency-clearing //////////////////
				total_price = parseFloat(total_price);			     
			     var subtotal_fre = $(btndel).parents(".div-frequency-clearing").find('.sub_total_frequency_'+temp_frequency).val();
			     	 subtotal_fre = replaceComma(subtotal_fre);
			     	 subtotal_fre = parseFloat(subtotal_fre);
			     //alert(subtotal_fre+'  '+total_price);
			     subtotal_fre = parseFloat(subtotal_fre-total_price);
			   	 subtotal_fre = subtotal_fre.toFixed(2);
			   	 //add function comma
				 subtotal_fre = commaSeparateNumber(subtotal_fre);
			     $(btndel).parents(".div-frequency-clearing").find('.sub_total_frequency_'+temp_frequency).val(subtotal_fre);

	   //////////////////////////  SUB_TOTAL CHEMICAL ////////////////////////////
	   	// 		total_price = parseFloat(total_price);			     
			  //   var total_clearing_chemical = $(".sub_total_chemical_clearing").val();
			  //    	 total_clearing_chemical = replaceComma(total_clearing_chemical);
			  //    	 total_clearing_chemical = parseFloat(total_clearing_chemical);
			  //   // alert(total_clearing_chemical+'  '+total_price);
			  //    total_clearing_chemical = parseFloat(total_clearing_chemical-total_price);
			  //  	 total_clearing_chemical = total_clearing_chemical.toFixed(2);
			  //  	 //add function comma
				 // total_clearing_chemical = commaSeparateNumber(total_clearing_chemical);
			  //  	 $(".sub_total_chemical_clearing").val(total_clearing_chemical);



		}//end if

		// if(mat_type=='Z002' || mat_type =='Z014'){

		// 	////////////////   TOTAL TFOOT Z005 //////////////////				  			
		//     total_price = parseFloat(total_price);	
		//     //alert("test"+total_price);  
		//     var total_tfoot = $(btndel).parents(".table_clearing_tool").find(".total_tfoot").val();
		//     	total_tfoot = replaceComma(total_tfoot);			     
		// 	//alert(total_tfoot+' '+total_price);
		// 		 total_tfoot = parseFloat(total_tfoot-total_price);
		// 	   	 total_tfoot = total_tfoot.toFixed(2);
		// 	   	 //add function comma
		// 		 total_tfoot = commaSeparateNumber(total_tfoot);
		// 	    $(btndel).parents(".table_clearing_tool").find(".total_tfoot").val(total_tfoot);

		// 	 ////////////////   TOTAL total_clearing_tool //////////////////
				
		// 		 total_price = parseFloat(total_price);			     
		// 	     var total_clearing_tool = $('.total_clearing_tool').val();
		// 	     	 total_clearing_tool = replaceComma(total_clearing_tool);
		// 	     	 total_clearing_tool = parseFloat(total_clearing_tool);
		// 	     //alert(total_clearing_tool+'  '+total_price);

		// 	     total_clearing_tool = parseFloat(total_clearing_tool-total_price);
		// 	   	 total_clearing_tool = total_clearing_tool.toFixed(2);
		// 	   	  //add function comma
		// 		 total_clearing_tool = commaSeparateNumber(total_clearing_tool);
		// 	    $('.total_clearing_tool').val(total_clearing_tool);

		// }//end if

		// if(mat_type=='Z005'){

		// 	////////////////   TOTAL TFOOT Z005 //////////////////				  			
		//     total_price = parseFloat(total_price);	
		//     //alert("test"+total_price);  
		//     var total_tfoot_Z005 =  $(".total_tfoot_Z005").val();	
		//     	total_tfoot_Z005 = replaceComma(total_tfoot_Z005);		     
		// 	//alert(total_tfoot_Z005+' '+total_price);
		// 		 total_tfoot_Z005 = parseFloat(total_tfoot_Z005-total_price);
		// 	   	 total_tfoot_Z005 = total_tfoot_Z005.toFixed(2);
		// 	   	 //add function comma
		// 		 total_tfoot_Z005 = commaSeparateNumber(total_tfoot_Z005);
		// 	    $('.total_tfoot_Z005').val(total_tfoot_Z005);

		// 	 ////////////////   TOTAL totol_macheine_clearing //////////////////
				
		// 		 total_price = parseFloat(total_price);			     
		// 	     var total_macheine_clearing = $('.total_macheine_clearing').val();
		// 	     	 total_macheine_clearing = replaceComma(total_macheine_clearing);
		// 	     	 total_macheine_clearing = parseFloat(total_macheine_clearing);
		// 	     //alert(total_macheine_clearing+'  '+total_price);

		// 	     total_macheine_clearing = parseFloat(total_macheine_clearing-total_price);
		// 	   	 total_macheine_clearing = total_macheine_clearing.toFixed(2);
		// 	   	 //add function comma
		// 		 total_macheine_clearing = commaSeparateNumber(total_macheine_clearing);
		// 	    $('.total_macheine_clearing').val(total_macheine_clearing);



		// }//end if

    ///////////////////////// TOTAL ALL ////////////////////////////////////
    var total_all = $("input[name='total_all_clearing']").val();
    total_all = replaceComma(total_all); 
    total_all = parseFloat(total_all); 
    total_all = parseFloat(total_all-total_price);  
    //add function comma
	total_all = commaSeparateNumber(total_all);
    $("input[name='total_all_clearing']").val(total_all);





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

    	$(btndel).closest("tr").remove();

	}else{
        return false;
    }
}

//############################ END : delete row  chemical ##################################################
function save_clearing(){
$('.save-btn-clearing').on('click', function (){
//alert('tst clearing');
	// $('#form_clone_staff').removeAttr('novalidate');
	// $('*[data-parsley-required="true"]').removeAttr('data-parsley-id');
	// $('.parsley-errors-list').remove();
	// $('#form_clone_staff').parsley().destroy();
	// $('#form_clone_staff').parsley().reset();
	// $('#form_clone_staff').parsley();

	var valid = $('#form_clearing').parsley().validate();
	if (valid) {
		$('#form_clearing').submit();
	} 
	return false;

});

}

//  function fieldCheck_clearing(){
     
// 	//check sold to selected====================================
// 	if($('.frequency').val() == 0 ){
// 	  $('.frequency').css('border','1px solid red');
// 	  alert('กรุณากรอกข้อมูล frequency');
// 	  return false;
// 	}


// }//eind fieldcheck


</script>