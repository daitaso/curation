<main class="l-site-500">
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
    <p>ご指定のメールアドレスにお送りした【パスワード再発行認証】メール内にある「認証キー」をご入力下さい。</p>
    <?=$passRemindReceive?>
</main>