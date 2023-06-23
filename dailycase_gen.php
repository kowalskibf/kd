<?php

    require_once 'db.php';
	require 'steamauth/steamauth.php';
	require 'steamauth/userInfo.php';

    $connection = @new mysqli($host, $db_user, $db_password, $db_name);
    mysqli_set_charset($connection, "utf8");
    
    $chances_shown = [99999, 199999, 299999, 399999, 499999, 599999, 699999, 799999, 899999, 999999, 1299999, 1599999, 1899999, 2199999, 2499999, 2799999, 3099999, 3399999, 3699999, 3999999, 4299999, 4599999, 4899999, 5199999, 5499999, 5799999, 6099999, 6399999, 6699999, 6999999, 7299999, 7599999, 7899999, 8199999, 8499999, 8799999, 9099999, 9399999, 9699999, 9999999];
    $item_types_shown = [3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2];
    $itemki_shown = [1096, 1205, 1224, 378, 318, 527, 487, 274, 122, 31, 10000, 5000, 2000, 1000, 500, 300, 200, 100, 80, 50, 20, 10, 5, 2, 1, 10000, 5000, 2000, 1000, 500, 300, 200, 100, 80, 50, 20, 10, 5, 2, 1];

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

    for($i=1;$i<=200;$i++)
    {
        $losowa = rand(0, 9999999);
        for($j=0;$j<sizeof($chances_shown);$j++)
        {
            if($losowa <= $chances_shown[$j])
            {
                break;
            }
        }
        if($item_types_shown[$j] == 1)
        {
            $img = 'img/cash.png';
            $opacity = '0.5';
            $rarity = 'rgba(133, 187, 101, '.$opacity.')';
            echo '<script>$("#imgslide'.$i.'").attr("src", "'.$img.'");</script>';
            echo '<script>$("#slide'.$i.'").css("background", "linear-gradient(rgba(16, 16, 20, 1) 0%, rgba(16, 16, 20, 1) 70%,'.$rarity.' 100%)");</script>';
            echo '<script>$("#slideskin'.$i.'").text("PLN");</script>';
            echo '<script>$("#slideweapon'.$i.'").text("'.formathajsudailycase($itemki_shown[$j]).'");</script>';
        }
        else if($item_types_shown[$j] == 2)
        {
           $img = 'img/essacoinsbag.png';
            $opacity = '0.5';
            $rarity = 'rgba(255, 215, 0, '.$opacity.')';
            echo '<script>$("#imgslide'.$i.'").attr("src", "'.$img.'");</script>';
            echo '<script>$("#slide'.$i.'").css("background", "linear-gradient(rgba(16, 16, 20, 1) 0%, rgba(16, 16, 20, 1) 70%,'.$rarity.' 100%)");</script>';
            echo '<script>$("#slideskin'.$i.'").text("ESSACOINS");</script>';
            echo '<script>$("#slideweapon'.$i.'").text("'.$itemki_shown[$j].'");</script>';
        }
        else if($item_types_shown[$j] == 3)
        {
            $skinid = $itemki_shown[$j];
            $result2 = $connection->query("SELECT * FROM skins WHERE skinid='$skinid'");
            $result2 = $result2->fetch_assoc();
            $img = $result2['skinimg'];
            $rarity = $result2['rarity'];
            $opacity = '0.5';
            if($rarity == 1){$rarity = 'rgba(176, 195, 217, '.$opacity.')';}
            else if($rarity == 2){$rarity = 'rgba(94, 152, 217, '.$opacity.')';}
            else if($rarity == 3){$rarity = 'rgba(75, 105, 255, '.$opacity.')';}
            else if($rarity == 4){$rarity = 'rgba(136, 71, 255, '.$opacity.')';}
            else if($rarity == 5){$rarity = 'rgba(211, 44, 230, '.$opacity.')';}
            else if($rarity == 6){$rarity = 'rgba(235, 75, 75, '.$opacity.')';}
            else if($rarity == 7){$rarity = 'rgba(228, 174, 57, '.$opacity.')';}
            echo '<script>$("#imgslide'.$i.'").attr("src", "'.$img.'");</script>';
            echo '<script>$("#slide'.$i.'").css("background", "linear-gradient(rgba(16, 16, 20, 1) 0%, rgba(16, 16, 20, 1) 70%,'.$rarity.' 100%)");</script>';
            echo '<script>$("#slideskin'.$i.'").text("'.$result2['skinskin'].'");</script>';
            echo '<script>$("#slideweapon'.$i.'").text("'.$result2['skinname'].'");</script>';
        }
    }
    
?>