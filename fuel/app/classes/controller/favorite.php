<?php

//
// お気に入り一覧
//
class Controller_Favorite extends Controller{

    public function action_index(){

//        $sql = 'SELECT * FROM MOVIE_LIST INNER JOIN FAVORITE ON MOVIE_LIST.MOVIE_ID = FAVORITE.MOVIE_ID WHERE FAVORITE.USERNAME = \''.Auth::get_screen_name().'\'' ;
//        $result = DB::query($sql,DB::SELECT)->execute();

        //変数としてビューを割り当てる
        $view = View::forge('template/index');
        $view->set('head',View::forge('template/head'));
        $view->set('header',View::forge('template/header'));
        $vv = View::forge('favorite');
//        $vv->set('movie_list',$result);
        $view->set('contents',$vv);
        $view->set('footer',View::forge('template/footer'));

        // レンダリングした HTML をリクエストに返す
        return $view;
    }
}

