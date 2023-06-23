<head>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="js/jq.js"></script>
    <script>
        $(function(){
            var speed = 50;
            $("#rollphp").load("animacja_gen.php");
            for(j=1;j<=200;j++)
            {
                var offsecik = (j-1) * 128;
                $("#slide".concat(j)).css("margin-left", offsecik+"px");
            }
            $(".openbutton").on("click", function(){
                $(".openbutton").attr("disabled", true);
                $("#rollphp").load("animacja_gen.php");
                for(j=1;j<=200;j++)
                {
                    var offsecik = (j-1) * 128;
                    $("#slide".concat(j)).css("margin-left", offsecik+"px");
                }
                var i = 1;
                var interwal = setInterval(function(){
                    if(i<180){speed = 50;}
                    else if(i<210){speed = 40;}
                    else if(i<250){speed = 30;}
                    else if(i<290){speed = 20;}
                    else if(i<330){speed = 15;}
                    else if(i<350){speed = 13;}
                    else if(i<340){speed = 10;}
                    else if(i<390){speed = 9;}
                    else if(i<400){speed = 8;}
                    else if(i<410){speed = 7;}
                    else if(i<420){speed = 6;}
                    else if(i<430){speed = 5;}
                    else if(i<440){speed = 4;}
                    else if(i<460){speed = 3;}
                    else if(i<480){speed = 2;}
                    else{speed = 1;}
                    for(j=1;j<=200;j++)
                    {
                        var offset = parseInt($("#slide".concat(j)).css("margin-left"));
                        offset = offset - speed;
                        offset = offset + "px";
                        $("#slide".concat(j)).css("margin-left", offset);
                    }
                    if(i>540)
                    {
                        clearInterval(interwal);
                        $(".openbutton").attr("disabled", false);
                    }
                    i++;
                }, 16.667);
            });
        });


    </script>

</head>
<body>
    <style>
    .slide{float:left;position:absolute;}
    .openbutton{cursor: pointer; padding: 10px 30px 10px 30px; border: 2px solid lime;
    border-radius: 16px; background-color: white; color:lime; transition: .2s;}
    .openbutton:hover{color: white; background-color: lime;}
    </style>
    <div id="roll" style="width: 896px; height:128px; border:2px solid red; margin:auto; overflow: hidden; position:relative;">
    <?php
    for($i=1;$i<=200;$i++)
    {
        $itemki = array('bayomarble.png', 'buttdoppler.png', 'gutsafari.png', 'karafade.png', 'm9gamma.png');
        $losowa = rand(0,4);
        echo '<div id="slide'.$i.'" class="slide"><img id="imgslide'.$i.'" src="'.$itemki[$losowa].'" width=128 height=128></div>';
    }
    ?>
    </div>
    <div id="rollphp"></div>
    <br/><center><button class="openbutton">OTWORZ</button></center>






    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js"></script>
</body>