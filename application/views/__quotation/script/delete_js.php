<script type="text/javascript">

var deletePreventionDialog = $('#modal-delete');
    var currentIndexToDelete = undefined;
            function setPreventDelete(title,msg,positiveBtn,negativeBtn,target){
                //console.log('setup function : '+handlerId+' to : > '+target);
                $(target).on('click',function(event){                   
                    var doc_type = $(this).attr('doctype');
                    event.preventDefault();
                    deletePreventionDialog.modal('show');
                    //currentEventHandlerId = handlerId;                    
                    currentIndexToDelete = $(this).attr('id');                  
                    
                    
                    if(negativeBtn !='' && negativeBtn != undefined){
                        deletePreventionDialog.find('.cancel-delete').html(negativeBtn);   
                    }

                    deletePreventionDialog.find('.confirm-delete').on('click',function(){
                         //alert('clicked')
                         if(target=='.commit-delete-btn'){
                         window.location = '<?php echo site_url($this->page_controller."/delete/'+doc_type+'/'+currentIndexToDelete+' ");?>';
                        }
                         if(target=='.group-delete-button'){  
                            $('input[name="delete"]').trigger('click');
                        }
                    
                    })

                });

            }
            //Raise dialog           

           setPreventDelete('','','','','.commit-delete-btn');
           setPreventDelete('','','','','.group-delete-button');

        
//################### start : DELETE upload file prospect  ##########

    function delete_file_prospect(target){
          

        if(target=='.delete_importance_file'){            
            
            $(target).on('click',function(event){ 
                // alert('delete_importance_file');

                var id =  $(this).attr('id');                 
                var doc_id = $(this).attr('doc-id');
                var doc_type = $(this).attr('doctype');
                

                $('#modal-delete-uploadfile').modal('show');                        
                //alert(project_id+' '+doc_id+' '+asset_id);    

                $('.confirm-delete-file').on('click',function(event){
                  //alert('delete');
                     window.top.location.href = '<?php echo site_url("__ps_quotation/delete_file_importance")?>'+'/'+id+'/'+doc_id+'/'+doc_type;    
                 });//end click confirm
            });//end click taget
                
        }else{
            
             $(target).on('click',function(event){ 
               // alert('other');

                var id =  $(this).attr('id');                 
                var doc_id = $(this).attr('doc-id');
                var doc_type = $(this).attr('doctype');
                

                $('#modal-delete-uploadfile').modal('show');                        
                //alert(project_id+' '+doc_id+' '+asset_id);    

                $('.confirm-delete-file').on('click',function(event){
                  //alert('delete');
                     window.top.location.href = '<?php echo site_url("__ps_quotation/delete_file_other")?>'+'/'+id+'/'+doc_id+'/'+doc_type;    
                 });//end click confirm
            });//end click taget
        }

    }//Raise dialog           

    delete_file_prospect('.delete_importance_file');
    delete_file_prospect('.delete_other_file');



//################### END :  : DELETE upload file prospect  ##########


        
//################### start : DELETE contract other  ##########

    function delete_contract(target){      
                      
        $(target).on('click',function(event){ 
            // alert('delete_importance_file');

            var id =  $(this).attr('id');                 
            var doc_id = $(this).attr('doc-id');
            var doc_type = $(this).attr('doc-type');
            

            

            $('#modal-delete-contact').modal('show');                        
            //alert(project_id+' '+doc_id+' '+asset_id);    

            $('.confirm-delete-contact').on('click',function(event){
              //alert('delete');
                 window.top.location.href = '<?php echo site_url("__ps_quotation/delete_contact")?>'+'/'+id+'/'+doc_id+'/'+doc_type;    
             });//end click confirm
        });//end click taget
                

    }//Raise dialog           

    delete_contract('.delete_other_contact');



//################### END :  : DELETE contract other ##########



//################### start : DELETE contract other  ##########

    function delete_contract_service(target){      
                      
        $(target).on('click',function(event){ 
            // alert('delete_importance_file');

            var id =  $(this).attr('id');                 
            var doc_id = $(this).attr('doc-id');
                    

            

            $('#modal-delete-other-service').modal('show');                        
            //alert(project_id+' '+doc_id+' '+asset_id);    

            $('.confirm-delete-service').on('click',function(event){
              //alert('delete');
                 window.top.location.href = '<?php echo site_url("__ps_quotation/delete_contact_service")?>'+'/'+id+'/'+doc_id;    
             });//end click confirm
        });//end click taget
                

    }//Raise dialog           

    delete_contract_service('.delete_other_contact_service');



//################### END :  : DELETE contract other ##########











</script>
