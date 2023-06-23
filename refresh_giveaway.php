<?php
	
	require_once 'db.php';
	require 'steamauth/steamauth.php';
	require 'steamauth/userInfo.php';

    $type = $_GET['type'];
    $connection = @new mysqli($host, $db_user, $db_password, $db_name);
    $czas = time();
    $result = $connection->query("SELECT * FROM giveaways WHERE giveawaytime1<'$czas' AND giveawaytime2>'$czas' AND giveawaytype='$type'");
    $result = $result->fetch_assoc();
    $skinid = $result['giveawayskin'];
    $skincond = $result['giveawaycondition'];
    $result2 = $connection->query("SELECT * FROM skins WHERE skinid='$skinid'");
    $result2 = $result2->fetch_assoc();
    echo '<div class="single-giveaway-left">';
        echo '<img src="'.$result2['skinimg'].'" class="giveaway-img">';
    echo '</div>';
    echo '<div class="single-giveaway-right">';
        echo '<div class="giveaway-margin-top-8-procent"></div>';
        if($type == 1){echo '<span style="color:#4BE4B6;">6-GODZINNY GIVEAWAY</span>';}
        if($type == 2){echo '<span style="color:#A020F0;">DZIENNY GIVEAWAY</span>';}
        if($type == 3){echo '<span style="color:#F53F59;">TYGODNIOWY GIVEAWAY</span>';}
        if($type == 4){echo '<span style="color:#dcae64;">MIESIĘCZNY GIVEAWAY</span>';}
        echo '<br/>'.$result2['skinname'].' | '.$result2['skinskin'];
        echo '<br/><span style="color:#aaaaaa;">Kliknij, aby dołączyć</span>';
        echo '<br/><span style="color:#aaaaaa;">Koniec za </span>';
        $czas = $result['giveawaytime2'] - time();
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
    echo '</div>';


?>