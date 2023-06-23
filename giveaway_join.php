<?php
	
	require_once 'db.php';
	require 'steamauth/steamauth.php';
	require 'steamauth/userInfo.php';
    
    $type = $_GET['type'];

    if(isset($_SESSION['steamid']))
	{
        $steamid = $_SESSION['steamid'];
        $uid = $_SESSION['userid'];
        $czas = time();
        $data = date('Y-m-d H:i:s');
        $connection = @new mysqli($host, $db_user, $db_password, $db_name);
        $result = $connection->query("SELECT * FROM giveaways WHERE giveawaytype='$type' AND giveawaytime1<'$czas' AND giveawaytime2>'$czas'");
        $ga = $result->fetch_assoc();
        $gaid = $ga['giveawayid'];
        if($type == 1 || $type == 2)
        {
            $result = $connection->query("SELECT * FROM giveawaysentries WHERE giveawayentrygiveawayid='$gaid' AND giveawayentryuserid='$uid'");
            if($result->num_rows == 0)
            {
                $connection->query("INSERT INTO giveawaysentries VALUES (NULL, '$gaid', '$uid', '$data')");
                echo '<div class="successdiv">Pomyślnie dołączyłeś do konkursu!</div>';
                echo '<script>$(".successdiv").hide().fadeIn(400, "swing");</script>';
                echo '<script>$(".successdiv").on("click", function(){ $(".successdiv").remove(); });</script>';
            }
            else
            {
                echo '<div class="errordiv">Już dołączyłeś do tego konkursu!</div>';
                echo '<script>$(".errordiv").hide().fadeIn(400, "swing");</script>';
                echo '<script>$(".errordiv").on("click", function(){ $(".errordiv").remove(); });</script>';
            }
        }
        if($type == 3)
        {
            $result = $connection->query("SELECT * FROM users WHERE userid='$uid'");
            $result = $result->fetch_assoc();
            $_SESSION['totaldepo'] = $result['totaldepo'];
            if($result['totaldepo'] >= 2000)
            {
                $result = $connection->query("SELECT * FROM giveawaysentries WHERE giveawayentrygiveawayid='$gaid' AND giveawayentryuserid='$uid'");
                if($result->num_rows == 0)
                {
                    $connection->query("INSERT INTO giveawaysentries VALUES (NULL, '$gaid', '$uid', '$data')");
                    echo '<div class="successdiv">Pomyślnie dołączyłeś do konkursu!</div>';
                    echo '<script>$(".successdiv").hide().fadeIn(400, "swing");</script>';
                    echo '<script>$(".successdiv").on("click", function(){ $(".successdiv").remove(); });</script>';
                }
                else
                {
                    echo '<div class="errordiv">Już dołączyłeś do tego konkursu!</div>';
                    echo '<script>$(".errordiv").hide().fadeIn(400, "swing");</script>';
                    echo '<script>$(".errordiv").on("click", function(){ $(".errordiv").remove(); });</script>';
                }
            }
            else
            {
                echo '<div class="errordiv">Aby móc dołączyć do tego konkursu, doładuj 20 PLN!</div>';
                echo '<script>$(".errordiv").hide().fadeIn(400, "swing");</script>';
                echo '<script>$(".errordiv").on("click", function(){ $(".errordiv").remove(); });</script>';
            }
        }
        if($type == 4)
        {
            $result = $connection->query("SELECT * FROM users WHERE userid='$uid'");
            $result = $result->fetch_assoc();
            $_SESSION['totaldepo'] = $result['totaldepo'];
            if($result['totaldepo'] >= 5000)
            {
                $result = $connection->query("SELECT * FROM giveawaysentries WHERE giveawayentrygiveawayid='$gaid' AND giveawayentryuserid='$uid'");
                if($result->num_rows == 0)
                {
                    $connection->query("INSERT INTO giveawaysentries VALUES (NULL, '$gaid', '$uid', '$data')");
                    echo '<div class="successdiv">Pomyślnie dołączyłeś do konkursu!</div>';
                    echo '<script>$(".successdiv").hide().fadeIn(400, "swing");</script>';
                    echo '<script>$(".successdiv").on("click", function(){ $(".successdiv").remove(); });</script>';
                }
                else
                {
                    echo '<div class="errordiv">Już dołączyłeś do tego konkursu!</div>';
                    echo '<script>$(".errordiv").hide().fadeIn(400, "swing");</script>';
                    echo '<script>$(".errordiv").on("click", function(){ $(".errordiv").remove(); });</script>';
                }
            }
            else
            {
                echo '<div class="errordiv">Aby móc dołączyć do tego konkursu, doładuj 50 PLN!</div>';
                echo '<script>$(".errordiv").hide().fadeIn(400, "swing");</script>';
                echo '<script>$(".errordiv").on("click", function(){ $(".errordiv").remove(); });</script>';
            }
        }
    }

?>