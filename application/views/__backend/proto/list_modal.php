 <!--Start: modal add new category -->
 <div class="modal fade" id="modal-form">
 	<form action='<?php echo site_url($this->page_controller.'/saveDetail'); #CMS?>' method="POST">
 		<div class="modal-dialog">
 			<div class="modal-content">
 				<div class="modal-header">
 					<button type="button" class="close" data-dismiss="modal">&times;</button>
 					<h4 class="modal-title"><?php echo 'New '.$this->page_object;#CMS ?> </h4>
 				</div>
 				<div class="modal-body" style='overflow:auto'>
 					<!--  #CMS  -->
 			
 					<?php if( isset($config) && array_key_exists('listview', $config)){ 
            // var_dump(json_encode($config['detailview']));
 						      //set blank content
                  $render_options = array('class'=>' col-sm-6 ');
                   $content = array();

                          foreach ($config['detailview'] as $key => $value) {
                            switch ($value['validation']) {
                              case 'text':
                              case 'number_alphabet':
                              case 'email':
                              case 'phone_no':
                              case 'number':
                                  echo ui_text_render($value,$content,$render_options);
                                break;
                                  
                              case 'dropdown':
                                  echo ui_dropdown_render($value,$content,$value['content_list'],$render_options);
                                break;
                              default:
                                # code...
                                break;
                            }//end switch 
                         }//end foreach
                         

 					} ?>



               
                      </div>

                      <div class='clear:both'></div>
                      <div class="modal-footer">
                      	<a href="#" class="btn btn-default" data-dismiss="modal">Close</a>

                      	<input type='hidden' value='<?php echo $this->session->userdata("current_url"); ?>' name='callback_url' >
                      	<input type='hidden' value='create' name='act'> 
 						             <input type='hidden' value='<?php echo $category;?>' name='category'> 
 		
                      	<input type='submit' class="btn btn-primary" value="Save">
                      </div>
                  </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
          </form>
      </div>
