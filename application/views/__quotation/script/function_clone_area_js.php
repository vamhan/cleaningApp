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
          //.parents("#clonedInputBuilding"+  cloneIndex)
          
          // .find("*").each(function() {
          //     var id = this.id || "";
          //     var match = id.match(regex) || [];
          //     if (match.length == 3) {
          //         this.id = match[1] + (cloneIndex);
          //     }
          // });
          //alert(cloneIndex);
          $("#clonedInputBuilding"+cloneIndex+" .section-table-floor").find('.total_floor').attr("name","total_floor_bu_"+ cloneIndex);
          $("#clonedInputBuilding"+cloneIndex+" .section-table-floor").find('.total_area_tr').attr("name","total_area_bu_"+cloneIndex+"_fl_1");  
          $("#clonedInputBuilding"+cloneIndex+" .section-table-floor").find('.total_of_floor').attr("name","total_of_floor_1_"+ cloneIndex);         
          $("#clonedInputBuilding"+cloneIndex).find('.building_name').attr("name","building_"+ cloneIndex);
          $("#clonedInputBuilding"+cloneIndex).find('.total_of_building').attr("name","total_of_building_"+ cloneIndex);
          $("#clonedInputBuilding"+cloneIndex).find('.floor_name').attr("name","building_"+ cloneIndex +'_floor_1');
          

          cloneIndex++; 
          count_add_building.val(cloneIndex-1);          

    });


    //====== DELETE : building ==============
    $(".delete-building").on('click',function(){


      var ele = $(this);
      
      $('#modal-delete-area').modal();
      $('.del_area_confirm').off();
      $('.del_area_confirm').on('click', function () {
        //===== start :  TODO set total =====
            var total = $("#total").val();
            var area_space =  ele.parents(".clonedInputBuilding").find(".total_of_building").val();////input[name='totol_of_building']
            //alert(total+'-'+area_space);
            total = parseFloat(total);
            area_space = parseFloat(area_space); 
            total =  parseFloat(total-area_space);
            $('#total').val(total);
        //===== end :  TODO set total =====

        //delete total building
        ele.parents(".clonedInputBuilding").remove(); 
      });      

    });
//############################ END : clone building   ##################################################

 
//############################ start : clone floor   ##################################################
  var regex_floor = /^(.*)(\d)+$/i;
  var cloneIndex_floor = ''; 
  var total_floor = '';    
   $(".add-floor").on('click',function(){ 
   total_floor = $(this).parents(".clonedInputBuilding").find(".total_floor").val();
   total_floor++;
   //alert(total_floor);
   //cloneIndex_floor = $(this).parents(".clonedInputBuilding").find(".cloneFloor").length+1;


        var id_p = $(this).parents(".clonedInputBuilding").attr("id");
        var str = id_p;
        var res = str.substring(19);
        //alert('test_addfloor : '+id_p);
        //alert('indexfloor: '+total_floor);


        //$(this).parents("#"+id_p).find(".cloneFloor").clone(true)
        $("#cloneFloor0").clone(true)
        .removeClass("hide") 

        //.insertAfter("#"+id_p+" .section-table-floor .cloneFloor")
        .appendTo("#"+id_p+" .section-table-floor")
        .attr("id", "cloneFloor" +  total_floor)//cloneIndex_floor
        .find('.floor_name').attr("name","building_"+ res +'_floor_'+total_floor); // set floor name             
        
        //alert(id_p+' building : '+res);
        //$("#cloneFloor"+total_floor).find('.floor_name').attr("name","building_"+ res +'_floor_'+total_floor);

        // .find("*").each(function() {
        //       var id = this.id || "";
        //       var match = id.match(regex_floor) || [];
        //       if (match.length == 3) {
        //           this.id = match[1] + (cloneIndex_floor);
        //       }
        //   });           
          

       // cloneIndex_floor++; 
       //alert('bu id:'+res);
       // $(this).find('.total_area_tr').attr("name","total_arear_bu_"+ res+'_fl_'+total_floor); 
       $("#"+id_p+" #cloneFloor"+total_floor+" .total_of_floor").attr("name","total_of_floor_"+total_floor +'_'+res);    
       $("#"+id_p+" #cloneFloor"+total_floor+" .total_area_tr").attr("name","total_area_bu_"+ res+'_fl_'+total_floor);   
        
        $(this).parents(".clonedInputBuilding").find(".total_floor").val(total_floor);

          
         
    });

    //====== DELETE : building ==============
    var buiding_delete_id ='';
    var floor_delete_id ='';
    $(".delete-floor").on('click',function(){  

      var ele = $(this);

      $('#modal-delete-area').modal();
      $('.del_area_confirm').off();
      $('.del_area_confirm').on('click', function () {
        buiding_delete_id = ele.parents(".clonedInputBuilding").attr("id");
        floor_delete_id = ele.parents(".cloneFloor").attr("id");
        //alert(buiding_delete_id+' '+floor_delete_id);

            //===== start :  TODO set total =====
              var total = $("#total").val();
              var area_space_of_floor = $("#"+buiding_delete_id+" #"+floor_delete_id).find(".total_of_floor").val();//input[name='total_of_floor']
              //alert(total+'-'+area_space_of_floor);           
              total = parseFloat(total);
              area_space_of_floor = parseFloat(area_space_of_floor); 
              total =  parseFloat(total-area_space_of_floor);
              $('#total').val(total);
            //===== end :  TODO set total =====

            //===== start :  TODO set total building =====
              var totol_of_building_set  = $("#"+buiding_delete_id).find(".total_of_building").val();//"input[name='totol_of_building']"
              //alert(totol_of_building_set+'-'+area_space_of_floor);           
              totol_of_building_set = parseFloat(totol_of_building_set);
              area_space_of_floor = parseFloat(area_space_of_floor); 
              totol_of_building_set =  parseFloat(totol_of_building_set-area_space_of_floor);
              $("#"+buiding_delete_id).find(".total_of_building").val(totol_of_building_set);//input[name='totol_of_building']
            //===== end :  TODO set total building =====

        
        //dlete floor
        ele.parents("#"+buiding_delete_id+" #"+floor_delete_id).remove();
      });
    });

