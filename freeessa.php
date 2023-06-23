<?php

	require_once 'db.php';
	require 'steamauth/steamauth.php';
	require 'steamauth/userInfo.php';
		
	$connection = @new mysqli($host, $db_user, $db_password, $db_name);
    mysqli_set_charset($connection, "utf8");

?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Darmowe Essacoiny - EssaDrop.pl</title>
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
			<div id="main">
                <div id="caseinfo">
                    <div id="caseinfo-left">
                        <a href="index">
                            <img src="img/return.png" height=24 width=24 style="margin-right:-12px;">
                            <span class="modal-link-text">STRONA GŁÓWNA</span>
                        </a>
                    </div>
                    <div id="caseinfo-middle">
                        <span class="caseinfo-middle-casename">DARMOWE ESSACOINY</span>
                    </div>
                    <div id="caseinfo-right">
                        <a href="essazone" style="float:right;">
                            <span class="modal-link-text">ESSAZONE</span>
                            <img src="img/chest.png" height=24 width=24 style="margin-left:-12px;">
                        </a>
                    </div>
                </div>
                <div id="freeessa-main">
                    <div id="freeessa-top">
                        <span style="border-bottom: 2px solid #dcae64;">
                            JAK ZDOBYĆ ESSACOINY?
                        </span>
                    </div>
                    <div class="freeessa-method">
                        OTWIERAJ CODZIENNE SKRZYNKI
                        <div class="freeessa-method-desc">
                            Co 24 godziny możesz otworzyć <a style="color:#4BE4B6;" href="dailycase">darmową skrzynkę</a>, z której możesz dostać essacoiny!
                        </div>
                    </div>
                    <div class="freeessa-method">
                        POLECAJ STRONĘ WRAZ ZE SWOIM KODEM ZNAJOMYM
                        <div class="freeessa-method-desc">
                            Za każdego znajomego, który skorzysta z Twojego <a style="color:#4BE4B6;" href="affiliate">kodu</a>, dostaniesz 25 essacoinów!
                        </div>
                    </div>
                    <div class="freeessa-method">
                        WPISZ KOD PROMOCYJNY
                        <div class="freeessa-method-desc">
                            Jeżeli posiadasz <a style="color:#4BE4B6;" href="promo">kod promocyjny</a>, możesz go wykorzystać i dostać za niego essacoiny!
                        </div>
                    </div>
                    <div class="freeessa-method">
                        MIEJ NASZ AWATAR ORAZ NICK NA STEAMIE
                        <div class="freeessa-method-desc">
                            Co godzinę losowa osoba z naszym <a style="color:#4BE4B6;" href="img/awatar.png" download>awatarem</a> oraz z <a style="color:#4BE4B6;" href="https://steamcommunity.com/id/me/edit/info" target="_blank">ESSADROP.PL</a> w nicku wygrywa darmowe essacoiny!
                        </div>
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