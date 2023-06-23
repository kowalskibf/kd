<script src="//ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="js/jq.js"></script>

<?php

    require_once 'db.php';
	require 'steamauth/steamauth.php';
	require 'steamauth/userInfo.php';

    $connection = @new mysqli($host, $db_user, $db_password, $db_name);
    mysqli_set_charset($connection, "utf8");

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

    function formathajsu2($wartosc)
    {
        if($wartosc < 10)
        {
            echo '0,0'.$wartosc;
        }
        else if($wartosc < 100)
        {
            echo '0,'.$wartosc;
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
        }
    }

    if(isset($_SESSION['steamid']))
    {
        if(isset($_POST['affiliatecode']))
        {
            $code = $_POST['affiliatecode'];
            if((ctype_alnum($code) == true) && (strlen($code) >= 3) && (strlen($code) <= 16))
            {
                $uid = $_SESSION['userid'];
                $code = htmlentities($code, ENT_QUOTES, "UTF-8");
                $code = strtoupper($code);
                $affiliateresult = $connection->query("SELECT * FROM users WHERE userid='$uid'");
                $affiliateresult = $affiliateresult->fetch_assoc();
                if(strlen($affiliateresult['refcode']) >= 3)
                {
                    echo '<script>$(".errordiv").remove();</script>';
                    echo '<script>$(".successdiv").remove();</script>';
                    echo '<div class="errordiv">Już posiadasz swój kod!</div>';
                    echo '<script>$(".errordiv").on("click", function(){
                        $(".errordiv").remove();
                    });</script>';
                }
                else
                {
                    $affiliateresult2 = $connection->query("SELECT * FROM users WHERE refcode='$code'");
                    if($affiliateresult2->num_rows != 0)
                    {
                        echo '<script>$(".errordiv").remove();</script>';
                        echo '<script>$(".successdiv").remove();</script>';
                        echo '<div class="errordiv">Kod jest już zajęty!</div>';
                        echo '<script>$(".errordiv").on("click", function(){
                            $(".errordiv").remove();
                        });</script>';
                    }
                    else
                    {
                        $connection->query("UPDATE users SET refcode='$code' WHERE userid='$uid'");
                        $_SESSION['affiliatecodesuccess'] = $code;
                        $_SESSION['refcode'] = $code;
                        header("Location: affiliate");
                        exit(0);
                    }
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

        if(isset($_SESSION['affiliatecodesuccess']))
        {
            echo '<script>$(".errordiv").remove();</script>';
            echo '<script>$(".successdiv").remove();</script>';
            echo '<div class="successdiv">Utworzono kod '.$_SESSION['affiliatecodesuccess'].'!</div>';
            echo '<script>$(".successdiv").on("click", function(){
                $(".successdiv").remove();
            });</script>';
            unset($_SESSION['affiliatecodesuccess']);
        }

        $uid = $_SESSION['userid'];
        $result = $connection->query("SELECT * FROM users WHERE userid='$uid'");
        $result = $result->fetch_assoc();
        $_SESSION['referraluserid'] = $result['referraluserid'];
        $_SESSION['refcode'] = $result['refcode'];
        $_SESSION['reftotal'] = $result['reftotal'];
    }

