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
            ->add_rule('min_length', 1)
            ->add_rule('max_length', 255);

        //送信ボタン
        $form->add('submit', '', array('type'=>'submit', 'value'=>'送信する'));

        if (Input::method() === 'POST') {

            $val = $form->validation();
            if ($val->run()) {
                $formData = $val->validated();
                if ($user = Auth::validate_user($formData['username'], $formData['password'])){
                    if(Auth::login($formData['username'], $formData['password'])){

                        // リダイレクト
                        Response::redirect('home');
                    }else{
                        // メッセージ格納
                        Session::set_flash('errMsg','ログインに失敗しました！時間を置いてお試し下さい！');
                    }
                }else{
                   Session::set_flash('errMsg','ログインに失敗しました２！時間を置いてお試し下さい！');
                }
            } else {
                // エラー格納
                $error = $val->error();
                // メッセージ格納
                Session::set_flash('errMsg','バリデーションエラー！');
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

