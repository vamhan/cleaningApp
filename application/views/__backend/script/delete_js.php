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

        

</script>
