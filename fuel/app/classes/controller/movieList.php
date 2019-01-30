<?php

class Controller_MovieList extends Controller{

    public function action_index(){

        //変数としてビューを割り当てる
        $view = View::forge('template/index');
        $view->set('head',View::forge('template/head'));
        $view->set('header',View::forge('template/header'));
        $vv = View::forge('movieList');
        $view->set('contents',$vv);
        $view->set('footer',View::forge('template/footer'));
        $vvv = View::forge('template/script');
        $vvv->set('jsname','movielist');
        $view->set('script',$vvv);
        return $view;

    }

}

