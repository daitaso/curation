<?php

//================================
// Ajax処理
//================================
class Controller_Api_Favorites extends Controller{
    public function action_index(){

        if (Input::method() === 'POST' && Auth::check()) {

            $m_id = Input::post('movieId');

            $result = DB::query('SELECT * FROM favorites WHERE movie_id = '.'\''. $m_id . '\''.' AND username = \'' . Auth::get_screen_name() . '\'', DB::SELECT)->execute();
            Log::info(count($result));
            if (count($result) === 1) {
                $result = DB::query('DELETE FROM favorites WHERE movie_id = '.'\''. $m_id .'\''.' AND username = \'' . Auth::get_screen_name() . '\'', DB::DELETE)->execute();
            } else {
                DB::insert('favorites')->columns(array('movie_id', 'username', 'created_at'))->values(array($m_id, Auth::get_screen_name(), date('Y-m-d H:i:s')))->execute();
            }
        }

        return ;
    }
}
?>