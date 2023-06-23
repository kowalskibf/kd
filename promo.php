<script src="//ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="js/jq.js"></script>

<?php

    require_once 'db.php';
	require 'steamauth/steamauth.php';
	require 'steamauth/userInfo.php';

    $connection = @new mysqli($host, $db_user, $db_password, $db_name);
    mysqli_set_charset($connection, "utf8");

    if(isset($_SESSION['steamid']))
    {
        if(isset($_POST['ref1input']))
        {
            if($_SESSION['referraluserid'] == 0)
            {
                $ref1 = $_POST['ref1input'];
                if((ctype_alnum($ref1) == true) && (strlen($ref1) >= 3) && (strlen($ref1) <= 16))
                {
                    $uid = $_SESSION['userid'];
                    $ref1 = htmlentities($ref1, ENT_QUOTES, "UTF-8");
                    $ref1 = strtoupper($ref1);
                    $refuser = $connection->query("SELECT * FROM users WHERE refcode='$ref1'");
                    if($refuser->num_rows == 1)
                    {
                        $refuser = $refuser->fetch_assoc();
                        if($refuser['userid'] == $uid)
                        {
                            echo '<script>$(".errordiv").remove();</script>';
                            echo '<script>$(".successdiv").remove();</script>';
                            echo '<div class="errordiv">Nie możesz skorzystać ze swojego kodu!</div>';
                            echo '<script>$(".errordiv").on("click", function(){
                                $(".errordiv").remove();
                            });</script>';
                        }
                        else
                        {
                            $refuser_res = $refuser;
                            $refuser = $refuser['userid'];
                            $connection->query(sprintf(
                                "UPDATE users SET referraluserid='%s' WHERE userid='%s'",
                                mysqli_real_escape_string($connection, $refuser),
                                mysqli_real_escape_string($connection, $uid)
                            ));
                            $ref_ec_bal = $refuser_res['gold'];
                            $ref_ec_bal = $ref_ec_bal + 25;
                            $refecbal = $ref_ec_bal;
                            $connection->query("UPDATE users SET gold='$refecbal' WHERE userid='$refuser'");
                            $_SESSION['referraluserid'] = $refuser;
                            $_SESSION['ref1success'] = $ref1;
                            $_SESSION['balance'] = $_SESSION['balance'] + 250;
                            $newbalance = $_SESSION['balance'];
                            $connection->query("UPDATE users SET balance='$newbalance' WHERE userid='$uid'");
                            header("Location: promo");
                            exit(0);
                        }
                    }
                    else if($refuser->num_rows == 0)
                    {
                        echo '<script>$(".errordiv").remove();</script>';
                        echo '<script>$(".successdiv").remove();</script>';
                        echo '<div class="errordiv">Nie ma takiego kodu!</div>';
                        echo '<script>$(".errordiv").on("click", function(){
                            $(".errordiv").remove();
                        });</script>';
                    }
                }
                else
                {
                    echo '<script>$(".errordiv").remove();</script>';
                    echo '<script>$(".successdiv").remove();</script>';
                    echo '<div class="errordiv">Nieprawidłowy format kodu!</div>';
                    echo '<script>$(".errordiv").on("click", function(){
                        $(".errordiv").remove();
                    });</script>';
                }
            }
            else
            {
                echo '<script>$(".errordiv").remove();</script>';
                echo '<script>$(".successdiv").remove();</script>';
                echo '<div class="errordiv">Użyto już kod znajomego!</div>';
                echo '<script>$(".errordiv").on("click", function(){
                    $(".errordiv").remove();
                });</script>';

            }
        }
        if(isset($_POST['ref2input']))
        {
            $ref2 = $_POST['ref2input'];
            if((ctype_alnum($ref2) == true) && (strlen($ref2) >= 3) && (strlen($ref2) <= 16))
            {
                $uid = $_SESSION['userid'];
                $ref2 = htmlentities($ref2, ENT_QUOTES, "UTF-8");
                $ref2 = strtoupper($ref2);
                $ref2_res = $connection->query("SELECT * FROM vouchers WHERE vouchercode='$ref2'");
                if($ref2_res->num_rows == 1)
                {
                    $czas = time();
                    $ref2_res = $ref2_res->fetch_assoc();
                    if(($ref2_res['voucherstatus'] == 1) && (strtotime($ref2_res['voucherdate1']) < $czas) && (strtotime($ref2_res['voucherdate2']) > $czas))
                    {
                        if($ref2_res['vouchertype'] == 997)
                        {
                            if($ref2_res['voucheritemtype'] == 1)
                            {
                                $uid = $_SESSION['userid'];
                                $_SESSION['balance'] = $_SESSION['balance'] + $ref2_res['voucheritemamount'];
                                $hajs = $_SESSION['balance'];
                                $connection->query("UPDATE users SET balance='$hajs' WHERE userid='$uid'");
                                $_SESSION['ref1success'] = $ref2;
                                header("Location: promo");
                                exit(0);
                            }
                        }
                    }
                    else
                    {
                        echo '<script>$(".errordiv").remove();</script>';
                        echo '<script>$(".successdiv").remove();</script>';
                        echo '<div class="errordiv">Niepoprawny kod!</div>';
                        echo '<script>$(".errordiv").on("click", function(){
                            $(".errordiv").remove();
                        });</script>';
                    }
                }
                else
                {
                    echo '<script>$(".errordiv").remove();</script>';
                    echo '<script>$(".successdiv").remove();</script>';
                    echo '<div class="errordiv">Niepoprawny kod!</div>';
                    echo '<script>$(".errordiv").on("click", function(){
                        $(".errordiv").remove();
                    });</script>';
                }
            }
            else
            {
                echo '<script>$(".errordiv").remove();</script>';
                echo '<script>$(".successdiv").remove();</script>';
                echo '<div class="errordiv">Nieprawidłowy format kodu!</div>';
                echo '<script>$(".errordiv").on("click", function(){
                    $(".errordiv").remove();
                });</script>';
            }
        }
        if(isset($_SESSION['ref1success']))
        {
            echo '<script>$(".errordiv").remove();</script>';
            echo '<script>$(".successdiv").remove();</script>';
            echo '<div class="successdiv">Użyto kodu '.$_SESSION['ref1success'].'!</div>';
            echo '<script>$(".successdiv").on("click", function(){
                $(".successdiv").remove();
            });</script>';
            unset($_SESSION['ref1success']);
        }
    }

