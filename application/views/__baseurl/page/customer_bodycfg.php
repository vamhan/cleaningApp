<style type="text/css">
.dt_header{
display: none  !important;
}

.dt_footer .row-fluid{
display: none  !important;
}

</style>


<?php  


//=====  TODO :: set permission wage =====
$array_function_login = $this->session->userdata('function');
$temp_function_login= $array_function_login;
// echo "<pre>";
// print_r($temp_function);
// echo "</pre>";
$permission_view_wage =  array("MK","CR","RC", "IC", "HR", "WF","IT", "TN", "AC", "FI");// dont have ST,OP

///////////////////////////////////////////////////////////////

    //====start : get data quotation   =========
     $data_quotation = $query_quotation->row_array();    

     if(!empty($data_quotation)){

         $contract_id  =$data_quotation['contract_id'];
         if($data_quotation['project_start']!='0000-00-00' && $data_quotation['project_end']!='0000-00-00'){
           $date_time_qt  = common_easyDateFormat($data_quotation['project_start']).' - '.common_easyDateFormat($data_quotation['project_end']);
         }else{
           $date_time_qt  = '';
         }//end else        

         $competitor  =$data_quotation['competitor_id'];
         $unit_time  =$data_quotation['unit_time'];
         $time  =$data_quotation['time'];
         $job_type  =$data_quotation['job_type'];

         $is_prospect  = $data_quotation['is_prospect'];
         //$is_go_live  =$data_quotation['is_go_live'];
         $previous_quotation_id  =$data_quotation['previous_quotation_id'];
         //$project_start  =$data_quotation['project_start'];
         //$project_end     =$data_quotation['project_end'];

         $sold_to_id        =$data_quotation['sold_to_id'];    
         $sold_to_name1     =$data_quotation['sold_to_name1'];      
        // $sold_to_name2     =$data_quotation['sold_to_name2'];
         $sold_to_address1  =$data_quotation['sold_to_address1'];
         $sold_to_address2  =$data_quotation['sold_to_address2'];
         $sold_to_address3  =$data_quotation['sold_to_address3'];
         $sold_to_address4  =$data_quotation['sold_to_address4'];
         $sold_to_district  =$data_quotation['sold_to_district'];
         $sold_to_country   =$data_quotation['sold_to_country'];    // varchar2
         $sold_to_region       =$data_quotation['sold_to_region']; // varchar2
         $sold_to_city         =$data_quotation['sold_to_city']; 
         $sold_to_postal_code  =$data_quotation['sold_to_postal_code'];  // varchar5
         $sold_to_industry     =$data_quotation['sold_to_industry']; // varchar4
         $sold_to_business_scale  =$data_quotation['sold_to_business_scale'];
         //$sold_to_customer_group  =$data_quotation['sold_to_customer_group'];

         $sold_to_tel  =$data_quotation['sold_to_tel'];
         $sold_to_tel_ext  =$data_quotation['sold_to_tel_ext'];
         $sold_to_fax  =$data_quotation['sold_to_fax'];
         $sold_to_fax_ext  =$data_quotation['sold_to_fax_ext'];
         $sold_to_mobile  =$data_quotation['sold_to_mobile'];
         $sold_to_email  =$data_quotation['sold_to_email'];


         $ship_to_id        =$data_quotation['ship_to_id'];    
         $ship_to_name1     =$data_quotation['ship_to_name1'];      
         //$ship_to_name2     =$data_quotation['ship_to_name2'];
         $ship_to_address1  =$data_quotation['ship_to_address1'];
         $ship_to_address2  =$data_quotation['ship_to_address2'];
         $ship_to_address3  =$data_quotation['ship_to_address3'];
         $ship_to_address4  =$data_quotation['ship_to_address4'];
         $ship_to_district  =$data_quotation['ship_to_district'];
         $ship_to_country   =$data_quotation['ship_to_country'];        
         $ship_to_region       =$data_quotation['ship_to_region'];
         $ship_to_city         =$data_quotation['ship_to_city'];
         $ship_to_postal_code  =$data_quotation['ship_to_postal_code'];
         $ship_to_industry     =$data_quotation['ship_to_industry'];
         $ship_to_business_scale  =$data_quotation['ship_to_business_scale'];
         //$ship_to_customer_group  =$data_quotation['ship_to_customer_group'];

         $ship_to_tel  =$data_quotation['ship_to_tel'];
         $ship_to_tel_ext  =$data_quotation['ship_to_tel_ext'];
         $ship_to_fax  =$data_quotation['ship_to_fax'];
         $ship_to_fax_ext  =$data_quotation['ship_to_fax_ext'];
         $ship_to_mobile  =$data_quotation['ship_to_mobile'];
         $ship_to_email  =$data_quotation['ship_to_email'];
         $distribution_channel_db  =$data_quotation['distribution_channel'];
         $required_doc =  unserialize($data_quotation['required_doc']);
        
      }//end
      
      //get : competitor
      $temp_bapi_competitor = $bapi_competitor->result_array();
      if(!empty($temp_bapi_competitor)){
      foreach($bapi_competitor->result_array() as $value){ 
        if($competitor==$value['competitor_id']){
            $competitor_name = $value['competitor_name'];
        }
      }//end if

      }//end foreach



      //=== GET :: ship_to_tax_id ===
      $this->db->select('sap_tbm_ship_to.ship_to_tax_id');
      $this->db->where('sap_tbm_ship_to.id', $ship_to_id);
      $get_ship_to_tax = $this->db->get('sap_tbm_ship_to');
      $query_ship_to_tax = $get_ship_to_tax->row_array();     
      if(!empty($query_ship_to_tax)){  
          $ship_to_tax_id= $query_ship_to_tax['ship_to_tax_id'];
      }else{
         $ship_to_tax_id= '';
      }


      //=== GET :: sold_to_to_tax_id ===
      $this->db->select('sap_tbm_sold_to.sold_to_tax_id');
      $this->db->where('sap_tbm_sold_to.id', $sold_to_id);
      $get_sold_to_tax = $this->db->get('sap_tbm_sold_to');
      $query_sold_to_tax = $get_sold_to_tax->row_array();     
      if(!empty($query_sold_to_tax)){  
          $sold_to_tax_id= $query_sold_to_tax['sold_to_tax_id'];
      }else{
         $sold_to_tax_id= '';
      }

