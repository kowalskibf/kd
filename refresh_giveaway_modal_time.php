<?php
	
	require_once 'db.php';
	require 'steamauth/steamauth.php';
	require 'steamauth/userInfo.php';

    $type = $_GET['type'];
    $czas = time();
    $connection = @new mysqli($host, $db_user, $db_password, $db_name);
    $ga = $connection->query("SELECT * FROM giveaways WHERE giveawaytime1<'$czas' AND giveawaytime2>'$czas' AND giveawaytype='$type'");
    $ga = $ga->fetch_assoc();
    $czas = $ga['giveawaytime2'] - time();
    $sekundy = $czas % 60;
    $czas = $czas - $sekundy;
    $minuty = floor(($czas % 3600) / 60);
    $czas = $czas - $minuty;
    if($type == 1 || $type == 2)
    {
        $godziny = floor($czas / 3600);
    }
    if($type == 3 || $type == 4)
    {
        $godziny = floor(($czas % 86400) / 3600);
        $czas = $czas - $godziny;
        $dni = floor($czas / 86400);
        echo $dni.' dni ';
    }
    echo $godziny.' godz. '.$minuty.' min '.$sekundy.' sek. ';

?>