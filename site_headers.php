<?php 
    require_once 'db.php';
	require 'steamauth/steamauth.php';
	require 'steamauth/userInfo.php';
?>

<script>
    $(function(){
        $(".headerdesktopmorebutton").on("click", function(){
			$(".header-desktop-modal").css("display", "block");
			if($(window).width() > 1500)
			{
				var right_offset = ($(window).width() - 1500) / 2;
				right_offset = right_offset + 18;
				$(".header-desktop-modal-content").css("margin-right", right_offset+"px");
			}
			else if($(window).width() > 900)
			{
				$(".header-desktop-modal-content").css("margin-right", "0px");
			}
		});
		var headerdesktopmodal = document.getElementById("header-desktop-modal");
		window.onclick = function(event)
		{
			if(event.target == headerdesktopmodal)
			{
				headerdesktopmodal.style.display = "none";
			}
		}
        $(".header-mobile-more-button").on("click", function(){
            if($("#header-mobile-modal").css("display") == "none")
            {
			    $("#header-mobile-modal").css("display", "block");
                $("#giveaways-bar").css("margin-top", "270px");
                $("#main").css("margin-top", "270px");
            }
            else
            {
                $("#header-mobile-modal").css("display", "none");
                $("#giveaways-bar").css("margin-top", "0px");
                $("#main").css("margin-top", "0px");
            }
		});
    });
</script>

