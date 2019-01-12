<footer>
    Copyright DOGA-CURATION <?=date('Y')?>. All Rights Reserved.
</footer>

<script src="https://cdn.jsdelivr.net/npm/vue@2.5.21/dist/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.js"></script>
<!--<script src="https://code.jquery.com/jquery-3.0.0.min.js"   integrity="sha256-JmvOoLtYsmqlsWxa7mDSLMwa6dZ9rrIdtrrVYRnDRH0="   crossorigin="anonymous"></script>-->
<?//=Asset::js('jquery.barrating.min.js')?>
<?//=Asset::js('fixfooter.js')?>

<script>

    //検索結果ヘッダー
    Vue.component('search-result-header', {
        props:['start_idx','end_idx'],
        template: '<h2>検索結果　{{ start_idx + 1 }}　―　{{ end_idx }} </h2>'
    })

    //サムネイルパネル
    Vue.component('thumb-panel', {
        props:['movie_id','title'],
        template: `
                    <a :href="'movieDetail.php?movie_id=' + movie_id " class="panel">
                        <img :src="'./assets/img/' + movie_id + '.jpg'" :alt="title">
                        <p class="panel-title">{{title}}</p>
                    </a>
                  `
    })

    //ページネーション
    Vue.component('pagenation', {
        props:['pages'],
        template: `
                    <ul class="pagination-list">
                        <li class="list-item" v-for="page in pages">
                            <a :href="'http://localhost/curation/public/movieList?page=' + page">{{page}}</a>
                        </li>
                    </ul>

                  `
    })

    //<ul class="pagination-list">
    //    <?php
    //    for($p = $start_page; $p <= $end_page; ++$p):
    //    ?>
    //    <li class="list-item"><a href="?page=<?php //echo $p ?>//"><?php //echo $p ?>//</a></li>
    <?php
    //endfor;
    //?>
    //</ul>



    //<ul class="pagination-list">
    //    <?php
    //    for($p = $start_page; $p <= $end_page; ++$p):
    //    ?>
    //    <li class="list-item"><a href="?page=<?php //echo $p ?>//"><?php //echo $p ?>//</a></li>
    <?php
    //endfor;
    //?>
    //</ul>


    //<!--                <a href="movieDetail.php?movie_id=--><?php ////echo $rec['movie_id'] ?>//<!--" class="panel">-->
    //<!--                    <img src="./assets/img/--><?php ////echo $rec['movie_id'] ?>//<!--.jpg" alt="--><?php ////echo $rec['title'] ?>//<!--">-->
    //    <!--                    <p class="panel-title">--><?php ////echo $rec['title'] ?>//<!--</p>-->
    //    <!--                </a>-->


    new Vue({
        el: '#movie_list',
        data () {
            return {
                info: null
            }
        },
        mounted () {
            axios
                .get('http://localhost/curation/public/movies/list.json?')
                .then(response => (this.info = response.data))
        }
    })

    // $(function() {
    //
    //     var $toggleMsg = $('.js-toggle-msg');
    //     if($toggleMsg.length){
    //         $toggleMsg.slideDown();
    //         setTimeout(function(){ $toggleMsg.slideUp(); },3000);
    //     }
    //
    //     //星５段階評価
    //     $('#example').barrating({
    //         theme: 'fontawesome-stars'
    //     });
    //
    //     // お気に入り登録・削除
    //     var $like,
    //         likeMovieId;
    //     $like = $('.js-click-like') || null; //nullというのはnull値という値で、「変数の中身は空ですよ」と明示するためにつかう値
    //     likeMovieId = $like.data('movie_id') || null;
    //     // 数値の0はfalseと判定されてしまう。product_idが0の場合もありえるので、0もtrueとする場合にはundefinedとnullを判定する
    //     if(likeMovieId !== undefined && likeMovieId !== null){
    //         $like.on('click',function(){
    //             var $this = $(this);
    //             $.ajax({
    //                 type: "POST",
    //                 url: "ajaxLike.php",
    //                 data: { movieId : likeMovieId}
    //             }).done(function( data ){
    //                 console.log('Ajax Success');
    //                 // クラス属性をtoggleでつけ外しする
    //                 $this.toggleClass('active');
    //             }).fail(function( msg ) {
    //                 console.log('Ajax Error');
    //             });
    //         });
    //     }
    //
    // });
</script>