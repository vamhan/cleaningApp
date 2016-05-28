<script type="text/javascript">
  (function($) {
    $('.commit-delete-btn').on('click',function(event){
      var vcontractId = $(this).data('contractid');
      var vshipToId = $(this).data('shiptoid');
      var vfunction =  $(this).data('function');  

      $('#modal-delete-assign').modal('show');                        

      $('.confirm-delete').on('click',function(event){
        window.top.location.href = '<?php echo site_url("__ps_action_plan_setting/unassign")?>'+'/'+vcontractId+'/'+vshipToId+'/'+vfunction;    
                         });//end click confirm
                    });//end click taget
  })(jQuery);
</script>