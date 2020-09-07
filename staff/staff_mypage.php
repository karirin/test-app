<?php
$error_messages = array();

if( isset($_SESSION['flash']) ){
	$flash_messages = $_SESSION['flash']['message'];
	$flash_type = $_SESSION['flash']['type'];
  }
  unset($_SESSION['flash']);


?>
<?php if (isset($flash_messages)): ?>
      <?php foreach ((array)$flash_messages as $message): ?>
        <p class ="flash_message <?= $flash_type ?>"><?= $message?></p>
      <?php endforeach ?>
<?php endif ?>  
<?php var_dump($flash_messages);?>


<!-- ログインしたが出ない -->