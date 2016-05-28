<script type="text/javascript">

// $('.a').on('click', function() {
// 	x($(this));
// })

// function x (a) {

// }
function selected_uniform(){

var  level_staff ='';
$( ".level_staff" ).change(function(){
level_staff = $(this).val();
//alert('level_staff :'+level_staff);

var group_id = $(this).parents(".clone_group").attr("id");
var str = group_id;
group_id = str.substring(12);
//alert(group_id);

var obj =  $("select[name='uniform_gr"+group_id+"']");
//todo :: disabled
$("select[name='uniform_gr"+group_id+"']").attr('disabled', true);

 $.ajax({
	      type: "GET",
	      url: '<?php echo site_url("__ps_quotation/get_ajax_uniform");?>'+'/'+level_staff ,
	      data: {},
	      dataType: "json",
	      success: function(data){	        
	        ////console.log('return data is : ');
	        ////console.log(data);                                    	          
	           //alert('success');
               obj.empty();
               obj.append('<option value="" >กรุณาเลือก</option>');  
	         //alert('test group');                                  
	           var count = 0;                  
	            for(var index in data){                          
	              var i = data[index];
	               if(i.material_no){
	                    obj.append('<option value="'+i.material_no+'" >'+i.material_description+'</option>');	                     
	                    //obj.append('<option value="'+i.material_no+'" >'+i.material_description+' '+i.price+'</option>');
	                    count++	                  
	                }
	            }//end for                    
	            if(count==0){
	              obj.append('<option value="0" >ไม่มีข้อมูล</option>');
	            }//end if 

	         	//TODO :: MANAGE
	              $("select[name='uniform_gr"+group_id+"']").attr('disabled', false);
	      },
	      error:function(err){
	        //console.log('error : ');
	        //console.log(err);
	      },
	      complete:function(){
	      }
    })//end ajax function


});//end change

}//end fun




function selected_position(){

var  position ='';
$( ".level_staff" ).change(function(){
level_staff = $(this).val();
//alert('level_staff :'+level_staff);

var group_id = $(this).parents(".clone_group").attr("id");
var str = group_id;
group_id = str.substring(12);
//alert(group_id);

var obj =  $("select[name='position_gr"+group_id+"']");
//todo :: disabled
$("select[name='position_gr"+group_id+"']").attr('disabled', true);

 $.ajax({
	      type: "GET",
	      url: '<?php echo site_url("__ps_quotation/get_ajax_position");?>'+'/'+level_staff ,
	      data: {},
	      dataType: "json",
	      success: function(data){	        
	        ////console.log('return data is : ');
	        ////console.log(data);                                    	          
	           //alert('success');
               obj.empty();
               obj.append('<option value="" >กรุณาเลือก</option>');  
	         //alert('test group');                                  
	           var count = 0;                  
	            for(var index in data){                          
	              var i = data[index];
	               if(i.id){
	                    obj.append('<option value="'+i.id+'" >'+i.title+'</option>');	                     
	                    //obj.append('<option value="'+i.material_no+'" >'+i.material_description+' '+i.price+'</option>');
	                    count++	                  
	                }
	            }//end for                    
	            if(count==0){
	              obj.append('<option value="0" >ไม่มีข้อมูล</option>');
	            }//end if 

	         	//TODO :: MANAGE
	              $("select[name='position_gr"+group_id+"']").attr('disabled', false);
	      },
	      error:function(err){
	        //console.log('error : ');
	        //console.log(err);
	      },
	      complete:function(){
	      }
    })//end ajax function


});//end change

}//end fun




function check_auto(){

$('.is_auto_ot').on('click', function() {
	var overtime_id = $(this).parents(".clone_group").find('.overtime_id').val();
	//alert(overtime_id);
	if(overtime_id=='000000000000030040'){
		$(this).parents(".clone_group").find('.overtime_id').val('000000000000030041');
	}else{
		$(this).parents(".clone_group").find('.overtime_id').val('000000000000030040');
	}	
});	//end click is_auto_ot

$('.is_auto_transport').on('click', function() {
	var transport_exp_id = $(this).parents(".clone_group").find('.transport_exp_id').val();
	//alert(transport_exp_id);

	if(transport_exp_id=='000000000000030033'){
		$(this).parents(".clone_group").find('.transport_exp_id').val('000000000000030034');
	}else{
		$(this).parents(".clone_group").find('.transport_exp_id').val('000000000000030033');
	}	
});	//end click is_auto_ot


$('.is_auto_special').on('click', function() {
	var special_id = $(this).parents(".clone_group").find('.special_id').val();
	//alert(transport_exp_id);

	if(special_id=='000000000000030028'){
		$(this).parents(".clone_group").find('.special_id').val('000000000000030050');
	}else{
		$(this).parents(".clone_group").find('.special_id').val('000000000000030028');
	}	
});	//end click is_auto_ot


}//end check_auto

function Chang_level(){
	$('.level_staff').on('change', function() {
		var group_id = $(this).parents(".clone_group").attr("id");
		var str = group_id;
		group_id = str.substring(12);
		//alert(group_id);

		var level_staff = $(this).val();
		//alert('level_staff :'+level_staff);
		 $(this).parents(".clone_group").find('.rate_day').attr('checked', false);
		 $(this).parents(".clone_group").find('.rate_month').attr('checked', false);
		 $(this).parents(".clone_group").find('.daily_pay_rate').attr('disabled', true);		 
		 $(this).parents(".clone_group").find('.daily_pay_rate').val('');
		 $(this).parents(".clone_group").find('.radio_pay_rate').attr('disabled', false);		 

		if(level_staff=='Z001'){
			 $(this).parents(".clone_group").find('.daily_pay_rate_id').val('000000000000030025');
			 // $(this).parents(".clone_group").find('.rate_day').attr('disabled', true);
			 // document.getElementById("rate_month_"+group_id).checked = true;
			 //$(this).parents(".clone_group").find('.daily_pay_rate').attr('disabled', false);	

		}else{
			 $(this).parents(".clone_group").find('.daily_pay_rate_id').val('000000000000030023');
			 //$(this).parents(".clone_group").find('.rate_day').attr('disabled', false);	
			 //document.getElementById("rate_month_"+group_id).checked = false;	
		}
	
	});

	$('.radio_pay_rate').on('click', function() {
		$(this).parents(".clone_group").find('.daily_pay_rate').attr('disabled', false);
	});


}//end function chage level


function add_other(ele){

		//$(".add-other").on('click',function(){ 
			var count_other_selected = ele.parents(".div-other").find(".count_ohter_select").val();
			//alert(count_other_selected);

			var other_type_id = ele.attr("id");
			var other_type_id_name = ele.attr("name");
			//alert("other_type_id ::"+other_type_id+" || other_type_id-name :: "+other_type_id_name);
			//console.log(ele.parents(".clone_group").attr("id"));
			var group = ele.parents(".clone_group").attr("id");
		 	var str = group;
		    var group = str.substring(12);

		    var count_other = ele.parents(".clone_group").find('.count_other_group').val();
		    //$("input[name='count_other_group_'"+group+"]").val();  

		    var data_type = '';
		    var temp_text = '';
		    if(other_type_id=='000000000000030044'){
		    	data_type = 'm';
		    	temp_text = 'THB/M';
		    }else{
		    	data_type = 'd';
		    	temp_text = 'THB/D';
		    }


		     if(count_other!=10){
			    count_other++;
			     ele.parents(".clone_group").find('.count_other_group').val(count_other);  
				//alert(group+' '+count_other);

				var row = 	'<div class="col-sm-4 div-other-add">';
			        row	+=  '<div class="input-group m-b">';
			        row	+=  '<span class="input-group-addon">';
			        row	+=  '<div class="label-width-adon"><font class="pull-left text-other">';
			        row	+=	other_type_id_name+' : '; //+other_type_id_name;
			        row	+=  '</font></div>';
			        row	+=  '</span> ';
			        row	+=  '<input type="hidden" class="form-control input-other "  data-type="'+data_type+'" name="other_typeID_'+count_other+'_group_'+group+'" value="'+other_type_id+'">';
			        row	+=  '<input type="text" autocomplete="off" onkeypress="return isDouble(event)" class="form-control input-other text-right" name="other_'+count_other+'_group_'+group+'" value="">';
			        row	+=  '<span class="input-group-addon"><?php  echo freetext("'+temp_text+'"); ?></span>';
			        row	+=  '<span class="input-group-addon btn btn-default btn-sm delete_other" data-id="'+other_type_id+'" data-txt="'+other_type_id_name+'"><i class="fa fa-trash-o h4"></i></span>';
			       // <span class="input-group-addon btn btn-default btn-sm btn-success btn-benefit">THB</span>
			        row	+=  '</div> ';
			        row	+=  '</div> ';

			     //=== Add oher to div other == 
			     ele.parents(".clone_group").find(".div-other").append(row);

			     /////////// CALCULATE ALL ////////////////
				$(".daily_pay_rate,.overtime,.holiday,.work_day,.work_holiday,.sub_group_staff,.input-other,.bonus,.transport_exp,.incentive,.other_value,.rate_position,.special,.total_man").on('keyup', function() {
					Calculat_ALL($(this),0);
				});

// add comma
$('.input-other').on('keyup', function() {
    
var val = $(this).val();
    val = replaceComma(val);

if(val!=''){
    var last_index = val.substr(val.length-1);
    if (last_index == '.') {
      return true;
    }

    var isint = isInteger(parseFloat(val));

        // console.log('# '+val);

        if (isint) {
          val = parseFloat(val).toMoney( 0 );
        } else {
          var seperator = val.indexOf('.');
          var decimal   = val.substr(seperator+1);
          val = parseFloat(val).toMoney(decimal.length);
        }

        // console.log('## '+val);
      $(this).val(val.toString());

}//end if

});//end input other


		     }//end if  

		     if(count_other==10){

		     	 ele.parents(".clone_group").find('.dropdown-toggle').attr('disabled', true);

		     }//end if     

		      //== remove slected==
			    // add-other
			     count_other_selected =  parseInt(count_other_selected-1);
			     //alert('count_other_selected : '+count_other_selected);

			     if(count_other_selected==0){
			     	var li_option =  "<li ><a href='#''>ไม่มีข้อมูล</a></li>";	
			     	ele.parents(".div-other").find(".dropdown-menu").append(li_option);

			     }//end if

			     ele.parents(".div-other").find(".count_ohter_select").val(count_other_selected);
			     ele.remove();

			///////////  delete_other ///////////////
			$(".delete_other").on('click',function(){  
				Calculat_ALL($(this),0);
				delete_other($(this));
			});
		//});//end on click

}//end function add other

function delete_other(ele){	
//var temp_ele = ele;	
	//console.log('delete other');
	//$(".delete_other").on('click',function(){     	
    	var count_other = ele.parents(".clone_group").find('.count_other_group').val();
    	//alert(count_other);
    	if(count_other==10){
     	 	ele.parents(".clone_group").find('.dropdown-toggle').attr('disabled', false);
     	}//end if  
    	ele.parents(".clone_group").find('.count_other_group').val(count_other-1);
    	
    	var li = ele.parents('.clone_group').find('ul.dropdown-menu');
      	var id = ele.data('id');
      	var txt = ele.data('txt');
      	//alert(txt);  
      	li.append("<li class='add-other' id='"+id+"' name='"+txt+"' ><a href='#''>"+txt+"</a></li>");

    	//alert('delete_off');	
    	ele.parents(".div-other-add").remove(); 

    	///////////  add_other ///////////////
    	$(".add-other").on('click',function(){ 
			//== call function add other
			Calculat_ALL($(this),0);
			add_other($(this));
		});

		//Calculat_ALL(temp_ele);
    //});//end on click

}//end function delete other


