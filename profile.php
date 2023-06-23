<?php

	require_once 'db.php';
	require 'steamauth/steamauth.php';
	require 'steamauth/userInfo.php';
		
	$connection = @new mysqli($host, $db_user, $db_password, $db_name);
    mysqli_set_charset($connection, "utf8");

    if(isset($_SESSION['steamid']) == false)
	{
        header("Location: index");
	}

    if(isset($_POST['tradeurlinput']))
    {
        $tradeurl = $_POST['tradeurlinput'];
        if((strlen($tradeurl) > 65) && (strlen($tradeurl) < 80))
        {
            if(strpos($tradeurl, 'https://steamcommunity.com/tradeoffer/new/?partner=') !== false)
            {
                $userid = $_SESSION['userid'];
                $tradeurl = htmlentities($tradeurl, ENT_QUOTES, "UTF-8");
                $dlugosc = strlen($tradeurl);
                if($tradeurl[$dlugosc - 19] == '&' && $tradeurl[$dlugosc - 18] == 'a' && $tradeurl[$dlugosc - 17] == 'm' && $tradeurl[$dlugosc - 16] == 'p' && $tradeurl[$dlugosc - 15] == ';')
                {
                    for($i=0;$i<14;$i++)
                    {
                        $tradeurl[$dlugosc - 18 + $i] = $tradeurl[$dlugosc - 14 + $i];
                    }
                    for($i=0;$i<4;$i++)
                    {
                        $tradeurl = substr_replace($tradeurl, "", -1);
                    }
                    $connection->query("UPDATE users SET steamtradeurl='$tradeurl' WHERE userid='$userid'");
                    $_SESSION['steamtradeurl'] = $tradeurl;
                    header("Location: profile");
                    exit(0);
                }
            }
        }
    }

