<?php

// データ抽出
class Controller_Extraction extends Controller
{
    public function action_index(){

        $url = 'https://www.tokyomotion.net/videos';      // NG http_code = 302
//  $url = 'https://video.fc2.com/';                // OK http_code = 200 htmlが返却される
//  $url = 'https://www.xvideos.com/';              // OK http_code = 200 htmlが返却される

        $option = [
            CURLOPT_RETURNTRANSFER => true, //文字列として返す
            CURLOPT_TIMEOUT        => 3, // タイムアウト時間
        ];

        $ch = curl_init($url);
        curl_setopt_array($ch, $option);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);

        $html    = curl_exec($ch);
        curl_close($ch);

        require APPPATH.'vendor/simple_html_dom.php';

        $html = str_get_html($html);

        //詳細ページへのa要素のリストを取得
        $as = $html->find('a[href^=/video/]');

        Log::info(count($as));
        $cnt = 0;

        foreach( $as as $a ){

            $cnt ++;
            Log::info($cnt);

            //詳細ページへのURLを解析
            $detail_url = $a->getAttribute('href');

            //ムービーID切り出し
            $dirs = explode('/',$detail_url);
            $movie_id = $dirs[2];

            //日本語部分をエンコード
            $detail_url = $dirs[0].'/'.$dirs[1].'/'.$dirs[2].'/'.urlencode($dirs[3]);

            //サムネイル画像保存
            $img_url = $a->find('img[src^=https://cdn.tokyo-motion.net/media/videos/]',0)->getAttribute('src');
            $img = file_get_contents($img_url);
            file_put_contents('./assets/img/' .$movie_id.'.jpg' , $img);

            //タイトル抽出
            $title = $a->find('img[src^=https://cdn.tokyo-motion.net/media/videos/]',0)->getAttribute('title');

            //詳細ページ取得
            $ch = curl_init('https://www.tokyomotion.net'.$detail_url);
            curl_setopt_array($ch, $option);
            curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);

            $detail_html = curl_exec($ch);
            curl_close($ch);

            $detail_html = str_get_html($detail_html);

            //共有タグ
            $embed_tag = $detail_html->find('iframe')[0]->outertext;

            $query = DB::insert('movie_list');
            $query->set(array(
                'site_nm'  => 'tokyomotion',
                'movie_id' => $movie_id,
                'embed_tag'    => $embed_tag,
                'title'    => $title,
                'created_at' => date('Y-m-d H:i:s'),));
            $query->execute();
            $query->reset();

            //検索タグ抽出
            $keywords = $detail_html->find('meta[name=keywords]',0)->getAttribute('content');
            $keywords = explode(',',$keywords);
            foreach ($keywords as $keyword) {
                $query = DB::insert('search_tags');
                $query->set(array(
                    'movie_id' => $movie_id,
                    'keyword' => trim(mb_convert_kana($keyword, "s", 'UTF-8')), //全角空白のtrim
                    'created_at' => date('Y-m-d H:i:s'),));
                $query->execute();
                $query->reset();
            }
        }

        return ;
    }
}
?>