function Clone_group(ele){

//$(".add-group").on('click',function(){ 
    var cloneGroup = $('#count_add_group').val();	  
	var count_add_group = $('#count_add_group');
    cloneGroup++; 
    //alert(cloneGroup); 
      //alert('ts');
         $("#clone_group_0").clone(true)
          .removeClass("hide") 
          .appendTo(".div-group-staff")
          .attr("id", "clone_group_" +  cloneGroup) 
         
         // alert(cloneGroup);

           $("#clone_group_"+cloneGroup+" ").find('.group_title').attr("name","group_title_gr"+ cloneGroup);
           $("#clone_group_"+cloneGroup+" ").find('.total_man').attr("name","total_man_gr"+ cloneGroup);
          // $("#clone_group_"+cloneGroup+" ").find('.sub_total_group').attr("name","sub_total_group_gr"+ cloneGroup);
           $("#clone_group_"+cloneGroup+" ").find('.overtime').attr("name","overtime_gr"+ cloneGroup);
           $("#clone_group_"+cloneGroup+" ").find('.overtime_id').attr("name","overtime_id_gr"+ cloneGroup);
           $("#clone_group_"+cloneGroup+" ").find('.is_auto_ot').attr("name","is_auto_ot_gr"+ cloneGroup);

           $("#clone_group_"+cloneGroup+" ").find('.incentive').attr("name","incentive_gr"+ cloneGroup);
           $("#clone_group_"+cloneGroup+" ").find('.incentive_id').attr("name","incentive_id_gr"+ cloneGroup);

           $("#clone_group_"+cloneGroup+" ").find('.transport_exp').attr("name","transport_exp_gr"+ cloneGroup);
           $("#clone_group_"+cloneGroup+" ").find('.is_auto_transport').attr("name","is_auto_transport_gr"+ cloneGroup);
           $("#clone_group_"+cloneGroup+" ").find('.transport_exp_id').attr("name","transport_exp_id_gr"+ cloneGroup);

           $("#clone_group_"+cloneGroup+" ").find('.daily_pay_rate').attr("name","daily_pay_rate_gr"+ cloneGroup);
           $("#clone_group_"+cloneGroup+" ").find('.daily_pay_rate_id').attr("name","daily_pay_rate_id_gr"+ cloneGroup);
           $("#clone_group_"+cloneGroup+" ").find('.radio_pay_rate').attr("name","daily_pay_rate_type_gr"+ cloneGroup);
           //todo
            $("#clone_group_"+cloneGroup+" ").find('.rate_day').attr("id","rate_day_"+ cloneGroup);
            $("#clone_group_"+cloneGroup+" ").find('.rate_month').attr("id","rate_month_"+ cloneGroup);

           $("#clone_group_"+cloneGroup+" ").find('.holiday').attr("name","holiday_gr"+ cloneGroup);
           $("#clone_group_"+cloneGroup+" ").find('.holiday_id').attr("name","holiday_id_gr"+ cloneGroup);

           $("#clone_group_"+cloneGroup+" ").find('.bonus').attr("name","bonus_gr"+ cloneGroup);
           $("#clone_group_"+cloneGroup+" ").find('.bonus_id').attr("name","bonus_id_gr"+ cloneGroup);

           //$("#clone_group_"+cloneGroup+" ").find('.is_auto_position').attr("name","is_auto_position_gr"+ cloneGroup);
           $("#clone_group_"+cloneGroup+" ").find('.is_auto_special').attr("name","is_auto_special_gr"+ cloneGroup);
           
           $("#clone_group_"+cloneGroup+" ").find('.rate_position_id').attr("name","rate_position_id_gr"+ cloneGroup);
           $("#clone_group_"+cloneGroup+" ").find('.rate_position').attr("name","rate_position_gr"+ cloneGroup);

           $("#clone_group_"+cloneGroup+" ").find('.special_id').attr("name","special_id_gr"+ cloneGroup);
           $("#clone_group_"+cloneGroup+" ").find('.special').attr("name","special_gr"+ cloneGroup);

           $("#clone_group_"+cloneGroup+" ").find('.count_other_group').attr("name","count_other_group_"+ cloneGroup);
           $("#clone_group_"+cloneGroup+" ").find('.other_title').attr("name","other_title_gr"+ cloneGroup);
           $("#clone_group_"+cloneGroup+" ").find('.other_value').attr("name","other_value_gr"+ cloneGroup);
           $("#clone_group_"+cloneGroup+" ").find('.other_id').attr("name","other_id_gr"+ cloneGroup);
           //$("#clone_group_"+cloneGroup+" .div-other").find('.input-other').attr("name","other_1_group_"+ cloneGroup);

           $("#clone_group_"+cloneGroup+" ").find('.level_staff').attr("name","level_staff_gr"+ cloneGroup);
           $("#clone_group_"+cloneGroup+" ").find('.position').attr("name","position_gr"+ cloneGroup);
           $("#clone_group_"+cloneGroup+" ").find('.uniform').attr("name","uniform_gr"+ cloneGroup);

           $("#clone_group_"+cloneGroup+" ").find('.waege').attr("name","waege_gr"+ cloneGroup);
           $("#clone_group_"+cloneGroup+" ").find('.benefit').attr("name","benefit_gr"+ cloneGroup);
           $("#clone_group_"+cloneGroup+" ").find('.benefit_man').attr("name","benefit_man_gr"+ cloneGroup);
           $("#clone_group_"+cloneGroup+" ").find('.wage_benefit').attr("name","wage_benefit_gr"+ cloneGroup);
           $("#clone_group_"+cloneGroup+" ").find('.sub_total').attr("name","sub_total_gr"+ cloneGroup);


           //chang name sub group clone 1
          $("#clone_group_"+cloneGroup+" ").find('.count_sub_group').attr("name","count_sub_group_"+ cloneGroup);
          $("#clone_group_"+cloneGroup+" #clone_sub_group_1").find('.sub_group_staff').attr("name","sub_group_staff_subg1_gr"+ cloneGroup);
          $("#clone_group_"+cloneGroup+" #clone_sub_group_1").find('.gender').attr("name","gender_subg1_gr"+ cloneGroup);
          //set custom radio day 
          $("#clone_group_"+cloneGroup+" #clone_sub_group_1").find('.day-radio').attr("name","day_radio_subg1_gr"+ cloneGroup);
          $("#clone_group_"+cloneGroup+" #clone_sub_group_1").find(".radio1").attr("id","radio11"+cloneGroup);
          $("#clone_group_"+cloneGroup+" #clone_sub_group_1").find(".radio2").attr("id","radio21"+cloneGroup);
          $("#clone_group_"+cloneGroup+" #clone_sub_group_1").find(".radio3").attr("id","radio31"+cloneGroup);
          $("#clone_group_"+cloneGroup+" #clone_sub_group_1").find(".radio4").attr("id","radio41"+cloneGroup);
          $("#clone_group_"+cloneGroup+" #clone_sub_group_1").find(".radio5").attr("id","radio51"+cloneGroup);
          $("#clone_group_"+cloneGroup+" #clone_sub_group_1").find(".radio6").attr("id","radio61"+cloneGroup);
          $("#clone_group_"+cloneGroup+" #clone_sub_group_1").find(".radio7").attr("id","radio71"+cloneGroup);
          $("#clone_group_"+cloneGroup+" #clone_sub_group_1").find(".radio8").attr("id","radio81"+cloneGroup);
	        $("#clone_group_"+cloneGroup+" #clone_sub_group_1").find(".radio_for1").attr("for","radio11"+cloneGroup);
			$("#clone_group_"+cloneGroup+" #clone_sub_group_1").find(".radio_for2").attr("for","radio21"+cloneGroup);
			$("#clone_group_"+cloneGroup+" #clone_sub_group_1").find(".radio_for3").attr("for","radio31"+cloneGroup);
			$("#clone_group_"+cloneGroup+" #clone_sub_group_1").find(".radio_for4").attr("for","radio41"+cloneGroup);
			$("#clone_group_"+cloneGroup+" #clone_sub_group_1").find(".radio_for5").attr("for","radio51"+cloneGroup);
			$("#clone_group_"+cloneGroup+" #clone_sub_group_1").find(".radio_for6").attr("for","radio61"+cloneGroup);
			$("#clone_group_"+cloneGroup+" #clone_sub_group_1").find(".radio_for7").attr("for","radio71"+cloneGroup);
			$("#clone_group_"+cloneGroup+" #clone_sub_group_1").find(".radio_for8").attr("for","radio81"+cloneGroup)


          $("#clone_group_"+cloneGroup+" #clone_sub_group_1").find('.time_start').attr("name","time_start_subg1_gr"+ cloneGroup);
          $("#clone_group_"+cloneGroup+" #clone_sub_group_1").find('.time_end').attr("name","time_end_subg1_gr"+ cloneGroup);
         //$("#clone_group_"+cloneGroup+" #clone_sub_group_1").find('.position').attr("name","position_subg1_gr"+ cloneGroup);
         //$("#clone_group_"+cloneGroup+" #clone_sub_group_1").find('.uniform').attr("name","uniform_subg1_gr"+ cloneGroup);
          $("#clone_group_"+cloneGroup+" #clone_sub_group_1").find('.work_hrs').attr("name","work_hrs_subg1_gr"+ cloneGroup);
          $("#clone_group_"+cloneGroup+" #clone_sub_group_1").find('.overtime_hrs').attr("name","overtime_hrs_subg1_gr"+ cloneGroup);
          $("#clone_group_"+cloneGroup+" #clone_sub_group_1").find('.work_day').attr("name","work_day_subg1_gr"+ cloneGroup);
          $("#clone_group_"+cloneGroup+" #clone_sub_group_1").find('.work_holiday').attr("name","work_holiday_subg1_gr"+ cloneGroup);
          $("#clone_group_"+cloneGroup+" #clone_sub_group_1").find('.charge_ot').attr("name","charge_ot_subg1_gr"+ cloneGroup);
          $("#clone_group_"+cloneGroup+" #clone_sub_group_1").find('.remark').attr("name","remark_subg1_gr"+ cloneGroup);
          $("#clone_group_"+cloneGroup+" #clone_sub_group_1").find('.per_person').attr("name","per_person_subg1_gr"+ cloneGroup);
          $("#clone_group_"+cloneGroup+" #clone_sub_group_1").find('.per_group').attr("name","per_group_subg1_gr"+ cloneGroup);

          //cloneGroup++; 
          count_add_group.val(cloneGroup);  

          // // call Calculat_ALL
          // Calculat_ALL();        
    //});

}//end function clon group


function Delete_group(ele){

//===========start : btn delete_group ==============
//$(".delete_group").on('click', function() {	


//console.log(ele.closest(".clone_group").attr("id"));

group_delete_id = ele.closest(".clone_group").attr("id");
//== delete Group ==
//$(this).parents(".clone_group").remove(); 

ele.closest("#"+group_delete_id).remove();

//////////////////// SET :: calculate total all page ////////////////////////
Calculate_total_page(ele);
// var group_id = ele.parents(".clone_group").attr("id");
// var str = group_id;
// group_id = str.substring(12);

// //alert('delete total');
// $(".qt_total").val(0);
// var count_add_group = $("#count_add_group").val();
// //alert(count_add_group);
// var total_all_page = 0;
// var sub_total_gr =0;
// for ( var j = 1; j <= count_add_group; j++) { 
// 	if(j!=group_id){
// 	  sub_total_gr = $("input[name='sub_total_gr"+j+"']").val();
// 		if( sub_total_gr=='' || sub_total_gr==undefined){ sub_total_gr=0; }	
// 		//alert('sub_total :'+sub_total_gr);	

// 		sub_total_gr = parseFloat(sub_total_gr);
// 		total_all_page = parseFloat(total_all_page);
// 		total_all_page = parseFloat(total_all_page+sub_total_gr);	
// 	}//end if delete
// }//end for
// //alert('total_all_page :'+total_all_page);
// //set total_all_page 
// $(".qt_total").val(total_all_page);

		
//});//end: key up

}//end function delete_group


function Calculate_total_page(ele){
//////////////////// SET :: calculate total all page ////////////////////////
var group_id = ele.parents(".clone_group").attr("id");
var str = group_id;
group_id = str.substring(12);

//alert('delete total');
$(".qt_total").val(0);
var count_add_group = $("#count_add_group").val();
count_add_group = parseInt(count_add_group);
// count_add_group = parseInt(count_add_group+1);
// alert("count_add_group"+count_add_group);

var total_all_page = 0;
var sub_total_gr =0;
for ( var j = 1; j <= count_add_group; j++) { 
	//if(j!=group_id){
	  sub_total_gr = $("input[name='sub_total_gr"+j+"']").val();
		if( sub_total_gr=='' || sub_total_gr==undefined){ sub_total_gr='0'; }	
		//alert('sub_total :'+sub_total_gr+":: j:"+j);	
		sub_total_gr = replaceComma(sub_total_gr);
		sub_total_gr = parseFloat(sub_total_gr);

		total_all_page = parseFloat(total_all_page);
		total_all_page = parseFloat(total_all_page+sub_total_gr);
		total_all_page = total_all_page.toFixed(2);	
	//}//end if delete
}//end for
//alert('total_all_page :'+total_all_page);
//set total_all_page 

//add function comma
total_all_page = commaSeparateNumber(total_all_page);
$(".qt_total").val(total_all_page);

}//end fuction


function Clone_sub_group(ele){
//alert('clone sub group');
	var count_sub_group = '';

	//$(".add-sub-group").on('click',function(){  
	
	count_sub_group = ele.parents(".clone_group").find(".count_sub_group").val();
	var work_day = $("#clone_sub_group_1").find(".work_holiday").val();
	//alert(work_day);	
	count_sub_group++;
	//alert('count_sub_group'+count_sub_group);

	var id_clone_group = ele.parents(".clone_group").attr("id");
	var str = id_clone_group;
	var group_id = str.substring(12);

		
	  $("#clone_sub_group_0").clone(true)
	  .removeClass("hide")
	  .appendTo("#"+id_clone_group+" .div-sub-gruop")          
	  .attr("id", "clone_sub_group_" +  count_sub_group) 
	 
	 //alert('clon group :: '+id_clone_group+' || clone_sub_gr :: clone_sub_group_'+count_sub_group+' || subg :'+count_sub_group+'|| group_id :'+group_id);
	 	
	 //chang name sub group
	$("#"+id_clone_group+" #clone_sub_group_"+count_sub_group+"").find(".sub_group_staff").attr("name","sub_group_staff_subg"+count_sub_group+"_gr"+ group_id); 

	$("#"+id_clone_group+" #clone_sub_group_"+count_sub_group+"").find(".gender").attr("name","gender_subg"+count_sub_group+"_gr"+ group_id); 
	//set custom radio day
	$("#"+id_clone_group+" #clone_sub_group_"+count_sub_group+"").find(".day-radio").attr("name","day_radio_subg"+count_sub_group+"_gr"+ group_id+"[]");
	$("#"+id_clone_group+" #clone_sub_group_"+count_sub_group+"").find(".radio1").attr("id","radio1"+count_sub_group+group_id);
	$("#"+id_clone_group+" #clone_sub_group_"+count_sub_group+"").find(".radio2").attr("id","radio2"+count_sub_group+group_id);
	$("#"+id_clone_group+" #clone_sub_group_"+count_sub_group+"").find(".radio3").attr("id","radio3"+count_sub_group+group_id);
	$("#"+id_clone_group+" #clone_sub_group_"+count_sub_group+"").find(".radio4").attr("id","radio4"+count_sub_group+group_id);
	$("#"+id_clone_group+" #clone_sub_group_"+count_sub_group+"").find(".radio5").attr("id","radio5"+count_sub_group+group_id);
	$("#"+id_clone_group+" #clone_sub_group_"+count_sub_group+"").find(".radio6").attr("id","radio6"+count_sub_group+group_id);
	$("#"+id_clone_group+" #clone_sub_group_"+count_sub_group+"").find(".radio7").attr("id","radio7"+count_sub_group+group_id);
	$("#"+id_clone_group+" #clone_sub_group_"+count_sub_group+"").find(".radio8").attr("id","radio8"+count_sub_group+group_id);
	$("#"+id_clone_group+" #clone_sub_group_"+count_sub_group+"").find(".radio_for1").attr("for","radio1"+count_sub_group+group_id);
	$("#"+id_clone_group+" #clone_sub_group_"+count_sub_group+"").find(".radio_for2").attr("for","radio2"+count_sub_group+group_id);
	$("#"+id_clone_group+" #clone_sub_group_"+count_sub_group+"").find(".radio_for3").attr("for","radio3"+count_sub_group+group_id);
	$("#"+id_clone_group+" #clone_sub_group_"+count_sub_group+"").find(".radio_for4").attr("for","radio4"+count_sub_group+group_id);
	$("#"+id_clone_group+" #clone_sub_group_"+count_sub_group+"").find(".radio_for5").attr("for","radio5"+count_sub_group+group_id);
	$("#"+id_clone_group+" #clone_sub_group_"+count_sub_group+"").find(".radio_for6").attr("for","radio6"+count_sub_group+group_id);
	$("#"+id_clone_group+" #clone_sub_group_"+count_sub_group+"").find(".radio_for7").attr("for","radio7"+count_sub_group+group_id);
	$("#"+id_clone_group+" #clone_sub_group_"+count_sub_group+"").find(".radio_for8").attr("for","radio8"+count_sub_group+group_id);


	$("#"+id_clone_group+" #clone_sub_group_"+count_sub_group+"").find(".time_start").attr("name","time_start_subg"+count_sub_group+"_gr"+ group_id); 
	$("#"+id_clone_group+" #clone_sub_group_"+count_sub_group+"").find(".time_end").attr("name","time_end_subg"+count_sub_group+"_gr"+ group_id); 
	//$("#"+id_clone_group+" #clone_sub_group_"+count_sub_group+"").find(".position").attr("name","position_subg"+count_sub_group+"_gr"+ group_id); 
	//$("#"+id_clone_group+" #clone_sub_group_"+count_sub_group+"").find(".uniform").attr("name","uniform_subg"+count_sub_group+"_gr"+ group_id); 
	$("#"+id_clone_group+" #clone_sub_group_"+count_sub_group+"").find(".work_hrs").attr("name","work_hrs_subg"+count_sub_group+"_gr"+ group_id); 
	$("#"+id_clone_group+" #clone_sub_group_"+count_sub_group+"").find(".overtime_hrs").attr("name","overtime_hrs_subg"+count_sub_group+"_gr"+ group_id); 
	$("#"+id_clone_group+" #clone_sub_group_"+count_sub_group+"").find(".work_day").attr("name","work_day_subg"+count_sub_group+"_gr"+ group_id); 

	$("#"+id_clone_group+" #clone_sub_group_"+count_sub_group+"").find(".work_holiday").attr("name","work_holiday_subg"+count_sub_group+"_gr"+ group_id); 
	$("#"+id_clone_group+" #clone_sub_group_"+count_sub_group+"").find(".charge_ot").attr("name","charge_ot_subg"+count_sub_group+"_gr"+ group_id); 
	$("#"+id_clone_group+" #clone_sub_group_"+count_sub_group+"").find(".remark").attr("name","remark_subg"+count_sub_group+"_gr"+ group_id); 
	$("#"+id_clone_group+" #clone_sub_group_"+count_sub_group+"").find(".per_person").attr("name","per_person_subg"+count_sub_group+"_gr"+ group_id); 
	$("#"+id_clone_group+" #clone_sub_group_"+count_sub_group+"").find(".per_group").attr("name","per_group_subg"+count_sub_group+"_gr"+ group_id); 

	$("input[name='work_holiday_subg"+count_sub_group+"_gr"+ group_id+"']").val(work_day); 
	 
	ele.parents(".clone_group").find(".count_sub_group").val(count_sub_group);          

	//});//end add sub group

	//Calculat_ALL();
}//end function clone_subgroup


