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
                <pagenation :pages="info.pages" v-on:page-change="onPageChange"></pagenation>
            </div>
        </div>
    </section>
</div>