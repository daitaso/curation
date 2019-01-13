<div class="ctn-main">
    <section id="contents" class="site-width">
        <div id="sidebar">
            <h1>条件指定</h1>
            <h2>タグ</h2>
            <div id="tag_list">
                <tag-panel
                        v-for="tag in info.tag_list"
                        v-bind:keyword="tag.keyword"
                ></tag-panel>
            </div>
        </div>
        <div id="main">
            <h1>動画一覧</h1>
            <div id="movie_list">
                <search-result-header :start_idx="info.start_idx" :end_idx="info.end_idx" :keyword="info.keyword"></search-result-header>
                <div class="panel-list">
                    <thumb-panel
                        v-for="movie in info.movie_list"
                        v-bind:movie_id="movie.movie_id"
                        v-bind:title="movie.title"
                    ></thumb-panel>
                </div>
                <div class="pagination">
                    <pagenation :pages="info.pages" :keyword="info.keyword" v-on:page-change="onPageChange"></pagenation>
                </div>
            </div>
        </div>
    </section>
</div>