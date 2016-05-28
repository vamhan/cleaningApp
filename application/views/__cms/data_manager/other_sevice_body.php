<!-- start : content -->
<section class="vbox">
  <section class="scrollable padder">
    <ul class="breadcrumb no-border no-radius b-b b-light pull-in">
      <li><a href="index.html"><i class="fa fa-home"></i> DOC OTHER SEVICE อัพโหลดไฟล์รายละเอียดการบริการ</a></li>
    </ul>
    <section class="panel panel-default">
      <header class="panel-heading">
        <?php echo $this->page_title; ?>                  
      </header>
      <div class="table-responsive">
        <table id="user_permission_table" class="table table-striped datagrid m-b-sm">
          <thead>
            <tr>
              <th colspan="7">
                <div class="row">
                  <div class="col-sm-8 m-t-xs m-b-xs pull-right text-right">
                    <div class="input-group search datagrid-search">
                      <div class="input-group-btn">
                        <button class="btn btn-primary btn-sm" data-cms-action="create" data-toggle="modal" data-target="#upload_file_other"><i class="fa fa-plus-circle"></i>&nbsp;&nbsp;อัพโหลดไฟล์</button>
                      </div>
                    </div>
                  </div>
                  <?=form_open('__cms_data_manager/doc_otherservice_management/');?>
                  <div class="col-sm-4 m-t-xs m-b-xs">
                    <div class="input-group search datagrid-search">
                      <input type="text" autocomplete="off" class="input-sm form-control" name="search" id="search" placeholder="Search">
                      <div class="input-group-btn">
                        <button class="btn btn-default btn-sm" ><i class="fa fa-search"></i></button>
                      </div>                          
                    </div>
                  </div>
                  <?=form_close();?>                      
                </div>
              </th>
            </tr>
            <tr>
              <th class="table-head">ภาษา</th>
              <th class="table-head">ชื่อเอกสาร</th>
              <th class="table-head">วันที่อัพโหลด</th>
              <th class="table-head">ประเภทธุรกิจ</th>
              <th class="table-head"></th>
            </tr>
          </thead>
          <tbody>
          <?php
            if (!empty($doc_list['th']) && !empty($doc_list['en'])) {
              if (!empty($doc_list['th'])) {
                foreach ($doc_list['th'] as $key => $doc_obj) {

                  //get path
                  $this->db->select('sap_tbm_industry.title');
                  $this->db->where('sap_tbm_industry.id', $doc_obj['industry_id']);
                  $query = $this->db->get('sap_tbm_industry');
                  $query_industry = $query->row_array();
                  $industry_title = $query_industry['title']; 
            ?>
                <tr>
                  <td>TH</td>
                  <td><?php echo $doc_obj['description']; ?></td>
                  <td><?php echo $doc_obj['create_date']; ?></td>
                  <td><?php echo $industry_title; ?></td>
                  <td class="text-right">
                  <a  href='<?php echo site_url($doc_obj['path']);?>' target="_blank" data-toggle="modal" class="btn btn-default" type="button"><i class="fa fa-expand h5"></i> <?php echo freetext('view'); //View?></a>
                  <a href='<?php echo site_url($doc_obj['path']);?>'  download="<?php echo site_url($doc_obj['description']);?>" class="btn btn-default  margin-left-small" type="button"><i class="fa fa-download"></i> <?php echo freetext('download'); //Download?></a>                  
                  <a class="btn btn-default delete_file_btn margin-left-small" type="button" id="<?php echo $doc_obj['id']; ?>" ><i class="fa fa-trash-o"></i> <?php echo freetext('delete'); ?></a>
                  </td>
                </tr>
            <?php
                }
              }
              if (!empty($doc_list['en'])) {
                foreach ($doc_list['en'] as $key => $doc_obj) {

                  //get path
                  $this->db->select('sap_tbm_industry.title');
                  $this->db->where('sap_tbm_industry.id', $doc_obj['industry_id']);
                  $query = $this->db->get('sap_tbm_industry');
                  $query_industry = $query->row_array();
                  $industry_title = $query_industry['title']; 
            ?>
                <tr>
                  <td>EN</td>
                  <td><?php echo $doc_obj['description']; ?></td>
                  <td><?php echo $doc_obj['create_date']; ?></td>
                  <td><?php echo $industry_title; ?></td>
                  <td class="text-right">
                  <a  href='<?php echo site_url($doc_obj['path']);?>' target="_blank" data-toggle="modal" class="btn btn-default" type="button"><i class="fa fa-expand h5"></i> <?php echo freetext('view'); //View?></a>
                  <a href='<?php echo site_url($doc_obj['path']);?>'  download="<?php echo site_url($doc_obj['description']);?>" class="btn btn-default  margin-left-small" type="button"><i class="fa fa-download"></i> <?php echo freetext('download'); //Download?></a>                  
                  <a class="btn btn-default delete_file_btn margin-left-small" type="button" id="<?php echo $doc_obj['id']; ?>" ><i class="fa fa-trash-o"></i> <?php echo freetext('delete'); ?></a>
                  </td>
                </tr>
            <?php
                }
              }
            } else {
          ?>
              <tr><td class="text-center" colspan="2">Empty</td></tr>
          <?php
            }
          ?>
          </tbody>
        </table>
      </div>
    </section>
  </section>
</section>
<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>  