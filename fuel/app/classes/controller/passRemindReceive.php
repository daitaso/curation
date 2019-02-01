<?php

// パスワードリマインダー（受信）
class Controller_PassRemindReceive extends Controller
{
    const PASS_LENGTH_MIN = 6;
    const PASS_LENGTH_MAX = 20;

    public function action_index()
    {
        $auth_key = Session::get('auth_key');
        if ( $auth_key === false ){
            Response::redirect('passRemindSend');
        }

        $error = '';
        $formData = '';

        $form = Fieldset::forge('passRemindReceive');

        //Email
        $form->add('authkey', '認証キー', array('type'=>'text', 'placeholder'=>'認証キー'))
            ->add_rule('required')
            ->add_rule('exact_length', 8);
//            ->add_rule('valid_string', array('alpha', 'uppercase','lowercase','numeric'));

        //送信ボタン
        $form->add('submit', '', array('type'=>'submit', 'value'=>'再発行する'));

        if (Input::method() === 'POST') {

            $val = $form->validation();
            if ($val->run()) {

                //バリデーションＯＫ
                $formData = $val->validated();

                if(Input::post('token') !== Session::get('auth_key')){
                    //キー違う
                }
                if(time() > Session::get('auth_key_limit')){
                    //期限切れ
                }

                $result = DB::select()->from('users')->where('email',Session::get('auth_email') )->execute();
                $username = $result[0]['username'];

                $new_password = Auth::reset_password($username);

                //メール送信
                $email = Email::forge();
                $email->from('e.curation.test@gmail.com');
                $email->to(Session::get('auth_email'));
                $email->subject('【パスワード再発行完了】｜E-CURATION');
                $honbun = <<<EOT
本メールアドレス宛にパスワードの再発行を致しました。
下記のURLにて再発行パスワードをご入力頂き、ログインください。

ログインページ：http://localhost/curation/public/login.php
再発行パスワード：{$new_password}
※ログイン後、パスワードのご変更をお願い致します
EOT;
                $email->body($honbun);
                try{
                    $email->send();
                }catch(\EmailValidationFailedException $e){
                    // バリデーションが失敗したとき
                    Log::info('koko');
                }catch(\EmailSendingFailedException $e){
                    // ドライバがメールを送信できなかったとき
                    Log::info('koko2');

                }

                //セッション削除
                Session::delete('auth_key');
                Session::delete('auth_email');
                Session::delete('auth_key_limit');

                Response::redirect('login');

            } else {
                Log::info('koko3');

            }
            // フォームにPOSTされた値をセット
            $form->repopulate();
        }

        //変数としてビューを割り当てる
        $view = View::forge('template/index');
        $view->set('head',View::forge('template/head'));
        $view->set('header',View::forge('template/header'));
        $view->set('contents',View::forge('passRemindReceive'));
        $view->set('footer',View::forge('template/footer'));
        $view->set_global('passRemindReceive', $form->build(''), false);
        $view->set_global('error', $error);
        $vvv = View::forge('template/script');
        $vvv->set('jsname','passRemindReceive');
        $view->set('script',$vvv);

        // レンダリングした HTML をリクエストに返す
        return $view;
    }
}

//認証キー生成
function makeRandKey($length = 8) {
    static $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJLKMNOPQRSTUVWXYZ0123456789';
    $str = '';
    for ($i = 0; $i < $length; ++$i) {
        $str .= $chars[mt_rand(0, 61)];
    }
    return $str;
}


