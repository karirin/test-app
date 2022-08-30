<?php
require_once('../config_1.php');
$user = new User($_SESSION['user_id']);
if (isset($_GET['page_id']) && $_GET['page_id'] != 'current_user') {
    $user = new User($_GET['page_id']);
} else {
    $user = new User($_SESSION['user_id']);
}
$test = new Test(0);
$get_goodtest_count = $test->get_goodtest_count($current_user['id']);
$current_user = $user->get_user();
$follow_users = $user->get_users('follows');
$follower_users = $user->get_users('followers');
$follows_count = 0;
$followers_count = 0;
?>
<div class="row">
    <div class="col-3">
        <div class="row" style="margin-top: 1.5rem;margin-left:0.5rem;">
            <div class="col-6">
                <img src="data:image/jpeg;base64,<?= $current_user['image']; ?>" class="mypage">
                <h3><?= $current_user['name']; ?></h2>
                    <input type="hidden" class="current_user_id" value="<?= $_SESSION['user_id'] ?>">
                    <input type="hidden" value="<?= $current_user['id'] ?>">
                    <?php if ($current_user['id'] != $_SESSION['user_id']) : ?>
                    <?php if ($user->check_follow($_SESSION['user_id'], $current_user['id'])) : ?>
                    <button class="follow_btn border_white btn following" type="button" name="follow"><i
                            class="fas fa-user-plus"></i><span id="follow_label">フォロー解除</span></button>
                    <?php else : ?>
                    <button class="follow_btn border_white btn" type="button" name="follow"><i
                            class="fas fa-user-plus"></i>
                        <span id="follow_label">フォローする</span></button>
                    <?php endif; ?>
                    <?php endif; ?>
            </div>
            <div class="col-6" style="text-align: right;">
                <div style='display:inline-block;margin-right: 1rem;width: 8rem;'>
                    <a href="../user/user_list.php?type=follows" style="color: #000;" class="a_follow_count">
                        <div style="text-align: left;margin-left: 1rem;">
                            フォロー<span class="follow_count"
                                style="margin-left: 0.5rem;"><?php print '' . current($user->get_user_count('follow', $current_user['id'])) . ''; ?></span>
                        </div>
                        <?php foreach ($follow_users as $follow_user) :
                            $follows_count++;
                            if ($follows_count == 4) {
                                break;
                            }
                        ?>
                        <img src="data:image/jpeg;base64,<?= $follow_user['image']; ?>" class="users_img">
                        <?php endforeach; ?>
                </div>
                </a>
                <div style='display:inline-block;margin: 1rem 1rem 1rem 0rem;width: 8rem;'>
                    <a href="../user/user_list.php?type=followers" style="color: #000;" class="a_follower_count">
                        <div style="text-align: left;margin-left: 1rem;">
                            フォロワー<span class="follower_count"
                                style="margin-left: 0.5rem;"><?php print '' . current($user->get_user_count('follower', $current_user['id'])) . ''; ?></span>
                        </div>
                        <?php foreach ($follower_users as $follower_user) :
                            $followers_count++;
                            if ($followers_count == 4) {
                                break;
                            }
                        ?>
                        <img src="data:image/jpeg;base64,<?= $follower_user['image']; ?>" class="users_img">
                        <?php endforeach; ?>
                </div>
                </a>
                <div style="text-align:center;width:100%;"><i class="fab fa-tumblr"
                        style="margin-right:1rem;font-size:1.5rem;"></i><i class="fas fa-times"
                        style="margin-right: 1rem;font-size: 1.3rem;"></i><span
                        style="font-size: 1.5rem;"><?= $get_goodtest_count[0]['count(*)']; ?></span>
                </div>
            </div>
        </div>
        <?php
        $skills = explode(" ", $current_user['skill']);
        $skills_len = "";
        $skills_delspace = str_replace("     ", "", $current_user['skill']);
        $licences = explode(" ", $current_user['licence']);
        $licences_len = "";
        $licencs_delspace = str_replace(" ", "", $current_user['licence']);
        ?>
        <div class="tag">
            <div class="tags">
                <div class="tag_skill">
                    <p class="tag_tittle">スキル</p>
                    <?php
                    foreach ($skills as $skill) :
                        if ($current_user['skill'] != '' && $skill != '') : ?>
                    <span id="child-span" class="skill_tag"><?= $skill ?></span>
                    <?php
                            if (!isset($skill_tag)) {
                                $skill_tag = array();
                            }
                            array_push($skill_tag, $skill);
                            $skills_len .= $skill;

                            if (3 <= count($skill_tag) || 9 <= strlen($skills_len)) {
                                print '<div></div>';
                                $skill_tag = array();
                                $skills_len = "";
                            }
                        endif;

                    endforeach;
                    ?>
                </div>
                <div class="tag_licence">
                    <p class="tag_tittle">取得資格</p>
                    <?php
                    foreach ($licences as $licence) :
                        if ($current_user['licence'] != '' && $licence != '') : ?>
                    <span id="child-span" class="licence_tag"><?= $licence ?></span>
                    <?php
                            if (!isset($licence_tag)) {
                                $licence_tag = array();
                            }
                            array_push($licence_tag, $licence);
                            $licences_len .= $licence;

                            if (2 <= count($licence_tag) || 9 <= strlen($licences_len)) {
                                print '<div></div>';
                                $licence_tag = array();
                                $licence_len = "";
                            }
                        endif;

                    endforeach;
                    ?>
                </div>
            </div>
            <div class="background">
                <p class="tag_tittle">職歴</p>
                <p class="user_workhistory"><?= $current_user['workhistory'] ?></p>
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
        switch ($_GET['page_type']) {
            case ('all'):
                require('../test/test_list.php');
                break;
            case ('my_post'):
                require('../test/test_list_mypost.php');
                break;
            case ('testcase'):
                require('../test/test_list_testcase.php');
                break;
        }
        ?>

    </div>
    <?php
    require('../footer.php');
    ?>