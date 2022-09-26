<?php
require_once('config_1.php');

if (isset($_SESSION['login']) == false) :
?>

<body class="top">
    <div class="description">
        Test Appは自分のサービスをユーザーに<br>テストしてもらうサービスです。<br>
        他ユーザーのサービスをテストすることもできます。
    </div>
    <form method="post" action="user_login/user_login_done.php">
        <div class="flex_btn margin_top">
            <input type="hidden" name="name" class="user_name_input" value="test_user">
            <input type="hidden" name="pass" class="user_pass_input" value="pass">
            <input class="test_login btn btn-outline-dark" type="submit" name="test_login" value="test login">
        </div>
    </form>

    <?php else : ?>

    <body>
        <?php require("test/test_top.php"); ?>
        <?php endif; ?>

    </body>
    <?php require('footer.php'); ?>

    </html>