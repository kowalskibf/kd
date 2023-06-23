<?php

    require_once 'db.php';
	require 'steamauth/steamauth.php';
	require 'steamauth/userInfo.php';

    $connection = @new mysqli($host, $db_user, $db_password, $db_name);
    mysqli_set_charset($connection, "utf8");

    if(ctype_alnum($_GET['itemid']))
    {
        $itemid = $_GET['itemid'];
        $result1 = $connection->query("SELECT * FROM items WHERE itemid='$itemid'");
        $result1 = $result1->fetch_assoc();
        if($_SESSION['userid'] == $result1['itemuserid'])
        {
            if($result1['itemstatus'] == 1)
            {
                $uid = $_SESSION['userid'];
                $connection->query("UPDATE items SET itemstatus=0 WHERE itemid='$itemid'");
                $skinid = $result1['itemskinid'];
                $result2 = $connection->query("SELECT * FROM skins WHERE skinid='$skinid'");
                $result2 = $result2->fetch_assoc();
                $price = $result2['skinprice'.$result1['itemcondition']];
                $_SESSION['balance'] = $_SESSION['balance'] + $price;
                $newbalance = $_SESSION['balance'];
                $connection->query("UPDATE users SET balance='$newbalance' WHERE userid='$uid'");
                echo '<script>$("#profileselldiv'.$itemid.'").remove();</script>';
            }
        }
    }

?>    