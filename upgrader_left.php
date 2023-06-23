<?php

    echo '<div class="upgrader-top-left-right-text">YOUR ITEM</div>';

    require_once 'db.php';
	require 'steamauth/steamauth.php';
	require 'steamauth/userInfo.php';

    $connection = @new mysqli($host, $db_user, $db_password, $db_name);
    mysqli_set_charset($connection, "utf8");

    $uid = $_SESSION['userid'];
    $result = $connection->query("SELECT * FROM items WHERE itemuserid='$uid' AND itemstatus=1 ORDER BY itemid DESC");
    $itemki = array();
    while($itemek = mysqli_fetch_assoc($result))
    {
        array_push($itemki, $itemek);
    }
    foreach($itemki as $itemek)
    {
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
        echo '<div id="upgrader-chosen-left-div'.$itemek['itemid'].'" class="upgrader-chosen-left-div" style="background:linear-gradient(rgba(0,0,0,0) 0%, rgba(0,0,0,0) 70%,'.$rarity.' 100%);">';
        echo '<div class="upgrader-single-skin-top">';
        echo '<div class="upgraderskinsmalltext-top upgrader-single-skin-condition-top">';
        if($itemek['itemcondition'] == 1){ echo 'BS';}
        if($itemek['itemcondition'] == 2){ echo 'WW';}
        if($itemek['itemcondition'] == 3){ echo 'FT';}
        if($itemek['itemcondition'] == 4){ echo 'MW';}
        if($itemek['itemcondition'] == 5){ echo 'FN';}
        echo '</div><div class="upgrader-single-skin-price-container"><div class="upgrader-single-skin-price-top">';
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
        echo '<img src="'.$result2['skinimg'].'" class="upgraderskinimg-top">';
        echo '<br/><div class="upgraderskinalltext"><div class="upgraderskinsmalltext-top">';
        echo $result2['skinskin'];
        echo '</div><div class="upgraderskinbigtext-top">';
        echo $result2['skinname'];
        echo '</div></div></div></div>';
        echo '<script>$("#upgrader-chosen-left-div'.$itemek['itemid'].'").on("click", function(){
            chosen_left_skin_id = 0;
            $(".upgrader-single-skin-div").show();
            $(".upgrader-chosen-left-div").hide();
            $(".upgrader-single-skin-div").css("opacity", "1");
            $("#upgrader-chosen-left-div'.$itemek['itemid'].'").hide();
            $("#upgrader-middle").load("upgrader_middle.php?price1=".concat(chosen_left_skin_id).concat("&price2=").concat(chosen_right_skin_id));
        });</script>';
        echo '<script>$(".upgrader-chosen-left-div").hide();</script>';
    }

?>