<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>

<title>Рекламная компания ООО РОССТС</title>

<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
<meta name="author" content="Erwin Aligam - styleshout.com" />
<meta name="description" content="Site Description Here" />
<meta name="keywords" content="keywords, here" />
<meta name="robots" content="index, follow, noarchive" />
<meta name="googlebot" content="noarchive" />

<link rel="stylesheet" type="text/css" media="screen" href="/css/screen.css" />

</head>
<body>

    <!-- header starts-->
    <div id="header-wrap"><div id="header" class="container_16">

        <h1 id="logo-text"><a href="index.html" title="">Росстс</a></h1>
        <p id="intro">Компания &ldquo;ООО РОССТС&rdquo;</p>

        <!-- navigation -->
        <div  id="nav">
            <ul>
                <li id="current"><a href="/">На главную</a></li>
                <li><a href="/offer.html">Договор оферты</a></li>
                <li><a href="/prices.html">Цены</a></li>
                <li><a href="/about.html">О нас</a></li>
            </ul>
        </div>

        <div id="header-image"></div>

        <div class="profile">
        <?php if (Auth::isLogin() === false): ?>
            <p>
                <a href="/auth.html" class="tbox">Личный кабинет</a>
            </p>
        <?php else: ?>
            <p>
                <a href="#" class="tbox">Личный кабинет</a>
                |
                <a href="/logout.html" class="tbox">Выход</a>
            </p>
        <?php endif; ?>
        </div>

    <!-- header ends here -->
    </div></div>

    <!-- content starts -->
    <div id="content-outer"><div id="content-wrapper" class="container_16">

        <!-- main -->
        <div id="main" class="grid_12">
            <?= $template ?>

            <div class="clear">&nbsp;</div>
        <!-- main ends -->
        </div>

        <!-- left-columns starts -->
        <div id="left-columns" class="grid_4">

            <div class="grid_4 alpha">
                <div class="sidemenu">
                    <a href="/order.html"><img src="/images/order.png" /></a>
                    <a href="#" class="promotions">&nbsp;</a>
                </div>
            </div>


        <!-- end left-columns -->
        </div>

    <!-- contents end here -->
    </div></div>

    <!-- footer starts here -->
    <div id="footer-wrapper" class="container_16">

        <div id="footer-bottom">

            <p class="bottom-left">
            &nbsp; &copy;2011 Информация о авторском праве &nbsp; &nbsp;
            Дизайн <a href="http://www.box-root.ru/">atomfil</a>
            </p>

            <p class="bottom-right" >
                <a href="index.html">Главная</a> |
                <a href="index.html">Карта сайта</a> |
                <a href="index.html">RSS </a> |
                <a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a> |
                   <a href="http://validator.w3.org/check/referer">XHTML</a>
            </p>

        </div>

    </div>
    <!-- footer ends here -->

</body>
</html>