function Delete_sub_group(ele){
	//console.log("delete sub group");
	var group_delete_id ='';
    var sub_group_delete_id ='';

    	group_delete_id = ele.parents(".clone_group").attr("id");
    	sub_group_delete_id = ele.parents(".clone_sub_group").attr("id");
    	//alert(group_delete_id+' '+sub_group_delete_id);      
      //DELETE : sub group
      ele.parents("#"+group_delete_id+" #"+sub_group_delete_id).remove();



}//end function delete sub group







////////////////////////////  FUNCTION CALLCULATE ////////////////////
function Calculate_holiday(){


$(".radio_pay_rate").on('click', function() {

	$(this).parents(".clone_group").find('.holiday').val('');
	$(this).parents(".clone_group").find('.daily_pay_rate').val('');
	$(this).parents(".clone_group").find('.holiday').attr('readonly', false);

});


$(".daily_pay_rate").on('keyup', function() {


var group_id = $(this).parents(".clone_group").attr("id");
var str = group_id;
group_id = str.substring(12);
//alert('group_id :'+group_id)
var daily_pay_rate_type_gr = $(this).parents("#clone_group_"+group_id).find("input[name='daily_pay_rate_type_gr"+group_id+"']:checked").val();
//alert(daily_pay_rate_type_gr1);

if(daily_pay_rate_type_gr=='day'){
		$(this).parents(".clone_group").find('.holiday').attr('readonly', true);		
		$(this).parents(".clone_group").find('.holiday').val('');
		var work_holiday_temp = $(this).parents(".clone_group").find('.work_holiday').val();
		work_holiday_temp =parseFloat(work_holiday_temp);
		//alert(work_holiday_temp);

		var daily_pay_rate =  $(this).val();
		if(daily_pay_rate=='' || daily_pay_rate==undefined){ daily_pay_rate='0';  }// $(this).parents(".clone_group").find('.daily_pay_rate').val(daily_pay_rate);}
		//recomma
		daily_pay_rate = replaceComma(daily_pay_rate);
		daily_pay_rate = parseFloat(daily_pay_rate);
		//alert(daily_pay_rate);

		  	var holiday = 0;
				holiday =parseFloat(holiday);
				holiday = parseFloat((work_holiday_temp/12)*daily_pay_rate);
				//set : 2 double
				holiday = holiday.toFixed(2);
			
			//== set holliday
			// if(holiday==0){
			// 	holiday='';
			// }

		//add function comma
		holiday = commaSeparateNumber(holiday);
		//alert(holiday);
		$(this).parents(".clone_group").find('.holiday').val(holiday);


}else{
	$(this).parents(".clone_group").find('.holiday').attr('readonly', false);

}//end else


});

}//end Calculate_pergroup




function Calculat_ALL(ele,sub_group_id){
//$(".daily_pay_rate,.overtime,.work_day,.sub_group_staff,.holiday,.work_holiday")
//$(".daily_pay_rate,.overtime,.holiday,.work_day,.work_holiday,.sub_group_staff,.input-other,.bonus,.incentive,.other_value,.rate_position,.special,.total_man").on('keyup', function() {
//console.log('calculate_all');

//set sub_group_id
if(sub_group_id==0){
sub_group_id ==-1;
}//end if

//alert("Calculat_ALL |sub_group_id:"+sub_group_id);

var group_id = ele.parents(".clone_group").attr("id");
var str = group_id;
group_id = str.substring(12);
//alert('group_id :'+group_id)
var daily_pay_rate_type_gr = ele.parents("#clone_group_"+group_id).find("input[name='daily_pay_rate_type_gr"+group_id+"']:checked").val();
//alert(daily_pay_rate_type_gr);

if(daily_pay_rate_type_gr=='day'){

	// == Call :: Calculate_per_person_date ==
	Calculate_per_person_date(ele,sub_group_id);
	//alert('Calculate_per_person_date');

	}else{

		// == Call :: Calculate_per_person_month ==
		Calculate_per_person_month(ele,sub_group_id);

	}//end else

//});//end key up


}//end Calculat_ALL





function Re_calculate_per_person_date(ele){

//$(".work_holiday").on('keyup', function(){
	var job_type = $('#job_type').val();
//group_id
	var group_id = ele.parents(".clone_group").attr("id");
 	var str = group_id;
    group_id = str.substring(12);
	//alert('group_id :'+group_id);

	var daily_pay_rate = ele.parents(".clone_group").find('.daily_pay_rate').val();
	var overtime = ele.parents(".clone_group").find('.overtime').val();	
	var holiday = ele.parents(".clone_group").find('.holiday').val();	

	if(daily_pay_rate=='' || daily_pay_rate==undefined){ daily_pay_rate='0'; }// ele.parents(".clone_group").find('.daily_pay_rate').val(daily_pay_rate);}
	if(overtime=='' || overtime==undefined){ overtime='0';  }//ele.parents(".clone_group").find('.overtime').val(overtime);}
	if(holiday=='' || overtime==undefined){ holiday='0';  }
	
	var count_sub_group = ele.parents(".clone_group").find('.count_sub_group').val();
		//alert('count_sub_group :'+count_sub_group);	

		daily_pay_rate = replaceComma(daily_pay_rate);	
		overtime = replaceComma(overtime);		
		holiday = replaceComma(holiday);

		for (var i = 1; i <= count_sub_group; i++) {

			var work_day = ele.parents(".clone_group").find("input[name='work_day_subg"+i+"_gr"+group_id+"']").val();		
			var overtime_hrs = ele.parents(".clone_group").find("input[name='overtime_hrs_subg"+i+"_gr"+group_id+"']").val();
			var work_holiday = ele.parents(".clone_group").find("input[name='work_holiday_subg"+i+"_gr"+group_id+"']").val();

			if(work_day=='' || work_day==undefined){ work_day=0; }// ele.parents(".clone_group").find("input[name='work_day_subg"+i+"_gr"+group_id+"']").val(work_day);}
			//if(overtime_hrs=='' || overtime_hrs==undefined){ overtime_hrs=0; }// ele.parents(".clone_group").find("input[name='overtime_hrs_subg"+i+"_gr"+group_id+"']").val(overtime_hrs);}
			if(work_holiday=='' || work_holiday==undefined){ work_holiday=0; }

			daily_pay_rate = parseFloat(daily_pay_rate);
			overtime = parseFloat(overtime);
			holiday = parseFloat(holiday);

			work_day = parseFloat(work_day);
			//overtime_hrs = parseFloat(overtime_hrs);
			work_holiday = parseFloat(work_holiday);

			// alert('daily_pay_rate :'+daily_pay_rate);
			// alert('overtime :'+overtime);
			// alert('work_day :'+work_day);
			// alert('overtime_hrs :'+overtime_hrs);

			var per_person = 0;
				per_person = parseFloat(per_person);
				per_person = parseFloat((work_day*daily_pay_rate)+(work_day*overtime)+((work_holiday/12)*daily_pay_rate));
				//per_person = parseFloat((work_day*daily_pay_rate)+(work_day*overtime)+((work_holiday/12)*holiday));
				//set : 2 double
				per_person = per_person.toFixed(2);
				//alert('per_person : '+per_person);				
				//!!set per_person 
				//add function comma
				per_person = commaSeparateNumber(per_person);
				ele.parents(".clone_group").find("input[name='per_person_subg"+i+"_gr"+group_id+"']").val(per_person);

				//== call per group ====
				Calculat_Per_group_ALL(ele,per_person,i,group_id);

					//== call wage ==
					Calculate_wage(ele,0);
					
					//== Calculate_benefit() ==
					Calculate_benefit(ele,0);

					//== cal wage_benefit
					Calculate_wage_benefit(ele);

					//== total_group() ==
					 total_group(ele,0);

		}//end for
//});

}//end function


function Calculate_per_person_date(ele,sub_group_id){


//======= start : click onkey_up person daily_pay_rate,.overtime ====
//$(".daily_pay_rate,.overtime,.holiday,.work_day,.work_holiday,.sub_group_staff").on('keyup', function() {

//group_id
	var group_id = ele.parents(".clone_group").attr("id");
 	var str = group_id;
    group_id = str.substring(12);
	//alert('group_id :'+group_id);

	var daily_pay_rate = ele.parents(".clone_group").find('.daily_pay_rate').val();
	var overtime = ele.parents(".clone_group").find('.overtime').val();	
	var holiday = ele.parents(".clone_group").find('.holiday').val();	

	if(daily_pay_rate=='' || daily_pay_rate==undefined){ daily_pay_rate='0'; }// ele.parents(".clone_group").find('.daily_pay_rate').val(daily_pay_rate);}
	if(overtime=='' || overtime==undefined){ overtime='0';  }//ele.parents(".clone_group").find('.overtime').val(overtime);}
	if(holiday=='' || overtime==undefined){ holiday='0';  }
	
	var count_sub_group = ele.parents(".clone_group").find('.count_sub_group').val();
		//alert('count_sub_group :'+count_sub_group);
		//alert('date sub gr id :'+sub_group_id);	

		daily_pay_rate = replaceComma(daily_pay_rate);	
		overtime = replaceComma(overtime);		
		holiday = replaceComma(holiday);

		for (var i = 1; i <= count_sub_group; i++) {
			if(sub_group_id!=i){
				
			var work_day = ele.parents(".clone_group").find("input[name='work_day_subg"+i+"_gr"+group_id+"']").val();		
			var overtime_hrs = ele.parents(".clone_group").find("input[name='overtime_hrs_subg"+i+"_gr"+group_id+"']").val();
			var work_holiday = ele.parents(".clone_group").find("input[name='work_holiday_subg"+i+"_gr"+group_id+"']").val();


			if(work_day=='' || work_day==undefined){ work_day=0; }// ele.parents(".clone_group").find("input[name='work_day_subg"+i+"_gr"+group_id+"']").val(work_day);}
			//if(overtime_hrs=='' || overtime_hrs==undefined){ overtime_hrs=0; }// ele.parents(".clone_group").find("input[name='overtime_hrs_subg"+i+"_gr"+group_id+"']").val(overtime_hrs);}
			if(work_holiday=='' || work_holiday==undefined){ work_holiday=0; }

			//alert("check sub_group_id :"+daily_pay_rate);			
			daily_pay_rate = parseFloat(daily_pay_rate);			
			overtime = parseFloat(overtime);
			holiday = parseFloat(holiday);

			work_day = parseFloat(work_day);
			//overtime_hrs = parseFloat(overtime_hrs);
			work_holiday = parseFloat(work_holiday);

			// alert('daily_pay_rate :'+daily_pay_rate);
			// alert('overtime :'+overtime);
			// alert('work_day :'+work_day);
			// alert('overtime_hrs :'+overtime_hrs);

			var per_person = 0;
				per_person = parseFloat(per_person);
				//per_person = parseFloat((work_day*daily_pay_rate)+(work_day*overtime)+((work_holiday/12)*holiday));
				per_person = parseFloat((work_day*daily_pay_rate)+(work_day*overtime)+((work_holiday/12)*daily_pay_rate));
				//set : 2 double
				per_person = per_person.toFixed(2);
				//alert('per_person : '+per_person);
				//set per_person 
				//add function comma
				per_person = commaSeparateNumber(per_person);
				
				ele.parents(".clone_group").find("input[name='per_person_subg"+i+"_gr"+group_id+"']").val(per_person);

				//alert('per_person : '+per_person);

				//== call per group ====
				Calculat_Per_group_ALL(ele,per_person,i,group_id);

					//== call wage ==
					Calculate_wage(ele,sub_group_id);
					
					//== Calculate_benefit() ==
					Calculate_benefit(ele,sub_group_id);

					//== cal wage_benefit
					Calculate_wage_benefit(ele);

					//== total_group() ==
 					total_group(ele,sub_group_id);	
 		}//end if sub_group_id		
		}//end for


//});//======= end : click onkey_up person daily_pay_rate,.overtime ====
}//end function



function Calculate_per_person_month(ele,sub_group_id){

//======= start : click onkey_up person daily_pay_rate,.overtime ====
//$(".daily_pay_rate,.overtime").on('keyup', function(){
var job_type = $('#job_type').val();
//group_id
	var group_id = ele.parents(".clone_group").attr("id");
 	var str = group_id;
    group_id = str.substring(12);
	//alert('group_id :'+group_id);

	var daily_pay_rate = ele.parents(".clone_group").find('.daily_pay_rate').val();
	var overtime = ele.parents(".clone_group").find('.overtime').val();	
	

	if(daily_pay_rate=='' || daily_pay_rate==undefined){ daily_pay_rate='0'; }// ele.parents(".clone_group").find('.daily_pay_rate').val(daily_pay_rate);}
	if(overtime=='' || overtime==undefined){ overtime='0';  }//ele.parents(".clone_group").find('.overtime').val(overtime);}

	
	var count_sub_group = ele.parents(".clone_group").find('.count_sub_group').val();
		//alert('count_sub_group :'+count_sub_group);	
		//alert('date sub gr id :'+sub_group_id);	
		daily_pay_rate = replaceComma(daily_pay_rate);	
		overtime = replaceComma(overtime);	

		for (var i = 1; i <= count_sub_group; i++) {
			if(sub_group_id!=i){
			var work_day = ele.parents(".clone_group").find("input[name='work_day_subg"+i+"_gr"+group_id+"']").val();		
			var overtime_hrs = ele.parents(".clone_group").find("input[name='overtime_hrs_subg"+i+"_gr"+group_id+"']").val();
		

			if(work_day=='' || work_day==undefined){ work_day=0; }// ele.parents(".clone_group").find("input[name='work_day_subg"+i+"_gr"+group_id+"']").val(work_day);}
			//if(overtime_hrs=='' || overtime_hrs==undefined){ overtime_hrs=0; }// ele.parents(".clone_group").find("input[name='overtime_hrs_subg"+i+"_gr"+group_id+"']").val(overtime_hrs);}

			daily_pay_rate = parseFloat(daily_pay_rate);
			overtime = parseFloat(overtime);			

			work_day = parseFloat(work_day);

			var per_person = 0;
				per_person = parseFloat(per_person);
				if(job_type=='ZQT1'){
					per_person = parseFloat(daily_pay_rate+(work_day*overtime));
				}else{
					per_person = parseFloat(((daily_pay_rate/30)*work_day)+(work_day*overtime));
				}
				//set : 2 double
				per_person = per_person.toFixed(2);
				//alert('per_person : '+per_person);
				//set per_person 
				//add function comma
				per_person = commaSeparateNumber(per_person);
				ele.parents(".clone_group").find("input[name='per_person_subg"+i+"_gr"+group_id+"']").val(per_person);

				//== call per group ====
				Calculat_Per_group_ALL(ele,per_person,i,group_id);

					//== call wage ==
					Calculate_wage(ele,sub_group_id);
					
					//== Calculate_benefit() ==
					Calculate_benefit(ele,sub_group_id);

					//== cal wage_benefit
					Calculate_wage_benefit(ele);

					//== total_group() ==
 					total_group(ele,sub_group_id);	
 		}//end if sub_group_id	
		}//end for


//});//======= end : click onkey_up person daily_pay_rate,.overtime ====

}//end Calculate_pergroup




function Calculat_Per_group_ALL(ele,per_person,i,group_id){
//alert('all');
//////////////   calculate per_group All ///////////////
per_person = replaceComma(per_person);
per_person = parseFloat(per_person);

var sub_group_staff = ele.parents(".clone_group").find("input[name='sub_group_staff_subg"+i+"_gr"+group_id+"']").val();
if(sub_group_staff=='' || sub_group_staff==undefined){ sub_group_staff=0; }//  ele.parents(".clone_group").find("input[name='sub_group_staff_subg"+i+"_gr"+group_id+"']").val(sub_group_staff);}

sub_group_staff = parseFloat(sub_group_staff);
var per_group = 0;
	per_group = parseFloat(per_group);
	per_group = parseFloat(per_person*sub_group_staff);
	//set : 2 double
	per_group = per_group.toFixed(2);
	//alert('per_group : '+per_group);

//set per_group 
//add function comma
per_group = commaSeparateNumber(per_group);
ele.parents(".clone_group").find("input[name='per_group_subg"+i+"_gr"+group_id+"']").val(per_group);
//alert(per_group);


}//end function


