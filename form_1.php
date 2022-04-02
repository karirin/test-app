<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <title>Auto Complete</title>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/themes/smoothness/jquery-ui.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
        integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/normalize.css">
    <link rel="stylesheet" href="/css/style.css">
    <link href="https://use.fontawesome.com/releases/v5.0.9/css/all.css" rel="stylesheet">
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/jquery-ui.min.js"></script>
</head>

<body>
    <form method="post" action="../tag_done.php" enctype="multipart/form-data">
        <input type="text" id="sample" style="border: solid" />
        <div id="skill" style="margin:10px 0">
            <?php
            function db_connect()
            {
                $dsn = 'mysql:dbname=chat;host=localhost;charset=utf8';
                $user = 'root';
                $password = '';
                $dbh = new PDO($dsn, $user, $password);
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $dbh;
            }
            class User
            {
                public function __construct($user_id)
                {
                    $this->id = $user_id;
                }

                public function get_user()
                {
                    try {
                        $dbh = db_connect();
                        $sql = "SELECT *
    FROM user
    WHERE id = :id";
                        $stmt = $dbh->prepare($sql);
                        $stmt->execute(array(':id' => $this->id));
                        return $stmt->fetch();
                    } catch (\Exception $e) {
                        error_log($e, 3, "../../php/error.log");
                        set_flash('error', ERR_MSG1);
                    }
                }
            }

            $_SESSION['user_id'] = 7;
            $user = new User($_SESSION['user_id']);
            $current_user = $user->get_user();
            $skills = explode(" ", $current_user['skill']);
            $skills_len = "";
            $skills_delspace = str_replace(" ", "", $current_user['skill']);

            foreach ($skills as $skill) :
                if ($current_user['skill'] != '' && $skill != '') : ?>
            <span id="child-span" class="skill_tag"><?= $skill ?><label><input type="button"><i
                        class="far  fa-times-circle tag"></i></label></span>
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
        <input type="hidden" name="skills" id="skills">
        <input type="submit" class="btn btn-outline-dark edit_done" style="margin-left:130px" value="登録">
        <input type="hidden" name="skill_count" id="skill_count">
    </form>

</body>
<script>
$(function() {
    $("#sample").autocomplete({
        source: "./autocomplete.php"
    });
});

const input = document.querySelector('input');
input.addEventListener('change', inputChange);

const list = new Array(
    'AWS',
    'Bootstrap',
    'C',
    'CakePHP',
    'C#',
    'C++',
    'COBOL',
    'CSS',
    'Docker',
    'Go',
    'Git',
    'HTTP',
    'iOS',
    'Java',
    'JavaScript',
    'JIRA',
    'Kotlin',
    'Laravel',
    'MATLAB',
    'MySQL',
    'Oracle Database',
    'Perl',
    'PHP',
    'PostgreSQL',
    'Python',
    'R',
    'React',
    'Ruby',
    'Ruby on Rails',
    'Rust',
    'SVN',
    'SSL',
    'SQLite',
    'TypeScript',
    'Vue.js'
);

function inputChange() {
    var fome_x_name = $(this).val(),
        label_element = document.createElement("label"),
        i_element = document.createElement("i"),
        input_element = document.createElement("input"),
        skill = document.getElementById("skill"),
        spans = skill.getElementsByTagName("span"),
        skills = new Array(),
        skill_count = document.getElementById('skill_count').val;

    for (i = 0; i < spans.length; i++) {
        skills[i] = spans[i].textContent;
    }

    skills = skills.join('');

    // 既に入力済みのものはタグ追加しない
    if (skills.indexOf(fome_x_name) != -1) {
        return false;
    }
    if (list.indexOf(fome_x_name) != -1) {

        var span_element = document.createElement("span"),
            newContent = document.createTextNode(fome_x_name),
            skill = document.getElementById("skill"),
            div_element = document.createElement("div"),
            spans = skill.getElementsByTagName("span");
        span_element.appendChild(newContent);
        span_element.setAttribute("id", "child-span" + i + "");
        parentDiv = document.getElementById("skill");
        span_element.setAttribute("class", "skill_tag");

        // タグの改行があった場合
        if (0 < document.getElementById('skill_count').val) {
            i--;
            skills = new Array();

            // 改行した列で再度文字数取得
            for (k = 0; k < skill_count; k++) {
                skills[k] = spans[i].textContent;
                i--;
            }
            spans = '';
            skills = skills.join('');

            // skill_countの値で改行後のタグ数を決める
            switch (skill_count) {
                case 2:
                    i += 1;
                    spans = '@@';
                    break;

                case 3:
                    i += 2;
                    spans = '@@@';
                    break;
                case 4:
                    i += 3;
                    spans = '@@@@';
                    break;

                case 5:
                    i += 4;
                    spans = '@@@@@';
                    break;
                default:
            }

            i++;
            document.getElementById('skill_count').val += 1;
        }

        // タグ数が３つ以上または、タグの文字数が９文字以上は改行
        if (3 <= spans.length || 9 <= skills.length) {
            i--;
            if (document.getElementById('child-span' + i + '') !== null) {
                parentDiv.appendChild(div_element, document.getElementById('child-span' + i + ''));
            }
            i++;
            document.getElementById('skill_count').val = 1; //追加
        }
        i++;

        parentDiv.appendChild(span_element, parentDiv.firstChild);
        i_element.setAttribute("class", "far fa-times-circle tag");
        i_element.setAttribute("style", "display:inline");
        input_element.setAttribute("type", "button");
        span_element.appendChild(label_element, span_element.firstChild);
        label_element.insertBefore(i_element, label_element.firstChild);
        label_element.insertBefore(input_element, label_element.firstChild);
        $(this).val('');
    }
}
$(document).on('click', '.far.fa-times-circle', function() {
    $(this).parents(".skill_tag").remove();
});

$(document).on('click', '.edit_done', function() { //追加
    var skill = document.getElementById("skill"),
        skill_div = document.getElementById("skills"),
        spans = skill.getElementsByTagName("span"),
        skills = new Array();

    for (i = 0; i < spans.length; i++) {
        skills[i] = spans[i].textContent;
    }
    skills = skills.join(' ');
    skill_div.value = skills;
}); //追加
</script>

</html>