?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Program Partnerski - Otwieraj skrzynki CS:GO</title>
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
                        <span class="caseinfo-middle-casename">PROGRAM PARTNERSKI</span>
                    </div>
                    <div id="caseinfo-right">
                        <a href="promo">
                            <span class="modal-link-text">KOD PROMOCYJNY</span>
                            <img src="img/promo.png" height=24 width=24 style="margin-left:-12px;">
                        </a>
                    </div>
                </div>
                <div id="affiliatemain">
                    <div class="affiliatecontainer">
                        <span class="affiliate-text-normal">Twój kod: <span style="color:#4BE4B6;"><?php echo $_SESSION['refcode']; ?></span></span>
                    </div>
                    <div class="affiliatecontainer">
                        <span class="affiliate-text-top">TWOJE STATYSTYKI</span>
                    </div>
                    <div class="affiliatecurrentstats">
                        <div class="affiliatecurrentstatssingle3">
                            Your current level<br/>
                            <?php
                                if($_SESSION['reftotal'] < 50000){echo '1';}
                                else if($_SESSION['reftotal'] < 500000){echo '2';}
                                else if($_SESSION['reftotal'] < 2000000){echo '3';}
                                else if($_SESSION['reftotal'] < 20000000){echo '4';}
                                else if($_SESSION['reftotal'] < 100000000){echo '5';}
                                else {echo '6';}
                            ?>
                        </div>
                        <div class="affiliatecurrentstatssingle3">
                            Your referrals<br/>
                            <?php
                                $uid = $_SESSION['userid'];
                                $refreferrals = $connection->query("SELECT * FROM users WHERE referraluserid='$uid'");
                                $refreferrals = $refreferrals->num_rows;
                                echo $refreferrals;
                            ?>
                        </div>
                        <div class="affiliatecurrentstatssingle3">
                            Your referral deposits<br/>
                            <?php formathajsu($_SESSION['reftotal']); ?>
                        </div>
                        <div class="affiliatecurrentstatssingle3">
                            Needed for the next level<br/>
                            <?php
                                if($_SESSION['reftotal'] >= 100000000)
                                {
                                    echo 'Already at max level!';
                                }
                                else
                                {
                                    formathajsu2($_SESSION['reftotal']);
                                    echo ' / ';
                                    if($_SESSION['reftotal'] < 50000){echo '500,00';}
                                    else if($_SESSION['reftotal'] < 500000){echo '5 000,00';}
                                    else if($_SESSION['reftotal'] < 2000000){echo '20 000,00';}
                                    else if($_SESSION['reftotal'] < 20000000){echo '200 000,00';}
                                    else {echo '1 000 000,00';}
                                }
                            ?>
                        </div>
                        <div class="affiliatecurrentstatssingle3">
                            Your percentage<br/>
                            <?php
                                if($_SESSION['reftotal'] < 50000){echo '3%';}
                                else if($_SESSION['reftotal'] < 500000){echo '4%';}
                                else if($_SESSION['reftotal'] < 2000000){echo '5%';}
                                else if($_SESSION['reftotal'] < 20000000){echo '6%';}
                                else if($_SESSION['reftotal'] < 100000000){echo '7%';}
                                else {echo '8%';}
                            ?>
                        </div>
                        <div class="affiliatecurrentstatssingle3">
                            Your earnings<br/>
                            <?php
                                if($_SESSION['reftotal'] < 50000)
                                {
                                    $wartosc = $_SESSION['reftotal'];
                                    $wartosc = floor($wartosc * 0.03);
                                    formathajsu($wartosc);
                                }
                                else if($_SESSION['reftotal'] < 500000)
                                {
                                    $wartosc = $_SESSION['reftotal'] - 50000;
                                    $wartosc = floor($wartosc * 0.04);
                                    $wartosc = $wartosc + 1500;
                                    formathajsu($wartosc);
                                }
                                else if($_SESSION['reftotal'] < 2000000)
                                {
                                    $wartosc = $_SESSION['reftotal'] - 500000;
                                    $wartosc = floor($wartosc * 0.05);
                                    $wartosc = $wartosc + 19500;
                                    formathajsu($wartosc);
                                }
                                else if($_SESSION['reftotal'] < 20000000)
                                {
                                    $wartosc = $_SESSION['reftotal'] - 2000000;
                                    $wartosc = floor($wartosc * 0.06);
                                    $wartosc = $wartosc + 94500;
                                    formathajsu($wartosc);
                                }
                                else if($_SESSION['reftotal'] < 100000000)
                                {
                                    $wartosc = $_SESSION['reftotal'] - 20000000;
                                    $wartosc = floor($wartosc * 0.07);
                                    $wartosc = $wartosc + 1174500;
                                    formathajsu($wartosc);
                                }
                                else
                                {
                                    $wartosc = $_SESSION['reftotal'] - 100000000;
                                    $wartosc = floor($wartosc * 0.08);
                                    $wartosc = $wartosc + 6774500;
                                    formathajsu($wartosc);
                                }
                            ?>
                        </div>
                    </div>
                    <div class="affiliatecontainer" style="margin-top:40px;">
                        <span class="affiliate-text-top">JAK ZARABIAĆ Z NASZYM PROGRAMEM PARTNERSKIM?</span>
                    </div>
                    <div class="affiliatecontainer">
                        <span class="affiliate-text-normal">KROK 1.</span><br/>
                        <span class="affiliate-text-normal">STWÓRZ SWÓJ WŁASNY KOD POLECAJĄCY</span><br/>
                        <span class="affiliate-text-small">Kod powinien składać się wyłącznie z liter oraz cyfr i powinien zawierać od 3 do 16 znaków!</span>
                        <form method="post" style="margin-bottom:0;margin-top:8px;">
                            <input type="text" id="affiliatecode" name="affiliatecode"
                            <?php
                                if(isset($_SESSION['steamid']))
                                {
                                    if(strlen($_SESSION['refcode']) != 0)
                                    {
                                        echo ' value="'.$_SESSION['refcode'].'"';
                                    }
                                    else
                                    {
                                        echo ' placeholder="WPISZ SWÓJ NOWY KOD!"';
                                    }
                                }
                            ?>
                            ><br/>
                            <input type="submit" id="affiliatesubmit" name="affiliatesubmit" value="<?php
                                if(isset($_SESSION['steamid']))
                                {
                                    if(strlen($_SESSION['refcode']) != 0)
                                    {
                                        echo 'JUŻ POSIADASZ WŁASNY KOD!';
                                    }
                                    else
                                    {
                                        echo 'STWÓRZ SWÓJ KOD!';
                                    }
                                }
                            ?>">
                        </form>
                    </div>
                    <div class="affiliatecontainer">
                        <span class="affiliate-text-normal">KROK 2.</span><br/>
                        <span class="affiliate-text-normal">WYŚLIJ SWÓJ KOD ZNAJOMYM I UDOSTĘPNIJ GO W MEDIACH SPOŁECZNOŚCIOWYCH!</span><br/>
                        <span class="affiliate-text-small">Możesz również dodać "USE CODE" i swój kod do nicku na Steamie oraz do opisu na Steamie!</span><br/>
                        <a href="https://steamcommunity.com/id/me/edit/info" target="_blank">
                            <button class="affiliate-steam-button">Edytuj swój profil Steam</button>
                        </a>
                    </div>
                    <div class="affiliatecontainer">
                        <span class="affiliate-text-normal">KROK 3.</span><br/>
                        <span class="affiliate-text-normal">CIESZ SIĘ BONUSEM OD KAŻDEJ WPŁATY DOKONANEJ PRZEZ KAŻDEGO, KTO SKORZYSTA Z TWOJEGO KODU!</span><br/>
                        <span class="affiliate-text-small">Każdy, kto skorzysta z Twojego kodu, jednorazowo otrzyma 2,50 PLN!</span>
                    </div>
                    <div class="affiliatecontainerspace"></div>
                    <div class="affiliatecontainer">
                        <span class="affiliate-text-top">ILE MOŻNA ZAROBIĆ Z NASZYM PROGRAMEM PARTNERSKIM?</span>
                    </div>
                    <div class="affiliatecontainer">
                        <span class="affiliate-text-normal">Bonus od wpłaty zależy od łącznej wartości wpłat z wykorzystaniem Twojego kodu!</span><br/>
                        <span class="affiliate-text-small">Poniżej znajduje się tabelka przedstawiająca zależność między łączną wartością wpłat a bonusem.</span>
                    </div>
                    <div class="affiliatecontainer">
                        <div class="affiliatecurrentstats">
                            <div class="affiliatecurrentstatssingle">
                                Your current level<br/>
                                <?php
                                    if($_SESSION['reftotal'] < 50000){echo '1';}
                                    else if($_SESSION['reftotal'] < 500000){echo '2';}
                                    else if($_SESSION['reftotal'] < 2000000){echo '3';}
                                    else if($_SESSION['reftotal'] < 20000000){echo '4';}
                                    else if($_SESSION['reftotal'] < 100000000){echo '5';}
                                    else {echo '6';}
                                ?>
                            </div>
                            <div class="affiliatecurrentstatssingle">
                                Your total referral deposit<br/>
                                <?php formathajsu($_SESSION['reftotal']); ?>
                            </div>
                            <div class="affiliatecurrentstatssingle">
                                Your percentage<br/>
                                <?php
                                    if($_SESSION['reftotal'] < 50000){echo '3%';}
                                    else if($_SESSION['reftotal'] < 500000){echo '4%';}
                                    else if($_SESSION['reftotal'] < 2000000){echo '5%';}
                                    else if($_SESSION['reftotal'] < 20000000){echo '6%';}
                                    else if($_SESSION['reftotal'] < 100000000){echo '7%';}
                                    else {echo '8%';}
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="affiliatecontainer">
                        <div class="affiliatecurrentstats2">
                            <div class="affiliatecurrentstatssingle">
                                Level<br/><div class="affiliateem1"></div>
                                1<br/>
                                2<br/>
                                3<br/>
                                4<br/>
                                5<br/>
                                6
                            </div>
                            <div class="affiliatecurrentstatssingle">
                                Needed total referral deposit<br/>
                                0,00 PLN<br/>
                                500,00 PLN<br/>
                                5 000,00 PLN<br/>
                                20 000,00 PLN<br/>
                                200 000,00 PLN<br/>
                                1 000 000,00 PLN
                            </div>
                            <div class="affiliatecurrentstatssingle">
                                Percentage<br/><div class="affiliateem1"></div>
                                3%<br/>
                                4%<br/>
                                5%<br/>
                                6%<br/>
                                7%<br/>
                                8%
                            </div>
                        </div>
                    </div>
                    <div class="affiliatecontainer">
                        <span class="affiliate-text-normal" style="color:#dcae64;">Im więcej osób dowie się o stronie od Ciebie i skorzysta z Twojego kodu - tym więcej zarobisz!</span><br/>
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