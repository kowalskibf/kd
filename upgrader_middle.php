<?php

    require_once 'db.php';
	require 'steamauth/steamauth.php';
	require 'steamauth/userInfo.php';

    $connection = @new mysqli($host, $db_user, $db_password, $db_name);
    mysqli_set_charset($connection, "utf8");

    ?>

    <div id="upgrader-circle-pointer-div">
        <img src="img/downarrow.png" height=40 width=40>
    </div>

    <div id="upgrader-circle-div">
        <svg width="250" height="250">
            <circle r="100" cx="125" cy="125" class="upgrader-circle-track"></circle>
            <circle r="100" cx="125" cy="125" class="upgrader-circle-progress" id="upgrader-circle-progress-id"></circle>
        </svg>
    </div>

    <div id="upgrader-chances-div">75%</div>

    <style>
        .upgrader-circle-track{
            stroke-width: 10;
            stroke: #1F1E27;
            fill: none;
        }
                
        .upgrader-circle-progress {
            stroke-width: 10;
            stroke: #dcae64;
            /*stroke-linecap: round;*/
            fill: none;
            transform: rotate(270deg);
            transform-origin: center;
        }
    </style>

    <script>
        progressCircle = document.querySelector(".upgrader-circle-progress");
        radius = progressCircle.r.baseVal.value;
        //circumference of a circle = 2πr;
        circumference = radius * 2 * Math.PI;
        // przed tymi trzema wyzej ma byc let
        progressCircle.style.strokeDasharray = circumference;
        //0 to 100
        //setProgress(75);
        //var circle_chance = 75;
    
        function setProgress(percent)
        {
            progressCircle.style.strokeDashoffset = circumference - (percent / 100) * circumference;
        }
        setProgress(75);
    </script>

    <?php

    if(ctype_alnum($_GET['price1']) && ctype_alnum($_GET['price2']))
    {
        if(($_GET['price1'] != 0) && ($_GET['price2'] != 0))
        {
            $price1 = $_GET['price1'];
            $price2 = $_GET['price2'];
            $price1 = htmlentities($price1, ENT_QUOTES, "UTF-8");
            $price2 = htmlentities($price2, ENT_QUOTES, "UTF-8");
            $item1 = $price1;
            $item2 = $price2;
            $result_price1 = $connection->query("SELECT * FROM items WHERE itemid='$price1'");
            $result_price1 = $result_price1->fetch_assoc();
            $skinid1 = $result_price1['itemskinid'];
            $skincond1 = $result_price1['itemcondition'];
            $result_price1 = $connection->query("SELECT * FROM skins WHERE skinid='$skinid1'");
            $result_price1 = $result_price1->fetch_assoc();
            $price1 = $result_price1['skinprice'.$skincond1];
            list($skinid2, $skincond2) = explode("x", $price2);
            $result_price2 = $connection->query("SELECT * FROM skins WHERE skinid='$skinid2'");
            $result_price2 = $result_price2->fetch_assoc();
            $price2 = $result_price2['skinprice'.$skincond2];
            if($price1 < $price2)
            {
                echo '<script>$("#upgradebutton").on("click", function(){
                    $("#upgraderphp1").load("upgrader_result.php?item1='.$item1.'&item2='.$item2.'");
                });</script>';
                
                echo '<script>$("#upgrader-chances-div").text("'.(round((($price1/$price2) * 90), 2)).'%");</script>';

                echo '<script>setProgress('.(round((($price1/$price2) * 90), 2)).');</script>';

            }
        }

        echo '<button id="upgradebutton">UPGRADE</button>';

    }

?>