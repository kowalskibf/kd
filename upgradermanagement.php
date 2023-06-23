<?php

	require_once 'db.php';
	require 'steamauth/steamauth.php';
	require 'steamauth/userInfo.php';

    $connection = @new mysqli($host, $db_user, $db_password, $db_name);
    mysqli_set_charset($connection, "utf8");

    if(isset($_SESSION['steamid']))
	{
        if($_SESSION['rank'] >= 1300)
        {
            echo '
            <meta charset="UTF-8">
            <script src="//ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
            <script src="js/jq.js"></script>';

            if(isset($_POST['gotowe']))
            {
                $result = $connection->query("SELECT * FROM skins");
                $result = $result->num_rows;
                for($i=1;$i<=$result;$i++)
                {
                    $tablica = [0, 0, 0, 0, 0];
                    for($j=1;$j<=5;$j++)
                    {
                        if(isset($_POST[$i.'x'.$j]))
                        {
                            $tablica[$j-1] = 1;
                        }
                    }
                    $wynik = $tablica[0].$tablica[1].$tablica[2].$tablica[3].$tablica[4];
                    $connection->query("UPDATE skins SET skinupgrader='$wynik' WHERE skinid='$i'");
                }
                header("Location: upgradermanagement");
                exit(0);              
            }
            echo '<style>div{width:10%;margin:0;float:left;height:20px;} .nowy{clear:both; width:100%;}</style>';
            echo '<form method="post">';
            $result = $connection->query("SELECT * FROM skins");
            $itemki = array();
            while($itemek = mysqli_fetch_assoc($result))
            {
                array_push($itemki, $itemek);
            }
            foreach($itemki as $itemek)
            {
                //$kolor = 'rgb('.rand(0, 255).', '.rand(0, 255).', '.rand(0, 255).')';
                if($itemek['rarity'] == 1){$kolor = 'rgb(176, 195, 217)';}
                if($itemek['rarity'] == 2){$kolor = 'rgb(94, 152, 217)';}
                if($itemek['rarity'] == 3){$kolor = 'rgb(75, 105, 255)';}
                if($itemek['rarity'] == 4){$kolor = 'rgb(136, 71, 255)';}
                if($itemek['rarity'] == 5){$kolor = 'rgb(211, 44, 230)';}
                if($itemek['rarity'] == 6){$kolor = 'rgb(235, 75, 75)';}
                if($itemek['rarity'] == 7){$kolor = 'rgb(228, 174, 57)';}
                echo '<div class="nowy" style="border-bottom:1px solid '.$kolor.'">';
                echo '<div>'.$itemek['skinid'].'</div>';
                echo '<div>'.$itemek['skinname'].'</div>';
                echo '<div>'.$itemek['skinskin'].'</div>';
                echo '<div>';
                if($itemek['rarity'] == 1){echo '<span style="color:rgba(176, 195, 217);">';}
                if($itemek['rarity'] == 2){echo '<span style="color:rgba(94, 152, 217);">';}
                if($itemek['rarity'] == 3){echo '<span style="color:rgba(75, 105, 255);">';}
                if($itemek['rarity'] == 4){echo '<span style="color:rgba(136, 71, 255);">';}
                if($itemek['rarity'] == 5){echo '<span style="color:rgba(211, 44, 230);">';}
                if($itemek['rarity'] == 6){echo '<span style="color:rgba(235, 75, 75);">';}
                if($itemek['rarity'] == 7){echo '<span style="color:rgba(228, 174, 57);">';}
                echo $itemek['rarity'].'</span></div>';
                $zbazy = $itemek['skinupgrader'];
                echo '<div>'; if($itemek['skinprice1'] != 0){echo '<input type="checkbox" name="'.$itemek['skinid'].'x1" id="'.$itemek['skinid'].'x1"'; if($zbazy[0] == '1'){echo 'checked';} echo '> BS ('.$itemek['skinprice1'].')';} echo '</div>';
                echo '<div>'; if($itemek['skinprice2'] != 0){echo '<input type="checkbox" name="'.$itemek['skinid'].'x2" id="'.$itemek['skinid'].'x2"'; if($zbazy[1] == '1'){echo 'checked';} echo '> WW ('.$itemek['skinprice2'].')';} echo '</div>';
                echo '<div>'; if($itemek['skinprice3'] != 0){echo '<input type="checkbox" name="'.$itemek['skinid'].'x3" id="'.$itemek['skinid'].'x3"'; if($zbazy[2] == '1'){echo 'checked';} echo '> FT ('.$itemek['skinprice3'].')';} echo '</div>';
                echo '<div>'; if($itemek['skinprice4'] != 0){echo '<input type="checkbox" name="'.$itemek['skinid'].'x4" id="'.$itemek['skinid'].'x4"'; if($zbazy[3] == '1'){echo 'checked';} echo '> MW ('.$itemek['skinprice4'].')';} echo '</div>';
                echo '<div>'; if($itemek['skinprice5'] != 0){echo '<input type="checkbox" name="'.$itemek['skinid'].'x5" id="'.$itemek['skinid'].'x5"'; if($zbazy[4] == '1'){echo 'checked';} echo '> FN ('.$itemek['skinprice5'].')';} echo '</div>';
                echo '<div><input type="checkbox" id="'.$itemek['skinid'].'"> Wszystko</div>';
                echo '<script>
                    $("#'.$itemek['skinid'].'").on("click", function(){
                        $("#'.$itemek['skinid'].'x1").attr("checked", true);
                        $("#'.$itemek['skinid'].'x2").attr("checked", true);
                        $("#'.$itemek['skinid'].'x3").attr("checked", true);
                        $("#'.$itemek['skinid'].'x4").attr("checked", true);
                        $("#'.$itemek['skinid'].'x5").attr("checked", true);
                    });    
                </script>';
                echo '</div>';


            }
            echo '<button type="submit" name="gotowe">ZAPISZ</button></form>';
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