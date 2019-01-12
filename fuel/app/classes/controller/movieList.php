<?php

class Controller_MovieList extends Controller{

    const PAGE_DATA_NUM                  = 12;     //１ページあたりに表示する、明細データの表示件数
    const PAGENATION_MAX_PAGE_NUM        =  5;     //ページネーションで一度に表示する最大ページリンク数

    public function action_index(){

//        //GETパラメータ取得
//        $keyword = Input::Get('keyword');
//        $page    = Input::Get('page');
//        if(is_null($page)){
//            $page = 1;  //page指定が無い時は1ページ目とみなす
//        }
//
//        $limit_offset = 'LIMIT '.self::PAGE_DATA_NUM.' OFFSET '.(($page - 1) * self::PAGE_DATA_NUM);
//        $sql = '';
//        if(!is_null($keyword)){
//            $sql = 'SELECT * FROM MOVIE_LIST INNER JOIN SEARCH_TAGS ON MOVIE_LIST.MOVIE_ID = SEARCH_TAGS.MOVIE_ID WHERE SEARCH_TAGS.KEYWORD = \''.$keyword.'\'';
//        }else{
//            $sql = 'SELECT * FROM MOVIE_LIST ';
//        }
//        //レコード総件数取得
//        $result = DB::query($sql,DB::SELECT)->execute();
//        $total_rec_num = count($result);
//
//        //カレントページ分のレコードを取得
//        $sql = $sql.$limit_offset;
//        $result = DB::query($sql,DB::SELECT)->execute();
//
//        //全データから生成される全ページ数を求める
//        $total_page_num = (int)floor($total_rec_num / self::PAGE_DATA_NUM);
//        if($total_rec_num % self::PAGE_DATA_NUM !== 0) ++$total_page_num;
//
//        //開始ページ数（ページネーション）
//        $start_page = $page;
//        for($i = 1; $i <= ((self::PAGENATION_MAX_PAGE_NUM - 1) / 2);++$i){
//            if($page - $i === 0) break;
//            $start_page = $page - $i;
//        }
//
//        //終了ページ数（ページネーション）
//        $end_page = $start_page + self::PAGENATION_MAX_PAGE_NUM - 1;
//        if($end_page > $total_page_num) $end_page = $total_page_num;
//
//        //カレントページが全データ中最後のページと、その１つ前の時に、開始ページを補正する
//        if((int)$page === $total_page_num     && $start_page - 2 > 0) $start_page -= 2;
//        if((int)$page === $total_page_num - 1 && $start_page - 1 > 0) $start_page -= 1;
//
//        //表示データインデックス（ヘッダー用）
//        $start_idx = ($page - 1) * self::PAGE_DATA_NUM;
//        $end_idx   = $start_idx + self::PAGE_DATA_NUM;

//        Log::info('total_rec_num'.$total_rec_num);
//        Log::info('total_page_num'.$total_page_num);
//        Log::info('start_page'.$start_page);
//        Log::info('end_page'.$end_page);
//        Log::info('page'.$page);

        //変数としてビューを割り当てる
        $view = View::forge('template/index');
        $view->set('head',View::forge('template/head'));
        $view->set('header',View::forge('template/header'));
        $vv = View::forge('movieList');

//        $vv->set('movie_list',$result);
//        $vv->set('start_page',$start_page);
//        $vv->set('end_page',$end_page);
//        $vv->set('start_idx',$start_idx);
//        $vv->set('end_idx',$end_idx);

        $view->set('contents',$vv);
        $view->set('footer',View::forge('template/footer'));

        return $view;

    }

}

