<footer>
    Copyright DOGA-CURATION <?=date('Y')?>. All Rights Reserved.
</footer>

<script src="https://cdn.jsdelivr.net/npm/vue@2.5.21/dist/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.js"></script>
<script src="https://code.jquery.com/jquery-3.0.0.min.js"   integrity="sha256-JmvOoLtYsmqlsWxa7mDSLMwa6dZ9rrIdtrrVYRnDRH0="   crossorigin="anonymous"></script>
<?=Asset::js('jquery.barrating.min.js')?>
<?=Asset::js('fixfooter.js')?>

<script>

    //イベントハブ
    let eventHub = new Vue()

    //検索結果ヘッダー
    Vue.component('search-result-header', {
        props:['start_idx','end_idx','keyword'],
        template: `
                    <h2>検索結果　{{ start_idx + 1 }}　―　{{ end_idx }} キーワード　{{keyword}}</h2>
                  `
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
        props:['pages','keyword'],
        template: `
                    <ul class="pagination-list">
                        <li class="list-item" v-for="page in pages">
                            <button  v-on:click="$emit('page-change',page,keyword)">{{page}}</button>
                        </li>
                    </ul>
                  `
    })

    //タグパネル
    Vue.component('tag-panel', {
        props:['keyword'],
        methods: {
            onTagChange: function (keyword) {
                eventHub.$emit('tag-change',1,keyword)
            }
        },
        template:
                  `
                    <button  v-on:click="onTagChange(keyword)">{{keyword}}</button>
                  `
    })

    new Vue({
        el: '#movie_list',
        data () {
            return {
                info: null
            }
        },
        methods: {
            onPageChange: function (page,keyword) {
                let url = 'http://localhost/curation/public/movies/list.json?page=' + page
                if(keyword !== null){
                    url += '&keyword=' + keyword
                }
                axios
                    .get(url)
                    .then(response => (this.info = response.data))
            }
        },
        created(){
            eventHub.$on('tag-change', this.onPageChange)
        },
        beforeDestroy() {
            eventHub.$off('tag-change', this.onPageChange)
        },
        mounted () {
            this.onPageChange(1,null)
        }

    })

    new Vue({
        el: '#favorite_list',
        data () {
            return {
                info: null
            }
        },
        methods: {
            onPageChange: function (page) {
                axios
                    .get('http://localhost/curation/public/movies/list.json?page=' + page + '&favorite=on')
                    .then(response => (this.info = response.data))
            }
        },
        mounted () {

            this.onPageChange(1)
        }

    })

    new Vue({
        el: '#tag_list',
        data () {
            return {
                info: null
            }
        },
        mounted () {
            axios
                .get('http://localhost/curation/public/tags/list.json')
                .then(response => (this.info = response.data))
        },
        created(){
        }
    })

    $(function() {

        var $toggleMsg = $('.js-toggle-msg');
        if($toggleMsg.length){
            $toggleMsg.slideDown();
            setTimeout(function(){ $toggleMsg.slideUp(); },3000);
        }

        //星５段階評価
        $('#example').barrating({
            theme: 'fontawesome-stars'
        });

        // お気に入り登録・削除
        var $like,
            likeMovieId;
        $like = $('.js-click-like') || null; //nullというのはnull値という値で、「変数の中身は空ですよ」と明示するためにつかう値
        likeMovieId = $like.data('movie_id') || null;
        // 数値の0はfalseと判定されてしまう。product_idが0の場合もありえるので、0もtrueとする場合にはundefinedとnullを判定する
        if(likeMovieId !== undefined && likeMovieId !== null){
            $like.on('click',function(){
                var $this = $(this);
                $.ajax({
                    type: "POST",
                    url: "ajaxLike.php",
                    data: { movieId : likeMovieId}
                }).done(function( data ){
                    console.log('Ajax Success');
                    // クラス属性をtoggleでつけ外しする
                    $this.toggleClass('active');
                }).fail(function( msg ) {
                    console.log('Ajax Error');
                });
            });
        }

    });
</script>