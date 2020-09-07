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
<?php require_once('../config.php');?>
<?php
if(isset($_SESSION['login'])==false)
{
print'ようこそ、coffeeaappへ';
}
else
{
require_once("../staff/staff_mypage.php");
}
?>
</body>
</html>