/////////////////////////////////////
 // === start :  get bapi sap =======
/////////////////////////////////////

/////////////////// sold to/////////////////////////

//===== get title contry==========
  $sold_to_country_title ='';
  $temp_bapi_country = $bapi_country->result_array();
    if(!empty($temp_bapi_country)){
      foreach($bapi_country->result_array() as $value){  
         if($value['id']== $sold_to_country){                                          
              $sold_to_country_title  = $value['title'];
          }

      }//end foreach
  }else{  $sold_to_country_title = ''; }

//===== get title region ==========
  $sold_to_region_title ='';
  $temp_bapi_region= $bapi_region->result_array();
    if(!empty($temp_bapi_region)){
      foreach($bapi_region->result_array() as $value){         
         if($value['id']== $sold_to_region){                                          
              $sold_to_region_title  = $value['title'];
          }

      }//end foreach
  }else{  $sold_to_region_title = ''; }


//===== get title industry ==========
  $sold_to_industry_title ='';
  $temp_bapi_industry= $bapi_industry->result_array();
    if(!empty($temp_bapi_industry)){
      foreach($bapi_industry->result_array() as $value){         
         if($value['id']== $sold_to_industry){                                          
              $sold_to_industry_title  = $value['title'];
          }

      }//end foreach
  }else{  $sold_to_industry_title = ''; }


  //===== get title industry ==========
  $sold_to_business_scale_title ='';
  $temp_business_scale= $bapi_business_scale->result_array();
    if(!empty($temp_business_scale)){
      foreach($bapi_business_scale->result_array() as $value){         
         if($value['id']== $sold_to_business_scale){                                          
              $sold_to_business_scale_title  = $value['title'];
          }

      }//end foreach
  }else{  $sold_to_business_scale_title = ''; }

/////////////////// ship to/////////////////////////


//===== get title contry==========
  $ship_to_country_title ='';
  $temp_bapi_country = $bapi_country->result_array();
    if(!empty($temp_bapi_country)){
      foreach($bapi_country->result_array() as $value){  
         if($value['id']== $ship_to_country){                                          
              $ship_to_country_title  = $value['title'];
          }

      }//end foreach
  }else{  $ship_to_country_title = ''; }


