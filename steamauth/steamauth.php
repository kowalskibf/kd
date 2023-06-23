<?php
ob_start();
session_start();

function logoutbutton() {
	//echo "<form action='' method='get'><button name='logout' type='submit' class='logoutbutton'>Wyloguj</button></form>"; //logout button
	echo '<form action="index" method="get">
	<div class="modal-link">
	<button name="logout" type="submit" class="logoutbutton"><img src="img/wyloguj.png" class="modal-link-img"><span class="modal-link-text"> WYLOGUJ SIĘ</span></button>
	</div>
	</form>';
}

function logoutbuttonprofile() {
	//echo "<form action='' method='get'><button name='logout' type='submit' class='logoutbutton'>Wyloguj</button></form>"; //logout button
	echo '<form action="index" method="get">
	<div class="modal-link">
	<button name="logout" type="submit" class="logoutbuttonprofile"><img src="img/wyloguj.png" class="modal-link-img"><span class="modal-link-text"> WYLOGUJ SIĘ</span></button>
	</div>
	</form>';
}

function logoutbuttonmobilemodal() {
	//echo "<form action='' method='get'><button name='logout' type='submit' class='logoutbutton'>Wyloguj</button></form>"; //logout button
	echo '<form action="index" method="get">
	<div class="header-mobile-modal-link" style="padding-top:3px;">
	<button name="logout" type="submit" class="logoutbutton"><img src="img/wyloguj.png" class="header-mobile-modal-link-img"><span class="modal-link-text-2"> WYLOGUJ SIĘ</span></button>
	</div>
	</form>';
}

function loginbutton($buttonstyle = "square") {
	$button['rectangle'] = "01";
	$button['square'] = "02";
	//$button = "<a href='?login'><img src='https://steamcommunity-a.akamaihd.net/public/images/signinthroughsteam/sits_".$button[$buttonstyle].".png'></a>";
	$button = "<a href='index?login'><button class='loginbutton'><img src='img/steam.png' class='steam'>ZALOGUJ ZA POMOCA STEAM</button></a>";
	
	echo $button;
}

function loginbutton_login_to_proceed($buttonstyle = "square") {
	$button['rectangle'] = "01";
	$button['square'] = "02";
	//$button = "<a href='?login'><img src='https://steamcommunity-a.akamaihd.net/public/images/signinthroughsteam/sits_".$button[$buttonstyle].".png'></a>";
	$button = "<a href='index?login'><button class='loginbutton_login_to_proceed'><img src='img/steam.png' class='steam'>ZALOGUJ ZA POMOCA STEAM</button></a>";
	
	echo $button;
}

/*function loginbuttonmobilemodal($buttonstyle = "square") {
	$button['rectangle'] = "01";
	$button['square'] = "02";
	//$button = "<a href='?login'><img src='https://steamcommunity-a.akamaihd.net/public/images/signinthroughsteam/sits_".$button[$buttonstyle].".png'></a>";
	$button = "<a href='?login'><button class='loginbuttonmobilemodal'><img src='img/steam.png' class='steam'>ZALOGUJ ZA POMOCA STEAM</button></a>";
	
	echo $button;
}*/

function loginbuttonmobilemodal($buttonstyle = "square") {
	$button['rectangle'] = "01";
	$button['square'] = "02";
	//$button = "<a href='?login'><img src='https://steamcommunity-a.akamaihd.net/public/images/signinthroughsteam/sits_".$button[$buttonstyle].".png'></a>";
	$button = "<a href='index?login'><button class='loginbuttonmobilemodal'><img src='img/steam.png' class='steam'>ZALOGUJ ZA POMOCA STEAM</button></a>";
	
	echo $button;
}

if (isset($_GET['login'])){
	require 'openid.php';
	try {
		require 'SteamConfig.php';
		$openid = new LightOpenID($steamauth['domainname']);
		
		if(!$openid->mode) {
			$openid->identity = 'https://steamcommunity.com/openid';
			header('Location: ' . $openid->authUrl());
		} elseif ($openid->mode == 'cancel') {
			echo 'User has canceled authentication!';
		} else {
			if($openid->validate()) { 
				$id = $openid->identity;
				$ptn = "/^https?:\/\/steamcommunity\.com\/openid\/id\/(7[0-9]{15,25}+)$/";
				preg_match($ptn, $id, $matches);
				
				$_SESSION['steamid'] = $matches[1];
				if (!headers_sent()) {
					header('Location: '.$steamauth['loginpage']);
					exit;
				} else {
					?>
					<script type="text/javascript">
						window.location.href="<?=$steamauth['loginpage']?>";
					</script>
					<noscript>
						<meta http-equiv="refresh" content="0;url=<?=$steamauth['loginpage']?>" />
					</noscript>
					<?php
					exit;
				}
			} else {
				echo "User is not logged in.\n";
			}
		}
	} catch(ErrorException $e) {
		echo $e->getMessage();
	}
}

if (isset($_GET['logout'])){
	require 'SteamConfig.php';
	session_unset();
	session_destroy();
	header('Location: '.$steamauth['logoutpage']);
	exit;
}

if (isset($_GET['update'])){
	unset($_SESSION['steam_uptodate']);
	require 'userInfo.php';
	header('Location: '.$_SERVER['PHP_SELF']);
	exit;
}

// Version 4.0

?>
