// 変数定義
var user_comment = $('.comment').text(),
    user_name = $('.profile_name').text(),
    user_comment_narrow = $('.comment_narrow').text(),
    user_name_narrow = $('.profile_name_narrow').text(),
    user_comment_narrower = $('.comment_narrower').text(),
    user_name_narrower = $('.profile_name_narrower').text(),
    user_workhistory = $('.workhistory').text(),
    user_workhistory_narrow = $('.workhistory_narrow').text(),
    user_workhistory_narrower = $('.workhistory_narrower').text(),
    user = $('.user').val();

window.onload = function() {
    // テストケースが優先度によって色が変わるようにする
    for (i = 0; i < $('.priority').length; i++) {
        switch ($('.priority .priority_input')[i].value) {
            case "A":
                $('.priority')[i].setAttribute("style", 'background-color: #b2cdff;');
                break;

            case "B":
                $('.priority')[i].setAttribute("style", 'background-color: #dce8fe;');
                break;

            case "C":
                break;
            default:
        }
        if ($('.priority .progress_input')[i].value == '完了') {
            $('.priority')[i].setAttribute("style", 'background-color: #a49e9e;');
        }
    }

    switch (location.search.substring(11)) {
        case "all":
            $('.post_tab').removeClass('active');
            $('.post_tab.all').addClass('active');
            break;

        case "my_post":
            $('.post_tab').removeClass('active');
            $('.post_tab.my_post').addClass('active');
            break;

        case "testcase":
            $('.post_tab').removeClass('active');
            $('.post_tab.testcase').addClass('active');
            break;
        default:
    }

    // 余分なタグが無い場合は(+)ボタンを非表示に
    if ($('.skill_tag.extra')[0] == undefined) {
        $('.skill_btn')[0].setAttribute('style', 'display:none;');
        $('.myprofile_skill_btn')[0].setAttribute('style', 'display:none;');
    }
    if ($('.licence_tag.extra')[0] == undefined) {
        $('.licence_btn')[0].setAttribute('style', 'display:none;');
        $('.myprofile_licence_btn')[0].setAttribute('style', 'display:none;');
    }
}

/// 長押しを検知する閾値
var LONGPRESS = 500;
/// 長押し実行タイマーのID
var timerId;

/// 長押し・ロングタップを検知する
$(document).on("mousedown touchstart", '.priority', function() {
    var $target_modal = $(this).data("target");
    console.log($target_modal);
    timerId = setTimeout(function() {
        if ($($target_modal).prev().prev().css('display') == 'none') {
            $($target_modal).animate({ width: '587px' }, 'slow');
            $($target_modal + ' .testcase_text').animate({ width: '76%' }, 'slow');
            $($target_modal).animate({ height: '45px' }, 'slow');
            $($target_modal).prev().prev().animate({ width: 'toggle' }, 'slow');
            $($target_modal).prev().prev().css('display', 'inline-block');
        } else {
            $($target_modal).animate({ width: '630px' }, 'slow');
            $($target_modal + ' .testcase_text').animate({ width: '77%' }, 'slow');
            $($target_modal).prev().prev().animate({ width: 'toggle' }, 'slow');
            $($target_modal).prev().prev().css('display', 'inline-block');
        }
    }, LONGPRESS);
    // テストケースの削除ボタン押下時
    $(document).on('click', '.delete_btn', function() {
        $('.modal_testcase').fadeIn();
        $('.testcase_delete').fadeIn();
        $('.testcase_delete .testcase_text').replaceWith('<span class="testcase_text" style="text-align: center;width: 100%;">' + $($target_modal + ' > span')[0].textContent + '</span>');
        $(document).on('click', '.testcase_clear', function() {
            $('.modal_testcase').fadeOut();
            $('.testcase_delete').fadeOut();
        });
        $(document).on('click', '.delete_btn', function() {
            var test_id = $target_modal.slice(10);
            console.log($target_modal);
            $.ajax({
                type: 'POST',
                url: '../ajax_edit_test.php',
                dataType: 'text',
                data: {
                    test_id: test_id,
                    delete_flg: 1
                }
            }).done(function() {
                $('.modal_testcase').fadeOut();
                $('.testcase_delete').fadeOut();
                $($target_modal).parent().fadeOut(1000);
            }).fail(function() {});
        });
    }).on("mouseup mouseleave touchend", function() {
        clearTimeout(timerId);
    });

    $(document).on('click', '.comment_btn', function() {
        $('.comment').fadeIn().css('display', 'flex');
    });
});


