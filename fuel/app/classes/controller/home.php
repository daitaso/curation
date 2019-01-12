<?php

// ホーム
class Controller_Home extends Controller
{
    public function action_index()
    {
        // リダイレクト
        Response::redirect('movieList');

        return ;
    }
}

