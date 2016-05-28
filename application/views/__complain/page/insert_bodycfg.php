<style type="text/css">
.dt_header{
display: none  !important;
}

.dt_footer .row-fluid{
display: none  !important;
}
.scrollable{
  padding-bottom: 350px;
}
</style>
<?php  
if($this->contract_id!=0){

//query tbt_quotation filed shop_to
$this->db->select('tbt_quotation.*');
$this->db->where('tbt_quotation.contract_id', $this->contract_id);
$query_data_qt = $this->db->get('tbt_quotation');          
$data_qt = $query_data_qt->row_array(); 
//foreach($query_data_customer->result_array() as $value){
$qt_ship_to_id = $data_qt['ship_to_id'];
//echo "<br>".$qt_ship_to_id;

//-== query ship_to_id =====
$this->db->select('sap_tbm_ship_to.*');
$this->db->where('sap_tbm_ship_to.id', $qt_ship_to_id);
$query_ship_to = $this->db->get('sap_tbm_ship_to');          
$data_ship_to = $query_ship_to->row_array(); 

$data_ship_to_name1 = $data_ship_to['ship_to_name1'];
$data_ship_to_distribution_channel = $data_ship_to['ship_to_distribution_channel'];
$data_ship_to_branch_id = $data_ship_to['ship_to_branch_id'];
$data_ship_to_branch_des = $data_ship_to['ship_to_branch_des'];
$data_ship_to_city = $data_ship_to['ship_to_city'];
$data_plant_code = $data_ship_to['plant_code'];
$data_plant_name = $data_ship_to['plant_name'];
$data_examiner_id = $data_ship_to['ins_id'];
$data_examiner_name = $data_ship_to['ins_name'];

}else{

$data_ship_to_name1 = '';
$data_ship_to_distribution_channel = '';
$data_ship_to_branch_id = '';
$data_ship_to_branch_des = '';
$data_ship_to_city = '';
$data_plant_code = '';
$data_plant_name = '';
$data_examiner_id = '';
$data_examiner_name = '';



}//end else

?>




<div class="div_detail">
<form action='<?php echo site_url($this->page_controller.'/insert_complain'); ?>' method="POST" data-parsley-validate  enctype="multipart/form-data"> 
<input type="hidden" name="contract_id" class="form-control" readonly="readonly" value="<?php echo $this->contract_id; ?>">


<section class="panel panel-default "> 
<div class="panel panel-heading back-color-gray">                  
	เพิ่ม : <?php echo freetext('complain'); ?>        
</div> 
<div class="panel-body"> 
<div class="form-group">

<!-- start : input group -->  
  <div class="col-sm-12 no-padd"> 
    <!-- <div class="col-md-6">
         <label class="col-sm-3 control-label"><?php //echo freetext('Method'); ?></label>
		 <div class="col-sm-9">
		    <div class="col-sm-4">
		      <label>
		        <input type='radio' name='input_method' class="Method email" value='email' checked='checked'>
		        <?php// echo freetext('email'); //No have serial code?>                            
		      </label>
		    </div>
		    <div class="col-sm-4"> 
		      <label >
		       <input type='radio' name='input_method' class="Method telephone" value='telephone'>
		        <?php //echo freetext('telephone'); //No have serial code?>                            
		      </label>
		    </div>		    
		 </div>    
    </div>   -->

      <div class="col-md-6">
         <div class="input-group m-b">
           <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('Method').'</font></div>'; ?></span>
           <!--  <input type="hidden" readonly class="form-control" name="problem_type_title" value=""> -->
            <select data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>"  class="select2  form-control  no-padd h6" name="input_method" id="input_method" style="height:31px;">
              <option value="" >กรุณาเลือก</option>
              <?php 
                $temp_type_complain = $master_type_complain->result_array();
                if(!empty($temp_type_complain)){   
                foreach($master_type_complain->result_array() as $value){ 
             ?>
                <option  value='<?php echo $value['id'] ?>'><?php echo $value['title']; ?></option> 
            <?php }//end foreach
               }else{ ?>
                 <option value='0'>ไม่มีข้อมูล</option> 
            <?php } ?>          
          </select>  
        </div>
        </div>                    

      <div class="col-md-6">
        <div class="input-group m-b">
           <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('create_date').'</font></div>'; ?></span>
             <input type="text" autocomplete="off" readonly class="form-control"  value="<?php echo date('d.m.Y'); ?>"/>
             <input type="hidden" class="form-control" name="create_date" value="<?php echo date('Y-m-d')?>"/>
        </div>
      </div>
  </div> 
