<div class="ctn-main">
    <section class="site-width">
        <h1>タグ検索</h1>
        <?php
        $result = DB::query('SELECT DISTINCT keyword FROM SEARCH_TAGS ORDER BY keyword ASC', DB::SELECT)->execute();
        foreach ($result as $rec):
            ?>
            <a href="movieList.php?keyword=<?php echo $rec['keyword'] ?>"><?php echo $rec['keyword'] ?></a>
        <?php
        endforeach;
        ?>
    </section>
</div>