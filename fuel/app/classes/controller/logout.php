<?php

// ログアウト
class Controller_Logout extends Controller{

    public function action_index(){

        Auth::logout();

        // リダイレクト
        Response::redirect('home');

        return ;

    }
}

