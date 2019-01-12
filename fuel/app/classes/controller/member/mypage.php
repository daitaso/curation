<?php

class Controller_Member_Mypage extends Controller
{
    public function action_index()
    {
        //変数としてビューを割り当てる
        $view = View::forge('template/index');
        $view->set('head',View::forge('template/head'));
        $view->set('header',View::forge('template/header'));
        $view->set('contents',View::forge('member/mypage'));
        $view->set('footer',View::forge('template/footer'));

        // レンダリングした HTML をリクエストに返す
        return $view;
    }
}