// テストケースの詳細画面表示
$(document).on('dblclick', '.priority', function() {
    var $target_modal = $(this).data("target"),
        $test_id = $target_modal.substring(10),
        $user_id = $('' + $target_modal + ' .priority_user_id')[0].value,
        $post_user_id = $('' + $target_modal + ' .post_user_id')[0].value,
        $test_priority = $('#testcase_' + $test_id).prev()[0].textContent,
        $test_progress = $('#testcase_' + $test_id + ' .priority_input')[0].value,
        $current_user_id = $('' + $target_modal + ' .user_id')[0].value;
    $('.testcase_disp').fadeIn();
    $('.modal_testcase').fadeIn();
    $('.testcase_clear').fadeIn();
    if ($current_user_id == $user_id) {
        $('.testcase_disp .testcase_text').replaceWith('<span class="testcase_text">' + $($target_modal + ' > span')[0].textContent + '</span>');
        $('.t_btn').fadeOut();
    } else {
        $('.testcase_disp .testcase_text').replaceWith('<span class="testcase_text" style="pointer-events: none">' + $($target_modal + ' > span')[0].textContent + '</span>');
        $('.t_btn').fadeIn();
    }
    if ($current_user_id == $post_user_id) {
        $('.testcase_disp #priority').fadeIn();
        $('.testcase_disp #progress').fadeIn();
    }
    $('.testcase_disp .test_user_img')[0].setAttribute('src', $($target_modal + ' > .test_user_info > a > span >.test_user_img')[0].getAttribute('src'));
    $('.testcase_disp .testcase_created_at').replaceWith('<span class="testcase_created_at">' + $($target_modal + ' > .test_user_info > .created_at')[0].textContent + '</span>');
    $('.testcase_disp .testcase_name').replaceWith('<span class="testcase_name">' + $($target_modal + ' > .test_user_info > a > span > .testcase_name')[0].textContent + '</span>');
    $('.testcase_disp .testcase_id').replaceWith('<input class="testcase_id" type="hidden" value="' + $test_id + '">');
    // セレクトボックスの初期値を指定
    $("#priority option[value='" + $test_priority + "']").prop('selected', true);
    $("#progress option[value='" + $test_progress + "']").prop('selected', true);
    $(document).on('click', '.testcase_clear', function() {
        $('.testcase_disp').fadeOut();
        $('.modal_testcase').fadeOut();
        $('.testcase_clear').fadeOut();
    });
    // $('.testcase_disp .if_comment').replaceWith('<?php if($comments==0) ?>');
    // $('.testcase_disp .end_comment').replaceWith('<?php endif; ?>');
});

// テストケースの必須チェック
$(document).on('click', '.testcase_btn', function() {
    if ($('#priority').val() == '' && $('#test_process_counter')[0].value == '') {
        $('#priority')[0].setAttribute("style", "border-color: #dc3545;");
        $('#test_process_counter')[0].setAttribute("style", "border-color: #dc3545;");
        $('.priority_error').fadeIn();
        $('.testcase_error').fadeIn();
        return false;
    } else if ($('#priority').val() == '') {
        $('#priority')[0].setAttribute("style", "border-color: #dc3545;");
        $('.priority_error').fadeIn();
        return false;
    } else if ($('#test_process_counter')[0].value == '') {
        $('#test_process_counter')[0].setAttribute("style", "border-color: #dc3545;");
        $('.testcase_error').fadeIn();
        return false;
    }
});

// テストケース必須チェック解除
$(document).ready(function() {
    $('#priority').change(function() {
        var str = $(this).val();
        if (str.search(/[A-C]/g) != -1) {
            $('#priority')[0].setAttribute("style", "border-color: #ced4da;");
            $('.priority_error').fadeOut();
        }
    });

    $('#test_process_counter').change(function() {
        var str = $(this).value;
        if (str != '') {
            $('#test_process_counter')[0].setAttribute("style", "border-color: #ced4da;");
            $('.testcase_error').fadeOut();
        }
    });

    $('.url_form').change(function() {
        var str = $(this).value;
        if (str != '') {
            $('.url_form')[0].setAttribute("style", "border-color: #ced4da;");
            $('.post_url_error').fadeOut();
        }
    });

    $('.test_form').change(function() {
        var str = $(this).value;
        if (str != '') {
            $('.test_form')[0].setAttribute("style", "border-color: #ced4da;");
            $('.post_text_error').fadeOut();
        }
    });
});

