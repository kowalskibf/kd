<script>
    for(j=1;j<=200;j++)
    {
        if(($(window).width()) > 1440)
        {
            var offsecik = (j-1) * 202;
        }
        else if(($(window).width()) > 1200)
        {
            var offsecik = (j-1) * 170;
        }
        else if(($(window).width()) > 903)
        {
            var offsecik = (j-1) * 170;
        }
        else
        {
            var offsecik = (j-1) * 120;
        }
        $("#slide".concat(j)).css("margin-left", offsecik+"px");
    }
</script>