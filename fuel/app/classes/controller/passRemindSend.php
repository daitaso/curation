<?php

// パスワードリマインダー（送信）
class Controller_PassRemindSend extends Controller
{
    const PASS_LENGTH_MIN = 6;
    const PASS_LENGTH_MAX = 20;

    public function action_index()
    {
        $error = '';
        $formData = '';

        $form = Fieldset::forge('passRemindSend');

        //Email
        $form->add('email', 'Ｅメール', array('type'=>'email', 'placeholder'=>'Ｅメール'))
            ->add_rule('required')
            ->add_rule('valid_email')
            ->add_rule('max_length', 255);

        //送信ボタン
        $form->add('submit', '', array('type'=>'submit', 'value'=>'送信する'));

        if (Input::method() === 'POST') {

            $val = $form->validation();
            if ($val->run()) {

                $formData = $val->validated();

                //Email存在チェック
                $result = DB::query('SELECT * FROM USERS WHERE email = '.'\''. $formData['email'] . '\'', DB::SELECT)->execute();
                if (count($result) >= 0) {
                    //EmailがＤＢに登録済

                    //認証キー生成
                    $auth_key = makeRandKey();

                    //メール送信
                    $email = Email::forge();
                    $email->from('e.curation.test@gmail.com');
                    $email->to($formData['email']);
                    $email->subject('【パスワード再発行認証】｜E-CURATION');
                    $honbun = <<<EOT
本メールアドレス宛にパスワード再発行のご依頼がありました。
下記のURLにて認証キーをご入力頂くとパスワードが再発行されます。

パスワード再発行認証キー入力ページ：http://localhost/public/passRemindRecieve.php
認証キー：{$auth_key}
※認証キーの有効期限は30分となります

認証キーを再発行されたい場合は下記ページより再度再発行をお願い致します。
http://localhost/public/passRemindSend.php
EOT;
                    $email->body($honbun);
                    try{
                        $email->send();
                    }catch(\EmailValidationFailedException $e){

                        // バリデーションが失敗したとき
                    }catch(\EmailSendingFailedException $e){
                        // ドライバがメールを送信できなかったとき

                    }

                    //認証に必要な情報をセッションへ保存
                    Session::set('auth_key', $auth_key);
                    Session::set('auth_email', $formData['email']);
                    Session::set('auth_key_limit', time()+(60*30));

                    Response::redirect('passRemindReceive');

                }else{
                    //存在しないEmail

                }

            }
            // フォームにPOSTされた値をセット
            $form->repopulate();
        }

        //変数としてビューを割り当てる
        $view = View::forge('template/index');
        $view->set('head',View::forge('template/head'));
        $view->set('header',View::forge('template/header'));
        $view->set('contents',View::forge('passRemindSend'));
        $view->set('footer',View::forge('template/footer'));
        $view->set_global('passRemindSend', $form->build(''), false);
        $view->set_global('error', $error);
        $vvv = View::forge('template/script');
        $vvv->set('jsname','passRemindSend');
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
