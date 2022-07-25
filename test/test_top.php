<?php
require_once('../config_1.php');
$user = new User($_SESSION['user_id']);
$current_user = $user->get_user();
$i = 0;
?>
<div class="row">
    <div class="col-3 center">
        <img src="data:image/jpeg;base64,<?= $current_user['image']; ?>" class="mypage">
        <h2><?= $current_user['name']; ?></h2>
    </div>
    <div class="col-9">
        <?php
        $post = new Post(0);
        $posts = $post->get_posts('', 'all', 0);
        ?>
        <?php
        require('../test/test_list.php');
        ?>
    </div>
</div>
<?php
require('../footer.php');
?>