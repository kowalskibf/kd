<?php

    require_once 'db.php';
	require 'steamauth/steamauth.php';
	require 'steamauth/userInfo.php';

    $connection = @new mysqli($host, $db_user, $db_password, $db_name);
    mysqli_set_charset($connection, "utf8");

    if(isset($_SESSION['userid']) == false)
    {
        header("Location: index");
    }

    if(isset($_SESSION['userid']))
    {
        if($_SESSION['rank'] > 1000)
        {
            $result = $connection->query("SELECT * FROM giveaways");
            $result = $result->num_rows;
            if(isset($_POST['submit0']))
            {
                $v1 = $_POST['gatype0'];
                $v2 = $_POST['gatime1x0'];
                $v2 = strtotime($v2);
                $v3 = $_POST['gatime2x0'];
                $v3 = strtotime($v3);
                $v4 = $_POST['gaskin0'];
                $v5 = $_POST['gacond0'];
                $v6 = $_POST['gawinner0'];
                $connection->query("INSERT INTO giveaways VALUES (NULL, '$v1', '$v2', '$v3', '$v4', '$v5', '$v6')");
                header("Location: giveawaysmanagement");
                exit(0);
            }
            for($i=1;$i<=$result;$i++)
            {
                if(isset($_POST['submit'.$i]))
                {
                    $v1 = $_POST['gatype'.$i];
                    $v2 = $_POST['gatime1x'.$i];
                    $v2 = strtotime($v2);
                    $v3 = $_POST['gatime2x'.$i];
                    $v3 = strtotime($v3);
                    $v4 = $_POST['gaskin'.$i];
                    $v5 = $_POST['gacond'.$i];
                    $v6 = $_POST['gawinner'.$i];
                    $connection->query("UPDATE giveaways SET giveawaytype='$v1' WHERE giveawayid='$i'");
                    $connection->query("UPDATE giveaways SET giveawaytime1='$v2' WHERE giveawayid='$i'");
                    $connection->query("UPDATE giveaways SET giveawaytime2='$v3' WHERE giveawayid='$i'");
                    $connection->query("UPDATE giveaways SET giveawayskin='$v4' WHERE giveawayid='$i'");
                    $connection->query("UPDATE giveaways SET giveawaycondition='$v5' WHERE giveawayid='$i'");
                    $connection->query("UPDATE giveaways SET giveawaywinneruserid='$v6' WHERE giveawayid='$i'");
                    header("Location: giveawaysmanagement");
                    exit(0);
                }
            }
            echo '<style>
                body{font-family:Arial, sans-serif;font-weight:600;}
                input{border:none;background:none;text-align:center;font-family:Arial, sans-serif;font-weight:600;}
                select{border:none;background:none;text-align:center;font-family:Arial, sans-serif;font-weight:600;}
                *:focus {outline: none;}
                .togglediv{
                    padding-top:8px;padding-bottom:8px;border-radius:8px;border:2px solid black;
                    cursor:pointer;text-align:center;margin:4px;display:block;
                }
                .singlega{clear:both;height:8px;display:block;}
                .singlegainfo{float:left;width:12.5%;text-align:center;display:block;}
                .gabutton{cursor:pointer;border:2px solid black;border-radius:4px;width:100%;}
            </style>';
            echo '<script src="//ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
            <script src="js/jq.js"></script>';
            $czas = time();
            $result1 = $connection->query("SELECT * FROM giveaways WHERE giveawaytime2<'$czas' ORDER BY giveawaytime2 DESC");
            $result2 = $connection->query("SELECT * FROM giveaways WHERE giveawaytime1<'$czas' AND giveawaytime2>'$czas' ORDER BY giveawaytype ASC");
            $result3 = $connection->query("SELECT * FROM giveaways WHERE giveawaytime1>'$czas' ORDER BY giveawaytime1 ASC");
            $giveaway1 = array();
            $giveaway2 = array();
            $giveaway3 = array();
            while($itemek = mysqli_fetch_assoc($result1))
            {
                array_push($giveaway1, $itemek);
            }
            while($itemek = mysqli_fetch_assoc($result2))
            {
                array_push($giveaway2, $itemek);
            }
            while($itemek = mysqli_fetch_assoc($result3))
            {
                array_push($giveaway3, $itemek);
            }
            echo '<form method="post" autocomplete="off">';
                echo '<div class="singlega">';
                    echo '<div class="singlegainfo">';
                        echo $result+1;
                    echo '</div>';
                    echo '<div class="singlegainfo">';
                        echo '<select name="gatype0">';
                            echo '<option value=1 selected="selected">6-godzinny</option>';
                            echo '<option value=2>dzienny</option>';
                            echo '<option value=3>tygodniowy</option>';
                            echo '<option value=4>miesięczny</option>';
                        echo '</select>';
                    echo '</div>';
                    echo '<div class="singlegainfo">';
                        echo '<input type="text" name="gatime1x0" placeholder="Data rozpoczęcia">';
                    echo '</div>';
                    echo '<div class="singlegainfo">';
                        echo '<input type="text" name="gatime2x0" placeholder="Data zakończenia">';
                    echo '</div>';
                    echo '<div class="singlegainfo">';
                        echo '<input type="text" name="gaskin0" placeholder="Skin">';
                    echo '</div>';
                    echo '<div class="singlegainfo">';
                        echo '<input type="text" name="gacond0" placeholder="Stan">';
                    echo '</div>';
                    echo '<div class="singlegainfo">';
                    echo '<input type="text" name="gawinner0" placeholder="Zwycięzca">';
                    echo '</div>';
                    echo '<div class="singlegainfo">';
                        echo '<button type="submit" class="gabutton" name="submit0">Dodaj giveaway</button>';
                    echo '</div>';
                echo '</div>';
            echo '</form>';
            echo '<div id="toggle1" class="togglediv">
                Zakończone
            </div>';
            echo '<div id="give1">';
            foreach($giveaway1 as $ga)
            {
                echo '<form method="post" autocomplete="off">';
                    echo '<div class="singlega">';
                        echo '<div class="singlegainfo">';
                            echo '<input type="text" name="gaid'.$ga['giveawayid'].'" value="'.$ga['giveawayid'].'">';
                        echo '</div>';
                        echo '<div class="singlegainfo">';
                            $type = $ga['giveawaytype'];
                            echo '<select name="gatype'.$ga['giveawayid'].'">';
                                echo '<option value=1'; if($type==1){echo ' selected="selected"';} echo '>6-godzinny</option>';
                                echo '<option value=2'; if($type==2){echo ' selected="selected"';} echo '>dzienny</option>';
                                echo '<option value=3'; if($type==3){echo ' selected="selected"';} echo '>tygodniowy</option>';
                                echo '<option value=4'; if($type==4){echo ' selected="selected"';} echo '>miesięczny</option>';
                            echo '</select>';
                        echo '</div>';
                        echo '<div class="singlegainfo">';
                            echo '<input type="text" name="gatime1x'.$ga['giveawayid'].'" value="'.date('Y-m-d H:i:s', $ga['giveawaytime1']).'">';
                        echo '</div>';
                        echo '<div class="singlegainfo">';
                            echo '<input type="text" name="gatime2x'.$ga['giveawayid'].'" value="'.date('Y-m-d H:i:s', $ga['giveawaytime2']).'">';
                        echo '</div>';
                        echo '<div class="singlegainfo">';
                            echo '<input type="text" name="gaskin'.$ga['giveawayid'].'" value="'.$ga['giveawayskin'].'">';
                        echo '</div>';
                        echo '<div class="singlegainfo">';
                            echo '<input type="text" name="gacond'.$ga['giveawayid'].'" value="'.$ga['giveawaycondition'].'">';
                        echo '</div>';
                        echo '<div class="singlegainfo">';
                        echo '<input type="text" name="gawinner'.$ga['giveawayid'].'" value="'.$ga['giveawaywinneruserid'].'">';
                        echo '</div>';
                        echo '<div class="singlegainfo">';
                            echo '<button type="submit" class="gabutton" name="submit'.$ga['giveawayid'].'">Zapisz</button>';
                        echo '</div>';
                    echo '</div>';
                echo '</form>';
            }
            echo '</div>';
            echo '<div id="toggle2" class="togglediv">
                Trwające
            </div>';
            echo '<div id="give2">';
            foreach($giveaway2 as $ga)
            {
                echo '<form method="post" autocomplete="off">';
                    echo '<div class="singlega">';
                        echo '<div class="singlegainfo">';
                            echo '<input type="text" name="gaid'.$ga['giveawayid'].'" value="'.$ga['giveawayid'].'">';
                        echo '</div>';
                        echo '<div class="singlegainfo">';
                            $type = $ga['giveawaytype'];
                            echo '<select name="gatype'.$ga['giveawayid'].'">';
                                echo '<option value=1'; if($type==1){echo ' selected="selected"';} echo '>6-godzinny</option>';
                                echo '<option value=2'; if($type==2){echo ' selected="selected"';} echo '>dzienny</option>';
                                echo '<option value=3'; if($type==3){echo ' selected="selected"';} echo '>tygodniowy</option>';
                                echo '<option value=4'; if($type==4){echo ' selected="selected"';} echo '>miesięczny</option>';
                            echo '</select>';
                        echo '</div>';
                        echo '<div class="singlegainfo">';
                            echo '<input type="text" name="gatime1x'.$ga['giveawayid'].'" value="'.date('Y-m-d H:i:s', $ga['giveawaytime1']).'">';
                        echo '</div>';
                        echo '<div class="singlegainfo">';
                            echo '<input type="text" name="gatime2x'.$ga['giveawayid'].'" value="'.date('Y-m-d H:i:s', $ga['giveawaytime2']).'">';
                        echo '</div>';
                        echo '<div class="singlegainfo">';
                            echo '<input type="text" name="gaskin'.$ga['giveawayid'].'" value="'.$ga['giveawayskin'].'">';
                        echo '</div>';
                        echo '<div class="singlegainfo">';
                            echo '<input type="text" name="gacond'.$ga['giveawayid'].'" value="'.$ga['giveawaycondition'].'">';
                        echo '</div>';
                        echo '<div class="singlegainfo">';
                        echo '<input type="text" name="gawinner'.$ga['giveawayid'].'" value="'.$ga['giveawaywinneruserid'].'">';
                        echo '</div>';
                        echo '<div class="singlegainfo">';
                            echo '<button type="submit" class="gabutton" name="submit'.$ga['giveawayid'].'">Zapisz</button>';
                        echo '</div>';
                    echo '</div>';
                echo '</form>';
            }
            echo '</div>';
            echo '<div id="toggle3" class="togglediv">
                Nadchodzące
            </div>';
            echo '<div id="give3">';
            foreach($giveaway3 as $ga)
            {
                echo '<form method="post" autocomplete="off">';
                    echo '<div class="singlega">';
                        echo '<div class="singlegainfo">';
                            echo '<input type="text" name="gaid'.$ga['giveawayid'].'" value="'.$ga['giveawayid'].'">';
                        echo '</div>';
                        echo '<div class="singlegainfo">';
                            $type = $ga['giveawaytype'];
                            echo '<select name="gatype'.$ga['giveawayid'].'">';
                                echo '<option value=1'; if($type==1){echo ' selected="selected"';} echo '>6-godzinny</option>';
                                echo '<option value=2'; if($type==2){echo ' selected="selected"';} echo '>dzienny</option>';
                                echo '<option value=3'; if($type==3){echo ' selected="selected"';} echo '>tygodniowy</option>';
                                echo '<option value=4'; if($type==4){echo ' selected="selected"';} echo '>miesięczny</option>';
                            echo '</select>';
                        echo '</div>';
                        echo '<div class="singlegainfo">';
                            echo '<input type="text" name="gatime1x'.$ga['giveawayid'].'" value="'.date('Y-m-d H:i:s', $ga['giveawaytime1']).'">';
                        echo '</div>';
                        echo '<div class="singlegainfo">';
                            echo '<input type="text" name="gatime2x'.$ga['giveawayid'].'" value="'.date('Y-m-d H:i:s', $ga['giveawaytime2']).'">';
                        echo '</div>';
                        echo '<div class="singlegainfo">';
                            echo '<input type="text" name="gaskin'.$ga['giveawayid'].'" value="'.$ga['giveawayskin'].'">';
                        echo '</div>';
                        echo '<div class="singlegainfo">';
                            echo '<input type="text" name="gacond'.$ga['giveawayid'].'" value="'.$ga['giveawaycondition'].'">';
                        echo '</div>';
                        echo '<div class="singlegainfo">';
                        echo '<input type="text" name="gawinner'.$ga['giveawayid'].'" value="'.$ga['giveawaywinneruserid'].'">';
                        echo '</div>';
                        echo '<div class="singlegainfo">';
                            echo '<button type="submit" class="gabutton" name="submit'.$ga['giveawayid'].'">Zapisz</button>';
                        echo '</div>';
                    echo '</div>';
                echo '</form>';
            }
            echo '</div>';
            echo '<script>
                $("#toggle1").on("click", function(){
                    $("#give1").toggle();
                });
                $("#toggle2").on("click", function(){
                    $("#give2").toggle();
                });
                $("#toggle3").on("click", function(){
                    $("#give3").toggle();
                });
                $("#give1").hide();
            </script>';
        }
        else
        {
            header("Location: index");
        }
    }
    else
    {
        header("Location: index");
    }

?>
