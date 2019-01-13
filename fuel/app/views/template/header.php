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

<header>
    <div class="site-width">
        <h1><a href="home.php">DOUGA-CURATION</a></h1>
        <nav id="top-nav">
            <ul>
                <?php if(Auth::check()) { ?>
                    <li><a href="logout.php">ログアウト</a></li>
                    <li><a href="favorite.php">お気に入り一覧</a></li>
                <?php }else{ ?>
                    <li><a href="login.php">ログイン</a></li>
                    <li><a href="signup.php">サインアップ</a></li>
                <?php } ?>
                <li><a href="movieList.php">動画一覧</a></li>
            </ul>
        </nav>
    </div>
</header>