<div id="header-desktop">
    <div id="header-desktop-content">
        <a href="index"><img src="img/logo.png" class="logo"></a>
        <?php if(isset($_SESSION['steamid'])) { ?>
            <div id="header-desktop-user">
                <div id="header-desktop-user-left">
                    <div id="headerdesktopbalance"></div>
                    <div id="headerdesktopdoladuj">
                        <a href="doladuj">
                            <button class="doladujbutton">
                                <span class="doladujtext">DOŁADUJ KONTO</span>
                            </button>
                        </a>
                    </div>
                </div>
                <div id="header-desktop-user-middle">
                    <div id="header-desktop-nick">
                        <span class="nick"><?php echo /*$_SESSION['nick']*/$_SESSION['steam_personaname']; ?></span>
                    </div>
                    <div id="header-desktop-gold">
                        <div id="header-desktop-gold-refresh"></div>
                    </div>
                </div>
                <div id="header-desktop-user-right">
                    <a href="profile"><img src="<?php echo /*$_SESSION['avatar']*/$_SESSION['steam_avatarfull']; ?>" class="avatar"></a>
                </div>
                <div id="headerdesktopmore">
                    <button class="headerdesktopmorebutton">
                        <img src="img/3paski1.png" height=40 width=40 class="x3paski">
                    </button>
                </div>
            </div>
            <div id="header-desktop-modal" class="header-desktop-modal">
                <div class="header-desktop-modal-content">
                    <div class="header-desktop-modal-content-mid">
                        <a href="profile">
                            <div class="modal-link-1">
                                <img src="img/profil.png" class="modal-link-img">
                                <span class="modal-link-text">MOJE KONTO</span>
                            </div>
                        </a>
                        <a href="doladuj">
                            <div class="modal-link">
                                <img src="img/doladuj.png" class="modal-link-img">
                                <span class="modal-link-text">DOŁADUJ KONTO</span>
                            </div>
                        </a>
                        <a href="promo">
                            <div class="modal-link">
                                <img src="img/promo.png" class="modal-link-img">
                                <span class="modal-link-text">KOD PROMOCYJNY</span>
                            </div>
                        </a>
                        <a href="affiliate">
                            <div class="modal-link">
                                <img src="img/affiliate.png" class="modal-link-img">
                                <span class="modal-link-text">PROGRAM PARTNERSKI</span>
                            </div>
                        </a>
                        <a href="pomoc">
                            <div class="modal-link">
                                <img src="img/pomoc.png" class="modal-link-img">
                                <span class="modal-link-text">POMOC</span>
                            </div>
                        </a>
                        <a href="provably">
                            <div class="modal-link">
                                <img src="img/provably.png" class="modal-link-img">
                                <span class="modal-link-text">PROVABLY FAIR</span>
                            </div>
                        </a>
                        <?php logoutbutton(); ?>
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <?php loginbutton(); ?>
        <?php } ?>
    </div>
    <div id="header-desktop-bar">
        <div id="header-desktop-bar-content">
            <div id="header-desktop-bar-content-left">
                <a href="index">
                    <div class="header-desktop-bar-content-left-category" style="background-image: url('img/categorycsgo.jpg');">
                        <span class="header-desktop-bar-content-left-category-text">CS:GO SKINS</span>
                    </div>
                </a>
                <a href="essazone">
                    <div class="header-desktop-bar-content-left-category" style="background-image: url('img/categorygold.jpg');">
                        <span class="header-desktop-bar-content-left-category-text">ESSA ZONE</span>
                    </div>
                </a>
            </div>
            <div id="header-desktop-bar-content-right">
                <a href="promo">
                    <div class="header-desktop-bar-content-right-link">
                        <img src="img/promo.png" class="header-desktop-bar-content-right-link-img">
                        <span class="header-desktop-bar-content-right-link-regular">
                            KOD PROMOCYJNY
                        </span>
                    </div>
                </a>
                <a href="freeessa">
                    <div class="header-desktop-bar-content-right-link">
                        <img src="img/chest.png" class="header-desktop-bar-content-right-link-img">
                        <span class="header-desktop-bar-content-right-link-regular">
                            DARMOWE ESSACOINY
                        </span>
                    </div>
                </a>
                <a href="dailycase">
                    <div class="header-desktop-bar-content-right-link">
                        <img src="img/gift.png" class="header-desktop-bar-content-right-link-img">
                        <span class="header-desktop-bar-content-right-link-green">
                            CODZIENNA SKRZYNKA
                        </span>
                    </div>
                </a>
                <a href="upgrader">
                    <div class="header-desktop-bar-content-right-link">
                        <img src="img/upgrade.png" class="header-desktop-bar-content-right-link-img">
                        <span class="header-desktop-bar-content-right-link-red">
                            UPGRADER
                        </span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<div id="header-mobile">
    <div id="header-mobile-top">
        <a href="index"><img src="img/logo.png" class="logo"></a>
        <div id="header-mobile-more">
            <button class="header-mobile-more-button">
                <img src="img/3paski1.png" height=64 width=64 class="x3paski">
            </button>
        </div>
    </div>
    <div id="header-mobile-modal">
        <div id="header-mobile-modal-categories">
            <a href="index">
                <div class="header-mobile-modal-category" style="background-image: url('img/categorycsgo.jpg');">
                    <span class="header-desktop-bar-content-left-category-text">CS:GO SKINS</span>   
                </div>
            </a>
            <a href="essazone">
                <div class="header-mobile-modal-category" style="background-image: url('img/categorygold.jpg');">
                    <span class="header-desktop-bar-content-left-category-text">GOLD AREA</span> 
                </div>
            </a>  
        </div>
        <div id="header-mobile-modal-links" <?php if(isset($_SESSION['steamid'])){echo 'style="margin-top:-16px;"';}?>>
            <a href="profile">
                <div class="header-mobile-modal-link">
                    <img src="img/profil.png" class="header-mobile-modal-link-img">
                    <span class="modal-link-text-2">MOJE KONTO</span>
                </div>
            </a>
            <a href="doladuj">
                <div class="header-mobile-modal-link">
                    <img src="img/doladuj.png" class="header-mobile-modal-link-img">
                    <span class="modal-link-text-2">DOŁADUJ KONTO</span>
                </div>
            </a>
            <a href="promo">
                <div class="header-mobile-modal-link">
                    <img src="img/promo.png" class="header-mobile-modal-link-img">
                    <span class="modal-link-text-2">KOD PROMOCYJNY</span>
                </div>
            </a>
            <a href="affiliate">
                <div class="header-mobile-modal-link">
                    <img src="img/affiliate.png" class="header-mobile-modal-link-img">
                    <span class="modal-link-text-2">PROGRAM PARTNERSKI</span>
                </div>
            </a>
            <a href="pomoc">
                <div class="header-mobile-modal-link">
                    <img src="img/pomoc.png" class="header-mobile-modal-link-img">
                    <span class="modal-link-text-2">POMOC</span>
                </div>
            </a>
            <a href="provably">
                <div class="header-mobile-modal-link">
                    <img src="img/provably.png" class="header-mobile-modal-link-img">
                    <span class="modal-link-text-2">PROVABLY FAIR</span>
                </div>
            </a>
            <a href="freeessa">
                <div class="header-mobile-modal-link">
                    <img src="img/chest.png" class="header-mobile-modal-link-img">
                    <span class="modal-link-text-2">DARMOWE ESSACOINY</span>
                </div>
            </a>
            <?php
                if(isset($_SESSION['steamid']))
                { 
                    logoutbuttonmobilemodal(); 
                }
                else 
                { ?>
                    <a href="?login">
                        <div class="header-mobile-modal-link">
                            <img src="img/steamgray.png" class="header-mobile-modal-link-img">
                            <span class="modal-link-text-2">ZALOGUJ SIĘ</span>
                        </div>
                    </a>
                    
                <?php }
            ?>
            <a href="dailycase">
                <div class="header-mobile-modal-link">
                    <img src="img/gift.png" class="header-mobile-modal-link-img">
                    <span class="modal-link-text-2-green">CODZIENNA SKRZYNKA</span>
                </div>
            </a>
            <a href="upgrader">
                <div class="header-mobile-modal-link">
                    <img src="img/upgrade.png" class="header-mobile-modal-link-img">
                    <span class="modal-link-text-2-red">UPGRADER</span>
                </div>
            </a>
        </div>
        <div id="header-mobile-modal-user">
            <?php if(isset($_SESSION['steamid'])) { ?>
                <div id="header-mobile-modal-user-logged">
                    <div id="header-mobile-modal-user-left">
                        <div class="header-mobile-modal-user-line">
                            <span class="nick"><?php echo /*$_SESSION['nick']*/$_SESSION['steam_personaname']; ?></span>
                        </div>
                        <div class="header-mobile-modal-user-line" style="margin-bottom:0;">
                            <div id="header-mobile-modal-user-balance"></div>
                        </div>
                        <div class="header-mobile-modal-user-line" style="margin-top:0; height:30px;">
                            <div id="header-mobile-modal-user-gold"></div>
                        </div>
                    </div>
                    <div id="header-mobile-modal-user-right">
                        <img src="<?php echo /*$_SESSION['avatar']*/$_SESSION['steam_avatarfull']; ?>" class="header-mobile-modal-user-avatar">
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>