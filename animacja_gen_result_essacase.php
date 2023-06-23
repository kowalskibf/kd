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
        $casename = 'ESSACASE';
        $result = $connection->query("SELECT * FROM cases WHERE casename='$casename'");
        if($result->num_rows == 0)
        {
            header("Location: index");
        }
        $result = $result->fetch_assoc();
        $caseitems = $result['caseitems'];
        $chances1 = $result['casechances1'];
        $chances2 = $result['casechances2'];
        $chances3 = $result['casechances3'];
        $dlugosc = strlen($caseitems);
        $iloscitemkow = $dlugosc/4;
        $itemki = array();
        $stany = array();
        $szanse = array();
        $lacznie_real = 0;
        $szansa_real = '';
        $itemki_real = array();
        $stany_real = array();
        $szanse_real = array();
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
        if($_SESSION['rank'] > 6)
        {
            for($i=0;$i<$iloscitemkow;$i++)
            {
                for($j=0;$j<5;$j++)
                {
                    if(is_numeric($chances3[(35 * $i) + (7 * $j)]))
                    {
                        $itemid_real = intval($caseitems[(4 * $i)].$caseitems[(4 * $i) + 1].$caseitems[(4 * $i) + 2].$caseitems[(4 * $i) + 3]);
                        array_push($itemki_real, $itemid_real);
                        array_push($stany_real, ($j+1));
                        for($k=0;$k<7;$k++)
                        {
                            $szansa_real = $szansa_real.$chances3[(35 * $i) + (7 * $j) + $k];
                        }
                        array_push($szanse_real, $szansa_real);
                        $szansa_real = '';
                        $lacznie_real++;
                    }
                }
            }
        }
        else
        {
            for($i=0;$i<$iloscitemkow;$i++)
            {
                for($j=0;$j<5;$j++)
                {
                    if(is_numeric($chances1[(35 * $i) + (7 * $j)]))
                    {
                        $itemid_real = intval($caseitems[(4 * $i)].$caseitems[(4 * $i) + 1].$caseitems[(4 * $i) + 2].$caseitems[(4 * $i) + 3]);
                        array_push($itemki_real, $itemid_real);
                        array_push($stany_real, ($j+1));
                        for($k=0;$k<7;$k++)
                        {
                            $szansa_real = $szansa_real.$chances1[(35 * $i) + (7 * $j) + $k];
                        }
                        array_push($szanse_real, $szansa_real);
                        $szansa_real = '';
                        $lacznie_real++;
                    }
                }
            }
        }
        $chances = array();
        $totalchances = 0;
        $chances_real = array();
        $totalchances_real = 0;
        for($i=0;$i<$lacznie;$i++)
        {
            array_push($chances, ($totalchances + $szanse[$i]));
            $totalchances = $totalchances + $szanse[$i] + 1;
        }
        for($i=0;$i<$lacznie_real;$i++)
        {
            array_push($chances_real, ($totalchances_real + $szanse_real[$i]));
            $totalchances_real = $totalchances_real + $szanse_real[$i] + 1;
        }
        for($i=1;$i<=200;$i++)
        {
            $losowa = rand(0, 9999999);
            if($i == 73)
            {
                for($j=0;$j<$lacznie_real;$j++)
                {
                    if($losowa <= $chances_real[$j])
                    {
                        break;
                    }
                }
                $skinid = $itemki_real[$j];
            }
            else
            {
                for($j=0;$j<$lacznie;$j++)
                {
                    if($losowa <= $chances[$j])
                    {
                        break;
                    }
                }
                $skinid = $itemki[$j];
            }
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
            if($i == 73)
            {
                if(isset($_SESSION['steamid']))
                {
                    if($_SESSION['gold'] >= $result['caseprice'])
                    {
                        $newbalance = $_SESSION['gold'] - $result['caseprice'];
                        $_SESSION['gold'] = $newbalance;
                        if($newbalance < $result['caseprice'])
                        {
                            echo '<script>
                            $("#idopenbutton").css("display", "none");
                            $("#idopenbuttondoladuj").css("display", "block");
                            </script>';
                        }
                        $sid = $_SESSION['steamid'];
                        $connection->query("UPDATE users SET gold='$newbalance' WHERE steamid='$sid'");
                        $skinid = $result2['skinid'];
                        $skincondition = $stany_real[$j];
                        $uid = $_SESSION['userid'];
                        $connection->query("INSERT INTO items VALUES (NULL, '$skinid', '$skincondition', '$uid', 0, 1)");
                        $_SESSION['caseskinid'] = $skinid;
                        $_SESSION['caseskincondition'] = $skincondition;
                        $result3 = $connection->query("SELECT * FROM items");
                        $_SESSION['caseitemid'] = $result3->num_rows;
                    }
                }
                else
                {
                    header("Location: index");
                }
            }
        }
    }
?>