?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>EssaDrop.pl - Otwieraj skrzynki CS:GO</title>
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
				}, 1000);
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
                        <span class="caseinfo-middle-casename">MOJE KONTO</span>
                    </div>
                    <div id="caseinfo-right">
                        <a href="wyplaty">
                            <span class="modal-link-text">WYPŁATY</span>
                            <img src="img/withdraw.png" height=24 width=24 style="margin-left:-12px;">
                        </a>
                    </div>
                </div>
                <div id="profileuserinfo">
                    <div id="profileuserinfo-left">
                        <div id="profileuserinfo-left-content">
                            <div class="profileuserinfo-left-content-single">
                                <div class="profileuserinfo-left-content-single-div-2">
                                    <form method="post">
                                        <input type="text" name="tradeurlinput" class="profileuserinfo-left-content-single-div-2-input"
                                            <?php
                                                if((strlen($_SESSION['steamtradeurl']) > 65) && (strlen($_SESSION['steamtradeurl']) < 80))
                                                {
                                                    echo ' placeholder="'.$_SESSION['steamtradeurl'].'"';
                                                }
                                                else
                                                {
                                                    echo ' placeholder="Podaj swój TradeURL"';
                                                }
                                            ?>
                                        >
                                        <button type="submit" class="profileuserinfo-left-content-single-div-2-submit">
                                            ZAPISZ
                                        </button>
                                        <a href="https://steamcommunity.com/id/me/tradeoffers/privacy#trade_offer_access_url" target="_blank">
                                            <div class="profileuserinfo-left-content-single-div-2-submit profileuserinfo-left-content-single-div-2-submit-2">
                                                TradeURL znajdziesz tutaj
                                            </div>
                                        </a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="profileuserinfo-middle">
                        <img src="<?php echo $_SESSION['steam_avatarfull']; ?>" class="profileuserinfoavatar">
                        <div id="profileuserinfonick">
                            <?php echo $_SESSION['nick']; ?>
                        </div>
                    </div>
                    <div id="profileuserinfo-right">
                        <div id="profileuserinfo-left-content">
                            <div class="profileuserinfo-left-content-single">
                                <div class="profileuserinfo-left-content-single-div-2">
                                    <a href="https://steamcommunity.com/id/me/edit/info" target="_blank">
                                        <button type="submit" class="profileuserinfo-left-content-single-div-2-submit">
                                            ZMIEŃ NICK
                                        </button>
                                    </a>
                                    <a href="https://steamcommunity.com/id/me/edit/avatar" target="_blank">
                                        <button type="submit" class="profileuserinfo-left-content-single-div-2-submit">
                                            ZMIEŃ AWATAR
                                        </button>
                                    </a>
                                    <a href="?update">
                                        <button type="submit" class="profileuserinfo-left-content-single-div-2-submit">
                                            ODŚWIEŻ PROFIL
                                        </button>
                                    </a>
                                    <a href="?logout">
                                        <button type="submit" class="profileuserinfo-left-content-single-div-2-submit">
                                            WYLOGUJ SIĘ
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="ekwipunek">
                    <?php
                        $uid = $_SESSION['userid'];
                        $result = $connection->query("SELECT * FROM items WHERE itemuserid='$uid' AND itemstatus=1 ORDER BY itemid DESC");
                        if($result->num_rows == 0)
                        {
                            echo '<div style="display:block;margin:auto;width:80%;max-width:1400px;height:300px;padding-top:100px;color:#F53F59;">
                            YOU CURRENTLY HAVE NO SKINS, OPEN SOME CASES TO GET THEM!
                            </div>';
                        }
                        else
                        {
                            $itemki = array();
                            while($itemek = mysqli_fetch_assoc($result))
                            {
                                array_push($itemki, $itemek);
                            }
                            foreach($itemki as $itemek)
                            {
                                $itemekskinid = $itemek['itemskinid'];
                                $result2 = $connection->query("SELECT * FROM skins WHERE skinid='$itemekskinid'");
                                $result2 = $result2->fetch_assoc();
                                $rarity = $result2['rarity'];
                                $opacity = '0.9';
                                if($rarity == 1){$rarity = 'rgba(176, 195, 217, '.$opacity.')';}
                                else if($rarity == 2){$rarity = 'rgba(94, 152, 217, '.$opacity.')';}
                                else if($rarity == 3){$rarity = 'rgba(75, 105, 255, '.$opacity.')';}
                                else if($rarity == 4){$rarity = 'rgba(136, 71, 255, '.$opacity.')';}
                                else if($rarity == 5){$rarity = 'rgba(211, 44, 230, '.$opacity.')';}
                                else if($rarity == 6){$rarity = 'rgba(235, 75, 75, '.$opacity.')';}
                                else if($rarity == 7){$rarity = 'rgba(228, 174, 57, '.$opacity.')';}
                                echo '<div id="profileselldiv'.$itemek['itemid'].'" class="profileselldiv" style="background:linear-gradient(rgba(0,0,0,0) 0%, rgba(0,0,0,0) 45%,'.$rarity.' 100%);">';
                                echo '<img src="'.$result2['skinimg'].'" class="profileskinimg">';
                                echo '<br/><div class="profileskinalltext"><div class="profileskinsmalltext">';
                                echo $result2['skinname'];
                                echo '</div><div class="profileskinbigtext">';
                                echo $result2['skinskin'];
                                echo '</div><div class="profileskinsmalltext">';
                                if($itemek['itemcondition'] == 1){ echo 'Battle-Scarred';}
                                if($itemek['itemcondition'] == 2){ echo 'Well-Worn';}
                                if($itemek['itemcondition'] == 3){ echo 'Field-Tested';}
                                if($itemek['itemcondition'] == 4){ echo 'Minimal Wear';}
                                if($itemek['itemcondition'] == 5){ echo 'Factory New';}
                                echo '</div></div>';
                                echo '<button id="profilesellbutton'.$itemek['itemid'].'" class="profilesellbutton">SELL FOR<br/>';
                                $price = $result2['skinprice'.$itemek['itemcondition']];
                                if($price < 10)
                                {
                                    echo '0,0'.$price.' PLN';
                                }
                                else if($price < 100)
                                {
                                    echo '0,'.$price.' PLN';
                                }
                                else
                                {
                                    $grosze = ($price%100);
                                    $zlote = (($price - $grosze)/100);
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
                                echo '</button>';
                                echo '<button id="profilecollectbutton'.$itemek['itemid'].'" class="profilecollectbutton">';
                                echo 'WITHDRAW';
                                echo '</button>';
                                echo '<script>
                                $("#profilesellbutton'.$itemek['itemid'].'").on("click", function(){
                                    $("#profilephpsell").load("profile_sell.php?itemid='.$itemek['itemid'].'");
                                });
                                $("#profilecollectbutton'.$itemek['itemid'].'").on("click", function(){
                                    $("#profilephpcollect").load("profile_collect.php?itemid='.$itemek['itemid'].'");
                                });</script>';
                                echo '<br/>';
                                echo '</div>';
                            }
                        }
                    ?>
                </div>
			</div>
            <div id="profilephpsell"></div>
            <div id="profilephpcollect"></div>
			<div id="footer"></div>
		</div>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>