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

    if(isset($_SESSION['userid']))
    {
        $skinid = $_GET['skinid'];
        if($skinid != 0)
        {
            $cond = $_GET['cond'];
            $uid = $_SESSION['userid'];
            $sid = $_SESSION['steamid'];
            $price_result = $connection->query("SELECT * FROM skins WHERE skinid='$skinid'");
            $price_result = $price_result->fetch_assoc();
            $price = floor($price_result['skinprice'.$cond] * 0.94);
            $godzina = date('Y-m-d H:i:s');
            $validate_result = $connection->query("SELECT * FROM deposits WHERE deposituserid='$uid' AND depositmethod=1 AND depositstatus<99 AND depositstatus>0");
            $tradeurl_result = $connection->query("SELECT * FROM users WHERE userid='$uid'");
            $tradeurl_result = $tradeurl_result->fetch_assoc();
            $tradeurl_result = $tradeurl_result['steamtradeurl'];
            if($validate_result->num_rows == 0)
            {
                if((strlen($_SESSION['steamtradeurl']) > 65) && (strlen($_SESSION['steamtradeurl']) < 80))
                {
                    $connection->query("INSERT INTO deposits VALUES (NULL, '$uid', '$price', 1, '$godzina', '', 1, '$skinid', '$cond', '', '')");
                    echo '<script>
                        setTimeout(function(){
                            window.location.reload(1);
                        }, 1000);
                     </script>';
                }
                else
                {
                    echo '<div class="errordiv">Nieprawidłowy TradeURL!</div>';
                    echo '<script>$(".errordiv").hide().fadeIn(400, "swing");</script>';
                    echo '<script>$(".errordiv").on("click", function(){ $(".errordiv").remove(); });</script>';
                }
            }
            else
            {
                echo '<div class="errordiv">Proces doładowania już został rozpoczęty, odśwież stronę!</div>';
                echo '<script>$(".errordiv").hide().fadeIn(400, "swing");</script>';
                echo '<script>$(".errordiv").on("click", function(){ $(".errordiv").remove(); });</script>';
            }
        }
    }

?>
