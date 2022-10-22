<?php
if (isset($_SESSION['login']) == true) :
    require('profile.php');
    require('post_process.php');
    require('testcase_process.php');
?>
<div class="footer">
    <a href="https://forms.gle/eLx24ykodQaRKqiV9">お問い合わせ</a> / <a href="../privacy_policy.php">プライバシーポリシー</a>
</div>
<script src=" https://code.jquery.com/jquery-3.4.1.min.js "></script>
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/themes/smoothness/jquery-ui.css" />
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.12.0/jquery-ui.min.js"></script>
<script src="/js/common.js"></script>
<script src="/js/test.js"></script>
<?php
endif;
?>