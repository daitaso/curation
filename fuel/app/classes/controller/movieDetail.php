<?php

class Controller_MovieDetail extends Controller{

    public function action_index(){

        //コメントフォーム
        $form = Fieldset::forge('commentform');

        //５段階評価
        $ops = array('1' => '1','2' => '2','3' => '3','4' => '4','5' => '5');
		$form->add('review', '５段階評価',
            array('options' => $ops, 'type' => 'select','id' => 'example'));

        //コメント入力テキストエリア
        $form->add('comment', 'コメント', array('type'=>'textarea','rows' => 6, 'cols' => 8, 'placeholder' => '感想をどうぞ！'))
            ->add_rule('required')
            ->add_rule('min_length', 1)
            ->add_rule('max_length', 255);

        //送信ボタン
        $form->add('submit', '', array('type'=>'submit', 'value'=>'送信'));

        $args = array();

        //GETパラメータで動画ＩＤ取得
        $movie_id = Input::Get('movie_id');

        //動画リストテーブルから情報を取得
        $result = DB::query('SELECT * FROM `movie_list` WHERE movie_id = '.$movie_id, DB::SELECT)->execute();

        $args['embed_tag'] = $result[0]['embed_tag'];
        $args['title'] = $result[0]['title'];

        //お気に入り情報存在チェック
        $isFavorite = false;
        if(Auth::check()){
            $result = DB::query('SELECT * FROM favorite WHERE movie_id = '.$movie_id.' AND username = \''.Auth::get_screen_name().'\'', DB::SELECT)->execute();
            if(count($result) === 1){
                $isFavorite = true;
            }
        }

        if(Input::method() === 'POST'){

            // バリデーションインスタンスを取得
            $val = $form->validation();
            if ($val->run()) {
                $formData = $val->validated();
                DB::insert('comment')->set(array('movie_id'=>$movie_id,'user_name'=>'ゲスト','comment'=>$formData['comment'],'created_at'=>date('Y-m-d H:i:s')))->execute();

            } else {
                // エラー格納
                $error = $val->error();
                // メッセージ格納
                Session::set_flash('errMsg','ユーザー登録に失敗しました！時間を置いてお試し下さい！');
            }
            // フォームにPOSTされた値をセット
            $form->repopulate();

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
        $view->set_global('comment', $form->build(Uri::create("movieDetail.php?movie_id=$movie_id")), false);


        // レンダリングした HTML をリクエストに返す
        return $view;
    }

}

