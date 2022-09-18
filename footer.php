<?php
if (isset($_SESSION['login']) == true) :
    require('profile.php');
    require('post_process.php');
    require('testcase_process.php');
?>
<script src=" https://code.jquery.com/jquery-3.4.1.min.js "></script>
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/themes/smoothness/jquery-ui.css" />
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.12.0/jquery-ui.min.js"></script>
<script src="/js/common.js"></script>
<script src="/js/test.js"></script>
<?php
endif;
?>