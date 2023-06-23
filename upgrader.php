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
            var chosen_left_skin_id = 0;
            var chosen_right_skin_id = 0;
			$(function(){
				$("#headers").load("site_headers.php");
				$("#footer").load("site_footer.php");
				$("#headerdesktopbalance").load("refresh_balance.php");
				$("#header-mobile-modal-user-balance").load("refresh_balance_2.php");
				$("#header-desktop-gold-refresh").load("refresh_gold.php");
				$("#header-mobile-modal-user-gold").load("refresh_gold_2.php");
                $("#upgrader-left").load("upgrader_left.php");
                $("#upgrader-middle").load("upgrader_middle.php?price1=".concat(chosen_left_skin_id).concat("&price2=").concat(chosen_right_skin_id));
                $("#upgrader-right").load("upgrader_right.php");
                $("#upgrader-skins-div-left").load("upgrader_skins_left.php?mode=1");
                $("#upgrader-skins-div-right").load("upgrader_skins_right.php?mode=1&filter1=0&filter2=0&filter3=0&filter4=0");
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
                        <span class="caseinfo-middle-casename">UPGRADER</span>
                    </div>
                    <div id="caseinfo-right">
                        <a href="profile">
                            <span class="modal-link-text">EKWIPUNEK</span>
                            <img src="img/backpack.png" height=24 width=24 style="margin-left:-12px;">
                        </a>
                    </div>
                </div>
                <div id="upgrader-top">
                    <div id="upgrader-left"></div>
                    <div id="upgrader-middle"></div>
                    <div id="upgrader-right">
                        <style>
                            .loaderup
                            {
                                margin: auto;
                                margin-top: 90px;
                            }
                            .loader
                            {
                                margin: auto;
                                border: 16px solid #f3f3f3;
                                border-radius: 50%;
                                border-top: 16px solid #3498db;
                                /*width: 120px;
                                height: 120px;*/
                                width: 240px;
                                height: 240px;
                                -webkit-animation: spin 2s linear infinite; /* Safari */
                                animation: spin 2s linear infinite;
                            }
                            /* Safari */
                            @-webkit-keyframes spin
                            {
                                0% { -webkit-transform: rotate(0deg); }
                                100% { -webkit-transform: rotate(360deg); }
                            }
                            @keyframes spin
                            {
                                0% { transform: rotate(0deg); }
                                100% { transform: rotate(360deg); }
                            }
                        </style>
                        <div class="loaderup">
                            <div class="loader"></div>
                        </div>
                    </div>
                    <div id="upgraderphp1"></div>
                </div>
                <div id="upgrader-skins">
                    <div id="upgrader-skins-left">
                        <div class="upgrader-skins-top-text">
                            <div class="upgrader-skins-top-text-text">
                                YOUR ITEMS
                            </div>
                            <div class="upgrader-skins-top-text-filters">
                                <div class="upgrader-skins-top-text-filters-single-left">
                                    <button class="upgrader-skins-top-text-filters-single-button" id="filter-left-1">
                                        Newest
                                    </button>
                                </div>
                                <div class="upgrader-skins-top-text-filters-single-left">
                                    <button class="upgrader-skins-top-text-filters-single-button" id="filter-left-2">
                                        Oldest
                                    </button>
                                </div>
                                <div class="upgrader-skins-top-text-filters-single-left">
                                    <button class="upgrader-skins-top-text-filters-single-button" id="filter-left-3">
                                        Price Asc
                                    </button>
                                </div>
                                <div class="upgrader-skins-top-text-filters-single-left">
                                    <button class="upgrader-skins-top-text-filters-single-button" id="filter-left-4">
                                        Price Desc
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div id="upgrader-skins-div-left" class="upgrader-skins-div"></div>
                    </div>
                    <div id="upgrader-skins-right">
                        <div class="upgrader-skins-top-text">
                            <div class="upgrader-skins-top-text-text">
                                AVAILABLE ITEMS
                            </div>
                            <div class="upgrader-skins-top-text-filters">
                                <div class="upgrader-skins-top-text-filters-single-right">
                                    <input type="text" placeholder="Weapon" id="filter-right-1">
                                </div>
                                <div class="upgrader-skins-top-text-filters-single-right">
                                    <input type="text" placeholder="Skin" id="filter-right-2">
                                </div>
                                <div class="upgrader-skins-top-text-filters-single-right">
                                    <input type="text" placeholder="Min Price" id="filter-right-3">
                                </div>
                                <div class="upgrader-skins-top-text-filters-single-right">
                                    <input type="text" placeholder="Max Price" id="filter-right-4">
                                </div>
                                <div class="upgrader-skins-top-text-filters-single-right">
                                    <button class="upgrader-skins-top-text-filters-single-button" id="filter-right-5">
                                        Price
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div id="upgrader-skins-div-right" class="upgrader-skins-div">
                            <div class="loaderup">
                                <div class="loader"></div>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
			<div id="footer"></div>
		</div>
        <script>
            var right_mode = 1;
            var right_filter_1 = "0";
            var right_filter_2 = "0";
            var right_filter_3 = "0";
            var right_filter_4 = "0";
            $("#filter-left-1").css("border", "1px solid #49d164");
            $("#filter-left-1").on("click", function(){
                $(".upgrader-skins-top-text-filters-single-button").css("border", "1px solid #2c2b36");
                $("#filter-left-1").css("border", "1px solid #49d164");
                $("#upgrader-skins-div-left").load("upgrader_skins_left.php?mode=1");
            });
            $("#filter-left-2").on("click", function(){
                $(".upgrader-skins-top-text-filters-single-button").css("border", "1px solid #2c2b36");
                $("#filter-left-2").css("border", "1px solid #49d164");
                $("#upgrader-skins-div-left").load("upgrader_skins_left.php?mode=2");
            });
            $("#filter-left-3").on("click", function(){
                $(".upgrader-skins-top-text-filters-single-button").css("border", "1px solid #2c2b36");
                $("#filter-left-3").css("border", "1px solid #49d164");
                $("#upgrader-skins-div-left").load("upgrader_skins_left.php?mode=3");
            });
            $("#filter-left-4").on("click", function(){
                $(".upgrader-skins-top-text-filters-single-button").css("border", "1px solid #2c2b36");
                $("#filter-left-4").css("border", "1px solid #49d164");
                $("#upgrader-skins-div-left").load("upgrader_skins_left.php?mode=4");
            });
            $("#filter-right-1").on("input", function(){
                right_filter_1 = $("#filter-right-1").val();
                if(right_filter_1.length == 0)
                {
                    right_filter_1 = "0";
                }
                $("#upgrader-skins-div-right").load("upgrader_skins_right.php?mode=".concat(right_mode).concat("&filter1=").concat(right_filter_1).concat("&filter2=").concat(right_filter_2).concat("&filter3=").concat(right_filter_3).concat("&filter4=").concat(right_filter_4));
            });
            $("#filter-right-2").on("input", function(){
                right_filter_2 = $("#filter-right-2").val();
                if(right_filter_2.length == 0)
                {
                    right_filter_2 = "0";
                }
                $("#upgrader-skins-div-right").load("upgrader_skins_right.php?mode=".concat(right_mode).concat("&filter1=").concat(right_filter_1).concat("&filter2=").concat(right_filter_2).concat("&filter3=").concat(right_filter_3).concat("&filter4=").concat(right_filter_4));
            });
            $("#filter-right-3").on("input", function(){
                right_mode = 2;
                right_filter_3 = $("#filter-right-3").val();
                if(right_filter_3.length == 0)
                {
                    right_filter_3 = "0";
                }
                $("#upgrader-skins-div-right").load("upgrader_skins_right.php?mode=".concat(right_mode).concat("&filter1=").concat(right_filter_1).concat("&filter2=").concat(right_filter_2).concat("&filter3=").concat(right_filter_3).concat("&filter4=").concat(right_filter_4));
            });
            $("#filter-right-4").on("input", function(){
                right_mode = 1;
                right_filter_4 = $("#filter-right-4").val();
                if(right_filter_4.length == 0)
                {
                    right_filter_4 = "0";
                }
                $("#upgrader-skins-div-right").load("upgrader_skins_right.php?mode=".concat(right_mode).concat("&filter1=").concat(right_filter_1).concat("&filter2=").concat(right_filter_2).concat("&filter3=").concat(right_filter_3).concat("&filter4=").concat(right_filter_4));
            });
            $("#filter-right-5").on("click", function(){
                if(right_mode == 1)
                {
                    right_mode = 2;
                }
                else
                {
                    right_mode = 1;
                }
                $("#upgrader-skins-div-right").load("upgrader_skins_right.php?mode=".concat(right_mode).concat("&filter1=").concat(right_filter_1).concat("&filter2=").concat(right_filter_2).concat("&filter3=").concat(right_filter_3).concat("&filter4=").concat(right_filter_4));
            });
        </script>
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