//############################ end : clone floor   ##################################################






//<!--################## to do chage area type ########################-->
var industry_room_description = '';
$( "select[name='select_area']" ).change(function() {
  industry_room_id = $(this).val();
  //alert(industry_room_id);
  industry_room_description = $(this).parents("tr").find("input[name='industry_room_description']");

   $.ajax({
              type: "GET",
              url: '<?php echo site_url("__ps_quotation/get_industry_room_by_id");?>'+'/'+industry_room_id ,
              data: {},
              dataType: "json",
              success: function(data){        
                  data = data[0]; 
                 if(data.id){         
                      industry_room_description.val(data.title);                     
                      
                 }else{
                    alert('ไม่มีข้อมูล');
                    industry_room_description.val('');  
                  }//end else
                
                },
              error:function(err){
                  alert('ผิดพลาด');
                  industry_room_description.val(''); 
              },  
              complete:function(){
              }
          })//end ajax function

});//end change

//##################End : SLECTED area type ########################-->


//<!--################## to do chage area type ########################-->
var texture_description = '';
var clear_type_id = '';
$( "select[name='select_texture']" ).change(function() {
  texture_id = $(this).val();
  //alert(texture_id);
  texture_description = $(this).parents("tr").find("input[name='texture_description']");
  clear_type_id = $(this).parents("tr").find("input[name='clear_job_type_id']");
  btn_area  = $(this).parents("tr").find(".add-area");
  btn_area.attr('disabled', true);

   $.ajax({
              type: "GET",
              url: '<?php echo site_url("__ps_quotation/get_texture_by_id");?>'+'/'+texture_id ,
              data: {},
              dataType: "json",
              success: function(data){        
                  data = data[0]; 
                 if(data.material_no){         
                      texture_description.val(data.material_description);  
                      clear_type_id.val(data.clear_type_id);                   
                      
                 }else{
                    alert('ไม่มีข้อมูล');
                    texture_description.val('');  
                  }//end else
                  
                   btn_area.attr('disabled', false);


                },
              error:function(err){
                  alert('ผิดพลาด');
                  texture_description.val(''); 
              },  
              complete:function(){
              }
         })//end ajax function

});//end change

//##################End : SLECTED area type ########################-->




