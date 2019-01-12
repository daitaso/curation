<?php

class Controller_Signup extends Controller
{
    const PASS_LENGTH_MIN = 6;
    const PASS_LENGTH_MAX = 20;

    public function action_index()
    {
        $error = '';
        $formData = '';

        // Fieldestクラスは、formの生成やバリデーションをしてくれる
        // 実際の生成やバリデーション処理はFormクラスとValidationクラスが行っている
        $form = Fieldset::forge('signupform');

        // addメソッドでformを生成、第一引数：name属性の値、第二引数：ラベルの文言、第三引数：色々な属性を配列形式で
        // add_ruleメソッドでバリデーションを設定（使えるルールはValidationクラスと全く同じ。Validationクラスを使っているので。）
        $form->add('username', 'ユーザー名', array('type'=>'text', 'placeholder'=>'ユーザー名'))
            ->add_rule('required')
            ->add_rule('min_length', 1)
            ->add_rule('max_length', 255);

        $form->add('email', 'Email', array('type'=>'email', 'placeholder'=>'Email'))
            ->add_rule('required')
            ->add_rule('valid_email')
            ->add_rule('min_length', 1)
            ->add_rule('max_length', 255);

        $form->add('password', 'Password', array('type'=>'password', 'placeholder'=>'パスワード'))
            ->add_rule('required')
            ->add_rule('min_length', self::PASS_LENGTH_MIN)
            ->add_rule('max_length', self::PASS_LENGTH_MAX);

        $form->add('password_re', 'Password（再入力）', array('type'=>'password', 'placeholder'=>'パスワード（再入力）'))
            // match_fieldをつける場合は必ず他のadd_ruleの前につける
            ->add_rule('match_field', 'password')
            ->add_rule('required')
            ->add_rule('min_length', self::PASS_LENGTH_MIN)
            ->add_rule('max_length', self::PASS_LENGTH_MAX);
        $form->add('submit', '', array('type'=>'submit', 'value'=>'登録'));

        // Input::method()でHTTPメソッドが返ってくるので、POSTかどうかを確認
        if (Input::method() === 'POST') {
            // バリデーションインスタンスを取得
            $val = $form->validation();
            if ($val->run()) {
                $formData = $val->validated();
                $auth = Auth::instance(); //Authインスタンス生成
                if($auth->create_user($formData['username'], $formData['password'], $formData['email'])){
                    // メッセージ格納
                    Session::set_flash('sucMsg','ユーザー登録が完了しました！');
                    // リダイレクト
                    Response::redirect('login');
                }else{
                    // メッセージ格納
                    Session::set_flash('errMsg','ユーザー登録に失敗しました！時間を置いてお試し下さい！');
                }
            } else {
                // エラー格納
                $error = $val->error();
                // メッセージ格納
                Session::set_flash('errMsg','ユーザー登録に失敗しました！時間を置いてお試し下さい！');
            }
            // フォームにPOSTされた値をセット
            $form->repopulate();
        }

        //変数としてビューを割り当てる
        $view = View::forge('template/index');
        $view->set('head',View::forge('template/head'));
        $view->set('header',View::forge('template/header'));
        $view->set('contents',View::forge('auth/signup'));
        $view->set('footer',View::forge('template/footer'));
        $view->set_global('signupform', $form->build(''), false);
        $view->set_global('error', $error);

        // レンダリングした HTML をリクエストに返す
        return $view;
    }
}

