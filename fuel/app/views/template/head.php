<!--共通head要素(view)-->
<!--役割：全ページ共通のHTML5のhead要素です-->
<meta charset="utf-8">
<title>E-CURATION</title>

<!--ファビコン-->
<?php
echo html_tag('link', array(
'rel' => 'icon',
'href' => Asset::get_file('favicon.ico', 'img'),
));
?>
<!--メインCSS-->
<?= Asset::css('style.css') ?>

<!--日本語フォント-->
<link href="https://fonts.googleapis.com/css?family=Noto+Serif+SC:400,700&amp;subset=japanese" rel="stylesheet">

<!-- 5段階評価用☆マーク表示用css-->
<?= Asset::css('fontawesome-stars.css') ?>
