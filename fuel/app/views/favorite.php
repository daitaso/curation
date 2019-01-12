<div class="ctn-main">
    <section class="site-width">
        <h1>お気に入り一覧</h1>
        <div class="panel-list">
            <?php
            foreach ($movie_list as $rec):
                ?>
                <a href="movieDetail.php?movie_id=<?php echo $rec['movie_id'] ?>" class="panel">
                    <img src="./assets/img/<?php echo $rec['movie_id'] ?>.jpg" alt="<?php echo $rec['title'] ?>">
                    <p class="panel-title"><?php echo $rec['title'] ?></p>
                </a>
            <?php
            endforeach;
            ?>
        </div>
    </section>
</div>