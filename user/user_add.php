<?php require_once('../head.php'); ?>
<body>
ユーザー追加<br />
<br />
<form method="post" action="user_add_check.php">
ユーザー名を入力してください。<br />
<input type="text" name="name" style="width:200px"><br />
パスワードを入力してください。<br />
<input type="password" name="pass" style="width:100px"><br />
パスワードをもう一度入力してください。<br />
<input type="password" name="pass2" style="width:100px"><br />
<br />
<input type="button" onclick="history.back()" value="戻る">
<input type="submit" value="OK">
</form>
</body>
</html>