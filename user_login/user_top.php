<?php 
require_once('../config.php');
require_once('../head.php'); 
require_once('../header.php');
require_once('../post_process.php');
?>
<body>
<?php

if (isset($_SESSION['id'])) {
  $current_user = get_user($_SESSION['id']);
}else{
  $current_user = 'guest';
}

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
