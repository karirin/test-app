<?php
function set_flash($type,$message){
	$_SESSION['flash']['type'] = "flash_${type}";
	$_SESSION['flash']['message'] = $message;
}
?>