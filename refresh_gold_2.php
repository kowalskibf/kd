<?php
	
	require_once 'db.php';
	require 'steamauth/steamauth.php';
	require 'steamauth/userInfo.php';

    if(isset($_SESSION['steamid']))
	{
        $steamid = $_SESSION['steamid'];
        $connection = @new mysqli($host, $db_user, $db_password, $db_name);
        $result = $connection->query("SELECT gold FROM users WHERE steamid='$steamid'");
        $result = $result->fetch_assoc();
        $_SESSION['gold'] = $result['gold'];
        $gold = $result['gold'];
        echo '<span class="balance-gold-2">';
        echo $gold;
        echo '</span> ';
        echo '<img src="img/essacoin.png" width=10 height=10>';
    }

?>