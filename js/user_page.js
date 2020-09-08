$(document).on('click','.favorite_btn',function(e){
    e.stopPropagation();
    var $this = $(this),
        $profile_count = $('.profile_count + .favorite > a > .count_num'),
        page_id = get_param('page_id'),
        post_id = $this.prev().val();
        //prev()は$thisの直前にあるhtml要素を取得する
        //val()は取得したいhtml要素のval値を取得する

    $.ajax({
        type: 'POST',
        url: 'ajax_post_favorite_process.php',
        dataType: 'json',
        data: { page_id: page_id,
                post_id: post_id}
    }).done(function(data){
      // php側でエラーが発生したらリロードしてエラーメッセージを表示させる
      if(data ==="error"){
        location.reload();
      }else{
        // プロフィール内のカウントを更新する
        $profile_count.text(data['profile_count']);
        // 投稿内のカウントを更新する
        $this.next('.post_count').text(data['post_count']);
        // アイコンを切り替える
        $this.children('i').toggleClass('fas');
        $this.children('i').toggleClass('far');
      }
    }).fail(function() {
      location.reload();
    });
  });

  //いいね機能実装中