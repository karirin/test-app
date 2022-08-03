<?php
require_once('../config_1.php');
$post_class = new Post($_GET['post_id']);
$test_class = new Test($_GET['post_id']);
$post = $post_class->get_post();
$test = $test_class->get_test();
$skills = explode(" ", $post['skill']);
$skills_len = "";
$skills_delspace = str_replace("     ", "", $post['skill']);
?>
<div class="col-6" style='display:inline-block;vertical-align:top;text-align:right'>
    <?php
    if (!empty($post['image'])) :
        print '<img src="data:image/jpeg;base64,' . $post['image'] . '" class="tast_case_img" >';
    endif;
    ?>
</div>
<div class="col-5" style='display:inline-block;'>
    <h6 style="font-weight:bold;">説明</h6>
    <span class="tast_case_text ellipsis" id="post_text"><?php print '' . $post['text'] . ''; ?></span>
    <h6 style="font-weight:bold;">URL</h6>
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
    <div class="tag">
        <div class="tags">
            <div class="tag_skill">
                <h6 style="font-weight:bold;">使用技術</h6>
                <?php
                foreach ($skills as $skill) :
                    if ($post['skill'] != '' && $skill != '') : ?>
                <span id="child-span" class="skill_tag"><?= $skill ?></span>
                <?php
                        if (!isset($skill_tag)) {
                            $skill_tag = array();
                        }
                        array_push($skill_tag, $skill);
                        $skills_len .= $skill;

                        if (10 <= count($skill_tag) || 40 <= strlen($skills_len)) {
                            print '<div></div>';
                            $skill_tag = array();
                            $skills_len = "";
                        }
                    endif;

                endforeach;
                ?>
            </div>
        </div>
    </div>
</div>
<ul class="test_case">
    <?php foreach ($test as $test_case) :
        $test_user = new User($test_case['user_id']);
        $test_user = $test_user->get_user(); ?>
    <li><span class="priority"><?= $test_case['priority'] ?></span><span
            class="testcase_text"><?= $test_case['text'] ?></span><span class="test_user_info"
            style="font-size:1rem;"><img src="data:image/jpeg;base64,<?= $test_user['image'] ?>"
                class="test_user_img"><?= $test_user['name'] ?></span></li>
    <?php endforeach ?>
    <button class=" btn btn-outline-secondary testcase_add"><i class="fas fa-plus"></i>　テストケース追加</button>
    <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
</ul>
<?php
require_once('../footer.php');
?>