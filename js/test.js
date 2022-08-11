window.onload = function() {
    // テストケースが優先度によって色が変わるようにする
    for (i = 0; i < $('.priority').length - 1; i++) {
        console.log($('.priority .priority_input')[i].value);
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
    }
}

// テストケースの詳細画面表示
$(document).on('click', '.priority', function() {
    var $target_modal = $(this).data("target"),
        test_id = $target_modal.substring(10),
        $user_id = $('' + $target_modal + ' .priority_user_id')[0].value,
        $current_user_id = $('' + $target_modal + ' .user_id')[0].value;
    console.log($user_id);
    console.log($current_user_id);
    $('.testcase_disp').fadeIn();
    $('.modal_testcase').fadeIn();
    $('.testcase_clear').fadeIn();
    if ($current_user_id == $user_id) {
        console.log("test1");
        $('.testcase_disp .testcase_text').replaceWith('<span class="testcase_text">' + $($target_modal + ' > span')[0].textContent + '</span>');
    } else {
        console.log("test2");
        $('.testcase_disp .testcase_text').replaceWith('<span class="testcase_text" style="pointer-events: none">' + $($target_modal + ' > span')[0].textContent + '</span>');
    }
    $('.testcase_disp .test_user_img')[0].setAttribute('src', $($target_modal + ' > .test_user_info > span > img')[0].getAttribute('src'));
    $('.testcase_disp .testcase_created_at').replaceWith('<span class="testcase_created_at">' + $($target_modal + ' > .test_user_info > .created_at')[0].textContent + '</span>');
    $('.testcase_disp .testcase_name').replaceWith('<span class="testcase_name">' + $($target_modal + ' > .test_user_info > span > .testcase_name')[0].textContent + '</span>');
    $('.testcase_disp .testcase_id').replaceWith('<input class="testcase_id" type="hidden" value="' + test_id + '">');
    $(document).on('click', '.testcase_clear', function() {
        $('.testcase_disp').fadeOut();
        $('.modal_testcase').fadeOut();
        $('.testcase_clear').fadeOut();
    });
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
                test_text: edit_test_text
            }
        }).done(function() {
            $('#edit_testcase_' + $test_id).replaceWith('<span class="testcase_text">' + edit_test_text + '</span>');
            $('#testcase_' + $test_id + ' .testcase_text').replaceWith('<span class="testcase_text">' + edit_test_text + '</span>');
            $('.testcase_disp .testcase_clear')[0].disabled = false;
            $('.testcase_error').fadeOut();
        }).fail(function() {});
    });
});