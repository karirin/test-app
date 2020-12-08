<?php
session_start();
@session_regenerate_id(true);
require_once('function.php');

if( isset($_SESSION['flash']) ){
	$flash_messages = $_SESSION['flash']['message'];
	$flash_type = $_SESSION['flash']['type'];
  }
  unset($_SESSION['flash']);

  
$error_messages = array();
//グローバル変数として定義 
//_debug('',true);
?>