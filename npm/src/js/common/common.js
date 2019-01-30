import Vue from 'vue'
import $ from 'jquery';

//イベントハブ
let eventHub = new Vue()

$(function() {

  var $toggleMsg = $('.js-toggle-msg');
  if($toggleMsg.length){
    $toggleMsg.slideDown();
    setTimeout(function(){ $toggleMsg.slideUp(); },3000);
  }

  // お気に入り登録・削除
  var $like,
      likeMovieId;
  $like = $('.js-click-like') || null;
  likeMovieId = $like.data('movie_id') || null;
  if(likeMovieId !== undefined && likeMovieId !== null){
    $like.on('click',function(){
      var $this = $(this);

      $.ajax({
        type: "POST",
        url: "api/favorites.php",
        data: { movieId : likeMovieId}
      }).done(function( data ){
        console.log('Ajax Success');
        // クラス属性をtoggleでつけ外しする
        $this.toggleClass('p-icn-like--active');

      }).fail(function( msg ) {
        console.log('Ajax Error');
      });
    });

    // フッターを最下部に固定
    var $ftr = $('footer');
    if (window.innerHeight > $ftr.offset().top + $ftr.outerHeight()) {
      $ftr.attr({'style': 'position:fixed; top:' + (window.innerHeight - $ftr.outerHeight()) + 'px;'});
    }
  }

});
