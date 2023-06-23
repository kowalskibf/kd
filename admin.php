<?php

	require_once 'db.php';
	require 'steamauth/steamauth.php';
	require 'steamauth/userInfo.php';

    $connection = @new mysqli($host, $db_user, $db_password, $db_name);
    mysqli_set_charset($connection, "utf8");

    if(isset($_SESSION['steamid']))
	{
        if($_SESSION['rank'] == 1337)
        {
            ?>
            <style>
                .toplink
                {
                    float: left;
                    width: 22%;
                    margin: 1%;
                    border: 2px solid lime;
                    border-radius: 8px;
                    padding-top: 20px;
                    padding-bottom: 20px;
                    text-align: center;
                    font-family: Arial, sans-serif;
                    color: black;
                }
            </style>
            <div style="margin:auto;width:100%;max-width:1500px;">
                <a href="casesmanagement">
                    <div class="toplink">
                        CASES MANAGEMENT
                    </div>
                </a>
                <a href="upgradermanagement">
                    <div class="toplink">
                        UPGRADER MANAGEMENT
                    </div>
                </a>
                <a href="skindepositmanagement">
                    <div class="toplink">
                        SKIN DEPOSIT MANAGEMENT
                    </div>
                </a>
                <a href="pscdepositmanagement">
                    <div class="toplink">
                        PSC DEPOSIT MANAGEMENT
                    </div>
                </a>
                <a href="giveawaysmanagement">
                    <div class="toplink">
                        GIVEAWAYS MANAGEMENT
                    </div>
                </a>
                <a href="withdrawmanagement">
                    <div class="toplink">
                        WITHDRAW MANAGEMENT
                    </div>
                </a>
                <a href="upgrader_db_sort_desc">
                    <div class="toplink">
                        UPGRADER SORT DESC
                    </div>
                </a>
                <a href="upgrader_db_sort_asc">
                    <div class="toplink">
                        UPGRADER SORT ASC
                    </div>
                </a>
            </div>
            <?php
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