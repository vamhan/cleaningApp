<script type="text/javascript">
$(document).ready(function(){

 
//############################ start : clone building   ##################################################
    var regex = /^(.*)(\d)+$/i;
    var cloneIndex = $(".clonedInputBuilding").length;      
    var count_add_building = $('#count_add_building');

    $(".cloneButton1").on('click',function(){  
      //alert('ts');
         $("#clonedInputBuilding_0").clone(true)
          .removeClass("hide") 
          .appendTo(".div-building")
          .attr("id", "clonedInputBuilding" +  cloneIndex)
          // .find("*").each(function() {
          //     var id = this.id || "";
          //     var match = id.match(regex) || [];
          //     if (match.length == 3) {
          //         this.id = match[1] + (cloneIndex);
          //     }
          // });
          alert(cloneIndex);
          cloneIndex++; 

          count_add_building.val(cloneIndex-1);
        


    });


    //====== DELETE : building ==============
    $(".delete-building").on('click',function(){  
        $(this).parents(".clonedInputBuilding").remove();
    });
//############################ END : clone building   ##################################################

 
//############################ start : clone floor   ##################################################
  var regex_floor = /^(.*)(\d)+$/i;
  var cloneIndex_floor = ''; 
  var total_floor = '';    
   $(".add-floor").on('click',function(){ 
   total_floor = $(this).parents(".clonedInputBuilding").find(".total_floor").val();
   total_floor++;
   alert(total_floor);
   //cloneIndex_floor = $(this).parents(".clonedInputBuilding").find(".cloneFloor").length+1;


        var id_p = $(this).parents(".clonedInputBuilding").attr("id");
        alert('test_addfloor : '+id_p);
        //alert('indexfloor: '+cloneIndex_floor);
        alert('indexfloor: '+total_floor);


        //$(this).parents("#"+id_p).find(".cloneFloor").clone(true)
        $("#cloneFloor0").clone(true)
        .removeClass("hide") 

        //.insertAfter("#"+id_p+" .section-table-floor .cloneFloor")
        .appendTo("#"+id_p+" .section-table-floor")
        .attr("id", "cloneFloor" +  total_floor)//cloneIndex_floor
        .find("*").each(function() {
              var id = this.id || "";
              var match = id.match(regex_floor) || [];
              if (match.length == 3) {
                  this.id = match[1] + (cloneIndex_floor);
              }
          });
         // cloneIndex_floor++; 
          $(this).parents(".clonedInputBuilding").find(".total_floor").val(total_floor);
    });

    //====== DELETE : building ==============
    var buiding_delete_id ='';
    var floor_delete_id ='';
    $(".delete-floor").on('click',function(){  
    	buiding_delete_id = $(this).parents(".clonedInputBuilding").attr("id");
    	floor_delete_id = $(this).parents(".cloneFloor").attr("id");
    	alert(buiding_delete_id+' '+floor_delete_id);
        $(this).parents("#"+buiding_delete_id+" #"+floor_delete_id).remove();
    });

//############################ end : clone floor   ##################################################


//############################ start : add AREA   ##################################################
$('.add-area').on('click',function(){ 
	
	var building_id =  $(this).parents(".clonedInputBuilding").attr("id");
	var floor_id = $(this).parents(".cloneFloor").attr("id");
	alert(building_id+' '+floor_id);
	//alert('flor');
		
		// var area_id =  $(this).parents("#"+floor_id).find('.select-area').val();
  //       var area    = $('.select-area option[value="'+area_id+'"]').text();
  //       alert(area_id);

         var area_type = $(this).parents("#"+floor_id).find('.area_type').val();
         //alert(area_type);


        var area_title = $(this).parents("#"+floor_id).find('.area_title').val();
        //alert(area_title);

        var texture = $(this).parents("#"+floor_id).find('.select_texture').val();
        //alert(texture);

        // var texture_id = $(this).parents("#"+floor_id).find('.select_texture').val();
        // var texture    = $('.select_texture option[value="'+texture_id+'"]').text();
        // alert(texture_id);       

        var area_space = $(this).parents("#"+floor_id).find('.area_space').val();
        //alert(area_space);

        if (texture != undefined && texture != '' && texture != 0 && area_type != undefined && area_type != '' && area_type != 0 && area_title != ""  && area_space != "") {
          
          //var count = $(this).parents("#"+floor_id).find('.area_table tbody tr').length;

          var count = $(this).parents("#"+floor_id).find(".total_area_tr").val();
          count++;  
          alert('count : '+count);

          var row = "<tr class='count_"+count+"'>" +
          			  "<td></td>"+
                      //"<td>"+area+"</td>"+
                       "<td>" +
	                      area_type+
	                      "<input type='hidden' name='area_"+count+"_"+floor_id+"_"+building_id+"_"+"[type]' value='"+area_type+"'>" +
                      "</td>"+
                      "<td>" +
	                      area_title+
	                      "<input type='hidden' name='area_"+count+"_"+floor_id+"_"+building_id+"_"+"[title]' value='"+area_title+"'>" +
                      "</td>"+
                      //"<td>"+texture_id+"</td>"+
                      "<td>" +
	                      texture+
	                      "<input type='hidden' name='area_"+count+"_"+floor_id+"_"+building_id+"_"+"[texture]' value='"+texture+"'>" +
                      "</td>"+
                      "<td>" +
	                      area_space+
	                      "<input type='hidden' name='area_"+count+"_"+floor_id+"_"+building_id+"_"+"[space]' value='"+area_space+"'>" +
                      "</td>"+
                      "<td>" +
                      //"<span class='col-sm-6'><input type='text'  name='area_"+count+"_"+floor_id+"_"+building_id+"_"+"[clearing]' class='form-control no-padd' placeholder='clearing'> </span>"+
                      "<span><a href='#' class='btn btn-default edit_area_btn'><i class='fa fa-pencil'></i></a></span>"+
                      "<span class='margin-left-small'><button type='button' onclick='SomeDeleteRowFunction(this);' class='btn btn-default delete-area'><i class='fa fa-trash-o'></i></button></span>"+
                      "</td>"+                     
                    "</tr>";
                    //**btn delete

                      // "<td class='text-center'><input type='text' class='form-control frequen_index' maxlength='11' name='area_"+count+"_"+area_id+"[frequen]'></td>"+
                      // "<td class='text-center'><a href='#' class='btn btn-default edit_area_btn'><i class='fa fa-pencil'></i></a></td>"+
                      // "<td class='text-center'><a href='#' class='btn btn-default del_area_btn'><i class='fa fa-trash-o'></i></a></td>"+


          alert('success');
          //$( "#"+floor_id+" area_table tbody tr").append(row);
          //$(this).parents("#"+floor_id).find('.area_table tbody tr').append(row);

          //$("#"+building_id+" #"+floor_id+" .area_table tbody").append(row);
           $(this).parents("#"+building_id).find("#"+floor_id+" .area_table tbody").append(row);

          $('#'+floor_id+' .select-area option:first').prop('selected', true);
           $('#'+floor_id+' .select_texture option:first').prop('selected', true);
           //$('#'+floor_id+' .select_area option:not(:first)').remove();
          $('#'+floor_id+' .area_title').val('');
          //$('#'+floor_id+' .select_texture option:not(:first)').remove();
          $('#'+floor_id+' .area_space').val('');
        
        }else{ //end if
            alert('กรุณากรอกข้อมูลให้ครบถ้วน');
        }

        //set total Area 
         $(this).parents("#"+floor_id).find(".total_area_tr").val(count);

      });//end click


  // $(".delete-area").on('click',function(){  
  //       $(this).parents("tr").remove();
  //   });


//############################ END : add AREA   ##################################################

 });//end document



//############################ start : number   ##################################################
 function SomeDeleteRowFunction(btndel) {
    if (typeof(btndel) == "object") {
        $(btndel).closest("tr").remove();
    } else {
        return false;
    }
}
//############################ END : number ##################################################



//############################ start : number   ##################################################
 function DeleteRowothercontract(btndel) {
    if (typeof(btndel) == "object") {
        $(btndel).closest("tr").remove();
    } else {
        return false;
    }
}
//############################ END : number ##################################################





</script>
