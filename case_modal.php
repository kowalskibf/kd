<?php

    require_once 'db.php';
	require 'steamauth/steamauth.php';
	require 'steamauth/userInfo.php';

    $connection = @new mysqli($host, $db_user, $db_password, $db_name);
    mysqli_set_charset($connection, "utf8");

    if(ctype_alnum($_GET['case']))
    {
        $casename = $_GET['case'];

        $skinid = $_SESSION['caseskinid'];
        $skincondition = $_SESSION['caseskincondition'];
        $result3 = $connection->query("SELECT * FROM skins WHERE skinid='$skinid'");
        $result3 = $result3->fetch_assoc();
        $rarity = $result3['rarity'];
        $opacity = '0.5';
        if($rarity == 1){$rarity = 'rgba(176, 195, 217, '.$opacity.')';}
        else if($rarity == 2){$rarity = 'rgba(94, 152, 217, '.$opacity.')';}
        else if($rarity == 3){$rarity = 'rgba(75, 105, 255, '.$opacity.')';}
        else if($rarity == 4){$rarity = 'rgba(136, 71, 255, '.$opacity.')';}
        else if($rarity == 5){$rarity = 'rgba(211, 44, 230, '.$opacity.')';}
        else if($rarity == 6){$rarity = 'rgba(235, 75, 75, '.$opacity.')';}
        else if($rarity == 7){$rarity = 'rgba(228, 174, 57, '.$opacity.')';}
        echo '<div id="case-modal-top" style="background: linear-gradient(rgba(16, 16, 20, 1) 0%, rgba(16, 16, 20, 1) 56%,'.$rarity.' 100%)">';
        echo '<div id="case-modal-top-img"><img src="'.$result3['skinimg'].'" class="case-modal-img"></div>';
        echo '<div id="case-modal-top-info">';
        echo '<div id="case-modal-top-skin">';
        echo $result3['skinskin'];
        echo '</div><div style="clear:both;"></div>';
        echo '<div id="case-modal-top-name">';
        echo $result3['skinname'];
        echo '</div><div style="clear:both;"></div>';
        echo '<div id="case-modal-top-condition">';
        if($_SESSION['caseskincondition'] == 1){ echo 'Battle-Scarred';}
        if($_SESSION['caseskincondition'] == 2){ echo 'Well-Worn';}
        if($_SESSION['caseskincondition'] == 3){ echo 'Field-Tested';}
        if($_SESSION['caseskincondition'] == 4){ echo 'Minimal Wear';}
        if($_SESSION['caseskincondition'] == 5){ echo 'Factory New';}
        echo '</div></div></div>';
        echo '<div id="case-modal-bottom">';
        echo '<div id="case-modal-bottom-sell" class="case-modal-bottom-div-1">';
        echo '<button id="casemodalsell" class="case-modal-bottom-button-sell">';
        echo 'SELL FOR<br/>';
        $price = $result3['skinprice'.$skincondition];
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
        echo '</button>';

        echo '</div>';
        echo '<div id="case-modal-bottom-upgrade" class="case-modal-bottom-div-2">';
        echo '<a href="upgrader"><button class="case-modal-bottom-button-upgrade">';
        echo '&nbsp &nbsp UPGRADE &nbsp &nbsp';
        echo '</button></a>';
        echo '</div>';
        echo '</div>';
        echo '<script>';
        echo '$("#casemodalsell").on("click", function(){
            $("#casemodal").hide();
            $("#rollphp3").load("case_sell.php");
            $("#rollphp4").load("refresh_case_buttons.php?case='.$casename.'");
        });';
        echo '</script>';
    }
?>