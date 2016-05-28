<script>
  <?php
    $quotation_data = $query_quotation->row_array();
    // $quotation_data['job_type'] = 'ZQT2';
  ?>
  var job_type = "<?php echo $quotation_data['job_type']; ?>";
  var total_subgroup_staff = parseInt($('#tab7 .total_subgroup_staff').val());

  function preventNumber(evt) {
    var theEvent = evt || window.event;
    var key = theEvent.keyCode || theEvent.which;
    key = String.fromCharCode( key );
    var regex = /[0-9]|\./;
    if( !regex.test(key) ) {
      theEvent.returnValue = false;
      if(theEvent.preventDefault) theEvent.preventDefault();
    }
  }

  function reCalculate () {
    if (job_type == 'ZQT1') {

      var employee_cost_sum   = parseFloat($('#tab7 input[name="employee_cost_sum"]').val());
      var social_security     = parseFloat($('#tab7 input[name="social_security"]').val());
      var equipment           = parseFloat($('#tab7 input[name="equipment"]').val());
      var equipment_clearjob  = parseFloat($('#tab7 input[name="equipment_clearjob"]').val());

      // var insurance            = ($('#tab7 input[name="insurance"]').val() != '') ? parseFloat($('#tab7 input[name="insurance"]').val()) : 0;
      // var insurance_per_person = (parseFloat(insurance)/parseFloat(total_subgroup_staff)).toFixed(2);
  
      // $('#tab7 input.insurance_per_person').val(insurance_per_person);

      var subtotal = parseFloat(employee_cost_sum+social_security+equipment+equipment_clearjob).toFixed(2);
      //function comma
      subtotal = commaSeparateNumber(subtotal);
      $('#tab7 input.subtotal').val(subtotal);
      //function replacecomma
      subtotal = replaceComma(subtotal);

      var operation_cost = parseFloat(($('#tab7 input[name="mpercent_operation"]').val()/100)*subtotal).toFixed(2);
      //function comma
      operation_cost = commaSeparateNumber(operation_cost);
      $('#tab7 input.operation_cost').val(operation_cost);
      //function replacecomma
      operation_cost = replaceComma(operation_cost);

      var operation_cost_per_person = parseFloat(operation_cost/total_subgroup_staff).toFixed(2);
      //function comma
      operation_cost_per_person = commaSeparateNumber(operation_cost_per_person);
      $('#tab7 input.operation_cost_per_person').val(operation_cost_per_person);
      //function replacecomma
      operation_cost_per_person = replaceComma(operation_cost_per_person);

      var total_cost = (parseFloat(subtotal)+parseFloat(operation_cost)).toFixed(2);
       //function comma
      total_cost = commaSeparateNumber(total_cost);
      $('#tab7 input.total_cost').val(total_cost);
      //function replacecomma
      total_cost = replaceComma(total_cost);

      var margin = parseFloat(($('#tab7 input[name="mpercent_margin"]').val()/100)*total_cost).toFixed(2);
      $('#tab7 input.margin').val(margin);


      var margin_per_person = parseFloat(margin/total_subgroup_staff).toFixed(2);
      $('#tab7 input.margin_per_person').val(margin_per_person);

      var sale_quoted = (parseFloat(total_cost)+parseFloat(margin)).toFixed(2);
      //function comma
      sale_quoted = commaSeparateNumber(sale_quoted);
      $('#tab7 input.sale_quoted').val(sale_quoted);
      //function replacecomma
      sale_quoted = replaceComma(sale_quoted);

      var maximum_discount = ($('#tab7 input[name="maximum_discount"]').val() != '') ? parseFloat(replaceComma($('#tab7 input[name="maximum_discount"]').val())) : 0;
      var maximum_discount_per_person = 0;
      if (maximum_discount != undefined && maximum_discount != "") {
        maximum_discount = parseFloat(maximum_discount);
        maximum_discount_per_person = parseFloat(maximum_discount/total_subgroup_staff).toFixed(2);
      } else {
        maximum_discount = 0;
      }
      //function comma
      maximum_discount_per_person = commaSeparateNumber(maximum_discount_per_person);
      $('#tab7 input.maximum_discount_per_person').val(maximum_discount_per_person);
      //function replacecomma
      maximum_discount_per_person = replaceComma(maximum_discount_per_person);

      var final_sale_quoted = (parseFloat(sale_quoted)-parseFloat(maximum_discount)).toFixed(2);
       //function comma
      final_sale_quoted = commaSeparateNumber(final_sale_quoted);
      $('#tab7 input.final_sale_quoted').val(final_sale_quoted);
       //function replacecomma
      final_sale_quoted = replaceComma(final_sale_quoted);

      var other_service                 = parseFloat(replaceComma($('#tab7 input[name="other_service"]').val()));
      var sale_quote_and_other_service = (parseFloat(final_sale_quoted)+parseFloat(other_service)).toFixed(2);
       //function comma
      sale_quote_and_other_service = commaSeparateNumber(sale_quote_and_other_service);
      $('#tab7 input.sale_quote_and_other_service').val(sale_quote_and_other_service);
       //function replacecomma
      sale_quote_and_other_service = replaceComma(sale_quote_and_other_service);

      //function comma
      sale_quote_and_other_service = commaSeparateNumber(sale_quote_and_other_service);
      $('#tab7 input.total_bottom_price').val(sale_quote_and_other_service);
      //function replacecomma
      sale_quote_and_other_service = replaceComma(sale_quote_and_other_service);


      var bottom_price_per_person = (parseFloat(sale_quote_and_other_service/total_subgroup_staff).toFixed(2));
      //function comma
      bottom_price_per_person = commaSeparateNumber(bottom_price_per_person);
      $('#tab7 input.bottom_price_per_person').val(bottom_price_per_person);
      //function replacecomma
      bottom_price_per_person = replaceComma(bottom_price_per_person);


      var vat = parseFloat(($('#tab7 input[name="mpercent_vat"]').val()/100)*sale_quote_and_other_service).toFixed(2);
      //function comma
      vat = commaSeparateNumber(vat);
      $('#tab7 input.vat').val(vat);
      //function replacecomma
      vat = replaceComma(vat);

      var total = (parseFloat(sale_quote_and_other_service)+parseFloat(vat)).toFixed(2);
      //function comma
      total = commaSeparateNumber(total);
      $('#tab7 input.total').val(total);

      var last = $('#tab7 .employee_level_price').length;
      var count = 1;
      var variant_val = $('#tab7 .total_variant_price').val();
      //function replacecomma
      variant_val = replaceComma(variant_val);
      if (variant_val == 0 || variant_val == "" || variant_val == null) {
        variant_val = parseFloat($('#tab7 .total_bottom_price').val());
      } else {
        variant_val = parseFloat(variant_val);
      }

      $('#tab7 .employee_level_price').each(function () {
          var id = $(this).data('id');
          var staff_total = parseInt($('.total_staff_'+id).val());
          
          var clearjob_employee_cost_per_person   = ($('#tab7 input[name="clearjob_employee_cost_per_person"]').val() != "") ? parseFloat(replaceComma($('#tab7 input[name="clearjob_employee_cost_per_person"]').val())) : 0;
          var social_security_per_person          = ($('#tab7 input[name="social_security_per_person"]').val() != "") ? parseFloat(replaceComma($('#tab7 input[name="social_security_per_person"]').val())) : 0;
          var equipment_per_person                = ($('#tab7 input[name="equipment_per_person"]').val() != "") ? parseFloat(replaceComma($('#tab7 input[name="equipment_per_person"]').val())) : 0;
          var equipment_clearjob_per_person       = ($('#tab7 input[name="equipment_clearjob_per_person"]').val() != "") ? parseFloat(replaceComma($('#tab7 input[name="equipment_clearjob_per_person"]').val())) : 0;
          var other_service_per_person            = ($('#tab7 input[name="other_service_per_person"]').val() != "") ? parseFloat(replaceComma($('#tab7 input[name="other_service_per_person"]').val())) : 0;
          var price_per_person                    = $('#tab7 .employee_level_price_per_person_'+id).val();
          //function replacecomma
          price_per_person = replaceComma(price_per_person);

          if (count < last) {
         
            var level_total = parseFloat(clearjob_employee_cost_per_person)
                              +parseFloat(social_security_per_person)
                              +parseFloat(equipment_per_person)
                              +parseFloat(equipment_clearjob_per_person)
                              +parseFloat(operation_cost_per_person)
                              +parseFloat(margin_per_person)
                              +parseFloat(other_service_per_person)
                              // +parseFloat(insurance_per_person)
                              +parseFloat(price_per_person)
                              -parseFloat(maximum_discount_per_person);

            level_total = level_total.toFixed(2);

            variant_val -= level_total*staff_total;
          } else {

            level_total = (variant_val/staff_total).toFixed(2);
          }

          //function comma
          level_total = commaSeparateNumber(level_total);
          $(this).val(level_total);

          count++;
      });
    } else {

      var employee_cost       = parseFloat($('#tab7 input[name="employee_cost"]').val());
      var social_security     = parseFloat($('#tab7 input[name="social_security"]').val());
      var equipment           = parseFloat($('#tab7 input[name="equipment"]').val());
      var transportation      = ($('#tab7 input[name="transportation"]').val() != '') ? parseFloat(replaceComma($('#tab7 input[name="transportation"]').val())) : 0;
      var insurance           = ($('#tab7 input[name="insurance"]').val() != '') ? parseFloat(replaceComma($('#tab7 input[name="insurance"]').val())) : 0;

      var subtotal = parseFloat(employee_cost+social_security+equipment+transportation+insurance).toFixed(2);     
      //function comma
      subtotal = commaSeparateNumber(subtotal);
      $('#tab7 input.subtotal').val(subtotal);
      //function replacecomma
      subtotal = replaceComma(subtotal);

      var operation_cost = parseFloat(($('#tab7 input[name="mpercent_operation"]').val()/100)*subtotal).toFixed(2);
      //function comma
      operation_cost = commaSeparateNumber(operation_cost);
      $('#tab7 input.operation_cost').val(operation_cost);
      //function replacecomma
      operation_cost = replaceComma(operation_cost);

      var total_cost = (parseFloat(subtotal)+parseFloat(operation_cost)).toFixed(2);
      //function comma
      total_cost = commaSeparateNumber(total_cost);
      $('#tab7 input.total_cost').val(total_cost);
      //function replacecomma
      total_cost = replaceComma(total_cost);

      var buffer = parseFloat(($('#tab7 input[name="mpercent_buffer"]').val()/100)*total_cost).toFixed(2);
      //function comma
      buffer = commaSeparateNumber(buffer);
      $('#tab7 input.buffer').val(buffer);
      //function replacecomma
      buffer = replaceComma(buffer);

      var subtotal_buffer = (parseFloat(total_cost)+parseFloat(buffer)).toFixed(2);
      //function comma
      subtotal_buffer = commaSeparateNumber(subtotal_buffer);
      $('#tab7 input.subtotal_buffer').val(subtotal_buffer);
      //function replacecomma
      subtotal_buffer = replaceComma(subtotal_buffer);

      var margin = parseFloat(($('#tab7 input[name="mpercent_margin"]').val()/100)*subtotal_buffer).toFixed(2);
      $('#tab7 input.margin').val(margin);

      var sale_quoted = (parseFloat(subtotal_buffer)+parseFloat(margin)).toFixed(2);
      //function comma
      sale_quoted = commaSeparateNumber(sale_quoted);
      $('#tab7 input.sale_quoted').val(sale_quoted);
      //function replacecomma
      sale_quoted = replaceComma(sale_quoted);

      var maximum_discount = ($('#tab7 input[name="maximum_discount"]').val() != '') ? parseFloat(replaceComma($('#tab7 input[name="maximum_discount"]').val())) : 0;
      if (maximum_discount != undefined && maximum_discount != "") {
        maximum_discount = parseFloat(maximum_discount);
      } else {
        maximum_discount = 0;
      }
      //don't have
      $('#tab7 input.maximum_discount_per_person').val(maximum_discount_per_person);

      var final_sale_quoted = (parseFloat(sale_quoted)-parseFloat(maximum_discount)).toFixed(2);
      //function comma
      final_sale_quoted = commaSeparateNumber(final_sale_quoted);
      $('#tab7 input.final_sale_quoted').val(final_sale_quoted);
      $('#tab7 input.total_bottom_price').val(final_sale_quoted);
      //function replacecomma
      final_sale_quoted = replaceComma(final_sale_quoted);

      var bottom_price_per_person = (parseFloat(final_sale_quoted/total_subgroup_staff).toFixed(2));
      //function comma
      bottom_price_per_person = commaSeparateNumber(bottom_price_per_person);
      $('#tab7 input.bottom_price_per_person').val(bottom_price_per_person);
      //function replacecomma
      bottom_price_per_person = replaceComma(bottom_price_per_person);

      var vat = parseFloat(($('#tab7 input[name="mpercent_vat"]').val()/100)*final_sale_quoted).toFixed(2);
      //function comma
      vat = commaSeparateNumber(vat);
      $('#tab7 input.vat').val(vat);
      //function replacecomma
      vat = replaceComma(vat);

      var total = (parseFloat(final_sale_quoted)+parseFloat(vat)).toFixed(2);
      //function comma
      total = commaSeparateNumber(total);
      $('#tab7 input.total').val(total);
    }

  
    var total_variant_price = ($('#tab7 .total_variant_price').val() != "") ? $('#tab7 .total_variant_price').val() : 0;

    if (total_variant_price != "") {
      //function replacecomma
      total_variant_price = replaceComma(total_variant_price);
      var total_variant_price = parseFloat(total_variant_price);

      var variant_val = parseFloat(total_variant_price);

      var total_cost;

      // var maximum_discount = '';
      // if($('#tab7 input[name="maximum_discount"]').val() != ''){
      //       maximum_discount = $('#tab7 input[name="maximum_discount"]').val();
      // }else{
      //      maximum_discount = 0;
      // }
      var maximum_discount = ($('#tab7 input[name="maximum_discount"]').val() != '') ? parseFloat(replaceComma($('#tab7 input[name="maximum_discount"]').val())) : 0;
      //function replacecomma
      // maximum_discount = replaceComma(maximum_discount);
      // maximum_discount = parseFloat(maximum_discount);
      total_variant_price -= maximum_discount;

      if (job_type == 'ZQT1') {
        total_cost = parseFloat(replaceComma($('#tab7 input[name="total_cost"]').val())); 

        var other_service = ($('#tab7 input[name="other_service"]').val() != '') ? parseFloat(replaceComma($('#tab7 input[name="other_service"]').val())) : 0;  
        total_variant_price -= other_service;
      } else {
        total_cost = replaceComma($('#tab7 input[name="subtotal_buffer"]').val());
      }

      var margin = (((total_variant_price-total_cost)/total_cost)*100).toFixed(2);
      $('#tab7 .percent_margin').val(margin);

      var vat = parseFloat(($('#tab7 input[name="mpercent_vat"]').val()/100)*variant_val).toFixed(2);
      //function comma
      vat = commaSeparateNumber(vat);
      $('#tab7 .vat_variant').val(vat);
       //function replacecomma
      vat = replaceComma(vat);
      $('#tab7 .vat_input').val(vat);

      var total = (parseFloat(variant_val)+parseFloat(vat)).toFixed(2);
      //function comma
      total = commaSeparateNumber(total); 
      $('#tab7 .total_variant').val(total);
      total = replaceComma(total);   
      $('#tab7 .total_input').val(total); 
    }

  }

  if (job_type == 'ZQT1') {
    $('#tab7 input[name="maximum_discount"]').on('keyup', function() {
      reCalculate();
    });
  } else {
    $('#tab7 .mpercent_buffer, #tab7 input[name="insurance"], #tab7 input[name="transportation"], #tab7 input[name="maximum_discount"]').on('keyup', function() {
      if ($(this).hasClass('mpercent_buffer')) {
        $('#tab7 input[name="mpercent_buffer"]').val($(this).val());
      }
      reCalculate();
    });

    $('#tab7 .commission_percent').on('keyup', function () {
      preventNumber();
      var count = 0;
      $('#tab7 .commission_percent').each(function() {
        var val = $(this).val();
        if (val == '' || val == undefined) {
          val = 0;
        }

        count += parseFloat(val);
      });

      if (count > 5) {
        $(this).val(0);
      }
    });
  }

  $('#tab7 .variant_price_per_person').on('keyup', function () {
    var val = $(this).val();
    //function replacecomma
    val = replaceComma(val);

    var margin_val = 0;
    var margin_percent = $('#tab7 input[name="mpercent_margin"]').val();
    if (val > 0 && val != "" && val != undefined) {
      var total_variant_price = parseFloat(val)*parseInt(total_subgroup_staff);
      //add function comma
      total_variant_price = commaSeparateNumber(total_variant_price);
      $('#tab7 .total_variant_price').val(total_variant_price);
      //function replacecomma
      total_variant_price = replaceComma(total_variant_price);

      if (total_variant_price > 0) {
        var total_variant_price = parseFloat(total_variant_price);
        var variant_val = parseFloat(total_variant_price);

        var total_cost;
        var maximum_discount = ($('#tab7 input[name="maximum_discount"]').val() != '') ?  parseFloat(replaceComma($('#tab7 input[name="maximum_discount"]').val())) : 0;
        total_variant_price += maximum_discount;

        if (job_type == 'ZQT1') {
          total_cost = $('#tab7 input[name="total_cost"]').val(); 
          total_cost = parseFloat(replaceComma(total_cost));

          var other_service = ($('#tab7 input[name="other_service"]').val() != '') ? $('#tab7 input[name="other_service"]').val() : 0;  
              other_service = parseFloat(replaceComma(other_service));
          total_variant_price -= other_service;

        } else {
          total_cost = $('#tab7 input[name="subtotal_buffer"]').val();
          total_cost = parseFloat(replaceComma(total_cost));
        }

        margin_val = (total_variant_price-total_cost );
        var margin = (((total_variant_price-total_cost )/total_cost)*100).toFixed(2);
        $('#tab7 .percent_margin').val(margin);

        var vat = parseFloat(($('#tab7 input[name="mpercent_vat"]').val()/100)*variant_val).toFixed(2);
        //add function comma
        vat = commaSeparateNumber(vat);
        $('#tab7 .vat_variant').val(vat);
         //function replacecomma
        vat = replaceComma(vat);
        $('#tab7 .vat_input').val(vat);

        var total = (parseFloat(variant_val)+parseFloat(vat)).toFixed(2);
        //function comma
        total = commaSeparateNumber(total); 
        $('#tab7 .total_variant').val(total);
        total = replaceComma(total);   
        $('#tab7 .total_input').val(total);  

      } else {
        $('#tab7 .percent_margin, .total_variant_price').val('');

        var price;
        if (job_type == 'ZQT1') {
          price = parseFloat(replaceComma($('#tab7 .sale_quote_and_other_service').val()));        
        } else {
          price = parseFloat(replaceComma($('#tab7 .final_sale_quoted').val()));
        }

        var vat = parseFloat(($('#tab7 input[name="mpercent_vat"]').val()/100)*price).toFixed(2);
        //add function comma
        vat = commaSeparateNumber(vat);
        $('#tab7 .vat_input').val(vat);
        //function replacecomma
        vat = replaceComma(vat);
        var total = (parseFloat(price)+parseFloat(vat)).toFixed(2);
        //function comma
        total = commaSeparateNumber(total);
        $('#tab7 .total_input').val(total);        
      }
    } else {
      $('#tab7 .percent_margin, .total_variant_price').val('');

      var price;
      if (job_type == 'ZQT1') {
        price = parseFloat(replaceComma($('#tab7 .sale_quote_and_other_service').val()));        
      } else {
        price = parseFloat(replaceComma($('#tab7 .final_sale_quoted').val()));
      }

      var vat = parseFloat(($('#tab7 input[name="mpercent_vat"]').val()/100)*price).toFixed(2);
      //add function comma
      vat = commaSeparateNumber(vat);
      $('#tab7 .vat_input').val(vat);
      //function replacecomma
      vat = replaceComma(vat);
      var total = (parseFloat(price)+parseFloat(vat)).toFixed(2);
      //function comma
      total = commaSeparateNumber(total);
      $('#tab7 .total_input').val(total);

      variant_val = parseFloat(replaceComma($('#tab7 .total_bottom_price').val()));
      margin_val  = parseFloat(replaceComma($('#tab7 .margin').val()));
      
      $('.total_variant, .vat_variant').val('');
    }

    if (job_type == 'ZQT1') {

        var last = $('#tab7 .employee_level_price').length;
        var count = 1;

        $('#tab7 .employee_level_price').each(function () {
          var id = $(this).data('id');
          var staff_total = parseInt($('.total_staff_'+id).val());

          var clearjob_employee_cost_per_person   = ($('#tab7 input[name="clearjob_employee_cost"]').val() != "") ? parseFloat(replaceComma($('#tab7 input[name="clearjob_employee_cost"]').val()))/parseInt(total_subgroup_staff) : 0;
          var social_security_per_person          = ($('#tab7 input[name="social_security"]').val() != "") ? parseFloat(replaceComma($('#tab7 input[name="social_security"]').val()))/parseInt(total_subgroup_staff) : 0;
          var equipment_per_person                = ($('#tab7 input[name="equipment"]').val() != "") ? parseFloat(replaceComma($('#tab7 input[name="equipment"]').val()))/parseInt(total_subgroup_staff) : 0;
          var equipment_clearjob_per_person       = ($('#tab7 input[name="equipment_clearjob"]').val() != "") ? parseFloat(replaceComma($('#tab7 input[name="equipment_clearjob"]').val()))/parseInt(total_subgroup_staff) : 0;
          var other_service_per_person            = ($('#tab7 input[name="other_service"]').val() != "") ? parseFloat(replaceComma($('#tab7 input[name="other_service"]').val()))/parseInt(total_subgroup_staff) : 0;
          var operation_cost_per_person           = ($('#tab7 input[name="operation_cost"]').val() != "") ? parseFloat(replaceComma($('#tab7 input[name="operation_cost"]').val()))/parseInt(total_subgroup_staff) : 0;
          // var insurance_per_person                = ($('#tab7 input[name="insurance"]').val() != "") ? parseFloat(replaceComma($('#tab7 input[name="insurance"]').val())/parseInt(total_subgroup_staff) : 0;
          var maximum_discount_per_person         = ($('#tab7 input[name="maximum_discount"]').val() != "") ? parseFloat(replaceComma($('#tab7 input[name="maximum_discount"]').val()))/parseInt(total_subgroup_staff) : 0;
          var price_per_person                    = $('#tab7 .employee_level_price_per_person_'+id).val();
          var margin_per_person                   = parseFloat(margin_val/total_subgroup_staff).toFixed(2);

          if (count < last) {
            
            var level_total = parseFloat(clearjob_employee_cost_per_person)
                              +parseFloat(social_security_per_person)
                              +parseFloat(equipment_per_person)
                              +parseFloat(equipment_clearjob_per_person)
                              +parseFloat(operation_cost_per_person)
                              +parseFloat(margin_per_person)
                              +parseFloat(other_service_per_person)
                              // +parseFloat(insurance_per_person)
                              +parseFloat(price_per_person)
                              -parseFloat(maximum_discount_per_person);

            level_total = level_total.toFixed(2);

            variant_val -= level_total*staff_total;

          } else {

            level_total = (variant_val/staff_total).toFixed(2);

          }
          //function comma
          level_total = commaSeparateNumber(level_total);
          $(this).val(level_total);

          count++;
      });
    } else if (job_type == 'ZQT3') {
      //total_subgroup_staff
        var last = $('#tab7 .employee_level_price').length;
        var count = 1;

        // console.log(variant_val);
        $('#tab7 .employee_level_price').each(function () {
          var id = $(this).data('id');

          var staff_total = parseInt($('.total_staff_'+id).val());
          // console.log(id+' : '+staff_total);

          var social_security_per_person = ($('#tab7 input[name="social_security"]').val() != "") ? parseFloat(replaceComma($('#tab7 input[name="social_security"]').val()))/parseInt(total_subgroup_staff) : 0;
          var transportation_per_person  = ($('#tab7 input[name="equipment"]').val() != "") ? parseFloat(replaceComma($('#tab7 input[name="equipment"]').val()))/parseInt(total_subgroup_staff) : 0;
          var equipment_per_person       = ($('#tab7 input[name="transportation"]').val() != "") ? parseFloat(replaceComma($('#tab7 input[name="transportation"]').val()))/parseInt(total_subgroup_staff) : 0;
          var insurance_per_person       = ($('#tab7 input[name="insurance"]').val() != "") ? parseFloat(replaceComma($('#tab7 input[name="insurance"]').val()))/parseInt(total_subgroup_staff) : 0;
          var operation_cost_per_person  = ($('#tab7 input[name="operation_cost"]').val() != "") ? parseFloat(replaceComma($('#tab7 input[name="operation_cost"]').val()))/parseInt(total_subgroup_staff) : 0;
          var buffer_per_person          = ($('#tab7 input[name="buffer"]').val() != "") ? parseFloat(replaceComma($('#tab7 input[name="buffer"]').val()))/parseInt(total_subgroup_staff) : 0;
          var maximum_discount_per_person = ($('#tab7 input[name="maximum_discount"]').val() != "") ? parseFloat(replaceComma($('#tab7 input[name="maximum_discount"]').val()))/parseInt(total_subgroup_staff) : 0;
          var price_per_person           = $('#tab7 .employee_level_price_per_person_'+id).val();
          //function replacecomma
          price_per_person = replaceComma(price_per_person);          
          var margin_per_person = parseFloat(margin_val/total_subgroup_staff).toFixed(2);        

          if (count < last) {

            var level_total = parseFloat(social_security_per_person)
                              +parseFloat(transportation_per_person)
                              +parseFloat(equipment_per_person)
                              +parseFloat(insurance_per_person)
                              +parseFloat(operation_cost_per_person)
                              +parseFloat(margin_per_person)
                              +parseFloat(buffer_per_person)
                              // +parseFloat(insurance_per_person)
                              -parseFloat(maximum_discount_per_person);

            level_total +=parseFloat(price_per_person);
            level_total = level_total.toFixed(2);

            variant_val -= level_total*staff_total;
          } else {

            level_total = (variant_val/staff_total).toFixed(2);
          }

          //function comma
          level_total = commaSeparateNumber(level_total);
          $(this).val(level_total);

          count++;
      });
    }
  });

  $('#tab7 .total_variant_price').on('keyup', function () {
    var val = $(this).val();
    //function replacecomma
    val = replaceComma(val);
    var margin_percent = $('#tab7 input[name="mpercent_margin"]').val();

    var margin_val = 0;

    if (val > 0 && val != "" && val != undefined) {
      var variant_price_per_person = (parseFloat(val)/parseInt(total_subgroup_staff)).toFixed(2);
      //function comma
      variant_price_per_person = commaSeparateNumber(variant_price_per_person);
      $('#tab7 .variant_price_per_person').val(variant_price_per_person);

      var val = parseFloat(val);
      var variant_val = parseFloat(val);

      var total_cost;

      if (job_type == 'ZQT1') {
        total_cost = parseFloat($('#tab7 input[name="total_cost"]').val()); 
        total_cost = parseFloat(replaceComma(total_cost));

        var other_service = ($('#tab7 input[name="other_service"]').val() != '') ? $('#tab7 input[name="other_service"]').val() : 0;  
            other_service = parseFloat(replaceComma(other_service));
        val -= other_service;

      } else {
        total_cost = $('#tab7 input[name="subtotal_buffer"]').val();
        total_cost = parseFloat(replaceComma(total_cost));
      }

      var maximum_discount = ($('#tab7 input[name="maximum_discount"]').val() != '') ? parseFloat(replaceComma($('#tab7 input[name="maximum_discount"]').val())) : 0;
      val += maximum_discount;

      margin_val = (val-total_cost);
      var margin = (((val-total_cost)/total_cost)*100).toFixed(2);
      $('#tab7 .percent_margin').val(margin);

      var vat = parseFloat(($('#tab7 input[name="mpercent_vat"]').val()/100)*variant_val).toFixed(2);
      //function comma
      vat = commaSeparateNumber(vat);
      $('#tab7 .vat_variant').val(vat);
       //function replacecomma
      vat = replaceComma(vat);
      $('#tab7 .vat_input').val(vat);

      var total = (parseFloat(variant_val)+parseFloat(vat)).toFixed(2);
      //function comma
      total = commaSeparateNumber(total); 
      $('#tab7 .total_variant').val(total);
      total = replaceComma(total);   
      $('#tab7 .total_input').val(total);    

    } else {

      $('#tab7 .percent_margin, .variant_price_per_person').val('');

      var price;
      if (job_type == 'ZQT1') {
        price = parseFloat(replaceComma($('#tab7 .sale_quote_and_other_service').val()));        
      } else {
        price = parseFloat(replaceComma($('#tab7 .final_sale_quoted').val()));
      }

      var vat = parseFloat(($('#tab7 input[name="mpercent_vat"]').val()/100)*price).toFixed(2);
      //function comma
      vat = commaSeparateNumber(vat);
      $('#tab7 .vat_input').val(vat);
      //function replacecomma
      vat = replaceComma(vat);

      var total = (parseFloat(price)+parseFloat(vat)).toFixed(2);
      //function comma
      total = commaSeparateNumber(total);
      $('#tab7 .total_input').val(total);

      variant_val = parseFloat(replaceComma($('#tab7 .total_bottom_price').val()));
      margin_val  = parseFloat(replaceComma($('#tab7 .margin').val()));
      
      $('.total_variant, .vat_variant').val('');
    }

    if (job_type == 'ZQT1') {

        var last = $('#tab7 .employee_level_price').length;
        var count = 1;

        // console.log(variant_val);
        $('#tab7 .employee_level_price').each(function () {
          var id = $(this).data('id');

          var staff_total = parseInt($('.total_staff_'+id).val());
          // console.log(id+' : '+staff_total);

          var clearjob_employee_cost_per_person   = ($('#tab7 input[name="clearjob_employee_cost"]').val() != "") ? parseFloat(replaceComma($('#tab7 input[name="clearjob_employee_cost"]').val()))/parseInt(total_subgroup_staff) : 0;
          var social_security_per_person          = ($('#tab7 input[name="social_security"]').val() != "") ? parseFloat(replaceComma($('#tab7 input[name="social_security"]').val()))/parseInt(total_subgroup_staff) : 0;
          var equipment_per_person                = ($('#tab7 input[name="equipment"]').val() != "") ? parseFloat(replaceComma($('#tab7 input[name="equipment"]').val()))/parseInt(total_subgroup_staff) : 0;
          var equipment_clearjob_per_person       = ($('#tab7 input[name="equipment_clearjob"]').val() != "") ? parseFloat(replaceComma($('#tab7 input[name="equipment_clearjob"]').val()))/parseInt(total_subgroup_staff) : 0;
          var other_service_per_person            = ($('#tab7 input[name="other_service"]').val() != "") ? parseFloat(replaceComma($('#tab7 input[name="other_service"]').val()))/parseInt(total_subgroup_staff) : 0;
          var operation_cost_per_person           = ($('#tab7 input[name="operation_cost"]').val() != "") ? parseFloat(replaceComma($('#tab7 input[name="operation_cost"]').val()))/parseInt(total_subgroup_staff) : 0;
          // var insurance_per_person                = ($('#tab7 input[name="insurance"]').val() != "") ? parseFloat(replaceComma($('#tab7 input[name="insurance"]').val()))/parseInt(total_subgroup_staff) : 0;
          var maximum_discount_per_person         = ($('#tab7 input[name="maximum_discount"]').val() != "") ? parseFloat(replaceComma($('#tab7 input[name="maximum_discount"]').val()))/parseInt(total_subgroup_staff) : 0;
          var price_per_person                    = $('#tab7 .employee_level_price_per_person_'+id).val();
          var margin_per_person                   = parseFloat(margin_val/total_subgroup_staff).toFixed(2);

          if (count < last) {

            var level_total = parseFloat(clearjob_employee_cost_per_person)
                              +parseFloat(social_security_per_person)
                              +parseFloat(equipment_per_person)
                              +parseFloat(equipment_clearjob_per_person)
                              +parseFloat(operation_cost_per_person)
                              +parseFloat(margin_per_person)
                              +parseFloat(other_service_per_person)
                              // +parseFloat(insurance_per_person)
                              -parseFloat(maximum_discount_per_person);

            level_total +=parseFloat(price_per_person);
            level_total = level_total.toFixed(2);

            variant_val -= level_total*staff_total;
          } else {

            level_total = (variant_val/staff_total).toFixed(2);
          }

          //function comma
          level_total = commaSeparateNumber(level_total);
          $(this).val(level_total);

          count++;
      });
    } else if (job_type == 'ZQT3') {
      //total_subgroup_staff
        var last = $('#tab7 .employee_level_price').length;
        var count = 1;

        // console.log(variant_val);
        $('#tab7 .employee_level_price').each(function () {
          var id = $(this).data('id');

          var staff_total = parseInt($('.total_staff_'+id).val());
          // console.log(id+' : '+staff_total);

          var social_security_per_person = ($('#tab7 input[name="social_security"]').val() != "") ? parseFloat(replaceComma($('#tab7 input[name="social_security"]').val()))/parseInt(total_subgroup_staff) : 0;
          var transportation_per_person  = ($('#tab7 input[name="equipment"]').val() != "") ? parseFloat(replaceComma($('#tab7 input[name="equipment"]').val()))/parseInt(total_subgroup_staff) : 0;
          var equipment_per_person       = ($('#tab7 input[name="transportation"]').val() != "") ? parseFloat(replaceComma($('#tab7 input[name="transportation"]').val()))/parseInt(total_subgroup_staff) : 0;
          var insurance_per_person       = ($('#tab7 input[name="insurance"]').val() != "") ? parseFloat(replaceComma($('#tab7 input[name="insurance"]').val()))/parseInt(total_subgroup_staff) : 0;
          var operation_cost_per_person  = ($('#tab7 input[name="operation_cost"]').val() != "") ? parseFloat(replaceComma($('#tab7 input[name="operation_cost"]').val()))/parseInt(total_subgroup_staff) : 0;
          var buffer_per_person          = ($('#tab7 input[name="buffer"]').val() != "") ? parseFloat(replaceComma($('#tab7 input[name="buffer"]').val()))/parseInt(total_subgroup_staff) : 0;
          var maximum_discount_per_person = ($('#tab7 input[name="maximum_discount"]').val() != "") ? parseFloat(replaceComma($('#tab7 input[name="maximum_discount"]').val()))/parseInt(total_subgroup_staff) : 0;
          var price_per_person           = $('#tab7 .employee_level_price_per_person_'+id).val();
          //function replacecomma
          price_per_person = replaceComma(price_per_person);          
          var margin_per_person = parseFloat(margin_val/total_subgroup_staff).toFixed(2);        

          if (count < last) {

            var level_total = parseFloat(social_security_per_person)
                              +parseFloat(transportation_per_person)
                              +parseFloat(equipment_per_person)
                              +parseFloat(insurance_per_person)
                              +parseFloat(operation_cost_per_person)
                              +parseFloat(margin_per_person)
                              +parseFloat(buffer_per_person)
                              // +parseFloat(insurance_per_person)
                              -parseFloat(maximum_discount_per_person);

            level_total +=parseFloat(price_per_person);
            level_total = level_total.toFixed(2);

            variant_val -= level_total*staff_total;
          } else {

            level_total = (variant_val/staff_total).toFixed(2);
          }

          //function comma
          level_total = commaSeparateNumber(level_total);
          $(this).val(level_total);

          count++;
      });
    }
  });

  $('#tab7 .percent_margin').on('keyup', function () {

    var margin_percent = $(this).val();
    var margin_val = 0;

    if (margin_percent > 0 && margin_percent != "" && margin_percent != undefined) {      

      var total_cost = 0;
      if (job_type == 'ZQT1') {
        total_cost = parseFloat(replaceComma($('#tab7 input[name="total_cost"]').val()));
      } else {
        total_cost = parseFloat(replaceComma($('#tab7 input[name="subtotal_buffer"]').val()));
      }

      var margin_val = parseFloat((parseFloat(margin_percent)/100)*parseFloat(total_cost)).toFixed(2);      

      total_cost = parseFloat(total_cost) + parseFloat(margin_val);

      if (job_type == 'ZQT1') {
        var other_service = ($('#tab7 input[name="other_service"]').val() != '') ? parseFloat(replaceComma($('#tab7 input[name="other_service"]').val())) : 0;  
        total_cost += other_service;
      }

      var maximum_discount = ($('#tab7 input[name="maximum_discount"]').val() != '') ? parseFloat(replaceComma($('#tab7 input[name="maximum_discount"]').val())) : 0;
      total_cost -= maximum_discount;

      var variant_val = parseFloat(total_cost).toFixed(2);
     //function comma
      variant_val = commaSeparateNumber(variant_val);
      $('#tab7 .total_variant_price').val(variant_val);
      //function replacecomma
      variant_val = replaceComma(variant_val);

      var variant_price_per_person = (parseFloat(variant_val)/parseInt(total_subgroup_staff)).toFixed(2);
      //function comma
      variant_price_per_person = commaSeparateNumber(variant_price_per_person);
      $('#tab7 .variant_price_per_person').val(variant_price_per_person);
      //function replacecomma
      variant_price_per_person = replaceComma(variant_price_per_person);
      
      var vat = parseFloat(($('#tab7 input[name="mpercent_vat"]').val()/100)*parseFloat(variant_val)).toFixed(2);
      //function comma
      vat = commaSeparateNumber(vat);      
      $('#tab7 .vat_variant').val(vat);
       //function replacecomma
      vat = replaceComma(vat);
      $('#tab7 .vat_input').val(vat);

      var total = (parseFloat(variant_val)+parseFloat(vat)).toFixed(2);
      //function comma
      total = commaSeparateNumber(total); 
      $('#tab7 .total_variant').val(total);
      total = replaceComma(total);   
      $('#tab7 .total_input').val(total); 

    } else {

      $('#tab7 .total_variant_price, .variant_price_per_person').val('');

      var price;
      if (job_type == 'ZQT1') {
        price = parseFloat(replaceComma($('#tab7 .sale_quote_and_other_service').val()));        
      } else {
        price = parseFloat(replaceComma($('#tab7 .final_sale_quoted').val()));
      }

      var vat = parseFloat(($('#tab7 input[name="mpercent_vat"]').val()/100)*price).toFixed(2);
      //function comma
      vat = commaSeparateNumber(vat); 
      $('#tab7 .vat_input').val(vat);
      //function replacecomma
      vat = replaceComma(vat);


      var total = (parseFloat(price)+parseFloat(vat)).toFixed(2);
      //function comma
      total = commaSeparateNumber(total);
      $('#tab7 .total_input').val(total);

      variant_val = $('#tab7 .total_bottom_price').val();
      margin_val  = $('#tab7 .margin').val();

      $('.total_variant, .vat_variant').val('');
    }

    if (job_type == 'ZQT1') {

        var last = $('#tab7 .employee_level_price').length;
        var count = 1;

        // console.log(variant_val);
        $('#tab7 .employee_level_price').each(function () {
          var id = $(this).data('id');

          var staff_total = parseInt($('.total_staff_'+id).val());
          // console.log(id+' : '+staff_total);

          var clearjob_employee_cost_per_person   = ($('#tab7 input[name="clearjob_employee_cost"]').val() != "") ? parseFloat(replaceComma($('#tab7 input[name="clearjob_employee_cost"]').val()))/parseInt(total_subgroup_staff) : 0;
          var social_security_per_person          = ($('#tab7 input[name="social_security"]').val() != "") ? parseFloat(replaceComma($('#tab7 input[name="social_security"]').val()))/parseInt(total_subgroup_staff) : 0;
          var equipment_per_person                = ($('#tab7 input[name="equipment"]').val() != "") ? parseFloat(replaceComma($('#tab7 input[name="equipment"]').val()))/parseInt(total_subgroup_staff) : 0;
          var equipment_clearjob_per_person       = ($('#tab7 input[name="equipment_clearjob"]').val() != "") ? parseFloat(replaceComma($('#tab7 input[name="equipment_clearjob"]').val()))/parseInt(total_subgroup_staff) : 0;
          var other_service_per_person            = ($('#tab7 input[name="other_service"]').val() != "") ? parseFloat(replaceComma($('#tab7 input[name="other_service"]').val()))/parseInt(total_subgroup_staff) : 0;
          var operation_cost_per_person           = ($('#tab7 input[name="operation_cost"]').val() != "") ? parseFloat(replaceComma($('#tab7 input[name="operation_cost"]').val()))/parseInt(total_subgroup_staff) : 0;
          // var insurance_per_person                = ($('#tab7 input[name="insurance"]').val() != "") ? parseFloat($('#tab7 input[name="insurance"]').val())/parseInt(total_subgroup_staff) : 0;
          var maximum_discount_per_person         = ($('#tab7 input[name="maximum_discount"]').val() != "") ? parseFloat(replaceComma($('#tab7 input[name="maximum_discount"]').val()))/parseInt(total_subgroup_staff) : 0;
          var price_per_person                    = $('#tab7 .employee_level_price_per_person_'+id).val();
          //function replacecomma
          price_per_person = replaceComma(price_per_person);          
          var margin_per_person                   = parseFloat(margin_val/total_subgroup_staff).toFixed(2);        

          if (count < last) {

            var level_total = parseFloat(clearjob_employee_cost_per_person)
                              +parseFloat(social_security_per_person)
                              +parseFloat(equipment_per_person)
                              +parseFloat(equipment_clearjob_per_person)
                              +parseFloat(operation_cost_per_person)
                              +parseFloat(margin_per_person)
                              +parseFloat(other_service_per_person)
                              // +parseFloat(insurance_per_person)
                              -parseFloat(maximum_discount_per_person);

            level_total +=parseFloat(price_per_person);
            level_total = level_total.toFixed(2);

            variant_val -= level_total*staff_total;
          } else {

            level_total = (variant_val/staff_total).toFixed(2);
          }

          //function comma
          level_total = commaSeparateNumber(level_total);
          $(this).val(level_total);

          count++;
      });
    } else if (job_type == 'ZQT3') {
      //total_subgroup_staff
        var last = $('#tab7 .employee_level_price').length;
        var count = 1;

        // console.log(variant_val);
        $('#tab7 .employee_level_price').each(function () {
          var id = $(this).data('id');

          var staff_total = parseInt($('.total_staff_'+id).val());
          // console.log(id+' : '+staff_total);

          var social_security_per_person = ($('#tab7 input[name="social_security"]').val() != "") ? parseFloat(replaceComma($('#tab7 input[name="social_security"]').val()))/parseInt(total_subgroup_staff) : 0;
          var transportation_per_person  = ($('#tab7 input[name="equipment"]').val() != "") ? parseFloat(replaceComma($('#tab7 input[name="equipment"]').val()))/parseInt(total_subgroup_staff) : 0;
          var equipment_per_person       = ($('#tab7 input[name="transportation"]').val() != "") ? parseFloat(replaceComma($('#tab7 input[name="transportation"]').val()))/parseInt(total_subgroup_staff) : 0;
          var insurance_per_person       = ($('#tab7 input[name="insurance"]').val() != "") ? parseFloat(replaceComma($('#tab7 input[name="insurance"]').val()))/parseInt(total_subgroup_staff) : 0;
          var operation_cost_per_person  = ($('#tab7 input[name="operation_cost"]').val() != "") ? parseFloat(replaceComma($('#tab7 input[name="operation_cost"]').val()))/parseInt(total_subgroup_staff) : 0;
          var buffer_per_person          = ($('#tab7 input[name="buffer"]').val() != "") ? parseFloat(replaceComma($('#tab7 input[name="buffer"]').val()))/parseInt(total_subgroup_staff) : 0;
          var maximum_discount_per_person = ($('#tab7 input[name="maximum_discount"]').val() != "") ? parseFloat(replaceComma($('#tab7 input[name="maximum_discount"]').val()))/parseInt(total_subgroup_staff) : 0;
          var price_per_person           = $('#tab7 .employee_level_price_per_person_'+id).val();
          //function replacecomma
          price_per_person = replaceComma(price_per_person);          
          var margin_per_person = parseFloat(margin_val/total_subgroup_staff).toFixed(2);        

          if (count < last) {

            var level_total = parseFloat(social_security_per_person)
                              +parseFloat(transportation_per_person)
                              +parseFloat(equipment_per_person)
                              +parseFloat(insurance_per_person)
                              +parseFloat(operation_cost_per_person)
                              +parseFloat(margin_per_person)
                              +parseFloat(buffer_per_person)
                              // +parseFloat(insurance_per_person)
                              -parseFloat(maximum_discount_per_person);

            level_total +=parseFloat(price_per_person);
            level_total = level_total.toFixed(2);

            variant_val -= level_total*staff_total;
          } else {

            level_total = (variant_val/staff_total).toFixed(2);
          }

          //function comma
          level_total = commaSeparateNumber(level_total);
          $(this).val(level_total);

          count++;
      });
    }
  });


   $('#tab7 .vat_variant').on('keyup', function () {
     // alert('vat');
    var vat = $(this).val(); 
        vat = replaceComma(vat);
        if (vat == 0 || vat == "" || vat == null) {
            vat = parseFloat(0);
          } else {
            vat = parseFloat(vat);
          }
      //alert(vat);

     var variant_val = $('#tab7 .total_variant_price').val();
     variant_val = replaceComma(variant_val);
     if (variant_val == 0 || variant_val == "" || variant_val == null) {
            variant_val = parseFloat(0);
          } else {
            variant_val = parseFloat(variant_val);
          }
      //alert(variant_val);      

      var total_vat = parseFloat(vat)+parseFloat(variant_val);
          total_vat = total_vat.toFixed(2);
          total_vat = commaSeparateNumber(total_vat);
      //set total_variant
      $('#tab7 .total_variant').val(total_vat);                     

  });


  $('#tab7 #save_summary_btn').on('click', function () {
    $('#tab7 #summary_form').submit();
  });

  $('#tab7 #submit_to_papyrus').on('click', function () {
    $('#tab7 input[name="submit_to_papyrus"]').val(1);
    $('#tab7 #summary_form').submit();
  });


</script>