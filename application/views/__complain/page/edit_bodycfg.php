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


$temp_detail_complain = $query_complain->result_array();
if(!empty($temp_detail_complain)){   
  foreach($query_complain->result_array() as $value){ 
     $input_method = $value['input_method'];
     $create_date = $value['create_date'];
     $raise_by_id = $value['raise_by_id'];
     $contract_id = $value['contract_id'];
     $ship_to_id = $value['ship_to_id'];
     $customer_id = $value['contact_id'];

     $ship_to_name1 = $value['ship_to_name1'];
     //$ship_to_name2 = $value['ship_to_name2'];
     $ship_to_distribution_channel = $value['ship_to_distribution_channel'];
     $ship_to_branch_id = $value['ship_to_branch_id'];
     $ship_to_branch_des = $value['ship_to_branch_des'];
     $ship_to_city = $value['ship_to_city'];

     $place_problem = $value['place'];
     $detail_problem = $value['detail'];
     $complain_problem = $value['problem'];

     $problem_type_id = $value['problem_type_id'];
     $problem_list_id = $value['problem_list_id'];
     $problem_level = $value['problem_level'];

     $plant_code = $value['plant_code'];
     $plant_name = $value['plant_name'];

     $examiner_id = $value['ins_id'];
     $examiner_name = $value['ins_name'];

     $contact_first_name = $value['contact_first_name'];
     $contact_function_des = $value['contact_function_des'];
     $contact_department_des = $value['contact_department_des'];
     
     $problem_type_title = $value['problem_type_title'];
     $problem_list_title = $value['problem_list_title'];

     $user_firstname=$value['user_firstname'];
     $user_lastname=$value['user_lastname'];

    $completedate = $value['completedate'];

  }//end foreach
}else{

     $input_method ='';
     $create_date = '';
     $raise_by_id ='';
     $contract_id = '';
     $ship_to_id = '';
     $customer_id = '';

     $ship_to_name1 = '';
    // $ship_to_name2 = '';
     $ship_to_distribution_channel ='';
     $ship_to_branch_id = '';
     $ship_to_branch_des = '';
     $ship_to_city = '';

     $place_problem = '';
     $detail_problem = '';
     $complain_problem = '';

     $problem_type_id = '';
     $problem_list_id = '';
     $problem_level = '';

     $plant_code = '';
     $plant_name = '';
     $examiner_id = '';
     $examiner_name = '';

     $contact_first_name = '';
     $contact_function_des = '';
     $contact_department_des = '';

     $problem_type_title = '';
     $problem_list_title = '';

     $completedate= '';

}//end


?>


<div class="div_detail">
<section class="panel panel-default "> 
<div class="panel panel-heading back-color-gray">                  
	แก้ไข : <?php echo freetext('complain'); ?>        
</div>              
<form action='<?php echo site_url($this->page_controller.'/update_complain/'.$this->complain_id); ?>' method="POST" data-parsley-validate> 
<input type="hidden" name="contract_id" class="form-control" readonly="readonly" value="<?php echo $contract_id; ?>">
            
<div class="panel-body"> 
<div class="form-group">
  <!-- start : input group -->
  <div class="col-sm-12 no-padd">
		  <div class="col-md-12">
          <div class="col-md-6 no-padd">
            <div class="input-group m-b">
           <span class="input-group-addon"><?php echo '<font class="pull-left">'.freetext('complain_id').'</font>'; ?></span>
           <input type="text" readonly autocomplete="off" onkeypress="return isInt(event)"  class="form-control"  value="<?php  echo $this->complain_id; ?>">
            </div>
          </div>
       </div>    
  </div>
  <!-- end : input group -->

