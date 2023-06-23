<?php

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

    require_once 'db.php';
    require 'steamauth/steamauth.php';
    require 'steamauth/userInfo.php';

    $connection = @new mysqli($host, $db_user, $db_password, $db_name);
    mysqli_set_charset($connection, "utf8");

    if(isset($_SESSION['steamid']))
    {
        ?>
        <div id="deposit-skin-after-top">
            Aktualny depozyt
        </div>
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
                        echo '<span style="color:#F53F59;">Błąd: Prywatny ekwipunek, zmień <a href="https://steamcommunity.com/id/me/edit/settings" target="_blank" style="color:#4BE4B6;">widoczność ekwipunku</a> Steam na publiczną!</span>';
                    }
                    else if($result_step['depositstatus'] == 32)
                    {
                        echo '<span style="color:#F53F59;">Błąd: Niepoprawny adres wymiany Steam (<a href="profile" target="_blank" style="color:#4BE4B6;">TradeURL</a>)!</span>';
                    }
                    else if($result_step['depositstatus'] == 33)
                    {
                        echo '<span style="color:#F53F59;">Błąd: Przedmiot niedostępny na wymianę!</span>';
                    }
                    else if($result_step['depositstatus'] == 34)
                    {
                        echo '<span style="color:#F53F59;">Błąd: Oferta wymiany odrzucona!</span>';
                    }
                    else if($result_step['depositstatus'] == 35)
                    {
                        echo '<span style="color:#F53F59;">Błąd: Brak możliwości wysłania oferty wymiany!</span>';
                    }
                    else if($result_step['depositstatus'] == 36)
                    {
                        echo '<span style="color:#F53F59;">Błąd: Unknown error!</span>';
                    }
                    else if($result_step['depositstatus'] == 37)
                    {
                        echo '<span style="color:#F53F59;">Błąd: Brak możliwości wymiany!</span>';
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

            <?php
        }
        else
        {
            echo '<script>
                odswiezanie_tak = 0;
                clearInterval(interwal);
                window.location = "doladuj";
            </script>';
        }
    }

?>




                                            