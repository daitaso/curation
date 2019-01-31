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
    <p>ご指定のメールアドレス宛にパスワード再発行用のＵＲＬと認証キーをお送り致します。</p>
    <?=$passRemindSend?>
</main>