<!-- start : input group -->  
  <div class="col-sm-12 no-padd"> 
  <!--   <div class="col-md-6">
         <label class="col-sm-3 control-label"><?php //echo freetext('Method'); ?></label>
		 <div class="col-sm-9">
		    <div class="col-sm-4">
		      <label>
		        <input type='radio' name='input_method' class="Method email" value='email' <?php //if($input_method=='email'){ echo "checked='checked'"; } ?> >
		        <?php //echo freetext('email'); //No have serial code?>                            
		      </label>
		    </div>
		    <div class="col-sm-4"> 
		      <label >
		       <input type='radio' name='input_method' class="Method telephone" value='telephone'  <?php //if($input_method=='telephone'){ echo "checked='checked'"; } ?>>
		        <?php //echo freetext('telephone'); //No have serial code?>                            
		      </label>
		    </div>		    
		 </div>    
    </div>  -->   


      <div class="col-md-6">
         <div class="input-group m-b">
           <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('Method').'</font></div>'; ?></span>
            <select data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>"  class="select2  form-control  no-padd h6" name="input_method" id="input_method" style="height:31px;">
              <option value="" >กรุณาเลือก</option>
              <?php 
                $temp_type_complain = $master_type_complain->result_array();
                if(!empty($temp_type_complain)){   
                foreach($master_type_complain->result_array() as $value){ 
             ?>
                <option <?php if( $value['id'] == $input_method ){ echo "selected='selected'";} ?> value='<?php echo $value['id'] ?>'><?php echo $value['title']; ?></option> 
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
            <input type="text" readonly class="form-control" value="<?php echo common_easyDateFormat($create_date); ?>"/>
            <input type="hidden" class="form-control" name="create_date" value="<?php echo $create_date; ?>"/>
        </div>
      </div>
  </div> 
<!-- end : input group --> 

<!-- start : input group -->  
  <div class="col-sm-12 no-padd"> 
       <div class="col-md-6">
         <div class="input-group m-b">
           <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('raise_by_id').'</font></div>'; ?></span>
          <input  type="hidden" readonly autocomplete="off" name="raise_by_id" class="form-control raise_by_id"   value="<?php echo $raise_by_id; ?>" >
          <input  type="text" readonly autocomplete="off" name="nameuser" class="form-control nameuser"   value="<?php echo $user_firstname.' '.$user_lastname; ?>" >
           
        </div>
      </div>                     

      <div class="col-md-6">
        <div class="input-group m-b">
           <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('plant').'</font></div>'; ?></span>
            <input readonly type="hidden" autocomplete="off" name="plant_code" class="form-control plant_code"  value="<?php echo $plant_code; ?>">
            <input readonly type="text" autocomplete="off" name="plant_name" class="form-control plant_name"  value="<?php echo $plant_name; ?>">
        </div>
      </div>
  </div> 
<!-- end : input group --> 


<!-- start : input group -->  
  <div class="col-sm-12 no-padd">                    

      <div class="col-md-6">
        <div class="input-group m-b">
           <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('ship_to_id').'</font></div>'; ?></span>
           	<input type="text" readonly name="ship_to_id" class="form-control" value="<?php echo $ship_to_id; ?>">         
        </div>
      </div>

       <div class="col-md-6">
         <div class="input-group m-b">
           <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('ship_to_name').'</font></div>'; ?></span>
          <input  type="text" readonly autocomplete="off" name="ship_to_name" class="form-control ship_to_name"   value="<?php echo $ship_to_name1; ?>" >
        </div>
      </div>  


  </div> 
<!-- end : input group --> 



<!-- start : input group -->  
  <div class="col-sm-12 no-padd">                       

       <div class="col-md-6">
         <div class="input-group m-b">
           <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('distribution_channel').'</font></div>'; ?></span>
          <input  type="text" readonly autocomplete="off" name="ship_to_distribution_channel" class="form-control ship_to_distribution_channel"   value="<?php echo $ship_to_distribution_channel?>" >
        </div>
      </div>   

      <div class="col-md-6">
        <div class="input-group m-b">
           <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('ship_to_branch').'</font></div>'; ?></span>
           <input readonly type="hidden" autocomplete="off" name="ship_to_branch_id" class="form-control ship_to_branch_id"  value="<?php echo $ship_to_branch_des_id; ?>">
            <input readonly type="text" autocomplete="off" name="ship_to_branch_des" class="form-control ship_to_branch_des"  value="<?php echo $ship_to_branch_des; ?>">
        </div>
      </div>

  </div> 
<!-- end : input group --> 


<!-- start : input group -->  
  <div class="col-sm-12 no-padd">  
      
      <div class="col-md-6">
        <div class="input-group m-b">
           <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('ship_to_city').'</font></div>'; ?></span>
            <input readonly type="text" autocomplete="off" name="ship_to_city" class="form-control ship_to_city"  value="<?php echo $ship_to_city?>">
        </div>
      </div>

       <div class="col-md-6">
      <!--
        <div class="input-group m-b">
           <span data-parsley-required="true" data-parsley-error-message="<?php //echo freetext('required_msg'); ?>" class="input-group-addon"><?php //echo '<div class="label-width-adon"><font class="pull-left">'.freetext('customer_id').'</font></div>'; ?></span>
           	<input readonly type="hidden" autocomplete="off" name="contact_first_name" class="form-control contact_first_name"  value="<?php //echo $contact_first_name; ?>">
            <select  class="select2  form-control  no-padd h5" name="customer_id" id="customer_id"  style="height:31px;">
        	   <option value="" >กรุณาเลือก</option> -->
             <?php 
                // $this->db->select('sap_tbm_contact.*');
                // $this->db->where('sap_tbm_contact.ship_to_id', $ship_to_id);
                // $query_customer = $this->db->get('sap_tbm_contact');          
                // $temp_customer = $query_customer->row_array();   
                // if(!empty($temp_customer)){   
                // foreach($query_customer->result_array() as $value){  
              ?>
                <!-- <option <?php //if( $value['id'] == $customer_id ){ echo "selected='selected'";} ?> value='<?php //echo $value['id'] ?>'><?php //echo $value['firstname'].' '.$value['lastname']; ?></option>  -->
            <?php 
               // }//end foreach
               // }else{ 
            ?>
                <!--  <option value='0'>ไม่มีข้อมูล</option>  -->
            <?php //} ?>
         	<!-- </select>  
        </div>
       -->
        <input type="hidden" class="form-control" name="customer_id" readonly value="<?php echo $customer_id; ?>"> 
        <div class="input-group m-b">
              <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('customer_id').'</font></div>'; ?></span>
              <input  type="text" readonly autocomplete="off" name="contact_first_name" class="form-control contact_first_name"   value="<?php echo  $contact_first_name ;//echo $ship_to_department ?>" >
        </div>
    </div>

  </div> 
<!-- end : input group --> 

<?php
// //query sap_tbm_contact
// $this->db->select('sap_tbm_contact.*');
// $this->db->where('sap_tbm_contact.id', $customer_id);
// $query_data_customer = $this->db->get('sap_tbm_contact');          
// $data_customer = $query_data_customer->row_array(); 
// //foreach($query_data_customer->result_array() as $value){
// $ship_to_department = $data_customer['department_des'];
// $ship_to_function = $data_customer['function_des'];
// //}//end foreach
?>

<!-- start : input group -->  
  <div class="col-sm-12 no-padd">                 
     
      <div class="col-md-6">
         <div class="input-group m-b">
           <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('ship_to_department').'</font></div>'; ?></span>
          <input  type="text" readonly autocomplete="off" name="ship_to_department" class="form-control ship_to_department"   value="<?php echo  $contact_department_des;//echo $ship_to_department ?>" data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>">
        </div>
      </div> 

        <div class="col-md-6">
        <div class="input-group m-b">
           <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('ship_to_function').'</font></div>'; ?></span>
           <input readonly type="text" autocomplete="off" name="ship_to_function" class="form-control ship_to_function"  value="<?php echo $contact_function_des;  //echo $ship_to_function ?>" data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>">
        </div>
      </div>   

  </div> 
<!-- end : input group --> 


<!-- start : input group -->  
  <div class="col-sm-12 no-padd">     
  	 <div class="col-md-6">
         <div class="input-group m-b">
           <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('examiner').'</font></div>'; ?></span>
          <input  type="hidden" readonly autocomplete="off" name="examiner_id" class="form-control examiner_id"   value="<?php echo $examiner_id ?>" >
          <input readonly type="text" autocomplete="off" name="examiner_name" class="form-control examiner_name"  value="<?php echo $examiner_name; ?>">
        </div>
      </div>    

  </div> 
<!-- end : input group --> 

<!-- start : input group -->
<div class="col-sm-12 no-padd">
      <div class="form-group col-sm-12">
        <label class="col-sm-2 problem-adon  "><?php echo freetext('place_problem'); ?></label>
        <div class="col-sm-10 no-padd">
          <textarea maxlength="60" data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>" id='place_problem' name='place_problem' class="place_problem" style='width:100%;height:120px;' placeholder='Text input'><?php echo $place_problem; ?></textarea>
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
          <textarea maxlength="60" data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>" id='detail_problem' name='detail_problem' class="detail_problem" style='width:100%;height:120px;' placeholder='Text input'><?php echo $detail_problem; ?></textarea>
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
          <textarea  maxlength="3000" data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>" id='complain_problem' name='complain_problem' class="complain_problem" style='width:100%;height:120px;' placeholder='Text input'><?php echo $complain_problem; ?></textarea>
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
           	<input type="hidden" readonly class="form-control" name="problem_type_title" value="<?php echo $problem_type_title; ?>">
            <select data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>"  class="select2  form-control  no-padd h6" name="problem_type_id" id="problem_type_id" style="height:31px;">
           	<!-- <select  name='ship_to_id' class='form-control' id="ship_to_id"> -->
        	    <option value="" >กรุณาเลือก</option>
              <?php 
                $temp_pb_type = $master_pb_type->result_array();
                if(!empty($temp_pb_type)){   
                foreach($master_pb_type->result_array() as $value){ 
             ?>
                <option <?php if( $value['id'] == $problem_type_id ){ echo "selected='selected'";} ?> value='<?php echo $value['id'] ?>'><?php echo $value['title']; ?></option> 
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
           	<input type="hidden" readonly class="form-control" name="problem_list_title" value="<?php echo $problem_list_title; ?>">
            <select data-parsley-required="true" data-parsley-error-message="<?php echo freetext('required_msg'); ?>"  class="select2  form-control  no-padd h6" name="problem_list_id" id="problem_list_id"  style="height:31px;">
           	<!-- <select  name='ship_to_id' class='form-control' id="ship_to_id"> -->
        	 <option value="" >กรุณาเลือก</option>
             <?php 
                $temp_pb_list = $master_pb_list->result_array();
                if(!empty($temp_pb_list)){   
                foreach($master_pb_list->result_array() as $value){ 
             ?>
                <option <?php if( $value['id'] == $problem_list_id ){ echo "selected='selected'";} ?> value='<?php echo $value['id'] ?>'><?php echo $value['title']; ?></option> 
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
           <span class="input-group-addon"><?php echo '<div class="label-width-adon"><font class="pull-left">'.freetext('completeDate').'</font></div>'; ?></span>
             <input type="text" autocomplete="off" readonly class="form-control completedate_text"  value="<?php echo common_easyDateFormat($completedate); ?>"/>
             <input type="hidden" readonly class="form-control completedate" name="completedate"  value="<?php echo $completedate; ?>"/>
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
	        <input type='radio' name='problem_level' class="problem_level moderate" value='moderate' <?php if($problem_level=='moderate'){ echo "checked='checked'"; } ?>>
	        <?php echo freetext('moderate'); //No have serial code?>                            
	      </label>
	    </div>
	    <div class="col-sm-3"> 
	      <label >
	       <input type='radio' name='problem_level' class="problem_level instant" value='instant' <?php if($problem_level=='instant'){ echo "checked='checked'"; } ?>>
	        <?php echo freetext('instant'); //No have serial code?>                            
	      </label>
	    </div>
	    <div class="col-sm-3"> 
	      <label >
	       <input type='radio' name='problem_level' class="problem_level urgently" value='urgently' <?php if($problem_level=='urgently'){ echo "checked='checked'"; } ?>>
	        <?php echo freetext('urgently'); //No have serial code?>                            
	      </label>
	    </div>
	    <div class="col-sm-3"> 
	      <label >
	       <input type='radio' name='problem_level' class="problem_level urgent" value='urgent' <?php if($problem_level=='urgent'){ echo "checked='checked'"; } ?>>
	        <?php echo freetext('urgent'); //No have serial code?>                            
	      </label>
	    </div>
	  </div>                  
   </div>
<!-- end : input group --> 


</div>
</section>


 <!--################################ end :required ############################-->




 <!-- start : photo panel -->
                  <div class="col-sm-12" style='margin-bottom:40px'>
                

                  <section class="panel panel-default">
                    <header class="panel-heading font-bold"><?php echo freetext('photo_dateail'); ?> 
                    <!-- <a href="#modal-photo-form" class="pull-right" data-toggle="modal"> -->
                    <span class="pull-right btn-sm btn-warning btn photo-add" style='margin-top:-6px'><i class='fa fa-plus-circle'></i> &nbsp;<?php echo freetext('add_photo'); ?></span>
                    <!-- </a> -->
                    </header>
                      <div class="panel-body">
                        

                  <table class="table m-b-none">
                      <thead>
                        <tr>
                          <th><?php echo freetext('photo'); ?></th>
                          <th><?php echo freetext('photo_title'); ?></th>
                          <th><?php echo freetext('photo_ownerby'); ?></th>                    
                          <th style="min-width:70px"></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                            $temp_ima = $query_images->result_array();
                           if(!empty($temp_ima)){
                             foreach($query_images->result_array() as $value){                               
                          ?>

                           <tr id='photo-<?php echo $value['id'] ?>'>                    
                            <td class='photo-thubms'>
                              <img src="<?php echo site_url($value['path']) ?>" height="32" class="img-rounded" />
                            </td>
                            <td class='photo-title'><?php echo $value['file_name'] ?></td>
                            <td class='photo-sequence'><?php echo $value['user_firstname'].' '.$value['user_lastname'];//$value['own_by']; ?></td>
                            <td class='photo-action'>
                            <a href="#" id="<?php echo $value['id'];?>" class="photo-delete btn btn-sm btn-icon btn-danger pull-right" style='margin-left:4px'><i class="fa fa-trash-o"></i></a>
                          </td>
                        </tr>



                           <?php
                               }
                              }else{ echo '<tr><td colspan="4">ไม่มีข้อมูล</td></tr>'; }
                            ?>

                      </tbody>
                  </table>
                

                      </div>
                  </section>

                  <!-- </form> -->
                  </div>
                  <!-- end : photo panel -->








<!-- form submit href="<?php //echo site_url($this->page_controller.'/submit_to_papyrus/'.$this->complain_id); ?>" -->
<div class="col-sm-12 no-padd" style="margin-bottom:80px;">
  <div class="pull-left">
    <a   class="pull-left btn btn-info submit-papyrus" style="width:120px;"> <?php echo freetext('submit_complain'); ?></a>
  </div>
  <div class="pull-right">
    <a href="<?php echo site_url($this->page_controller.'/listview_complain'); ?>"  class="btn btn-default" style="width:120px;"> <?php echo freetext('cancel'); ?></a>
    <button type="submit" class="btn btn-primary  btn_save_changes margin-left-small"> <?php echo freetext('Save_changes'); ?></button>
    <!-- submit to papyrus -->
  </div>
</div>
<!-- end : form submit -->
</form>


<div style="margin: 50px;"></div>
</div><!-- end : class div_detail -->

</section><!-- end : scrollable padder -->
</section><!-- end : class vbox -->
<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>



          











