<?php
/**
 * Created by PhpStorm.
 * User: daitaso
 * Date: 2019/01/13
 * Time: 18:07
 */

class Controller_Api_Tags extends Controller_Rest{

    public function get_list(){

        //GETパラメータ取得
        $sql = '';
        $result = DB::query('SELECT DISTINCT keyword FROM TAGS ORDER BY TAGS.CREATED_AT DESC LIMIT 10', DB::SELECT)->execute();
        return $this->response(array(
            'tag_list' => $result
        ));

    }
}