<?php
// TagsテーブルＡＰＩ
//
// 役割：DBの検索タグテーブルへのアクセスAPI
//
class Controller_Api_Tags extends Controller_Rest{

    //
    // 検索タグを新しい方から１０件取得し、返却する
    //
    // 返却値：検索タグテーブルクエリのJSON
    //
    public function get_list(){

        $result = DB::query('SELECT DISTINCT keyword FROM TAGS ORDER BY TAGS.CREATED_AT DESC LIMIT 10', DB::SELECT)->execute();
        return $this->response(array(
            'tag_list' => $result
        ));

    }
}