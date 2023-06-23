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
                .dana{width:10%;float:left;text-align:center;}
                .dzialanie{width:20%;float:left;text-align:center;}
                input{width:50%;float:left;};
            </style>';
            $result = $connection->query("SELECT * FROM withdraws WHERE withdrawstatus=1 OR withdrawstatus=2");
            $wyplaty = array();
            while($wyplata = mysqli_fetch_assoc($result))
            {
                array_push($wyplaty, $wyplata);
            }
            foreach($wyplaty as $wyplata)
            {
                if(isset($_POST['submitx'.$wyplata['withdrawid']]))
                {
                    $id = $wyplata['withdrawid'];
                    if(isset($_POST['editstatusx'.$id]))
                    {
                        $status = $_POST['editstatusx'.$wyplata['withdrawid']];
                        if($status == 0)
                        {
                            $stat0_res = $connection->query("SELECT * FROM withdraws WHERE withdrawid='$id'");
                            $stat0_res = $stat0_res->fetch_assoc();
                            $itemid = $stat0_res['withdrawitemid'];
                            $connection->query("UPDATE items SET itemstatus=1 WHERE itemid='$itemid'");
                        }
                        if($status == 2)
                        {
                            $data = date('Y-m-d H:i:s');
                            $connection->query("UPDATE withdraws SET withdrawdate2='$data' WHERE withdrawid='$id'");
                        }
                        $connection->query("UPDATE withdraws SET withdrawstatus='$status' WHERE withdrawid='$id'");
                    }
                    header("Location: withdrawmanagement");
                    exit(0);
                }
                echo '<div class="rekord">';
                    echo '<div class="dana" id="idx'.$wyplata['withdrawid'].'" style="width:5%;">'.$wyplata['withdrawid'].'</div>';
                    echo '<div class="dana" id="useridx'.$wyplata['withdrawid'].'" style="width:5%;">'.$wyplata['withdrawuserid'].'</div>';
                    echo '<div class="dana" id="data1x'.$wyplata['withdrawid'].'">'.$wyplata['withdrawdate1'].'</div>';
                    echo '<div class="dana" id="data2x'.$wyplata['withdrawid'].'">'.$wyplata['withdrawdate2'].'</div>';
                    echo '<div class="dana" id="statusx'.$wyplata['withdrawid'].'" style="width:5%;">'.$wyplata['withdrawstatus'].'</div>';
                    $itemid = $wyplata['withdrawitemid'];
                    $result1 = $connection->query("SELECT * FROM items WHERE itemid='$itemid'");
                    $result1 = $result1->fetch_assoc();
                    $skinid = $result1['itemskinid'];
                    $result2 = $connection->query("SELECT * FROM skins WHERE skinid='$skinid'");
                    $result2 = $result2->fetch_assoc();
                    echo '<div class="dana" id="weaponx'.$wyplata['withdrawid'].'">'.$result2['skinname'].'</div>';
                    echo '<div class="dana" id="skinx'.$wyplata['withdrawid'].'">'.$result2['skinskin'].'</div>';
                    echo '<div class="dana" id="conditionx'.$wyplata['withdrawid'].'" style="width:5%;">'.$result1['itemcondition'].'</div>';
                    $uid = $wyplata['withdrawuserid'];
                    $result3 = $connection->query("SELECT * FROM users WHERE userid='$uid'");
                    $result3 = $result3->fetch_assoc();
                    echo '<div class="dana" id="tradeurlx'.$wyplata['withdrawid'].'" style="width:20%;">'.$result3['steamtradeurl'].'</div>';
                    echo '<div class="dzialanie" id="dzialaniex'.$wyplata['withdrawid'].'">';
                        echo '<form method="post">';
                            echo '<input type="number" name="editstatusx'.$wyplata['withdrawid'].'" placeholder="Edytuj Status">';
                            echo '<input type="submit" name="submitx'.$wyplata['withdrawid'].'" value="Edytuj">';
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