function Calculat_Per_group(ele,per_person){
per_person = replaceComma(per_person);
per_person = parseFloat(per_person);

//////////////   calculate per_group ///////////////
//alert('nomal');
var sub_group_staff = ele.parents(".clone_sub_group").find('.sub_group_staff').val();
if(sub_group_staff=='' || sub_group_staff==undefined){ sub_group_staff=0; }// ele.parents(".clone_sub_group").find('.sub_group_staff').val(sub_group_staff);}
	
sub_group_staff = parseFloat(sub_group_staff);
var per_group = 0;
	per_group = parseFloat(per_group);
	per_group = parseFloat(per_person*sub_group_staff);
	//set : 2 double
	per_group = per_group.toFixed(2);
	//alert('per_group : '+per_group);

//set per_person 
//add function comma
per_group = commaSeparateNumber(per_group);
ele.parents(".clone_sub_group").find('.per_group').val(per_group);
//alert(per_group);

}//end function






function Calculate_wage_benefit(ele){
//======= start : click btn wage_benefit ====
//$(".daily_pay_rate,.overtime,.work_day,.sub_group_staff").on('keyup', function() {
//group_id
	var group_id = ele.parents(".clone_group").attr("id");
 	var str = group_id;
    group_id = str.substring(12);
	//alert('group_id :'+group_id);

	var waege = ele.parents(".clone_group").find('.waege').val();	

	var benefit = ele.parents(".clone_group").find('.benefit').val();
		
	if(waege=='' || waege==undefined){ waege='0';  }//ele.parents(".clone_group").find('.waege').val(waege);}
	if(benefit=='' || benefit==undefined){ benefit='0'; }// ele.parents(".clone_group").find('.benefit').val(benefit);}

	waege = replaceComma(waege);
	waege = parseFloat(waege);
	benefit = replaceComma(benefit);
	benefit = parseFloat(benefit);
	//alert('waege :'+waege);	
	//alert('benefit :'+benefit);		
	var wage_benefit = 0;
		wage_benefit= parseFloat(wage_benefit);	
		wage_benefit = parseFloat(waege+benefit);
		//set : 2 double
		wage_benefit = wage_benefit.toFixed(2);

		//alert('wage_benefit :'+wage_benefit);

	//set wage_benefit 
		//add function comma
		wage_benefit = commaSeparateNumber(wage_benefit);
		ele.parents(".clone_group").find('.wage_benefit').val(wage_benefit);
		//$(this).parents(".clone_group").find('.btn-wage-benefit').attr('disabled', true);

//});//======= start : click btn wage_benefit ====


}//end fuction



function Calculate_wage(ele,sub_group_id){


// //======= start : click btn waege ====
// $(".daily_pay_rate,.overtime,.work_day,.sub_group_staff,.holiday,.work_holiday").on('keyup', function() {
ele.parents(".clone_group").find('.waege').val('');
//group_id
	var group_id = ele.parents(".clone_group").attr("id");
 	var str = group_id;
    group_id = str.substring(12);
	//alert('group_id :'+group_id);

	var count_sub_group = ele.parents(".clone_group").find('.count_sub_group').val();
		//alert('count_sub_group :'+count_sub_group);
	if(count_sub_group=='' || count_sub_group==undefined){ count_sub_group=0; }	


	var total_per_group = 0;
	var per_group =0;	
	var sub_group_staff =0;
	var total_sub_group_staff =0;	
	var total_per_group =0;		


	for (i = 1; i <= count_sub_group; i++) {     
	if(sub_group_id!=i){
		per_group = ele.parents(".clone_group").find("input[name='per_group_subg"+i+"_gr"+group_id+"']").val();//per_group_subg1_gr1
		if( per_group=='' || per_group == undefined ){ per_group='0'; }		
		//alert('per_group : '+per_group);

		
		sub_group_staff = ele.parents(".clone_group").find("input[name='sub_group_staff_subg"+i+"_gr"+group_id+"']").val();//per_group_subg1_gr1
		if( sub_group_staff=='' || sub_group_staff == undefined ){ sub_group_staff=0; }		
		//alert('sub_group_staff : '+sub_group_staff);
		sub_group_staff = parseFloat(sub_group_staff);
		total_sub_group_staff = parseFloat(total_sub_group_staff);
		total_sub_group_staff = parseFloat(total_sub_group_staff) + parseFloat(sub_group_staff);

		per_group = replaceComma(per_group);
		per_group = parseFloat(per_group);		
		total_per_group = parseFloat(total_per_group);
		total_per_group = parseFloat(total_per_group) + parseFloat(per_group);
	}//end if sub_group_id
	}//end for
	

	//check per total_per_group
	if(total_per_group=='' || total_per_group==undefined){ total_per_group=0; }	
	//alert('total_per_group :'+total_per_group);

	if(total_sub_group_staff=='' || total_sub_group_staff==undefined){ total_sub_group_staff=0; }	
	
//count_sub_group = parseFloat(count_sub_group);
  //alert('total_sub_group_staff :'+total_sub_group_staff);
 // alert('total_per_group :'+total_per_group);

		var waege = 0;
		//waege= parseFloat(waege);
		if(total_per_group ==0 && total_sub_group_staff==0){
			waege = 0;	
		}else{
			waege = parseFloat(total_per_group)/parseFloat(total_sub_group_staff);		
		}//end else		
		
		//set : 2 double
		waege = waege.toFixed(2);
		//alert('waege :'+waege);

	//set waege 
		//add function comma
		waege = commaSeparateNumber(waege);
		ele.parents(".clone_group").find('.waege').val(waege);
// });//======= start : click btn waege ====



}//end function





function Calculate_benefit(ele,sub_group_id){

var job_type = $('#job_type').val();
//alert(job_type);
	if(job_type=='ZQT1'){
		Calculate_benefit_ZQT1(ele,sub_group_id);
	}else{
		Calculate_benefit_ZQT2(ele,sub_group_id);
}//end else

}//end cal benefit Z001


function Calculate_benefit_ZQT1(ele,sub_group_id){
//$(".incentive,.transport_exp,.bonus,.input-other,.other_value,.work_day,.sub_group_staff,.total_man,.rate_position").on('keyup', function() {
var group_id = ele.parents(".clone_group").attr("id");
 	var str = group_id;
    group_id = str.substring(12);
	//alert('group_id :'+group_id);

	var count_other = ele.parents(".clone_group").find('.count_other_group').val();
	//alert('count_other :'+count_other);	
	var	other1 =  0;
	var	other2 =  0;
	var	other3 =  0;
	var	other4 =  0;
	var	other5 =  0;
	var	other6 =  0;
	var	other7 =  0;
	var	other8 =  0;
	var	other9 =  0;
	var	other10 = 0;

	var	other1_type =  '';
	var	other2_type =  '';
	var	other3_type =  '';
	var	other4_type =  '';
	var	other5_type =  '';
	var	other6_type =  '';
	var	other7_type =  '';
	var	other8_type =  '';
	var	other9_type =  '';
	var	other10_type = '';

	for (i = 0; i <= count_other; i++) {     
    	if(i==1){
			other1 = ele.parents(".clone_group").find("input[name='other_1_group_"+group_id+"']").val();
			other1_type = $("input[name='other_typeID_1_group_"+group_id+"']").data('type');		
		
		}else if(i==2){
			other2 = ele.parents(".clone_group").find("input[name='other_2_group_"+group_id+"']").val();
			other2_type = $("input[name='other_typeID_2_group_"+group_id+"']").data('type');	
			//alert('other2 :'+other2);
		
		}else if(i==3){
			other3 = ele.parents(".clone_group").find("input[name='other_3_group_"+group_id+"']").val();
			other3_type = $("input[name='other_typeID_3_group_"+group_id+"']").data('type');	
			//alert('other3 :'+other3);
		
		}else if(i==4){
			other4 = ele.parents(".clone_group").find("input[name='other_4_group_"+group_id+"']").val();
			other4_type = $("input[name='other_typeID_4_group_"+group_id+"']").data('type');	
			//alert('other4 :'+other4);
		
		}else if(i==5){
			other5 = ele.parents(".clone_group").find("input[name='other_5_group_"+group_id+"']").val();
			other5_type = $("input[name='other_typeID_5_group_"+group_id+"']").data('type');	
			//alert('other5 :'+other5);
		
		}else if(i==6){
			other6 = ele.parents(".clone_group").find("input[name='other_6_group_"+group_id+"']").val();
			other6_type = $("input[name='other_typeID_6_group_"+group_id+"']").data('type');	
			//alert('other6 :'+other5);
		
		}else if(i==7){
			other7 = ele.parents(".clone_group").find("input[name='other_7_group_"+group_id+"']").val();
			other7_type = $("input[name='other_typeID_7_group_"+group_id+"']").data('type');	
			//alert('other7 :'+other7);
		
		}else if(i==8){
			other8 = ele.parents(".clone_group").find("input[name='other_8_group_"+group_id+"']").val();
			other8_type = $("input[name='other_typeID_8_group_"+group_id+"']").data('type');	
			//alert('other8 :'+other8);
		
		}else if(i==9){
			other9 = ele.parents(".clone_group").find("input[name='other_9_group_"+group_id+"']").val();
			other9_type = $("input[name='other_typeID_9_group_"+group_id+"']").data('type');	
			//alert('other9 :'+other9);
		
		}else if(i==10){
			other10 = ele.parents(".clone_group").find("input[name='other_10_group_"+group_id+"']").val();
			other10_type = $("input[name='other_typeID_10_group_"+group_id+"']").data('type');	
			//alert('other10 :'+other10);
		}
	}//end for 	

	// == call monthe ===	
	var incentive = ele.parents(".clone_group").find('.incentive').val();		
	//alert('incentive:'+incentive);	
	var bonus = ele.parents(".clone_group").find('.bonus').val();		
	//alert('bonus:'+bonus);
	var rate_position = ele.parents(".clone_group").find('.rate_position').val();		
	//alert('rate_position:'+rate_position);

	// == call date ===
	var transport_exp = ele.parents(".clone_group").find('.transport_exp').val();		
	//alert('transport_exp:'+transport_exp);
	var special = ele.parents(".clone_group").find('.special').val();
	//alert('special:'+special);
	var other_value = ele.parents(".clone_group").find('.other_value').val();		
	//alert('other_value:'+other_value);


	var total_man = ele.parents(".clone_group").find('.total_man').val();
	//alert('total_man:'+total_man);


	if(incentive=='' || incentive==undefined){ incentive='0'; }// ele.parents(".clone_group").find('.incentive').val(incentive);}
	if(bonus=='' || bonus==undefined){ bonus='0';  }// ele.parents(".clone_group").find('.bonus').val(bonus);}
	if(rate_position=='' || rate_position==undefined){ rate_position='0';  }// ele.parents(".clone_group").find('.bonus').val(bonus);}

	if(transport_exp=='' || transport_exp==undefined){ transport_exp='0'; }// ele.parents(".clone_group").find('.transport_exp').val(transport_exp);}
	if(special=='' || special==undefined){ special='0'; }// ele.parents(".clone_group").find('.transport_exp').val(transport_exp);}
	if(other_value=='' || other_value==undefined){ other_value='0'; }//  ele.parents(".clone_group").find('.other_value').val(other_value);}
	
	
	if(other1=='' || other1==undefined){ other1='0'; }//ele.parents(".clone_group").find("input[name='other_1_group_"+group_id+"']").val(other1);}
	if(other2=='' || other2==undefined){ other2='0'; }//ele.parents(".clone_group").find("input[name='other_2_group_"+group_id+"']").val(other2);}
	if(other3=='' || other3==undefined){ other3='0'; }//ele.parents(".clone_group").find("input[name='other_3_group_"+group_id+"']").val(other3);}
	if(other4=='' || other4==undefined){ other4='0'; }//ele.parents(".clone_group").find("input[name='other_4_group_"+group_id+"']").val(other4);}
	if(other5=='' || other5==undefined){ other5='0'; }//ele.parents(".clone_group").find("input[name='other_5_group_"+group_id+"']").val(other5);}
	if(other6=='' || other6==undefined){ other6='0'; }//ele.parents(".clone_group").find("input[name='other_6_group_"+group_id+"']").val(other6);}
	if(other7=='' || other7==undefined){ other7='0'; }//ele.parents(".clone_group").find("input[name='other_7_group_"+group_id+"']").val(other7);}
	if(other8=='' || other8==undefined){ other8='0'; }//ele.parents(".clone_group").find("input[name='other_8_group_"+group_id+"']").val(other8);}
	if(other9=='' || other9==undefined){ other9='0'; }//ele.parents(".clone_group").find("input[name='other_9_group_"+group_id+"']").val(other9);}
	if(other10=='' || other10==undefined){ other10='0';  }//ele.parents(".clone_group").find("input[name='other_10_group_"+group_id+"']").val(other10);}

	
	incentive = replaceComma(incentive);
	incentive = parseFloat(incentive);
	bonus = replaceComma(bonus);
	bonus = parseFloat(bonus);
	rate_position = replaceComma(rate_position);
	rate_position = parseFloat(rate_position);

	transport_exp = replaceComma(transport_exp);
	transport_exp = parseFloat(transport_exp);
	special = replaceComma(special);
	special = parseFloat(special);
	other_value = replaceComma(other_value);
	other_value = parseFloat(other_value);


	other1 = replaceComma(other1);
	other2 = replaceComma(other2);
	other3 = replaceComma(other3);
	other4 = replaceComma(other4);
	other5 = replaceComma(other5);
	other6 = replaceComma(other6);
	other7 = replaceComma(other7);
	other8 = replaceComma(other8);
	other9 = replaceComma(other9);
	other10 = replaceComma(other10);
	other1 = parseFloat(other1);
	other2 = parseFloat(other2);
	other3 = parseFloat(other3);
	other4 = parseFloat(other4);
	other5 = parseFloat(other5);
	other6 = parseFloat(other6);
	other7 = parseFloat(other7);
	other8 = parseFloat(other8);
	other9 = parseFloat(other9);
	other10 = parseFloat(other10);

//+(other_value*total_man)
//=========== benefit =========
var benefit = 0;
	benefit = parseFloat(benefit);
	benefit =parseFloat((bonus*total_man)+(incentive*total_man)+(rate_position*total_man));
	//alert('incentive :'+benefit);
	
//=========================================================================================	
//==================================  freach sub group all ================================
//=========================================================================================

var count_sub_group = ele.parents(".clone_group").find('.count_sub_group').val();
//alert('count_sub_group :'+count_sub_group);
if(count_sub_group=='' || count_sub_group==undefined){ count_sub_group=0; }	

var work_day =0;	
var sub_group_staff =0;
var total_sub_group_staff =0;	
var temp_unifrom =0;
for (i = 1; i <= count_sub_group; i++) {     
if(sub_group_id!=i){
work_day = ele.parents(".clone_group").find("input[name='work_day_subg"+i+"_gr"+group_id+"']").val();//per_group_subg1_gr1
if( work_day=='' || work_day == undefined ){ work_day=0; }		
//alert('work_day : '+work_day);

sub_group_staff = ele.parents(".clone_group").find("input[name='sub_group_staff_subg"+i+"_gr"+group_id+"']").val();//per_group_subg1_gr1
if( sub_group_staff=='' || sub_group_staff == undefined ){ sub_group_staff=0; }		
//alert('sub_group_staff : '+sub_group_staff);

/// == CAL total staff sub group ====
sub_group_staff = parseFloat(sub_group_staff);
total_sub_group_staff = parseFloat(total_sub_group_staff);
total_sub_group_staff = parseFloat(total_sub_group_staff) + parseFloat(sub_group_staff);


//== CALCULATE OTHER ALL ====
if(other1!=0){	
	if(other1_type=='m'){  temp_unifrom = other1; }else{ benefit = parseFloat(benefit+(other1*work_day*sub_group_staff)); }			
}
if(other2!=0){	
	if(other2_type=='m'){ temp_unifrom = other2; }else{  benefit = parseFloat(benefit+(other2*work_day*sub_group_staff));  }	
}
if(other3!=0){	
	if(other3_type=='m'){ temp_unifrom = other3; }else{  benefit = parseFloat(benefit+(other3*work_day*sub_group_staff));  }	
}
if(other4!=0){	
	if(other4_type=='m'){ temp_unifrom = other4; }else{  benefit = parseFloat(benefit+(other4*work_day*sub_group_staff));  }	
}
if(other5!=0){	
	if(other5_type=='m'){ temp_unifrom = other5; }else{  benefit = parseFloat(benefit+(other5*work_day*sub_group_staff));  }	
}
if(other6!=0){	
	if(other6_type=='m'){ temp_unifrom = other6; }else{  benefit = parseFloat(benefit+(other6*work_day*sub_group_staff));  }	
}
if(other7!=0){	
	if(other7_type=='m'){ temp_unifrom = other7; }else{  benefit = parseFloat(benefit+(other7*work_day*sub_group_staff));  }	
}
if(other8!=0){	
	if(other8_type=='m'){ temp_unifrom = other8; }else{  benefit = parseFloat(benefit+(other8*work_day*sub_group_staff));  }	
}
if(other9!=0){	
	if(other9_type=='m'){ temp_unifrom = other9; }else{  benefit = parseFloat(benefit+(other9*work_day*sub_group_staff));  }	
}

if(other10!=0){	
	if(other10_type=='m'){ temp_unifrom = other10; }else{  benefit = parseFloat(benefit+(other10*work_day*sub_group_staff));  }	
}

if(other_value!=0){	
	 benefit = parseFloat(benefit+(other_value*work_day*sub_group_staff)); 
}
if(transport_exp!=0){	
	 benefit = parseFloat(benefit+(transport_exp*work_day*sub_group_staff)); 
}
if(special!=0){	
	 benefit = parseFloat(benefit+(special*work_day*sub_group_staff)); 
}
}//end sub_group_id
}//end for
//================================================================================================================

//== call uniform : month ==
 benefit = parseFloat(benefit+(temp_unifrom*total_man));

//==== call total_sub_group_staff / benefit =====
if(total_sub_group_staff=='' || total_sub_group_staff==undefined){ total_sub_group_staff=0; }
//alert('total_sub_group_staff :'+total_sub_group_staff);
if(total_sub_group_staff!=0){
	//== set benefit man
 	ele.parents(".clone_group").find('.benefit_man').val(benefit);
	benefit = parseFloat(benefit/total_sub_group_staff); 
}//end if

//set : 2 double
benefit = benefit.toFixed(2);
//alert('benefit : '+benefit);

//== set benefit
//add function comma
 benefit = commaSeparateNumber(benefit);
 ele.parents(".clone_group").find('.benefit').val(benefit);

//});//end on key up



}//end cal benefit Z001






