<div class="ctn-main">
    <section class="ctn-form">
        <h1>ログイン</h1>
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
        <?=$login?>
        <a href="http://localhost/curation/public/passReminder">ログインのユーザーネームまたはパスワードを忘れた</a>
    </section>
</div>