<?php
require_once('../config_1.php');

if (isset($_SESSION['login']) == false) :
?>

<body class="top">
    <div class="description">
        ユーザー同士でコミュニケーションが取れるＳＮＳとなっています。</br>
        共感できる投稿をお気に入りにしたり、お話したい相手とメッセージのやり取りなどが行えます。
    </div>
    <form method="post" action="user_login_done.php">
        <div class="flex_btn margin_top">
            <input type="hidden" name="name" class="user_name_input" value="test_user">
            <input type="hidden" name="pass" class="user_pass_input" value="pass">
            <input class="test_login btn btn-outline-dark" type="submit" name="test_login" value="テストログイン">
        </div>
        <div class="test_login_description">
            ※お試しでログインできます
        </div>
    </form>
    <?php else : ?>

    <body>
        <?php require_once("../user/user_disp.php"); ?>
        <?php endif; ?>

    </body>
    <?php require_once('../footer.php'); ?>

    </html>