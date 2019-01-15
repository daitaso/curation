<div class="ctn-main">
    <section class="site-width">

        <div>
            <h1><?php echo $title ?></h1>
            <i class="fas fa-heart icn-like js-click-like <?php if($isFavorite){ echo 'active'; } ?>" aria-hidden="true" data-movie_id="<?php echo $movie_id ?>" ></i>
        </div>
        <?php echo $embed_tag ?>

        <h1>コメント入力欄</h1>
        <div id="review_input">
            <review-input :movie_id="<?php echo $movie_id ?>"></review-input>
        </div>

        <h1>コメント一覧</h1>
        <div id="review_list">
            <review-panel-list :movie_id="<?php echo $movie_id ?>"></review-panel-list>
        </div>

    </section>
</div>