function Calculate_benefit_ZQT2(ele,sub_group_id){


//$(".incentive,.transport_exp,.bonus,.input-other,.other_value,.work_day,.sub_group_staff,.total_man,.rate_position").on('keyup', function() {

var group_id = ele.parents(".clone_group").attr("id");
 	var str = group_id;
    group_id = str.substring(12);
	//alert('group_id :'+group_id);

	var count_other = ele.parents(".clone_group").find('.count_other_group').val();
	//alert('count_other :'+count_other);	
	var	other1 =  0;
	var	other2 =  0;
	var	other3 =  0;
	var	other4 =  0;
	var	other5 =  0;
	var	other6 =  0;
	var	other7 =  0;
	var	other8 =  0;
	var	other9 =  0;
	var	other10 = 0;

	var	other1_type =  '';
	var	other2_type =  '';
	var	other3_type =  '';
	var	other4_type =  '';
	var	other5_type =  '';
	var	other6_type =  '';
	var	other7_type =  '';
	var	other8_type =  '';
	var	other9_type =  '';
	var	other10_type = '';

	for (i = 0; i <= count_other; i++) {     
    	if(i==1){
			other1 = ele.parents(".clone_group").find("input[name='other_1_group_"+group_id+"']").val();
			other1_type = $("input[name='other_typeID_1_group_"+group_id+"']").data('type');		
		
		}else if(i==2){
			other2 = ele.parents(".clone_group").find("input[name='other_2_group_"+group_id+"']").val();
			other2_type = $("input[name='other_typeID_2_group_"+group_id+"']").data('type');	
			//alert('other2 :'+other2);
		
		}else if(i==3){
			other3 = ele.parents(".clone_group").find("input[name='other_3_group_"+group_id+"']").val();
			other3_type = $("input[name='other_typeID_3_group_"+group_id+"']").data('type');	
			//alert('other3 :'+other3);
		
		}else if(i==4){
			other4 = ele.parents(".clone_group").find("input[name='other_4_group_"+group_id+"']").val();
			other4_type = $("input[name='other_typeID_4_group_"+group_id+"']").data('type');	
			//alert('other4 :'+other4);
		
		}else if(i==5){
			other5 = ele.parents(".clone_group").find("input[name='other_5_group_"+group_id+"']").val();
			other5_type = $("input[name='other_typeID_5_group_"+group_id+"']").data('type');	
			//alert('other5 :'+other5);
		
		}else if(i==6){
			other6 = ele.parents(".clone_group").find("input[name='other_6_group_"+group_id+"']").val();
			other6_type = $("input[name='other_typeID_6_group_"+group_id+"']").data('type');	
			//alert('other6 :'+other5);
		
		}else if(i==7){
			other7 = ele.parents(".clone_group").find("input[name='other_7_group_"+group_id+"']").val();
			other7_type = $("input[name='other_typeID_7_group_"+group_id+"']").data('type');	
			//alert('other7 :'+other7);
		
		}else if(i==8){
			other8 = ele.parents(".clone_group").find("input[name='other_8_group_"+group_id+"']").val();
			other8_type = $("input[name='other_typeID_8_group_"+group_id+"']").data('type');	
			//alert('other8 :'+other8);
		
		}else if(i==9){
			other9 = ele.parents(".clone_group").find("input[name='other_9_group_"+group_id+"']").val();
			other9_type = $("input[name='other_typeID_9_group_"+group_id+"']").data('type');	
			//alert('other9 :'+other9);
		
		}else if(i==10){
			other10 = ele.parents(".clone_group").find("input[name='other_10_group_"+group_id+"']").val();
			other10_type = $("input[name='other_typeID_10_group_"+group_id+"']").data('type');	
			//alert('other10 :'+other10);
		}
	}//end for 	

	// == call monthe ===	
	var incentive = ele.parents(".clone_group").find('.incentive').val();		
	//alert('incentive:'+incentive);	
	var bonus = ele.parents(".clone_group").find('.bonus').val();		
	//alert('bonus:'+bonus);
	var rate_position = ele.parents(".clone_group").find('.rate_position').val();		
	//alert('rate_position:'+rate_position);

	// == call date ===
	var transport_exp = ele.parents(".clone_group").find('.transport_exp').val();		
	//alert('transport_exp:'+transport_exp);
	var special = ele.parents(".clone_group").find('.special').val();
	//alert('special:'+special);
	var other_value = ele.parents(".clone_group").find('.other_value').val();		
	//alert('other_value:'+other_value);


	var total_man = ele.parents(".clone_group").find('.total_man').val();
	//alert('total_man:'+total_man);


	if(incentive=='' || incentive==undefined){ incentive='0'; }// ele.parents(".clone_group").find('.incentive').val(incentive);}
	if(bonus=='' || bonus==undefined){ bonus='0';  }// ele.parents(".clone_group").find('.bonus').val(bonus);}
	if(rate_position=='' || rate_position==undefined){ rate_position='0';  }// ele.parents(".clone_group").find('.bonus').val(bonus);}

	if(transport_exp=='' || transport_exp==undefined){ transport_exp='0'; }// ele.parents(".clone_group").find('.transport_exp').val(transport_exp);}
	if(special=='' || special==undefined){ special='0'; }// ele.parents(".clone_group").find('.transport_exp').val(transport_exp);}
	if(other_value=='' || other_value==undefined){ other_value='0'; }//  ele.parents(".clone_group").find('.other_value').val(other_value);}
	
	
	if(other1=='' || other1==undefined){ other1='0'; }//ele.parents(".clone_group").find("input[name='other_1_group_"+group_id+"']").val(other1);}
	if(other2=='' || other2==undefined){ other2='0'; }//ele.parents(".clone_group").find("input[name='other_2_group_"+group_id+"']").val(other2);}
	if(other3=='' || other3==undefined){ other3='0'; }//ele.parents(".clone_group").find("input[name='other_3_group_"+group_id+"']").val(other3);}
	if(other4=='' || other4==undefined){ other4='0'; }//ele.parents(".clone_group").find("input[name='other_4_group_"+group_id+"']").val(other4);}
	if(other5=='' || other5==undefined){ other5='0'; }//ele.parents(".clone_group").find("input[name='other_5_group_"+group_id+"']").val(other5);}
	if(other6=='' || other6==undefined){ other6='0'; }//ele.parents(".clone_group").find("input[name='other_6_group_"+group_id+"']").val(other6);}
	if(other7=='' || other7==undefined){ other7='0'; }//ele.parents(".clone_group").find("input[name='other_7_group_"+group_id+"']").val(other7);}
	if(other8=='' || other8==undefined){ other8='0'; }//ele.parents(".clone_group").find("input[name='other_8_group_"+group_id+"']").val(other8);}
	if(other9=='' || other9==undefined){ other9='0'; }//ele.parents(".clone_group").find("input[name='other_9_group_"+group_id+"']").val(other9);}
	if(other10=='' || other10==undefined){ other10='0';  }//ele.parents(".clone_group").find("input[name='other_10_group_"+group_id+"']").val(other10);}
	
	incentive = replaceComma(incentive);
	incentive = parseFloat(incentive);
	bonus = replaceComma(bonus);
	bonus = parseFloat(bonus);
	rate_position = replaceComma(rate_position);
	rate_position = parseFloat(rate_position);

	transport_exp = replaceComma(transport_exp);
	transport_exp = parseFloat(transport_exp);
	special = replaceComma(special);
	special = parseFloat(special);
	other_value = replaceComma(other_value);
	other_value = parseFloat(other_value);

	other1 = replaceComma(other1);
	other2 = replaceComma(other2);
	other3 = replaceComma(other3);
	other4 = replaceComma(other4);
	other5 = replaceComma(other5);
	other6 = replaceComma(other6);
	other7 = replaceComma(other7);
	other8 = replaceComma(other8);
	other9 = replaceComma(other9);
	other10 = replaceComma(other10);
	other1 = parseFloat(other1);
	other2 = parseFloat(other2);
	other3 = parseFloat(other3);
	other4 = parseFloat(other4);
	other5 = parseFloat(other5);
	other6 = parseFloat(other6);
	other7 = parseFloat(other7);
	other8 = parseFloat(other8);
	other9 = parseFloat(other9);
	other10 = parseFloat(other10);

//+(other_value*total_man)
//=========== benefit =========
var benefit = 0;
	benefit = parseFloat(benefit);
	//benefit =parseFloat((bonus*total_man)+(incentive*total_man)+(rate_position*total_man));

//=========================================================================================	
//==================================  freach sub group all ================================
//=========================================================================================

var count_sub_group = ele.parents(".clone_group").find('.count_sub_group').val();
//alert('count_sub_group :'+count_sub_group);
if(count_sub_group=='' || count_sub_group==undefined){ count_sub_group=0; }	

var work_day =0;	
var sub_group_staff =0;
var total_sub_group_staff =0;	
var temp_unifrom =0;
for (i = 1; i <= count_sub_group; i++) {     
if(sub_group_id!=i){
work_day = ele.parents(".clone_group").find("input[name='work_day_subg"+i+"_gr"+group_id+"']").val();//per_group_subg1_gr1
if( work_day=='' || work_day == undefined ){ work_day=0; }		
//alert('work_day : '+work_day);

sub_group_staff = ele.parents(".clone_group").find("input[name='sub_group_staff_subg"+i+"_gr"+group_id+"']").val();//per_group_subg1_gr1
if( sub_group_staff=='' || sub_group_staff == undefined ){ sub_group_staff=0; }		
//alert('sub_group_staff : '+sub_group_staff);

/// == CAL total staff sub group ====
sub_group_staff = parseFloat(sub_group_staff);
total_sub_group_staff = parseFloat(total_sub_group_staff);
total_sub_group_staff = parseFloat(total_sub_group_staff) + parseFloat(sub_group_staff);


if(bonus!=0){	
	 benefit =	parseFloat(benefit+((bonus/30)*work_day*sub_group_staff));
}
if(incentive!=0){	
	 benefit =	parseFloat(benefit+((incentive/30)*work_day*sub_group_staff));
}
if(rate_position!=0){	
	 benefit =	parseFloat(benefit+((rate_position/30)*work_day*sub_group_staff));
}

//== CALCULATE OTHER ALL ====
if(other1!=0){	
	benefit = parseFloat(benefit+(other1*work_day*sub_group_staff)); 			
}
if(other2!=0){	
  	benefit = parseFloat(benefit+(other2*work_day*sub_group_staff));  	
}
if(other3!=0){	
  	benefit = parseFloat(benefit+(other3*work_day*sub_group_staff));  	
}
if(other4!=0){	
  	benefit = parseFloat(benefit+(other4*work_day*sub_group_staff));  	
}
if(other5!=0){	
  	benefit = parseFloat(benefit+(other5*work_day*sub_group_staff));  	
}
if(other6!=0){	
  	benefit = parseFloat(benefit+(other6*work_day*sub_group_staff));  	
}
if(other7!=0){	
  	benefit = parseFloat(benefit+(other7*work_day*sub_group_staff));  	
}
if(other8!=0){	
	 benefit = parseFloat(benefit+(other8*work_day*sub_group_staff));  	
}
if(other9!=0){	
	 benefit = parseFloat(benefit+(other9*work_day*sub_group_staff));  
}

if(other10!=0){	
	 benefit = parseFloat(benefit+(other10*work_day*sub_group_staff));  	
}

if(other_value!=0){	
	 benefit = parseFloat(benefit+(other_value*work_day*sub_group_staff)); 
}
if(transport_exp!=0){	
	 benefit = parseFloat(benefit+(transport_exp*work_day*sub_group_staff)); 
}
if(special!=0){	
	 benefit = parseFloat(benefit+(special*work_day*sub_group_staff)); 
}
}//end sub_group_id
}//end for
//================================================================================================================

//== call uniform : month ==
// benefit = parseFloat(benefit+((temp_unifrom/30)*work_day));

//==== call total_sub_group_staff / benefit =====
if(total_sub_group_staff=='' || total_sub_group_staff==undefined){ total_sub_group_staff=0; }
//alert('total_sub_group_staff :'+total_sub_group_staff);
if(total_sub_group_staff!=0){
	//== set benefit man
 	ele.parents(".clone_group").find('.benefit_man').val(benefit);
	benefit = parseFloat(benefit/total_sub_group_staff); 
}//end if

//set : 2 double
benefit = benefit.toFixed(2);
//alert('benefit : '+benefit);

//== set benefit
//add function comma
benefit = commaSeparateNumber(benefit);
ele.parents(".clone_group").find('.benefit').val(benefit);

//});//end on key up
}//end cal benefit Calculate_benefit_ZQT2


