<?php
require_once('../config.php');
require_once('../head.php');
require_once('../header.php');
?>
<body>
コメント画面<br />
<br />
<?php $post_id=$_GET['post_id']; ?>
<form method="post" action="comment_add_check.php" enctype="multipart/form-data">
コメント内容を入力ください。<br />
<input type="text" name="text" style="width:200px"><br />
画像を選んでください。<br />
<input type="file" name="image" style="width:200px"><br />
<br />
<input type="button" onclick="history.back()" value="戻る">
<input type="hidden" name="id" value="<?= $post_id ?>">
<input type="submit" value="OK">
</form>
</body>
<?php require_once('../footer.php'); ?>
</html>