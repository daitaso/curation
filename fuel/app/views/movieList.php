<main class="l-site-980">
    <div class="l-site-980__sidebar">
        <h1 class="u-mbs">条件指定</h1>
        <h2>カテゴリー</h2>
        <div id="select_list" class="u-mbs">
            <div class="selectdiv">
                <label>
                    <select>
                        <option value="" selected>全て</option>
                        <option value="X">XVIDEOS</option>
                        <option value="F">FC2</option>
                        <option value="T">TOKYOMOTION</option>
                    </select>
                </label>
            </div>
        </div>

        <h2>最近のタグ</h2>
        <div id="tag_list">
            <tag-panel
                    v-for="tag in info.tag_list"
                    v-bind:keyword="tag.keyword"
            ></tag-panel>
        </div>
    </div>
    <div class="l-site-980__contents">
        <div id="movie_list">
            <search-result-header :start_idx="info.start_idx" :end_idx="info.end_idx" :keyword="info.keyword" :category="info.category"></search-result-header>
            <div class="p-panel-list ">
                <thumb-panel
                    v-for="movie in info.movie_list"
                    v-bind:movie_id="movie.movie_id"
                    v-bind:title="movie.title"
                    v-bind:created_at="movie.created_at"
                ></thumb-panel>
            </div>
            <div class="p-pagination">
                <pagenation :pages="info.pages" :keyword="info.keyword" v-on:page-change="onPageChange"></pagenation>
            </div>
        </div>
    </div>
</main>
