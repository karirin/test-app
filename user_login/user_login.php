<?php
session_start();
@session_regenerate_id(true);

require('../db_connect.php');
require('../function.php');
require('../head.php');

if(isset($_SESSION['flash'])){
  $flash_messages = $_SESSION['flash']['message'];
  $flash_type = $_SESSION['flash']['type'];
  }
unset($_SESSION['flash']);

$error_messages = array();

require('../header.php');

if(!empty($_POST)){
  require_once('user_login_check.php');
}
?>
<body>
  <div class="row">
<div class="col-6 offset-3 center">
<h2>ログイン</h2>
<form method="post"action="#">
<input type="text" name="name" class="user_name_input" placeholder="ユーザー名">
<input type="password" name="pass" class="user_pass_input" placeholder="パスワード">
<div class="flex_btn margin_top">
<input class="btn btn-outline-dark" type="submit" value="ログイン">
<input class="btn btn-outline-info" type="button" onclick="history.back()" value="戻る">
</div>
</form>
</div>
</div>
</body>
<?php require_once('../footer.php'); ?>
</html>