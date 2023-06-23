<?php

    /*

    require_once 'db.php';
	require 'steamauth/steamauth.php';
	require 'steamauth/userInfo.php';

    $connection = @new mysqli($host, $db_user, $db_password, $db_name);
    mysqli_set_charset($connection, "utf8");

    $chances = [1999999, 3999999, 4999999, 5999999, 6999999, 7999999, 8999999, 9499999, 9699999, 9899999, 9949999, 9999999];
    $types = [0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1];
    $items = [0, 20, 10, 5, 2, 1, 30, 50, 80, 100, 200, 500];

    $chances2 = [1999999, 3999999, 4999999, 5999999, 6999999, 7999999, 8999999, 9499999, 9699999, 9899999, 9949999, 9999999];
    $types2 = [0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1];
    $items2 = [0, 20, 10, 5, 2, 1, 30, 50, 80, 100, 200, 500];

    function formathajsu($wartosc)
    {
        if($wartosc < 10)
        {
            echo '0,0'.$wartosc.' PLN';
        }
        else if($wartosc < 100)
        {
            echo '0,'.$wartosc.' PLN';
        }
        else
        {
            $grosze = ($wartosc%100);
            $zlote = (($wartosc - $grosze)/100);
            echo $zlote.',';
            if($grosze < 10)
            {
                echo '0'.$grosze;
            }
            else
            {
                echo $grosze;
            }
            echo ' PLN';
        }
    }

    if(ctype_alnum($_GET['z']))
    {
        $zid = $_GET['z'];
        if(isset($_SESSION['steamid']))
        {
            $uid = $_SESSION['userid'];
            if($_SESSION['gold'] >= 25)
            {
                if(isset($_SESSION['zdrapka_'.$zid]) == false)
                {
                    $_SESSION['zdrapka_'.$zid] = true;
                    $losowa = rand(0, 9999999);
                    if($_SESSION['rank'] > 6)
                    {
                        for($j=0;$j<sizeof($chances);$j++)
                        {
                            if($losowa <= $chances[$j])
                            {
                                break;
                            }
                        }
                        $type = $types[$j];
                        $item = $items[$j];
                    }
                    else
                    {
                        for($j=0;$j<sizeof($chances2);$j++)
                        {
                            if($losowa <= $chances2[$j])
                            {
                                break;
                            }
                        }
                        $type = $types2[$j];
                        $item = $items2[$j];
                    }
                    $_SESSION['gold'] = $_SESSION['gold'] - 25;
                    $gold = $_SESSION['gold'];
                    $connection->query("UPDATE users SET gold='$gold' WHERE userid='$uid'");
                    if($type == 0)
                    {
                        echo '<script>$("#zdrapka'.$zid.'").css("background", "none");</script>';
                        echo '<script>$("#zdrapkaimg'.$zid.'").attr("src", "img/redcross.png");</script>';
                    }
                    else if($type == 1)
                    {
                        echo '<script>$("#zdrapka'.$zid.'").css("background", "none");</script>';
                        ?><script>$("#zdrapka<?php echo $zid; ?>").text("<?php formathajsu($item); ?>");</script><?php
                        echo '<script>$("#zdrapka'.$zid.'").css("padding-top", "54px");</script>';
                        $_SESSION['balance'] = $_SESSION['balance'] + $item;
                        $balance = $_SESSION['balance'];
                        $connection->query("UPDATE users SET balance='$balance' WHERE userid='$uid'");
                    }
                }
                else
                {
                    echo '<div class="errordiv">Zdrapka już została zdrapana!</div>';
                    echo '<script>$(".errordiv").hide().fadeIn(400, "swing");</script>';
                    echo '<script>$(".errordiv").on("click", function(){ $(".errordiv").remove(); });</script>';
                }
            }
            else
            {
                echo '<div class="errordiv">Brak wystarczającej ilości essacoinów!</div>';
                echo '<script>$(".errordiv").hide().fadeIn(400, "swing");</script>';
                echo '<script>$(".errordiv").on("click", function(){ $(".errordiv").remove(); });</script>';
            }
        }
        else
        {
            header("Location: index.php");
        }
    }*/
?>