function total_group(ele,sub_group_id){

//$(".incentive,.transport_exp,.bonus,.input-other,.other_value,.work_day,.sub_group_staff,.total_man,.rate_position").on('keyup', function() {

//group_id
var group_id = ele.parents(".clone_group").attr("id");
var str = group_id;
group_id = str.substring(12);
//alert('group_id :'+group_id);

var benefit = ele.parents(".clone_group").find('.benefit_man').val();
if(benefit=='' || benefit==undefined){ benefit=0;  }//ele.parents(".clone_group").find('.benefit').val(benefit);}
benefit = parseFloat(benefit);



var count_sub_group = ele.parents(".clone_group").find('.count_sub_group').val();
	//alert('count_sub_group :'+count_sub_group);
if(count_sub_group=='' || count_sub_group==undefined){ count_sub_group=0; }	


var total_per_group = 0;
var per_group =0;	
// var sub_group_staff =0;
// var total_sub_group_staff =0;		
for (i = 1; i <= count_sub_group; i++) {     
if(sub_group_id!=i){
	per_group = ele.parents(".clone_group").find("input[name='per_group_subg"+i+"_gr"+group_id+"']").val();//per_group_subg1_gr1
	if( per_group=='' || per_group == undefined ){ per_group='0'; }		
	//alert('per_group : '+per_group);

	
	// sub_group_staff = ele.parents(".clone_group").find("input[name='sub_group_staff_subg"+i+"_gr"+group_id+"']").val();//per_group_subg1_gr1
	// if( sub_group_staff=='' || sub_group_staff == undefined ){ sub_group_staff=0; }		
	// //alert('sub_group_staff : '+sub_group_staff);
	// sub_group_staff = parseFloat(sub_group_staff);
	// total_sub_group_staff = parseFloat(total_sub_group_staff);
	// total_sub_group_staff = parseFloat(total_sub_group_staff) + parseFloat(sub_group_staff);
	per_group = replaceComma(per_group);
	per_group = parseFloat(per_group);
	total_per_group = parseFloat(total_per_group);
	total_per_group = parseFloat(total_per_group) + parseFloat(per_group);
}//end sub_group_id
}//end for


//var benefit_man = 0;
//benefit_man = parseFloat(benefit)*parseFloat(total_sub_group_staff);
//alert(benefit);



var sub_total = 0;
sub_total= parseFloat(sub_total);	
sub_total = parseFloat(total_per_group)+parseFloat(benefit);
//set : 2 double
sub_total = sub_total.toFixed(2);
//alert('sub_total :'+sub_total);

//set wage_benefit 
//add function comma
sub_total = commaSeparateNumber(sub_total);
ele.parents(".clone_group").find('.sub_total').val(sub_total);



//////////////////// SET :: calculate total all page ////////////////////////
Calculate_total_page(ele);
// var count_add_group = $("#count_add_group").val();
// //alert(count_add_group);
// var total_all_page = 0;
// var sub_total_gr =0;
// for ( var j = 1; j <= count_add_group; j++) { 
// 	  sub_total_gr = ele.parents(".div-group-staff").find("input[name='sub_total_gr"+j+"']").val();
// 		if( sub_total_gr=='' || sub_total_gr==undefined){ sub_total_gr=0; }	
// 		//alert('sub_total :'+sub_total_gr);	

// 		sub_total_gr = parseFloat(sub_total_gr);
// 		total_all_page = parseFloat(total_all_page);
// 		total_all_page = parseFloat(total_all_page+sub_total_gr);	
// }//end for
// //alert('total_all_page :'+total_all_page);
// //set total_all_page 
// $(".qt_total").val(total_all_page);


//});//======= end : onkeyup  ====




}//end furction total_group






