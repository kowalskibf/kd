<?php

    echo '<div class="upgrader-top-left-right-text">DESIRED ITEM</div>';

    require_once 'db.php';
	require 'steamauth/steamauth.php';
	require 'steamauth/userInfo.php';

    $connection = @new mysqli($host, $db_user, $db_password, $db_name);
    mysqli_set_charset($connection, "utf8");

    $uid = $_SESSION['userid'];
    $result = $connection->query("SELECT * FROM skins");
    $itemki = array();
    $items_ids = array();
    $items_conditions = array();
    $items_prices = array();
    $items_ilosc = 0;
    while($itemek = mysqli_fetch_assoc($result))
    {
        array_push($itemki, $itemek);
    }
    foreach($itemki as $itemek)
    {
        for($i=5;$i>0;$i--)
        {
            $czybaza = $itemek['skinupgrader'];
            if($czybaza[$i-1] != 0)
            {
                if($itemek['skinprice'.$i] != 0)
                {
                    array_push($items_ids, $itemek['skinid']);
                    array_push($items_conditions, $i);
                    array_push($items_prices, $itemek['skinprice'.$i]);
                    $items_ilosc++;
                }
            }
        }
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
        echo '<div id="upgrader-chosen-right-div'.$items_ids[$i].'x'.$items_conditions[$i].'" class="upgrader-chosen-right-div" style="background:linear-gradient(rgba(0,0,0,0) 0%, rgba(0,0,0,0) 70%,'.$rarity.' 100%);">';
        echo '<div class="upgrader-single-skin-top">';
        echo '<div class="upgraderskinsmalltext-top upgrader-single-skin-condition-top">';
        if($items_conditions[$i] == 1){echo 'BS';}
        if($items_conditions[$i] == 2){echo 'WW';}
        if($items_conditions[$i] == 3){echo 'FT';}
        if($items_conditions[$i] == 4){echo 'MW';}
        if($items_conditions[$i] == 5){echo 'FN';}
        echo '</div><div class="upgrader-single-skin-price-container"><div class="upgrader-single-skin-price-top">';
        formathajsu($items_prices[$i]);
        echo '</div></div>';
        echo '<img src="'.$result2['skinimg'].'" class="upgraderskinimg-top">';
        echo '<br/><div class="upgraderskinalltext"><div class="upgraderskinsmalltext-top">';
        echo $result2['skinskin'];
        echo '</div><div class="upgraderskinbigtext-top">';
        echo $result2['skinname'];
        echo '</div></div></div></div>';
        echo '<script>$("#upgrader-chosen-right-div'.$items_ids[$i].'x'.$items_conditions[$i].'").on("click", function(){
            chosen_right_skin_id = 0;
            $(".upgrader-single-right-skin-div").show();
            $(".upgrader-chosen-right-div").hide();
            $(".upgrader-single-right-skin-div").css("opacity", "1");
            $("#upgrader-chosen-right-div'.$items_ids[$i].'x'.$items_conditions[$i].'").hide();
            $("#upgrader-middle").load("upgrader_middle.php?price1=".concat(chosen_left_skin_id).concat("&price2=").concat(chosen_right_skin_id));
        });</script>';
    }
    echo '<script>$(".upgrader-chosen-right-div").hide();</script>';

?>