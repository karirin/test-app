<?php
require_once('../config_2.php');
require('../head.php');
require('../header.php');

if (!empty($_POST)) {
    require_once('user_login_done.php');
}
?>

<body>
    <div class="row">
        <div class="col-6 offset-3 center">
            <h2>ログイン</h2>
            <form method="post" action="#">
                <div class="user_title">ユーザー名</div>
                <input type="text" name="name" class="user_name_input form-control">
                <div class="user_title">パスワード</div>
                <input type=" password" name="pass" class="user_pass_input form-control">
                <div class="flex_btn margin_top">
                    <input class="btn btn-outline-info" type="button" onclick="history.back()" value="戻る">
                    <input class="btn btn-outline-dark" type="submit" value="ログイン">
                </div>
            </form>
        </div>
    </div>
</body>
<?php require_once('../footer.php'); ?>

</html>