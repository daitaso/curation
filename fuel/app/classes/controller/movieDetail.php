<?php

class Controller_MovieDetail extends Controller{

    public function action_index(){

        $args = array();

        //GETパラメータで動画ＩＤ取得
        $movie_id = Input::Get('movie_id');

        //動画リストテーブルから情報を取得
        $result = DB::query('SELECT * FROM MOVIES WHERE movie_id = '.'\''.$movie_id.'\'', DB::SELECT)->execute();
        $args['embed_tag'] = $result[0]['embed_tag'];
        $args['title'] = $result[0]['title'];

        //お気に入り情報存在チェック
        $isFavorite = false;
        if(Auth::check()){
            $result = DB::query('SELECT * FROM FAVORITES WHERE movie_id = '.'\''.$movie_id.'\''.' AND username = \''.Auth::get_screen_name().'\'', DB::SELECT)->execute();
            if(count($result) === 1){
                $isFavorite = true;
            }
        }

        //変数としてビューを割り当てる
        $view = View::forge('template/index');
        $view->set('head',View::forge('template/head'));
        $view->set('header',View::forge('template/header'));
        $vv = View::forge('movieDetail');
        $vv->set('embed_tag',$args['embed_tag'],false);
        $vv->set('title',$args['title']);
        $vv->set('movie_id',$movie_id);
        $vv->set('isFavorite',$isFavorite);
        $view->set('contents',$vv);
        $view->set('footer',View::forge('template/footer'));
        $vvv = View::forge('template/script');
        $vvv->set('jsname','movieDetail');
        $view->set('script',$vvv);


        // レンダリングした HTML をリクエストに返す
        return $view;
    }

}

