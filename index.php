<?php
require_once('config_1.php');

if (isset($_SESSION['login']) == false) :
?>

<body class="top">
    <div class="description">
        <!-- Test Appは自分のWebサービスをユーザーに<br>テストしてもらうWebサービスです。<br>
        他ユーザーのWebサービスをテストすることもできます。 -->
        <span>
            Test Appは自分のサービスをユーザーに<br>テストしてもらうサービスです。<br>
            他ユーザーのサービスをテストすることもできます。
        </span>
    </div>
    <form method="post" action="user_login/user_login_done.php">
        <div class="test_btn">
            <input type="hidden" name="name" class="user_name_input" value="test_user">
            <input type="hidden" name="pass" class="user_pass_input" value="pass">
            <input class="test_login btn btn-outline-dark" type="submit" name="test_login" value="おためしログイン">
        </div>
    </form>

    <?php else : ?>

    <body>
        <?php require("test/test_top.php"); ?>
        <?php endif; ?>
        <?php require('footer.php'); ?>
    </body>

    </html>