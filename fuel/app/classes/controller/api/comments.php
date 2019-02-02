<?php
//
// CommentsテーブルＡＰＩ
//
// 役割：DBのコメントテーブルへのアクセスAPI
//
class Controller_Api_Comments extends Controller_Rest{

    //
    // コメントリストの取得
    //
    // パラメータ（GET)
    // :movie_id 動画ID
    //
    // 返却値
    // :CommentsテーブルクエリのJSON
    //
    public function get_list(){

        $movie_id  = Input::Get('movie_id');

        $result = DB::query('SELECT * FROM COMMENTS WHERE movie_id = '.'\''.$movie_id.'\''.' ORDER BY CREATED_AT DESC', DB::SELECT)->execute();

        return $this->response(array(
            'comment_list' => $result
        ));
    }

    //
    // コメントの投稿
    //
    // パラメータ（POST)
    // :movie_id 動画ID
    // :comment  投稿されたコメントの本文
    // :review   投稿された５段階評価値
    //
    // 返却値
    // :CommentsテーブルクエリのJSON
    //
    public function post_list(){

        //バリデーション
        $val = Validation::forge();
        if (!$val->run(Input::json())) {
            throw new ValidateException;
        }

        //入力パラメータ取得
        $movie_id = Input::json('movie_id');
        $comment  = Input::json('comment');
        $review   = Input::json('review');

        //DBへ挿入
        DB::insert('comment')->set(array('movie_id'=>$movie_id,'user_name'=>'ゲスト','comment'=>$comment,'review'=>$review,'created_at'=>date('Y-m-d H:i:s')))->execute();

        return;

    }


}