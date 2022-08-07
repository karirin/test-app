<?php
session_start();
@session_regenerate_id(true);

require('db_connect.php');
require('function.php');
require('class.php');
require('head.php');
require('withdraw.php');
require('post_process.php');
require('help_disp.php');

if (isset($_SESSION['flash'])) {
  $flash_messages = $_SESSION['flash']['message'];
  $flash_type = $_SESSION['flash']['type'];
}
unset($_SESSION['flash']);

$error_messages = array();

require('header.php');
//グローバル変数として定義 
//_debug('', true);
//_debug($flash_messages);
global $i;
$_SESSION['page'] = 0;
if (isset($_POST['block'])) {
  switch ($_POST['block']) {
    case '«':
      $_SESSION['page']--;
      break;
    case '»':
      $_SESSION['page']++;
      break;
    default:
      $_SESSION['page'] = $_POST['block'] - 1;
      break;
  }
}