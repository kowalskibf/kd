<meta charset="UTF-8">

<?php

    require_once 'db.php';
	require 'steamauth/steamauth.php';
	require 'steamauth/userInfo.php';

    $connection = @new mysqli($host, $db_user, $db_password, $db_name);
    mysqli_set_charset($connection, "utf8");

    if(isset($_GET['mode']))
    {
        if(ctype_alnum($_GET['mode']))
        {
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
            $uid = $_SESSION['userid'];
            if($_GET['mode'] == 1)
            {
                $result = $connection->query("SELECT * FROM items WHERE itemuserid='$uid' AND itemstatus=1 ORDER BY itemid DESC");
                $itemki = array();
                $ilosc_itemkow = 0;
                $ktory_itemek = 0;
                $numer_strony = 1;
                while($itemek = mysqli_fetch_assoc($result))
                {
                    array_push($itemki, $itemek);
                    $ilosc_itemkow++;
                }
                foreach($itemki as $itemek)
                {
                    if($ktory_itemek % 15 == 0)
                    {
                        echo '<div class="upgrader-skins-left-single-page" id="upgrader-skins-left-single-page-'.$numer_strony.'">';
                    }
                    $itemekskinid = $itemek['itemskinid'];
                    $result2 = $connection->query("SELECT * FROM skins WHERE skinid='$itemekskinid'");
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
                    echo '<div id="upgrader-skin-left-div'.$itemek['itemid'].'" class="upgrader-single-skin-div" style="background:linear-gradient(rgba(0,0,0,0) 0%, rgba(0,0,0,0) 70%,'.$rarity.' 100%);">';
                    echo '<div class="upgrader-single-skin-top">';
                    echo '<div class="upgraderskinsmalltext upgrader-single-skin-condition">';
                    if($itemek['itemcondition'] == 1){ echo 'BS';}
                    if($itemek['itemcondition'] == 2){ echo 'WW';}
                    if($itemek['itemcondition'] == 3){ echo 'FT';}
                    if($itemek['itemcondition'] == 4){ echo 'MW';}
                    if($itemek['itemcondition'] == 5){ echo 'FN';}
                    echo '</div><div class="upgrader-single-skin-price-container"><div class="upgrader-single-skin-price">';
                    $price = $result2['skinprice'.$itemek['itemcondition']];
                    if($price < 10)
                    {
                        echo '0,0'.$price.' PLN';
                    }
                    else if($price < 100)
                    {
                        echo '0,'.$price.' PLN';
                    }
                    else
                    {
                        $grosze = ($price%100);
                        $zlote = (($price - $grosze)/100);
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
                    echo '</div></div>';
                    echo '<img src="'.$result2['skinimg'].'" class="upgraderskinimg">';
                    echo '<br/><div class="upgraderskinalltext"><div class="upgraderskinsmalltext">';
                    echo $result2['skinskin'];
                    echo '</div><div class="upgraderskinbigtext">';
                    echo $result2['skinname'];
                    echo '</div></div></div></div>';
                    echo '<script>$("#upgrader-skin-left-div'.$itemek['itemid'].'").on("click", function(){
                        if($("#upgrader-skin-left-div'.$itemek['itemid'].'").css("opacity") == "1")
                        {
                            chosen_left_skin_id = '.$itemek['itemid'].';
                            $(".upgrader-single-skin-div").css("opacity", "1");
                            $(".upgrader-chosen-left-div").hide();
                            $("#upgrader-skin-left-div'.$itemek['itemid'].'").css("opacity", "0.2");
                            $("#upgrader-chosen-left-div'.$itemek['itemid'].'").show();
                        }
                        else
                        {
                            chosen_left_skin_id = 0;
                            $(".upgrader-single-skin-div").show();
                            $(".upgrader-chosen-left-div").hide();
                            $("#upgrader-skin-left-div'.$itemek['itemid'].'").css("opacity", "1");
                            $("#upgrader-chosen-left-div'.$itemek['itemid'].'").hide();
                        }
                        $("#upgrader-middle").load("upgrader_middle.php?price1=".concat(chosen_left_skin_id).concat("&price2=").concat(chosen_right_skin_id));
                    });</script>';
                    if((($ktory_itemek - 14) % 15 == 0) && ($ktory_itemek + 1 < $ilosc_itemkow))
                    {
                        echo '<div class="upgrader-skins-bottom">';
                        echo '<div class="upgrader-img-container"><div class="upgrader-skins-left-arrow-left" id="upgrader-skins-left-arrow-left-'.$numer_strony.'">';
                        echo '<img src="img/leftarrowgrey.png" class="upgrader-skins-arrow-img"></div></div>';
                        echo '<div class="upgrader-skins-left-bottom-middle">'.$numer_strony.'/'.(ceil($ilosc_itemkow/15)).'</div>';
                        echo '<div class="upgrader-img-container upgrader-img-container-right"><div class="upgrader-skins-left-arrow-right" id="upgrader-skins-left-arrow-right-'.$numer_strony.'" style="float:right;">';
                        echo '<img src="img/rightarrowgrey.png" class="upgrader-skins-arrow-img"></div></div>';
                        echo '</div></div>';
                        echo '<script>
                            $("#upgrader-skins-left-arrow-left-'.$numer_strony.'").on("click", function(){
                                $(".upgrader-skins-left-single-page").hide();
                                $("#upgrader-skins-left-single-page-'.($numer_strony - 1).'").show();
                            });
                            $("#upgrader-skins-left-arrow-right-'.$numer_strony.'").on("click", function(){
                                $(".upgrader-skins-left-single-page").hide();
                                $("#upgrader-skins-left-single-page-'.($numer_strony + 1).'").show();
                            });
                        </script>';
                        $numer_strony++;
                    }
                    else if(($ktory_itemek - 14) % 15 == 0)
                    {
                        echo '<div class="upgrader-skins-bottom">';
                        echo '<div class="upgrader-img-container"><div class="upgrader-skins-left-arrow-left" id="upgrader-skins-left-arrow-left-'.$numer_strony.'">';
                        echo '<img src="img/leftarrowgrey.png" class="upgrader-skins-arrow-img"></div></div>';
                        echo '<div class="upgrader-skins-left-bottom-middle">'.$numer_strony.'/'.(ceil($ilosc_itemkow/15)).'</div>';
                        echo '<div class="upgrader-img-container upgrader-img-container-right"><div class="upgrader-skins-left-arrow-right" id="upgrader-skins-left-arrow-right-'.$numer_strony.'" style="float:right;">';
                        echo '<img src="img/rightarrowgrey.png" class="upgrader-skins-arrow-img"></div></div>';
                        echo '</div></div>';
                        echo '<script>
                            $("#upgrader-skins-left-arrow-left-'.$numer_strony.'").on("click", function(){
                                $(".upgrader-skins-left-single-page").hide();
                                $("#upgrader-skins-left-single-page-'.($numer_strony - 1).'").show();
                            });
                            $("#upgrader-skins-left-arrow-right-'.$numer_strony.'").on("click", function(){
                                $(".upgrader-skins-left-single-page").hide();
                                $("#upgrader-skins-left-single-page-'.($numer_strony + 1).'").show();
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
                    echo '<div class="upgrader-img-container"><div class="upgrader-skins-left-arrow-left" id="upgrader-skins-left-arrow-left-'.$numer_strony.'">';
                    echo '<img src="img/leftarrowgrey.png" class="upgrader-skins-arrow-img"></div></div>';
                    echo '<div class="upgrader-skins-left-bottom-middle">'.$numer_strony.'/'.(ceil($ilosc_itemkow/15)).'</div>';
                    echo '<div class="upgrader-img-container upgrader-img-container-right"><div class="upgrader-skins-left-arrow-right" id="upgrader-skins-left-arrow-right-'.$numer_strony.'" style="float:right;">';
                    echo '<img src="img/rightarrowgrey.png" class="upgrader-skins-arrow-img"></div></div>';
                    echo '</div></div>';
                    echo '<script>
                        $("#upgrader-skins-left-arrow-left-'.$numer_strony.'").on("click", function(){
                            $(".upgrader-skins-left-single-page").hide();
                            $("#upgrader-skins-left-single-page-'.($numer_strony - 1).'").show();
                        });
                        $("#upgrader-skins-left-arrow-right-'.$numer_strony.'").on("click", function(){
                            $(".upgrader-skins-left-single-page").hide();
                            $("#upgrader-skins-left-single-page-'.($numer_strony + 1).'").show();
                        });
                    </script>';
                }
                echo '<script>
                    $(".upgrader-skins-left-single-page").hide();
                    $("#upgrader-skins-left-single-page-1").show();
                    $("#upgrader-skins-left-arrow-left-1").text("");
                    $("#upgrader-skins-left-arrow-left-1").off("click");
                    $("#upgrader-skins-left-arrow-left-1").css("cursor", "auto");
                    $("#upgrader-skins-left-arrow-right-'.$numer_strony.'").text("");
                    $("#upgrader-skins-left-arrow-right-'.$numer_strony.'").off("click");
                    $("#upgrader-skins-left-arrow-right-'.$numer_strony.'").css("cursor", "auto");
                </script>';
            }
            if($_GET['mode'] == 2)
            {
                $result = $connection->query("SELECT * FROM items WHERE itemuserid='$uid' AND itemstatus=1 ORDER BY itemid ASC");
                $itemki = array();
                $ilosc_itemkow = 0;
                $ktory_itemek = 0;
                $numer_strony = 1;
                while($itemek = mysqli_fetch_assoc($result))
                {
                    array_push($itemki, $itemek);
                    $ilosc_itemkow++;
                }
                foreach($itemki as $itemek)
                {
                    if($ktory_itemek % 15 == 0)
                    {
                        echo '<div class="upgrader-skins-left-single-page" id="upgrader-skins-left-single-page-'.$numer_strony.'">';
                    }
                    $itemekskinid = $itemek['itemskinid'];
                    $result2 = $connection->query("SELECT * FROM skins WHERE skinid='$itemekskinid'");
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
                    echo '<div id="upgrader-skin-left-div'.$itemek['itemid'].'" class="upgrader-single-skin-div" style="background:linear-gradient(rgba(0,0,0,0) 0%, rgba(0,0,0,0) 70%,'.$rarity.' 100%);">';
                    echo '<div class="upgrader-single-skin-top">';
                    echo '<div class="upgraderskinsmalltext upgrader-single-skin-condition">';
                    if($itemek['itemcondition'] == 1){ echo 'BS';}
                    if($itemek['itemcondition'] == 2){ echo 'WW';}
                    if($itemek['itemcondition'] == 3){ echo 'FT';}
                    if($itemek['itemcondition'] == 4){ echo 'MW';}
                    if($itemek['itemcondition'] == 5){ echo 'FN';}
                    echo '</div><div class="upgrader-single-skin-price-container"><div class="upgrader-single-skin-price">';
                    $price = $result2['skinprice'.$itemek['itemcondition']];
                    if($price < 10)
                    {
                        echo '0,0'.$price.' PLN';
                    }
                    else if($price < 100)
                    {
                        echo '0,'.$price.' PLN';
                    }
                    else
                    {
                        $grosze = ($price%100);
                        $zlote = (($price - $grosze)/100);
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
                    echo '</div></div>';
                    echo '<img src="'.$result2['skinimg'].'" class="upgraderskinimg">';
                    echo '<br/><div class="upgraderskinalltext"><div class="upgraderskinsmalltext">';
                    echo $result2['skinskin'];
                    echo '</div><div class="upgraderskinbigtext">';
                    echo $result2['skinname'];
                    echo '</div></div></div></div>';
                    echo '<script>$("#upgrader-skin-left-div'.$itemek['itemid'].'").on("click", function(){
                        if($("#upgrader-skin-left-div'.$itemek['itemid'].'").css("opacity") == "1")
                        {
                            chosen_left_skin_id = '.$itemek['itemid'].';
                            $(".upgrader-single-skin-div").css("opacity", "1");
                            $(".upgrader-chosen-left-div").hide();
                            $("#upgrader-skin-left-div'.$itemek['itemid'].'").css("opacity", "0.2");
                            $("#upgrader-chosen-left-div'.$itemek['itemid'].'").show();
                        }
                        else
                        {
                            chosen_left_skin_id = 0;
                            $(".upgrader-single-skin-div").show();
                            $(".upgrader-chosen-left-div").hide();
                            $("#upgrader-skin-left-div'.$itemek['itemid'].'").css("opacity", "1");
                            $("#upgrader-chosen-left-div'.$itemek['itemid'].'").hide();
                        }
                        $("#upgrader-middle").load("upgrader_middle.php?price1=".concat(chosen_left_skin_id).concat("&price2=").concat(chosen_right_skin_id));
                    });</script>';
                    if((($ktory_itemek - 14) % 15 == 0) && ($ktory_itemek + 1 < $ilosc_itemkow))
                    {
                        echo '<div class="upgrader-skins-bottom">';
                        echo '<div class="upgrader-img-container"><div class="upgrader-skins-left-arrow-left" id="upgrader-skins-left-arrow-left-'.$numer_strony.'">';
                        echo '<img src="img/leftarrowgrey.png" class="upgrader-skins-arrow-img"></div></div>';
                        echo '<div class="upgrader-skins-left-bottom-middle">'.$numer_strony.'/'.(ceil($ilosc_itemkow/15)).'</div>';
                        echo '<div class="upgrader-img-container upgrader-img-container-right"><div class="upgrader-skins-left-arrow-right" id="upgrader-skins-left-arrow-right-'.$numer_strony.'" style="float:right;">';
                        echo '<img src="img/rightarrowgrey.png" class="upgrader-skins-arrow-img"></div></div>';
                        echo '</div></div>';
                        echo '<script>
                            $("#upgrader-skins-left-arrow-left-'.$numer_strony.'").on("click", function(){
                                $(".upgrader-skins-left-single-page").hide();
                                $("#upgrader-skins-left-single-page-'.($numer_strony - 1).'").show();
                            });
                            $("#upgrader-skins-left-arrow-right-'.$numer_strony.'").on("click", function(){
                                $(".upgrader-skins-left-single-page").hide();
                                $("#upgrader-skins-left-single-page-'.($numer_strony + 1).'").show();
                            });
                        </script>';
                        $numer_strony++;
                    }
                    else if(($ktory_itemek - 14) % 15 == 0)
                    {
                        echo '<div class="upgrader-skins-bottom">';
                        echo '<div class="upgrader-img-container"><div class="upgrader-skins-left-arrow-left" id="upgrader-skins-left-arrow-left-'.$numer_strony.'">';
                        echo '<img src="img/leftarrowgrey.png" class="upgrader-skins-arrow-img"></div></div>';
                        echo '<div class="upgrader-skins-left-bottom-middle">'.$numer_strony.'/'.(ceil($ilosc_itemkow/15)).'</div>';
                        echo '<div class="upgrader-img-container upgrader-img-container-right"><div class="upgrader-skins-left-arrow-right" id="upgrader-skins-left-arrow-right-'.$numer_strony.'" style="float:right;">';
                        echo '<img src="img/rightarrowgrey.png" class="upgrader-skins-arrow-img"></div></div>';
                        echo '</div></div>';
                        echo '<script>
                            $("#upgrader-skins-left-arrow-left-'.$numer_strony.'").on("click", function(){
                                $(".upgrader-skins-left-single-page").hide();
                                $("#upgrader-skins-left-single-page-'.($numer_strony - 1).'").show();
                            });
                            $("#upgrader-skins-left-arrow-right-'.$numer_strony.'").on("click", function(){
                                $(".upgrader-skins-left-single-page").hide();
                                $("#upgrader-skins-left-single-page-'.($numer_strony + 1).'").show();
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
                    echo '<div class="upgrader-img-container"><div class="upgrader-skins-left-arrow-left" id="upgrader-skins-left-arrow-left-'.$numer_strony.'">';
                    echo '<img src="img/leftarrowgrey.png" class="upgrader-skins-arrow-img"></div></div>';
                    echo '<div class="upgrader-skins-left-bottom-middle">'.$numer_strony.'/'.(ceil($ilosc_itemkow/15)).'</div>';
                    echo '<div class="upgrader-img-container upgrader-img-container-right"><div class="upgrader-skins-left-arrow-right" id="upgrader-skins-left-arrow-right-'.$numer_strony.'" style="float:right;">';
                    echo '<img src="img/rightarrowgrey.png" class="upgrader-skins-arrow-img"></div></div>';
                    echo '</div></div>';
                    echo '<script>
                        $("#upgrader-skins-left-arrow-left-'.$numer_strony.'").on("click", function(){
                            $(".upgrader-skins-left-single-page").hide();
                            $("#upgrader-skins-left-single-page-'.($numer_strony - 1).'").show();
                        });
                        $("#upgrader-skins-left-arrow-right-'.$numer_strony.'").on("click", function(){
                            $(".upgrader-skins-left-single-page").hide();
                            $("#upgrader-skins-left-single-page-'.($numer_strony + 1).'").show();
                        });
                    </script>';
                }
                echo '<script>
                    $(".upgrader-skins-left-single-page").hide();
                    $("#upgrader-skins-left-single-page-1").show();
                    $("#upgrader-skins-left-arrow-left-1").text("");
                    $("#upgrader-skins-left-arrow-left-1").off("click");
                    $("#upgrader-skins-left-arrow-left-1").css("cursor", "auto");
                    $("#upgrader-skins-left-arrow-right-'.$numer_strony.'").text("");
                    $("#upgrader-skins-left-arrow-right-'.$numer_strony.'").off("click");
                    $("#upgrader-skins-left-arrow-right-'.$numer_strony.'").css("cursor", "auto");
                </script>';
            }
            if($_GET['mode'] == 3)
            {
                $result = $connection->query("SELECT * FROM items WHERE itemuserid='$uid' AND itemstatus=1 ORDER BY itemid DESC");
                $itemki = array();
                $items_ids = array();
                $items_conditions = array();
                $items_prices = array();
                $items_ids_items = array();
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
                    $skinid = $itemek['itemskinid'];
                    $result2 = $connection->query("SELECT * FROM skins WHERE skinid='$skinid'");
                    $result2 = $result2->fetch_assoc();
                    array_push($items_ids, $result2['skinid']);
                    array_push($items_conditions, $itemek['itemcondition']);
                    array_push($items_prices, $result2['skinprice'.$itemek['itemcondition']]);
                    array_push($items_ids_items, $itemek['itemid']);
                    $items_ilosc++;
                    $ilosc_itemkow++;
                }
                for($n = $items_ilosc; $n > 1; $n--)
                {
                    for($i=0;$i<$n-1;$i++)
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
                            $temp = $items_ids_items[$i];
                            $items_ids_items[$i] = $items_ids_items[$i+1];
                            $items_ids_items[$i+1] = $temp;
                        }
                    }
                }
                for($i=0;$i<$items_ilosc;$i++)
                {
                    if($ktory_itemek % 15 == 0)
                    {
                        echo '<div class="upgrader-skins-left-single-page" id="upgrader-skins-left-single-page-'.$numer_strony.'">';
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
                    echo '<div id="upgrader-skin-left-div'.$items_ids_items[$i].'" class="upgrader-single-skin-div" style="background:linear-gradient(rgba(0,0,0,0) 0%, rgba(0,0,0,0) 70%,'.$rarity.' 100%);">';
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
                    echo '<script>$("#upgrader-skin-left-div'.$items_ids_items[$i].'").on("click", function(){
                        if($("#upgrader-skin-left-div'.$items_ids_items[$i].'").css("opacity") == "1")
                        {
                            chosen_left_skin_id = '.$items_ids_items[$i].';
                            $(".upgrader-single-skin-div").css("opacity", "1");
                            $(".upgrader-chosen-left-div").hide();
                            $("#upgrader-skin-left-div'.$items_ids_items[$i].'").css("opacity", "0.2");
                            $("#upgrader-chosen-left-div'.$items_ids_items[$i].'").show();
                        }
                        else
                        {
                            chosen_left_skin_id = 0;
                            $(".upgrader-single-skin-div").show();
                            $(".upgrader-chosen-left-div").hide();
                            $("#upgrader-skin-left-div'.$items_ids_items[$i].'").css("opacity", "1");
                            $("#upgrader-chosen-left-div'.$items_ids_items[$i].'").hide();
                        }
                        $("#upgrader-middle").load("upgrader_middle.php?price1=".concat(chosen_left_skin_id).concat("&price2=").concat(chosen_right_skin_id));
                    });</script>';
                    if((($ktory_itemek - 14) % 15 == 0) && ($ktory_itemek + 1 < $ilosc_itemkow))
                    {
                        echo '<div class="upgrader-skins-bottom">';
                        echo '<div class="upgrader-img-container"><div class="upgrader-skins-left-arrow-left" id="upgrader-skins-left-arrow-left-'.$numer_strony.'">';
                        echo '<img src="img/leftarrowgrey.png" class="upgrader-skins-arrow-img"></div></div>';
                        echo '<div class="upgrader-skins-left-bottom-middle">'.$numer_strony.'/'.(ceil($ilosc_itemkow/15)).'</div>';
                        echo '<div class="upgrader-img-container upgrader-img-container-right"><div class="upgrader-skins-left-arrow-right" id="upgrader-skins-left-arrow-right-'.$numer_strony.'" style="float:right;">';
                        echo '<img src="img/rightarrowgrey.png" class="upgrader-skins-arrow-img"></div></div>';
                        echo '</div></div>';
                        echo '<script>
                            $("#upgrader-skins-left-arrow-left-'.$numer_strony.'").on("click", function(){
                                $(".upgrader-skins-left-single-page").hide();
                                $("#upgrader-skins-left-single-page-'.($numer_strony - 1).'").show();
                            });
                            $("#upgrader-skins-left-arrow-right-'.$numer_strony.'").on("click", function(){
                                $(".upgrader-skins-left-single-page").hide();
                                $("#upgrader-skins-left-single-page-'.($numer_strony + 1).'").show();
                            });
                        </script>';
                        $numer_strony++;
                    }
                    else if(($ktory_itemek - 14) % 15 == 0)
                    {
                        echo '<div class="upgrader-skins-bottom">';
                        echo '<div class="upgrader-img-container"><div class="upgrader-skins-left-arrow-left" id="upgrader-skins-left-arrow-left-'.$numer_strony.'">';
                        echo '<img src="img/leftarrowgrey.png" class="upgrader-skins-arrow-img"></div></div>';
                        echo '<div class="upgrader-skins-left-bottom-middle">'.$numer_strony.'/'.(ceil($ilosc_itemkow/15)).'</div>';
                        echo '<div class="upgrader-img-container upgrader-img-container-right"><div class="upgrader-skins-left-arrow-right" id="upgrader-skins-left-arrow-right-'.$numer_strony.'" style="float:right;">';
                        echo '<img src="img/rightarrowgrey.png" class="upgrader-skins-arrow-img"></div></div>';
                        echo '</div></div>';
                        echo '<script>
                            $("#upgrader-skins-left-arrow-left-'.$numer_strony.'").on("click", function(){
                                $(".upgrader-skins-left-single-page").hide();
                                $("#upgrader-skins-left-single-page-'.($numer_strony - 1).'").show();
                            });
                            $("#upgrader-skins-left-arrow-right-'.$numer_strony.'").on("click", function(){
                                $(".upgrader-skins-left-single-page").hide();
                                $("#upgrader-skins-left-single-page-'.($numer_strony + 1).'").show();
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
                    echo '<div class="upgrader-img-container"><div class="upgrader-skins-left-arrow-left" id="upgrader-skins-left-arrow-left-'.$numer_strony.'">';
                    echo '<img src="img/leftarrowgrey.png" class="upgrader-skins-arrow-img"></div></div>';
                    echo '<div class="upgrader-skins-left-bottom-middle">'.$numer_strony.'/'.(ceil($ilosc_itemkow/15)).'</div>';
                    echo '<div class="upgrader-img-container upgrader-img-container-right"><div class="upgrader-skins-left-arrow-right" id="upgrader-skins-left-arrow-right-'.$numer_strony.'" style="float:right;">';
                    echo '<img src="img/rightarrowgrey.png" class="upgrader-skins-arrow-img"></div></div>';
                    echo '</div></div>';
                    echo '<script>
                        $("#upgrader-skins-left-arrow-left-'.$numer_strony.'").on("click", function(){
                            $(".upgrader-skins-left-single-page").hide();
                            $("#upgrader-skins-left-single-page-'.($numer_strony - 1).'").show();
                        });
                        $("#upgrader-skins-left-arrow-right-'.$numer_strony.'").on("click", function(){
                            $(".upgrader-skins-left-single-page").hide();
                            $("#upgrader-skins-left-single-page-'.($numer_strony + 1).'").show();
                        });
                    </script>';
                }
                echo '<script>
                    $(".upgrader-skins-left-single-page").hide();
                    $("#upgrader-skins-left-single-page-1").show();
                    $("#upgrader-skins-left-arrow-left-1").text("");
                    $("#upgrader-skins-left-arrow-left-1").off("click");
                    $("#upgrader-skins-left-arrow-left-1").css("cursor", "auto");
                    $("#upgrader-skins-left-arrow-right-'.$numer_strony.'").text("");
                    $("#upgrader-skins-left-arrow-right-'.$numer_strony.'").off("click");
                    $("#upgrader-skins-left-arrow-right-'.$numer_strony.'").css("cursor", "auto");
                </script>';
            }
            if($_GET['mode'] == 4)
            {
                $result = $connection->query("SELECT * FROM items WHERE itemuserid='$uid' AND itemstatus=1 ORDER BY itemid DESC");
                $itemki = array();
                $items_ids = array();
                $items_conditions = array();
                $items_prices = array();
                $items_ids_items = array();
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
                    $skinid = $itemek['itemskinid'];
                    $result2 = $connection->query("SELECT * FROM skins WHERE skinid='$skinid'");
                    $result2 = $result2->fetch_assoc();
                    array_push($items_ids, $result2['skinid']);
                    array_push($items_conditions, $itemek['itemcondition']);
                    array_push($items_prices, $result2['skinprice'.$itemek['itemcondition']]);
                    array_push($items_ids_items, $itemek['itemid']);
                    $items_ilosc++;
                    $ilosc_itemkow++;
                }
                for($n = $items_ilosc; $n > 1; $n--)
                {
                    for($i=0;$i<$n-1;$i++)
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
                            $temp = $items_ids_items[$i];
                            $items_ids_items[$i] = $items_ids_items[$i+1];
                            $items_ids_items[$i+1] = $temp;
                        }
                    }
                }
                for($i=0;$i<$items_ilosc;$i++)
                {
                    if($ktory_itemek % 15 == 0)
                    {
                        echo '<div class="upgrader-skins-left-single-page" id="upgrader-skins-left-single-page-'.$numer_strony.'">';
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
                    echo '<div id="upgrader-skin-left-div'.$items_ids_items[$i].'" class="upgrader-single-skin-div" style="background:linear-gradient(rgba(0,0,0,0) 0%, rgba(0,0,0,0) 70%,'.$rarity.' 100%);">';
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
                    echo '<script>$("#upgrader-skin-left-div'.$items_ids_items[$i].'").on("click", function(){
                        if($("#upgrader-skin-left-div'.$items_ids_items[$i].'").css("opacity") == "1")
                        {
                            chosen_left_skin_id = '.$items_ids_items[$i].';
                            $(".upgrader-single-skin-div").css("opacity", "1");
                            $(".upgrader-chosen-left-div").hide();
                            $("#upgrader-skin-left-div'.$items_ids_items[$i].'").css("opacity", "0.2");
                            $("#upgrader-chosen-left-div'.$items_ids_items[$i].'").show();
                        }
                        else
                        {
                            chosen_left_skin_id = 0;
                            $(".upgrader-single-skin-div").show();
                            $(".upgrader-chosen-left-div").hide();
                            $("#upgrader-skin-left-div'.$items_ids_items[$i].'").css("opacity", "1");
                            $("#upgrader-chosen-left-div'.$items_ids_items[$i].'").hide();
                        }
                        $("#upgrader-middle").load("upgrader_middle.php?price1=".concat(chosen_left_skin_id).concat("&price2=").concat(chosen_right_skin_id));
                    });</script>';
                    if((($ktory_itemek - 14) % 15 == 0) && ($ktory_itemek + 1 < $ilosc_itemkow))
                    {
                        echo '<div class="upgrader-skins-bottom">';
                        echo '<div class="upgrader-img-container"><div class="upgrader-skins-left-arrow-left" id="upgrader-skins-left-arrow-left-'.$numer_strony.'">';
                        echo '<img src="img/leftarrowgrey.png" class="upgrader-skins-arrow-img"></div></div>';
                        echo '<div class="upgrader-skins-left-bottom-middle">'.$numer_strony.'/'.(ceil($ilosc_itemkow/15)).'</div>';
                        echo '<div class="upgrader-img-container upgrader-img-container-right"><div class="upgrader-skins-left-arrow-right" id="upgrader-skins-left-arrow-right-'.$numer_strony.'" style="float:right;">';
                        echo '<img src="img/rightarrowgrey.png" class="upgrader-skins-arrow-img"></div></div>';
                        echo '</div></div>';
                        echo '<script>
                            $("#upgrader-skins-left-arrow-left-'.$numer_strony.'").on("click", function(){
                                $(".upgrader-skins-left-single-page").hide();
                                $("#upgrader-skins-left-single-page-'.($numer_strony - 1).'").show();
                            });
                            $("#upgrader-skins-left-arrow-right-'.$numer_strony.'").on("click", function(){
                                $(".upgrader-skins-left-single-page").hide();
                                $("#upgrader-skins-left-single-page-'.($numer_strony + 1).'").show();
                            });
                        </script>';
                        $numer_strony++;
                    }
                    else if(($ktory_itemek - 14) % 15 == 0)
                    {
                        echo '<div class="upgrader-skins-bottom">';
                        echo '<div class="upgrader-img-container"><div class="upgrader-skins-left-arrow-left" id="upgrader-skins-left-arrow-left-'.$numer_strony.'">';
                        echo '<img src="img/leftarrowgrey.png" class="upgrader-skins-arrow-img"></div></div>';
                        echo '<div class="upgrader-skins-left-bottom-middle">'.$numer_strony.'/'.(ceil($ilosc_itemkow/15)).'</div>';
                        echo '<div class="upgrader-img-container upgrader-img-container-right"><div class="upgrader-skins-left-arrow-right" id="upgrader-skins-left-arrow-right-'.$numer_strony.'" style="float:right;">';
                        echo '<img src="img/rightarrowgrey.png" class="upgrader-skins-arrow-img"></div></div>';
                        echo '</div></div>';
                        echo '<script>
                            $("#upgrader-skins-left-arrow-left-'.$numer_strony.'").on("click", function(){
                                $(".upgrader-skins-left-single-page").hide();
                                $("#upgrader-skins-left-single-page-'.($numer_strony - 1).'").show();
                            });
                            $("#upgrader-skins-left-arrow-right-'.$numer_strony.'").on("click", function(){
                                $(".upgrader-skins-left-single-page").hide();
                                $("#upgrader-skins-left-single-page-'.($numer_strony + 1).'").show();
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
                    echo '<div class="upgrader-img-container"><div class="upgrader-skins-left-arrow-left" id="upgrader-skins-left-arrow-left-'.$numer_strony.'">';
                    echo '<img src="img/leftarrowgrey.png" class="upgrader-skins-arrow-img"></div></div>';
                    echo '<div class="upgrader-skins-left-bottom-middle">'.$numer_strony.'/'.(ceil($ilosc_itemkow/15)).'</div>';
                    echo '<div class="upgrader-img-container upgrader-img-container-right"><div class="upgrader-skins-left-arrow-right" id="upgrader-skins-left-arrow-right-'.$numer_strony.'" style="float:right;">';
                    echo '<img src="img/rightarrowgrey.png" class="upgrader-skins-arrow-img"></div></div>';
                    echo '</div></div>';
                    echo '<script>
                        $("#upgrader-skins-left-arrow-left-'.$numer_strony.'").on("click", function(){
                            $(".upgrader-skins-left-single-page").hide();
                            $("#upgrader-skins-left-single-page-'.($numer_strony - 1).'").show();
                        });
                        $("#upgrader-skins-left-arrow-right-'.$numer_strony.'").on("click", function(){
                            $(".upgrader-skins-left-single-page").hide();
                            $("#upgrader-skins-left-single-page-'.($numer_strony + 1).'").show();
                        });
                    </script>';
                }
                echo '<script>
                    $(".upgrader-skins-left-single-page").hide();
                    $("#upgrader-skins-left-single-page-1").show();
                    $("#upgrader-skins-left-arrow-left-1").text("");
                    $("#upgrader-skins-left-arrow-left-1").off("click");
                    $("#upgrader-skins-left-arrow-left-1").css("cursor", "auto");
                    $("#upgrader-skins-left-arrow-right-'.$numer_strony.'").text("");
                    $("#upgrader-skins-left-arrow-right-'.$numer_strony.'").off("click");
                    $("#upgrader-skins-left-arrow-right-'.$numer_strony.'").css("cursor", "auto");
                </script>';
            }
        }
    }

?>