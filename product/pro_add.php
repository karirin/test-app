<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>coffeeapp</title>
</head>
<body>
新規投稿画面<br />
<br />
<form method="post" action="pro_add_check.php" enctype="multipart/form-data">
店名を入力してください。<br />
<input type="text" name="name" style="width:200px"><br />
住所を入力してください。<br />
<input type="text" name="address" style="width:200px"><br />
営業時間を入力してください。<br />
<input type="time" name="time_start" style="width:80px">～
<input type="time" name="time_end" style="width:80px"><br />
画像を選んでください。<br />
<input type="file" name="gazou" style="width:200px"><br />
<br />
<input type="button" onclick="history.back()" value="戻る">
<input type="submit" value="OK">
</form>
</body>
</html>