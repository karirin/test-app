<?php
require_once('../config.php');
require_once('../head.php');
require_once('../header.php');
?>
<body>
<div class="row">
<div class="col-8 offset-2 center">
<h2>ユーザー追加</h2>
<form method="post" action="user_add_check.php" enctype="multipart/form-data">
<div class="user_login_info">ユーザー名を入力してください。</div>
<input type="text" name="name" class="user_name_input">
<div class="user_login_info">パスワード</div>
<input type="password" name="pass">
<div class="user_login_info">パスワードをもう一度入力してください。</div>
<input type="password" name="pass2">
<div class="user_login_info">プロフィール画像を選んでください。</div>
<div class="post_btn margin_top">
<label>
  <i class="far fa-image"></i>
  <input type="file" name="image" id="my_image" accept="image/*" multiple>
</label>
</div>
  <p class="preview_img"><img class="my_preview"></p>
  <input type="button" id="my_clear" value="ファイルをクリアする">
  <div class="login_btn margin_top">
<input　class="btn btn-outline-info" type="button" onclick="history.back()" value="戻る">
<input class="btn btn-outline-dark"　type="submit" value="登録">
</div>
</form>
</body>
<?php require_once('../footer.php'); ?>
</html>