//===== get title region ==========
  $ship_to_region_title ='';
  $temp_bapi_region= $bapi_region->result_array();
    if(!empty($temp_bapi_region)){
      foreach($bapi_region->result_array() as $value){         
         if($value['id']== $ship_to_region){                                          
              $ship_to_region_title  = $value['title'];
          }

      }//end foreach
  }else{  $ship_to_region_title = ''; }


  //===== get title industry ==========
  $ship_to_industry_title ='';
  $temp_bapi_industry= $bapi_industry->result_array();
    if(!empty($temp_bapi_industry)){
      foreach($bapi_industry->result_array() as $value){         
         if($value['id']== $ship_to_industry){                                          
              $ship_to_industry_title  = $value['title'];
          }

      }//end foreach
  }else{  $ship_to_industry_title = ''; }


 

  //===== get title industry ==========
  $ship_to_business_scale_title ='';
  $temp_business_scale= $bapi_business_scale->result_array();
    if(!empty($temp_business_scale)){
      foreach($bapi_business_scale->result_array() as $value){         
         if($value['id']== $ship_to_business_scale){                                          
              $ship_to_business_scale_title  = $value['title'];
          }

      }//end foreach
  }else{  $ship_to_business_scale_title = ''; }


  //get $job_type
  if($job_type=='ZQT1'){
    $job_type_title = 'งานประจำ';
  }else if($job_type=='ZQT2'){
    $job_type_title = 'งานจร';
  }else{
    $job_type_title = 'งาน ot พิเศษ';
  }
?>




