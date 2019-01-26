<section class="l-site-640">

    <div class="p-movie-caption">
        <!-- タイトル  -->
        <h1 class="p-movie-caption__h1"><?php echo $title ?></h1>

        <!-- お気に入り登録ボタン  -->
        <i class="fas fa-heart p-movie-caption__i p-icn-like js-click-like <?php if($isFavorite){ echo 'active'; } ?>" aria-hidden="true" data-movie_id="<?php echo $movie_id ?>" ></i>
    </div>

    <!-- 動画再生  -->
    <div class="p-movie-container">
        <?php echo $embed_tag ?>
    </div>

    <!--  コメント入力  -->
    <h2>コメントを残す</h2>
    <div id="review_input">
        <review-input :movie_id="<?php echo $movie_id ?>"></review-input>
    </div>

    <!--  コメント一覧  -->
    <div id="review_list">
        <review-panel-list :movie_id="<?php echo $movie_id ?>"></review-panel-list>
    </div>

</section>
