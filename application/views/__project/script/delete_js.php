<script type="text/javascript">

var deletePreventionDialog = $('#modal-delete');
    var currentIndexToDelete = undefined;
            function setPreventDelete(title,msg,positiveBtn,negativeBtn,target){
                //console.log('setup function : '+handlerId+' to : > '+target);
                $(target).on('click',function(event){
                    event.preventDefault();
                    deletePreventionDialog.modal('show');
                    //currentEventHandlerId = handlerId;                    
                    currentIndexToDelete = $(this).attr('id');
                    tableToDelete = $(this).attr('main-table');
                    
                    
                    if(negativeBtn !='' && negativeBtn != undefined){
                        deletePreventionDialog.find('.cancel-delete').html(negativeBtn);   
                    }

                    deletePreventionDialog.find('.confirm-delete').on('click',function(){
                         //alert('clicked')
                         if(target=='.commit-delete-btn'){
                         window.location = '<?php echo site_url($this->page_controller."/delete/'+currentIndexToDelete+'/'+tableToDelete+'");?>';
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



  function delete_file_prospect(target){
         

        if(target=='.delete_importance_file'){            
            
            $(target).on('click',function(event){ 
                // alert('delete_importance_file');
                 //alert('test');

                var id =  $(this).attr('id');                 
                var doc_id = $(this).attr('doc-id');
                var doc_type = $(this).attr('doctype');
                

                $('#modal-delete-uploadfile').modal('show');                        
                //alert(project_id+' '+doc_id+' '+asset_id);    

                $('.confirm-delete-file').on('click',function(event){
                  //alert('delete');
                     window.top.location.href = '<?php echo site_url("__ps_project/delete_file_importance")?>'+'/'+id+'/'+doc_id+'/'+doc_type;    
                 });//end click confirm
            });//end click taget
                
        }else{
            
             $(target).on('click',function(event){ 
               // alert('other');
                //alert('test');

                var id =  $(this).attr('id');                 
                var doc_id = $(this).attr('doc-id');
                var doc_type = $(this).attr('doctype');
                

                $('#modal-delete-uploadfile').modal('show');                        
                //alert(project_id+' '+doc_id+' '+asset_id);    

                $('.confirm-delete-file').on('click',function(event){
                  //alert('delete');
                     window.top.location.href = '<?php echo site_url("__ps_project/delete_file_other")?>'+'/'+id+'/'+doc_id+'/'+doc_type;    
                 });//end click confirm
            });//end click taget
        }

    }//Raise dialog           

    delete_file_prospect('.delete_importance_file');
    delete_file_prospect('.delete_other_file');



//################### END :  : DELETE upload file prospect  ##########

        

</script>
