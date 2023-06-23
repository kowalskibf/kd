<?php
	
	require_once 'db.php';
	require 'steamauth/steamauth.php';
	require 'steamauth/userInfo.php';
    
    $type = $_GET['type'];

    if(isset($_SESSION['steamid']))
	{
        ?>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="js/jq.js"></script>
        <script>
            $(function(){
                var giveawaymodal = document.getElementById("giveaway-modal");
                window.onclick = function(event)
                {
                    if(event.target == giveawaymodal)
                    {
                        giveawaymodal.style.display = "none";
                        clearInterval(interwal);
                    }
                }
                $("#giveaway-modal-content-top-time").load("refresh_giveaway_modal_time.php?type=<?php echo $type; ?>");
				var interwal = setInterval(() => {
                    $("#giveaway-modal-content-top-time").load("refresh_giveaway_modal_time.php?type=<?php echo $type; ?>");
				}, 1000);
            });
        </script>
        <?php
        $steamid = $_SESSION['steamid'];
        $uid = $_SESSION['userid'];
        $czas = time();
        $connection = @new mysqli($host, $db_user, $db_password, $db_name);
        $ga = $connection->query("SELECT * FROM giveaways WHERE giveawaytime1<'$czas' AND giveawaytime2>'$czas' AND giveawaytype='$type'");
        $ga = $ga->fetch_assoc();
        $skinid = $ga['giveawayskin'];
        $cond = $ga['giveawaycondition'];
        $skin = $connection->query("SELECT * FROM skins WHERE skinid='$skinid'");
        $skin = $skin->fetch_assoc();
        ?>
        <div id="giveaway-modal">
            <div id="giveaway-modal-content" style="border: 2px solid <?php
                if($type==1){echo '#4BE4B6';}
                if($type==2){echo '#A020F0';}
                if($type==3){echo '#F53F59';}
                if($type==4){echo '#dcae64';}
            ?>;">
                <div id="giveaway-modal-content-top" style="background: <?php
                    if($type==1){echo 'linear-gradient(90deg, rgba(75, 228, 182, 0.6) 0%, rgba(75, 228, 182, 0.2) 100%)';}
                    if($type==2){echo 'linear-gradient(90deg, rgba(160, 32, 240, 0.6) 0%, rgba(160, 32, 240, 0.2) 100%)';}
                    if($type==3){echo 'linear-gradient(90deg, rgba(245, 63, 89, 0.6) 0%, rgba(245, 63, 89, 0.2) 100%)';}
                    if($type==4){echo 'linear-gradient(90deg, rgba(220, 174, 100, 0.6) 0%, rgba(220, 174, 100, 0.2) 100%)';}
                ?>;">
                    <div class="giveaway-modal-content-top-33">
                        <img src="<?php echo $skin['skinimg']; ?>" class="giveaway-modal-skin-img">
                    </div>
                    <div class="giveaway-modal-content-top-33 giveaway-modal-content-top-33-padding">
                        <?php echo $skin['skinname'].' | '.$skin['skinskin']; ?>
                        <br/><span style="color:#aaaaaa;">Dołącz do darmowego konkursu!</span>
                    </div>
                    <div class="giveaway-modal-content-top-33 giveaway-modal-content-top-33-padding giveaway-modal-mobile-bottom">
                        <?php
                            if($type == 1){echo '<span style="color:#4BE4B6;">6-GODZINNY GIVEAWAY</span>';}
                            if($type == 2){echo '<span style="color:#A020F0;">DZIENNY GIVEAWAY</span>';}
                            if($type == 3){echo '<span style="color:#F53F59;">TYGODNIOWY GIVEAWAY</span>';}
                            if($type == 4){echo '<span style="color:#dcae64;">MIESIĘCZNY GIVEAWAY</span>';}
                        ?>
                        <br/><span style="color:#aaaaaa;">Pozostały czas</span><br/>
                        <div id="giveaway-modal-content-top-time"></div>
                    </div>
                </div>
                <div id="giveaway-modal-content-middle">
                    <div id="giveaway-modal-content-middle-content">
                        <button class="giveaway-modal-content-middle-content-button" id="giveaway-button-<?php echo $type; ?>" style="background-color: 
                            <?php
                                if($type==1){echo '#4BE4B6;';}
                                if($type==2){echo '#A020F0;';}
                                if($type==3){echo '#F53F59;';}
                                if($type==4){echo '#dcae64;';}
                            ?>
                        ">
                            Dołącz do konkursu!
                        </button>
                    </div>
                </div>
                <div id="giveaway-modal-content-bottom">

                </div>
            </div>
        </div>
        <div id="giveaway-popup-php"></div>
        <script>
            $("#giveaway-button-<?php echo $type; ?>").on("click", function(){
                $("#giveaway-popup-php").load("giveaway_join.php?type=<?php echo $type; ?>");
            });
        </script>
        <?php

    }
    else
    {
        echo '<div class="errordiv">Zaloguj się!</div>';
        echo '<script>$(".errordiv").hide().fadeIn(400, "swing");</script>';
        echo '<script>$(".errordiv").on("click", function(){ $(".errordiv").remove(); });</script>';
    }

?>