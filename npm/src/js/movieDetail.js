import Vue from 'vue'
import axios from 'axios';
import $ from 'jquery';
import moment from 'moment';

//イベントハブ
let eventHub = new Vue()

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
      base_attr = base_attr.replace(' p-icn-star--active','')
      let el = e.currentTarget.previousElementSibling
      while (el) {
        el.setAttribute('class',base_attr + ' p-icn-star--active')
        el = el.previousElementSibling;
        this.star_count++
      }
      //押された☆をactiveにする
      e.currentTarget.setAttribute('class',base_attr + ' p-icn-star--active')
      this.star_count++

      //押された☆の右側を非activeにする
      el = e.currentTarget.nextElementSibling
      while (el) {
        el.setAttribute('class',base_attr + ' p-icn-star')
        el = el.nextElementSibling
      }
    },
    onKeyUp: function(e){
      this.input_text = e.currentTarget.value
    },
    //送信ボタンクリック
    onSubmit: function (e) {

      axios.post('http://localhost/curation/public/api/comments/list.json', {
        movie_id: this.movie_id,
        comment:  this.input_text,
        review:   this.star_count
      }).then(response => {
        eventHub.$emit('comment-update',this.movie_id)
      }).catch(error => {
        console.log(error);
      });

    }
  },
  template:
      `
                <div class="root">
                    <div class="review-star-input">
                        <i class="fas fa-star p-icn-star--active" @click="onStarChange"></i>
                        <i class="fas fa-star p-icn-star " @click="onStarChange"></i>
                        <i class="fas fa-star p-icn-star " @click="onStarChange"></i>
                        <i class="fas fa-star p-icn-star " @click="onStarChange"></i>
                        <i class="fas fa-star p-icn-star " @click="onStarChange"></i>
                    </div>
                    <div class="p-review-text-input">
                        <textarea class="p-review-text-input__textarea" @keyup="onKeyUp" name="comment" id="" cols="10" rows="10" placeholder="どうでしたか？"></textarea>
                        <button class="p-review-text-input__button" @click="onSubmit">送信</button>
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
  methods:{
    onCommentUpdate: function (movie_id) {
      let url = 'http://localhost/curation/public/api/comments/list.json?movie_id=' + movie_id
      axios
          .get(url)
          .then(response => (this.info = response.data))
      console.log(this.info)
    }
  },
  created(){
    eventHub.$on('comment-update', this.onCommentUpdate)
  },
  beforeDestroy() {
    eventHub.$off('comment-update', this.onCommentUpdate)
  },
  mounted () {
    this.onCommentUpdate(this.movie_id)
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
    },
    fromNow: function (){
      var date = this.comment.created_at
      moment.locale( 'ja' )
      return moment(date, 'YYYY/MM/DD HH:mm:S').fromNow()
    }
  },
  template: `
                    <div class="p-review-area">
                        <ul class="p-review-area__ul">
                            <li class="p-review-area__ul__li" v-for="n in this.Review" ><i class="fas fa-star p-icn-star--active"></i></li>
                            <li class="p-review-area__ul__li" v-for="n in this.zeroReview" ><i class="fas fa-star p-icn-star "></i></li>
                        </ul>
                        <p>{{comment.user_name}}<span class="u-from-now">{{this.fromNow}}</span></p>
                        <p>{{comment.comment}}</p>
                    </div>
                  `
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