// テスト投稿の必須チェック
$(document).on('click', '.post_process_btn', function() {
    if ($('.url_form').val() == '' && $('.test_form')[0].value == '') {
        $('.url_form')[0].setAttribute("style", "border-color: #dc3545;");
        $('.test_form')[0].setAttribute("style", "border-color: #dc3545;");
        $('.post_url_error').fadeIn();
        $('.post_text_error').fadeIn();
        return false;
    } else if ($('.url_form').val() == '') {
        $('.url_form')[0].setAttribute("style", "border-color: #dc3545;");
        $('.post_url_error').fadeIn();
        return false;
    } else if ($('.test_form')[0].value == '') {
        $('.test_form')[0].setAttribute("style", "border-color: #dc3545;");
        $('.post_text_error').fadeIn();
        return false;
    }
});

// テストケース入力処理
$(document).on('click', '.testcase_disp .testcase_text', function() {
    var $test_id = $('.testcase_disp .testcase_id')[0].value,
        $test_text = $('.testcase_disp .testcase_text')[0].textContent;
    $(this).replaceWith('<textarea type="text" name="text" id="edit_testcase_' + $test_id + '" class="edit_testcase" style="width: 100%;">' + $test_text);
    $('#edit_testcase_' + $test_id).on('mouseout', function(e) {
        e.stopPropagation();
        var edit_test_text = $('#edit_testcase_' + $test_id).val();
        if (edit_test_text == '') {
            $('#edit_testcase_' + $test_id)[0].setAttribute("style", "border-color: #dc3545;border-style: solid;width: 100%;");
            $('.testcase_disp .testcase_error').fadeIn();
            $('.testcase_disp .testcase_clear')[0].disabled = true;
            return false;
        }
        $.ajax({
            type: 'POST',
            url: '../ajax_edit_test.php',
            dataType: 'text',
            data: {
                test_id: $test_id,
                test_text: edit_test_text,
                disp_flg: 1
            }
        }).done(function() {
            $('#edit_testcase_' + $test_id).replaceWith('<span class="testcase_text">' + edit_test_text + '</span>');
            $('#testcase_' + $test_id + ' .testcase_text').replaceWith('<span class="testcase_text">' + edit_test_text + '</span>');
            $('.testcase_disp .testcase_clear')[0].disabled = false;
            $('.testcase_error').fadeOut();
        }).fail(function() {});
    });
});

// 選択した進捗度によってテストケースの色を変更
$(document).on('change', '.testcase_disp #priority', function() {
    var $test_val = $('.testcase_disp #priority')[0].value,
        $test_id = $('.testcase_disp .testcase_id')[0].value,
        $test_progress = $('#testcase_' + $test_id).prev();
    $.ajax({
        type: 'POST',
        url: '../ajax_edit_test.php',
        dataType: 'text',
        data: {
            test_id: $test_id,
            test_val: $test_val,
            select_flg: 1
        }
    }).done(function() {
        $test_progress.replaceWith('<span class="progress">' + $test_val + '</span>');
        // 選択した進捗度によってテストケースの色を変更
        if ($test_val == '完了') {
            $('#testcase_' + $test_id).parent()[0].setAttribute("style", 'background-color: #a49e9e;');
        } else {
            switch ($('.testcase_disp #progress')[0].value) {
                case "A":
                    $('#testcase_' + $test_id).parent()[0].setAttribute("style", 'background-color: #b2cdff;');
                    break;

                case "B":
                    $('#testcase_' + $test_id).parent()[0].setAttribute("style", 'background-color: #dce8fe;');
                    break;

                case "C":
                    $('#testcase_' + $test_id).parent()[0].setAttribute("style", 'background-color: whitesmoke;');
                    break;

                default:
            }
        }
    });
});

