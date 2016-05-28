<script type="text/javascript">
$(document).ready(function(){



 var first_count_other = '';
 //first_count_other = $("#other").find('.table_other_contracts tbody tr').length;
first_count_other = $("#other").find('.other_contracts_id').length;
 $("#other").find('#first_conut_other').val(first_count_other);
//############################ start : add oter contacts  ##################################################
$('.add_oter_contracts').on('click',function(){
 // alert('click');

         var contact_title = $(this).parents("tfoot").find("select[name='contact_title']").val();
        //alert(contact_title);

         var other_fist_name = $(this).parents("tfoot").find("input[name='other_fist_name']").val();
        // alert(other_fist_name);


        var other_last_name = $(this).parents("tfoot").find("input[name='other_last_name']").val();
        //alert(other_last_name);

        var other_function = $(this).parents("tfoot").find("select[name='other_function']").val();
        //alert(other_function);    
        var other_function_name = other_function;
        var res = other_function_name.split("|");
        //alert(res[1]);


        var other_department = $(this).parents("tfoot").find("select[name='other_department']").val();
        //alert(other_function);    
        var other_department_name = other_department;
        var res_department = other_department_name.split("|");
        //alert(res_department[1]+' '+res_department[0]);

        

        var other_tel = $(this).parents("tfoot").find("input[name='other_tel']").val();
        //alert(other_tel);

        var other_tel_ext = $(this).parents("tfoot").find("input[name='other_tel_ext']").val();
        //alert(other_tel_ext);

        var other_fax = $(this).parents("tfoot").find("input[name='other_fax']").val();
        //alert(other_fax);

        var other_fax_ext = $(this).parents("tfoot").find("input[name='other_fax_ext']").val();
        //alert(other_fax_ext);

        var other_mobile_no = $(this).parents("tfoot").find("input[name='other_mobile_no']").val();
       // alert(other_mobile_no);

        var other_email = $(this).parents("tfoot").find("input[name='other_email']").val();
       // alert(other_email);     

        
      if (contact_title == undefined || contact_title == '' || contact_title == 0 ){
            $('.text_msg_title').html('กรุณากรอกข้อมูล');
       }
    
       if (other_fist_name == undefined || other_fist_name == '' || other_fist_name == 0 ){
            $('.text_msg1').html('กรุณากรอกข้อมูล');
       }

        if (other_last_name == undefined || other_last_name == '' || other_last_name == 0 ){
            $('.text_msg2').html('กรุณากรอกข้อมูล');
       }

        if (other_function == undefined || other_function == '' || other_function == 0 ){
            $('.text_msg3').html('กรุณากรอกข้อมูล');
       }

       if(other_tel==undefined || other_tel==''||other_tel==0){

        if (other_mobile_no == undefined || other_mobile_no == '' || other_mobile_no == 0 ){
            $('.text_msg5').html('กรุณากรอกข้อมูล');
        }

       }

       //  if (other_email == undefined || other_email == '' || other_email == 0 ){
       //      $('.text_msg6').html('กรุณากรอกข้อมูล');
       // }


       // if (other_tel == undefined || other_tel == '' || other_tel == 0 ){
       //      $('.text_msg7').html('กรุณากรอกข้อมูล');
       // }

       //  if (other_tel_ext == undefined || other_tel_ext == '' || other_tel_ext == 0 ){
       //      $('.text_msg8').html('กรุณากรอกข้อมูล');
       // }

       //  if (other_fax == undefined || other_fax == '' || other_fax == 0 ){
       //      $('.text_msg9').html('กรุณากรอกข้อมูล');
       // }

       // if (other_fax_ext == undefined || other_fax_ext == '' || other_fax_ext == 0 ){
       //      $('.text_msg10').html('กรุณากรอกข้อมูล');
       // }


       if (other_department == undefined || other_department == '' || other_department == 0 ){
            $('.text_msg11').html('กรุณากรอกข้อมูล');
       }


       //=== check  email ========
       if(other_email!=''){
          var emailFilter=/^.+@.+\..{2,3}$/;
          var str = other_email;
           if(!(emailFilter.test(str))){
             $('.text_msg_email').html('(อีเมลล์ไม่ถูกต้อง)');
             return;
           }
        }
      
       // other_position != undefined && other_position != '' && other_position != 0 &&

       if(   other_mobile_no != '' || other_tel != '' ){

        if (other_fist_name != undefined && other_fist_name != '' && other_fist_name != 0 && 
            contact_title != undefined && contact_title != '' && contact_title != 0 && 
            other_last_name != undefined && other_last_name != '' && other_last_name != 0 &&
            other_function != undefined && other_function != '' && other_function != 0 &&  
            other_department != undefined && other_department != '' && other_department != 0          
           
            
             //&&  other_mobile_no != undefined && other_mobile_no != '' && other_mobile_no != 0 
            //other_email != undefined && other_email != '' && other_email != 0 
            // other_tel != undefined && other_tel != '' && other_tel != 0 && 
            // other_tel_ext != undefined && other_tel_ext != '' && other_tel_ext != 0 &&   
            // other_fax != undefined && other_fax != '' && other_fax != 0 && 
            // other_fax_ext != undefined && other_fax_ext != '' && other_fax_ext != 0 && 

            ){
          
          // var count = $(this).parents("#other").find('.table_other_contracts tbody tr').length;
          // count++;  
         // alert('count : '+count);


         if($("#count_other_contract").val()==0){
            var count = $(this).parents("#other").find('.other_contracts_id').length;
            count++;        
          }else{
            var count = $("#count_other_contract").val();
            count++;
          }  


          var row = "<tr class='other_contracts_id count_"+count+"'>" +
                       "<td>" +
                        contact_title+' '+other_fist_name+' '+other_last_name+
                        "<input type='hidden' name='contract_"+count+"_"+"fistname' value='"+other_fist_name+"'>" +
                        "<input type='hidden' name='contract_"+count+"_"+"title' value='"+contact_title+"'>" +
                        "<input type='hidden' name='contract_"+count+"_"+"lastname' value='"+other_last_name+"'>" +
                      "</td>"+

                      //  "<td>" +
                      //   other_last_name+
                      //   "<input type='hidden' name='contract_"+count+"_"+"lastname' value='"+other_last_name+"'>" +
                      // "</td>"+

                       "<td>" +
                        res[1]+
                        "<input type='hidden' name='contract_"+count+"_"+"function' value='"+res[0]+"'>" +
                      "</td>"+

                      "<td>" +
                        res_department[1]+
                        "<input type='hidden' name='contract_"+count+"_"+"department' value='"+res_department[0]+"'>" +
                      "</td>"+

                       "<td>" +
                        other_tel+
                        "<input type='hidden' name='contract_"+count+"_"+"tel' value='"+other_tel+"'>" +
                      "</td>"+

                       "<td>" +
                        other_tel_ext+
                        "<input type='hidden' name='contract_"+count+"_"+"tel_ext' value='"+other_tel_ext+"'>" +
                      "</td>"+

                       "<td>" +
                        other_fax+
                        "<input type='hidden' name='contract_"+count+"_"+"fax' value='"+other_fax+"'>" +
                      "</td>"+

                       "<td>" +
                        other_fax_ext+
                        "<input type='hidden' name='contract_"+count+"_"+"fax_ext' value='"+other_fax_ext+"'>" +
                      "</td>"+



                       "<td>" +
                        other_mobile_no+
                        "<input type='hidden' name='contract_"+count+"_"+"mobile' value='"+other_mobile_no+"'>" +
                      "</td>"+

                       "<td>" +
                        other_email+
                        "<input type='hidden' name='contract_"+count+"_"+"email' value='"+other_email+"'>" +
                      "</td>"+                     

                      "<td>" +                      
                        "<span class='margin-left-small'><button type='button' onclick='DeleteRowothercontract(this);' class='btn btn-default delete-area'><i class='fa fa-trash-o'></i></button></span>"+
                      "</td>"+  

                    "</tr>";
                   
          //alert('success'+first_count_other);
           $(this).parents("#other").find("#count_other_contract").val(count);
           $(".empty_other_contact").hide();

           $(this).parents(".table_other_contracts").find("tbody").append(row);
          
          
          $('tr .other_fist_name').val('');
          $('tr .other_last_name').val('');
          $('tr .contact_title').val(0);
          $('tr .other_function').val(0);
          $('tr .other_department').val(0);
          $('tr .other_tel').val('');
          $('tr .other_tel_ext').val('');
          $('tr .other_fax').val('');
          $('tr .other_fax_ext').val('');
          $('tr .other_mobile_no').val('');
          $('tr .other_email').val('');

          $('.text_msg_title').html('');
          $('.text_msg1').html('');
          $('.text_msg2').html('');
          $('.text_msg3').html('');
          //$('.text_msg4').html('');
          $('.text_msg5').html('');
          $('.text_msg6').html('');
          $('.text_msg7').html('');
          $('.text_msg8').html('');
          $('.text_msg9').html('');
          $('.text_msg10').html('');
          $('.text_msg11').html('');
          $('.text_msg_email').html('');

        
        }else{ //end if
           // alert('กรุณากรอกข้อมูลให้ครบถ้วน');
        }

      }

        //set total Area 
         $(this).parents("#"+floor_id).find(".total_area_tr").val(count);

      });//end click

  //====== DELETE : building ==============
    $(".btn_delete_add_other").on('click',function(){  
      alert('delete');
        $(this).parents("tr").remove();
    });
//############################ END : add oter contacts   ##################################################









})// end document

</script>