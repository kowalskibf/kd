<?php

    require_once 'db.php';
	require 'steamauth/steamauth.php';
	require 'steamauth/userInfo.php';

    $connection = @new mysqli($host, $db_user, $db_password, $db_name);

    if(ctype_alnum($_GET['case']))
    {
        $casename = $_GET['case'];

        $result_casb = $connection->query("SELECT * FROM cases WHERE casename='$casename'");
        $result_casb = $result_casb->fetch_assoc();
        
        if($casename == 'ESSACASE')
        {
            if(isset($_SESSION['steamid'])) { ?>
                <script>
                    $("#idopenbuttonloggedout").css("display", "none");
                </script>
                <?php if($_SESSION['gold'] >= $result_casb['caseprice']) { ?>
                        <script>
                            $("#idopenbuttondoladuj").css("display", "none");
                            $("#idopenbutton").css("display", "block");
                        </script>
                <?php } else { ?>
                        <script>
                            $("#idopenbutton").css("display", "none");
                            $("#idopenbuttondoladuj").css("display", "block");
                        </script>
                <?php } ?>
            <?php } else { ?>
                <script>
                    $("#idopenbutton").css("display", "none");
                    $("#idopenbuttondoladuj").css("display", "none");
                </script>
            <?php }
        }
        else
        {
            if(isset($_SESSION['steamid'])) { ?>
                <script>
                    $("#idopenbuttonloggedout").css("display", "none");
                </script>
                <?php if($_SESSION['balance'] >= $result_casb['caseprice']) { ?>
                        <script>
                            $("#idopenbuttondoladuj").css("display", "none");
                            $("#idopenbutton").css("display", "block");
                        </script>
                <?php } else { ?>
                        <script>
                            $("#idopenbutton").css("display", "none");
                            $("#idopenbuttondoladuj").css("display", "block");
                        </script>
                <?php } ?>
            <?php } else { ?>
                <script>
                    $("#idopenbutton").css("display", "none");
                    $("#idopenbuttondoladuj").css("display", "none");
                </script>
            <?php }
        }
    }

?>