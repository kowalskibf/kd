<?php

    require_once 'db.php';
	require 'steamauth/steamauth.php';
	require 'steamauth/userInfo.php';

    $connection = @new mysqli($host, $db_user, $db_password, $db_name);
    mysqli_set_charset($connection, "utf8");

    error_reporting(E_ERROR | E_PARSE);

    if(ctype_alnum($_GET['mode']))
    {
        echo '<meta charset="UTF-8">';
        $_GET['filter1'] = htmlentities($_GET['filter1']);
        $_GET['filter2'] = htmlentities($_GET['filter2']);
        $_GET['filter3'] = htmlentities($_GET['filter3']);
        $_GET['filter4'] = htmlentities($_GET['filter4']);
        $weapon = $_GET['filter1'];
        $skin = $_GET['filter2'];
        $minprice = $_GET['filter3'];
        $maxprice = $_GET['filter4'];
        function formathajsureverse($wartosc)
        {
            if(strpos($wartosc, ",") !== false)
            {
                $czesci = explode(",", $wartosc);
                $zlote = intval($czesci[0]);
                $grosze = intval($czesci[1]);
                if($grosze < 10)
                {
                    $grosze = 10 * $grosze;
                }
                $suma = (100 * $zlote) + $grosze;
                return $suma;
            }
            else
            {
                $suma = intval(100 * $wartosc);
                return $suma;
            }
        }
        $uid = $_SESSION['userid'];

        if($minprice != "0")
        {
            $minprice = formathajsureverse($minprice);
        }
        if($maxprice != "0")
        {
            $maxprice = formathajsureverse($maxprice);
        }
        $qqq = "SELECT * FROM skins";
        if($weapon != "0")
        {
            $qqq = $qqq." WHERE skinname LIKE '%".$weapon."%'";
        }
        if($skin != "0")
        {
            if($weapon == "0")
            {
                $qqq = $qqq." WHERE skinskin LIKE '%".$skin."%'";
            }
            else
            {
                $qqq = $qqq." AND skinskin LIKE '%".$skin."%'";
            }
        }
        $result = $connection->query($qqq);
        $itemki = array();
        $items_ids = array();
        $items_conditions = array();
        $items_prices = array();
        $items_ilosc = 0;
        $ilosc_itemkow = 0;
        $ktory_itemek = 0;
        $numer_strony = 1;
        while($itemek = mysqli_fetch_assoc($result))
        {
            array_push($itemki, $itemek);
        }
        foreach($itemki as $itemek)
        {
            for($i=5;$i>0;$i--)
            {
                $czy_na_upgraderze = $itemek['skinupgrader'];
                if($czy_na_upgraderze[$i-1] != '0')
                {
                    if($itemek['skinprice'.$i] != 0)
                    {
                        if($minprice == 0 && $maxprice == 0)
                        {
                            array_push($items_ids, $itemek['skinid']);
                            array_push($items_conditions, $i);
                            array_push($items_prices, $itemek['skinprice'.$i]);
                            $items_ilosc++;
                            $ilosc_itemkow++;
                        }
                        if($minprice == 0 && $maxprice != 0)
                        {
                            if($itemek['skinprice'.$i] <= $maxprice)
                            {
                                array_push($items_ids, $itemek['skinid']);
                                array_push($items_conditions, $i);
                                array_push($items_prices, $itemek['skinprice'.$i]);
                                $items_ilosc++;
                                $ilosc_itemkow++;
                            }
                        }
                        if($minprice != 0 && $maxprice == 0)
                        {
                            if($itemek['skinprice'.$i] >= $minprice)
                            {
                                array_push($items_ids, $itemek['skinid']);
                                array_push($items_conditions, $i);
                                array_push($items_prices, $itemek['skinprice'.$i]);
                                $items_ilosc++;
                                $ilosc_itemkow++;
                            }
                        }
                        if($minprice != 0 && $maxprice != 0)
                        {
                            if(($itemek['skinprice'.$i] <= $maxprice) && ($itemek['skinprice'.$i] >= $minprice))
                            {
                                array_push($items_ids, $itemek['skinid']);
                                array_push($items_conditions, $i);
                                array_push($items_prices, $itemek['skinprice'.$i]);
                                $items_ilosc++;
                                $ilosc_itemkow++;
                            }
                        }
                    }
                }
            }
        }
        for($n = $items_ilosc; $n > 1; $n--)
        {
            for($i=0;$i<$n-1;$i++)
            {
                if($_GET['mode'] == 1)
                {
                    if($items_prices[$i] < $items_prices[$i+1])
                    {
                        $temp = $items_prices[$i];
                        $items_prices[$i] = $items_prices[$i+1];
                        $items_prices[$i+1] = $temp;
                        $temp = $items_ids[$i];
                        $items_ids[$i] = $items_ids[$i+1];
                        $items_ids[$i+1] = $temp;
                        $temp = $items_conditions[$i];
                        $items_conditions[$i] = $items_conditions[$i+1];
                        $items_conditions[$i+1] = $temp;
                    }
                }
                if($_GET['mode'] == 2)
                {
                    if($items_prices[$i] > $items_prices[$i+1])
                    {
                        $temp = $items_prices[$i];
                        $items_prices[$i] = $items_prices[$i+1];
                        $items_prices[$i+1] = $temp;
                        $temp = $items_ids[$i];
                        $items_ids[$i] = $items_ids[$i+1];
                        $items_ids[$i+1] = $temp;
                        $temp = $items_conditions[$i];
                        $items_conditions[$i] = $items_conditions[$i+1];
                        $items_conditions[$i+1] = $temp;
                    }
                }
            }
        }
        function formathajsu($wartosc)
        {
            if($wartosc < 10)
            {
                echo '0,0'.$wartosc.' PLN';
            }
            else if($wartosc < 100)
            {
                echo '0,'.$wartosc.' PLN';
            }
            else
            {
                $grosze = ($wartosc%100);
                $zlote = (($wartosc - $grosze)/100);
                echo $zlote.',';
                if($grosze < 10)
                {
                    echo '0'.$grosze;
                }
                else
                {
                    echo $grosze;
                }
                echo ' PLN';
            }
        }
        for($i=0;$i<$items_ilosc;$i++)
        {
            if($ktory_itemek % 15 == 0)
            {
                echo '<div class="upgrader-skins-right-single-page" id="upgrader-skins-right-single-page-'.$numer_strony.'">';
            }
            $itemid = $items_ids[$i];
            $result2 = $connection->query("SELECT * FROM skins WHERE skinid='$itemid'");
            $result2 = $result2->fetch_assoc();
            $rarity = $result2['rarity'];
            $opacity = '0.9';
            if($rarity == 1){$rarity = 'rgba(176, 195, 217, '.$opacity.')';}
            else if($rarity == 2){$rarity = 'rgba(94, 152, 217, '.$opacity.')';}
            else if($rarity == 3){$rarity = 'rgba(75, 105, 255, '.$opacity.')';}
            else if($rarity == 4){$rarity = 'rgba(136, 71, 255, '.$opacity.')';}
            else if($rarity == 5){$rarity = 'rgba(211, 44, 230, '.$opacity.')';}
            else if($rarity == 6){$rarity = 'rgba(235, 75, 75, '.$opacity.')';}
            else if($rarity == 7){$rarity = 'rgba(228, 174, 57, '.$opacity.')';}
            echo '<div id="upgrader-skin-right-div'.$items_ids[$i].'x'.$items_conditions[$i].'" class="upgrader-single-right-skin-div" style="background:linear-gradient(rgba(0,0,0,0) 0%, rgba(0,0,0,0) 70%,'.$rarity.' 100%);">';
            echo '<div class="upgrader-single-skin-top">';
            echo '<div class="upgraderskinsmalltext upgrader-single-skin-condition">';
            if($items_conditions[$i] == 1){echo 'BS';}
            if($items_conditions[$i] == 2){echo 'WW';}
            if($items_conditions[$i] == 3){echo 'FT';}
            if($items_conditions[$i] == 4){echo 'MW';}
            if($items_conditions[$i] == 5){echo 'FN';}
            echo '</div><div class="upgrader-single-skin-price-container"><div class="upgrader-single-skin-price">';
            formathajsu($items_prices[$i]);
            echo '</div></div>';
            echo '<img src="'.$result2['skinimg'].'" class="upgraderskinimg">';
            echo '<br/><div class="upgraderskinalltext"><div class="upgraderskinsmalltext">';
            echo $result2['skinskin'];
            echo '</div><div class="upgraderskinbigtext">';
            echo $result2['skinname'];
            echo '</div></div></div></div>';
            echo '<script>$("#upgrader-skin-right-div'.$items_ids[$i].'x'.$items_conditions[$i].'").on("click", function(){
                if($("#upgrader-skin-right-div'.$items_ids[$i].'x'.$items_conditions[$i].'").css("opacity") == "1")
                {
                    chosen_right_skin_id = "'.$items_ids[$i].'x'.$items_conditions[$i].'";
                    $(".upgrader-single-right-skin-div").css("opacity", "1");
                    $(".upgrader-chosen-right-div").hide();
                    $("#upgrader-skin-right-div'.$items_ids[$i].'x'.$items_conditions[$i].'").css("opacity", "0.2");
                    $("#upgrader-chosen-right-div'.$items_ids[$i].'x'.$items_conditions[$i].'").show();
                }
                else
                {
                    chosen_right_skin_id = 0;
                    $(".upgrader-single-right-skin-div").show();
                    $(".upgrader-chosen-right-div").hide();
                    $("#upgrader-skin-right-div'.$items_ids[$i].'x'.$items_conditions[$i].'").css("opacity", "1");
                    $("#upgrader-chosen-right-div'.$items_ids[$i].'x'.$items_conditions[$i].'").hide();
                }
                $("#upgrader-middle").load("upgrader_middle.php?price1=".concat(chosen_left_skin_id).concat("&price2=").concat(chosen_right_skin_id));
            });</script>';
            if((($ktory_itemek - 14) % 15 == 0) && ($ktory_itemek + 1 < $ilosc_itemkow))
            {
                echo '<div class="upgrader-skins-bottom">';
                echo '<div class="upgrader-img-container"><div class="upgrader-skins-right-arrow-left" id="upgrader-skins-right-arrow-left-'.$numer_strony.'">';
                echo '<img src="img/leftarrowgrey.png" class="upgrader-skins-arrow-img"></div></div>';
                echo '<div class="upgrader-skins-left-bottom-middle">'.$numer_strony.'/'.(ceil($ilosc_itemkow/15)).'</div>';
                echo '<div class="upgrader-img-container upgrader-img-container-right"><div class="upgrader-skins-right-arrow-right" id="upgrader-skins-right-arrow-right-'.$numer_strony.'" style="float:right;">';
                echo '<img src="img/rightarrowgrey.png" class="upgrader-skins-arrow-img"></div></div>';
                echo '</div></div>';
                echo '<script>
                    $("#upgrader-skins-right-arrow-left-'.$numer_strony.'").on("click", function(){
                        $(".upgrader-skins-right-single-page").hide();
                        $("#upgrader-skins-right-single-page-'.($numer_strony - 1).'").show();
                    });
                    $("#upgrader-skins-right-arrow-right-'.$numer_strony.'").on("click", function(){
                        $(".upgrader-skins-right-single-page").hide();
                        $("#upgrader-skins-right-single-page-'.($numer_strony + 1).'").show();
                    });
                </script>';
                $numer_strony++;
            }
            else if(($ktory_itemek - 14) % 15 == 0)
            {
                echo '<div class="upgrader-skins-bottom">';
                echo '<div class="upgrader-img-container"><div class="upgrader-skins-right-arrow-left" id="upgrader-skins-right-arrow-left-'.$numer_strony.'">';
                echo '<img src="img/leftarrowgrey.png" class="upgrader-skins-arrow-img"></div></div>';
                echo '<div class="upgrader-skins-left-bottom-middle">'.$numer_strony.'/'.(ceil($ilosc_itemkow/15)).'</div>';
                echo '<div class="upgrader-img-container upgrader-img-container-right"><div class="upgrader-skins-right-arrow-right" id="upgrader-skins-right-arrow-right-'.$numer_strony.'" style="float:right;">';
                echo '<img src="img/rightarrowgrey.png" class="upgrader-skins-arrow-img"></div></div>';
                echo '</div></div>';
                echo '<script>
                    $("#upgrader-skins-right-arrow-left-'.$numer_strony.'").on("click", function(){
                        $(".upgrader-skins-right-single-page").hide();
                        $("#upgrader-skins-right-single-page-'.($numer_strony - 1).'").show();
                    });
                    $("#upgrader-skins-right-arrow-right-'.$numer_strony.'").on("click", function(){
                        $(".upgrader-skins-right-single-page").hide();
                        $("#upgrader-skins-right-single-page-'.($numer_strony + 1).'").show();
                    });
                </script>';
            }
            $ktory_itemek++;
        }
        $ktory_itemek--;
        if(($ktory_itemek - 14) % 15 != 0)
        {
            if($ktory_itemek % 15 < 5)
            {
                echo '<div class="upgrader-skins-bottom" style="clear:both;padding-top:341px;height:0px;">';
            }
            else if($ktory_itemek % 15 < 10)
            {
                echo '<div class="upgrader-skins-bottom" style="clear:both;padding-top:170px;height:0px;">';
            }
            else
            {
                echo '<div class="upgrader-skins-bottom" style="clear:both;height:0px;">';
            }
            echo '<div class="upgrader-img-container"><div class="upgrader-skins-right-arrow-left" id="upgrader-skins-right-arrow-left-'.$numer_strony.'">';
            echo '<img src="img/leftarrowgrey.png" class="upgrader-skins-arrow-img"></div></div>';
            echo '<div class="upgrader-skins-left-bottom-middle">'.$numer_strony.'/'.(ceil($ilosc_itemkow/15)).'</div>';
            echo '<div class="upgrader-img-container upgrader-img-container-right"><div class="upgrader-skins-right-arrow-right" id="upgrader-skins-right-arrow-right-'.$numer_strony.'" style="float:right;">';
            echo '<img src="img/rightarrowgrey.png" class="upgrader-skins-arrow-img"></div></div>';
            echo '</div></div>';
            echo '<script>
                $("#upgrader-skins-right-arrow-left-'.$numer_strony.'").on("click", function(){
                    $(".upgrader-skins-right-single-page").hide();
                    $("#upgrader-skins-right-single-page-'.($numer_strony - 1).'").show();
                });
                $("#upgrader-skins-right-arrow-right-'.$numer_strony.'").on("click", function(){
                    $(".upgrader-skins-right-single-page").hide();
                    $("#upgrader-skins-right-single-page-'.($numer_strony + 1).'").show();
                });
            </script>';
        }
        echo '<script>
            $(".upgrader-skins-right-single-page").hide();
            $("#upgrader-skins-right-single-page-1").show();
            $("#upgrader-skins-right-arrow-left-1").text("");
            $("#upgrader-skins-right-arrow-left-1").off("click");
            $("#upgrader-skins-right-arrow-left-1").css("cursor", "auto");
            $("#upgrader-skins-right-arrow-right-'.$numer_strony.'").text("");
            $("#upgrader-skins-right-arrow-right-'.$numer_strony.'").off("click");
            $("#upgrader-skins-right-arrow-right-'.$numer_strony.'").css("cursor", "auto");
        </script>';
    }

?>