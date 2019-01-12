<div class="ctn-main">
    <section class="site-width">

        <div>
            <h1><?php echo $title ?></h1>
            <i class="fa fa-heart icn-like js-click-like <?php if($isFavorite){ echo 'active'; } ?>" aria-hidden="true" data-movie_id="<?php echo $movie_id ?>" ></i>
        </div>
        <?php echo $embed_tag ?>
        <h1>コメント一覧</h1>
        <?php
        $result = DB::query('SELECT * FROM COMMENT WHERE movie_id = '.$movie_id.' ORDER BY CREATED_AT DESC', DB::SELECT)->execute();
        foreach ($result as $rec):
            ?>
            <p><?php echo $rec['created_at'] ?></p>
            <p><?php echo $rec['user_name'] ?></p>
            <p><?php echo $rec['review'] ?></p>
            <p><?php echo $rec['comment'] ?></p>
        <?php
        endforeach;
        ?>
        <h1>コメント入力欄</h1>
        <?=$comment?>

    </section>
</div>