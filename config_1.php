<?php
session_start();
@session_regenerate_id(true);

require('db_connect.php');
require('function.php');
require('class.php');
require('head.php');
require('withdraw.php');
require('help_disp.php');

if (isset($_SESSION['flash'])) {
  $flash_messages = $_SESSION['flash']['message'];
  $flash_type = $_SESSION['flash']['type'];
}
unset($_SESSION['flash']);

$error_messages = array();

require('header.php');
//グローバル変数として定義 
_debug('', true);
//_debug($flash_messages);
global $i;
if (!isset($_SESSION['page'])) {
  $_SESSION['page'] = 0;
}
if (!isset($_SESSION['page_mypost'])) {
  $_SESSION['page_mypost'] = 0;
}
if (!isset($_SESSION['page_testcase'])) {
  $_SESSION['page_testcase'] = 0;
}
if (!isset($_SESSION['page_userlist'])) {
  $_SESSION['page_userlist'] = 0;
}
if (!isset($_SESSION['page_follow'])) {
  $_SESSION['page_follow'] = 0;
}
if (!isset($_SESSION['page_follower'])) {
  $_SESSION['page_follower'] = 0;
}
_debug($_POST);
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

if (isset($_POST['block_testcase'])) {
  switch ($_POST['block_testcase']) {
    case '«':
      $_SESSION['page_testcase']--;
      break;
    case '»':
      $_SESSION['page_testcase']++;
      break;
    default:
      $_SESSION['page_testcase'] = $_POST['block_testcase'] - 1;
      break;
  }
}
if (isset($_POST['block_userlist'])) {
  switch ($_POST['block_userlist']) {
    case '«':
      $_SESSION['page_userlist']--;
      break;
    case '»':
      $_SESSION['page_userlist']++;
      break;
    default:
      $_SESSION['page_userlist'] = $_POST['block_userlist'] - 1;
      break;
  }
}

if (isset($_POST['block_follow'])) {
  switch ($_POST['block_follow']) {
    case '«':
      $_SESSION['page_follow']--;
      break;
    case '»':
      $_SESSION['page_follow']++;
      break;
    default:
      $_SESSION['page_follow'] = $_POST['block_follow'] - 1;
      break;
  }
}

if (isset($_POST['block_follower'])) {
  switch ($_POST['block_follower']) {
    case '«':
      $_SESSION['page_follower']--;
      break;
    case '»':
      $_SESSION['page_follower']++;
      break;
    default:
      $_SESSION['page_follower'] = $_POST['block_follower'] - 1;
      break;
  }
}

if (isset($_POST['block_mypost'])) {
  switch ($_POST['block_mypost']) {
    case '«':
      $_SESSION['page_mypost']--;
      break;
    case '»':
      $_SESSION['page_mypost']++;
      break;
    default:
      $_SESSION['page_mypost'] = $_POST['block_mypost'] - 1;
      break;
  }
}
_debug($_SESSION);