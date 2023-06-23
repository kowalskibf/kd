<?php

    require_once 'db.php';
	require 'steamauth/steamauth.php';
	require 'steamauth/userInfo.php';

    $connection = @new mysqli($host, $db_user, $db_password, $db_name);
    mysqli_set_charset($connection, "utf8");

    error_reporting(E_ERROR | E_PARSE);

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

    $golds_list = [
        'Nomad Knife', 'Skeleton Knife', 'Survival Knife', 'Paracord Knife', 'Classic Knife', 'Bayonet', 'Bowie Knife',
        'Butterfly Knife', 'Falchion Knife', 'Flip Knife', 'Gut Knife', 'Huntsman Knife', 'Karambit', 'M9 Bayonet',
        'Navaja Knife', 'Shadow Daggers', 'Stiletto Knife', 'Talon Knife', 'Ursus Knife', 'Broken Fang Gloves',
        'Driver Gloves', 'Hand Wraps', 'Moto Gloves', 'Specialist Gloves', 'Sport Gloves', 'Hydra Gloves', 'Bloodhound Gloves'
    ];

    $uid = $_SESSION['userid'];
    $result_step = $connection->query("SELECT * FROM deposits WHERE deposituserid='$uid' AND depositmethod=1 AND depositstatus<99 AND depositstatus>0");
    if($result_step->num_rows != 0)
    {
        echo '<script>var odswiezanie_tak = 1;</script>';
    }

    if(isset($_POST['pscsubmit']))
    {
        $godzina = date('Y-m-d H:i:s');
        $kod = $_POST['psccode'];
        $kod = htmlentities($kod, ENT_QUOTES, "UTF-8");
        if(strlen($kod) >= 16 && strlen($kod) <= 19)
        {
            $connection->query("INSERT INTO deposits VALUES (NULL, '$uid', 0, 2, '$godzina', '', 1, 0, 0, '', '$kod')");
            header("Location: doladuj?m=psc");
            exit(0);
        }
    }

?>

<script>
    function formathajsujs(wartosc)
    {
        if(wartosc < 10)
        {
            return "0,0".concat(wartosc.toString()).concat(" PLN");
        }
        else if(wartosc < 100)
        {
            return "0,".concat(wartosc.toString()).concat(" PLN");
        }
        else
        {
            grosze = (wartosc%100);
            zlote = ((wartosc - grosze)/100);
            wynik = zlote.toString().concat(",");
            if(grosze < 10)
            {
                wynik = wynik.concat("0").concat(grosze.toString());
            }
            else
            {
                wynik = wynik.concat(grosze.toString());
            }
            wynik = wynik.concat(" PLN");
            return wynik;
        }
    }
