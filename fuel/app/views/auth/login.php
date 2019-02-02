<!--ログイン画面(view)-->
<!--役割：ログイン画面のview-->
<main class="l-site-500">
    <h1>ログイン</h1>

    <!-- バリデーションエラーのメッセージ表示用領域  -->
    <?php
        if(!empty($error)):
    ?>
        <ul class="area-error-msg">
    <?php
        foreach ($error as $key => $val):
    ?>
            <li><?=$val?></li>
    <?php
        endforeach;
    ?>
        </ul>
    <?php
        endif;
    ?>

    <!-- フォーム要素   -->
    <?=$login?>

    <!-- パスワードリマインダーへのリンク    -->
    <a href="http://localhost/curation/public/passRemindSend">ログインのユーザーネームまたはパスワードを忘れた</a>
</main>