<script type="text/javascript">
  $(document).ready(function(){

    /// ================ start :check toggle menu top project ==========
      var click_tiggle =0;
      
      $('.togle-project').on('click',function(){
        //alert(click_tiggle);        
        if(click_tiggle==0){
         //alert(click_tiggle);
          $('.div_detail').addClass("z-index-down");
          $('.icon_project_down').removeClass("text-active");
          $('.icon_project_up').addClass("text-active");
          click_tiggle=1;
        }
        else if(click_tiggle==1){
          //alert(click_tiggle);
          $('.div_detail').removeClass("z-index-down");          
          $('.icon_project_down').addClass("text-active");
          $('.icon_project_up').removeClass("text-active");
          click_tiggle=0;
        } 
      });  

      //toggle customer
      $('.toggle_custotmer').on('click',function(){     
          //alert('custormer');            
         if(click_tiggle==0){
          //alert(click_tiggle);         
          $('.icon_customer_down').removeClass("text-active");
          $('.icon_customer_up').addClass("text-active");  
          click_tiggle=1;
        }
         else if(click_tiggle==1){             
          $('.icon_customer_down').addClass("text-active");
          $('.icon_customer_up').removeClass("text-active");
            click_tiggle=0;
        } 
      });  
      //toggle person
     $('.toggle_person').on('click',function(){     
          //alert('custormer');            
         if(click_tiggle==0){
          //alert(click_tiggle);         
          $('.icon_person_down').removeClass("text-active");
          $('.icon_person_up').addClass("text-active");  
          click_tiggle=1;
        }
         else if(click_tiggle==1){             
          $('.icon_person_down').addClass("text-active");
          $('.icon_person_up').removeClass("text-active");
            click_tiggle=0;
        } 
      });  

      //toggle document
     $('.toggle_doc').on('click',function(){     
          //alert('custormer');            
         if(click_tiggle==0){
          //alert(click_tiggle);         
          $('.icon_doc_down').removeClass("text-active");
          $('.icon_doc_up').addClass("text-active");  
          click_tiggle=1;
        }
         else if(click_tiggle==1){             
          $('.icon_doc_down').addClass("text-active");
          $('.icon_doc_up').removeClass("text-active");
            click_tiggle=0;
        } 
      });  


      //toggle document
     $('.toggle_chemicals').on('click',function(){     
          //alert('custormer');            
         if(click_tiggle==0){
          //alert(click_tiggle);         
          $('.icon_chemicals_down').removeClass("text-active");
          $('.icon_chemicals_up').addClass("text-active");  
          click_tiggle=1;
        }
         else if(click_tiggle==1){             
          $('.icon_chemicals_down').addClass("text-active");
          $('.icon_chemicals_up').removeClass("text-active");
            click_tiggle=0;
        } 
      });  

      //toggle document
     $('.toggle_clear_chemicals').on('click',function(){     
          //alert('custormer');            
         if(click_tiggle==0){
          //alert(click_tiggle);         
          $('.icon_clear_chemicals_down').removeClass("text-active");
          $('.icon_clear_chemicals_up').addClass("text-active");  
          click_tiggle=1;
        }
         else if(click_tiggle==1){             
          $('.icon_clear_chemicals_down').addClass("text-active");
          $('.icon_clear_chemicals_up').removeClass("text-active");
            click_tiggle=0;
        } 
      });  


       //toggle machines
     $('.toggle_machines').on('click',function(){     
          //alert('custormer');            
         if(click_tiggle==0){
          //alert(click_tiggle);         
          $('.icon_machines_down').removeClass("text-active");
          $('.icon_machines_up').addClass("text-active");  
          click_tiggle=1;
        }
         else if(click_tiggle==1){             
          $('.icon_machines_down').addClass("text-active");
          $('.icon_machines_up').removeClass("text-active");
            click_tiggle=0;
        } 
      });  

       //toggle machines
     $('.toggle_tool').on('click',function(){     
          //alert('custormer');            
         if(click_tiggle==0){
          //alert(click_tiggle);         
          $('.icon_tool_down').removeClass("text-active");
          $('.icon_tool_up').addClass("text-active");  
          click_tiggle=1;
        }
         else if(click_tiggle==1){             
          $('.icon_tool_down').addClass("text-active");
          $('.icon_tool_up').removeClass("text-active");
            click_tiggle=0;
        } 
      });  

    /// ================ end :check toggle menu top project ==========
});



</script>