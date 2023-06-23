<?php

    require_once 'db.php';
	require 'steamauth/steamauth.php';
	require 'steamauth/userInfo.php';

    $connection = @new mysqli($host, $db_user, $db_password, $db_name);
    mysqli_set_charset($connection, "utf8");

    if(isset($_SESSION['userid']) == false)
    {
        header("Location: index");
    }

    $id = $_GET['id'];

    $result = $connection->query("SELECT * FROM deposits WHERE depositid='$id'");
    $result = $result->fetch_assoc();
    if(isset($_SESSION['userid']))
    {
        if($_SESSION['userid'] == $result['deposituserid'])
        {
            if($result['depositstatus'] == 1 || $result['depositstatus'] == 31 || $result['depositstatus'] == 32 || $result['depositstatus'] == 33 || $result['depositstatus'] == 34 || $result['depositstatus'] == 35 || $result['depositstatus'] == 36 || $result['depositstatus'] == 37)
            {
                $connection->query("UPDATE deposits SET depositstatus=0 WHERE depositid='$id'");
            }
        }
    }

?>
