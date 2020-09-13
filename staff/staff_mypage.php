<?php require_once('../function.php'); ?>

<div class="count_label">お気に入り</div>
<span class="count_num"><?= current(get_user_count('favorite',$_SESSION['staff_code'])) ?></span>