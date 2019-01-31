<?php

//
// お気に入り一覧
//
class Controller_FavoriteList extends Controller{

    public function action_index(){

        //変数としてビューを割り当てる
        $view = View::forge('template/index');
        $view->set('head',View::forge('template/head'));
        $view->set('header',View::forge('template/header'));
        $vv = View::forge('favoriteList');
        $view->set('contents',$vv);
        $view->set('footer',View::forge('template/footer'));
        $vvv = View::forge('template/script');
        $vvv->set('jsname','favoriteList');
        $view->set('script',$vvv);

        // レンダリングした HTML をリクエストに返す
        return $view;
    }
}

