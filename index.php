<?php

	require_once 'db.php';
	require 'steamauth/steamauth.php';
	require 'steamauth/userInfo.php';
		
	$connection = @new mysqli($host, $db_user, $db_password, $db_name);
    mysqli_set_charset($connection, "utf8");

    if(isset($_SESSION['steamid']))
	{
		$steamid = $_SESSION['steamid'];
		$nick = $steamprofile['personaname'];
		$nick = htmlentities($nick, ENT_QUOTES, "UTF-8");
		$avatar = $steamprofile['avatarmedium'];
		$_SESSION['nick'] = $nick;
		$_SESSION['avatar'] = $avatar;
		$_SESSION['avatar_full'] = $steamprofile['avatarfull'];

		$date = date('Y-m-d H:i:s');
		$ip = $_SERVER['REMOTE_ADDR'];
		$connection->query("INSERT INTO logins VALUES (NULL, '$steamid', '$date', '$ip')");

		$result = $connection->query("SELECT * FROM users WHERE steamid='$steamid'");

		$ile = $result->num_rows;

		if($ile == 0)
		{
			$connection->query("INSERT INTO users VALUES (NULL, '$steamid', '$nick', '$avatar', 0, 0, '', 0, '', 0, 0, 0, 0, 0, '0000-00-00 00:00:00')");
			$resultileuserow = $connection->query("SELECT * FROM users");
			$_SESSION['userid'] = $resultileuserow->num_rows;
			$_SESSION['balance'] = 0;
			$_SESSION['gold'] = 0;
			$_SESSION['steamtradeurl'] = '';
			$_SESSION['referraluserid'] = 0;
			$_SESSION['refcode'] = '';
			$_SESSION['reftotal'] = 0;
			$_SESSION['totaldepo'] = 0;
			$_SESSION['rank'] = 0;
			$_SESSION['ip'] = 0;
			$_SESSION['ban'] = 0;
			$_SESSION['last_daily_case'] = 0;
		}
		else
		{
			$connection->query("UPDATE users SET steamnick='$nick', steamavatar='$avatar' WHERE steamid='$steamid'");
			$result = $connection->query("SELECT * FROM users WHERE steamid='$steamid'");
			$result = $result->fetch_assoc();
			$_SESSION['userid'] = $result['userid'];
			$_SESSION['balance'] = $result['balance'];
			$_SESSION['gold'] = $result['gold'];
            $_SESSION['steamtradeurl'] = $result['steamtradeurl'];
            $_SESSION['referraluserid'] = $result['referraluserid'];
			$_SESSION['refcode'] = $result['refcode'];
			$_SESSION['reftotal'] = $result['reftotal'];
			$_SESSION['totaldepo'] = $result['totaldepo'];
			$_SESSION['rank'] = $result['rank'];
			$_SESSION['ip'] = $result['ip'];
			$_SESSION['ban'] = $result['ban'];
			$_SESSION['last_daily_case'] = $result['userlastdailycase'];
			$_SESSION['last_daily_case'] = strtotime($_SESSION['last_daily_case']);
		}

		$result1 = $connection->query("SELECT * FROM logins WHERE ip='$ip'");
		$result1 = $result1->num_rows;
		$result2 = $connection->query("SELECT * FROM logins WHERE ip='$ip' AND steamid='$steamid'");
		$result2 = $result2->num_rows;
		if($result1 > $result2)
		{
			//$connection->query("UPDATE users SET ip=1 WHERE steamid='$steamid'");
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
				$("#giveaway-1").load("refresh_giveaway.php?type=1");
				$("#giveaway-2").load("refresh_giveaway.php?type=2");
				$("#giveaway-3").load("refresh_giveaway.php?type=3");
				$("#giveaway-4").load("refresh_giveaway.php?type=4");
				setInterval(() => {
					$("#headerdesktopbalance").load("refresh_balance.php");
					$("#header-mobile-modal-user-balance").load("refresh_balance_2.php");
					$("#header-desktop-gold-refresh").load("refresh_gold.php");
					$("#header-mobile-modal-user-gold").load("refresh_gold_2.php");
					$("#giveaway-1").load("refresh_giveaway.php?type=1");
					$("#giveaway-2").load("refresh_giveaway.php?type=2");
					$("#giveaway-3").load("refresh_giveaway.php?type=3");
					$("#giveaway-4").load("refresh_giveaway.php?type=4");
				}, 1000);
			});
		</script>
    </head>
    <body>
		<div id="all">
			<div id="headers"></div>
			<div id="main">
				<div id="giveaways-bar">
					<div class="single-giveaway" style="border-bottom: 2px solid #4BE4B6; background: linear-gradient(90deg, rgba(75, 228, 182, 0.6) 0%, rgba(75, 228, 182, 0.2) 100%);">
						<div id="giveaway-1"></div>
					</div>
					<div class="single-giveaway" style="border-bottom: 2px solid #A020F0; background: linear-gradient(90deg, rgba(160, 32, 240, 0.6) 0%, rgba(160, 32, 240, 0.2) 100%);">
						<div id="giveaway-2"></div>
					</div>
					<div class="single-giveaway" style="border-bottom: 2px solid #F53F59; background: linear-gradient(90deg, rgba(245, 63, 89, 0.6) 0%, rgba(245, 63, 89, 0.2) 100%);">
						<div id="giveaway-3"></div>
					</div>
					<div class="single-giveaway" style="border-bottom: 2px solid #dcae64; background: linear-gradient(90deg, rgba(220, 174, 100, 0.6) 0%, rgba(220, 174, 100, 0.2) 100%);">
						<div id="giveaway-4"></div>
					</div>
				</div>
				<div id="giveaway-popup"></div>
				<div id="cases-all">
					<?php
						require_once 'konfiguracja.php';
						$ilosc_skrzynek = sizeof($konfiguracja_skrzynek);
						for($i=0;$i<$ilosc_skrzynek;$i++)
						{ 
							$aktualna_nazwa = $konfiguracja_skrzynek[$i];
							$result = $connection->query("SELECT * FROM cases WHERE casename='$aktualna_nazwa'");
							$result = $result->fetch_assoc();
							?>
							<a href="case?case=<?php echo $result['casename'];?>">
								<div class="case-single" style="background-image: url('<?php echo $result['caseimg'];?>');">
									<div class="case-single-price-div">
										<?php
											if($result['caseprice'] < 10)
											{
												echo '0,0'.$result['caseprice'].' PLN';
											}
											else if($result['caseprice'] < 100)
											{
												echo '0,'.$result['caseprice'].' PLN';
											}
											else if($result['caseprice'] < 100000)
											{
												$grosze = ($result['caseprice']%100);
												$zlote = (($result['caseprice'] - $grosze)/100);
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
											else
											{
												$grosze = ($result['caseprice']%100);
												$zlote = ((($result['caseprice'] - $grosze)/100)%1000);
												$tysiace = floor($result['caseprice']/100000);
												echo $tysiace.' '.$zlote.',';
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
										?>
									</div>
									<div class="case-single-name-div">
										<?php echo $result['casename'];?>
									</div>
								</div>
							</a>
						<?php }
					?>
				</div>
			</div>
			<div id="footer"></div>
		</div>
		<script>
			$("#giveaway-1").on("click", function(){
				$("#giveaway-popup").load("giveaway_popup.php?type=1");
			});
			$("#giveaway-2").on("click", function(){
				$("#giveaway-popup").load("giveaway_popup.php?type=2");
			});
			$("#giveaway-3").on("click", function(){
				$("#giveaway-popup").load("giveaway_popup.php?type=3");
			});
			$("#giveaway-4").on("click", function(){
				$("#giveaway-popup").load("giveaway_popup.php?type=4");
			});
		</script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>