$(document).ready(function(){
//=== TODO :: DEBUG chage level ======
// var temp = "";
// $('.daily_pay_rate').on('keyup', function() {
// temp  = $(this).parents(".clone_group").find('.radio_pay_rate:checked').val();
// alert(temp);

// });
//===========================================================================
//////////////////// START ::  CALL FUNCTION ////////////////////////////////
//===========================================================================
/////////////// CHAGE : LEVEL ///////////////
Chang_level();
/////////////////////////////////////////////

/////////////// CHAGE : Auto ///////////////
check_auto();
/////////////////////////////////////////////

/////////////// selected :  ///////////////
selected_uniform();
selected_position();


$('.radio_pay_rate').on('click', function() {
	Calculat_ALL($(this),0);
});
//////////////////////////  GROUP //////////////////////////////////////

$(".add-group").on('click',function(){ 
	//call function caculate all
	//Calculat_ALL($(this)); 
	//== CALL : function Clone_group ===
	Clone_group($(this));   
	// /////////////// CHAGE : LEVEL ///////////////
	// 	Chang_level();
});

$(".delete_group").on('click', function() {	
	//call function caculate all
	//Calculat_ALL($(this)); 
	//== CALL : function Delete_group ===
	Delete_group($(this)); 
});

////////////////////////// SUB GROUP //////////////////////////////////////
$(".add-sub-group").on('click',function(){
	//call function caculate all
	Calculat_ALL($(this),0);
	//alert("function clone");
	//== CALL : function Clone_sub_group ===
	 Clone_sub_group($(this));
});

$(".delete_sub_group").on('click',function(){ 

	var sub_group_id = $(this).parents(".clone_sub_group").attr("id");
	var str = sub_group_id;
	var sub_group_id = str.substring(16);
	//alert('outid sub gr'+sub_group_id);

	//== CALL : function Delete_sub_group ===
	 Calculat_ALL($(this),sub_group_id); 
	 Delete_sub_group($(this));

});

/////////////////////////// CLONE OTHER ////////////////////

$(".add-other").on('click',function(){ 
	//== call function add other
	//Calculat_ALL($(this));
	add_other($(this));

});
	
$(".delete_other").on('click',function(){ 
	Calculat_ALL($(this),0);
	delete_other($(this));
});
	
/////////////// holiday ////////////////////////
Calculate_holiday();

/////////// CALCULATE ALL ////////////////
$(".daily_pay_rate,.overtime,.holiday,.work_day,.work_holiday,.sub_group_staff,.input-other,.bonus,.transport_exp,.incentive,.other_value,.rate_position,.special,.total_man").on('keyup', function() {
	Calculat_ALL($(this),0);
});



$(".work_holiday").on('keyup', function() {

var group_id = $(this).parents(".clone_group").attr("id");
var str = group_id;
group_id = str.substring(12);
//alert(group_id);

var daily_pay_rate_type_gr = $(this).parents("#clone_group_"+group_id).find("input[name='daily_pay_rate_type_gr"+group_id+"']:checked").val();
//alert(daily_pay_rate_type_gr);

if(daily_pay_rate_type_gr=='day'){

	var work_holiday = $(this).parents(".clone_sub_group").find('.work_holiday').val();
		$(this).parents(".clone_group").find('.work_holiday').val(work_holiday);

		//== set holiday ==
		$(this).parents(".clone_group").find('.holiday').val('');	
		var daily_pay_rate = $(this).parents(".clone_group").find('.daily_pay_rate').val();	
		daily_pay_rate = replaceComma(daily_pay_rate);
		daily_pay_rate = parseFloat(daily_pay_rate);

		//== calculate holiday
		var holiday = 0;
			holiday = parseFloat((work_holiday/12)*daily_pay_rate);
			//set : 2 double
			holiday = holiday.toFixed(2);
			//add function comma
			holiday = commaSeparateNumber(holiday);
			$(this).parents(".clone_group").find('.holiday').val(holiday);	

		Re_calculate_per_person_date($(this));

}else{

	var work_holiday = $(this).parents(".clone_sub_group").find('.work_holiday').val();
	$(this).parents(".clone_group").find('.work_holiday').val(work_holiday);

}

});



/////////////////////////////// END ::  CALL FUNCTION  ///////////////////////////////////////////























//////////////////////////////////////// START :  compress //////////////////////////////////
$(".compress").on('click',function(){ 

	var compress_type  = $(this).parents(".clone_sub_group").find(".compress_type").val();
	//alert(compress_type);

	if(compress_type=="compress"){	
		 //set icon botton
	    $(this).find('.btn_compress').removeClass("fa-compress");
		$(this).find('.btn_compress').addClass("fa-expand");
		$(this).parents(".box-subgroup").find(".div-coppy-subgroup").addClass("col-sm-1");
		$(this).parents(".box-subgroup").find(".div-coppy-subgroup").removeClass("col-sm-2");

		$(this).parents(".box-subgroup").find(".div-staff-subgroup").addClass("col-sm-5");
		$(this).parents(".box-subgroup").find(".div-staff-subgroup").removeClass("col-sm-4");

		$(this).parents(".box-subgroup").find(".div-delete-subgroup").addClass("col-sm-4");
		$(this).parents(".box-subgroup").find(".div-delete-subgroup").removeClass("col-sm-2");

		$(this).parents(".box-subgroup").find(".div-day-subgroup").addClass("col-sm-12");
		$(this).parents(".box-subgroup").find(".div-day-subgroup").removeClass("col-sm-7");
		$(this).parents(".box-subgroup").find(".div-day-subgroup").css('margin-bottom', '5px');

		$(this).parents(".box-subgroup").find(".div-time-subgroup").addClass("col-sm-12");
		$(this).parents(".box-subgroup").find(".div-time-subgroup").removeClass("col-sm-5");

		$(this).parents(".box-subgroup").find(".div-datawork-group").css('margin-top', '135px');

		$(this).parents(".box-subgroup").find(".div-gender-subgroup").css('display', 'none');

		$(this).parents(".box-subgroup").find(".div-position-subgroup").css('display', 'none');

		$(this).parents(".box-subgroup").find(".div-ot-subgroup").css('display', 'none');

		//$(this).parents(".box-subgroup").find(".text-day").css('display', 'none');

		$(this).parents(".box-subgroup").find(".sbj-work-hrs").html("W Hrs.");
		$(this).parents(".box-subgroup").find(".sbj-over-hrs").html("Ot Hrs.");
		$(this).parents(".box-subgroup").find(".sbj-wday").html("W Day");
		$(this).parents(".box-subgroup").find(".sbj-holiday").html("W Hd.");

		$(this).parents(".box-subgroup").find(".div-remark-subgroup").addClass("col-sm-12");
		$(this).parents(".box-subgroup").find(".div-remark-subgroup").removeClass("col-sm-6");
		$(this).parents(".box-subgroup").find(".remark").addClass("input-sm");

		$(this).parents(".box-subgroup").find(".work_hrs").addClass("input-sm");
		$(this).parents(".box-subgroup").find(".overtime_hrs").addClass("input-sm");
		$(this).parents(".box-subgroup").find(".work_day").addClass("input-sm");
		$(this).parents(".box-subgroup").find(".per_person").addClass("input-sm");
		$(this).parents(".box-subgroup").find(".per_group").addClass("input-sm");	
		
		//set div box-subgroup
		$(this).parents(".box-subgroup").addClass("col-sm-3");
    	$(this).parents(".box-subgroup").removeClass("col-sm-6");

    	$(this).parents(".box-subgroup").find(".sub_group_staff").addClass("input-sm");


		compress_type =	 $(this).parents(".clone_sub_group").find(".compress_type").val('expand');

	}else{
		
		//set icon botton
		$(this).find('.btn_compress').removeClass("fa-expand");  
    	$(this).find('.btn_compress').addClass("fa-compress");
    	$(this).parents(".box-subgroup").find(".div-coppy-subgroup").removeClass("col-sm-1");
		$(this).parents(".box-subgroup").find(".div-coppy-subgroup").addClass("col-sm-2");

		$(this).parents(".box-subgroup").find(".div-staff-subgroup").removeClass("col-sm-5");
		$(this).parents(".box-subgroup").find(".div-staff-subgroup").addClass("col-sm-4");

		$(this).parents(".box-subgroup").find(".div-delete-subgroup").removeClass("col-sm-4");
		$(this).parents(".box-subgroup").find(".div-delete-subgroup").addClass("col-sm-2");

		$(this).parents(".box-subgroup").find(".div-day-subgroup").removeClass("col-sm-12");
		$(this).parents(".box-subgroup").find(".div-day-subgroup").addClass("col-sm-7");
		$(this).parents(".box-subgroup").find(".div-day-subgroup").css('margin-bottom', '0px');

		$(this).parents(".box-subgroup").find(".div-time-subgroup").removeClass("col-sm-12");
		$(this).parents(".box-subgroup").find(".div-time-subgroup").addClass("col-sm-5");

		$(this).parents(".box-subgroup").find(".div-datawork-group").css('margin-top', '0px');

		$(this).parents(".box-subgroup").find(".div-gender-subgroup").css('display', 'block');

		$(this).parents(".box-subgroup").find(".div-position-subgroup").css('display', 'block');

		$(this).parents(".box-subgroup").find(".div-ot-subgroup").css('display', 'block');

		//$(this).parents(".box-subgroup").find(".text-day").css('display', 'block');


		$(this).parents(".box-subgroup").find(".sbj-work-hrs").html("work_hrs");
		$(this).parents(".box-subgroup").find(".sbj-over-hrs").html("overtime_hrs");
		$(this).parents(".box-subgroup").find(".sbj-wday").html("work_day");
		$(this).parents(".box-subgroup").find(".sbj-holiday").html("work_holiday");


		$(this).parents(".box-subgroup").find(".div-remark-subgroup").removeClass("col-sm-12");
		$(this).parents(".box-subgroup").find(".div-remark-subgroup").addClass("col-sm-6");
		$(this).parents(".box-subgroup").find(".remark").removeClass("input-sm");

		$(this).parents(".box-subgroup").find(".work_hrs").removeClass("input-sm");
		$(this).parents(".box-subgroup").find(".overtime_hrs").removeClass("input-sm");
		$(this).parents(".box-subgroup").find(".work_day").removeClass("input-sm");
		$(this).parents(".box-subgroup").find(".per_person").removeClass("input-sm");
		$(this).parents(".box-subgroup").find(".per_group").removeClass("input-sm");

    	//set div box-subgroup
		$(this).parents(".box-subgroup").removeClass("col-sm-3");
    	$(this).parents(".box-subgroup").addClass("col-sm-6");


    	$(this).parents(".box-subgroup").find(".sub_group_staff").removeClass("input-sm");


    	compress_type =	 $(this).parents(".clone_sub_group").find(".compress_type").val('compress');
	}

});
//////////////////////////////////////// END :  compress //////////////////////////////////







/////////////////////// start : coppy sub group ////////////////////////////////
var count_sub_group = '';
$(".coppy_sub_group").on('click',function(){ 
var count_sub_group = '';

//alert('coppy sub group');
var temp_count_sub_group = $(this).parents(".clone_sub_group").attr("id");
var str_sub_id = temp_count_sub_group;
var sub_gr_id = str_sub_id.substring(16);
temp_count_sub_group = sub_gr_id;


//alert('temp_count_sub_group :'+temp_count_sub_group);


count_sub_group = $(this).parents(".clone_group").find(".count_sub_group").val();
count_sub_group++;

var id_clone_group = $(this).parents(".clone_group").attr("id");
var str = id_clone_group;
var group_id = str.substring(12);
	

 var clone =  $(this).parents(".div-sub-gruop").find("#clone_sub_group_"+temp_count_sub_group).clone(true).attr("id", "clone_sub_group_" +count_sub_group);

     //clone.find(".clone_sub_group").attr("id", "clone_sub_group_"+count_sub_group);
     // .appendTo("#"+id_clone_group+" .div-sub-gruop")          
     // .attr("id", "clone_sub_group_" +  count_sub_group) 
  //== chage name other ===

   clone.find(".sub_group_staff").prop("name","sub_group_staff_subg"+count_sub_group+"_gr"+ group_id);

   clone.find(".gender").prop("name","gender_subg"+count_sub_group+"_gr"+ group_id);
   clone.find(".gender").attr("data-parsley-multiple","gender_subg"+count_sub_group+"_gr"+ group_id);//gender_subg2_gr1
   clone.find(".gender").prop("data-parsley-id","51"+count_sub_group+group_id);      

   //set custom radio day
	 clone.find(".day-radio").attr("name","day_radio_subg"+count_sub_group+"_gr"+ group_id+"[]");
	 clone.find(".day-radio").attr("data-parsley-multiple","day_radio_subg"+count_sub_group+"_gr"+ group_id);//day_radio_subg1_gr1
	 clone.find(".radio1").attr("id","radio1"+count_sub_group+group_id);
	 clone.find(".radio2").attr("id","radio2"+count_sub_group+group_id);
	 clone.find(".radio3").attr("id","radio3"+count_sub_group+group_id);
	 clone.find(".radio4").attr("id","radio4"+count_sub_group+group_id);
	 clone.find(".radio5").attr("id","radio5"+count_sub_group+group_id);
	 clone.find(".radio6").attr("id","radio6"+count_sub_group+group_id);
	 clone.find(".radio7").attr("id","radio7"+count_sub_group+group_id);
	 clone.find(".radio8").attr("id","radio8"+count_sub_group+group_id);
	 clone.find(".radio_for1").attr("for","radio1"+count_sub_group+group_id);
	 clone.find(".radio_for2").attr("for","radio2"+count_sub_group+group_id);
	 clone.find(".radio_for3").attr("for","radio3"+count_sub_group+group_id);
	 clone.find(".radio_for4").attr("for","radio4"+count_sub_group+group_id);
	 clone.find(".radio_for5").attr("for","radio5"+count_sub_group+group_id);
	 clone.find(".radio_for6").attr("for","radio6"+count_sub_group+group_id);
	 clone.find(".radio_for7").attr("for","radio7"+count_sub_group+group_id);
	 clone.find(".radio_for8").attr("for","radio8"+count_sub_group+group_id);

	clone.find(".time_start").attr("name","time_start_subg"+count_sub_group+"_gr"+ group_id); 
	clone.find(".time_end").attr("name","time_end_subg"+count_sub_group+"_gr"+ group_id); 

	clone.find(".work_hrs").attr("name","work_hrs_subg"+count_sub_group+"_gr"+ group_id);
	// clone.find(".work_hrs").after('<input data-parsley-min ="1" data-parsley-required="true" data-parsley-error-message="กรุณาใส่ข้อมูล" type="text" autocomplete="off" onkeypress="return isInt(event)" name="work_hrs_subg'+count_sub_group+'_gr'+group_id+'" class="form-control  work_hrs_clone parsley-success" value="'+$('#clone_sub_group_'+temp_count_sub_group).find('.work_hrs').val()+'">');
	// clone.find(".work_hrs").remove();
	// clone.find(".work_hrs").addClass('work_hrs');
	// clone.find(".work_hrs").removeClass('work_hrs_clone');


	clone.find(".overtime_hrs").attr("name","overtime_hrs_subg"+count_sub_group+"_gr"+ group_id); 
	clone.find(".work_day").attr("name","work_day_subg"+count_sub_group+"_gr"+ group_id); 
	clone.find(".work_holiday").attr("name","work_holiday_subg"+count_sub_group+"_gr"+ group_id); 
	clone.find(".charge_ot").attr("name","charge_ot_subg"+count_sub_group+"_gr"+ group_id); 
	clone.find(".remark").attr("name","remark_subg"+count_sub_group+"_gr"+ group_id); 
	clone.find(".per_person").attr("name","per_person_subg"+count_sub_group+"_gr"+ group_id); 
	clone.find(".per_group").attr("name","per_group_subg"+count_sub_group+"_gr"+ group_id); 



 
	clone.find('.parsley-error').removeClass('parsley-error');
	clone.find('.parsley-errors-list.filled > li').remove();
	clone.find('.parsley-errors-list.filled').removeClass('filled');
	
	 if (temp_count_sub_group == 1) {
	 	clone.find('.compress').after('<button class="btn btn-sm btn-default  pull-right delete_sub_group" type="button"><i class="fa fa-trash-o"></i></button>');
	 }

    clone.appendTo("#"+id_clone_group+" .div-sub-gruop");  
 //alert('clon group :: '+id_clone_group+' || clone_sub_gr :: clone_sub_group_'+count_sub_group+' || subg :'+count_sub_group+'|| group_id :'+group_id);
 		
 	
  	$(this).parents(".clone_group").find(".count_sub_group").val(count_sub_group);  

  	//CALL :: Calculat_ALL
 	Calculat_ALL($(this),0); 

 	//=== call Delete_sub_group ===
 	$(".delete_sub_group").on('click',function(){ 
 		//alert('coppy_sub_group');
 	var sub_group_id = $(this).parents(".clone_sub_group").attr("id");
	var str = sub_group_id;
	var sub_group_id = str.substring(16);
	//alert('addsub id sub gr'+sub_group_id);

	//== CALL : function Delete_sub_group ===
	 Calculat_ALL($(this),sub_group_id); 
	 Delete_sub_group($(this));

	});


});//end add sub group

/////////////////////// END : coppy sub group ////////////////////////////////

//////////////////////// start : coppy group ////////////////////////////////
$(".coppy_group").on('click',function(){ 

var count_add_group = $("#count_add_group").val();
	//alert('count_add_group :'+ count_add_group);
	count_add_group++;

var group_id = $(this).parents(".clone_group").attr("id");
 	var str = group_id;
    group_id = str.substring(12);
    //alert('group_id :'+group_id);

var master = $(this).parents(".div-group-staff").find("#clone_group_"+group_id);
var clone =  master.clone(true).attr("id", "clone_group_" +count_add_group);

clone.find(".group_title").prop("name","group_title_gr"+ count_add_group);
clone.find('.group_title').prop("name","group_title_gr"+ count_add_group);

clone.find('.total_man').after('<input data-parsley-min ="1" data-parsley-required="true" data-parsley-error-message="" type="text" autocomplete="off" onkeypress="return isInt(event)" class="form-control total_man_clone" name="total_man_gr'+count_add_group+'" value="'+clone.find('.total_man').val()+'">');
clone.find('.total_man').remove();
clone.find('.total_man_clone').addClass('total_man');
clone.find('.total_man_clone').removeClass('total_man_clone');

clone.find('.overtime').prop("name","overtime_gr"+ count_add_group);
clone.find('.is_auto_ot').prop("name","is_auto_ot_gr"+ count_add_group);
clone.find('.overtime_id').prop("name","overtime_id_gr"+ count_add_group);

clone.find('.incentive').prop("name","incentive_gr"+ count_add_group);
clone.find('.incentive_id').prop("name","incentive_id_gr"+ count_add_group);

clone.find('.transport_exp').prop("name","transport_exp_gr"+ count_add_group);
clone.find('.is_auto_transport').prop("name","is_auto_transport_gr"+ count_add_group);
clone.find('.transport_exp_id').prop("name","transport_exp_id_gr"+ count_add_group);

clone.find('.daily_pay_rate').prop("name","daily_pay_rate_gr"+ count_add_group);
clone.find('.radio_pay_rate').prop("name","daily_pay_rate_type_gr"+ count_add_group);
clone.find('.rate_day').attr("id","rate_day_"+ count_add_group);
clone.find('.rate_month').attr("id","rate_month_"+ count_add_group);
clone.find('.daily_pay_rate_id').prop("name","daily_pay_rate_id_gr"+ count_add_group);

clone.find('.holiday').prop("name","holiday_gr"+ count_add_group);
clone.find('.holiday_id').prop("name","holiday_id_gr"+ count_add_group);

clone.find('.bonus').prop("name","bonus_gr"+ count_add_group);
clone.find('.bonus_id').prop("name","bonus_id_gr"+ count_add_group);

//clone.find('.is_auto_position').prop("name","is_auto_position_gr"+ count_add_group);
clone.find('.is_auto_special').prop("name","is_auto_special_gr"+ count_add_group);

clone.find('.rate_position_id').prop("name","rate_position_id_gr"+ count_add_group);
clone.find('.rate_position').prop("name","rate_position_gr"+ count_add_group);

clone.find('.special_id').prop("name","special_id_gr"+ count_add_group);
clone.find('.special').prop("name","special_gr"+ count_add_group);

clone.find('.count_other_group').prop("name","count_other_group_"+ count_add_group);
clone.find('.other_title').prop("name","other_title_gr"+ count_add_group);
clone.find('.other_value').prop("name","other_value_gr"+ count_add_group);
clone.find('.other_id').prop("name","other_id_gr"+ count_add_group);

clone.find('.level_staff').after('<select class="form-control level_staff_clone" data-parsley-required="true" name="level_staff_gr'+count_add_group+'"></select>');
clone.find('.level_staff_clone').append(clone.find('.level_staff option'));
clone.find('.level_staff').remove();
clone.find('.level_staff_clone').addClass('level_staff');
clone.find('.level_staff_clone').removeClass('level_staff_clone');
if (clone.find('.level_staff option[selected="selected"]').length > 0) {
	clone.find('.level_staff option[selected="selected"]').attr('selected', 'selected');
} else {
	clone.find('.level_staff option:first').attr('selected', 'selected');
}

clone.find('.position').after('<select class="form-control position_clone" data-parsley-required="true" name="position_gr'+count_add_group+'"></select>');
clone.find('.position_clone').append(clone.find('.position option'));
clone.find('.position').remove();
clone.find('.position_clone').addClass('position');
clone.find('.position_clone').removeClass('position_clone');
if (clone.find('.position_clone option[selected="selected"]').length > 0) {
	clone.find('.position_clone option[selected="selected"]').attr('selected', 'selected');
} else {
	clone.find('.position_clone option:first').attr('selected', 'selected');
}


clone.find('.uniform').after('<select class="form-control uniform_clone" data-parsley-required="true" name="uniform_gr'+count_add_group+'"></select>');
clone.find('.uniform_clone').append(clone.find('.uniform option'));
clone.find('.uniform').remove();
clone.find('.uniform_clone').addClass('uniform');
clone.find('.uniform_clone').removeClass('uniform_clone');
if (clone.find('.uniform option[selected="selected"]').length > 0) {
	clone.find('.uniform option[selected="selected"]').attr('selected', 'selected');
} else {
	clone.find('.uniform option:first').attr('selected', 'selected');
}


clone.find('.overtime').after('<input data-parsley-required="true" data-parsley-error-message="" type="text" autocomplete="off" onkeypress="return isDouble(event)" class="form-control overtime_clone text-right" name="overtime_gr'+count_add_group+'" value="'+clone.find('.overtime').val()+'">');
clone.find('.overtime').remove();
clone.find('.overtime_clone').addClass('overtime');
clone.find('.overtime_clone').removeClass('overtime_clone');

clone.find('.daily_pay_rate').after('<input data-parsley-min ="1" data-parsley-required="true" data-parsley-error-message="" type="text" autocomplete="off" onkeypress="return isDouble(event)" class="form-control daily_pay_rate_clone text-right" name="daily_pay_rate_gr'+count_add_group+'" value="'+clone.find('.daily_pay_rate').val()+'">');
clone.find('.daily_pay_rate').remove();
clone.find('.daily_pay_rate_clone').addClass('daily_pay_rate');
clone.find('.daily_pay_rate_clone').removeClass('daily_pay_rate_clone');

clone.find('.benefit').prop("name","benefit_gr"+ count_add_group);
clone.find('.benefit_man').prop("name","benefit_man_gr"+ count_add_group);

clone.find('.waege').after('<input data-parsley-required="true" data-parsley-error-message="" readonly type="text" autocomplete="off" onkeypress="return isDouble(event)" class="form-control waege_clone" name="waege_gr'+count_add_group+'" value="'+clone.find('.waege').val()+'">');
clone.find('.waege').remove();
clone.find('.waege_clone').addClass('waege');
clone.find('.waege_clone').removeClass('waege_clone');

clone.find('.wage_benefit').after('<input data-parsley-required="true" data-parsley-error-message="" readonly type="text" autocomplete="off" onkeypress="return isDouble(event)" class="form-control wage_benefit_clone" name="wage_benefit_gr'+count_add_group+'" value="'+clone.find('.wage_benefit').val()+'">');
clone.find('.wage_benefit').remove();
clone.find('.wage_benefit_clone').addClass('wage_benefit');
clone.find('.wage_benefit_clone').removeClass('wage_benefit_clone');

clone.find('.sub_total').after('<input data-parsley-required="true" data-parsley-error-message="" readonly type="text" autocomplete="off" onkeypress="return isDouble(event)" class="form-control sub_total_clone" name="sub_total_gr'+count_add_group+'" value="'+clone.find('.sub_total').val()+'">');
clone.find('.sub_total').remove();
clone.find('.sub_total_clone').addClass('sub_total');
clone.find('.sub_total_clone').removeClass('sub_total_clone');

var qt_staff = ($('.qt_staff').val() != "") ? parseInt($('.qt_staff').val()) : 0;
var total_man = (clone.find('.total_man').val() != "") ? parseInt(clone.find('.total_man').val()) : 0;
  
var master_total_man = 0 // get the current value of the input field.

$(".total_man").each(function() {
	master_total_man += ($(this).val() != 0 ) ? parseInt($(this).val()) : 0;
});
//alert('man : '+man+' || staff_qt : '+staff_quotation);
master_total_man = parseInt(master_total_man);


if (qt_staff < (master_total_man+total_man)) {
	clone.find('.total_man').val('');
	clone.find('.waege').val('');
	clone.find('.wage_benefit').val('');
	clone.find('.sub_total').val('');
}

// chage name other
var count_other_group = clone.find('.count_other_group').val();
//alert('count_other_group :'+count_other_group);
for (var i = 1; i <= count_other_group; i++) { 

	clone.find("input[name='other_"+i+"_group_"+group_id+"']").prop("name","other_"+i+"group_"+count_add_group);


}//end for


//=== chang name sub group clone 1
   clone.find('.count_sub_group').prop("name","count_sub_group_"+ count_add_group);
   var count_sub_group = clone.find('.count_sub_group').val();
	   //alert('count_sub_group :'+count_sub_group);
		for (var j = 1; j <= count_sub_group; j++) { 

	     //chang name sub group
			clone.find("#clone_sub_group_"+j+" .sub_group_staff").prop("name","sub_group_staff_subg"+j+"_gr"+ count_add_group);

			clone.find('#clone_sub_group_'+j+' .sub_group_staff').after('<input data-parsley-min ="1" data-parsley-required="true" data-parsley-error-message="" type="text" autocomplete="off" onkeypress="return isInt(event)" name="sub_group_staff_subg'+j+'_gr'+count_add_group+'" class="form-control  sub_group_staff_clone parsley-success" value="'+clone.find('#clone_sub_group_'+j+' .sub_group_staff').val()+'">');
			clone.find('#clone_sub_group_'+j+' .sub_group_staff').remove();
			clone.find('#clone_sub_group_'+j+' .sub_group_staff_clone').addClass('sub_group_staff');
			clone.find('#clone_sub_group_'+j+' .sub_group_staff_clone').removeClass('sub_group_staff_clone');

			if (qt_staff < (master_total_man+total_man)) {
				clone.find('.sub_group_staff').val('');
			}

			clone.find("#clone_sub_group_"+j+" .gender").prop("name","gender_subg"+j+"_gr"+ count_add_group);
			clone.find("#clone_sub_group_"+j+" .gender").attr("data-parsley-multiple","gender_subg"+j+"_gr"+ count_add_group);//gender_subg2_gr1 
			//set custom radio day
			clone.find("#clone_sub_group_"+j+" .day-radio").prop("name","day_radio_subg"+j+"_gr"+ count_add_group+"[]");
			clone.find("#clone_sub_group_"+j+" .day-radio").attr("data-parsley-multiple","day_radio_subg"+j+"_gr"+ count_add_group);//day_radio_subg1_gr1
			
			clone.find("#clone_sub_group_"+j+" .radio1").prop("id","radio1"+j+count_add_group);
			clone.find("#clone_sub_group_"+j+" .radio2").prop("id","radio2"+j+count_add_group);
			clone.find("#clone_sub_group_"+j+" .radio3").prop("id","radio3"+j+count_add_group);
			clone.find("#clone_sub_group_"+j+" .radio4").prop("id","radio4"+j+count_add_group);
			clone.find("#clone_sub_group_"+j+" .radio5").prop("id","radio5"+j+count_add_group);
			clone.find("#clone_sub_group_"+j+" .radio6").prop("id","radio6"+j+count_add_group);
			clone.find("#clone_sub_group_"+j+" .radio7").prop("id","radio7"+j+count_add_group);
			clone.find("#clone_sub_group_"+j+" .radio8").prop("id","radio8"+j+count_add_group);
			clone.find("#clone_sub_group_"+j+" .radio_for1").prop("for","radio1"+j+count_add_group);
			clone.find("#clone_sub_group_"+j+" .radio_for2").prop("for","radio2"+j+count_add_group);
			clone.find("#clone_sub_group_"+j+" .radio_for3").prop("for","radio3"+j+count_add_group);
			clone.find("#clone_sub_group_"+j+" .radio_for4").prop("for","radio4"+j+count_add_group);
			clone.find("#clone_sub_group_"+j+" .radio_for5").prop("for","radio5"+j+count_add_group);
			clone.find("#clone_sub_group_"+j+" .radio_for6").prop("for","radio6"+j+count_add_group);
			clone.find("#clone_sub_group_"+j+" .radio_for7").prop("for","radio7"+j+count_add_group);
			clone.find("#clone_sub_group_"+j+" .radio_for8").prop("for","radio8"+j+count_add_group);

			clone.find('#clone_sub_group_'+j+' .time_start').after('<input data-parsley-required="true" data-parsley-error-message="" type="text" autocomplete="off" style="width:60px;" onkeypress="return isNumberTime(event)" maxlength="5" class="time_start_clone" name="time_start_subg'+j+'_gr'+count_add_group+'" placeholder="00:00" value="'+clone.find('#clone_sub_group_'+j+' .time_start').val()+'" >');
			clone.find('#clone_sub_group_'+j+' .time_start').remove();
			clone.find('#clone_sub_group_'+j+' .time_start_clone').addClass('time_start');
			clone.find('#clone_sub_group_'+j+' .time_start_clone').removeClass('time_start_clone');

			clone.find('#clone_sub_group_'+j+' .time_end').after('<input data-parsley-required="true" data-parsley-error-message="" type="text" autocomplete="off" style="width:60px;" onkeypress="return isNumberTime(event)" maxlength="5" class="time_end_clone" name="time_end_subg'+j+'_gr'+count_add_group+'" placeholder="00:00" value="'+clone.find('#clone_sub_group_'+j+' .time_end').val()+'">');
			clone.find('#clone_sub_group_'+j+' .time_end').remove();
			clone.find('#clone_sub_group_'+j+' .time_end_clone').addClass('time_end');
			clone.find('#clone_sub_group_'+j+' .time_end_clone').removeClass('time_end_clone');

			clone.find('#clone_sub_group_'+j+' .work_hrs').after('<input data-parsley-min ="1" data-parsley-required="true" data-parsley-error-message="" type="text" autocomplete="off" onkeypress="return isDouble(event)" name="work_hrs_subg'+j+'_gr'+count_add_group+'" class="form-control  work_hrs_clone parsley-success" value="'+clone.find('#clone_sub_group_'+j+' .work_hrs').val()+'">');
			clone.find('#clone_sub_group_'+j+' .work_hrs').remove();
			clone.find('#clone_sub_group_'+j+' .work_hrs_clone').addClass('work_hrs');
			clone.find('#clone_sub_group_'+j+' .work_hrs_clone').removeClass('work_hrs_clone');

			clone.find("#clone_sub_group_"+j+" .overtime_hrs").prop("name","overtime_hrs_subg"+j+"_gr"+ count_add_group); 

			clone.find('#clone_sub_group_'+j+' .work_day').after('<input data-parsley-min ="1" data-parsley-required="true" data-parsley-error-message="" type="text" autocomplete="off" onkeypress="return isInt(event)" name="work_day_subg'+j+'_gr'+count_add_group+'" class="form-control  work_day_clone parsley-success" value="'+clone.find('#clone_sub_group_'+j+' .work_day').val()+'">');
			clone.find('#clone_sub_group_'+j+' .work_day').remove();
			clone.find('#clone_sub_group_'+j+' .work_day_clone').addClass('work_day');
			clone.find('#clone_sub_group_'+j+' .work_day_clone').removeClass('work_day_clone');

			clone.find("#clone_sub_group_"+j+" .work_holiday").prop("name","work_holiday_subg"+j+"_gr"+ count_add_group); 

			clone.find('#clone_sub_group_'+j+' .charge_ot').after('<input  data-parsley-required="true" data-parsley-error-message="" type="text" autocomplete="off" onkeypress="return isInt(event)" name="charge_ot_subg'+j+'_gr'+count_add_group+'" class="form-control  charge_ot_clone text-right parsley-success" value="'+clone.find('#clone_sub_group_'+j+' .charge_ot').val()+'">');
			//data-parsley-min ="1"
			clone.find('#clone_sub_group_'+j+' .charge_ot').remove();
			clone.find('#clone_sub_group_'+j+' .charge_ot_clone').addClass('charge_ot');
			clone.find('#clone_sub_group_'+j+' .charge_ot_clone').removeClass('charge_ot_clone');

			clone.find("#clone_sub_group_"+j+" .remark").prop("name","remark_subg"+j+"_gr"+ count_add_group); 
			clone.find("#clone_sub_group_"+j+" .per_person").prop("name","per_person_subg"+j+"_gr"+ count_add_group); 
			clone.find("#clone_sub_group_"+j+" .per_group").prop("name","per_group_subg"+j+"_gr"+ count_add_group); 

		}//end for


		clone.find('.parsley-error').removeClass('parsley-error');
		// clone.find('.parsley-errors-list.filled > li').remove();
		// clone.find('.parsley-errors-list.filled').removeClass('filled');
		clone.find('.parsley-errors-list').remove();

		 if (group_id == 1) {
		 	clone.find('.del_div').append('<button class="btn btn-default delete_group  pull-right" type="button"><i class="fa fa-trash-o h4"></i></button>');
		 }
		//== add to div ==
		clone.appendTo(".div-group-staff");  

///////////////////coopygroup call funcoton //////////////////////////////
		
		/////////////// CHAGE : LEVEL ///////////////
		Chang_level();

		/////////////// CHAGE : Auto ///////////////
		check_auto();

		/////////////// selected :  ///////////////
		selected_uniform();
		selected_position();


		////// add comma //////////

		$('.daily_pay_rate,.overtime,.holiday,.transport_exp,.incentive,.bonus,.rate_position,.special,.input-other,.other_value,.charge_ot').on('keyup', function() {
		    
		var val = $(this).val();
		    val = replaceComma(val);

		if(val!=''){
		    var last_index = val.substr(val.length-1);
		    if (last_index == '.') {
		      return true;
		    }

		    var isint = isInteger(parseFloat(val));

		        // console.log('# '+val);

		        if (isint) {
		          val = parseFloat(val).toMoney( 0 );
		        } else {
		          var seperator = val.indexOf('.');
		          var decimal   = val.substr(seperator+1);
		          val = parseFloat(val).toMoney(decimal.length);
		        }

		        // console.log('## '+val);
		      $(this).val(val.toString());

		}//end if

		});

				
		 /////////// CALCULATE ALL ////////////////
		 Calculat_ALL($(this),0);
		$(".daily_pay_rate,.overtime,.holiday,.work_day,.work_holiday,.sub_group_staff,.input-other,.bonus,.transport_exp,.incentive,.other_value,.rate_position,.special,.total_man").on('keyup', function() {
			Calculat_ALL($(this),0);
		});
		// start : calculate_holiday
		Calculate_holiday();


		$(".work_holiday").on('keyup', function() {

			var group_id = $(this).parents(".clone_group").attr("id");
			var str = group_id;
			group_id = str.substring(12);
			//alert(group_id);

			var daily_pay_rate_type_gr = $(this).parents("#clone_group_"+group_id).find("input[name='daily_pay_rate_type_gr"+group_id+"']:checked").val();
			//alert(daily_pay_rate_type_gr);

			if(daily_pay_rate_type_gr=='day'){

				var work_holiday = $(this).parents(".clone_sub_group").find('.work_holiday').val();
					$(this).parents(".clone_group").find('.work_holiday').val(work_holiday);

					//== set holiday ==
					$(this).parents(".clone_group").find('.holiday').val('');	
					var daily_pay_rate = $(this).parents(".clone_group").find('.daily_pay_rate').val();	
						daily_pay_rate = replaceComma(daily_pay_rate);
						daily_pay_rate = parseFloat(daily_pay_rate);
					//== calculate holiday
					var holiday = 0;
						holiday = parseFloat((work_holiday/12)*daily_pay_rate);
						//set : 2 double
						holiday = holiday.toFixed(2);
						//add function comma
						holiday = commaSeparateNumber(holiday);
						$(this).parents(".clone_group").find('.holiday').val(holiday);	

					Re_calculate_per_person_date($(this));

			}else{

				var work_holiday = $(this).parents(".clone_sub_group").find('.work_holiday').val();
				$(this).parents(".clone_group").find('.work_holiday').val(work_holiday);

			}

		});


		$(".delete_group").on('click', function() {			
			//== CALL : function Delete_group ===
			Delete_group($(this)); 
		});

		$(".delete_sub_group").on('click',function(){ 
			var sub_group_id = $(this).parents(".clone_sub_group").attr("id");
			var str = sub_group_id;
			var sub_group_id = str.substring(16);
			//alert('cppy gr id sub gr'+sub_group_id);
			//== CALL : function Delete_sub_group ===
			 Calculat_ALL($(this),sub_group_id); 
			 Delete_sub_group($(this));
		});

		$(".delete_other").on('click',function(){ 
			Calculat_ALL($(this),0);
			delete_other($(this));
		});




	 		
		//############################ start : CHECK STAFF TOTAL   ##################################################
$('.total_man').bind('input', function() { 
	var staff_quotation =  $("input[name='qt_staff']").val();   
	var man = 0 // get the current value of the input field.

    $(".total_man").each(function() {
    	man += ($(this).val() != 0 ) ? parseInt($(this).val()) : 0;
    });
    man = parseInt(man);
    staff_quotation = parseInt(staff_quotation);

    if(man>staff_quotation){
    	//alert("ผิดพลาด : จำนวนคนเกิน");
    	$(this).val('');
    	$(this).parents(".clone_group").find('.waege').val('');
    	$(this).parents(".clone_group").find('.wage_benefit').val('');
    	$(this).parents(".clone_group").find('.benefit').val('');
    	$(this).parents(".clone_sub_group").find('.per_group').val('');
    }//end if
});
//############################ end : CHECK STAFF QT TOTAL   ##################################################


//############################ start : CHECK sub_group_staff     ##################################################
$('.sub_group_staff').bind('input', function() { 
	var group_staff =   $(this).parents(".clone_group").find(".total_man").val();   
    var sub_group_staff = $(this).val() // get the current value of the input field.
    //alert('sub_group_staff : '+sub_group_staff+' || staff_qt : '+group_staff);

    sub_group_staff = parseInt(sub_group_staff);
    group_staff = parseInt(group_staff);


    if(sub_group_staff>group_staff){
    	//alert("ผิดพลาด : จำนวนคนเกิน");
    	$(this).val('');
    	$(this).parents(".clone_group").find('.waege').val('');
    	$(this).parents(".clone_group").find('.wage_benefit').val('');
    	$(this).parents(".clone_group").find('.benefit').val('');
    	$(this).parents(".clone_sub_group").find('.per_group').val('');

    }//end if

});


$(".sub_group_staff").on('keyup', function() {
	var group_staff =   $(this).parents(".clone_group").find(".total_man").val(); 
	//alert(group_staff);
    if(group_staff=='' || group_staff==0){
    	//alert("ผิดพลาด : จำนวนคนเกิน");
    	$(this).val('');
    	$(this).parents(".clone_group").find('.waege').val('');
    	$(this).parents(".clone_group").find('.wage_benefit').val('');
    	$(this).parents(".clone_group").find('.benefit').val('');
    	$(this).parents(".clone_sub_group").find('.per_group').val('');

    }//end if
});
//############################ end : CHECK sub_group_staff  ##################################################

///SET :: count_add_group
	$("#count_add_group").val(count_add_group);  


//////////////  Calculate_total_page /////////
	Calculate_total_page($(this));




});//end coopy group

//////////////////////////////// end coppy group ////////////////////////////////








//############################ start : CHECK STAFF TOTAL   ##################################################
$('.total_man').bind('input', function() { 
	var staff_quotation =  $("input[name='qt_staff']").val();   
	var man = 0 // get the current value of the input field.

    $(".total_man").each(function() {
    	man += ($(this).val() != 0 ) ? parseInt($(this).val()) : 0;
    });
    man = parseInt(man);
    staff_quotation = parseInt(staff_quotation);

    if(man>staff_quotation){
    	//alert("ผิดพลาด : จำนวนคนเกิน");
    	$(this).val('');
    	$(this).parents(".clone_group").find('.waege').val('');
    	$(this).parents(".clone_group").find('.wage_benefit').val('');
    	$(this).parents(".clone_group").find('.benefit').val('');
    	$(this).parents(".clone_sub_group").find('.per_group').val('');
    }//end if
});
//############################ end : CHECK STAFF QT TOTAL   ##################################################


//############################ start : CHECK sub_group_staff     ##################################################
$('.sub_group_staff').bind('input', function() { 
	var group_staff =   $(this).parents(".clone_group").find(".total_man").val();   
    var sub_group_staff = $(this).val() // get the current value of the input field.
    //alert('sub_group_staff : '+sub_group_staff+' || staff_qt : '+group_staff);

    sub_group_staff = parseInt(sub_group_staff);
    group_staff = parseInt(group_staff);


    if(sub_group_staff>group_staff){
    	//alert("ผิดพลาด : จำนวนคนเกิน");
    	$(this).val('');
    	$(this).parents(".clone_group").find('.waege').val('');
    	$(this).parents(".clone_group").find('.wage_benefit').val('');
    	$(this).parents(".clone_group").find('.benefit').val('');
    	$(this).parents(".clone_sub_group").find('.per_group').val('');

    }//end if

});


$(".sub_group_staff").on('keyup', function() {
	var group_staff =   $(this).parents(".clone_group").find(".total_man").val(); 
	//alert(group_staff);
    if(group_staff=='' || group_staff==0){
    	//alert("ผิดพลาด : จำนวนคนเกิน");
    	$(this).val('');
    	$(this).parents(".clone_group").find('.waege').val('');
    	$(this).parents(".clone_group").find('.wage_benefit').val('');
    	$(this).parents(".clone_group").find('.benefit').val('');
    	$(this).parents(".clone_sub_group").find('.per_group').val('');

    }//end if
});
//############################ end : CHECK sub_group_staff  ##################################################

$('.save_fom_btn').on('click', function (){

	// $('#form_clone_staff').removeAttr('novalidate');
	// $('*[data-parsley-required="true"]').removeAttr('data-parsley-id');
	// $('.parsley-errors-list').remove();
	// $('#form_clone_staff').parsley().destroy();
	// $('#form_clone_staff').parsley().reset();
	// $('#form_clone_staff').parsley();

	var valid = $('#form_clone_staff').parsley().validate();
	if (valid) {
		$('#form_clone_staff').submit();
	} 
	return false;

});

$('select').on('change', function() {
	var val = $(this).val();	
	$(this).find('option').removeAttr('selected');
	$(this).find('option[value="'+val+'"]').attr('selected', 'selected');
});


});//end document

</script>
