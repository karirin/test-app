<?php
require_once('../config.php');
if(!empty($_POST)){
  require_once('user_login_check.php');
}
require_once('../head.php');
require_once('../header.php');
?>
<body>
<h2 class="center margin_top">ユーザーログイン</h2>
<form method="post"action="#">
ユーザー名
<input type="text" name="name">
パスワード
<input type="password" name="pass">

<input type="button" onclick="history.back()" value="戻る">
<input type="submit" value="ログイン">
</form>
</body>
<?php require_once('../footer.php'); ?>
</html>