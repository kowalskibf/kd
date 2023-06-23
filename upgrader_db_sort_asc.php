<?php

    require_once 'db.php';
	require 'steamauth/steamauth.php';
	require 'steamauth/userInfo.php';

    $connection = @new mysqli($host, $db_user, $db_password, $db_name);
    mysqli_set_charset($connection, "utf8");

    error_reporting(E_ERROR | E_PARSE);

    if(isset($_SESSION['steamid']))
    {
        if($_SESSION['rank'] > 1000)
        {
            $uid = $_SESSION['userid'];

            $qqq = "SELECT * FROM skins";
            $result = $connection->query($qqq);
            $itemki = array();
            $items_ids = array();
            $items_conditions = array();
            $items_prices = array();
            $items_ilosc = 0;
            $ilosc_itemkow = 0;
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
                            array_push($items_ids, $itemek['skinid']);
                            array_push($items_conditions, $i);
                            array_push($items_prices, $itemek['skinprice'.$i]);
                            $items_ilosc++;
                            $ilosc_itemkow++;
                        }
                    }
                }
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
                    }
                }
            }
            $connection->query("TRUNCATE eff_upgrader_right_asc");
            for($i=0;$i<$items_ilosc;$i++)
            {
                $itemid = $items_ids[$i];
                $result2 = $connection->query("SELECT * FROM skins WHERE skinid='$itemid'");
                $result2 = $result2->fetch_assoc();
                $skinid = $itemid;
                $skinname = $result2['skinname'];
                $skinskin = $result2['skinskin'];
                $rarity = $result2['rarity'];
                $skinimg = $result2['skinimg'];
                $skincond = $items_conditions[$i];
                $skinprice = $items_prices[$i];
                $connection->query("INSERT INTO eff_upgrader_right_asc VALUES (NULL, '$itemid', '$skinname', '$skinskin', '$rarity', '$skinimg', '$skincond', '$skinprice')");
            }
        }
        else
        {
            header("Location: index");
        }
    }
    else
    {
        header("Location: index");
    }
?>