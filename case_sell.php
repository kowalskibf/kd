<?php

    require_once 'db.php';
	require 'steamauth/steamauth.php';
	require 'steamauth/userInfo.php';

    $connection = @new mysqli($host, $db_user, $db_password, $db_name);
    mysqli_set_charset($connection, "utf8");

    $itemid = $_SESSION['caseitemid'];
    $result_case_sell = $connection->query("SELECT * FROM items WHERE itemid='$itemid'");
    $result_case_sell = $result_case_sell->fetch_assoc();
    if($result_case_sell['itemstatus'] == 1)
    {
        $connection->query("UPDATE items SET itemstatus=0 WHERE itemid='$itemid'");
        $itemskinid = $result_case_sell['itemskinid'];
        $itemcondition = $result_case_sell['itemcondition'];
        $result_case_sell2 = $connection->query("SELECT * FROM skins WHERE skinid='$itemskinid'");
        $result_case_sell2 = $result_case_sell2->fetch_assoc();
        $price = $result_case_sell2['skinprice'.$itemcondition];
        $_SESSION['balance'] = $_SESSION['balance'] + $price;
        $newbalance = $_SESSION['balance'];
        $sid = $_SESSION['steamid'];
        $connection->query("UPDATE users SET balance='$newbalance' WHERE steamid='$sid'");
    }

?>