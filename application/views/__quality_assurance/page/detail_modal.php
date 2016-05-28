    <?php
      $track_doc_id = $this->track_doc_id;
      $project_id = $this->project_id;
    ?>

      <div class="modal fade" id="modal-remark">
         <!-- #### remark-->
         
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title"><?php echo freetext('remark');?> </h4>
                </div>
                <div class="modal-body" style='overflow:auto'>              
                 

                  <div class="form-group  col-sm-12">
                     <textarea id="remark_area" name="remark_area"  style="width:500px;height:150px;" placeholder="ใส่ข้อความ" ></textarea>
                  </div>     
                </div>
                <div class='clear:both'></div>
                <div class="modal-footer">
                  <a href="#" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban h5 tx-red"></i> <?php echo freetext('cancel'); ?></a>
                  <button type="submit" class="btn btn-primary" name="save" id="remark_save"><i class="fa fa-save h5"></i> <?php echo freetext('save'); ?></button>                  
                                   
                </div>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->            
      </div>


      <div class="modal fade" id="modal-upload">  
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title"><?php echo freetext('upload');?> </h4>
                </div>
                <div class="modal-body" style='overflow:auto; padding:50px 20px;'> 
                  <form id="upload_form" action="<?php echo site_url('__ps_quality_assurance/upload_image/' ) ?>" method="post" enctype="multipart/form-data">                                                
                    <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
                    <input type="hidden" name="doc_id" value="<?php echo $track_doc_id; ?>">
                    <input type="hidden" name="area_id" value="">
                    <input type="hidden" name="question_no" value="">
                    <div class="form-group row col-sm-12 m-t-md">
                      <div class="col-sm-2">
                        <label class="control-label h5 m-t-xs">File</label>
                      </div>
                      <div class="col-sm-8">
                        <input type="text" autocomplete="off" class="form-control inline file_name" disabled>
                      </div>
                      <div class="col-sm-2">
                        <a class="btn btn-default browse_btn">Browse</a>
                      </div>
                      <input type="file" name="uploadFile" id="fileToUpload" style="display:none;">
                    </div>
                  </form>     
                </div>

                <div class='clear:both'></div>
                <div class="modal-footer" style="margin:0;">
                  <a href="#" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban h5 tx-red"></i> <?php echo freetext('cancel'); ?></a>
                  <a href="#" class="btn btn-primary" name="save" id="upload_btn" disabled><i class="fa fa-save h5"></i> <?php echo freetext('save'); ?></a>                  
                                   
                </div>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->           
      </div>


<div id="myCarousel" class="carousel slide carousel-fit" data-ride="carousel">

  <!-- Wrapper for slides -->
  <div class="carousel-inner">

  </div>

  <!-- Controls -->
  <a class="left carousel-control" href="#myCarousel" data-slide="prev" style="font-size: 3em;color: black;">
    <i class="fa fa-chevron-circle-left"></i>
  </a>
  <a class="right carousel-control" href="#myCarousel" data-slide="next" style="font-size: 3em;color: black; margin-right:15px;">
    <i class="fa fa-chevron-circle-right"></i>
  </a>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body" style="padding:0;">
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<div id="myPrevCarousel" class="carousel slide carousel-fit" data-ride="carousel">

  <!-- Wrapper for slides -->
  <div class="carousel-inner">

  </div>

  <!-- Controls -->
  <a class="left carousel-control" href="#myPrevCarousel" data-slide="prev" style="font-size: 3em;color: black;">
    <i class="fa fa-chevron-circle-left"></i>
  </a>
  <a class="right carousel-control" href="#myPrevCarousel" data-slide="next" style="font-size: 3em;color: black; margin-right:15px;">
    <i class="fa fa-chevron-circle-right"></i>
  </a>
</div>

<div class="modal fade" id="myPrevModal" tabindex="-1" role="dialog" aria-labelledby="myPRevModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo freetext('remark');?> </h4>
      </div>
      <div class="wrapper">
        <textarea class="remark" style="width:100%; height:80px;" disabled></textarea>
      </div>
      <div class="modal-body" style="padding:0;">
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