//############################ start : add AREA   ##################################################
$('.add-area').on('click',function(){ 
	var job_type =$("input[name='job_type']").val();//alert(job_type);  
	var building_id =  $(this).parents(".clonedInputBuilding").attr("id");
	var floor_id = $(this).parents(".cloneFloor").attr("id");
	//alert(building_id+' '+floor_id);		

        var area_type = $(this).parents("#"+floor_id).find('.area_type').val();
         //alert(area_type);

        var industry_name = $(this).parents("#"+floor_id).find('.industry_room_description').val();
        //alert(industry_name);


        var area_title = $(this).parents("#"+floor_id).find('.area_title').val();

        //alert(area_title);

        var texture = $(this).parents("#"+floor_id).find('.select_texture').val();
        //alert(texture);

        var texture_name = $(this).parents("#"+floor_id).find('.texture_description').val();
        //alert(texture_name);

         var clear_job_type_id = $(this).parents("#"+floor_id).find('.clear_job_type_id').val();
        //alert(clear_job_type_id);     

        var area_space = $(this).parents("#"+floor_id).find('.area_space').val();
        //alert(area_space);


        if (area_type == undefined || area_type == '' || area_type == 0 
            || industry_name == undefined || industry_name == ''|| industry_name == 0 
          ){
            $(this).parents("#"+floor_id).find('.mag_area').html('กรุณากรอกข้อมูล');
        }

        // if (area_title == undefined || area_title == '' ){
        //     $(this).parents("#"+floor_id).find('.mag_area_title').html('กรุณากรอกข้อมูล');
        // }

         if (texture == undefined || texture == '' || texture == 0 
          || texture_name == undefined || texture_name == '' || texture_name == 0 
          || clear_job_type_id == undefined || clear_job_type_id == ''|| clear_job_type_id == 0 
          ){
            $(this).parents("#"+floor_id).find('.mag_texture').html('กรุณากรอกข้อมูล');
        }

         if (area_space == undefined || area_space == ''  || area_space == 0 ){
            $(this).parents("#"+floor_id).find('.mag_space').html('กรุณากรอกข้อมูล');
        }



        if (texture != undefined && texture != '' && texture != 0 
          && texture_name != undefined && texture_name != '' && texture_name != 0 
          && area_type != undefined && area_type != '' && area_type != 0 
          && industry_name != undefined && industry_name != '' && industry_name != 0 
          && clear_job_type_id != undefined && clear_job_type_id != '' && clear_job_type_id != 0 
          // && area_title != undefined && area_title != ""  
          && area_space != undefined && area_space != '' && area_space != 0) {
          
          //var count = $(this).parents("#"+floor_id).find('.area_table tbody tr').length;
          var count = $(this).parents("#"+floor_id).find(".total_area_tr").val();     
          console.log(floor_id); 
          console.log('count : '+count);

          var row = "<tr class='h5 tx-green count_"+count+"'>";
          		row	+=  "<td></td>";
              row += "<td>"+industry_name;//area_type
	            row += "<input type='hidden' name='area_"+count+"_"+floor_id+"_"+building_id+"_"+"roomID' value='"+area_type+"'>" ;
              row += "<input type='hidden' name='area_"+count+"_"+floor_id+"_"+building_id+"_"+"roomName' value='"+industry_name+"'>" ;
              row += "</td>";
              if(area_title!=""){
              row += "<td>"+area_title;
              }else{
                row += "<td> - ";
              }
	            row += "<input type='hidden' name='area_"+count+"_"+floor_id+"_"+building_id+"_"+"title' value='"+area_title+"'>";
              row += "</td>";
              row += "<td>"+texture_name;//texture
	            row += "<input type='hidden' name='area_"+count+"_"+floor_id+"_"+building_id+"_"+"textureID' value='"+texture+"'>";
              row += "<input type='hidden' name='area_"+count+"_"+floor_id+"_"+building_id+"_"+"textureName' value='"+texture_name+"'>";
              row += "<input type='hidden' name='area_"+count+"_"+floor_id+"_"+building_id+"_"+"clearJobID' value='"+clear_job_type_id+"'>";
              row += "</td>";
              row += "<td>"+area_space;
	            row += "<input type='hidden' name='area_"+count+"_"+floor_id+"_"+building_id+"_"+"space' value='"+area_space+"'>";
              row += "</td>";
              row += "<td>";
              if(job_type=='ZQT1'){
                row += "<span class='col-sm-6' style='padding-left:0px;'><input data-parsley-min ='1'  data-parsley-error-message='<?php echo freetext('required_min'); ?>'' maxlength='2' type='text' onkeypress='return isInt(event)' name='area_"+count+"_"+floor_id+"_"+building_id+"_"+"frequency' class='form-control no-padd' placeholder='clearing'> </span>";
              }
              //row += "<span><a href='#' class='btn btn-default edit_area_btn'><i class='fa fa-pencil'></i></a></span>";
              row += "<span class='margin-left-small'><button type='button' onclick='SomeDeleteRowFunction("+area_space+",this);' class='btn btn-default delete-area'><i class='fa fa-trash-o'></i></button></span>";
              row += "</td>";                   
              row += "</tr>";
                   
           
           //=== Add area to floor == 
             //alert('success');
             $(this).parents("#"+building_id).find("#"+floor_id+" .area_table tbody").append(row);


             //===== start :  TODO set total =====
            var total = $("#total").val();
            total = parseFloat(total);
            area_space = parseFloat(area_space); 
            total =  parseFloat(total+area_space);
            $('#total').val(total);
          //===== end :  TODO set total =====


           //===== start :  TODO set total of floor ===
            var total_of_floor =  $(this).parents("#"+floor_id).find(".total_of_floor").val();//input[name='total_of_floor']
            total_of_floor = parseFloat(total_of_floor);
            area_space = parseFloat(area_space);
            total_of_floor =  parseFloat(total_of_floor+area_space);
            $(this).parents("#"+floor_id).find(".total_of_floor").val(total_of_floor);//"input[name='total_of_floor']"
          //===== end :  TODO set total floor =====


           //===== start :  TODO set total of building ===
            var total_of_building =  $(this).parents("#"+building_id).find(".total_of_building").val();//input[name='totol_of_building']
            total_of_building = parseFloat(total_of_building);
            area_space = parseFloat(area_space); 
            total_of_building =  parseFloat(total_of_building+area_space);
            $(this).parents("#"+building_id).find(".total_of_building").val(total_of_building);//input[name='totol_of_building']
          //===== end :   TODO set total of building ===

         
          
          //===============  SET DATA ===========================
              $('#'+floor_id+' .area_type').val('0');
              $('#'+floor_id+' .select_texture').val('0');
              $('#'+floor_id+' .industry_room_description').val('');
              $('#'+floor_id+' .texture_description').val('');
              $('#'+floor_id+' .clear_job_type_id').val('');
              $('#'+floor_id+' .area_title').val('');
              $('#'+floor_id+' .area_space').val('');

              //set requrie msg ===
               $(this).parents("#"+floor_id).find('.mag_area').html('');
               $(this).parents("#"+floor_id).find('.mag_area_title').html('');
               $(this).parents("#"+floor_id).find('.mag_texture').html('');
               $(this).parents("#"+floor_id).find('.mag_space').html('');


          //=== set total Area ==
          count++;
          //alert(count);
          $(this).parents("#"+floor_id).find(".total_area_tr").val(count);
            
        }else{ //end if
            //alert('ข้อมูลผิดพลาด : อาจกรอกข้อมูลไม่ครบถ้วน');
        }





      });//end click