<!-- end : input group --> 
<?php

//query sap_tbm_contact
$this->db->select('tbt_user.user_firstname,tbt_user.user_lastname');
$this->db->where('tbt_user.employee_id', $this->session->userdata('id'));
$query_data_customer = $this->db->get('tbt_user');          
$data_customer = $query_data_customer->row_array(); 
//foreach($query_data_customer->result_array() as $value){
$raise_name = $data_customer['user_firstname'];
$raise_lastname = $data_customer['user_lastname'];
?>
<!-- start : input group -->  
  <div class="col-sm-12 no-padd"> 
       <div class="col-md-6">
         <div class="input-group m-b">
            <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('raise_by_id').'</font></div>'; ?></span>
            <input  type="hidden" readonly autocomplete="off" name="raise_by_id" class="form-control raise_by_id"   value="<?php echo $this->session->userdata('id');  ?>" >
            <input  type="text" readonly autocomplete="off" name="nameuser" class="form-control nameuser"   value="<?php echo $raise_name.' '.$raise_lastname; ?>" >
        </div>
      </div>                     

      <div class="col-md-6">
        <div class="input-group m-b">
           <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('plant').'</font></div>'; ?></span>

<?php if($this->contract_id==0){  ?> 
<input readonly type="hidden" autocomplete="off" name="plant_name" class="form-control plant_name"  value="">
<?php 
$array_plant = array();
$temp_bapi_ship_to = $bapi_ship_to->result_array();
if(!empty($temp_bapi_ship_to)){   
foreach($bapi_ship_to->result_array() as $value){ 
  if(!empty($value['plant_code'])){
      if (in_array( $value['plant_code'], $array_plant, TRUE)){                
        //echo "have";
      }else{
          //echo "nohave";
          //array_push($texture,$value['texture_id']);
          $array_plant[$value['plant_code']] = $value['plant_name']; 
      }//end else  
  }//end if check plant_code
}//end foreach
}//end if
?>
<select  <?php if($this->contract_id!=0){ echo "disabled"; } ?>  data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>" class="select2  form-control  no-padd h6 plant_code" name="plant_code" style="height:31px;">
<option value="" >กรุณาเลือก</option>
 <?php 
  if(!empty($array_plant)){
  foreach($array_plant as $a => $a_value) {
 ?>
  <option  value='<?php echo $a; ?>'><?php echo $a_value; ?></option> 
 <?php           
  }//end foreach
  }else{ 
?>
  <option value=''>ไม่มีข้อมูล</option> 
<?php }//end else ?>
</select> 

<?php }else{ ?>
<input readonly type="text" autocomplete="off" name="plant_name" class="form-control plant_name"  value="<?php echo $data_plant_name;?>">
<input readonly type="hidden" autocomplete="off" name="plant_code" class="form-control plant_code"  value="<?php echo $data_plant_code;?>">
<?php }//end else ?>

        </div>
      </div>
  </div> 
<!-- end : input group --> 


<!-- start : input group -->  
  <div class="col-sm-12 no-padd">                    

      <div class="col-md-6">
        <div class="input-group m-b">
           <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('ship_to_id').'</font></div>'; ?></span>
           	<select  <?php if($this->contract_id==0){ echo "disabled"; } ?>   data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>" class="select2  form-control   no-padd h6 ship_to_id" name="ship_to_id" id="ship_to_id" style="width:435px; height:31px;">
           	<!-- <select  name='ship_to_id' class='form-control' id="ship_to_id"> -->
        	     <option value="" >กรุณาเลือก</option>
            <?php 
                $temp_bapi_ship_to = $bapi_ship_to->result_array();
                if(!empty($temp_bapi_ship_to)){   
                foreach($bapi_ship_to->result_array() as $value){
                if($value['ship_to_id'] == $qt_ship_to_id ){ 
             ?>
                <option <?php if( $value['ship_to_id'] == $qt_ship_to_id ){ echo "selected='selected'";} ?>   value='<?php echo $value['ship_to_id'] ?>'><?php echo $value['ship_to_id'].' '.$value['ship_to_name1'] ?></option> 
            <?php 
                  }//end if
                  }//end foreach
               }else{ ?>
                 <option value='0'>ไม่มีข้อมูล</option> 
            <?php } ?>
         	</select>  
        </div>
      </div>

       <div class="col-md-6">
         <div class="input-group m-b">
           <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('ship_to_name').'</font></div>'; ?></span>
          <input  type="text" readonly autocomplete="off" name="ship_to_name" class="form-control ship_to_name"   value="<?php echo $data_ship_to_name1;?>" >
        </div>
      </div>    

  </div> 
