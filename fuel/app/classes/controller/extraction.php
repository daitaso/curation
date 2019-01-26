<?php

// データ抽出
class Controller_Extraction extends Controller_Rest
{
    public function get_list(){

        set_time_limit(300);    //処理時間が長いためタイムアウト時間を5分延長

//        //TOKYO MOTION
//        $url = 'https://www.tokyomotion.net/videos';
//
//        $option = [
//            CURLOPT_RETURNTRANSFER => true, //文字列として返す
//            CURLOPT_TIMEOUT        => 10, // タイムアウト時間
//        ];
//
//        $ch = curl_init($url);
//        curl_setopt_array($ch, $option);
//        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
//
//        $html    = curl_exec($ch);
//        curl_close($ch);
//
//        require APPPATH.'vendor/simple_html_dom.php';
//
//        $html = str_get_html($html);
//
//        //詳細ページへのa要素のリストを取得
//        $as = $html->find('a[href^=/video/]');
//
//        $cnt = 0;
//
//        foreach( $as as $a ){
//
//            $cnt ++;
//
//            //詳細ページへのURLを解析
//            $detail_url = $a->getAttribute('href');
//
//            //ムービーID切り出し
//            $dirs = explode('/',$detail_url);
//            $movie_id = $dirs[2];
//
//            //日本語部分をエンコード
//            $detail_url = $dirs[0].'/'.$dirs[1].'/'.$dirs[2].'/'.urlencode($dirs[3]);
//
//            //サムネイル画像保存
//            $img_url = $a->find('img[src^=https://cdn.tokyo-motion.net/media/videos/]',0)->getAttribute('src');
//            $img = file_get_contents($img_url);
//            file_put_contents('./assets/img/' .$movie_id.'.jpg' , $img);
//
//            //タイトル抽出
//            $title = $a->find('img[src^=https://cdn.tokyo-motion.net/media/videos/]',0)->getAttribute('title');
//
//            //詳細ページ取得
//            $ch = curl_init('https://www.tokyomotion.net'.$detail_url);
//            curl_setopt_array($ch, $option);
//            curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
//
//            $detail_html = curl_exec($ch);
//            curl_close($ch);
//
//            $detail_html = str_get_html($detail_html);
//
//            //共有タグ
//            $embed_tag = $detail_html->find('iframe')[0]->outertext;
//
//            $query = DB::insert('movie_list');
//            $query->set(array(
//                'site_id'  => 'T',
//                'movie_id' => $movie_id,
//                'embed_tag'    => $embed_tag,
//                'title'    => $title,
//                'created_at' => date('Y-m-d H:i:s'),));
//            $query->execute();
//            $query->reset();
//
//            //検索タグ抽出
//            $keywords = $detail_html->find('meta[name=keywords]',0)->getAttribute('content');
//            $keywords = explode(',',$keywords);
//            foreach ($keywords as $keyword) {
//                $query = DB::insert('search_tags');
//                $query->set(array(
//                    'movie_id' => $movie_id,
//                    'keyword' => trim(mb_convert_kana($keyword, "s", 'UTF-8')), //全角空白のtrim
//                    'created_at' => date('Y-m-d H:i:s'),));
//                $query->execute();
//                $query->reset();
//            }
//        }
//
//        //XVIDEOS
//        $url = 'https://www.xvideos.com/lang/japanese';
//        $option = [
//            CURLOPT_RETURNTRANSFER => true, //文字列として返す
//            CURLOPT_TIMEOUT        => 300, // タイムアウト時間
//        ];
//
//        $ch = curl_init($url);
//        curl_setopt_array($ch, $option);
//        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
//        $html = curl_exec($ch);
//        curl_close($ch);
//
//        $html = str_get_html($html);
//        $blocks = $html->find('div.thumb-block');
//
//        foreach( $blocks as $block ) {
//
//            //ムービーID
//            $colums = explode('_',$block->id);
//            $movie_id = $colums[1];
//
//            //タイトル
//            $title = $block->find('div.thumb-under',0)->find('a',0)->getAttribute('title');
//
//            //サムネイル画像保存
//            $img_url = $block->find('div.thumb',0)->find('img[data-src^=https://img-]',0)->getAttribute('data-src');
//            $img_url = str_replace('THUMBNUM','1',$img_url);
//            $img = file_get_contents($img_url);
//            file_put_contents('./assets/img/' .$movie_id.'.jpg' , $img);
//
//            //詳細ページ取得
//            $detail_url = 'https://www.xvideos.com'.$block->find('div.thumb',0)->find('a',0)->getAttribute('href');
//
//            $ch = curl_init($detail_url);
//            curl_setopt_array($ch, $option);
//            curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
//            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
//
//            $detail_html = curl_exec($ch);
//
//            curl_close($ch);
//
//            $detail_html = str_get_html($detail_html);
//
//            //共有タグ
//            $embed_tag = $detail_html->find('input#copy-video-embed',0)->getAttribute('value');
//            $embed_tag = htmlspecialchars_decode($embed_tag);
//
//            //検索タグ抽出
//            $keywords = $detail_html->find('a[href^=/tags/]');
//
//
//            foreach($keywords as $keyword){
//                Log::info($keyword->plaintext);
//            }
//            Log::info($movie_id);
//            Log::info($title);
//            Log::info($img_url);
//            Log::info($detail_url);
//            Log::info(htmlspecialchars_decode($embed_tag));
//
//            $query = DB::insert('movie_list');
//            $query->set(array(
//                'site_id'  => 'X',
//                'movie_id' => $movie_id,
//                'embed_tag'    => $embed_tag,
//                'title'    => $title,
//                'created_at' => date('Y-m-d H:i:s'),));
//            $query->execute();
//            $query->reset();
//
//            //検索タグ抽出
//            foreach ($keywords as $keyword) {
//                $query = DB::insert('search_tags');
//                $query->set(array(
//                    'movie_id' => $movie_id,
//                    'keyword' => trim(mb_convert_kana($keyword->plaintext, "s", 'UTF-8')), //全角空白のtrim
//                    'created_at' => date('Y-m-d H:i:s'),));
//                $query->execute();
//                $query->reset();
//            }
//
//        }

        //FC2
        $url = 'https://video.fc2.com/a/search/video/free/?category_id=30';
        $option = [
            CURLOPT_RETURNTRANSFER => true, //文字列として返す
            CURLOPT_TIMEOUT        => 300, // タイムアウト時間
        ];

        $ch = curl_init($url);
        curl_setopt_array($ch, $option);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
        $html = curl_exec($ch);
        curl_close($ch);

        $html = str_get_html($html);
        $blocks = $html->find('li.c-boxList-111_video');

        foreach( $blocks as $block ) {

//            //ムービーID
//            $colums = explode('_',$block->id);
//            $movie_id = $colums[1];
//
//            //タイトル
//            $title = $block->find('div.thumb-under',0)->find('a',0)->getAttribute('title');
//
//            //サムネイル画像保存
//            $img_url = $block->find('div.thumb',0)->find('img[data-src^=https://img-]',0)->getAttribute('data-src');
//            $img_url = str_replace('THUMBNUM','1',$img_url);
//            $img = file_get_contents($img_url);
//            file_put_contents('./assets/img/' .$movie_id.'.jpg' , $img);
//
//            //詳細ページ取得
//            $detail_url = 'https://www.xvideos.com'.$block->find('div.thumb',0)->find('a',0)->getAttribute('href');
//
//            $ch = curl_init($detail_url);
//            curl_setopt_array($ch, $option);
//            curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
//            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
//
//            $detail_html = curl_exec($ch);
//
//            curl_close($ch);
//
//            $detail_html = str_get_html($detail_html);
//
//            //共有タグ
//            $embed_tag = $detail_html->find('input#copy-video-embed',0)->getAttribute('value');
//            $embed_tag = htmlspecialchars_decode($embed_tag);
//
//            //検索タグ抽出
//            $keywords = $detail_html->find('a[href^=/tags/]');
//
//
//            foreach($keywords as $keyword){
//                Log::info($keyword->plaintext);
//            }
//            Log::info($movie_id);
//            Log::info($title);
//            Log::info($img_url);
//            Log::info($detail_url);
//            Log::info(htmlspecialchars_decode($embed_tag));
//
//            $query = DB::insert('movie_list');
//            $query->set(array(
//                'site_id'  => 'X',
//                'movie_id' => $movie_id,
//                'embed_tag'    => $embed_tag,
//                'title'    => $title,
//                'created_at' => date('Y-m-d H:i:s'),));
//            $query->execute();
//            $query->reset();
//
//            //検索タグ抽出
//            foreach ($keywords as $keyword) {
//                $query = DB::insert('search_tags');
//                $query->set(array(
//                    'movie_id' => $movie_id,
//                    'keyword' => trim(mb_convert_kana($keyword->plaintext, "s", 'UTF-8')), //全角空白のtrim
//                    'created_at' => date('Y-m-d H:i:s'),));
//                $query->execute();
//                $query->reset();
//            }

        }

        return ;
    }
}
?>