<div class="div_detail"  style="padding-left:50px;padding-right:50px;padding-bottom:50px;">
<h4 class="page-header font-bold tx-black"><i class="fa fa-leaf h5"></i> ข้อมูลลูกค้า</h4>
<div class="col-sm-12 h5">
<section class="panel panel-default">
  <header class="panel-heading back-color-gray "><span class="tx-blue font-bold tx-blue"><?php echo freetext('customer'); ?></span></header>
  <table class="table table-striped m-b-none ">
    <thead>
      <tr>
        <th  width="400"></th>  
        <th></th>       
      </tr>
    </thead>
    <tbody>
      <tr>  
        <td><?php echo freetext('quotation'); ?></td>
        <td><?php if(!empty($this->quotation_id)){ echo $this->quotation_id; }else{ echo "-";  }  ?></td>        
      </tr>

       <tr>  
        <td><?php echo freetext('contract'); ?></td>
        <td><?php if(!empty($contract_id)){ echo $contract_id; }else{ echo "-";  }  ?></td>        
      </tr>

       <tr>  
        <td><?php echo freetext('previous_quotation'); ?></td>
        <td><?php if(!empty($previous_quotation_id)){ echo $previous_quotation_id; }else{ echo "-";  }  ?></td>        
      </tr>

       <tr>  
        <td><?php echo freetext('start_project'); ?></td>
        <td><?php if(!empty($date_time_qt)){ echo $date_time_qt; }else{ echo "-";  }  ?></td>        
      </tr>

      <tr>  
        <td><?php echo freetext('job_type'); ?></td>
        <td><?php if(!empty($job_type_title)){ echo $job_type_title; }else{ echo "-";  }  ?></td>        
      </tr>
      <tr>  
        <td><?php echo freetext('time'); ?></td>
        <td><?php if(!empty($time)){  echo $time.' '.$unit_time;  }else{ echo "-";  }  ?></td>           
      </tr>
       <tr>  
        <td><?php echo freetext('competitor'); ?></td>
        <td><?php if(!empty($competitor_name)){ echo $competitor_name; }else{ echo "-";  }  ?></td>           
      </tr>


      <!-- <tr ><td colspan="2"  class="back-color-gray font-bold tx-blue">sold to :</td></tr> -->

      <tr>  
        <td><?php echo freetext('sold_to_id'); ?></td>
        <td><?php if(!empty($sold_to_id)){ echo $sold_to_id; }else{ echo "-";  }  ?></td>           
      </tr>

       <tr>  
        <td><?php echo freetext('sold_to_name1'); ?></td>
        <td><?php if(!empty($sold_to_name1)){ echo $sold_to_name1; }else{ echo "-";  }  ?></td>           
      </tr>
      <!-- <tr>  
        <td><?php //echo freetext('sold_to_name2'); ?></td>
        <td><?php //if(!empty($sold_to_name2)){ echo $sold_to_name2; }else{ echo "-";  }  ?></td>           
      </tr> -->
      <tr>  
        <td><?php echo freetext('sold_to_address1'); ?></td>
        <td><?php if(!empty($sold_to_address1)){ echo $sold_to_address1; }else{ echo "-";  }  ?></td>           
      </tr>
      <tr>  
        <td><?php echo freetext('sold_to_address2'); ?></td>
        <td><?php if(!empty($sold_to_address2)){ echo $sold_to_address2; }else{ echo "-";  }  ?></td>           
      </tr>
      <tr>  
        <td><?php echo freetext('sold_to_address3'); ?></td>
        <td><?php if(!empty($sold_to_address3)){ echo $sold_to_address3; }else{ echo "-";  }  ?></td>           
      </tr>
      <!--  <tr>  
        <td><?php //echo freetext('sold_to_address3'); ?></td>
        <td><?php //if(!empty($sold_to_address3)){ echo $sold_to_address3; }else{ echo "-";  }  ?></td>           
      </tr> -->
       <tr>  
        <td><?php echo freetext('sold_to_address4'); ?></td>
        <td><?php if(!empty($sold_to_address4)){ echo $sold_to_address4; }else{ echo "-";  }  ?></td>           
      </tr>
       <tr>  
        <td><?php echo freetext('sold_to_district'); ?></td>
        <td><?php if(!empty($sold_to_district)){ echo $sold_to_district; }else{ echo "-";  }  ?></td>           
      </tr>
       <tr>  
        <td><?php echo freetext('sold_to_city'); ?></td>
        <td><?php if(!empty($sold_to_city)){ echo $sold_to_city; }else{ echo "-";  }  ?></td>           
      </tr>
      <tr>  
        <td><?php echo freetext('sold_to_postal_code'); ?></td>
        <td><?php if(!empty($sold_to_postal_code)){ echo $sold_to_postal_code; }else{ echo "-";  }  ?></td>           
      </tr>
      <tr>  
        <td><?php echo freetext('sold_to_country'); ?></td>
        <td><?php if(!empty($sold_to_country_title)){ echo $sold_to_country_title; }else{ echo "-";  }  ?></td>           
      </tr>
       <tr>  
        <td><?php echo freetext('sold_to_region'); ?></td>
        <td><?php if(!empty($sold_to_region_title)){ echo $sold_to_region_title; }else{ echo "-";  }  ?></td>           
      </tr>
      <!--  <tr>  
        <td><?php //echo freetext('sold_to_region'); ?></td>
        <td><?php //if(!empty($sold_to_region_title)){ echo $sold_to_region_title; }else{ echo "-";  }  ?></td>           
      </tr> -->
       <tr>  
        <td><?php echo freetext('sold_to_industry'); ?></td>
        <td><?php if(!empty($sold_to_industry_title)){ echo $sold_to_industry_title; }else{ echo "-";  }  ?></td>           
      </tr>
       <tr>  
        <td><?php echo freetext('sold_to_tel'); ?></td>
        <td><?php if(!empty($sold_to_tel)){ echo $sold_to_tel; }else{ echo "-";  }  ?></td>           
      </tr>
       <tr>  
        <td><?php echo freetext('sold_to_tel_ext'); ?></td>
        <td><?php if(!empty($sold_to_tel_ext)){ echo $sold_to_tel_ext; }else{ echo "-";  }  ?></td>           
      </tr>
       <tr>  
        <td><?php echo freetext('sold_to_fax'); ?></td>
        <td><?php if(!empty($sold_to_fax)){ echo $sold_to_fax; }else{ echo "-";  }  ?></td>           
      </tr>
       <tr>  
        <td><?php echo freetext('sold_to_fax_ext'); ?></td>
        <td><?php if(!empty($sold_to_fax_ext)){ echo $sold_to_fax_ext; }else{ echo "-";  }  ?></td>           
      </tr>
       <!-- <tr>  
        <td><?php //echo freetext('sold_to_fax_ext'); ?></td>
        <td><?php //if(!empty($sold_to_fax_ext)){ echo $sold_to_fax_ext; }else{ echo "-";  }  ?></td>           
      </tr> -->
       <tr>  
        <td><?php echo freetext('sold_to_mobile'); ?></td>
        <td><?php if(!empty($sold_to_mobile)){ echo $sold_to_mobile; }else{ echo "-";  }  ?></td>           
      </tr>
      <tr>  
        <td><?php echo freetext('sold_to_email'); ?></td>
        <td><?php if(!empty($sold_to_email)){ echo $sold_to_email; }else{ echo "-";  }  ?></td>           
      </tr>
       <tr>  
        <td><?php echo freetext('sold_to_tax_id'); ?></td>
        <td><?php if(!empty($sold_to_tax_id)){ echo $sold_to_tax_id; }else{ echo "-";  }  ?></td>           
      </tr>

      <tr ><td colspan="2" class="back-color-gray font-bold tx-blue">สถานที่ปฏิบัติงาน</td></tr>

       <tr>  
        <td><?php echo freetext('ship_to_id'); ?></td>
        <td><?php if(!empty($ship_to_id)){ echo $ship_to_id; }else{ echo "-";  }  ?></td>           
      </tr>
     
       <tr>  
        <td><?php echo freetext('ship_to_name1'); ?></td>
        <td><?php if(!empty($ship_to_name1)){ echo $ship_to_name1; }else{ echo "-";  }  ?></td>           
      </tr>
      <!-- <tr>  
        <td><?php //echo freetext('ship_to_name2'); ?></td>
        <td><?php //if(!empty($ship_to_name2)){ echo $ship_to_name2; }else{ echo "-";  }  ?></td>           
      </tr> -->
      <tr>  
        <td><?php echo freetext('ship_to_address1'); ?></td>
        <td><?php if(!empty($ship_to_address1)){ echo $ship_to_address1; }else{ echo "-";  }  ?></td>           
      </tr>
      <tr>  
        <td><?php echo freetext('ship_to_address2'); ?></td>
        <td><?php if(!empty($ship_to_address2)){ echo $ship_to_address2; }else{ echo "-";  }  ?></td>           
      </tr>
     <!--  <tr>  
        <td><?php //echo freetext('ship_to_address3'); ?></td>
        <td><?php //if(!empty($ship_to_address3)){ echo $ship_to_address3; }else{ echo "-";  }  ?></td>           
      </tr> -->
       <tr>  
        <td><?php echo freetext('ship_to_address3'); ?></td>
        <td><?php if(!empty($ship_to_address3)){ echo $ship_to_address3; }else{ echo "-";  }  ?></td>           
      </tr>
       <tr>  
        <td><?php echo freetext('ship_to_address4'); ?></td>
        <td><?php if(!empty($ship_to_address4)){ echo $ship_to_address4; }else{ echo "-";  }  ?></td>           
      </tr>
       <tr>  
        <td><?php echo freetext('ship_to_district'); ?></td>
        <td><?php if(!empty($ship_to_district)){ echo $ship_to_district; }else{ echo "-";  }  ?></td>           
      </tr>
       <tr>  
        <td><?php echo freetext('ship_to_city'); ?></td>
        <td><?php if(!empty($ship_to_city)){ echo $ship_to_city; }else{ echo "-";  }  ?></td>           
      </tr>
      <tr>  
        <td><?php echo freetext('ship_to_postal_code'); ?></td>
        <td><?php if(!empty($ship_to_postal_code)){ echo $ship_to_postal_code; }else{ echo "-";  }  ?></td>           
      </tr>
      <tr>  
        <td><?php echo freetext('ship_to_country'); ?></td>
        <td><?php if(!empty($ship_to_country_title)){ echo $ship_to_country_title; }else{ echo "-";  }  ?></td>           
      </tr>
       <!-- <tr>  
        <td><?php //echo freetext('ship_to_region'); ?></td>
        <td><?php //if(!empty($ship_to_region_title)){ echo $ship_to_region_title; }else{ echo "-";  }  ?></td>           
      </tr> -->
       <tr>  
        <td><?php echo freetext('ship_to_region'); ?></td>
        <td><?php if(!empty($ship_to_region_title)){ echo $ship_to_region_title; }else{ echo "-";  }  ?></td>           
      </tr>
       <tr>  
        <td><?php echo freetext('ship_to_industry'); ?></td>
        <td><?php if(!empty($ship_to_industry_title)){ echo $ship_to_industry_title; }else{ echo "-";  }  ?></td>           
      </tr>
       <tr>  
        <td><?php echo freetext('ship_to_tel'); ?></td>
        <td><?php if(!empty($ship_to_tel)){ echo $ship_to_tel; }else{ echo "-";  }  ?></td>           
      </tr>
       <tr>  
        <td><?php echo freetext('ship_to_tel_ext'); ?></td>
        <td><?php if(!empty($ship_to_tel_ext)){ echo $ship_to_tel_ext; }else{ echo "-";  }  ?></td>           
      </tr>
       <tr>  
        <td><?php echo freetext('ship_to_fax'); ?></td>
        <td><?php if(!empty($ship_to_fax)){ echo $ship_to_fax; }else{ echo "-";  }  ?></td>           
      </tr>
      <!--  <tr>  
        <td><?php //echo freetext('ship_to_fax_ext'); ?></td>
        <td><?php //if(!empty($ship_to_fax_ext)){ echo $ship_to_fax_ext; }else{ echo "-";  }  ?></td>           
      </tr> -->
       <tr>  
        <td><?php echo freetext('ship_to_fax_ext'); ?></td>
        <td><?php if(!empty($ship_to_fax_ext)){ echo $ship_to_fax_ext; }else{ echo "-";  }  ?></td>           
      </tr>
       <tr>  
        <td><?php echo freetext('ship_to_mobile'); ?></td>
        <td><?php if(!empty($ship_to_mobile)){ echo $ship_to_mobile; }else{ echo "-";  }  ?></td>           
      </tr>
      <tr>  
        <td><?php echo freetext('ship_to_email'); ?></td>
        <td><?php if(!empty($ship_to_email)){ echo $ship_to_email; }else{ echo "-";  }  ?></td>           
      </tr>
        <tr>  
        <td><?php echo freetext('ship_to_tax_id'); ?></td>
        <td><?php if(!empty($ship_to_tax_id)){ echo $ship_to_tax_id; }else{ echo "-";  }  ?></td>           
      </tr>

    </tbody>
  </table>