// 選択した優先度によってテストケースの色を変更
$(document).on('change', '.testcase_disp #progress', function() {
    var $test_progres = $('.testcase_disp #progress')[0].value,
        $test_id = $('.testcase_disp .testcase_id')[0].value,
        $test_priority = $('.testcase_disp #priority')[0].value;
    $.ajax({
        type: 'POST',
        url: '../ajax_edit_test.php',
        dataType: 'text',
        data: {
            test_id: $test_id,
            test_progress: $test_progres,
            progress_flg: 1
        }
    }).done(function() {
        if ($test_priority == '完了') {
            $('#testcase_' + $test_id).parent()[0].setAttribute("style", 'background-color: #a49e9e;');
        } else {
            switch ($test_progres) {
                case "A":
                    $('#testcase_' + $test_id).parent()[0].setAttribute("style", 'background-color: #b2cdff;');
                    break;

                case "B":
                    $('#testcase_' + $test_id).parent()[0].setAttribute("style", 'background-color: #dce8fe;');
                    break;

                case "C":
                    $('#testcase_' + $test_id).parent()[0].setAttribute("style", 'background-color: whitesmoke;');
                    break;
                default:
            }
        }
    });
});

$(document).on('click', '.t_btn', function() {
    $test_id = $('.testcase_disp .testcase_id')[0].value;
    $.ajax({
        type: 'POST',
        url: '../ajax_edit_test.php',
        dataType: 'text',
        data: {
            test_id: $test_id,
            t_flg: 1
        }
    }).done(function() {
        $('#testcase_' + $test_id).next().fadeIn(1000);
    });
});

$(document).on('click', '.t_btn', function() {
    $test_id = $('.testcase_disp .testcase_id')[0].value;
    $.ajax({
        type: 'POST',
        url: '../ajax_edit_test.php',
        dataType: 'text',
        data: {
            test_id: $test_id,
            t_flg: 1
        }
    }).done(function() {
        $('#testcase_' + $test_id).next().fadeIn(1000);
    });
});

$('.skill_btn').on('click', function() {
    $('.skill_tag').fadeIn(1000);
    $('.skill_btn').off('click');
    $('.skill_btn').attr('class', 'fas fa-minus skill_btn_close');
    $('.skill_btn_close').on('click', function() {
        $('.skill_tag.extra').fadeOut(1000);
        $('.skill_btn_close').off('click');
        $('.skill_btn_close').attr('class', 'fas fa-plus skill_btn');
    });
});

$('.myprofile_skill_btn').on('click', function() {
    $('.skill_tag').fadeIn(1000);
    $('.myprofile_skill_btn').off('click');
    $('.myprofile_skill_btn').attr('class', 'fas fa-minus myprofile_skill_btn_close');
    $('.myprofile_skill_btn_close').on('click', function() {
        $('.skill_tag.extra').fadeOut(1000);
        $('.myprofile_skill_btn_close').off('click');
        $('.myprofile_skill_btn_close').attr('class', 'fas fa-plus myprofile_skill_btn');
    });
});

$('.licence_btn').on('click', function() {
    $('.licence_tag').fadeIn(1000);
    $('.licence_btn').off('click');
    $('.licence_btn').attr('class', 'fas fa-minus licence_btn_close');
    $('.licence_btn_close').on('click', function() {
        $('.licence_tag.extra').fadeOut(1000);
        $('.licence_btn_close').off('click');
        $('.licence_btn_close').attr('class', 'fas fa-plus licence_btn');
    });
});

$('.myprofile_licence_btn').on('click', function() {
    $('.licence_tag').fadeIn(1000);
    $('.myprofile_licence_btn').off('click');
    $('.myprofile_licence_btn').attr('class', 'fas fa-minus myprofile_licence_btn_close');
    $('.myprofile_licence_btn_close').on('click', function() {
        $('.licence_tag.extra').fadeOut(1000);
        $('.myprofile_licence_btn_close').off('click');
        $('.myprofile_licence_btn_close').attr('class', 'fas fa-plus myprofile_licence_btn');
    });
});

