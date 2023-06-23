<?php
if (empty($_SESSION['steam_uptodate']) or empty($_SESSION['steam_personaname']))
{
	
	require 'SteamConfig.php';

	if(isset($_SESSION['steamid']))
	{
		$url = file_get_contents("https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=".$steamauth['apikey']."&steamids=".$_SESSION['steamid']);
	}
	
	if(isset($url))
	{
		$content = json_decode($url, true);
	}
	
	if(isset($content['response']['players'][0]['steamid']))
	{
		$_SESSION['steam_steamid'] = $content['response']['players'][0]['steamid'];
	}

	if(isset($content['response']['players'][0]['communityvisibilitystate']))
	{
		$_SESSION['steam_communityvisibilitystate'] = $content['response']['players'][0]['communityvisibilitystate'];
	}

	if(isset($content['response']['players'][0]['profilestate']))
	{
		$_SESSION['steam_profilestate'] = $content['response']['players'][0]['profilestate'];
	}

	if(isset($content['response']['players'][0]['personaname']))
	{
		$_SESSION['steam_personaname'] = $content['response']['players'][0]['personaname'];
	}

	if(isset($content['response']['players'][0]['lastlogoff']))
	{
		$_SESSION['steam_lastlogoff'] = $content['response']['players'][0]['lastlogoff'];
	}

	if(isset($content['response']['players'][0]['profileurl']))
	{
		$_SESSION['steam_profileurl'] = $content['response']['players'][0]['profileurl'];
	}

	if(isset($content['response']['players'][0]['avatar']))
	{
		$_SESSION['steam_avatar'] = $content['response']['players'][0]['avatar'];
	}

	if(isset($content['response']['players'][0]['avatarmedium']))
	{
		$_SESSION['steam_avatarmedium'] = $content['response']['players'][0]['avatarmedium'];
	}

	if(isset($content['response']['players'][0]['avatarfull']))
	{
		$_SESSION['steam_avatarfull'] = $content['response']['players'][0]['avatarfull'];
	}

	if(isset($content['response']['players'][0]['personastate']))
	{
		$_SESSION['steam_personastate'] = $content['response']['players'][0]['personastate'];
	}

	if(isset($content['response']['players'][0]['realname']))
	{
		$_SESSION['steam_realname'] = $content['response']['players'][0]['realname'];
	}

	$_SESSION['steam_realname'] = "Real name not given";

	if(isset($content['response']['players'][0]['primaryclanid']))
	{
		$_SESSION['steam_primaryclanid'] = $content['response']['players'][0]['primaryclanid'];
	}
	
	if(isset($content['response']['players'][0]['timecreated']))
	{
		$_SESSION['steam_timecreated'] = $content['response']['players'][0]['timecreated'];
	}
	
	$_SESSION['steam_uptodate'] = time();

}
	
	if(isset($_SESSION['steam_steamid']))
	{
		$steamprofile['steamid'] = $_SESSION['steam_steamid'];
	}

	if(isset($_SESSION['steam_communityvisibilitystate']))
	{
		$steamprofile['communityvisibilitystate'] = $_SESSION['steam_communityvisibilitystate'];
	}

	if(isset($_SESSION['steam_profilestate']))
	{
		$steamprofile['profilestate'] = $_SESSION['steam_profilestate'];
	}

	if(isset($_SESSION['steam_personaname']))
	{
		$steamprofile['personaname'] = $_SESSION['steam_personaname'];
	}

	if(isset($_SESSION['steam_lastlogoff']))
	{
		$steamprofile['lastlogoff'] = $_SESSION['steam_lastlogoff'];
	}

	if(isset($_SESSION['steam_profileurl']))
	{
		$steamprofile['profileurl'] = $_SESSION['steam_profileurl'];
	}

	if(isset($_SESSION['steam_avatar']))
	{
		$steamprofile['avatar'] = $_SESSION['steam_avatar'];
	}

	if(isset($_SESSION['steam_avatarmedium']))
	{
		$steamprofile['avatarmedium'] = $_SESSION['steam_avatarmedium'];
	}

	if(isset($_SESSION['steam_avatarfull']))
	{
		$steamprofile['avatarfull'] = $_SESSION['steam_avatarfull'];
	}

	if(isset($_SESSION['steam_personastate']))
	{
		$steamprofile['personastate'] = $_SESSION['steam_personastate'];
	}

	if(isset($_SESSION['steam_realname']))
	{
		$steamprofile['realname'] = $_SESSION['steam_realname'];
	}

	if(isset($_SESSION['steam_primaryclanid']))
	{
		$steamprofile['primaryclanid'] = $_SESSION['steam_primaryclanid'];
	}

	if(isset($_SESSION['steam_timecreated']))
	{
		$steamprofile['timecreated'] = $_SESSION['steam_timecreated'];
	}

	if(isset($_SESSION['steam_uptodate']))
	{
		$steamprofile['uptodate'] = $_SESSION['steam_uptodate'];
	}

// Version 4.0
?>
    
