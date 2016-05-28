<script type="text/javascript">
$(".input-page").keyup(function (e) {
    if (e.keyCode == 13) {
        // Do something        
        var inputPage = $(".input-page").val();
        var totalPage = $(".input-totalPage").val();        
       // alert(totalPage);
        var location1 = '<?php echo site_url("__ps_asset_track/listview/list/1/1/1/'+inputPage+'" ); ?>';
        var location2 ='<?php echo site_url("__ps_asset_track/listview/list/1/1/1/'+totalPage+'" ); ?>';
        if( inputPage <= totalPage && inputPage >=1){
          window.location.assign(location1);
        }else{
          window.location.assign(location2);
        }
    }
});
</script>