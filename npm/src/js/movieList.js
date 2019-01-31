import Vue from 'vue'
import axios from 'axios';
import $ from 'jquery';
import moment from 'moment';

//イベントハブ
let eventHub = new Vue()

//検索結果ヘッダー
Vue.component('search-result-header', {
  props:['start_idx','end_idx','keyword','category'],
  template: `
                    <h1>検索結果　{{ start_idx + 1 }}　―　{{ end_idx }} キーワード　{{keyword}} カテゴリー {{category}}</h1>
                  `
})

//サムネイルパネル
Vue.component('thumb-panel', {
  props:['movie_id','title','created_at'],
  computed: {
    fromNow: function (){
      var date = this.created_at;
      moment.locale( 'ja' );
      return moment(date, 'YYYY/MM/DD HH:mm:S').fromNow();
    }
  },
  template: `
                    <a :href="'movieDetail.php?movie_id=' + movie_id " class="p-panel-list__panel">
                        <img class ="p-panel-list__panel__img" :src="'./assets/img/thumb/' + movie_id + '.jpg'" :alt="title">
                        <p class="p-panel-list__panel__title">{{title}}</p>
                        <span class="p-panel-list__panel__fromnow">{{this.fromNow}}</span>
                    </a>
                  `
})

//ページネーション
Vue.component('pagenation', {
  props:['pages','keyword','cur_page'],
  computed: {
    createPushClass : function () {
      let cur_page = this.cur_page
      self = this;
      return function (page) {
        if(Number(page) === Number(cur_page)){
          return 'p-pagination__list__list-item__button--select'
        }
        return '';
      };
    }
  },
  template: `
                <ul class="p-pagination__list">
                    <li class="p-pagination__list__list-item" v-for="page in pages">
                        <button class="p-pagination__list__list-item__button" v-bind:class="createPushClass(page)" v-on:click="$emit('page-change',page,keyword,null)">{{page}}</button>
                    </li>
                </ul>
             `
})

//タグパネル
Vue.component('tag-panel', {
  props:['keyword'],
  methods: {
    onTagChange: function (keyword) {

      if(keyword === '未指定'){
        keyword = null
      }
      eventHub.$emit('tag-change',1,keyword,null)
    }
  },
  template:
      `
                    <button class="p-tag-button " v-on:click="onTagChange(keyword,$event)">{{keyword}}</button>
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
    onPageChange: function (page,keyword,category) {
      let url = 'http://localhost/curation/public/api/movies/list.json?page=' + page
      if(keyword !== null){
        url += '&keyword=' + keyword
      }
      if(category !== null){
        url += '&category=' + category
      }
      axios
          .get(url)
          .then(response => (this.info = response.data))
    }
  },
  created(){
    eventHub.$on('tag-change', this.onPageChange)
    eventHub.$on('category-change',this.onPageChange)
  },
  beforeDestroy() {
    eventHub.$off('tag-change', this.onPageChange)
    eventHub.$off('category-change',this.onPageChange)

  },
  mounted () {
    this.onPageChange(1,null,null)
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
        .get('http://localhost/curation/public/api/tags/list.json')
        .then(response => (this.info = response.data))
  },
  created(){
  }
})

$(function() {

  //カテゴリーが変更されたら
  $('select').change(function () {
    var val = $(this).val() || null;
    eventHub.$emit('category-change', 1, null, val)
  });

})