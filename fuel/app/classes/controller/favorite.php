<?php

//
// お気に入り一覧
//
class Controller_Favorite extends Controller{

    public function action_index(){

        //変数としてビューを割り当てる
        $view = View::forge('template/index');
        $view->set('head',View::forge('template/head'));
        $view->set('header',View::forge('template/header'));
        $vv = View::forge('favorite');
        $view->set('contents',$vv);
        $view->set('footer',View::forge('template/footer'));

        // レンダリングした HTML をリクエストに返す
        return $view;
    }
}

