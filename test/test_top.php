<?php
require_once('../config_1.php');
$user = new User($_SESSION['user_id']);
if (isset($_GET['page_id']) && $_GET['page_id'] != 'current_user') {
    $user = new User($_GET['page_id']);
    $current_user = $user->get_user();
} else {
    $user = new User($_SESSION['user_id']);
    $current_user = $user->get_user();
}
$test = new Test(0);
$get_goodtest_count = $test->get_goodtest_count($current_user['id']);
$i = 0;
?>
<div class="row">
    <div class="col-3 center">
        <img src="data:image/jpeg;base64,<?= $current_user['image']; ?>" class="mypage">
        <h2><?= $current_user['name']; ?></h2>
        <input type="hidden" class="current_user_id" value="<?= $_SESSION['user_id'] ?>">
        <input type="hidden" value="<?= $current_user['id'] ?>">
        <?php if ($current_user['id'] != $_SESSION['user_id']) : ?>
        <?php if ($user->check_follow($_SESSION['user_id'], $current_user['id'])) : ?>
        <button class="follow_btn border_white btn following" type="button" name="follow"><i
                class="fas fa-user-plus"></i><span id="follow_label">フォロー解除</span></button>
        <?php else : ?>
        <button class="follow_btn border_white btn" type="button" name="follow"><i class="fas fa-user-plus"></i>
            <span id="follow_label">フォローする</span></button>
        <?php endif; ?>
        <?php endif; ?>
        <div class="row">
            <div class="col-6">
                <a href="../user/user_list.php?type=follows" style="color: #000;" class="a_follow_count">
                    フォロー<span class="follow_count"
                        style="margin-left: 0.5rem;"><?php print '' . current($user->get_user_count('follow', $current_user['id'])) . ''; ?></span>
                </a>
            </div>
            <div class="col-6">
                <a href="../user/user_list.php?type=followers" style="color: #000;" class="a_follower_count">
                    フォロワー<span class="follower_count"
                        style="margin-left: 0.5rem;"><?php print '' . current($user->get_user_count('follower', $current_user['id'])) . ''; ?></span>
                </a>
            </div>
            <div style="text-align:center;width:100%;margin-top: 1rem;"><i class="fab fa-tumblr"
                    style="margin-right:1rem;font-size:1.5rem;"></i><i class="fas fa-times"
                    style="margin-right: 1rem;font-size: 1.3rem;"></i><span
                    style="font-size: 1.5rem;"><?= $get_goodtest_count[0]['count(*)']; ?></span>
            </div>
        </div>
    </div>
    <div class="col-9" style="text-align: center;">
        <ul class="nav nav-tabs">
            <li class="nav-item"><a href="../user_login/user_top.php?page_type=all"
                    class="nav-link post_tab all active">すべての投稿</a></li>
            <li class="nav-item"><a href="../user_login/user_top.php?page_type=my_post"
                    class="nav-link post_tab my_post">自分の投稿</a></li>
            <li class="nav-item"><a href="../user_login/user_top.php?page_type=testcase"
                    class="nav-link post_tab testcase">テストケースを記載した投稿</a></li>
        </ul>
        <?php
        $post = new Post(0);
        $posts = $post->get_posts($current_user['id'], $_GET['page_type'], 0);
        require('../test/test_list.php');
        ?>

    </div>
    <?php
    require('../footer.php');
    ?>