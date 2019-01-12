<div class="ctn-main">

    <section class="site-width">
        <div id="movie_list">
            <h1>動画一覧</h1>
            <search-result-header :start_idx="info.start_idx" :end_idx="info.end_idx"></search-result-header>

            <div class="panel-list">
                <thumb-panel
                    v-for="movie in info.movie_list"
                    v-bind:movie_id="movie.movie_id"
                    v-bind:title="movie.title"
                ></thumb-panel>
            </div>
            <div class="pagination">
                <pagenation :pages="info.pages"></pagenation>
            </div>

    <!--            --><?php
    //            foreach ($movie_list as $rec):
    //            ?>
<!--                    <a href="movieDetail.php?movie_id=--><?php //echo $rec['movie_id'] ?><!--" class="panel">-->
<!--                        <img src="./assets/img/--><?php //echo $rec['movie_id'] ?><!--.jpg" alt="--><?php //echo $rec['title'] ?><!--">-->
<!--                        <p class="panel-title">--><?php //echo $rec['title'] ?><!--</p>-->
<!--                    </a>-->
    <!--            --><?php
    //            endforeach;
    //            ?>
<!--            </div>-->
<!--            <div class="pagination">-->
<!--                <ul class="pagination-list">-->
<!--                    --><?php
//                    for($p = $start_page; $p <= $end_page; ++$p):
//                    ?>
<!--                        <li class="list-item"><a href="?page=--><?php //echo $p ?><!--">--><?php //echo $p ?><!--</a></li>-->
<!--                    --><?php
//                    endfor;
//                    ?>
<!--                </ul>-->
<!--            </div>-->
        </div>
    </section>
</div>