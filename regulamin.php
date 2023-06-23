<?php

	require_once 'db.php';
	require 'steamauth/steamauth.php';
	require 'steamauth/userInfo.php';

?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Regulamin - Otwieraj skrzynki CS:GO</title>
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
                        <span class="caseinfo-middle-casename">REGULAMIN</span>
                    </div>
                    <div id="caseinfo-right">
                        <a href="pomoc">
                            <span class="modal-link-text">POMOC</span>
                            <img src="img/pomoc.png" height=24 width=24 style="margin-left:-12px;">
                        </a>
                    </div>
                </div>
				<div style="width:100%;margin-top:60px;">
					<div class="regulamin-katerogia">
						<div class="regulamin-kategoria-top">
							<span class="regulamin-top-span">
								<!--I. DEFINICJE--> INFO
							</span>
						</div>
						<div class="regulamin-kategoria-main">
							<!--
							1. Regulamin - niniejszy regulamin<br/>
							2. Serwis - serwis internetowy znajdujący się pod adresem essadrop.pl<br/>
							3. Administrator - informacja zostanie umieszczona po oficjalnym uruchomieniu serwisu<br/>
							4. Użytkownik - pełnoletnia osoba fizyczna korzystająca z Serwisu<br/>
							5. Konto - 
							-->
							Trwają prace nad regulaminem, strona w fazie testowej.


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