<!-- end : input group --> 



<!-- start : input group -->  
  <div class="col-sm-12 no-padd">                       

       <div class="col-md-6">
         <div class="input-group m-b">
           <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('distribution_channel').'</font></div>'; ?></span>
          <input  type="text" readonly autocomplete="off" name="ship_to_distribution_channel" class="form-control ship_to_distribution_channel"   value="<?php echo $data_ship_to_distribution_channel;?>" >
        </div>
      </div>   

      <div class="col-md-6">
        <div class="input-group m-b">
           <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('ship_to_branch').'</font></div>'; ?></span>
            <input readonly type="hidden" autocomplete="off" name="ship_to_branch_id" class="form-control ship_to_branch_id"  value="<?php echo $data_ship_to_branch_id;?>" >
            <input readonly type="text" autocomplete="off" name="ship_to_branch_des" class="form-control ship_to_branch_des"  value="<?php echo $data_ship_to_branch_des;?>" >
        </div>
      </div>

  </div> 
<!-- end : input group --> 


<!-- start : input group -->  
  <div class="col-sm-12 no-padd">  
      
      <div class="col-md-6">
        <div class="input-group m-b">
           <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('ship_to_city').'</font></div>'; ?></span>
            <input readonly type="text" autocomplete="off" name="ship_to_city" class="form-control ship_to_city"  value="<?php echo $data_ship_to_city;?>" >
        </div>
      </div>

      <div class="col-md-6">
        <div class="input-group m-b">
           <span  class="input-group-addon">
            <div class="label-width-adon">
            </div>
            <font class="pull-left">
            <input disabled type="checkbox" id="is_contact_db" name="is_contact_db"  value="1" class="is_contact_db">
            <?php echo freetext('customer_id'); ?>
            </font>
           
          </span>
           	<select <?php if($this->contract_id==0){ echo "disabled"; } ?>  class="select2  form-control  no-padd h6" name="customer_id" id="customer_id"  style="height:31px;">
           	<!-- <select  name='ship_to_id' class='form-control' id="ship_to_id"> -->
        	   <option value="" >กรุณาเลือก</option> 
              <?php 
                $this->db->select('sap_tbm_contact.*');
                $this->db->where('sap_tbm_contact.ship_to_id', $qt_ship_to_id);
                $query_customer = $this->db->get('sap_tbm_contact');          
                $temp_customer = $query_customer->row_array();   
                if(!empty($temp_customer)){   
                foreach($query_customer->result_array() as $value){  
              ?>
                <option value='<?php echo $value['id'] ?>'><?php echo $value['firstname'].' '.$value['lastname']; ?></option> 
            <?php }//end foreach
               }else{ ?>
                 <option value='0'>ไม่มีข้อมูล</option> 
            <?php } ?>         
         	</select>  
        </div>
      </div>

  </div> 
<!-- end : input group --> 


<!-- start : input group -->  
<div class="col-sm-12 no-padd">      
      <div class="col-md-6">
         <div class="input-group m-b">
           <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('firstname').'</font></div>'; ?></span>
          <input maxlength="35" type="text"  autocomplete="off" name="name_contact" class="form-control name_contact"   value=""   data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>">
        </div>
      </div>

      <div class="col-md-6">
         <div class="input-group m-b">
           <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('lastname').'</font></div>'; ?></span>
          <input maxlength="35" type="text"  autocomplete="off" name="lastname_contact" class="form-control lastname_contact"   value=""  data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>">
        </div>
      </div>
</div>
<!-- end : input group -->




