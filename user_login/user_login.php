<?php
require_once('../config.php');
if(!empty($_POST)){
  require_once('user_login_check.php');
}
require_once('../head.php');
require_once('../header.php');
?>
<body>
  <div class="row">
<div class="col-8 offset-2 center">
<h2>ユーザーログイン</h2>
<form method="post"action="#">
<div class="user_login_info">ユーザー名</div>
<input type="text" name="name" class="user_name_input">
<div class="user_login_info">パスワード</div>
<input type="password" name="pass" class="user_pass_input">
<div class="login_btn margin_top">
<input class="btn btn-outline-dark" type="submit" value="ログイン">
<input class="btn btn-outline-info" type="button" onclick="history.back()" value="戻る">
</div>
</form>
</div>
</div>
</body>
<?php require_once('../footer.php'); ?>
</html>