<?php
$sucMsg = Session::get_flash('sucMsg');
if(!empty($sucMsg)):
    ?>
    <div class="alert-msg success js-toggle-msg">
        <?=$sucMsg?>
    </div>
    <?php
endif;
$errMsg = Session::get_flash('errMsg');
if(!empty($errMsg)):
    ?>
    <div class="alert-msg err js-toggle-msg">
        <?=$errMsg ?>
    </div>
    <?php
endif;
?>
<header class="l-header">
    <div class="l-header--width-980">
        <div class="p-logo-container">
            <a  href="home.php"><?=Asset::img('logo.png',array('class' => 'p-logo-container__img'))?></a>
        </div>
        <nav class="p-nav">
            <ul class="p-nav__ul">
                <li class="p-nav__ul__li"><a class="p-nav__ul__li__a" href="movieList.php">動画一覧</a></li>
                <?php if(Auth::check()) { ?>
                    <li class="p-nav__ul__li"><a class="p-nav__ul__li__a" href="favoriteList.php">お気に入り一覧</a></li>
                    <li class="p-nav__ul__li p-nav__ul__li--reverse"><a class="p-nav__ul__li--reverse__a" href="logout.php">ログアウト</a></li>
                <?php }else{ ?>
                    <li class="p-nav__ul__li"><a class="p-nav__ul__li__a" href="signup.php">サインアップ</a></li>
                    <li class="p-nav__ul__li p-nav__ul__li--reverse"><a class="p-nav__ul__li--reverse__a" href="login.php">ログイン</a></li>
                <?php } ?>
            </ul>
        </nav>
    </div>
</header>