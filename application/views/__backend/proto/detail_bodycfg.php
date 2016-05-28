

          <section class="vbox">
            <section class="scrollable padder">
              <ul class="breadcrumb no-border no-radius b-b b-light pull-in">
                <li><a href="index.html"><i class="fa fa-home"></i> Home</a></li>
                <li><a href="#">UI kit</a></li>
                <li><a href="#">Form</a></li>
                <li class="active">Elements</li>
              </ul>
              

              <div class="row">
                <!-- start : form -->
                <form action='<?php echo site_url($this->page_controller.'/saveDetail'); #CMS?>' method="POST">
                <div class="col-sm-12">
                  <section class="panel panel-default">
                  <!-- <button style='margin:4px 4px 0px 0px' class='pull-right btn-sm btn-primary btn'>Save</button> -->
                    <header class="panel-heading font-bold">Basic form</header>
                    <?php //echo '<pre>';print_r($content);echo '</pre>'; ?>
                    <?php //echo '<pre>';print_r($config['detailview']);echo '</pre>'; ?>
                    
                    <div class="panel-body">
                        <?php 
                          $render_options = array('class'=>' col-sm-6 ');

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
                         
                          

                        ?>
                        <button type="submit" class="pull-right btn-sm btn-primary btn">Submit</button>
                    </div>
                  </section>
                </div>

                <input type='hidden' value='<?php echo $content["id"]; ?>' name='id'> 
                <input type='hidden' value='<?php echo $this->session->userdata("current_url"); ?>' name='callback_url' >
                <input type='hidden' value='edit' name='act'> 
                <input type='hidden' value='<?php echo $category;?>' name='category'> 
    

                </form>
                <!-- end : form -->
              </div>
             
            </section>
          </section>
          <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
        