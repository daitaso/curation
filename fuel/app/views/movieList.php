<main class="site-width">
    <div id="sidebar">
        <h1>条件指定</h1>
        <h2>カテゴリー</h2>
        <h2>最近のタグ</h2>
        <div id="tag_list">
            <tag-panel
                    v-for="tag in info.tag_list"
                    v-bind:keyword="tag.keyword"
            ></tag-panel>
        </div>
    </div>
    <div id="main">
        <div id="movie_list">
            <search-result-header :start_idx="info.start_idx" :end_idx="info.end_idx" :keyword="info.keyword"></search-result-header>
            <div class="panel-list">
                <thumb-panel
                    v-for="movie in info.movie_list"
                    v-bind:movie_id="movie.movie_id"
                    v-bind:title="movie.title"
                    v-bind:created_at="movie.created_at"
                ></thumb-panel>
            </div>
            <div class="pagination">
                <pagenation :pages="info.pages" :keyword="info.keyword" v-on:page-change="onPageChange"></pagenation>
            </div>
        </div>
    </div>
</main>