// 編集ボタン押下時の処理
$(document).on('click', '.profile_edit_btn', function() {
    scroll_position = $(window).scrollTop();
    $('.profile_edit_btn').fadeOut();
    $('.follow_user').fadeOut();
    $('.comment').replaceWith('<textarea class="edit_comment form-control" type="text" name="user_comment" >' + user_comment);
    $('.profile_name').replaceWith('<input class="edit_name form-control" type="text" name="user_name" value="' + user_name + '">');
    $('.comment_narrow').replaceWith('<textarea class="edit_comment form-control" type="text" name="user_comment" >' + user_comment_narrow);
    $('.profile_name_narrow').replaceWith('<input class="edit_name form-control" type="text" name="user_name" value="' + user_name_narrow + '">');
    $('.comment_narrower').replaceWith('<textarea class="edit_comment form-control" type="text" name="user_comment" >' + user_comment_narrower);
    $('.profile_name_narrower').replaceWith('<input class="edit_name form-control" type="text" name="user_name" value="' + user_name_narrower + '">');
    $('.workhistory').replaceWith('<textarea class="edit_workhistory form-control" type="text" name="user_workhistory" >' + user_workhistory);
    $('.workhistory_narrow').replaceWith('<textarea class="edit_workhistory form-control" type="text" name="user_workhistory" >' + user_workhistory_narrow);
    $('.workhistory_narrower').replaceWith('<textarea class="edit_workhistory form-control" type="text" name="user_workhistory" >' + user_workhistory_narrower);
    $('.mypage').css('display', 'none');
    $('.edit_profile_img').css('display', 'inline-block');
    $('.btn_flex').css('display', 'flex');
    $('.profile').addClass('editing');
    $('.form').css('display', 'inline-block');
    $('.tag').fadeOut();
    $('.col-3').css('margin-top', '-2rem');
    $('.edit_btns').fadeIn();
    $('.profile_count').fadeOut();
    $('.edit_workhistory').change(function() {
        var str = $('.edit_workhistory')[0].value.length;
        if (str < 100) {
            $('.edit_workhistory')[0].setAttribute("style", "border-color: #ced4da;");
            $('.error_workhistory').fadeOut();
        }
    });
});

$(function() {
    $("#skill_myprofile_input").autocomplete({
        source: "../autocomplete_skill.php"
    });
});

if (document.getElementById('skill_myprofile_input') != null) {
    let skill_myprofile_input = document.getElementById('skill_myprofile_input'),
        myprofile_skill = document.getElementById("myprofile_skill"),
        myprofile_spans = skill.getElementsByTagName("span");

    skill_myprofile_input.addEventListener('change', inputChange_skill);

    // 初期状態のタグ数でmyprofile_skill_countの値を決める
    if (document.getElementById('myprofile_skill_count').val) {
        if (myprofile_spans.length > 3) {
            myprofile_skill_count_val = myprofile_spans.length % 3;
            switch (myprofile_skill_count_val) {
                case 0:
                    document.getElementById('myprofile_skill_count').val = 3;
                    break;

                case 1:
                    document.getElementById('myprofile_skill_count').val = 1;
                    break;

                case 2:
                    document.getElementById('myprofile_skill_count').val = 2;
                    break;

                default:
            }
        }
    }
}

