<?php
/**
 * Created by PhpStorm.
 * User: daitaso
 * Date: 2019/01/13
 * Time: 18:07
 */

class Controller_Tags extends Controller_Rest{

    public function get_list(){

        //GETパラメータ取得
        $sql = '';
        $result = DB::query('SELECT DISTINCT keyword FROM SEARCH_TAGS ORDER BY keyword ASC', DB::SELECT)->execute();
        return $this->response(array(
            'tag_list' => $result
        ));

    }
}