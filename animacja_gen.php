<?php

    require_once 'db.php';
	require 'steamauth/steamauth.php';
	require 'steamauth/userInfo.php';

    $connection = @new mysqli($host, $db_user, $db_password, $db_name);
    mysqli_set_charset($connection, "utf8");

    $lacznie = 0;
    $szansa = '';
    if(ctype_alnum($_GET['case']))
    {
        $casename = $_GET['case'];
        $result = $connection->query("SELECT * FROM cases WHERE casename='$casename'");
        $result = $result->fetch_assoc();
        $caseitems = $result['caseitems'];
        $chances2 = $result['casechances2'];
        $dlugosc = strlen($caseitems);
        $iloscitemkow = $dlugosc/4;
        $itemki = array();
        $stany = array();
        $szanse = array();
        for($i=0;$i<$iloscitemkow;$i++)
        {
            for($j=0;$j<5;$j++)
            {
                if(is_numeric($chances2[(35 * $i) + (7 * $j)]))
                {
                    $itemid = intval($caseitems[(4 * $i)].$caseitems[(4 * $i) + 1].$caseitems[(4 * $i) + 2].$caseitems[(4 * $i) + 3]);
                    array_push($itemki, $itemid);
                    array_push($stany, ($j+1));
                    for($k=0;$k<7;$k++)
                    {
                        $szansa = $szansa.$chances2[(35 * $i) + (7 * $j) + $k];
                    }
                    array_push($szanse, $szansa);
                    $szansa = '';
                    $lacznie++;
                }
            }
        }
        $chances = array();
        $totalchances = 0;
        for($i=0;$i<$lacznie;$i++)
        {
            array_push($chances, ($totalchances + $szanse[$i]));
            $totalchances = $totalchances + $szanse[$i] + 1;
        }
        for($i=1;$i<=80;$i++)
        {
            $losowa = rand(0, 9999999);
            for($j=0;$j<$lacznie;$j++)
            {
                if($losowa <= $chances[$j])
                {
                    break;
                }
            }
            $skinid = $itemki[$j];
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