<footer>
    Copyright DOGA-CURATION <?=date('Y')?>. All Rights Reserved.
</footer>

<script src="https://cdn.jsdelivr.net/npm/vue@2.5.21/dist/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.js"></script>
<script src="https://code.jquery.com/jquery-3.0.0.min.js"   integrity="sha256-JmvOoLtYsmqlsWxa7mDSLMwa6dZ9rrIdtrrVYRnDRH0="   crossorigin="anonymous"></script>
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

    //評価入力
    Vue.component('review-input', {
        props:['movie_id'],
        data:  ()=> {
            return {
                star_count: 1,
                input_text: ''
            }
        },
        methods:{
            //星がクリックされた
            onStarChange: function (e) {

                let base_attr = e.currentTarget.getAttribute('class')
                this.star_count = 0

                //押された☆の左側をactiveにする
                base_attr = base_attr.replace(' active','')
                let el = e.currentTarget.previousElementSibling
                while (el) {
                    el.setAttribute('class',base_attr + ' active')
                    el = el.previousElementSibling;
                    this.star_count++
                }
                //押された☆をactiveにする
                e.currentTarget.setAttribute('class',base_attr + ' active')
                this.star_count++

                //押された☆の右側を非activeにする
                el = e.currentTarget.nextElementSibling
                while (el) {
                    el.setAttribute('class',base_attr)
                    el = el.nextElementSibling
                }
            },
            onKeyUp: function(e){
                this.input_text = e.currentTarget.value
            },
            //送信ボタンクリック
            onSubmit: function (e) {

                axios.post('http://localhost/curation/public/comments/list.json', {
                    movie_id: this.movie_id,
                    comment:  this.input_text,
                    review:   this.star_count
                })
            }
        },
        template:
            `
                <div class="root">
                    <div class="review-star-input">
                        <i class="fas fa-star icn-star active" @click="onStarChange"></i>
                        <i class="fas fa-star icn-star " @click="onStarChange"></i>
                        <i class="fas fa-star icn-star " @click="onStarChange"></i>
                        <i class="fas fa-star icn-star " @click="onStarChange"></i>
                        <i class="fas fa-star icn-star " @click="onStarChange"></i>
                    </div>
                    <div class="review-text-input">
                        <textarea @keyup="onKeyUp" name="comment" id="" cols="10" rows="10" placeholder="どうでしたか？"></textarea>
                        <button @click="onSubmit">送信</button>
                    </div>
                </div>
             `
    })

    //評価パネルリスト
    Vue.component('review-panel-list', {
        props:['movie_id'],
        data () {
            return {
                info: null
            }
        },
        mounted () {
            let url = 'http://localhost/curation/public/comments/list.json?movie_id=' + this.movie_id
            console.log(url)
            axios
                .get(url)
                .then(response => (this.info = response.data))
        },
        template: `
                    <div>
                        <review-panel v-for="comment in info.comment_list" :comment="comment"></review-panel>
                    </div>
                  `
    })

    //評価パネル
    Vue.component('review-panel', {
        props:['comment'],
        computed: {
            Review: function (){
                return Number(this.comment.review)
            },
            zeroReview: function () {
                return 5 - this.comment.review
            }
        },
        template: `
                    <div class="review-area">
                        <ul>
                            <li v-for="n in this.Review" ><i class="fas fa-star icn-star active"></i></li>
                            <li v-for="n in this.zeroReview" ><i class="fas fa-star icn-star "></i></li>
                        </ul>
                        <p>{{comment.user_name}}{{comment.created_at}}</p>
                        <p>{{comment.comment}}</p>
                    </div>
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

    new Vue({
        el: '#review_input',
        data () {
            return {
                info: null
            }
        }
    })

    new Vue({
        el: '#review_list'
    })

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