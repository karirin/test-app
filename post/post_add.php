<?php
require_once('../config.php');
?>
<body>
新規投稿画面<br />
<br />
<form method="post" action="../post/post_add_done.php" enctype="multipart/form-data">
<textarea class="textarea form-control" placeholder="投稿内容を入力ください" name="content"></textarea>
<input type="text" name="text" style="width:200px"><br />
画像を選んでください。<br />
<input type="file" name="image_name" style="width:200px"><br />
<br />
<input type="button" onclick="history.back()" value="戻る">
<input type="submit" value="OK">
</form>
</body>
<?php require_once('../footer.php'); ?>
</html>