<?php
require_once('../config.php');
if(!empty($_POST)){
  require_once('user_login_check.php');
}
require_once('../head.php');
require_once('../header.php');
?>
<body>
スタッフログイン<br />
<?php if (isset($flash_messages)): ?>
      <?php foreach ((array)$flash_messages as $message): ?>
        <p class ="flash_message <?= $flash_type ?>"><?= $message?></p>
      <?php endforeach ?>
<?php endif ?>
<br />
<form method="post"action="#">
ユーザーコード<br />
<input type="text" name="id"><br />
パスワード<br />
<input type="password" name="pass"><br />
<br />
<input type="button" onclick="history.back()" value="戻る">
<input type="submit" value="ログイン">
</form>
</body>
<?php require_once('../footer.php'); ?>
</html>