function inputChange_skill() {
    var fome_x_name_myprofile = $(this).val(),
        skill_myprofile = document.getElementById("myprofile_skill"),
        skills_myprofile = new Array(),
        spans_myprofile = skill_myprofile.getElementsByTagName("span");

    for (i = 0; i < spans_myprofile.length; i++) {
        skills_myprofile[i] = spans_myprofile[i].textContent;
    }

    skills_myprofile = skills_myprofile.join('');

    // 既に入力済みのものはタグ追加しない
    if (skills_myprofile.indexOf(fome_x_name_myprofile) != -1) {
        return false;
    }
    // 入力した文字列がlistと合えばタグ追加
    if (skill_list.indexOf(fome_x_name_myprofile) != -1) {
        var span_element_myprofile = document.createElement("span"),
            label_element_myprofile = document.createElement("label"),
            i_element_myprofile = document.createElement("i"),
            input_element_myprofile = document.createElement("input"),
            newContent_myprofile = document.createTextNode(fome_x_name_myprofile),
            div_element_myprofile = document.createElement("div"),
            parentDiv_myprofile = document.getElementById("myprofile_skill"),
            skill_count_myprofile = document.getElementById('myprofile_skill_count').val;

        span_element_myprofile.appendChild(newContent_myprofile);
        span_element_myprofile.setAttribute("id", "child-span_myprofile" + i + "");
        span_element_myprofile.setAttribute("class", "skill_tag");
        span_element_myprofile.setAttribute("style", "margin-right:4px;");
        div_element_myprofile.setAttribute("id", "span" + i + "");
        i_element_myprofile.setAttribute("class", "far fa-times-circle skill");
        input_element_myprofile.setAttribute("type", "button");

        // タグの改行があった場合
        if (0 < document.getElementById('myprofile_skill_count').val) {
            i--;
            var skills_myprofile = new Array();

            // 改行した列で再度文字数取得
            for (k = 0; k < skill_count_myprofile; k++) {
                skills_myprofile[k] = spans[i].textContent;
                i--;
            }
            spans_myprofile = '';
            skills_myprofile = skills.join('');

            // skill_countの値で改行後のタグ数を決める
            switch (skill_count_myprofile) {
                case 2:
                    i += 1;
                    spans_myprofile = '@@';
                    break;

                case 3:
                    i += 2;
                    spans_myprofile = '@@@';
                    break;
                case 4:
                    i += 3;
                    spans_myprofile = '@@@@';
                    break;

                case 5:
                    i += 4;
                    spans_myprofile = '@@@@@';
                    break;
                default:
            }

            i++;
            document.getElementById('myprofile_skill_count').val += 1;
        }

        // タグ数が３つ以上または、タグの文字数が９文字以上は改行
        // if ((3 <= spans_myprofile.length || 22 <= skills_myprofile.length)) {
        //     i--;
        //     if (document.getElementById('child-span_myprofile' + i + '') !== null) {
        //         parentDiv.insertBefore(div_element, document.getElementById('child-span_myprofile' + i + ''));
        //         parentDiv_myprofile.insertBefore(div_element_myprofile, document.getElementById('child-span_myprofile' + i + ''));
        //     }
        //     i++;
        //     document.getElementById('myprofile_skill_count').val = 1;
        // }
        i++;

        parentDiv_myprofile.insertBefore(span_element_myprofile, parentDiv_myprofile.firstChild);
        span_element_myprofile.appendChild(label_element_myprofile, span_element_myprofile.firstChild);
        label_element_myprofile.insertBefore(i_element_myprofile, label_element_myprofile.firstChild);
        label_element_myprofile.insertBefore(input_element_myprofile, label_element_myprofile.firstChild);
        $(this).val('');
    }
}

// タグのバツ印がクリックされた場合
$(document).on('click', '.far.fa-times-circle.skill_myprofile', function() {
    var k = 0,
        skills_myprofile = new Array(),
        skill_myprofile = document.getElementById("myprofile_skill"),
        spans_myprofile = skill_myprofile.getElementsByTagName("myprofile_span"),
        span_myprofile = $(this).parents(".skill_tag")[0].textContent;

    // skill_countの値を元に最終行のタグ情報を取得
    switch (document.getElementById('myprofile_skill_count').val) {
        case 1:
            var spans_count_myprofile = spans_myprofile.length - 1;
            break;

        case 2:
            var spans_count_myprofile = spans_myprofile.length - 2;
            break;

        case 3:
            var spans_count_myprofile = spans_myprofile.length - 3;
            break;

        default:
    }
    for (i = spans_count_myprofile; i < spans_myprofile.length; i++) {
        skills_myprofile[k] = spans_myprofile[i].textContent;
        k++;
    }
    $(this).parents(".skill_tag").remove();

    skills_myprofile = skills_myprofile.join('');
    if (skills_myprofile.indexOf(span_myprofile) != -1) {
        document.getElementById('myprofile_skill_count').val -= 1;
    }
});

// プロフィール編集のキャンセルボタン押下時
$(document).on('click', ".profile_close", function() {
    $('.edit_name').replaceWith('<h2 class="profile_name">' + user_name + '</h2>');
    $('.edit_workhistory').replaceWith('<p class="workhistory">' + user_workhistory + '</p>');
    $('.mypage').css('display', 'inline');
    $('.edit_profile_img').css('display', 'none');
    $('.btn_flex').css('display', 'none');
    $('.profile').removeClass('editing');
    $('.profile_edit_btn').fadeIn();
    $('.follow_user').fadeIn();
    $('.edit_btns').fadeOut();
    $('.col-3').css('margin-top', '0rem');
    $('.myprofile_btn').fadeIn();
    $('.form').fadeOut();
    $('.tag').css('display', 'inline-block');
});