</section>
</div>






<!--################################ start :tab contract and other ############################-->
<div class="form-group col-sm-12 ">
<section class="panel panel-default ">               
     <div class="panel-heading" style="padding-bottom :24px;">
       <font class="font-bold h5"> <?php echo freetext('contract_person'); ?></font>        
    </div>
    <div class="panel-body"> 
      <div class="form-group">
        <div class="col-sm-12 add-all-medium no-padd">
          <div class="col-sm-12 no-padd" id="other">
         <!--==================== end : table ============--> 
                <input type="hidden" name="first_conut_other" id="first_conut_other" class="form-control" value="0">
                <input type="hidden" name="count_other_contract" id="count_other_contract" class="form-control" value="0">
               
                <table  class="table  m-b-none table_other_contracts" >               
                    <thead>
                      <tr class="back-color-gray">
                        <th><?php echo freetext('firstname'); //First Name?></th>
                       <!--  <th><?php //echo freetext('lastname'); //Last Name?></th> -->
                        <th><?php echo freetext('function'); //Function?></th>
                        <th><?php echo freetext('department');?></th>
                        <th><?php echo freetext('tel'); //Function?></th>
                        <th><?php echo freetext('tel_ext'); //Function?></th>
                        <th><?php echo freetext('fax'); //Function?></th>
                        <th><?php echo freetext('fax_ext'); //Function?></th> 
                        <th><?php echo freetext('mobile_phone'); //mobile phone?></th>
                        <th><?php echo freetext('email'); //mobile phone?></th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                      $count_row_contact =0;   
                    //GET :: sap_tbm_contact
                    if(!empty($ship_to_id) && $is_prospect ==0 ){
                      //echo "ship_to";              
                      $this->db->select('sap_tbm_contact.*');
                      $this->db->where('sap_tbm_contact.ship_to_id', $ship_to_id);
                      $query_sap_tbm_contact= $this->db->get('sap_tbm_contact');
                      $temp_query_sap_tbm_contact = $query_sap_tbm_contact->row_array();
                      if(!empty($temp_query_sap_tbm_contact)){ 
                      foreach($query_sap_tbm_contact->result_array() as $value){
                        $count_row_contact++; 
                    ?>
                     <tr id="<?php echo $value['id']; ?>">
                        <td><?php echo $value['title'].' '.$value['firstname'].' '.$value['lastname'];?></td>
                        <!-- <td><?php //echo $value['lastname'];?></td> -->
                        <td><?php if(!empty($value['function_des'])){ echo $value['function_des']; }else{ echo "-"; }?></td>
                        <td><?php if(!empty($value['department_des'])){ echo $value['department_des']; }else{ echo "-"; }?></td>
                        <td><?php if(!empty($value['tel'])){ echo $value['tel']; }else{ echo "-"; }?></td>
                        <td><?php if(!empty($value['tel_ext'])){ echo $value['tel_ext']; }else{ echo "-"; }?></td>
                        <td><?php if(!empty($value['fax'])){ echo $value['fax']; }else{ echo "-"; }?></td>
                        <td><?php if(!empty($value['fax_ext'])){ echo $value['fax_ext']; }else{ echo "-"; }?></td>
                        <td><?php if(!empty($value['mobile'])){ echo $value['mobile']; }else{ echo "-"; }?></td>
                        <td><?php if(!empty($value['email'])){ echo $value['email']; }else{ echo "-"; }?></td>
                        <td></td>
                      </tr>
                    <?php
                        }//end foreach
                      }//end if                    
                    }else{
                      //echo "prospect";
                    }
                    ?>

                      <?php 
                          $temp_query_contact = $query_contact->result_array();
                                    

                        if(!empty($temp_query_contact)){                            
                            foreach($query_contact->result_array() as $value){
                              //if($is_prospect==1 && $value['prospect_id']==$sold_to_id){ 
                              if($value['quotation_id']==$this->quotation_id || ($is_prospect==1 && $value['prospect_id']==$sold_to_id) ){   
                              $count_row_contact++;                           
                          ?>
                          <tr id="<?php echo $value['id']; ?>">
                            <td><?php echo $value['title'].' '.$value['firstname'].' '. $value['lastname'];?></td>
                            <!-- <td><?php //echo $value['lastname'];?></td> -->
                            <td><?php if(!empty($value['function_title'])){ echo $value['function_title']; }else{ echo "-"; }?></td>
                            <td><?php if(!empty($value['department_title'])){ echo $value['department_title']; }else{ echo "-"; }?></td>
                            <td><?php if(!empty($value['tel'])){ echo $value['tel']; }else{ echo "-"; }?></td>
                            <td><?php if(!empty($value['tel_ext'])){ echo $value['tel_ext']; }else{ echo "-"; }?></td>
                            <td><?php if(!empty($value['fax'])){ echo $value['fax']; }else{ echo "-"; }?></td>
                            <td><?php if(!empty($value['fax_ext'])){ echo $value['fax_ext']; }else{ echo "-"; }?></td>
                            <td><?php if(!empty($value['mobile_no'])){ echo $value['mobile_no']; }else{ echo "-"; }?></td>
                            <td><?php if(!empty($value['email'])){ echo $value['email']; }else{ echo "-"; }?></td>
                            
                          </tr>
                          <?php
                                }//end if
                              }//end foreach
                            }else{ 
                          ?>                                   
                         <!--  <tr>
                              <td colspan='7'><?php //echo 'ไม่มีข้อมูล';?></td>                                              
                          </tr> -->
                        <?php 
                            }//end if temp                   
                            
                            if($count_row_contact==0){
                                echo "<tr><td colspan='7'>ไม่มีข้อมูล</td></tr>";
                            }//end if
                       ?>
                    </tbody> 
                   
                 <!--  </tfoot>
                </tfoot> -->


                </table>
          <!--==================== end : table ============-->
           </div>
            <div class='clear:both'></div>
             
          </div> <!-- end : col12 -->                        
      </div><!--end : form-group -->
  </div><!--end : panel-body -->
</section>
</div>


<!--################################ start :tab contract and other ############################-->





<!-- /////////// form submit ///////////////////-->
<div class="form-group col-sm-12 ">
  <div class="pull-right">
    <a href="<?php echo site_url($this->page_controller.'/listview/'.$this->quotation_id); ?>"  class="btn btn-info" style="width:120px;"> <?php echo freetext('back'); ?></a>
   
  </div>
</div>
<!-- end : form submit -->



</div><!-- end : class div_detail -->


          











