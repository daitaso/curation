<?php
/**
 * Created by PhpStorm.
 * User: daitaso
 * Date: 2019/01/10
 * Time: 22:56
 */
class Controller_Api_Movies extends Controller_Rest{

    const PAGE_DATA_NUM                  = 12;     //１ページあたりに表示する、明細データの表示件数
    const PAGENATION_MAX_PAGE_NUM        =  5;     //ページネーションで一度に表示する最大ページリンク数

    public function get_list(){

        //GETパラメータ取得
        $keyword  = Input::Get('keyword');
        $page     = Input::Get('page');
        $favorite = Input::Get('favorite');
        $category = Input::Get('category');

        if(is_null($page)){
            $page = 1;  //page指定が無い時は1ページ目とみなす
        }
        $limit_offset = 'LIMIT '.self::PAGE_DATA_NUM.' OFFSET '.(($page - 1) * self::PAGE_DATA_NUM);

        $sql = '';
        if(is_null($favorite)) {
            //通常検索orタグ検索orカテゴリー検索
            if(!is_null($keyword)){
                $sql = 'SELECT * FROM MOVIE_LIST INNER JOIN SEARCH_TAGS ON MOVIE_LIST.MOVIE_ID = SEARCH_TAGS.MOVIE_ID WHERE SEARCH_TAGS.KEYWORD = \''.$keyword.'\' ORDER BY MOVIE_LIST.CREATED_AT DESC ';
            }else if(!is_null($category)) {
                $sql = 'SELECT * FROM MOVIE_LIST WHERE MOVIE_LIST.SITE_ID = \''.$category.'\' ORDER BY MOVIE_LIST.CREATED_AT DESC ';
            }else{
                $sql = 'SELECT * FROM MOVIE_LIST ORDER BY MOVIE_LIST.CREATED_AT DESC ';
            }
        }else{
            //お気に入り一覧
            $sql = 'SELECT * FROM MOVIE_LIST INNER JOIN FAVORITE ON MOVIE_LIST.MOVIE_ID = FAVORITE.MOVIE_ID WHERE FAVORITE.USERNAME = \''.Auth::get_screen_name().'\'' ;
        }
        //レコード総件数取得
        $result = DB::query($sql,DB::SELECT)->execute();
        $total_rec_num = count($result);

        //カレントページ分のレコードを取得
        $sql = $sql.$limit_offset;
        $result = DB::query($sql,DB::SELECT)->execute();

        //全データから生成される全ページ数を求める
        $total_page_num = (int)floor($total_rec_num / self::PAGE_DATA_NUM);
        if($total_rec_num % self::PAGE_DATA_NUM !== 0) ++$total_page_num;

        //開始ページ数（ページネーション）
        $start_page = $page;
        for($i = 1; $i <= ((self::PAGENATION_MAX_PAGE_NUM - 1) / 2);++$i){
            if($page - $i === 0) break;
            $start_page = $page - $i;
        }

        //終了ページ数（ページネーション）
        $end_page = $start_page + self::PAGENATION_MAX_PAGE_NUM - 1;
        if($end_page > $total_page_num) $end_page = $total_page_num;

        //カレントページが全データ中最後のページと、その１つ前の時に、開始ページを補正する
        if((int)$page === $total_page_num     && $start_page - 2 > 0) $start_page -= 2;
        if((int)$page === $total_page_num - 1 && $start_page - 1 > 0) $start_page -= 1;

        //ページ番号配列作成
        $pages = range($start_page,$end_page);

        //表示データインデックス（ヘッダー用）
        $start_idx = ($page - 1) * self::PAGE_DATA_NUM;
        $end_idx   = $start_idx + count($result);

        return $this->response(array(
            'movie_list' => $result,
            'pages'      => $pages,
            'cur_page'   => $page,
            'start_idx'  => $start_idx,
            'end_idx'    => $end_idx,
            'keyword'    => $keyword,
            'category'   => $category
        ));
    }
}