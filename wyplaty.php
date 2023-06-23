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
                        <span class="caseinfo-middle-casename">WYPŁATY</span>
                    </div>
                    <div id="caseinfo-right">
                        <a href="profile">
                            <span class="modal-link-text">MOJE KONTO</span>
                            <img src="img/profil.png" height=24 width=24 style="margin-left:-12px;">
                        </a>
                    </div>
                </div>
                <div id="wyplaty-main">
                    <?php
                        $uid = $_SESSION['userid'];
                        $result = $connection->query("SELECT * FROM withdraws WHERE withdrawuserid='$uid' ORDER BY withdrawid DESC");
                        if($result->num_rows == 0)
                        {
                            echo '<div style="display:block;margin:auto;width:80%;max-width:1400px;height:300px;padding-top:100px;color:#F53F59;">
                            YOU CURRENTLY HAVE NO WITHDRAW REQUESTS!
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
                                $itemid = $itemek['withdrawitemid'];
                                $result2 = $connection->query("SELECT * FROM items WHERE itemid='$itemid'");
                                $result2 = $result2->fetch_assoc();
                                $skinid = $result2['itemskinid'];
                                $skincondition = $result2['itemcondition'];
                                $result3 = $connection->query("SELECT * FROM skins WHERE skinid='$skinid'");
                                $result3 = $result3->fetch_assoc();
                                echo '<div class="wyplaty-div">';
                                echo '<div class="wyplaty-div-1" style="padding-top:0px;">';
                                echo '<img class="wyplaty-img" src="'.$result3['skinimg'].'">';
                                echo '</div><div class="wyplaty-div-2">';
                                echo $result3['skinname'].' | '.$result3['skinskin'].' (';
                                if($skincondition == 1){echo 'Battle-Scarred';}
                                if($skincondition == 2){echo 'Well-Worn';}
                                if($skincondition == 3){echo 'Field-Tested';}
                                if($skincondition == 4){echo 'Minimal Wear';}
                                if($skincondition == 5){echo 'Factory New';}
                                echo ')</div><div class="wyplaty-div-1">Data wypłacenia:<br/>';
                                echo $itemek['withdrawdate1'];
                                echo '</div><div class="wyplaty-div-1">Data wysłania:<br/>';
                                if(strtotime($itemek['withdrawdate2']) == 0){echo 'Jeszcze nie wysłano';}else{echo $itemek['withdrawdate2'];}
                                echo '</div><div class="wyplaty-div-1">Status wypłaty:<br/>';
                                if($itemek['withdrawstatus'] == 1){echo '<span style="color:#dcae64;">W oczekiwaniu na realizację</span>';}
                                if($itemek['withdrawstatus'] == 2){echo '<span style="color:#dcae64;">W realizacji</span>';}
                                if($itemek['withdrawstatus'] == 3){echo '<span style="color:#50e36d;">Zakończona</span>';}
                                if($itemek['withdrawstatus'] == 0){echo '<span style="color:#F53F59;">Anulowana</span>';}
                                echo '</div></div>';
                            }
                        }
                    ?>

                </div>
			</div>
			<div id="footer"></div>
		</div>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>