<?php
/**
 * Created by PhpStorm.
 * User: daitaso
 * Date: 2019/01/10
 * Time: 22:56
 */
class Controller_Comments extends Controller_Rest{

    public function get_list(){

        $movie_id  = Input::Get('movie_id');

//        $limit_offset = 'LIMIT '.self::PAGE_DATA_NUM.' OFFSET '.(($page - 1) * self::PAGE_DATA_NUM);
        $result = DB::query('SELECT * FROM COMMENT WHERE movie_id = '.$movie_id.' ORDER BY CREATED_AT DESC', DB::SELECT)->execute();

        return $this->response(array(
            'comment_list' => $result
        ));
    }

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