import $ from 'jquery';

$(function() {

  //カテゴリーが変更されたら
  $('select').change(function() {
    var val = $(this).val() || null;
    eventHub.$emit('category-change',1,null,val)
  });

});
