<?php 
require_once('../header.php'); 
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>coffeeapp</title>
</head>
<body>
<?php
if(isset($_SESSION['login'])==false)
{
print'ようこそ、coffeeaappへ';
}
else
{
require_once("../staff/staff_disp.php");
//require_onceだとマイページを指定して表示できない、ほかの方法がないか模索中
}
?>
</body>
</html>