<!-- start : input group -->  
  <div class="col-sm-12 no-padd">                 
     
      <div class="col-md-6">
         <div class="input-group m-b">
           <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('ship_to_department').'</font></div>'; ?></span>
          <input maxlength="20" type="text"  autocomplete="off" name="ship_to_department" class="form-control ship_to_department"   value="<?php echo $data_ship_to_department;?>"  data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>">
        </div>
      </div> 

        <div class="col-md-6">
        <div class="input-group m-b">
           <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('ship_to_function').'</font></div>'; ?></span>
           <input maxlength="20"  type="text" autocomplete="off" name="ship_to_function" class="form-control ship_to_function"  value="<?php echo $data_ship_to_function;?>"  data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>">
        </div>
      </div>   

  </div> 
<!-- end : input group --> 


<!-- start : input group -->  
  <div class="col-sm-12 no-padd">     
  	 <div class="col-md-6">
         <div class="input-group m-b">
           <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('examiner').'</font></div>'; ?></span>
          <input  type="text" readonly autocomplete="off" name="examiner_name" class="form-control examiner_name"   value="<?php echo $data_examiner_name;?>" >
          <input  type="hidden" readonly autocomplete="off" name="examiner_id" class="form-control examiner_id"   value="<?php echo $data_examiner_id;?>" >
        </div>
      </div>  
</div> 
<!-- end : input group --> 



<!-- start : input group -->
<div class="col-sm-12 no-padd">
      <div class="form-group col-sm-12">
        <label class="col-sm-2 problem-adon  "><?php echo freetext('place_problem'); ?></label>
        <div class="col-sm-10 no-padd">
          <textarea maxlength="60" data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>" id='place_problem' name='place_problem' class="place_problem" style='width:100%;height:120px;' placeholder='Text input'></textarea>
          <!-- $problem -->
        </div>
      </div>  
</div>
<!-- end : input group -->



<!-- start : input group -->
<div class="col-sm-12 no-padd">
      <div class="form-group col-sm-12">
        <label class="col-sm-2 problem-adon  "><?php echo freetext('detail_problem'); ?></label>
        <div class="col-sm-10 no-padd">
          <textarea maxlength="60" data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>" id='detail_problem' name='detail_problem' class="detail_problem" style='width:100%;height:120px;' placeholder='Text input'></textarea>
          <!-- $problem -->
        </div>
      </div>  
</div>
<!-- end : input group -->


<!-- start : input group -->
<div class="col-sm-12 no-padd">
      <div class="form-group col-sm-12">
        <label class="col-sm-2 problem-adon  "><?php echo freetext('complain_problem'); ?></label>
        <div class="col-sm-10 no-padd">
          <textarea  maxlength="3000"  data-parsley-required="true"  data-parsley-error-message="<?php echo freetext('required_msg'); ?>" id='complain_problem' name='complain_problem' class="complain_problem" style='width:100%;height:120px;' placeholder='Text input'></textarea>
          <!-- $problem -->
        </div>
      </div>  
</div>
<!-- end : input group -->



</div>
</div>



</section>


  <!--   <?php // foreach($get_requiredByid->result_array() as $row){  if($row['id']== $re_doc_id  ){ echo 'checked="checked"'; } } ?>  -->
<section class="panel panel-default">
<header class="panel-heading font-bold">                  
<?php echo freetext('title_detail_complain');  ?>
</header>
<div class="panel-body">


<!-- start : input group -->  
  <div class="col-sm-12 no-padd"> 
	     <div class="col-md-6">
         <div class="input-group m-b">
           <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('problem_type_id').'</font></div>'; ?></span>
            <input type="hidden" readonly class="form-control" name="problem_type_title" value="">
           	<select data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>"  class="select2  form-control  no-padd h6" name="problem_type_id" id="problem_type_id" style="height:31px;">
           	  <!-- <select  name='ship_to_id' class='form-control' id="ship_to_id"> -->
        	    <option value="" >กรุณาเลือก</option>
              <?php 
                $temp_pb_type = $master_pb_type->result_array();
                if(!empty($temp_pb_type)){   
                foreach($master_pb_type->result_array() as $value){ 
             ?>
                <option  value='<?php echo $value['id'] ?>'><?php echo $value['title']; ?></option> 
            <?php }//end foreach
               }else{ ?>
                 <option value='0'>ไม่มีข้อมูล</option> 
            <?php } ?>          
         	</select>  
        </div>
      	</div>    

      	<div class="col-md-6">
         <div class="input-group m-b">
           <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('problem_list_id').'</font></div>'; ?></span>
           	<input type="hidden" readonly class="form-control" name="problem_list_title" value="">
            <select disabled data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>"  class="select2  form-control  no-padd h6" name="problem_list_id" id="problem_list_id"  style="height:31px;">
           	 <!-- <select  name='ship_to_id' class='form-control' id="ship_to_id"> -->
        	     <option value="" >กรุณาเลือก</option>           
         	</select>  
        </div>
      	</div>                    

  </div> 
