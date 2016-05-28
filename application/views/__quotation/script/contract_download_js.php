<script type="text/javascript">

var a = ['','One ','Two ','Three ','Four ', 'Five ','Six ','Seven ','Eight ','Nine ','Ten ','Eleven ','Twelve ','Thirteen ','Fourteen ','Fifteen ','Sixteen ','Seventeen ','Eighteen ','Nineteen '];
var b = ['', '', 'Twenty','Thirty','Forty','Fifty', 'Sixty','Seventy','Eighty','Ninety'];

function inWords (num) {
    if ((num = num.toString()).length > 9) return 'overflow';
    n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
    if (!n) return; var str = '';
    str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'Crore ' : '';
    str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'Lakh ' : '';
    str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'Thousand ' : '';
    str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'Hundred ' : '';
    str += (n[5] != 0) ? ((str != '') ? 'and ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) + '' : '';
    return str;
}

Number.prototype.MoneyToWord = function() {

    var money = this;
    var result = '';
    var minus = '';

    if (money < 0) {
        minus = 'ติดลบ';
        money = money * -1;
    }

    money = parseFloat(Math.round(money * 100) / 100).toFixed(2);

    if (money == '0.00') {
        result = 'ศูนย์บาทถ้วน';
        return result;
    }

    var numbers = ['', 'หนึ่ง', 'สอง', 'สาม', 'สี่', 'ห้า', 'หก', 'เจ็ด', 'แปด', 'เก้า'];
    var positions = ['', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน'];

    var digit = money.length;
    var inputs = [];

    if (digit <= 15) {
        if (digit > 9) {
            inputs[0] = money.substr(0, digit - 9);
            inputs[1] = money.substr(inputs[0].length, 6);
        } else {
            inputs[0] = '00';
            inputs[1] = money.substr(0, money.length - 3);
        }
        inputs[2] = money.substr(money.indexOf('.') + 1, 2);
    } else {
        result = 'Error: ไม่สามารถรองรับจำนวนเงินที่เกินหลักแสนล้าน';
        return result;
    }

    for (i = 0; i < 3; i ++) {
        var input = inputs[i];

        if (input != '0' && input != '00') {
            var digit = input.length;

            for (j = 0; j < digit; j ++) {
                var s = input.substr(j, 1);
                var number = numbers[s];
                var position = '';

                if (number != '') {
                    position = positions[digit - (j + 1)];
                }

                if ((digit - j) == 2) {
                    if (s == '1') {
                        number = '';
                    } else if (s == '2') {
                        number = 'ยี่';
                    }
                } else if ((digit - j) == 1 && (digit != 1)) {
                    var pre_s = '0';
                    if (j > 0) {
                        pre_s = input.substr(j - 1, 1);
                    }

                    if (i == 0) {
                        if (pre_s != '0') {
                            if (s == '1') {
                                number = 'เอ็ด';
                            }
                        }
                    } else {
                        if (s == '1') {
                            number = 'เอ็ด';
                        }
                    }
                }

                result = result + number + position;
            }
        }

        if (i == 0) {
            if (input != '00') {
                result = result + 'ล้าน';
            }
        } else if (i == 1) {
            if (input != '0' && input != '00') {
                result = result + 'บาท';
                if (inputs[2] == '00') {
                    result = result + 'ถ้วน';
                }
            }
        } else {
            if (input != '00') {
                result = result + 'สตางค์';
            }
        }
    }

    return minus + result;
}

Number.prototype.toMoney = function(decimals, decimal_sep, thousands_sep)
{ 
   var n = this,
   c = isNaN(decimals) ? 2 : Math.abs(decimals), //if decimal is zero we must take it, it means user does not want to show any decimal
   d = decimal_sep || '.', //if no decimal separator is passed we use the dot as default decimal separator (we MUST use a decimal separator)

   t = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep, //if you don't want to use a thousands separator you can pass empty string as thousands_sep value

   sign = (n < 0) ? '-' : '',

   //extracting the absolute value of the integer part of the number and converting to string
   i = parseInt(n = Math.abs(n).toFixed(c)) + '', 

   j = ((j = i.length) > 3) ? j % 3 : 0; 
   return sign + (j ? i.substr(0, j) + t : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : ''); 
}

function isInteger(n) {
   return n % 1 === 0;
}

function isInt(evt)
{
   var charCode = (evt.which) ? evt.which : event.keyCode
   if (charCode > 31 && (charCode < 48 || charCode > 57))
      return false;

   return true;
}

function isDouble(evt)
{
   var charCode = (evt.which) ? evt.which : event.keyCode
   if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 46)
      return false;

   return true;
}

function replaceComma (text) {
  text = text.replace(',', '');

  if (text.indexOf(',') >= 0) {
    return replaceComma(text);
  } else {
    return text;
  }
}

function insertComma (val) {
    
    val = replaceComma(val);

    var last_index = val.substr(val.length-1);
    if (last_index == '.') {
      return true;
    }

    var isint = isInteger(parseFloat(val));

    if (isint) {
      val = parseFloat(val).toMoney(0);
    } else {
      var seperator = val.indexOf('.');
      var decimal   = val.substr(seperator+1);
      val = parseFloat(val).toMoney(decimal.length);
    }

    val = val.toString();   

    return val;
}

<?php
    $quotation = $query_quotation->row_array();
    $quotation_id = $quotation['id'];
    $last_three_digits = substr($quotation_id, 8);

    if ($last_three_digits != '00') {
        $quotation_id = substr($quotation_id, 0, 8).'00';
        $quotation = $this->__ps_project_query->getObj('tbt_quotation', array('id' => $quotation_id));
        $summary_data = $this->__ps_project_query->getObj('tbt_summary', array('quotation_id' => $quotation_id));
    }    

    $month_mapping_th = array(
        'มกราคม', 
        'กุมภาพันธ์',
        'มีนาคม',
        'เมษายน',
        'พฤษภาคม',
        'มิถุนายน',
        'กรกฎาคม',
        'สิงหาคม',
        'กันยายน',
        'ตุลาคม',
        'พฤศจิกายน',
        'ธันวาคม'
    );   

    $unit_time_th = array(
        'day'   => 'วัน',
        'month' => 'เดือน',
        'year'  => 'ปี'
    );

    $quot_lead_letter = 'Q';
    $quot_year        = '';
    $contract_year    = '';

    $plant_code = "";

    if (!empty($quotation)) {

        if ($quotation['is_prospect'] == 1) {
            $quot_lead_letter = '0';
        }

        $ship_to = $this->__ps_project_query->getObj('sap_tbm_ship_to', array('id' => $quotation['ship_to_id']));
        $plant = $this->__ps_project_query->getObj('sap_tbm_plant', array('plant_code' => $ship_to['plant_code']));
        if (!empty($plant)) {
            $plant_code = $plant['doc_code'];
        }

        $quot_year = substr($quotation['create_date'], 2,2);
        $contract_year = substr($quotation['project_start'], 2,2);

        $sale_name = "";
        $sale_position = "";

        $sale = $this->__ps_project_query->getObj('tbt_user', array('employee_id' => $quotation['project_owner_id']));
        $man_group = $this->__ps_project_query->getObj('tbt_man_group', array('quotation_id' => $quotation['id']));

        if (!empty($sale)) {
            $sale_name = $sale['user_firstname'].' '.$sale['user_lastname'];
            $user_position = $this->__ps_project_query->getObj('tbt_user_position', array('employee_id' => $quotation['project_owner_id']));
            if (!empty($user_position)) {
                $position = $this->__ps_project_query->getObj('tbm_position', array('id' => $user_position['position_id']));
                if (!empty($position)) {
                    $sale_position = $position['title'];
                }
            }
        }

        $sold_to_region_title ='';
        $temp_bapi_region= $bapi_region->result_array();
        if(!empty($temp_bapi_region)){
            foreach($bapi_region->result_array() as $value){         
                if($quotation['sold_to_region']== $value['id']){  
                    $sold_to_region_title  = $value['title'];
                }

            }//end foreach
        }else{  $sold_to_region_title = ''; }

        $ship_to_region_title ='';
        $temp_bapi_region= $bapi_region->result_array();
        if(!empty($temp_bapi_region)){
            foreach($bapi_region->result_array() as $value){         
                if($quotation['ship_to_region']== $value['id']){                                          
                    $ship_to_region_title  = $value['title'];
                }

            }//end foreach
        }else{  $ship_to_region_title = ''; }

        $ship_to_en = $this->__ps_project_query->getObj('sap_tbm_ship_to_en', array('id' => $quotation['ship_to_id']));
        $ship_to_region_title_en ='';
        $temp_bapi_region= $bapi_region->result_array();
        if(!empty($temp_bapi_region)){
            foreach($bapi_region->result_array() as $value){         
                if($ship_to_en['ship_to_region']== $value['id']){                                          
                    $ship_to_region_title_en  = $value['title'];
                }

            }//end foreach
        }else{  $ship_to_region_title_en = ''; }

        $sold_to_en = $this->__ps_project_query->getObj('sap_tbm_sold_to_en', array('id' => $quotation['sold_to_id']));
        $sold_to_region_title_en ='';
        $temp_bapi_region= $bapi_region->result_array();
        if(!empty($temp_bapi_region)){
            foreach($bapi_region->result_array() as $value){         
                if($sold_to_en['sold_to_region']== $value['id']){                                          
                    $sold_to_region_title_en  = $value['title'];
                }

            }//end foreach
        }else{  $sold_to_region_title_en = ''; }

?>
    var loadFile=function(url,callback){
        JSZipUtils.getBinaryContent(url,callback);
    }

    $('.download_quotation_en').on('click', function () { 
        <?php
            $quotation_file = my_url('assets/upload/doc_template/QuotationEn.docx');
            if ($quotation['job_type'] != 'ZQT1') {
                $quotation_file = my_url('assets/upload/doc_template/QuotationOneEn.docx');
            }
        ?>

        loadFile("<?php echo $quotation_file; ?>",function(err,content){

            var monthly_fee = "<?php if (!empty($summary_data) && !empty($summary_data['total_variant_price'])) { echo $summary_data['total_variant_price']; } else if (!empty($summary_data) && !empty($summary_data['total_bottom_price'])) { echo $summary_data['total_bottom_price']; } ?>";
            if (monthly_fee != "") {
                monthly_fee =parseFloat(monthly_fee);  
                monthly_fee = monthly_fee.toFixed(2);
                //monthly_fee = insertComma(monthly_fee);   
                 monthly_fee = commaSeparateNumber(monthly_fee); 
            }

            var total_tax = "<?php if (!empty($summary_data) && !empty($summary_data['vat'])) { echo $summary_data['vat']; } ?>";              
            if (total_tax != "") {
                total_tax =parseFloat(total_tax);  
                total_tax = total_tax.toFixed(2);
                //total_tax = insertComma(total_tax);
                total_tax = commaSeparateNumber(total_tax);   
            }

            var letter_of_sum = "";
            var sum = "<?php if (!empty($summary_data) && !empty($summary_data['total_variant_price'])) { echo floatval($summary_data['total_variant_price'])+floatval($summary_data['vat']); } else if (!empty($summary_data) && !empty($summary_data['total_bottom_price'])) { echo floatval($summary_data['total_bottom_price'])+floatval($summary_data['vat']); } ?>";
            if (sum != "") {
                sum = parseFloat(sum).toFixed(2);
                sum = sum.toString();
                var parts = sum.split('.');
                if (parts.length == 2 && parts[1] != '00') {
                    letter_of_sum = inWords(parts[0])+'Baht and '+inWords(parts[1])+'Stang Only';
                } else {
                    letter_of_sum = inWords(parts[0])+'Baht Only';
                }

                sum =parseFloat(sum);  
                sum = sum.toFixed(2);
                //sum = insertComma(sum);
                sum = commaSeparateNumber(sum);  
            }

            doc = new Docxgen(content)
            doc.setData( 
                {
                    "Quotation ID"                  : "<?php echo $quot_lead_letter.''.$quot_year.''.$plant_code.'-'.$quotation['id']; ?>",
                    "Day"                           : "<?php echo date('j', strtotime($quotation['create_date'])); ?>",
                    "Month"                         : "<?php echo date('F', strtotime($quotation['create_date'])); ?>",
                    "Year"                          : "<?php echo date('Y', strtotime($quotation['create_date'])); ?>",
                    'staff'                         : "<?php if (!empty($man_group) && !empty($man_group['staff'])) { echo $man_group['staff']; } ?>",
                    "Customer Name"                 : "<?php if (!empty($sold_to_en['sold_to_name'])) { echo $sold_to_en['sold_to_name'].' '; } ?>",
                    "Customer Address 1"            : "<?php if (!empty($sold_to_en['sold_to_address1'])) { echo $sold_to_en['sold_to_address1'].' '; } if (!empty($sold_to_en['sold_to_address2'])) { echo $sold_to_en['sold_to_address2'].' '; } if (!empty($sold_to_en['sold_to_address3'])) { echo $sold_to_en['sold_to_address3'].' '; } if (!empty($sold_to_en['sold_to_address4'])) { echo $sold_to_en['sold_to_address4']; } ?>",
                    "Customer Address 2"            : "<?php if (!empty($sold_to_en['sold_to_district'])) { echo $sold_to_en['sold_to_district'].' '; } if (!empty($sold_to_en['sold_to_city'])) { echo $sold_to_en['sold_to_city'].' '; } if (!empty($sold_to_region_title_en)) { echo $sold_to_region_title_en.' '; } if (!empty($sold_to_en['sold_to_postal_code'])) { echo $sold_to_en['sold_to_postal_code']; }  ?>",                  
                    "Address 1"                     : "<?php echo $ship_to_en['ship_to_name1']; ?>",
                    "Address 2"                     : "<?php if (!empty($ship_to_en['ship_to_address1'])) { echo $ship_to_en['ship_to_address1'].' '; } if (!empty($ship_to_en['ship_to_address2'])) { echo $ship_to_en['ship_to_address2'].' '; } if (!empty($ship_to_en['ship_to_address3'])) { echo $ship_to_en['ship_to_address3'].' '; } if (!empty($ship_to_en['ship_to_address4'])) { echo $ship_to_en['ship_to_address4']; } ?>",
                    "Address 3"                     : "<?php if (!empty($ship_to_en['ship_to_district'])) { echo $ship_to_en['ship_to_district'].' '; } if (!empty($ship_to_en['ship_to_city'])) { echo $ship_to_en['ship_to_city'].' '; } if (!empty($ship_to_region_title_en)) { echo $ship_to_region_title_en.' '; } if (!empty($ship_to_en['ship_to_postal_code'])) { echo $ship_to_en['ship_to_postal_code']; } ?>",
                    "Monthly Fee"                   : monthly_fee,
                    "Tax"                           : "<?php if (!empty($summary_data) && !empty($summary_data['mpercent_vat'])) { echo $summary_data['mpercent_vat']; } ?>",
                    "Total Tax"                     : total_tax,
                    "Sum"                           : sum,
                    "Letter of sum"                 : '('+letter_of_sum+')'
                }
            ) //set the templateVariables
            doc.render() //apply them (replace all occurences of {first_name} by Hipp, ...)
            out=doc.getZip().generate({type:"blob"}) //Output the document using Data-URI
            saveAs(out,"Quotation.docx")
        });

    });

    $('.download_quotation_th').on('click', function () { 
        <?php
            $quotation_file = my_url('assets/upload/doc_template/Quotation.docx');
            if ($quotation['job_type'] != 'ZQT1') {
                $quotation_file = my_url('assets/upload/doc_template/QuotationOne.docx');
            }
        ?>

        loadFile("<?php echo $quotation_file; ?>",function(err,content){

            var monthly_fee = "<?php if (!empty($summary_data) && !empty($summary_data['total_variant_price'])) { echo $summary_data['total_variant_price']; } else if (!empty($summary_data) && !empty($summary_data['total_bottom_price'])) { echo $summary_data['total_bottom_price']; } ?>";
            if (monthly_fee != "") {
                monthly_fee =parseFloat(monthly_fee);  
                monthly_fee = monthly_fee.toFixed(2);
                //monthly_fee = insertComma(monthly_fee); 
                monthly_fee = commaSeparateNumber(monthly_fee); 

            }

            var total_tax = "<?php if (!empty($summary_data) && !empty($summary_data['vat'])) { echo $summary_data['vat']; } ?>";              
            if (total_tax != "") {
                total_tax =parseFloat(total_tax);  
                total_tax = total_tax.toFixed(2);
                //total_tax = insertComma(total_tax); 
                total_tax = commaSeparateNumber(total_tax);  
            }

            var letter_of_sum = "";
            var sum = "<?php if (!empty($summary_data) && !empty($summary_data['total_variant_price'])) { echo floatval($summary_data['total_variant_price'])+floatval($summary_data['vat']); } else if (!empty($summary_data) && !empty($summary_data['total_bottom_price'])) { echo floatval($summary_data['total_bottom_price'])+floatval($summary_data['vat']); } ?>";
            if (sum != "") {
                letter_of_sum = parseFloat(sum).MoneyToWord();
                sum =parseFloat(sum);  
                sum = sum.toFixed(2);
                //sum = insertComma(sum);
                sum = commaSeparateNumber(sum); 
            }

            doc = new Docxgen(content)
            doc.setData( 
                {
                    "Quotation ID"                  : "<?php echo $quot_lead_letter.''.$quot_year.''.$plant_code.'-'.$quotation['id']; ?>",                    
                    "Address 1"                     : "<?php echo $quotation['ship_to_name1'].' '.$quotation['ship_to_name2']; ?>",
                    "Address 2"                     : "<?php if (!empty($quotation['ship_to_address1'])) { echo $quotation['ship_to_address1'].' '; } if (!empty($quotation['ship_to_address2'])) { echo $quotation['ship_to_address2'].' '; } if (!empty($quotation['ship_to_address3'])) { echo $quotation['ship_to_address3'].' '; } if (!empty($quotation['ship_to_address4'])) { echo $quotation['ship_to_address4']; } ?>",
                    "Address 3"                     : "<?php if (!empty($quotation['ship_to_district'])) { echo $quotation['ship_to_district'].' '; } if (!empty($quotation['ship_to_city'])) { echo $quotation['ship_to_city'].' '; } if (!empty($ship_to_region_title)) { echo $ship_to_region_title.' '; } if (!empty($quotation['ship_to_postal_code'])) { echo $quotation['ship_to_postal_code']; } ?>",
                    "Monthly Fee"                   : monthly_fee,
                    "Tax"                           : "<?php if (!empty($summary_data) && !empty($summary_data['mpercent_vat'])) { echo $summary_data['mpercent_vat']; } ?>",
                    "Total Tax"                     : total_tax,
                    "Sum"                           : sum,
                    "Letter of sum"                 : '('+letter_of_sum+')',
                    "Employee Name"                 : "<?php if (!empty($sale_name)) { echo $sale_name; } ?>",
                    "Employee Position"             : "<?php if (!empty($sale_position)) { echo $sale_position; } ?>",
                    "Time"                          : "<?php echo $quotation['time']; ?>",
                    "Unit Time"                     : "<?php echo $unit_time_th[$quotation['unit_time']]; ?>"
                }
            ) //set the templateVariables
            doc.render() //apply them (replace all occurences of {first_name} by Hipp, ...)
            out=doc.getZip().generate({type:"blob"}) //Output the document using Data-URI
            saveAs(out,"ใบเสนอราคา.docx")
        });

    });

    $('.download_contract_th').on('click', function () { 
        //alert('download_contract_th');

        loadFile("<?php echo my_url('assets/upload/doc_template/ContractTH.docx'); ?>",function(err,content){

            var monthly_fee = "<?php if (!empty($summary_data) && !empty($summary_data['total_variant_price'])) { echo $summary_data['total_variant_price']; } else if (!empty($summary_data) && !empty($summary_data['total_bottom_price'])) { echo $summary_data['total_bottom_price']; } ?>";
            if (monthly_fee != "") {
                //monthly_fee = insertComma(monthly_fee);
                monthly_fee =parseFloat(monthly_fee);  
                monthly_fee = monthly_fee.toFixed(2);                
                monthly_fee = commaSeparateNumber(monthly_fee);   
            }

            var total_tax = "<?php if (!empty($summary_data) && !empty($summary_data['vat'])) { echo $summary_data['vat']; } ?>";              
            if (total_tax != "") {
                //total_tax = insertComma(total_tax); 
                total_tax =parseFloat(total_tax);  
                total_tax = total_tax.toFixed(2);
                total_tax = commaSeparateNumber(total_tax);  
            }

            var letter_of_sum = "";
            var sum = "<?php if (!empty($summary_data) && !empty($summary_data['total_variant_price'])) { echo floatval($summary_data['total_variant_price'])+floatval($summary_data['vat']); } else if (!empty($summary_data) && !empty($summary_data['total_bottom_price'])) { echo floatval($summary_data['total_bottom_price'])+floatval($summary_data['vat']); } ?>";
            if (sum != "") {
                letter_of_sum = parseFloat(sum).MoneyToWord();
                //sum = insertComma(sum);
                sum =parseFloat(sum);  
                sum = sum.toFixed(2);                
                sum = commaSeparateNumber(sum); 
            }

            var letter_of_total = "";
            var total_sum = "<?php if (!empty($summary_data) && !empty($summary_data['total_variant_price'])) { echo (floatval($summary_data['total_variant_price'])+floatval($summary_data['vat']))*floatval($quotation['time']); } else if (!empty($summary_data) && !empty($summary_data['total_bottom_price'])) { echo (floatval($summary_data['total_bottom_price'])+floatval($summary_data['vat']))*floatval($quotation['time']); } ?>";
            if (total_sum != "") {
                letter_of_total = parseFloat(total_sum).MoneyToWord();
                //total_sum = insertComma(total_sum);
                total_sum =parseFloat(total_sum);  
                total_sum = total_sum.toFixed(2);                
                total_sum = commaSeparateNumber(total_sum); 
            }

            doc = new Docxgen(content)
            doc.setData( 
                {
                    "Contract ID"                   : "<?php echo 'C'.$contract_year.''.$plant_code.'-'.$quotation['contract_id'].'-'.$quotation['ship_to_id']; ?>",
                    "Day"                           : "<?php echo date('j', strtotime($quotation['create_date'])); ?>",
                    "Month"                         : "<?php echo $month_mapping_th[intval(date('n', strtotime($quotation['create_date'])))-1]; ?>",
                    "Year"                          : "<?php echo date('Y', strtotime($quotation['create_date'])); ?>",
                    "Customer Company Name"         : "<?php echo $quotation['sold_to_name1']; ?>",
                    "Customer Sign Name"            : "<?php echo $bapi_customer_Z005['firstname'].' '.$bapi_customer_Z005['lastname']; ?>",
                    "Customer Name"                 : "",
                    "Customer Position"             : "<?php echo $bapi_customer_Z005['function_des']; ?>",
                    "Address 1"                     : "<?php if (!empty($quotation['sold_to_address1'])) { echo $quotation['sold_to_address1'].' '; } if (!empty($quotation['sold_to_address2'])) { echo $quotation['sold_to_address2'].' '; } if (!empty($quotation['sold_to_address3'])) { echo $quotation['sold_to_address3'].' '; } if (!empty($quotation['sold_to_address4'])) { echo $quotation['sold_to_address4']; } ?>",
                    "Address 2"                     : "<?php if (!empty($quotation['sold_to_district'])) { echo $quotation['sold_to_district'].' '; } if (!empty($quotation['sold_to_city'])) { echo $quotation['sold_to_city'].' '; } if (!empty($sold_to_region_title)) { echo $sold_to_region_title.' '; } if (!empty($quotation['sold_to_postal_code'])) { echo $quotation['sold_to_postal_code']; }  ?>",
                    "Start Date"                    : "<?php echo common_easyDateFormat($quotation['project_start']); ?>",
                    "End Date"                      : "<?php echo common_easyDateFormat($quotation['project_end']); ?>",
                    "Contract Time"                 : "<?php echo $quotation['time']; ?>",
                    "Contract Unit Time"            : "<?php echo $unit_time_th[$quotation['unit_time']]; ?>",
                    "Monthly Fee"                   : monthly_fee,//monthly_fee
                    "Tax"                           : "<?php if (!empty($summary_data) && !empty($summary_data['mpercent_vat'])) { echo $summary_data['mpercent_vat']; } ?>",
                    "Total Tax"                     : total_tax,//total_tax
                    "Sum"                           : sum,//sum
                    "Letter of sum"                 : '('+letter_of_sum+')',//letter_of_sum
                    "Total Sum"                     : total_sum,//total_sum
                    "Letter of total"               : '('+letter_of_total+')',//letter_of_total
                    "Customer Witness"              : "<?php echo $bapi_customer1['firstname'].' '.$bapi_customer1['lastname']; ?>",
                    "Customer Witness Position"     : "<?php echo $bapi_customer1['function_des']; ?>",
                    "Customer Witness2"              : "<?php echo $bapi_customer2['firstname'].' '.$bapi_customer2['lastname']; ?>",
                    "Customer Witness Position2"     : "<?php echo $bapi_customer2['function_des']; ?>",
                    "Customer Witness3"              : "<?php echo $bapi_customer3['firstname'].' '.$bapi_customer3['lastname']; ?>",
                    "Customer Witness Position3"     : "<?php echo $bapi_customer3['function_des']; ?>",
                    "Customer Witness4"              : "<?php echo $query_nameEmp['user_firstname'].' '.$query_nameEmp['user_lastname']; ?>",
                    "Customer Witness Posi"          : "<?php echo $temp_position_des['title']; ?>",
                }
            ) //set the templateVariables
            doc.render() //apply them (replace all occurences of {first_name} by Hipp, ...)
            out=doc.getZip().generate({type:"blob"}) //Output the document using Data-URI
            saveAs(out,"สัญญาว่าจ้างทำความสะอาด.docx")
        });

    });

    $('.download_contract_en').on('click', function () { 

        loadFile("<?php echo my_url('assets/upload/doc_template/ContractEN.docx'); ?>",function(err,content){

            var monthly_fee = "<?php if (!empty($summary_data) && !empty($summary_data['total_variant_price'])) { echo $summary_data['total_variant_price']; } else if (!empty($summary_data) && !empty($summary_data['total_bottom_price'])) { echo $summary_data['total_bottom_price']; } ?>";
            if (monthly_fee != "") {
                monthly_fee = insertComma(monthly_fee);   
            }

            var letter_of_sum = "";
            if (monthly_fee != "") {
                monthly_fee = parseFloat(monthly_fee).toFixed(2);
                monthly_fee = monthly_fee.toString();
                var parts = monthly_fee.split('.');
                if (parts.length == 2 && parts[1] != '00') {
                    letter_of_sum = inWords(parts[0])+'Baht and '+inWords(parts[1])+'Stang Only';
                } else {
                    letter_of_sum = inWords(parts[0])+'Baht Only';
                }
            }

            doc = new Docxgen(content)
            doc.setData( 
                {
                    "Contract ID"                   : "<?php echo 'C'.$contract_year.''.$plant_code.'-'.$quotation['contract_id'].'-'.$quotation['ship_to_id']; ?>",
                    "Customer Company Name"         : "<?php echo $sold_to_en['sold_to_name']; ?>",
                    "Customer Sign Name"            : "",
                    "Customer Name"                 : "<?php echo $bapi_customer_Z005['firstname'].' '.$bapi_customer_Z005['lastname']; ?>",
                    "Customer Position"             : "<?php echo $bapi_customer_Z005['function_des']; ?>",
                    "Address 1"                     : "<?php if (!empty($sold_to_en['sold_to_address1'])) { echo $sold_to_en['sold_to_address1'].' '; } if (!empty($sold_to_en['sold_to_address2'])) { echo $sold_to_en['sold_to_address2'].' '; } if (!empty($sold_to_en['sold_to_address3'])) { echo $sold_to_en['sold_to_address3'].' '; } if (!empty($sold_to_en['sold_to_address4'])) { echo $sold_to_en['sold_to_address4']; } ?>",
                    "Address 2"                     : "<?php if (!empty($sold_to_en['sold_to_district'])) { echo $sold_to_en['sold_to_district'].' '; } if (!empty($sold_to_en['sold_to_city'])) { echo $sold_to_en['sold_to_city'].' '; } if (!empty($sold_to_region_title_en)) { echo $sold_to_region_title_en.' '; } if (!empty($sold_to_en['sold_to_postal_code'])) { echo $sold_to_en['sold_to_postal_code']; }  ?>",
                    "Start Date"                    : "<?php echo common_easyDateFormat($quotation['project_start']); ?>",
                    "End Date"                      : "<?php echo common_easyDateFormat($quotation['project_end']); ?>",
                    "Contract Time"                 : "<?php echo $quotation['time']; ?>",
                    "Contract Unit Time"            : "<?php if ($unit_time_th[$quotation['unit_time']] == 'เดือน') { echo 'Months'; } else if ($unit_time_th[$quotation['unit_time']] == 'วัน') { echo 'Days'; } else if ($unit_time_th[$quotation['unit_time']] == 'ปี') { echo 'Year'; } ?>",
                    "Shipto Address 1"              : "<?php echo $ship_to_en['ship_to_name1'].' '.$ship_to_en['ship_to_name2']; ?>",
                    "Shipto Address 2"              : "<?php if (!empty($ship_to_en['ship_to_address1'])) { echo $ship_to_en['ship_to_address1'].' '; } if (!empty($ship_to_en['ship_to_address2'])) { echo $ship_to_en['ship_to_address2'].' '; } if (!empty($ship_to_en['ship_to_address3'])) { echo $ship_to_en['ship_to_address3'].' '; } if (!empty($ship_to_en['ship_to_address4'])) { echo $ship_to_en['ship_to_address4']; } ?>",
                    "Shipto Address 3"              : "<?php if (!empty($ship_to_en['ship_to_district'])) { echo $ship_to_en['ship_to_district'].' '; } if (!empty($ship_to_en['ship_to_city'])) { echo $ship_to_en['ship_to_city'].' '; } if (!empty($ship_to_region_title_en)) { echo $ship_to_region_title_en.' '; } if (!empty($ship_to_en['ship_to_postal_code'])) { echo $ship_to_en['ship_to_postal_code']; } ?>",
                    "Monthly Fee"                   : monthly_fee,
                    "Tax"                           : "<?php if (!empty($summary_data) && !empty($summary_data['mpercent_vat'])) { echo $summary_data['mpercent_vat']; } ?>",
                    "Letter of sum"                 : '('+letter_of_sum+')',
                    "Customer Witness"              : "<?php echo $bapi_customer1['firstname'].' '.$bapi_customer1['lastname']; ?>",
                    "Customer Witness Position"     : "<?php echo $bapi_customer1['function_des']; ?>",
                    "Customer Witness2"              : "<?php echo $bapi_customer2['firstname'].' '.$bapi_customer2['lastname']; ?>",
                    "Customer Witness Position2"     : "<?php echo $bapi_customer2['function_des']; ?>",
                    "Customer Witness3"              : "<?php echo $bapi_customer3['firstname'].' '.$bapi_customer3['lastname']; ?>",
                    "Customer Witness Position3"     : "<?php echo $bapi_customer3['function_des']; ?>",
                    "Customer Witness4"              : "<?php echo $query_nameEmp['user_firstname'].' '.$query_nameEmp['user_lastname']; ?>",
                    "Customer Witness Posi"          : "<?php echo $temp_position_des['title']; ?>",
                }
            ) //set the templateVariables
            doc.render() //apply them (replace all occurences of {first_name} by Hipp, ...)
            out=doc.getZip().generate({type:"blob"}) //Output the document using Data-URI
            saveAs(out,"CLEANING SERVICES AGREEMENT.docx")
        });

    });

<?php
    }
?>

</script>

