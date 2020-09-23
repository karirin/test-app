<?php 
require_once('../header.php');
require_once('../head.php'); 
require_once('../config.php');
?>
<script src=" https://code.jquery.com/jquery-3.4.1.min.js "></script>
<script src="../js/user_page.js"></script>
<body>
<?php if (isset($flash_messages)): ?>
      <?php foreach ((array)$flash_messages as $message): ?>
        <p class ="flash_message <?= $flash_type ?>"><?= $message?></p>
      <?php endforeach ?>
<?php endif ?>
<?php

if (isset($_SESSION['id'])) {
  $current_user = get_user($_SESSION['id']);
}else{
sajlkasjjfalskj
}

if(isset($_SESSION['login'])==false)
{
print '<br />';
print 'ようこそ、coffeeappへ';
}
else
{
 require_once("../user/user_mypage.php");
}
?>

</body>
</html>
