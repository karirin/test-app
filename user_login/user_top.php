<body>
<?php

if(isset($_SESSION['login'])==false)
{
print '<br />';
print 'ようこそ、coffeeappへ';
}
else
{
 require_once("../user/user_disp.php");
}
?>

</body>
<?php require_once('../footer.php'); ?>
</html>