?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Kod Promocyjny - Otwieraj skrzynki CS:GO</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="X-Ua-Compatible" content="IE=edge">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">
        <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
        <link rel="icon" href="img/icon.png">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="js/jq.js"></script>
		<script>
			$(function(){
				$("#headers").load("site_headers.php");
				$("#footer").load("site_footer.php");
				$("#headerdesktopbalance").load("refresh_balance.php");
				$("#header-mobile-modal-user-balance").load("refresh_balance_2.php");
				$("#header-desktop-gold-refresh").load("refresh_gold.php");
				$("#header-mobile-modal-user-gold").load("refresh_gold_2.php");
				setInterval(() => {
					$("#headerdesktopbalance").load("refresh_balance.php");
					$("#header-mobile-modal-user-balance").load("refresh_balance_2.php");
					$("#header-desktop-gold-refresh").load("refresh_gold.php");
					$("#header-mobile-modal-user-gold").load("refresh_gold_2.php");
				}, 200);
			});
		</script>
    </head>
    <body>
        <div id="all">
			<div id="headers"></div>
			<div id="main" style="color:white;text-align:center;margin:auto;font-family:Cairobold,sans-serif;">
                <div id="profiletop">
                    <div id="caseinfo-left">
                        <a href="index">
                            <img src="img/return.png" height=24 width=24 style="margin-right:-12px;">
                            <span class="modal-link-text">STRONA GŁÓWNA</span>
                        </a>
                    </div>
                    <div id="caseinfo-middle">
                        <span class="caseinfo-middle-casename">KOD PROMOCYJNY</span>
                    </div>
                    <div id="caseinfo-right">
                        <a href="affiliate">
                            <span class="modal-link-text">PROGRAM PARTNERSKI</span>
                            <img src="img/affiliate.png" height=24 width=24 style="margin-left:-12px;">
                        </a>
                    </div>
                </div>
                <div id="promo-main">
                    <div class="promo-main-half">
                        <form method="post">
                            <div style="margin-bottom:8px;">KOD POLECAJĄCY ZNAJOMEGO</div>
                            <input id="ref-1-button" name="ref1input" type="text" placeholder="
                            <?php
                                if($_SESSION['referraluserid'] == 0)
                                {
                                    echo 'WPISZ KOD ZNAJOMEGO';
                                }
                                else
                                {
                                    $ref1 = $_SESSION['referraluserid'];
                                    $ref1result = $connection->query("SELECT * FROM users WHERE userid='$ref1'");
                                    $ref1result = $ref1result->fetch_assoc();
                                    echo $ref1result['refcode'];
                                }
                            ?>
                            ">
                            <button class="promo-main-half-button" type="submit">UŻYJ</button>
                        </form>
                        <a href="affiliate">
                            <button class="promo-own-code-button">STWÓRZ SWÓJ WŁASNY KOD I ZARABIAJ Z NAMI!</button>
                        </a>
                    </div>
                    <div class="promo-main-half">
                        <form method="post">
                            <div style="margin-bottom:8px;">KOD PROMOCYJNY</div>
                            <input id="ref-2-button" name="ref2input" type="text" placeholder="WPISZ KOD PROMOCYJNY">
                            <button class="promo-main-half-button" type="submit">UŻYJ</button>
                        </form>
                        <button class="promo-own-code-button">KODY PROMOCYJNE SĄ DOSTĘPNE OKAZYJNIE!</button>
                    </div>
                </div>
            </div>
			<div id="footer"></div>
		</div>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>

<?php

    if(isset($_SESSION['userid']) == false)
    {
        ?>
        <script>
            $(function(){
                $("#main").load("login_first.php");
            });
        </script>
        <?php
    }

?>