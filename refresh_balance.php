<?php
	
	require_once 'db.php';
	require 'steamauth/steamauth.php';
	require 'steamauth/userInfo.php';

    if(isset($_SESSION['steamid']))
	{
        $steamid = $_SESSION['steamid'];
        $connection = @new mysqli($host, $db_user, $db_password, $db_name);
        $result = $connection->query("SELECT balance FROM users WHERE steamid='$steamid'");
        $result = $result->fetch_assoc();
		$_SESSION['balance'] = $result['balance'];
        $balance = $result['balance'];
		$grosze = $balance % 100;
		$zlote = ($balance - $grosze) / 100;
        echo '<span class="balance">';
		if($grosze == 0)
		{
			echo $zlote.",00 PLN";
		}
		else if($grosze < 10)
		{
			echo $zlote.",0".$grosze." PLN";
		}
		else
		{
			echo $zlote.",".$grosze." PLN";
		}
        echo '</span>';
    }

?>