<!-- end : input group --> 


<!-- start : input group -->  
  <div class="col-sm-12 no-padd"> 
       <div class="col-md-6">
        <div class="input-group m-b">
           <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('completeDate').'</font></div>'; ?></span>
             <input type="text" autocomplete="off" readonly class="form-control completedate_text"  value=""/>
             <input type="hidden" readonly class="form-control completedate" name="completedate"  value=""/>
        </div>  
      </div>
  </div> 
<!-- end : input group --> 





<!-- start : input group -->  
  <div class="form-group col-sm-12">
   <label class="col-sm-3 control-label h5"><?php echo freetext('problem_level'); ?></label>
	 <div class="col-sm-9 h5">
	    <div class="col-sm-3">
	      <label>
	        <input type='radio' name='problem_level' class="problem_level moderate" value='moderate' checked='checked'>
	        <?php echo freetext('moderate'); //No have serial code?>                            
	      </label>
	    </div>
	    <div class="col-sm-3"> 
	      <label >
	       <input type='radio' name='problem_level' class="problem_level instant" value='instant'>
	        <?php echo freetext('instant'); //No have serial code?>                            
	      </label>
	    </div>
	    <div class="col-sm-3"> 
	      <label >
	       <input type='radio' name='problem_level' class="problem_level urgently" value='urgently'>
	        <?php echo freetext('urgently'); //No have serial code?>                            
	      </label>
	    </div>
	    <div class="col-sm-3"> 
	      <label >
	       <input type='radio' name='problem_level' class="problem_level urgent" value='urgent'>
	        <?php echo freetext('urgent'); //No have serial code?>                            
	      </label>
	    </div>
	  </div>                  
   </div>
<!-- end : input group --> 


</div>



</section>


 <!--################################ end :required ############################-->


<!--################################ start : important docment ############################-->
<!-- <section class="panel panel-default ">               
     <div class="panel-heading" style="padding-bottom :24px;">
       <font class="font-bold h5"> <?php //echo freetext('doc'); ?></font>
    </div>
    <div class="panel-body"> 
      <div class="form-group">
        <div class="col-sm-12 add-all-medium">     -->  
   <!-- <form method="post" action="<?php //echo site_url('__ps_quotation/upload_file_quotation');?>" enctype="multipart/form-data" />   -->  
             <!-- start : upload file -->
               <!-- <div class="col-sm-12"> -->
               <!-- 
                  <div class="col-sm-10 no-padd" style="margin-top:-10px;">
                     <input readonly type="hidden" name="quotation_id" value="<?php //echo $this->quotation_id; ?>" />
                     <input type="file"  name="image"  class="filestyle" data-icon="false" data-classButton="btn btn-default col-sm-2 pull-left" data-classInput="pull-left h3 col-sm-10">                  
                  </div> -->
                  <!-- <div class="col-sm-2 ">
                      <button  id="submit" class="btn btn-s-md btn-info pull-left btn_upload_importance" ><?php  //echo freetext('upload'); //Upload?></button>
                  </div> -->
                
             <!--  </div>     -->          
              <!-- End : upload file -->
   <!-- </form> -->
         <!--  </div> --> <!-- end : col12 -->                        
     <!--  </div> --><!--end : form-group -->
  <!-- </div> --><!--end : panel-body -->
<!-- </section> -->
 <!--################################ end : important docment ############################-->



<!-- form submit -->
<div class="col-sm-12 no-padd" style="margin-top:20px;margin-bottom:80px;">
  <div class="pull-right">
    <a href="<?php echo site_url($this->page_controller.'/listview_complain'); ?>"  class="btn btn-default" style="width:120px;"> <?php echo freetext('cancel'); ?></a>
    <button type="submit" class="btn btn-primary  btn_save_changes margin-left-small"> <?php echo freetext('Save_changes'); ?></button>
  </div>
</div>
<!-- end : form submit -->



<div style="margin: 50px;"></div>
</div><!-- end : class div_detail -->
</form>


</section><!-- end : scrollable padder -->
</section><!-- end : class vbox -->
<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>



          











