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
            $result = $connection->query("SELECT * FROM cases");
            $iloscskrzynek = $result->num_rows;
            for($i=1;$i<=$iloscskrzynek;$i++)
            {
                $result = $connection->query("SELECT * FROM cases WHERE caseid='$i'");
                $result = $result->fetch_assoc();
                $caseitems = $result['caseitems'];
                $casechances1 = $result['casechances1'];
                $casechances2 = $result['casechances2'];
                $casechances3 = $result['casechances3'];
                $dlugosc = strlen($caseitems);
                $iloscitemkow = $dlugosc/4;
                if(isset($_POST['name'.$i]))
                {
                    $img = $_POST['name'.$i];
                    $connection->query("UPDATE cases SET casename='$img' WHERE caseid='$i'");
                    header("Location: casesmanagement");
                    exit(0);
                }
                if(isset($_POST['price'.$i]))
                {
                    $cena = ((intval($_POST['zlote'.$i]) * 100) + intval($_POST['grosze'.$i]));
                    $connection->query("UPDATE cases SET caseprice='$cena' WHERE caseid='$i'");
                    header("Location: casesmanagement");
                    exit(0);
                }
                if(isset($_POST['img'.$i]))
                {
                    $img = $_POST['img'.$i];
                    $connection->query("UPDATE cases SET caseimg='$img' WHERE caseid='$i'");
                    header("Location: casesmanagement");
                    exit(0);
                }
                if(isset($_POST['save'.$i]))
                {
                    $nadpisz0 = '';
                    $nadpisz1 = '';
                    $nadpisz2 = '';
                    $nadpisz3 = '';
                    for($j=0;$j<$iloscitemkow;$j++)
                    {
                        $nadpiszskinid = $_POST['skinid'.$i.'x'.$j];
                        $nadpiszskinszansa11 = $_POST['chance11x'.$i.'x'.$j];
                        $nadpiszskinszansa12 = $_POST['chance12x'.$i.'x'.$j];
                        $nadpiszskinszansa13 = $_POST['chance13x'.$i.'x'.$j];
                        $nadpiszskinszansa14 = $_POST['chance14x'.$i.'x'.$j];
                        $nadpiszskinszansa15 = $_POST['chance15x'.$i.'x'.$j];
                        $nadpiszskinszansa21 = $_POST['chance21x'.$i.'x'.$j];
                        $nadpiszskinszansa22 = $_POST['chance22x'.$i.'x'.$j];
                        $nadpiszskinszansa23 = $_POST['chance23x'.$i.'x'.$j];
                        $nadpiszskinszansa24 = $_POST['chance24x'.$i.'x'.$j];
                        $nadpiszskinszansa25 = $_POST['chance25x'.$i.'x'.$j];
                        $nadpiszskinszansa31 = $_POST['chance31x'.$i.'x'.$j];
                        $nadpiszskinszansa32 = $_POST['chance32x'.$i.'x'.$j];
                        $nadpiszskinszansa33 = $_POST['chance33x'.$i.'x'.$j];
                        $nadpiszskinszansa34 = $_POST['chance34x'.$i.'x'.$j];
                        $nadpiszskinszansa35 = $_POST['chance35x'.$i.'x'.$j];
                        if($nadpiszskinszansa11 != 0)$nadpiszskinszansa11 = $nadpiszskinszansa11 - 1;
                        if($nadpiszskinszansa12 != 0)$nadpiszskinszansa12 = $nadpiszskinszansa12 - 1;
                        if($nadpiszskinszansa13 != 0)$nadpiszskinszansa13 = $nadpiszskinszansa13 - 1;
                        if($nadpiszskinszansa14 != 0)$nadpiszskinszansa14 = $nadpiszskinszansa14 - 1;
                        if($nadpiszskinszansa15 != 0)$nadpiszskinszansa15 = $nadpiszskinszansa15 - 1;
                        if($nadpiszskinszansa21 != 0)$nadpiszskinszansa21 = $nadpiszskinszansa21 - 1;
                        if($nadpiszskinszansa22 != 0)$nadpiszskinszansa22 = $nadpiszskinszansa22 - 1;
                        if($nadpiszskinszansa23 != 0)$nadpiszskinszansa23 = $nadpiszskinszansa23 - 1;
                        if($nadpiszskinszansa24 != 0)$nadpiszskinszansa24 = $nadpiszskinszansa24 - 1;
                        if($nadpiszskinszansa25 != 0)$nadpiszskinszansa25 = $nadpiszskinszansa25 - 1;
                        if($nadpiszskinszansa31 != 0)$nadpiszskinszansa31 = $nadpiszskinszansa31 - 1;
                        if($nadpiszskinszansa32 != 0)$nadpiszskinszansa32 = $nadpiszskinszansa32 - 1;
                        if($nadpiszskinszansa33 != 0)$nadpiszskinszansa33 = $nadpiszskinszansa33 - 1;
                        if($nadpiszskinszansa34 != 0)$nadpiszskinszansa34 = $nadpiszskinszansa34 - 1;
                        if($nadpiszskinszansa35 != 0)$nadpiszskinszansa35 = $nadpiszskinszansa35 - 1;
                        if($nadpiszskinid < 10){$nadpiszskinid = '000'.$nadpiszskinid;}
                        else if($nadpiszskinid < 100){$nadpiszskinid = '00'.$nadpiszskinid;}
                        else if($nadpiszskinid < 1000){$nadpiszskinid = '0'.$nadpiszskinid;}
                        if($nadpiszskinszansa11 == 0){$nadpiszskinszansa11 = 'xxxxxxx';}
                        else if($nadpiszskinszansa11 < 10){$nadpiszskinszansa11 = '000000'.$nadpiszskinszansa11;}
                        else if($nadpiszskinszansa11 < 100){$nadpiszskinszansa11 = '00000'.$nadpiszskinszansa11;}
                        else if($nadpiszskinszansa11 < 1000){$nadpiszskinszansa11 = '0000'.$nadpiszskinszansa11;}
                        else if($nadpiszskinszansa11 < 10000){$nadpiszskinszansa11 = '000'.$nadpiszskinszansa11;}
                        else if($nadpiszskinszansa11 < 100000){$nadpiszskinszansa11 = '00'.$nadpiszskinszansa11;}
                        else if($nadpiszskinszansa11 < 1000000){$nadpiszskinszansa11 = '0'.$nadpiszskinszansa11;}
                        if($nadpiszskinszansa12 == 0){$nadpiszskinszansa12 = 'xxxxxxx';}
                        else if($nadpiszskinszansa12 < 10){$nadpiszskinszansa12 = '000000'.$nadpiszskinszansa12;}
                        else if($nadpiszskinszansa12 < 100){$nadpiszskinszansa12 = '00000'.$nadpiszskinszansa12;}
                        else if($nadpiszskinszansa12 < 1000){$nadpiszskinszansa12 = '0000'.$nadpiszskinszansa12;}
                        else if($nadpiszskinszansa12 < 10000){$nadpiszskinszansa12 = '000'.$nadpiszskinszansa12;}
                        else if($nadpiszskinszansa12 < 100000){$nadpiszskinszansa12 = '00'.$nadpiszskinszansa12;}
                        else if($nadpiszskinszansa12 < 1000000){$nadpiszskinszansa12 = '0'.$nadpiszskinszansa12;}
                        if($nadpiszskinszansa13 == 0){$nadpiszskinszansa13 = 'xxxxxxx';}
                        else if($nadpiszskinszansa13 < 10){$nadpiszskinszansa13 = '000000'.$nadpiszskinszansa13;}
                        else if($nadpiszskinszansa13 < 100){$nadpiszskinszansa13 = '00000'.$nadpiszskinszansa13;}
                        else if($nadpiszskinszansa13 < 1000){$nadpiszskinszansa13 = '0000'.$nadpiszskinszansa13;}
                        else if($nadpiszskinszansa13 < 10000){$nadpiszskinszansa13 = '000'.$nadpiszskinszansa13;}
                        else if($nadpiszskinszansa13 < 100000){$nadpiszskinszansa13 = '00'.$nadpiszskinszansa13;}
                        else if($nadpiszskinszansa13 < 1000000){$nadpiszskinszansa13 = '0'.$nadpiszskinszansa13;}
                        if($nadpiszskinszansa14 == 0){$nadpiszskinszansa14 = 'xxxxxxx';}
                        else if($nadpiszskinszansa14 < 10){$nadpiszskinszansa14 = '000000'.$nadpiszskinszansa14;}
                        else if($nadpiszskinszansa14 < 100){$nadpiszskinszansa14 = '00000'.$nadpiszskinszansa14;}
                        else if($nadpiszskinszansa14 < 1000){$nadpiszskinszansa14 = '0000'.$nadpiszskinszansa14;}
                        else if($nadpiszskinszansa14 < 10000){$nadpiszskinszansa14 = '000'.$nadpiszskinszansa14;}
                        else if($nadpiszskinszansa14 < 100000){$nadpiszskinszansa14 = '00'.$nadpiszskinszansa14;}
                        else if($nadpiszskinszansa14 < 1000000){$nadpiszskinszansa14 = '0'.$nadpiszskinszansa14;}
                        if($nadpiszskinszansa15 == 0){$nadpiszskinszansa15 = 'xxxxxxx';}
                        else if($nadpiszskinszansa15 < 10){$nadpiszskinszansa15 = '000000'.$nadpiszskinszansa15;}
                        else if($nadpiszskinszansa15 < 100){$nadpiszskinszansa15 = '00000'.$nadpiszskinszansa15;}
                        else if($nadpiszskinszansa15 < 1000){$nadpiszskinszansa15 = '0000'.$nadpiszskinszansa15;}
                        else if($nadpiszskinszansa15 < 10000){$nadpiszskinszansa15 = '000'.$nadpiszskinszansa15;}
                        else if($nadpiszskinszansa15 < 100000){$nadpiszskinszansa15 = '00'.$nadpiszskinszansa15;}
                        else if($nadpiszskinszansa15 < 1000000){$nadpiszskinszansa15 = '0'.$nadpiszskinszansa15;}
                        if($nadpiszskinszansa21 == 0){$nadpiszskinszansa21 = 'xxxxxxx';}
                        else if($nadpiszskinszansa21 < 10){$nadpiszskinszansa21 = '000000'.$nadpiszskinszansa21;}
                        else if($nadpiszskinszansa21 < 100){$nadpiszskinszansa21 = '00000'.$nadpiszskinszansa21;}
                        else if($nadpiszskinszansa21 < 1000){$nadpiszskinszansa21 = '0000'.$nadpiszskinszansa21;}
                        else if($nadpiszskinszansa21 < 10000){$nadpiszskinszansa21 = '000'.$nadpiszskinszansa21;}
                        else if($nadpiszskinszansa21 < 100000){$nadpiszskinszansa21 = '00'.$nadpiszskinszansa21;}
                        else if($nadpiszskinszansa21 < 1000000){$nadpiszskinszansa21 = '0'.$nadpiszskinszansa21;}
                        if($nadpiszskinszansa22 == 0){$nadpiszskinszansa22 = 'xxxxxxx';}
                        else if($nadpiszskinszansa22 < 10){$nadpiszskinszansa22 = '000000'.$nadpiszskinszansa22;}
                        else if($nadpiszskinszansa22 < 100){$nadpiszskinszansa22 = '00000'.$nadpiszskinszansa22;}
                        else if($nadpiszskinszansa22 < 1000){$nadpiszskinszansa22 = '0000'.$nadpiszskinszansa22;}
                        else if($nadpiszskinszansa22 < 10000){$nadpiszskinszansa22 = '000'.$nadpiszskinszansa22;}
                        else if($nadpiszskinszansa22 < 100000){$nadpiszskinszansa22 = '00'.$nadpiszskinszansa22;}
                        else if($nadpiszskinszansa22 < 1000000){$nadpiszskinszansa22 = '0'.$nadpiszskinszansa22;}
                        if($nadpiszskinszansa23 == 0){$nadpiszskinszansa23 = 'xxxxxxx';}
                        else if($nadpiszskinszansa23 < 10){$nadpiszskinszansa23 = '000000'.$nadpiszskinszansa23;}
                        else if($nadpiszskinszansa23 < 100){$nadpiszskinszansa23 = '00000'.$nadpiszskinszansa23;}
                        else if($nadpiszskinszansa23 < 1000){$nadpiszskinszansa23 = '0000'.$nadpiszskinszansa23;}
                        else if($nadpiszskinszansa23 < 10000){$nadpiszskinszansa23 = '000'.$nadpiszskinszansa23;}
                        else if($nadpiszskinszansa23 < 100000){$nadpiszskinszansa23 = '00'.$nadpiszskinszansa23;}
                        else if($nadpiszskinszansa23 < 1000000){$nadpiszskinszansa23 = '0'.$nadpiszskinszansa23;}
                        if($nadpiszskinszansa24 == 0){$nadpiszskinszansa24 = 'xxxxxxx';}
                        else if($nadpiszskinszansa24 < 10){$nadpiszskinszansa24 = '000000'.$nadpiszskinszansa24;}
                        else if($nadpiszskinszansa24 < 100){$nadpiszskinszansa24 = '00000'.$nadpiszskinszansa24;}
                        else if($nadpiszskinszansa24 < 1000){$nadpiszskinszansa24 = '0000'.$nadpiszskinszansa24;}
                        else if($nadpiszskinszansa24 < 10000){$nadpiszskinszansa24 = '000'.$nadpiszskinszansa24;}
                        else if($nadpiszskinszansa24 < 100000){$nadpiszskinszansa24 = '00'.$nadpiszskinszansa24;}
                        else if($nadpiszskinszansa24 < 1000000){$nadpiszskinszansa24 = '0'.$nadpiszskinszansa24;}
                        if($nadpiszskinszansa25 == 0){$nadpiszskinszansa25 = 'xxxxxxx';}
                        else if($nadpiszskinszansa25 < 10){$nadpiszskinszansa25 = '000000'.$nadpiszskinszansa25;}
                        else if($nadpiszskinszansa25 < 100){$nadpiszskinszansa25 = '00000'.$nadpiszskinszansa25;}
                        else if($nadpiszskinszansa25 < 1000){$nadpiszskinszansa25 = '0000'.$nadpiszskinszansa25;}
                        else if($nadpiszskinszansa25 < 10000){$nadpiszskinszansa25 = '000'.$nadpiszskinszansa25;}
                        else if($nadpiszskinszansa25 < 100000){$nadpiszskinszansa25 = '00'.$nadpiszskinszansa25;}
                        else if($nadpiszskinszansa25 < 1000000){$nadpiszskinszansa25 = '0'.$nadpiszskinszansa25;}
                        if($nadpiszskinszansa31 == 0){$nadpiszskinszansa31 = 'xxxxxxx';}
                        else if($nadpiszskinszansa31 < 10){$nadpiszskinszansa31 = '000000'.$nadpiszskinszansa31;}
                        else if($nadpiszskinszansa31 < 100){$nadpiszskinszansa31 = '00000'.$nadpiszskinszansa31;}
                        else if($nadpiszskinszansa31 < 1000){$nadpiszskinszansa31 = '0000'.$nadpiszskinszansa31;}
                        else if($nadpiszskinszansa31 < 10000){$nadpiszskinszansa31 = '000'.$nadpiszskinszansa31;}
                        else if($nadpiszskinszansa31 < 100000){$nadpiszskinszansa31 = '00'.$nadpiszskinszansa31;}
                        else if($nadpiszskinszansa31 < 1000000){$nadpiszskinszansa31 = '0'.$nadpiszskinszansa31;}
                        if($nadpiszskinszansa32 == 0){$nadpiszskinszansa32 = 'xxxxxxx';}
                        else if($nadpiszskinszansa32 < 10){$nadpiszskinszansa32 = '000000'.$nadpiszskinszansa32;}
                        else if($nadpiszskinszansa32 < 100){$nadpiszskinszansa32 = '00000'.$nadpiszskinszansa32;}
                        else if($nadpiszskinszansa32 < 1000){$nadpiszskinszansa32 = '0000'.$nadpiszskinszansa32;}
                        else if($nadpiszskinszansa32 < 10000){$nadpiszskinszansa32 = '000'.$nadpiszskinszansa32;}
                        else if($nadpiszskinszansa32 < 100000){$nadpiszskinszansa32 = '00'.$nadpiszskinszansa32;}
                        else if($nadpiszskinszansa32 < 1000000){$nadpiszskinszansa32 = '0'.$nadpiszskinszansa32;}
                        if($nadpiszskinszansa33 == 0){$nadpiszskinszansa33 = 'xxxxxxx';}
                        else if($nadpiszskinszansa33 < 10){$nadpiszskinszansa33 = '000000'.$nadpiszskinszansa33;}
                        else if($nadpiszskinszansa33 < 100){$nadpiszskinszansa33 = '00000'.$nadpiszskinszansa33;}
                        else if($nadpiszskinszansa33 < 1000){$nadpiszskinszansa33 = '0000'.$nadpiszskinszansa33;}
                        else if($nadpiszskinszansa33 < 10000){$nadpiszskinszansa33 = '000'.$nadpiszskinszansa33;}
                        else if($nadpiszskinszansa33 < 100000){$nadpiszskinszansa33 = '00'.$nadpiszskinszansa33;}
                        else if($nadpiszskinszansa33 < 1000000){$nadpiszskinszansa33 = '0'.$nadpiszskinszansa33;}
                        if($nadpiszskinszansa34 == 0){$nadpiszskinszansa34 = 'xxxxxxx';}
                        else if($nadpiszskinszansa34 < 10){$nadpiszskinszansa34 = '000000'.$nadpiszskinszansa34;}
                        else if($nadpiszskinszansa34 < 100){$nadpiszskinszansa34 = '00000'.$nadpiszskinszansa34;}
                        else if($nadpiszskinszansa34 < 1000){$nadpiszskinszansa34 = '0000'.$nadpiszskinszansa34;}
                        else if($nadpiszskinszansa34 < 10000){$nadpiszskinszansa34 = '000'.$nadpiszskinszansa34;}
                        else if($nadpiszskinszansa34 < 100000){$nadpiszskinszansa34 = '00'.$nadpiszskinszansa34;}
                        else if($nadpiszskinszansa34 < 1000000){$nadpiszskinszansa34 = '0'.$nadpiszskinszansa34;}
                        if($nadpiszskinszansa35 == 0){$nadpiszskinszansa35 = 'xxxxxxx';}
                        else if($nadpiszskinszansa35 < 10){$nadpiszskinszansa35 = '000000'.$nadpiszskinszansa35;}
                        else if($nadpiszskinszansa35 < 100){$nadpiszskinszansa35 = '00000'.$nadpiszskinszansa35;}
                        else if($nadpiszskinszansa35 < 1000){$nadpiszskinszansa35 = '0000'.$nadpiszskinszansa35;}
                        else if($nadpiszskinszansa35 < 10000){$nadpiszskinszansa35 = '000'.$nadpiszskinszansa35;}
                        else if($nadpiszskinszansa35 < 100000){$nadpiszskinszansa35 = '00'.$nadpiszskinszansa35;}
                        else if($nadpiszskinszansa35 < 1000000){$nadpiszskinszansa35 = '0'.$nadpiszskinszansa35;}
                        $nadpisz0 = $nadpisz0.$nadpiszskinid;
                        $nadpisz1 = $nadpisz1.$nadpiszskinszansa11.$nadpiszskinszansa12.$nadpiszskinszansa13.$nadpiszskinszansa14.$nadpiszskinszansa15;
                        $nadpisz2 = $nadpisz2.$nadpiszskinszansa21.$nadpiszskinszansa22.$nadpiszskinszansa23.$nadpiszskinszansa24.$nadpiszskinszansa25;
                        $nadpisz3 = $nadpisz3.$nadpiszskinszansa31.$nadpiszskinszansa32.$nadpiszskinszansa33.$nadpiszskinszansa34.$nadpiszskinszansa35;
                    }
                    $connection->query("UPDATE cases SET caseitems='$nadpisz0' WHERE caseid='$i'");
                    $connection->query("UPDATE cases SET casechances1='$nadpisz1' WHERE caseid='$i'");
                    $connection->query("UPDATE cases SET casechances2='$nadpisz2' WHERE caseid='$i'");
                    $connection->query("UPDATE cases SET casechances3='$nadpisz3' WHERE caseid='$i'");
                    header("Location: casesmanagement");
                    exit(0);
                }
                if(isset($_POST['zamien'.$i]))
                {
                    $skin1 = $_POST['zamien'.$i.'x1'];
                    $skin1 = intval($skin1) - 1;
                    $skin2 = $_POST['zamien'.$i.'x2'];
                    $skin2 = intval($skin2) - 1;
                    $skin1items = '';
                    $skin2items = '';
                    $skin1chances1 = '';
                    $skin2chances1 = '';
                    $skin1chances2 = '';
                    $skin2chances2 = '';
                    for($k=0;$k<35;$k++)
                    {
                        if($k<4)
                        {
                            $skin1items = $skin1items.$caseitems[(4*$skin1) + $k];
                            $skin2items = $skin2items.$caseitems[(4*$skin2) + $k];
                        }
                        $skin1chances1 = $skin1chances1.$casechances1[(35*$skin1) + $k];
                        $skin1chances2 = $skin1chances2.$casechances2[(35*$skin1) + $k];
                        $skin1chances3 = $skin1chances3.$casechances3[(35*$skin1) + $k];
                        $skin2chances1 = $skin2chances1.$casechances1[(35*$skin2) + $k];
                        $skin2chances2 = $skin2chances2.$casechances2[(35*$skin2) + $k];
                        $skin2chances3 = $skin2chances3.$casechances3[(35*$skin2) + $k];
                    }
                    $caseitemsnew = $caseitems;
                    $casechances1new = $casechances1;
                    $casechances2new = $casechances2;
                    $casechances3new = $casechances3;
                    for($k=0;$k<35;$k++)
                    {
                        if($k<4)
                        {
                            $caseitemsnew[(4*$skin1) + $k] = $skin2items[$k];
                            $caseitemsnew[(4*$skin2) + $k] = $skin1items[$k];
                        }
                        $casechances1new[(35*$skin1) + $k] = $skin2chances1[$k];
                        $casechances1new[(35*$skin2) + $k] = $skin1chances1[$k];
                        $casechances2new[(35*$skin1) + $k] = $skin2chances2[$k];
                        $casechances2new[(35*$skin2) + $k] = $skin1chances2[$k];
                        $casechances3new[(35*$skin1) + $k] = $skin2chances3[$k];
                        $casechances3new[(35*$skin2) + $k] = $skin1chances3[$k];
                    }
                    $connection->query("UPDATE cases SET caseitems='$caseitemsnew' WHERE caseid='$i'");
                    $connection->query("UPDATE cases SET casechances1='$casechances1new' WHERE caseid='$i'");
                    $connection->query("UPDATE cases SET casechances2='$casechances2new' WHERE caseid='$i'");
                    $connection->query("UPDATE cases SET casechances3='$casechances3new' WHERE caseid='$i'");
                    header("Location: casesmanagement");
                    exit(0);
                }
                if(isset($_POST['dodaj'.$i]))
                {
                    $nadpisz = $connection->query("SELECT * FROM cases WHERE caseid='$i'");
                    $nadpisz = $nadpisz->fetch_assoc();
                    $nadpisz0 = $nadpisz['caseitems'];
                    $nadpisz1 = $nadpisz['casechances1'];
                    $nadpisz2 = $nadpisz['casechances2'];
                    $nadpisz3 = $nadpisz['casechances3'];
                    $nadpisz0 = $nadpisz0.'0000';
                    $nadpisz1 = $nadpisz1.'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
                    $nadpisz2 = $nadpisz2.'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
                    $nadpisz3 = $nadpisz3.'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
                    $connection->query("UPDATE cases SET caseitems='$nadpisz0' WHERE caseid='$i'");
                    $connection->query("UPDATE cases SET casechances1='$nadpisz1' WHERE caseid='$i'");
                    $connection->query("UPDATE cases SET casechances2='$nadpisz2' WHERE caseid='$i'");
                    $connection->query("UPDATE cases SET casechances3='$nadpisz3' WHERE caseid='$i'");
                    header("Location: casesmanagement.php");
                    exit(0);
                }
                if(isset($_POST['usun'.$i]))
                {
                    $caseitemsnew = '';
                    $casechances1new = '';
                    $casechances2new = '';
                    $casechances3new = '';
                    for($j=0;$j<$iloscitemkow-1;$j++)
                    {
                        for($k=0;$k<35;$k++)
                        {
                            if($k<4)
                            {
                                $caseitemsnew = $caseitemsnew.$caseitems[(4*$j) + $k];
                            }
                            $casechances1new = $casechances1new.$casechances1[(35*$j) + $k];
                            $casechances2new = $casechances2new.$casechances2[(35*$j) + $k];
                            $casechances3new = $casechances3new.$casechances3[(35*$j) + $k];
                        }
                    }
                    $connection->query("UPDATE cases SET caseitems='$caseitemsnew' WHERE caseid='$i'");
                    $connection->query("UPDATE cases SET casechances1='$casechances1new' WHERE caseid='$i'");
                    $connection->query("UPDATE cases SET casechances2='$casechances2new' WHERE caseid='$i'");
                    $connection->query("UPDATE cases SET casechances3='$casechances3new' WHERE caseid='$i'");
                    header("Location: casesmanagement");
                    exit(0);
                }
                echo '<form method="post" autocomplete="off">';
                echo 'Name: ';
                echo '<input type="text" name="name'.$i.'" value="'.$result['casename'].'" style="width: 200px;">';
                echo '<input type="submit" value="Zapisz" name="namesave'.$i.'"/></form>';
                echo '<form method="post" autocomplete="off">';
                echo 'Price: ';
                echo '<input type="number" name="zlote'.$i.'" value="'.(floor($result['caseprice']/100)).'" style="width: 60px;">';
                echo '<input type="number" name="grosze'.$i.'" value="'.($result['caseprice']%100).'" style="width: 60px;">';
                echo '<input type="submit" value="Zapisz" name="price'.$i.'"/></form>';
                echo '<form method="post" autocomplete="off">';
                echo 'Image: ';
                echo '<input type="text" name="img'.$i.'" value="'.$result['caseimg'].'" style="width: 200px;">';
                echo '<input type="submit" value="Zapisz" name="imgsave'.$i.'"/></form>';
                echo '<form method="post" autocomplete="off">';
                $sumaprocentow1 = 0;
                $sumaprocentow2 = 0;
                $sumaprocentow3 = 0;
                $zwrot1 = 0;
                $zwrot2 = 0;
                $zwrot3 = 0;
                for($j=0;$j<$iloscitemkow;$j++)
                {
                    $skinid = intval($caseitems[(4 * $j)].$caseitems[(4 * $j) + 1].$caseitems[(4 * $j) + 2].$caseitems[(4 * $j) + 3]);
                    $result2 = $connection->query("SELECT * FROM skins WHERE skinid='$skinid'");
                    $result2 = $result2->fetch_assoc();
                    if(is_numeric($casechances1[(35 * $j)])){$chance11 = (intval($casechances1[(35 * $j)].$casechances1[(35 * $j) + 1].$casechances1[(35 * $j) + 2].$casechances1[(35 * $j) + 3].$casechances1[(35 * $j) + 4].$casechances1[(35 * $j) + 5].$casechances1[(35 * $j) + 6]) + 1);}else{$chance11 = 0;}
                    if(is_numeric($casechances1[(35 * $j) + 7])){$chance12 = (intval($casechances1[(35 * $j) + 7].$casechances1[(35 * $j) + 8].$casechances1[(35 * $j) + 9].$casechances1[(35 * $j) + 10].$casechances1[(35 * $j) + 11].$casechances1[(35 * $j) + 12].$casechances1[(35 * $j) + 13]) + 1);}else{$chance12 = 0;}
                    if(is_numeric($casechances1[(35 * $j) + 14])){$chance13 = (intval($casechances1[(35 * $j) + 14].$casechances1[(35 * $j) + 15].$casechances1[(35 * $j) + 16].$casechances1[(35 * $j) + 17].$casechances1[(35 * $j) + 18].$casechances1[(35 * $j) + 19].$casechances1[(35 * $j) + 20]) + 1);}else{$chance13 = 0;}
                    if(is_numeric($casechances1[(35 * $j) + 21])){$chance14 = (intval($casechances1[(35 * $j) + 21].$casechances1[(35 * $j) + 22].$casechances1[(35 * $j) + 23].$casechances1[(35 * $j) + 24].$casechances1[(35 * $j) + 25].$casechances1[(35 * $j) + 26].$casechances1[(35 * $j) + 27]) + 1);}else{$chance14 = 0;}
                    if(is_numeric($casechances1[(35 * $j) + 28])){$chance15 = (intval($casechances1[(35 * $j) + 28].$casechances1[(35 * $j) + 29].$casechances1[(35 * $j) + 30].$casechances1[(35 * $j) + 31].$casechances1[(35 * $j) + 32].$casechances1[(35 * $j) + 33].$casechances1[(35 * $j) + 34]) + 1);}else{$chance15 = 0;}
                    if(is_numeric($casechances2[(35 * $j)])){$chance21 = (intval($casechances2[(35 * $j)].$casechances2[(35 * $j) + 1].$casechances2[(35 * $j) + 2].$casechances2[(35 * $j) + 3].$casechances2[(35 * $j) + 4].$casechances2[(35 * $j) + 5].$casechances2[(35 * $j) + 6]) + 1);}else{$chance21 = 0;}
                    if(is_numeric($casechances2[(35 * $j) + 7])){$chance22 = (intval($casechances2[(35 * $j) + 7].$casechances2[(35 * $j) + 8].$casechances2[(35 * $j) + 9].$casechances2[(35 * $j) + 10].$casechances2[(35 * $j) + 11].$casechances2[(35 * $j) + 12].$casechances2[(35 * $j) + 13]) + 1);}else{$chance22 = 0;}
                    if(is_numeric($casechances2[(35 * $j) + 14])){$chance23 = (intval($casechances2[(35 * $j) + 14].$casechances2[(35 * $j) + 15].$casechances2[(35 * $j) + 16].$casechances2[(35 * $j) + 17].$casechances2[(35 * $j) + 18].$casechances2[(35 * $j) + 19].$casechances2[(35 * $j) + 20]) + 1);}else{$chance23 = 0;}
                    if(is_numeric($casechances2[(35 * $j) + 21])){$chance24 = (intval($casechances2[(35 * $j) + 21].$casechances2[(35 * $j) + 22].$casechances2[(35 * $j) + 23].$casechances2[(35 * $j) + 24].$casechances2[(35 * $j) + 25].$casechances2[(35 * $j) + 26].$casechances2[(35 * $j) + 27]) + 1);}else{$chance24 = 0;}
                    if(is_numeric($casechances2[(35 * $j) + 28])){$chance25 = (intval($casechances2[(35 * $j) + 28].$casechances2[(35 * $j) + 29].$casechances2[(35 * $j) + 30].$casechances2[(35 * $j) + 31].$casechances2[(35 * $j) + 32].$casechances2[(35 * $j) + 33].$casechances2[(35 * $j) + 34]) + 1);}else{$chance25 = 0;}
                    if(is_numeric($casechances3[(35 * $j)])){$chance31 = (intval($casechances3[(35 * $j)].$casechances3[(35 * $j) + 1].$casechances3[(35 * $j) + 2].$casechances3[(35 * $j) + 3].$casechances3[(35 * $j) + 4].$casechances3[(35 * $j) + 5].$casechances3[(35 * $j) + 6]) + 1);}else{$chance31 = 0;}
                    if(is_numeric($casechances3[(35 * $j) + 7])){$chance32 = (intval($casechances3[(35 * $j) + 7].$casechances3[(35 * $j) + 8].$casechances3[(35 * $j) + 9].$casechances3[(35 * $j) + 10].$casechances3[(35 * $j) + 11].$casechances3[(35 * $j) + 12].$casechances3[(35 * $j) + 13]) + 1);}else{$chance32 = 0;}
                    if(is_numeric($casechances3[(35 * $j) + 14])){$chance33 = (intval($casechances3[(35 * $j) + 14].$casechances3[(35 * $j) + 15].$casechances3[(35 * $j) + 16].$casechances3[(35 * $j) + 17].$casechances3[(35 * $j) + 18].$casechances3[(35 * $j) + 19].$casechances3[(35 * $j) + 20]) + 1);}else{$chance33 = 0;}
                    if(is_numeric($casechances3[(35 * $j) + 21])){$chance34 = (intval($casechances3[(35 * $j) + 21].$casechances3[(35 * $j) + 22].$casechances3[(35 * $j) + 23].$casechances3[(35 * $j) + 24].$casechances3[(35 * $j) + 25].$casechances3[(35 * $j) + 26].$casechances3[(35 * $j) + 27]) + 1);}else{$chance34 = 0;}
                    if(is_numeric($casechances3[(35 * $j) + 28])){$chance35 = (intval($casechances3[(35 * $j) + 28].$casechances3[(35 * $j) + 29].$casechances3[(35 * $j) + 30].$casechances3[(35 * $j) + 31].$casechances3[(35 * $j) + 32].$casechances3[(35 * $j) + 33].$casechances3[(35 * $j) + 34]) + 1);}else{$chance35 = 0;}
                    echo ($j+1).' Skin ID: ';
                    echo '<input type="number" name="skinid'.$i.'x'.$j.'" value="'.$skinid.'" style="width: 60px;">';
                    echo ' '.$result2['skinname'].' | '.$result2['skinskin'];
                    echo '<br/>BS 1 ';
                    echo '<input type="number" name="chance11x'.$i.'x'.$j.'" value="'.$chance11.'" style="width: 80px;">';
                    echo '/10000000 ('.(100 * $chance11 / 10000000).'%)';
                    if($chance11 != 0){$zwrot1 = $zwrot1 + (($result2['skinprice1'] * $chance11) / 1000000000);}
                    echo ' WW 1 ';
                    echo '<input type="number" name="chance12x'.$i.'x'.$j.'" value="'.$chance12.'" style="width: 80px;">';
                    echo '/10000000 ('.(100 * $chance12 / 10000000).'%)';
                    if($chance12 != 0){$zwrot1 = $zwrot1 + (($result2['skinprice2'] * $chance12) / 1000000000);}
                    echo ' FT 1 ';
                    echo '<input type="number" name="chance13x'.$i.'x'.$j.'" value="'.$chance13.'" style="width: 80px;">';
                    echo '/10000000 ('.(100 * $chance13 / 10000000).'%)';
                    if($chance13 != 0){$zwrot1 = $zwrot1 + (($result2['skinprice3'] * $chance13) / 1000000000);}
                    echo ' MW 1 ';
                    echo '<input type="number" name="chance14x'.$i.'x'.$j.'" value="'.$chance14.'" style="width: 80px;">';
                    echo '/10000000 ('.(100 * $chance14 / 10000000).'%)';
                    if($chance14 != 0){$zwrot1 = $zwrot1 + (($result2['skinprice4'] * $chance14) / 1000000000);}
                    echo ' FN 1 ';
                    echo '<input type="number" name="chance15x'.$i.'x'.$j.'" value="'.$chance15.'" style="width: 80px;">';
                    echo '/10000000 ('.(100 * $chance15 / 10000000).'%)';
                    if($chance15 != 0){$zwrot1 = $zwrot1 + (($result2['skinprice5'] * $chance15) / 1000000000);}
                    echo '<br/>BS 2 ';
                    echo '<input type="number" name="chance21x'.$i.'x'.$j.'" value="'.$chance21.'" style="width: 80px;">';
                    echo '/10000000 ('.(100 * $chance21 / 10000000).'%)';
                    if($chance21 != 0){$zwrot2 = $zwrot2 + (($result2['skinprice1'] * $chance21) / 1000000000);}
                    echo ' WW 2 ';
                    echo '<input type="number" name="chance22x'.$i.'x'.$j.'" value="'.$chance22.'" style="width: 80px;">';
                    echo '/10000000 ('.(100 * $chance22 / 10000000).'%)';
                    if($chance22 != 0){$zwrot2 = $zwrot2 + (($result2['skinprice2'] * $chance22) / 1000000000);}
                    echo ' FT 2 ';
                    echo '<input type="number" name="chance23x'.$i.'x'.$j.'" value="'.$chance23.'" style="width: 80px;">';
                    echo '/10000000 ('.(100 * $chance23 / 10000000).'%)';
                    if($chance23 != 0){$zwrot2 = $zwrot2 + (($result2['skinprice3'] * $chance23) / 1000000000);}
                    echo ' MW 2 ';
                    echo '<input type="number" name="chance24x'.$i.'x'.$j.'" value="'.$chance24.'" style="width: 80px;">';
                    echo '/10000000 ('.(100 * $chance24 / 10000000).'%)';
                    if($chance24 != 0){$zwrot2 = $zwrot2 + (($result2['skinprice4'] * $chance24) / 1000000000);}
                    echo ' FN 2 ';
                    echo '<input type="number" name="chance25x'.$i.'x'.$j.'" value="'.$chance25.'" style="width: 80px;">';
                    echo '/10000000 ('.(100 * $chance25 / 10000000).'%)';
                    if($chance25 != 0){$zwrot2 = $zwrot2 + (($result2['skinprice5'] * $chance25) / 1000000000);}
                    echo '<br/>BS 3 ';
                    echo '<input type="number" name="chance31x'.$i.'x'.$j.'" value="'.$chance31.'" style="width: 80px;">';
                    echo '/10000000 ('.(100 * $chance31 / 10000000).'%)';
                    if($chance31 != 0){$zwrot3 = $zwrot3 + (($result2['skinprice1'] * $chance31) / 1000000000);}
                    echo ' WW 3 ';
                    echo '<input type="number" name="chance32x'.$i.'x'.$j.'" value="'.$chance32.'" style="width: 80px;">';
                    echo '/10000000 ('.(100 * $chance32 / 10000000).'%)';
                    if($chance32 != 0){$zwrot3 = $zwrot3 + (($result2['skinprice2'] * $chance32) / 1000000000);}
                    echo ' FT 3 ';
                    echo '<input type="number" name="chance33x'.$i.'x'.$j.'" value="'.$chance33.'" style="width: 80px;">';
                    echo '/10000000 ('.(100 * $chance33 / 10000000).'%)';
                    if($chance33 != 0){$zwrot3 = $zwrot3 + (($result2['skinprice3'] * $chance33) / 1000000000);}
                    echo ' MW 3 ';
                    echo '<input type="number" name="chance34x'.$i.'x'.$j.'" value="'.$chance34.'" style="width: 80px;">';
                    echo '/10000000 ('.(100 * $chance34 / 10000000).'%)';
                    if($chance34 != 0){$zwrot3 = $zwrot3 + (($result2['skinprice4'] * $chance34) / 1000000000);}
                    echo ' FN 3 ';
                    echo '<input type="number" name="chance35x'.$i.'x'.$j.'" value="'.$chance35.'" style="width: 80px;">';
                    echo '/10000000 ('.(100 * $chance35 / 10000000).'%)<br/>';
                    if($chance35 != 0){$zwrot3 = $zwrot3 + (($result2['skinprice5'] * $chance35) / 1000000000);}
                    $sumaprocentow1 = $sumaprocentow1 + $chance11 + $chance12 + $chance13 + $chance14 + $chance15;
                    $sumaprocentow2 = $sumaprocentow2 + $chance21 + $chance22 + $chance23 + $chance24 + $chance25;
                    $sumaprocentow3 = $sumaprocentow3 + $chance31 + $chance32 + $chance33 + $chance34 + $chance35;
                }
                echo 'Suma procentow 1: '.($sumaprocentow1/100000).'% ';
                echo 'Suma procentow 2: '.($sumaprocentow2/100000).'% ';
                echo 'Suma procentow 3: '.($sumaprocentow3/100000).'%<br/>';
                echo 'Zwrot 1: '.round($zwrot1, 2).' ('.round(((10000 * $zwrot1) / $result['caseprice']), 2).'%)<br/>';
                echo 'Zwrot 2: '.round($zwrot2, 2).' ('.round(((10000 * $zwrot2) / $result['caseprice']), 2).'%)<br/>';
                echo 'Zwrot 3: '.round($zwrot3, 2).' ('.round(((10000 * $zwrot3) / $result['caseprice']), 2).'%)<br/>';
                echo '<input type="submit" value="Zapisz" name="save'.$i.'"/></form>';
                echo '<form method="post" autocomplete="off">';
                echo 'Zamien miejscem skina numer ';
                echo '<input type="number" name="zamien'.$i.'x1" style="width: 60px;">';
                echo ' ze skinem numer ';
                echo '<input type="number" name="zamien'.$i.'x2" style="width: 60px;">';
                echo '<input type="submit" value="Zamien" name="zamien'.$i.'"/></form>';
                echo '<form method="post" autocomplete="off">';
                echo '<input type="submit" value="Dodaj skina" name="dodaj'.$i.'"/></form>';
                echo '<form method="post" autocomplete="off">';;
                echo '<input type="submit" value="Usun ostatniego skina" name="usun'.$i.'"/></form>';
            }
            if(isset($_POST['addcase']))
            {
                $connection->query("INSERT INTO cases VALUES (NULL, '', '', 100, '', '', '', '')");
                header("Location: casesmanagement");
                exit(0);
            }
            echo '<form method="post" autocomplete="off">';
            echo '<input type="submit" value="Dodaj skrzynke" name="addcase"/></form>';
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