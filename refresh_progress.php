<?php
	
	require_once 'db.php';
	require 'steamauth/steamauth.php';
	require 'steamauth/userInfo.php';

    if(isset($_SESSION['steamid']))
	{
        $steamid = $_SESSION['steamid'];
        $connection = @new mysqli($host, $db_user, $db_password, $db_name);
        $result = $connection->query("SELECT progress FROM users WHERE steamid='$steamid'");
        $result = $result->fetch_assoc();
        $_SESSION['progress'] = $result['progress'];
        echo $_SESSION['progress'];
    }

?>