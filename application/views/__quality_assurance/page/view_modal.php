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
                     <textarea id="remark_area" name="remark_area" disabled style="width:500px;height:150px;" placeholder="ใส่ข้อความ" ></textarea>
                  </div>     
                </div>

                <div class='clear:both'></div>
                <div class="modal-footer">
                  <a href="#" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban h5 tx-red"></i> <?php echo freetext('cancel'); ?></a>      
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






