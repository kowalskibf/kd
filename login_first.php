<?php

    require 'steamauth/steamauth.php';

    echo '<div style="margin:auto;width:100%;margin-top:200px;color:white;font-size:30px;font-family:Cairo;text-align:center;">';
    echo 'You need to login to access this page!<br/>';
    echo '<a href="?login">';
    loginbutton_login_to_proceed();
    echo '</a>';
    echo '</div>';

?>