//############################ END : add AREA   ##################################################

 });//end document



//############################ start : number   ##################################################
 function SomeDeleteRowFunction(area_space,btndel) {

    if (typeof(btndel) == "object") {

      var ele = $(this);
      
        $('#modal-delete-area').modal();
        $('.del_area_confirm').off();
        $('.del_area_confirm').on('click', function () {
          var total_del = $('#total').val();
          //alert(area_space+' '+total_del);      

          //===== start :  TODO set total =====
            total_del = parseFloat(total_del);
            area_space = parseFloat(area_space); 
            total_del =  parseFloat(total_del-area_space);
            $('#total').val(total_del);
          //===== end :  TODO set total =====

          //===== start :  TODO set total of floor ===
              var total_of_floor_del = $(btndel).parents(".cloneFloor").find(".total_of_floor").val();//input[name='total_of_floor']
               //alert(total_of_floor_del);
              total_of_floor_del = parseFloat(total_of_floor_del);
              area_space = parseFloat(area_space); 
              total_of_floor_del =  parseFloat(total_of_floor_del-area_space);
              $(btndel).parents(".cloneFloor").find(".total_of_floor").val(total_of_floor_del);//"input[name='total_of_floor']"
            //===== end :  TODO set total floor =====

             //===== start :  TODO set total of building ===
              var total_of_building_del =  $(btndel).parents(".clonedInputBuilding").find(".total_of_building").val();//"input[name='totol_of_building']"
              total_of_building_del = parseFloat(total_of_building_del);
              area_space = parseFloat(area_space); 
              total_of_building_del =  parseFloat(total_of_building_del-area_space);
              $(btndel).parents(".clonedInputBuilding").find(".total_of_building").val(total_of_building_del);//input[name='totol_of_building']
            //===== end :   TODO set total of building ===

            //remove tr
            $(btndel).closest("tr").remove();
       
        });

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
