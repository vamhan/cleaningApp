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
    /// ================ end :check toggle menu top project ==========
});



</script>