<?php

    require_once 'db.php';
	require 'steamauth/steamauth.php';
	require 'steamauth/userInfo.php';

    $connection = @new mysqli($host, $db_user, $db_password, $db_name);
    mysqli_set_charset($connection, "utf8");

    if(isset($_SESSION['steamid']))
    {
        function formathajsudailycase($wartosc)
        {
            if($wartosc < 10)
            {
                return '0,0'.$wartosc;
            }
            else if($wartosc < 100)
            {
                return '0,'.$wartosc;
            }
            else
            {
                $grosze = ($wartosc%100);
                $zlote = (($wartosc - $grosze)/100);
                $wynik = $zlote.',';
                if($grosze < 10)
                {
                    $wynik = $wynik.'0'.$grosze;
                }
                else
                {
                    $wynik = $wynik.$grosze;
                }
                return $wynik;
            }
        }
        $itemtype = $_SESSION['daily_case_drawn_item_type'];
        $itemvalue = $_SESSION['daily_case_drawn_item_value'];
        $opacity = '0.5';
        if($itemtype == 1)
        {
            $rarity = 'rgba(133, 187, 101, '.$opacity.')';
        }
        else if($itemtype == 2)
        {
            $rarity = 'rgba(255, 215, 0, '.$opacity.')';
        }
        echo '<div id="case-modal-top" style="background: linear-gradient(rgba(16, 16, 20, 1) 0%, rgba(16, 16, 20, 1) 56%,'.$rarity.' 100%);">';
        echo '<div id="case-modal-top-img"><img src="';
        if($itemtype == 1){echo 'img/cash.png';}else if($itemtype == 2){echo 'img/essacoinsbag.png';}
        echo '" class="case-modal-img" style="margin-top:8px;"></div>';
        echo '<div id="case-modal-top-info">';
        echo '<div id="case-modal-top-skin">';
        if($itemtype == 1){echo 'PLN';}else if($itemtype == 2){echo 'ESSACOINS';}
        echo '</div><div style="clear:both;"></div>';
        echo '<div id="case-modal-top-name" style="margin-bottom:-8px;">';
        if($itemtype == 1){echo formathajsudailycase($itemvalue);}else if($itemtype == 2){echo $itemvalue;}
        echo '</div></div></div>';
        echo '<div class="dailycase-modal-div">';
        if($itemtype == 1){echo '<a href="index">';}else if($itemtype == 2){echo '<a href="essazone">';}
        if($itemtype == 1){echo '<button class="dailycase-modal-button">';}else if($itemtype == 2){echo '<button class="dailycase-modal-button">';}
        if($itemtype == 1){echo 'OPEN CASES';}else if($itemtype == 2){echo 'SPEND ESSACOINS';}
        echo '</button>';
        echo '</a></div>';
    }
?>