</script>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Doładuj konto - Otwieraj skrzynki CS:GO</title>
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
            var selected_skin = -1;
            var selected_skin_id = 0;
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
                        <span class="caseinfo-middle-casename">DOŁADUJ KONTO</span>
                    </div>
                    <div id="caseinfo-right">
                        <a href="promo">
                            <span class="modal-link-text">KOD PROMOCYJNY</span>
                            <img src="img/promo.png" height=24 width=24 style="margin-left:-12px;">
                        </a>
                    </div>
                </div>
                <div id="depositmain">
                    <div id="depositmain-left">
                        <div class="deposit-side-top-text">
                            METODY PŁATNOŚCI
                        </div>
                        <div class="deposit-payment-method-div" id="depo1">
                            CS:GO SKINS
                            <img src="img/deposit-csgoskins.png" class="deposit-method-img">
                        </div>
                        <div class="deposit-payment-method-div" id="depo2">
                            <img src="img/deposit-psc.png" class="deposit-method-img">
                        </div>
                        <div class="deposit-payment-method-div" id="depo3">
                            <img src="img/deposit-sms.png" class="deposit-method-img">
                            <div class="deposit-method-options-container">
                                <div class="deposit-method-options-option">
                                    <div class="deposit-method-options-option-container">
                                        <img src="img/sms_orange.svg" class="deposit-method-options-img">
                                    </div>
                                </div>
                                <div class="deposit-method-options-option">
                                    <div class="deposit-method-options-option-container">
                                        <img src="img/sms_tmobile.svg" class="deposit-method-options-img">
                                    </div>
                                </div>
                                <div class="deposit-method-options-option">
                                    <div class="deposit-method-options-option-container">
                                        <img src="img/sms_plus.svg" class="deposit-method-options-img">
                                    </div>
                                </div>
                                <div class="deposit-method-options-option">
                                    <div class="deposit-method-options-option-container">
                                        <img src="img/sms_play.svg" class="deposit-method-options-img">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="deposit-payment-method-div" id="depo4">
                            <img src="img/deposit-g2apay.png" class="deposit-method-img">
                            <div class="deposit-method-options-container">
                                <div class="deposit-method-options-option">
                                    <div class="deposit-method-options-option-container">
                                        <img src="img/g2a_visa.svg" class="deposit-method-options-img">
                                    </div>
                                </div>
                                <div class="deposit-method-options-option">
                                    <div class="deposit-method-options-option-container">
                                        <img src="img/g2a_mastercard.svg" class="deposit-method-options-img">
                                    </div>
                                </div>
                                <div class="deposit-method-options-option">
                                    <div class="deposit-method-options-option-container">
                                        <img src="img/g2a_blik.svg" class="deposit-method-options-img">
                                    </div>
                                </div>
                                <div class="deposit-method-options-option">
                                    <div class="deposit-method-options-option-container">
                                        <img src="img/g2a_przelewy24.svg" class="deposit-method-options-img">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="depositmain-right">
                        <div class="deposit-right-div" id="deporight1">
                            <?php
                                $uid = $_SESSION['userid'];
                                $result_step = $connection->query("SELECT * FROM deposits WHERE deposituserid='$uid' AND depositmethod=1 AND depositstatus<99 AND depositstatus>0");
                                if($result_step->num_rows != 0)
                                {
                                    $result_step = $result_step->fetch_assoc();
                                    $skinid = $result_step['depositskinid'];
                                    $cond = $result_step['depositskincondition'];
                                    $result_skin = $connection->query("SELECT * FROM skins WHERE skinid='$skinid'");
                                    $result_skin = $result_skin->fetch_assoc();
                                    ?>
                                    <script>
                                        $("#deporight1").css("height", "594px");
                                        $("#deporight1").css("background-color", "#19181E");
                                        $("#deporight1").css("border-radius", "8px");
                                    </script>
                                    <div id="deposit-skin-after-top">
                                        Aktualny depozyt
                                    </div>
                                    <div id="deposit-skin-after-rest">
                                        <div id="deposit-skin-after-item-info">
                                            <div id="deposit-skin-after-item-info-left">
                                                <img src="<?php echo $result_skin['skinimg']; ?>" id="deposit-skin-after-skin-img">
                                            </div>
                                            <div id="deposit-skin-after-item-info-middle">
                                                <?php
                                                    echo $result_skin['skinname'].' | '.$result_skin['skinskin'];
                                                    if($cond == 1){echo ' (Battle-Scarred)';}
                                                    if($cond == 2){echo ' (Well-Worn)';}
                                                    if($cond == 3){echo ' (Field-Tested)';}
                                                    if($cond == 4){echo ' (Minimal Wear)';}
                                                    if($cond == 5){echo ' (Factory New)';}
                                                ?>
                                            </div>
                                            <div id="deposit-skin-after-item-info-right">
                                                Otrzymasz: 
                                                <span style="color:#dcae64;">
                                                    <?php formathajsu($result_step['depositamount']) ?>
                                                </span>
                                            </div>
                                        </div>
                                        <div id="deposit-skin-after-status-info">
                                            <?php
                                                if($result_step['depositstatus'] == 1)
                                                {
                                                    echo '<span style="color:#dcae64;">Przygotowywanie oferty przez naszego bota...</span>';
                                                }
                                                else if($result_step['depositstatus'] == 2)
                                                {
                                                    echo '<span style="color:#01FF70;">Oferta gotowa!</span>';
                                                }
                                                else if($result_step['depositstatus'] == 31)
                                                {
                                                    echo '<span style="color:#F53F59;">Błąd: Prywatny ekwipunek, <a href="https://steamcommunity.com/id/me/edit/settings" target="_blank">zmień widoczność ekwipunku Steam</a> na publiczny!</span>';
                                                }
                                                else if($result_step['depositstatus'] == 32)
                                                {
                                                    echo '<span style="color:#F53F59;">Błąd: Niepoprawny adres wymiany Steam (TradeURL)!</span>';
                                                }
                                                else if($result_step['depositstatus'] == 33)
                                                {
                                                    echo '<span style="color:#F53F59;">Błąd: Przedmiot niedostępny na wymianę!</span>';
                                                }
                                                else if($result_step['depositstatus'] == 34)
                                                {
                                                    echo '<span style="color:#F53F59;">Błąd: Oferta wymiany odrzucona!</span>';
                                                }
                                            ?>
                                        </div>
                                        <div id="deposit-skin-after-buttons">
                                            <form>
                                            <?php
                                                if($result_step['depositstatus'] != 2)
                                                {
                                                    if($result_step['depositstatus'] > 30 && $result_step['depositstatus'] < 40)
                                                    {
                                                        echo '<div style="width:100%;text-align:center;">';
                                                        echo '<div style="width:50%;float:left;">';
                                                        echo '<form>
                                                            <button class="after-button-half" id="after-button-1" type="submit" style="float:right;margin:5%;">ANULUJ OFERTĘ</button>
                                                        </form>';
                                                        echo '</div>';
                                                        echo '<div style="width:50%;float:left;">';
                                                        echo '<form>
                                                            <button class="after-button-half" id="after-button-2" type="submit" style="float:left;margin:5%;">PONÓW OFERTĘ</button>
                                                        </form>';
                                                        echo '</div>';
                                                        echo '</div>';
                                                        echo '<script>
                                                        $("#after-button-1").on("click", function(){
                                                            $("#deposkinphp2").load("deposit_skin_cancel.php?id='.$result_step['depositid'].'");
                                                        });
                                                        $("#after-button-2").on("click", function(){
                                                            $("#deposkinphp2").load("deposit_skin_renew.php?id='.$result_step['depositid'].'");
                                                        });
                                                        </script>';
                                                    }
                                                    else
                                                    {
                                                        echo '<form>
                                                            <button class="after-button" id="after-button-1" type="submit">ANULUJ OFERTĘ</button>
                                                        </form>';
                                                        echo '<script>
                                                        $("#after-button-1").on("click", function(){
                                                            $("#deposkinphp2").load("deposit_skin_cancel.php?id='.$result_step['depositid'].'");
                                                        });
                                                        </script>';
                                                    }
                                                }
                                                else if($result_step['depositstatus'] == 2)
                                                {
                                                    echo '<a href="'.$result_step['depositofferurl'].'" target="_blank">
                                                        <div class="after-button-div" type="submit">OTWÓRZ OFERTĘ</div>
                                                    </a>';
                                                }
                                            ?>
                                            </form>
                                        </div>
                                    </div>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <div id="deposit-skin-top">
                                        <div id="deposit-skin-top-container">
                                            <div id="deposit-skin-top-left">
                                                <div id="deposit-skin-top-left-img-div">
                                                    <img id="deposit-skin-top-left-img" src="">
                                                </div>
                                                <div id="deposit-skin-top-left-right-div">
                                                    <span id="depo-skin-top-left-span">
                                                        Nie wybrano skina
                                                    </span>
                                                </div>
                                            </div>
                                            <div id="deposit-skin-top-middle">
                                                Otrzymasz: 
                                                <span id="depo-skin-top-middle-span" style="color:#dcae64;">
                                                    0,00 PLN
                                                </span>
                                            </div>
                                            <div id="deposit-skin-top-right">
                                                <form>
                                                    <button id="deposit-button-1">ADD FUNDS</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                        $url = 'https://steamcommunity.com/profiles/'.$_SESSION['steamid'].'/inventory/json/730/2';
                                        //$url = 'https://steamcommunity.com/profiles/76561198208716648/inventory/json/730/2';
                                        $json = json_decode(file_get_contents($url));
                                        if(is_array($json) || is_object($json))
                                        {
                                            $items_imgs = array();
                                            $items_weapons = array();
                                            $items_skins = array();
                                            $items_conditions = array();
                                            $items_prices = array();
                                            $items_rarities = array();
                                            $items_skinids = array();
                                            foreach($json->rgDescriptions as $itemek)
                                            {
                                                $name = $itemek->market_hash_name;
                                                $icon_url = $itemek->icon_url;
                                                if((strpos($name, '|') !== false) && (strpos($name, '(') !== false) && (strpos($name, 'Sticker') === false) && (strpos($name, 'Graffiti') === false) && (strpos($name, 'StatTrak') === false) && (strpos($name, 'Souvenir') === false) && (strpos($name, 'Genuine') === false)/* && ($name[0] != "'")*/)
                                                {
                                                    $itemweapon = explode(" |", $name);
                                                    $itemweapon = $itemweapon[0];
                                                    $itemskin = explode("| ", $name);
                                                    $itemskin = $itemskin[1];
                                                    $itemskin = explode(" (", $itemskin);
                                                    if(strpos($name, 'Dragon King') !== false)
                                                    {
                                                        $itemskin1 = $itemskin[0];
                                                        $itemskin2 = $itemskin[1];
                                                        $itemskin = $itemskin1.' ('.$itemskin2;
                                                        $itemcondition = explode("(", $name);
                                                        $itemcondition = $itemcondition[2];
                                                        $itemcondition = explode(")", $itemcondition);
                                                        $itemcondition = $itemcondition[0];
                                                    }
                                                    else
                                                    {
                                                        $itemskin = $itemskin[0];
                                                        $itemcondition = explode("(", $name);
                                                        $itemcondition = $itemcondition[1];
                                                        $itemcondition = explode(")", $itemcondition);
                                                        $itemcondition = $itemcondition[0];
                                                    }
                                                    foreach($golds_list as $single_gold)
                                                    {
                                                        if(strpos($itemweapon, $single_gold) !== false)
                                                        {
                                                            $itemweapon = substr($itemweapon, 4);
                                                            break;
                                                        }
                                                    }
                                                    if($itemcondition == 'Battle-Scarred'){$itemcondition = 1;}
                                                    if($itemcondition == 'Well-Worn'){$itemcondition = 2;}
                                                    if($itemcondition == 'Field-Tested'){$itemcondition = 3;}
                                                    if($itemcondition == 'Minimal Wear'){$itemcondition = 4;}
                                                    if($itemcondition == 'Factory New'){$itemcondition = 5;}
                                                    $price_result = $connection->query("SELECT * FROM skins WHERE skinname='$itemweapon' AND skinskin='$itemskin'");
                                                    $price_result = $price_result->fetch_assoc();
                                                    $itemprice = $price_result['skinprice'.$itemcondition];
                                                    $itemprice = floor($itemprice * 0.94);
                                                    $itemrarity = $price_result['rarity'];
                                                    $itemskinid = $price_result['skinid'];
                                                    $itemimg = $price_result['skinimg'];
                                                    //array_push($items_imgs, $icon_url);
                                                    array_push($items_imgs, $itemimg);
                                                    array_push($items_weapons, $itemweapon);
                                                    array_push($items_skins, $itemskin);
                                                    array_push($items_conditions, $itemcondition);
                                                    array_push($items_prices, $itemprice);
                                                    array_push($items_rarities, $itemrarity);
                                                    array_push($items_skinids, $itemskinid);
                                                }
                                            }
                                            for($n = sizeof($items_imgs); $n > 1; $n--)
                                            {
                                                for($i=0;$i<$n-1;$i++)
                                                {
                                                    if($items_prices[$i] < $items_prices[$i+1])
                                                    {
                                                        $temp = $items_prices[$i];
                                                        $items_prices[$i] = $items_prices[$i+1];
                                                        $items_prices[$i+1] = $temp;
                                                        $temp = $items_imgs[$i];
                                                        $items_imgs[$i] = $items_imgs[$i+1];
                                                        $items_imgs[$i+1] = $temp;
                                                        $temp = $items_weapons[$i];
                                                        $items_weapons[$i] = $items_weapons[$i+1];
                                                        $items_weapons[$i+1] = $temp;
                                                        $temp = $items_skins[$i];
                                                        $items_skins[$i] = $items_skins[$i+1];
                                                        $items_skins[$i+1] = $temp;
                                                        $temp = $items_conditions[$i];
                                                        $items_conditions[$i] = $items_conditions[$i+1];
                                                        $items_conditions[$i+1] = $temp;
                                                        $temp = $items_rarities[$i];
                                                        $items_rarities[$i] = $items_rarities[$i+1];
                                                        $items_rarities[$i+1] = $temp;
                                                        $temp = $items_skinids[$i];
                                                        $items_skinids[$i] = $items_skinids[$i+1];
                                                        $items_skinids[$i+1] = $temp;
                                                    }
                                                }
                                            }
                                            for($i=0;$i<sizeof($items_imgs);$i++)
                                            {
                                                if($items_prices[$i] >= 250)
                                                {
                                                    
                                                    $opacity = '0.9';
                                                    if($items_rarities[$i] == 1){$rarity = 'rgba(176, 195, 217, '.$opacity.')';}
                                                    else if($items_rarities[$i] == 2){$rarity = 'rgba(94, 152, 217, '.$opacity.')';}
                                                    else if($items_rarities[$i] == 3){$rarity = 'rgba(75, 105, 255, '.$opacity.')';}
                                                    else if($items_rarities[$i] == 4){$rarity = 'rgba(136, 71, 255, '.$opacity.')';}
                                                    else if($items_rarities[$i] == 5){$rarity = 'rgba(211, 44, 230, '.$opacity.')';}
                                                    else if($items_rarities[$i] == 6){$rarity = 'rgba(235, 75, 75, '.$opacity.')';}
                                                    else if($items_rarities[$i] == 7){$rarity = 'rgba(228, 174, 57, '.$opacity.')';}
                                                    echo '<div id="depositskin'.($i+1).'" class="depositskins-single-skin-div" style="background:linear-gradient(rgba(0,0,0,0) 0%, rgba(0,0,0,0) 70%,'.$rarity.' 100%);">';
                                                        echo '<div class="upgrader-single-skin-top">';
                                                            echo '<div class="depositskinsmalltext upgrader-single-skin-condition depositskins-single-skin-condition">';
                                                                if($items_conditions[$i] == 1){ echo 'BS';}
                                                                if($items_conditions[$i] == 2){ echo 'WW';}
                                                                if($items_conditions[$i] == 3){ echo 'FT';}
                                                                if($items_conditions[$i] == 4){ echo 'MW';}
                                                                if($items_conditions[$i] == 5){ echo 'FN';}
                                                            echo '</div>';
                                                            echo '<div class="upgrader-single-skin-price-container">';
                                                                echo '<div class="deposit-single-skin-price">';
                                                                    formathajsu($items_prices[$i]);
                                                                echo '</div>';
                                                            echo '</div>';
                                                            //echo '<img src="https://cdn.steamcommunity.com/economy/image/'.$items_imgs[$i].'" class="csgoinv-img">';
                                                            echo '<img src="'.$items_imgs[$i].'" class="csgoinv-img">';
                                                            echo '<br/>';
                                                            echo '<div class="upgraderskinalltext">';
                                                                echo '<div class="depositskinsmalltext">';
                                                                    echo $items_skins[$i];
                                                                echo '</div>';
                                                                echo '<div class="depositskinbigtext">';
                                                                    echo $items_weapons[$i];
                                                                echo '</div>';
                                                            echo '</div>';
                                                        echo '</div>';
                                                    echo '</div>';
                                                    echo '<script>
                                                        $("#depositskin'.($i+1).'").on("click", function(){
                                                            if(selected_skin != '.($i+1).')
                                                            {
                                                                selected_skin = '.($i+1).';
                                                                selected_skin_id = '.$items_skinids[$i].';
                                                                var selected_skin_condition = '.$items_conditions[$i].';
                                                                var selected_skin_weapon = "'.$items_weapons[$i].'";
                                                                var selected_skin_skin = "'.$items_skins[$i].'";
                                                                var selected_skin_img = "'.$items_imgs[$i].'";
                                                                var selected_skin_rarity = '.$items_rarities[$i].';
                                                                $(".depositskins-single-skin-div").css("border", "1px solid #2c2b36");
                                                                $(this).css("border", "1px solid #01FF70");
                                                                $("#depo-chosen-skin-number").text(selected_skin);
                                                                $("#depo-skin-top-middle-span").text(formathajsujs('.$items_prices[$i].'));
                                                                //$("#deposit-skin-top-left-img").attr("src", "http://cdn.steamcommunity.com/economy/image/'.$items_imgs[$i].'");
                                                                $("#deposit-skin-top-left-img").attr("src", "'.$items_imgs[$i].'");
                                                                $("#deposit-skin-top-left-img").css("display", "flex");
                                                                var item_cond;
                                                                if('.$items_conditions[$i].' == 1){item_cond = "Battle-Scarred";}
                                                                if('.$items_conditions[$i].' == 2){item_cond = "Well-Worn";}
                                                                if('.$items_conditions[$i].' == 3){item_cond = "Field-Tested";}
                                                                if('.$items_conditions[$i].' == 4){item_cond = "Minimal Wear";}
                                                                if('.$items_conditions[$i].' == 5){item_cond = "Factory New";}
                                                                $("#depo-skin-top-left-span").text("'.$items_weapons[$i].' | '.$items_skins[$i].' (".concat(item_cond).concat(")"));
                                                                $("#deposit-button-1").attr("disabled", false);
                                                                $("#deposit-button-1").off("click");
                                                                $("#deposit-button-1").on("click", function(event){
                                                                    event.preventDefault();
                                                                });
                                                                $("#deposit-button-1").on("click", function(){
                                                                    $("#deposkinphp1").load("deposit_skin_1.php?skinid='.$items_skinids[$i].'&cond='.$items_conditions[$i].'");
                                                                });
                                                            }
                                                            else if(selected_skin == '.($i+1).')
                                                            {
                                                                selected_skin = -1;
                                                                selected_skin_id = 0;
                                                                selected_skin_condition = 0;
                                                                $(".depositskins-single-skin-div").css("border", "1px solid #2c2b36");
                                                                $("#depo-skin-top-middle-span").text("0,00 PLN");
                                                                $("#deposit-skin-top-left-img").attr("src", "");
                                                                $("#deposit-skin-top-left-img").css("display", "none");
                                                                $("#depo-skin-top-left-span").text("Nie wybrano skina");
                                                                $("#deposit-button-1").attr("disabled", true);
                                                                $("#deposit-button-1").off("click");
                                                            }
                                                        });
                                                    </script>';
                                                }
                                            }
                                            if(sizeof($items_imgs) == 0)
                                            {
                                                echo '<div style="display:block;margin:auto;width:80%;height:230px;padding-top:100px;color:#F53F59;">
                                                    YOU CURRENTLY HAVE NO ACCEPTED SKINS, GET SOME OR USE ANOTHER PAYMENT METHOD
                                                </div>';
                                            }
                                        }
                                        else
                                        {
                                            echo '<div style="display:block;margin:auto;width:80%;height:230px;padding-top:100px;color:#F53F59;">
                                                TRY AGAIN IN A SECOND...
                                            </div>';
                                        }
                                    }
                                ?>
                        </div>
                        <div class="deposit-right-div" id="deporight2">
                            <div style="width:100%;min-height:594px;background-color:#19181E;border-radius:8px;">
                                <div id="deposit-skin-after-top">
                                    <img src="img/deposit-psc.png" class="deposit-right-top-img">
                                </div>
                                <div id="deposit-psc-form">
                                    <form method="post">
                                        <div class="psccodediv">Wpisz kod</div><br/>
                                        <input type="text" name="psccode" class="psccodeinput">
                                        <button type="submit" name="pscsubmit" class="psccodebutton">UŻYJ KOD</button>
                                    </form>
                                </div>
                                <div id="deposit-psc-disclaimer">
                                    Płatność za pomocą PaySafeCard nie przebiega za pomocą oficjalnej bramki płatniczej PaySafeCard, ta funkcja zostanie dodana wkrótce!
                                </div>
                                <div id="deposit-psc-payments">
                                    <span style="color:#dcae64;">Twoje oczekujące płatności</span>
                                    <?php
                                        $psc_payments = array();
                                        $psc_result = $connection->query("SELECT * FROM deposits WHERE deposituserid='$uid' AND depositmethod=2 AND depositstatus=1");
                                        while($psc_payment = mysqli_fetch_assoc($psc_result))
                                        {
                                            array_push($psc_payments, $psc_payment);
                                        }
                                        foreach($psc_payments as $psc_payment)
                                        {
                                            echo '<br/>';
                                            echo $psc_payment['depositdate1'];
                                            echo '&nbsp;&nbsp;&nbsp;&nbsp;';
                                            $kod = $psc_payment['depositpsccode'];
                                            for($i=0;$i<4;$i++){echo $kod[$i];}
                                            for($i=0;$i<8;$i++){echo '*';}
                                            for($i=-4;$i<0;$i++){echo $kod[$i];}
                                        }


                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="deposit-right-div" id="deporight3">
                            <div class="deposit-right-coming-soon">
                                Już wkrótce...
                            </div>
                        </div>
                        <div class="deposit-right-div" id="deporight4">
                            <div class="deposit-right-coming-soon">
                                Już wkrótce...
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="deposkinphp1"></div>
            <div id="deposkinphp2"></div>
			<div id="footer"></div>
		</div>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="js/bootstrap.min.js"></script>
        <script>
            $(".deposit-right-div").css("display", "none");
            $("#deporight1").css("display", "block");
            $("#depo1").css("border", "2px solid #dcae64");
            $(".deposit-payment-method-div").on("click", function(){
                $(".deposit-payment-method-div").css("border", "2px solid #111114");
                $(this).css("border", "2px solid #dcae64");
            });
            $("#depo1").on("click", function(){
                $(".deposit-right-div").css("display", "none");
                $("#deporight1").css("display", "block");
            })
            $("#depo2").on("click", function(){
                $(".deposit-right-div").css("display", "none");
                $("#deporight2").css("display", "block");
            })
            $("#depo3").on("click", function(){
                $(".deposit-right-div").css("display", "none");
                $("#deporight3").css("display", "block");
            })
            $("#depo4").on("click", function(){
                $(".deposit-right-div").css("display", "none");
                $("#deporight4").css("display", "block");
            })
            $("#deposit-button-1").attr("disabled", true);
            if(typeof odswiezanie_tak !== 'undefined')
            {
                var interwal = setInterval(() => {
                    if(odswiezanie_tak == 1)
                    {
                        $("#deporight1").load("deposit_after_refresh.php");
                    }
                }, 1000);
            }
        </script>
        <?php
            if(isset($_GET['m']))
            {
                if($_GET['m'] == 'psc')
                {
                    echo '<script>
                        $("#deporight1").css("display", "none");
                        $("#deporight2").css("display", "block");
                        $(".deposit-payment-method-div").css("border", "2px solid #111114");
                        $("#depo2").css("border", "2px solid #dcae64");
                    </script>';
                }
            }
        ?>
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


