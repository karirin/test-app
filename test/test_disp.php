<?php
require_once('../config_1.php');
$post_class = new Post($_GET['post_id']);
$post = $post_class->get_post();
$test_class = new Test($_GET['post_id']);
$test = $test_class->get_test();
?>
<div class="col-4 tested_app">
    <?php
    if (!empty($post['image'])) {
        print '<img src="data:image/jpeg;base64,' . $post['image'] . '" class="tast_case_img" style="margin-bottom: 1rem;">';
    } else {
        print '<img src="../post/image/noimage.jpg" class="tast_case_img" style="width: 70%;margin-bottom: 1rem;" >';
    }
    ?>

    <div>
        <h6 style="font-weight:bold;margin-bottom: 0;">サービス内容</h6>
        <span class="tast_case_text" id="post_text"
            style="margin-bottom: 1rem;"><?php print '' . $post['service'] . ''; ?></span>
        <h6 style="font-weight:bold;margin-bottom: 0;margin-top:1rem;">テスト方針</h6>
        <span class="tast_case_text" id="post_text"
            style="margin-bottom: 1rem;"><?php print '' . $post['test_request'] . ''; ?></span>
        <h6 style="font-weight:bold;margin-top:1rem;">URL</h6>
        <div class="input-group test_url" style="width: 100%;margin-left:0">
            <div class="input-group mb-2">
                <input type="text" id="test_url" class="form-control" aria-label="Username" aria-describedby="text1a"
                    value="<?= $post['url']; ?>" readonly="readonly">
                <div class="input-group-append">
                    <button type="button" class="btn btn-outline-secondary" onclick="copyToClipboard()"><i
                            class="fas fa-copy"></i></button>
                </div>
            </div>
        </div>
        <div>
            <h6 style="font-weight:bold;margin-top:1rem;">アプリケーション形式</h6>
            <?php print '' . $post['app_format'] . ''; ?>
        </div>
    </div>
</div>
<div class="col-7" style="display: inline-block;margin-top: -2rem;text-align: right;padding-left: 0;">
    <div class="help"><i class="fas fa-question-circle help_btn"></i></div>
    <ul class="test_case">
        <?php foreach ($test as $test_case) :
            $test_user = new User($test_case['user_id']);
            $test_user = $test_user->get_user(); ?>
        <li class="priority" data-target="#testcase_<?= $test_case['id'] ?>" data-toggle="testcase">
            <div class="delete_btn"><i class="far fa-trash-alt" style="vertical-align: sub;"></i></div>
            <span class="progress"><?= $test_case['progress'] ?></span>
            <div id="testcase_<?= $test_case['id'] ?>">
                <input type="hidden" class="procedure" value="<?= $test_case['procedure'] ?>">
                <input type="hidden" class="priority_input" value="<?= $test_case['priority'] ?>">
                <input type="hidden" class="progress_input" value="<?= $test_case['progress'] ?>">
                <input type="hidden" class="priority_user_id" value="<?= $test_case['user_id'] ?>">
                <input type="hidden" class="post_user_id" value="<?= $post['user_id'] ?>">
                <input type="hidden" class="user_id" value="<?= $_SESSION['user_id'] ?>"><span
                    class="testcase_text"><?= $test_case['text'] ?></span><span class="test_user_info"
                    style="font-size:1rem;display:inline-block;"><a
                        href="../index.php?page_id=<?= $test_case['user_id'] ?>&type=main&page_type=my_post"><span
                            style=" display:block;"><img src="data:image/jpeg;base64,<?= $test_user['image'] ?>"
                                class="test_user_img"><span
                                class="testcase_name"><?= $test_user['name'] ?></span></span></a><span
                        class="created_at"><?= convert_to_fuzzy_time($test_case['created_at']) ?></span></span>
            </div>
            <?php if ($test_case['rated'] == 1) : ?>
            <i class="fas fa-thumbs-up" style="vertical-align: super;margin-left: 0.5rem;"></i>
            <?php else : ?>
            <i class="fas fa-thumbs-up" style="vertical-align: super;margin-left: 0.5rem;display:none;"></i>
            <?php endif; ?>
        </li>
        <?php endforeach ?>
        <button class="btn btn-outline-secondary testcase_add"><i class="fas fa-plus"></i>　テストケース追加</button>
        <input type="hidden" name="post_id" value="<?= $post['id'] ?>">

    </ul>
</div>
<?php
require_once('../footer.php');
?>