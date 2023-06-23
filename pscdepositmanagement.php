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
            echo '<style>
                .rekord{width:100%;clear:both;}
                .dana{width:12.5%;float:left;text-align:center;}
                .dzialanie{width:37.5%;float:left;text-align:center;}
                input{width:33%;float:left;};
            </style>';
            $result = $connection->query("SELECT * FROM deposits WHERE depositmethod=2 AND depositstatus=1");
            $wplaty = array();
            while($wplata = mysqli_fetch_assoc($result))
            {
                array_push($wplaty, $wplata);
            }
            foreach($wplaty as $wplata)
            {
                if(isset($_POST['submitx'.$wplata['depositid']]))
                {
                    $id = $wplata['depositid'];
                    if(isset($_POST['editstatusx'.$id]))
                    {
                        $status = $_POST['editstatusx'.$wplata['depositid']];
                        $connection->query("UPDATE deposits SET depositstatus='$status' WHERE depositid='$id'");
                    }
                    if(isset($_POST['edithajsx'.$id]))
                    {
                        $hajs = $_POST['edithajsx'.$wplata['depositid']];
                        $result4 = $connection->query("SELECT * FROM deposits WHERE depositid='$id'");
                        $result4 = $result4->fetch_assoc();
                        $userid = $result4['deposituserid'];
                        $result5 = $connection->query("SELECT * FROM users WHERE userid='$userid'");
                        $result5 = $result5->fetch_assoc();
                        $hajs = $hajs + $result5['balance'];
                        $connection->query("UPDATE users SET balance='$hajs' WHERE userid='$userid'");
                        $refid = $result5['referraluserid'];
                        $result6 = $connection->query("SELECT * FROM users WHERE userid='$refid'");
                        $result6 = $result6->fetch_assoc();
                        $reftotal = $result6['reftotal'];
                        if($reftotal + $hajsstale <= 50000) // 1
                        {
                            $reftotalnew = $reftotal + floor(0.03 * $hajsstale);
                        }
                        else if($reftotal >= 50000 && $reftotal + $hajsstale <= 500000) // 2
                        {
                            $reftotalnew = $reftotal + floor(0.04 * $hajsstale);
                        }
                        else if($reftotal >= 500000 && $reftotal + $hajsstale <= 2000000) // 3
                        {
                            $reftotalnew = $reftotal + floor(0.05 * $hajsstale);
                        }
                        else if($reftotal >= 2000000 && $reftotal + $hajsstale <= 20000000) // 4
                        {
                            $reftotalnew = $reftotal + floor(0.06 * $hajsstale);
                        }
                        else if($reftotal >= 20000000 && $reftotal + $hajsstale <= 100000000) // 5
                        {
                            $reftotalnew = $reftotal + floor(0.07 * $hajsstale);
                        }
                        else if($reftotal >= 100000000) // 6
                        {
                            $reftotalnew = $reftotal + floor(0.08 * $hajsstale);
                        }
                        else if($reftotal < 50000 && $reftotal + $hajsstale > 50000 && $reftotal + $hajsstale <= 500000) // 1-2
                        {
                            $under500 = floor(50000 - $reftotal);
                            $over500 = floor($reftotal + $hajsstale - 50000);
                            $reftotalnew = ($under500 * 0.03) + ($over500 * 0.04);
                        }
                        else if($reftotal >= 50000 && $reftotal < 500000 && $reftotal + $hajsstale > 500000 && $reftotal + $hajsstale <= 2000000) // 2-3
                        {
                            $under5000 = floor(500000 - $reftotal);
                            $over5000 = floor($reftotal + $hajsstale - 500000);
                            $reftotalnew = ($under5000 * 0.04) + ($over5000 * 0.05);
                        }
                        else if($reftotal >= 500000 && $reftotal < 2000000 && $reftotal + $hajsstale > 2000000 && $reftotal + $hajsstale <= 200000000) // 3-4
                        {
                            $under20000 = floor(2000000 - $reftotal);
                            $over20000 = floor($reftotal + $hajsstale - 2000000);
                            $reftotalnew = ($under20000 * 0.05) + ($over20000 * 0.06);
                        }
                        else if($reftotal >= 2000000 && $reftotal < 200000000 && $reftotal + $hajsstale > 20000000 && $reftotal + $hajsstale <= 100000000) // 4-5
                        {
                            $under200000 = floor(20000000 - $reftotal);
                            $over200000 = floor($reftotal + $hajsstale - 20000000);
                            $reftotalnew = ($under200000 * 0.06) + ($over200000 * 0.07);
                        }
                        else if($reftotal >= 20000000 && $reftotal < 100000000 && $reftotal + $hajsstale > 100000000) // 5-6
                        {
                            $under1000000 = floor(100000000 - $reftotal);
                            $over1000000 = floor($reftotal + $hajsstale - 100000000);
                            $reftotalnew = ($under1000000 * 0.07) + ($over1000000 * 0.08);
                        }
                        else if($reftotal < 50000 && $reftotal + $hajsstale > 500000 && $reftotal + $hajsstale <= 2000000) // 1-3
                        {
                            $under500 = floor(50000 - $reftotal);
                            $level2 = 450000;
                            $over5k = floor($reftotal + $hajsstale - 500000);
                            $reftotalnew = ($under500 * 0.03) + ($level2 * 0.04) + ($over5k * 0.05); 
                        }
                        else if($reftotal >= 50000 && $reftotal < 500000 && $reftotal + $hajsstale > 2000000 && $reftotal + $hajsstale <= 20000000) // 2-4
                        {
                            $under5k = floor(500000 - $reftotal);
                            $level3 = 1500000;
                            $over20k = floor($reftotal + $hajsstale - 2000000);
                            $reftotalnew = ($under5k * 0.04) + ($level3 * 0.05) + ($over20k * 0.06); 
                        }
                        else if($reftotal >= 500000 && $reftotal < 2000000 && $reftotal + $hajsstale > 20000000 && $reftotal + $hajsstale <= 100000000) // 3-5
                        {
                            $under20k = floor(2000000 - $reftotal);
                            $level4 = 18000000;
                            $over200k = floor($reftotal + $hajsstale - 20000000);
                            $reftotalnew = ($under5k * 0.05) + ($level3 * 0.06) + ($over20k * 0.07); 
                        }
                        else if($reftotal >= 2000000 && $reftotal < 20000000 && $reftotal + $hajsstale > 100000000) // 4-6
                        {
                            $under200k = floor(20000000 - $reftotal);
                            $level5 = 80000000;
                            $over1m = floor($reftotal + $hajsstale - 100000000);
                            $reftotalnew = ($under5k * 0.06) + ($level3 * 0.07) + ($over20k * 0.08); 
                        }
                        else if($reftotal < 50000 && $reftotal + $hajsstale > 2000000 && $reftotal + $hajsstale <= 20000000) // 1-4
                        {
                            $under500 = floor(50000 - $reftotal);
                            $level2 = 450000;
                            $level3 = 1500000;
                            $over20k = floor($reftotal + $hajsstale - 2000000);
                            $reftotalnew = ($under500 * 0.03) + ($level2 * 0.04) + ($level3 * 0.05) + ($over20k * 0.06); 
                        }
                        else if($reftotal >= 50000 && $reftotal < 500000 && $reftotal + $hajsstale > 20000000 && $reftotal + $hajsstale <= 100000000) // 2-5
                        {
                            $under5k = floor(500000 - $reftotal);
                            $level3 = 1500000;
                            $level4 = 18000000;
                            $over200k = floor($reftotal + $hajsstale - 20000000);
                            $reftotalnew = ($under5k * 0.04) + ($level3 * 0.05) + ($level4 * 0.06) + ($over200k * 0.07);
                        }
                        else if($reftotal >= 500000 && $reftotal < 2000000 && $reftotal + $hajsstale > 100000000) // 3-6
                        {
                            $under20k = floor(2000000 - $reftotal);
                            $level4 = 18000000;
                            $level5 = 80000000;
                            $over1m = floor($reftotal + $hajsstale - 100000000);
                            $reftotalnew = ($under20k * 0.05) + ($level4 * 0.06) + ($level5 * 0.07) + ($over1m * 0.08);
                        }
                        else if($reftotal < 50000 && $reftotal + $hajsstale > 20000000 && $reftotal + $hajsstale <= 100000000) // 1-5
                        {
                            $under500 = floor(50000 - $reftotal);
                            $level2 = 450000;
                            $level3 = 1500000;
                            $level4 = 18000000;
                            $over200k = floor($reftotal + $hajsstale - 20000000);
                            $reftotalnew = ($under500 * 0.03) + ($level2 * 0.04) + ($level3 * 0.05) + ($level4 * 0.06) + ($over200k * 0.07); 
                        }
                        else if($reftotal >= 50000 && $reftotal < 500000 && $reftotal + $hajsstale > 100000000) // 2-6
                        {
                            $under5k = floor(500000 - $reftotal);
                            $level3 = 1500000;
                            $level4 = 18000000;
                            $level5 = 80000000;
                            $over1m = floor($reftotal + $hajsstale - 100000000);
                            $reftotalnew = ($under5k * 0.04) + ($level3 * 0.05) + ($level4 * 0.06) + ($level5 * 0.07) + ($over1m * 0.08); 
                        }
                        else if($reftotal < 50000 && $reftotal + $hajsstale > 100000000) // 1-6
                        {
                            $under500 = floor(50000 - $reftotal);
                            $level2 = 450000;
                            $level3 = 1500000;
                            $level4 = 18000000;
                            $level5 = 80000000;
                            $over1m = floor($reftotal + $hajsstale - 100000000);
                            $reftotalnew = ($under500 * 0.03) + ($level2 * 0.04) + ($level3 * 0.05) + ($level4 * 0.06) + ($level5 * 0.07) + ($over1m * 0.08); 
                        }
                        $reftotal = $reftotal + $hajsstale;
                        $connection->query("UPDATE users SET reftotal='$reftotal' WHERE userid='$refid'");
                        $refhajs = $result6['balance'];
                        $refhajs = $refhajs + $reftotalnew;
                        $connection->query("UPDATE users SET balance='$refhajs' WHERE userid='$refid'");
                        $totaldepo_res = $connection->query("SELECT * FROM users WHERE userid='$userid'");
                        $totaldepo_res = $totaldepo_res->fetch_assoc();
                        $totaldepo = $totaldepo_res['totaldepo'];
                        $totaldepo = $totaldepo + $hajsstale;
                        $connection->query("UPDATE users SET totaldepo='$totaldepo' WHERE userid='$userid'");
                    }
                    header("Location: pscdepositmanagement");
                    exit(0);
                }
                echo '<div class="rekord">';
                    echo '<div class="dana" id="idx'.$wplata['depositid'].'">'.$wplata['depositid'].'</div>';
                    echo '<div class="dana" id="useridx'.$wplata['depositid'].'">'.$wplata['deposituserid'].'</div>';
                    echo '<div class="dana" id="datax'.$wplata['depositid'].'">'.$wplata['depositdate1'].'</div>';
                    echo '<div class="dana" id="statusx'.$wplata['depositid'].'">'.$wplata['depositstatus'].'</div>';
                    echo '<div class="dana" id="kodx'.$wplata['depositid'].'">'.$wplata['depositpsccode'].'</div>';
                    echo '<div class="dzialanie" id="dzialaniex'.$wplata['depositid'].'">';
                        echo '<form method="post">';
                            echo '<input type="number" name="editstatusx'.$wplata['depositid'].'" placeholder="Edytuj Status">';
                            echo '<input type="number" name="edithajsx'.$wplata['depositid'].'" placeholder="Dodaj Hajs">';
                            echo '<input type="submit" name="submitx'.$wplata['depositid'].'" value="Edytuj">';
                        echo '</form>';
                    echo '</div>';
                echo '</div>';
            }
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
