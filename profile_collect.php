<?php

    require_once 'db.php';
	require 'steamauth/steamauth.php';
	require 'steamauth/userInfo.php';

    $connection = @new mysqli($host, $db_user, $db_password, $db_name);
    mysqli_set_charset($connection, "utf8");

    if(ctype_alnum($_GET['itemid']))
    {
        $itemid = $_GET['itemid'];
        $uid = $_SESSION['userid'];
        $result1 = $connection->query("SELECT * FROM items WHERE itemid='$itemid'");
        $result1 = $result1->fetch_assoc();
        $result2 = $connection->query("SELECT * FROM users WHERE userid='$uid'");
        $result2 = $result2->fetch_assoc();
        $_SESSION['totaldepo'] = $result2['totaldepo'];
        if((strlen($_SESSION['steamtradeurl']) > 65) && (strlen($_SESSION['steamtradeurl']) < 80))
        {
            if($_SESSION['userid'] == $result1['itemuserid'])
            {
                if($result1['itemstatus'] == 1)
                {
                    if($_SESSION['totaldepo'] >= 1000)
                    {
                        $skinid = $result1['itemskinid'];
                        $result3 = $connection->query("SELECT * FROM skins WHERE skinid='$skinid'");
                        $result3 = $result3->fetch_assoc();
                        if($result3['skinstock'.$result1['itemcondition']] > 0)
                        {
                            $ip_res = $connection->query("SELECT * FROM users WHERE userid='$uid'");
                            $ip_res = $ip_res->fetch_assoc();
                            $_SESSION['ip'] = $ip_res['ip'];
                            $_SESSION['ban'] = $ip_res['ban'];
                            if($_SESSION['ip'] == 0 && $_SESSION['ban'] == 0)
                            {
                                $date = date('Y-m-d H:i:s');
                                $connection->query("UPDATE items SET itemstatus=0 WHERE itemid='$itemid'");
                                $connection->query("INSERT INTO withdraws VALUES (NULL, '$uid', '$itemid', '$date', '', 1)");
                                echo '<script>$("#profileselldiv'.$itemid.'").remove();</script>';
                                echo '<div class="successdiv">Status wypłaty możesz znaleźć w zakładce WYPŁATY!</div>';
                                echo '<script>$(".successdiv").hide().fadeIn(400, "swing");</script>';
                                echo '<script>$(".successdiv").on("click", function(){ $(".successdiv").remove(); });</script>';
                            }
                            else
                            {
                                echo '<div class="errordiv">Błąd wypłaty! Skontaktuj się z Supportem!</div>';
                                echo '<script>$(".errordiv").hide().fadeIn(400, "swing");</script>';
                                echo '<script>$(".errordiv").on("click", function(){ $(".errordiv").remove(); });</script>';
                            }
                        }
                        else
                        {
                            echo '<div class="errordiv">Chwilowy brak skina w magazynie! Skontaktuj się z Supportem lub otwórz innego skina!</div>';
                            echo '<script>$(".errordiv").hide().fadeIn(400, "swing");</script>';
                            echo '<script>$(".errordiv").on("click", function(){ $(".errordiv").remove(); });</script>';
                        }
                    }
                    else
                    {
                        echo '<div class="errordiv">Aby móc wypłacać, doładuj 10 PLN!</div>';
                        echo '<script>$(".errordiv").hide().fadeIn(400, "swing");</script>';
                        echo '<script>$(".errordiv").on("click", function(){ $(".errordiv").remove(); });</script>';
                    }
                }
            }
        }
        else
        {
            echo '<div class="errordiv">Nieprawidłowy TRADE-URL!</div>';
            echo '<script>$(".errordiv").hide().fadeIn(400, "swing");</script>';
            echo '<script>$(".errordiv").on("click", function(){ $(".errordiv").remove(); });</script>';
        }
    }

?>    