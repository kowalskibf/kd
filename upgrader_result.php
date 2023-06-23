<?php

    require_once 'db.php';
	require 'steamauth/steamauth.php';
	require 'steamauth/userInfo.php';

    $connection = @new mysqli($host, $db_user, $db_password, $db_name);
    mysqli_set_charset($connection, "utf8");

    if(ctype_alnum($_GET['item1']) && ctype_alnum($_GET['item2']))
    {
        if(($_GET['item1'] != 0) && ($_GET['item2'] != 0))
        {
            $uid = $_SESSION['userid'];
            $item1 = $_GET['item1'];
            $item2 = $_GET['item2'];
            $item1 = htmlentities($item1, ENT_QUOTES, "UTF-8");
            $item2 = htmlentities($item2, ENT_QUOTES, "UTF-8");
            $result1 = $connection->query("SELECT * FROM items WHERE itemid='$item1'");
            $result1 = $result1->fetch_assoc();
            $skinid1 = $result1['itemskinid'];
            $skincond1 = $result1['itemcondition'];
            $result1 = $connection->query("SELECT * FROM skins WHERE skinid='$skinid1'");
            $result1 = $result1->fetch_assoc();
            $price1 = $result1['skinprice'.$skincond1];
            list($skinid2, $skincond2) = explode("x", $item2);
            $result2 = $connection->query("SELECT * FROM skins WHERE skinid='$skinid2'");
            $result2 = $result2->fetch_assoc();
            $price2 = $result2['skinprice'.$skincond2];
            $losowa = rand(0, 1000000);
            $ratio = ($price1/$price2) * 900000;
            $validate1 = $connection->query("SELECT * FROM items WHERE itemid='$item1' AND itemstatus=1 AND itemuserid='$uid'");
            if($validate1->num_rows > 0)
            {
                ?>

                <script>
                    var i = 1;
                    var offset = <?php echo round(((270-(0.00036 * $losowa))%360)); ?>;
                    $(".upgrader-circle-progress").css("transform", "rotate(".concat(offset).concat("deg)"));
                    var upgrader_interval = setInterval(() => {
                        if(i<=49){offset = offset + 23;}
                        else if(i<=50){offset = offset + 22.3;}
                        else if(i<=60){offset = offset + 22;}
                        else if(i<=65){offset = offset + 19;}
                        else if(i<=70){offset = offset + 18;}
                        else if(i<=75){offset = offset + 17;}
                        else if(i<=80){offset = offset + 16;}
                        else if(i<=85){offset = offset + 15;}
                        else if(i<=90){offset = offset + 14;}
                        else if(i<=95){offset = offset + 13;}
                        else if(i<=100){offset = offset + 12;}
                        else if(i<=105){offset = offset + 11;}
                        else if(i<=110){offset = offset + 10;}
                        else if(i<=120){offset = offset + 9;}
                        else if(i<=130){offset = offset + 8;}
                        else if(i<=140){offset = offset + 7;}
                        else if(i<=150){offset = offset + 6.5;}
                        else if(i<=160){offset = offset + 6;}
                        else if(i<=170){offset = offset + 5.5;}
                        else if(i<=180){offset = offset + 5;}
                        else if(i<=190){offset = offset + 4.5;}
                        else if(i<=200){offset = offset + 4;}
                        else if(i<=210){offset = offset + 3.7;}
                        else if(i<=220){offset = offset + 3.3;}
                        else if(i<=230){offset = offset + 3;}
                        else if(i<=240){offset = offset + 2.7;}
                        else if(i<=250){offset = offset + 2.3;}
                        else if(i<=260){offset = offset + 2;}
                        else if(i<=270){offset = offset + 1.7;}
                        else if(i<=280){offset = offset + 1.3;}
                        else if(i<=290){offset = offset + 1;}
                        else if(i<=300){offset = offset + 0.7;}
                        else if(i<=310){offset = offset + 0.5;}
                        else if(i<=320){offset = offset + 0.3}
                        else if(i<=330){offset = offset + 0.2;}
                        else if(i<=340){offset = offset + 0.15;}
                        else if(i<=350){offset = offset + 0.12;}
                        else if(i<=360){offset = offset + 0.1;}
                        $(".upgrader-circle-progress").css("transform", "rotate(".concat(offset).concat("deg)"));
                        if(i>360)
                        {
                            clearInterval(upgrader_interval);
                            chosen_left_skin_id = 0;
                            chosen_right_skin_id = 0;
                            $(".upgrader-skins-top-text-filters-single-button").css("border", "1px solid #2c2b36");
                            $("#filter-left-1").css("border", "1px solid #49d164");
                            $("#upgrader-left").load("upgrader_left.php");
                            $("#upgrader-skins-div-left").load("upgrader_skins_left.php?mode=1");
                            $("#upgrader-skins-div-right").load("upgrader_skins_right.php?mode=1&filter1=0&filter2=0&filter3=0&filter4=0");
                            $(".upgrader-chosen-right-div").hide();
                        }
                        i++
                    }, 16.667);
                </script>

                <?php
                if($losowa < $ratio)
                {
                    $connection->query("INSERT INTO items VALUES (NULL, '$skinid2', '$skincond2', '$uid', 0, 1)");
                }
                $connection->query("UPDATE items SET itemstatus=0 WHERE itemid='$item1'");
            }
        }
    }


?>