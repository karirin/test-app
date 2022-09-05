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

<form method="post" action="../ajax_edit_profile.php" enctype="multipart/form-data">
    <div class="row">
        <div class="col-3">
            <div class="row" style="margin-top: 1.5rem;margin-left:0.5rem;">
                <div class="col-6">
                    <div class="edit_profile_img">
                        <label>
                            <div class="fa-image_range">
                                <i class="far fa-image"></i>
                            </div>
                            <input type="file" name="image_name" id="edit_profile_img" accept="image/*" multiple>
                        </label>
                        <img name="profile_image" class="editing_profile_img"
                            src="data:image/jpeg;base64,<?= $current_user['image']; ?>">
                        <label>
                            <i class="far fa-times-circle profile_clear"></i>
                            <input type="button" id="profile_clear">
                        </label>
                    </div>
                    <img src="data:image/jpeg;base64,<?= $current_user['image']; ?>" class="mypage">
                    <h3 class="profile_name"><?= $current_user['name']; ?></h3>
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
            $skill_tag = array();
            $licences = explode(" ", $current_user['licence']);
            $licences_len = "";
            $licencs_delspace = str_replace("     ", "", $current_user['licence']);
            $licence_tag = array();
            ?>
            <div class="tag">
                <div class="tags">
                    <div class="tag_skill">
                        <p class="tag_tittle">スキル</p>
                        <?php
                        foreach ($skills as $skill) :
                            if ($current_user['skill'] != '' && $skill != '') : ?>
                        <?php
                                array_push($skill_tag, $skill);
                                $skills_len .= $skill;
                                if (3 <= count($skill_tag) || 9 <= mb_strlen($skills_len)) {
                                    print '<span id="child-span" class="skill_tag extra" style="display: none;">' . $skill . '</span>';
                                } else {
                                    print '<span id="child-span" class="skill_tag">' . $skill . '</span>';
                                }
                            endif;
                        endforeach;
                        ?>
                        <i class="fas fa-plus skill_btn"></i>
                    </div>
                    <div class="tag_licence">
                        <p class="tag_tittle">取得資格</p>
                        <?php
                        foreach ($licences as $licence) :
                            if ($current_user['licence'] != '' && $licence != '') :
                                array_push($licence_tag, $licence);
                                $licences_len .= $licence;
                                if (2 <= count($licence_tag) || 9 <= mb_strlen($licences_len)) {
                                    print '<span id="child-span" class="licence_tag extra" style="display: none;">' . $licence . '</span>';
                                } else {
                                    print '<span id="child-span" class="licence_tag">' . $licence . '</span>';
                                }
                            endif;

                        endforeach;
                        ?>
                        <i class="fas fa-plus licence_btn"></i>
                    </div>
                </div>
                <div class="background">
                    <p class="tag_tittle">職歴</p>
                    <p class="user_workhistory"><?= $current_user['workhistory'] ?></p>
                </div>
                <div class="form">
                    <div id="skill">
                        <p class="tag_tittle">スキル</p>
                        <?php
                        foreach ($skills as $skill) :
                            if ($current_user['skill'] != '' && $skill != '') : ?>
                        <span id="child-span" class="skill_tag"><?= $skill ?><label><input type="button"><i
                                    class="far  fa-times-circle skill"></i></label></span>
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

                    <input placeholder="skill Stack" name="name" id="skill_input" />
                    <input type="hidden" name="skills" id="skills">
                    <input type="hidden" name="skill_count" id="skill_count">
                    <input type="hidden" name="myskills" value="<?= $current_user['skill'] ?>">
                    <div id="licence">
                        <p class="tag_tittle" style="margin-top: 1rem;">取得資格</p>
                        <?php
                        foreach ($licences as $licence) :
                            if ($current_user['licence'] != '' && $licence != '') : ?>
                        <span id="child-span" class="licence_tag"><?= $licence ?><label><input type="button"><i
                                    class="far fa-times-circle licence"></i></label></span>
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
                    <input placeholder="licence Stack" name="name" id="licence_input" />
                    <input type="hidden" name="licences" id="licences">
                    <input type="hidden" name="licence_count" id="licence_count">
                    <input type="hidden" name="mylicences" value="<?= $current_user['licence'] ?>">
                    <div class="background">
                        <p class="tag_tittle">職歴</p>
                        <p class="workhistory"><?= $current_user['workhistory'] ?></p>
                    </div>
                </div>
            </div>
            <?php if ($current_user['id'] == $_SESSION['user_id']) : ?>
            <button class="btn btn btn-outline-dark edit_btn" type="button" name="follow">プロフィール編集</button>
            <?php endif; ?>
        </div>
        <div class="col-9" style="text-align: center;">
            <?php if ($current_user['id'] == $_SESSION['user_id']) : ?>
            <ul class="nav nav-tabs">
                <li class="nav-item"><a href="../user_login/user_top.php?page_type=all"
                        class="nav-link post_tab all active">すべての投稿</a></li>
                <li class="nav-item"><a href="../user_login/user_top.php?page_type=my_post"
                        class="nav-link post_tab my_post">自分の投稿</a></li>
                <li class="nav-item"><a href="../user_login/user_top.php?page_type=testcase"
                        class="nav-link post_tab testcase">テストケースを記載した投稿</a></li>
            </ul>
            <?php else : ?>
            <h3 style="text-align:left;margin-left: 2.5rem;"><?= $current_user['name']  ?>さんの投稿</h3>
            <?php endif; ?>
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
</form>
<?php
require('../footer.php');
?>