<?php

/* @var $this \yii\web\View */
/* @var $content string */

/* @var $logs \app\modules\opencase\models\GameLog[] */

use app\models\User;
use app\modules\opencase\models\GameLog;
use yii\helpers\Url;

$user = User::getCurrentUser();
$urlActionPayment = Url::toRoute(['/freekassa/payment/create']);
$logs = GameLog::find()
    ->with(['item', 'user'])
    ->orderBy(['id' => SORT_DESC])
    ->limit(30)
    ->all();

$cntUsers = User::find()->count();
$cntUsers = number_format($cntUsers, null, null, ' ');
$cntBoxs = intval(Yii::$app->params['boxCounts']) + GameLog::find()->count();
$cntBoxs = number_format($cntBoxs, null, null, ' ');

if ($user && $user->token_index) {
    $isFirstPay = \app\modules\freekassa\models\Freekassa::find()
        ->where(['user_id' => $user->token_index])
        ->andWhere(['status' => 2])
        ->andWhere(['>=', 'amount', 999])
        ->exists();
} else {
    $isFirstPay = false;
}

?>

<!DOCTYPE html>
<html class="no-js  page" lang="ru">

<head>
    <meta charset="utf-8">
    <title>Магазин коробок-сюрпризов — Vsebox</title>
    <meta name="description" content="">
    <meta http-equiv="Cache-control" content="no-cache">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="-1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
          content="Открывая коробку вы получаете один из предметов, который можете заказать с доставкой на дом или продать. Таким образом, вы можете получить дорогие и интересные товары по очень низким ценам.">
    <meta name="keywords"
          content=" все бокс,сюрприз кейс, всебокс, всебокс ру, сюрприз кейс, vsebox, vsebox ru, сайт vsebox, промокоды для vsebox, сайт vsebox ru, vsebox ru отзывы, сюрприз бокс, сайт кейс"/>
    <meta name="format-detection" content="telephone=no">

    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <link href="css/style.min.css" rel="stylesheet" media="screen">
    <link href="css/site.css" rel="stylesheet" media="screen">
    <link href="css/font-awesome.min.css" rel="stylesheet" media="screen">

    <script>
        // Маркер работающего javascript
        document.documentElement.className = document.documentElement.className.replace('no-js', 'js');
        document.addEventListener('DOMContentLoaded', function () {
            if (window.isMobile !== undefined) {
                // console.log(isMobile);
                if (isMobile.any) {
                    var rootClasses = ' is-mobile';
                    for (key in isMobile) {
                        if (typeof isMobile[key] === 'boolean' && isMobile[key] && key !== 'any') rootClasses += ' is-mobile--' + key;
                        if (typeof isMobile[key] === 'object' && key !== 'other') {
                            for (type in isMobile[key]) {
                                if (isMobile[key][type]) rootClasses += ' is-mobile--' + key + '-' + type;
                            }
                        }
                    }
                    document.documentElement.className += rootClasses;
                }
            }
            else {
                console.log('Классы для мобильных не добавлены: в сборке отсутствует isMobile.js');
            }
        });

    </script>
    <script type="text/javascript" src="//vk.com/js/api/openapi.js?150"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="icon" href="img/favicon.ico" type="image/x-icon">

</head>

<body>

<div class="page__inner">

    <div class="page__content">

        <header class="page-header" role="banner">
            <div class="container">
                <div class="page-header__wrapper">
                    <a href="<?= Yii::$app->homeUrl ?>" class="logo  page-header__logo">
                        <img src="img/logo.png" alt="Box">
                        Box
                    </a>

                    <div class="page-header__counter">
                        <div class="page-header__counter-block">
                            <div class="page-header__users">
                                <div class="page-header__users-number"><?= $cntUsers ?></div>
                                <div class="page-header__users-text">Пользователей</div>
                            </div>
                        </div>

                        <div class="page-header__counter-block  page-header__counter-block_ml">
                            <div class="page-header__users">
                                <div class="page-header__users-number"><?= $cntBoxs ?></div>
                                <div class="page-header__users-text">Открыто коробок</div>
                            </div>
                        </div>
                    </div>

                    <nav id="main-nav" class="main-nav" role="navigation">
                        <div id="main-nav-toggler" class="main-nav__toggler  burger"><span></span></div>
                        <ul class="main-nav__list">
                            <li class="main-nav__item">
                                <a href="<?= Url::toRoute(['/site/index']) ?>"
                                   class="main-nav__link <?= $this->context->route == 'site/index' ? 'main-nav__link--active' : ''; ?>">
                                    Коробки
                                </a>
                            </li>
                            <li class="main-nav__item">
                                <a href="<?= Url::toRoute(['/site/delivery']) ?>"
                                   class="main-nav__link <?= $this->context->route == 'site/delivery' ? 'main-nav__link--active' : ''; ?>">
                                    Доставка
                                </a>
                            </li>
                            <li class="main-nav__item">
                                <a href="<?= Url::toRoute(['/site/testimonials']) ?>"
                                   class="main-nav__link <?= $this->context->route == 'site/testimonials' ? 'main-nav__link--active' : ''; ?>">
                                    Отзывы
                                </a>
                            </li>
                            <li class="main-nav__item">
                                <a href="<?= Url::toRoute(['/site/help']) ?>"
                                   class="main-nav__link <?= $this->context->route == 'site/help' ? 'main-nav__link--active' : ''; ?>">
                                    Помощь
                                </a>
                            </li>
                            <?php
                            if (Yii::$app->user->isGuest) {
                                ?>

                                <li class="login-btn eas" data-uloginbutton="vkontakte"
                                    onclick="window.location.href ='<?= Url::toRoute(['/site/login-social', 'service' => 'vkontakte']) ?>';">
                                    <strong>Войти через</strong>
                                    <span class="flaticon-soc-vk">
                                        <svg class="flaticon-soc-vk__icon" xmlns="http://www.w3.org/2000/svg"
                                             xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1"
                                             x="0px" y="0px" width="30" height="24" viewBox="0 0 548.358 548.358"
                                             style="enable-background:new 0 0 300 300;" xml:space="preserve">
                                            <g>
                                                <path fill="#fff"
                                                      d="M545.451,400.298c-0.664-1.431-1.283-2.618-1.858-3.569c-9.514-17.135-27.695-38.167-54.532-63.102l-0.567-0.571   l-0.284-0.28l-0.287-0.287h-0.288c-12.18-11.611-19.893-19.418-23.123-23.415c-5.91-7.614-7.234-15.321-4.004-23.13   c2.282-5.9,10.854-18.36,25.696-37.397c7.807-10.089,13.99-18.175,18.556-24.267c32.931-43.78,47.208-71.756,42.828-83.939   l-1.701-2.847c-1.143-1.714-4.093-3.282-8.846-4.712c-4.764-1.427-10.853-1.663-18.278-0.712l-82.224,0.568   c-1.332-0.472-3.234-0.428-5.712,0.144c-2.475,0.572-3.713,0.859-3.713,0.859l-1.431,0.715l-1.136,0.859   c-0.952,0.568-1.999,1.567-3.142,2.995c-1.137,1.423-2.088,3.093-2.848,4.996c-8.952,23.031-19.13,44.444-30.553,64.238   c-7.043,11.803-13.511,22.032-19.418,30.693c-5.899,8.658-10.848,15.037-14.842,19.126c-4,4.093-7.61,7.372-10.852,9.849   c-3.237,2.478-5.708,3.525-7.419,3.142c-1.715-0.383-3.33-0.763-4.859-1.143c-2.663-1.714-4.805-4.045-6.42-6.995   c-1.622-2.95-2.714-6.663-3.285-11.136c-0.568-4.476-0.904-8.326-1-11.563c-0.089-3.233-0.048-7.806,0.145-13.706   c0.198-5.903,0.287-9.897,0.287-11.991c0-7.234,0.141-15.085,0.424-23.555c0.288-8.47,0.521-15.181,0.716-20.125   c0.194-4.949,0.284-10.185,0.284-15.705s-0.336-9.849-1-12.991c-0.656-3.138-1.663-6.184-2.99-9.137   c-1.335-2.95-3.289-5.232-5.853-6.852c-2.569-1.618-5.763-2.902-9.564-3.856c-10.089-2.283-22.936-3.518-38.547-3.71   c-35.401-0.38-58.148,1.906-68.236,6.855c-3.997,2.091-7.614,4.948-10.848,8.562c-3.427,4.189-3.905,6.475-1.431,6.851   c11.422,1.711,19.508,5.804,24.267,12.275l1.715,3.429c1.334,2.474,2.666,6.854,3.999,13.134c1.331,6.28,2.19,13.227,2.568,20.837   c0.95,13.897,0.95,25.793,0,35.689c-0.953,9.9-1.853,17.607-2.712,23.127c-0.859,5.52-2.143,9.993-3.855,13.418   c-1.715,3.426-2.856,5.52-3.428,6.28c-0.571,0.76-1.047,1.239-1.425,1.427c-2.474,0.948-5.047,1.431-7.71,1.431   c-2.667,0-5.901-1.334-9.707-4c-3.805-2.666-7.754-6.328-11.847-10.992c-4.093-4.665-8.709-11.184-13.85-19.558   c-5.137-8.374-10.467-18.271-15.987-29.691l-4.567-8.282c-2.855-5.328-6.755-13.086-11.704-23.267   c-4.952-10.185-9.329-20.037-13.134-29.554c-1.521-3.997-3.806-7.04-6.851-9.134l-1.429-0.859c-0.95-0.76-2.475-1.567-4.567-2.427   c-2.095-0.859-4.281-1.475-6.567-1.854l-78.229,0.568c-7.994,0-13.418,1.811-16.274,5.428l-1.143,1.711   C0.288,140.146,0,141.668,0,143.763c0,2.094,0.571,4.664,1.714,7.707c11.42,26.84,23.839,52.725,37.257,77.659   c13.418,24.934,25.078,45.019,34.973,60.237c9.897,15.229,19.985,29.602,30.264,43.112c10.279,13.515,17.083,22.176,20.412,25.981   c3.333,3.812,5.951,6.662,7.854,8.565l7.139,6.851c4.568,4.569,11.276,10.041,20.127,16.416   c8.853,6.379,18.654,12.659,29.408,18.85c10.756,6.181,23.269,11.225,37.546,15.126c14.275,3.905,28.169,5.472,41.684,4.716h32.834   c6.659-0.575,11.704-2.669,15.133-6.283l1.136-1.431c0.764-1.136,1.479-2.901,2.139-5.276c0.668-2.379,1-5,1-7.851   c-0.195-8.183,0.428-15.558,1.852-22.124c1.423-6.564,3.045-11.513,4.859-14.846c1.813-3.33,3.859-6.14,6.136-8.418   c2.282-2.283,3.908-3.666,4.862-4.142c0.948-0.479,1.705-0.804,2.276-0.999c4.568-1.522,9.944-0.048,16.136,4.429   c6.187,4.473,11.99,9.996,17.418,16.56c5.425,6.57,11.943,13.941,19.555,22.124c7.617,8.186,14.277,14.271,19.985,18.274   l5.708,3.426c3.812,2.286,8.761,4.38,14.853,6.283c6.081,1.902,11.409,2.378,15.984,1.427l73.087-1.14   c7.229,0,12.854-1.197,16.844-3.572c3.998-2.379,6.373-5,7.139-7.851c0.764-2.854,0.805-6.092,0.145-9.712   C546.782,404.25,546.115,401.725,545.451,400.298z"/>
                                            </g>
                                        </svg>
                                    </span>
                                </li>

                                <?php
                            } else {
                                ?>
                                <li class="main-nav__item  main-nav__item_ml  main-nav__item-user">
                                    <a href="<?= Url::toRoute(['/site/profile']) ?>"
                                       class="main-nav__link  main-nav__link--mt0">
                                        <img src="<?= $user->getAvatar() ?>" class="ava" alt="ava">
                                    </a>
                                    <div class="main-nav__link-user-wrapper">
                                        <a href="<?= Url::toRoute(['/site/profile']) ?>"
                                           class="main-nav__link-user-name">Мой профиль</a>
                                        <div class="main-nav__link-balance-wrapper">
                                            <div class="main-nav__link-user-balance"><?= $user->money ?> &#8381;</div>
                                            <button class="btn  main-nav__btn  main-nav__btn-balance"
                                                    data-toggle="modal"
                                                    data-target="#modal-demo-02">
                                                +
                                            </button>
                                        </div>
                                    </div>
                                </li>
                                <?php
                            } ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </header>
        <main role="main" class="page-delivery">
            <div class="container">
                <div class="products-carousel">
                    <div class="products-carousel__header">
                        <span class="products-carousel__header-text">Live Лента</span>
                    </div>
                    <div class="owl-carousel products-carousel__carousel" id="owl-carousel-demo">
                        <?php
                        $tmp = <<< HTML
                    <div onclick="window.location.href = '%s'">
                        <img src="%s" alt="surpise"
                             class="owl-carousel__prize" style="width: 70px">
                        <img src="%s" alt="person"
                             class="owl-carousel__person" style="width: 70px">
                    </div>
HTML;
                        /**
                         * @var \app\modules\opencase\models\GameLog[] $logs
                         */
                        foreach ($logs as $log) {
                            echo sprintf($tmp, Url::to(['user', 'token' => $log->token_index]), $log->itemAvatar, $log->userAvatar);
                        }

                        ?>

                    </div>
                </div>
                <?= $content ?>
            </div>

        </main>
    </div>

    <div class="page__footer-wrapper">

        <footer class="page-footer" role="contentinfo">
            <div class="container">
                <div class="page-footer__wrapper">
                    <div class="page-footer__left">
                        <div class="pay-system">
                            <h3 class="pay-system__title">Мы принимаем</h3>
                            <div class="pay-system__wrapper">
                                <div class="pay-system__item">
                                    <img src="img/master.png" alt="MasterCard" title="MasterCard">
                                </div>
                                <div class="pay-system__item">
                                    <img src="img/visa.png" alt="Visa" title="Visa">
                                </div>
                                <div class="pay-system__item">
                                    <img src="img/yandex.png" alt="Яндекс.Деньги" title="Яндекс.Деньги">
                                </div>
                                <div class="pay-system__item">
                                    <img src="img/qiwi.png" alt="Qiwi" title="Qiwi">
                                </div>
                                <div class="pay-system__item">
                                    <img src="img/mts.png" alt="МТС" title="МТС">
                                </div>
                                <div class="pay-system__item">
                                    <img src="img/bee.png" alt="Beeline" title="Beeline">
                                </div>
                            </div>
                        </div>
                        <div class="freekassa-baner hidden-xs" style="float: right;margin-top: -70px;">
                            <a href="//www.free-kassa.ru/"><img src="//www.free-kassa.ru/img/fk_btn/8.png"></a>
                        </div>
                        <div class="page-footer__copyright">
                            Общество с ограниченной ответственностью "Всебокс"<br>
                            196105 г. Санкт-Петербург, пр-кт Люботинский, д. 2/4, оф 55 <br>
                            ИНН 7810841326 КПП 781001001 ОГРН 1117847402805 ОКПО 30607969
                        </div>
                        <br>
                        <div class="page-footer__confidential">Авторизируясь на сайте вы принимаете
                            <a href="/agreement" class="page-footer__link">пользовательское соглашение</a>
                        </div>
                        <a href="#" class="page-footer__link">Политика конфиденциальности</a>
                    </div>
                    <div class="page-footer__right">
                        <div class="page-footer__vk" id="vk_groups"></div>
                    </div>
                </div>
            </div>

            <div id="modal-demo-01" class="modal" tabindex="-1" role="dialog">
                <div class="modal__dialog" role="document">
                    <div class="modal__content">
                        <div class="modal__header">
                            <span class="close  modal__close" data-dismiss="modal"
                                  aria-label="Закрыть"><span></span></span>
                            <div class="modal__title">Пожалуйста авторизируйтесь</div>
                        </div>
                        <li class="login-btn eas" data-uloginbutton="vkontakte" style="width: 60%; margin: auto"
                            onclick="window.location.href ='<?= Url::toRoute(['/site/login-social', 'service' => 'vkontakte']) ?>';">
                            <strong>Войти через</strong>
                            <span class="flaticon-soc-vk">
                                        <svg class="flaticon-soc-vk__icon" xmlns="http://www.w3.org/2000/svg"
                                             xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1"
                                             x="0px" y="0px" width="30" height="24" viewBox="0 0 548.358 548.358"
                                             style="enable-background:new 0 0 300 300;" xml:space="preserve">
                                            <g>
                                                <path fill="#fff"
                                                      d="M545.451,400.298c-0.664-1.431-1.283-2.618-1.858-3.569c-9.514-17.135-27.695-38.167-54.532-63.102l-0.567-0.571   l-0.284-0.28l-0.287-0.287h-0.288c-12.18-11.611-19.893-19.418-23.123-23.415c-5.91-7.614-7.234-15.321-4.004-23.13   c2.282-5.9,10.854-18.36,25.696-37.397c7.807-10.089,13.99-18.175,18.556-24.267c32.931-43.78,47.208-71.756,42.828-83.939   l-1.701-2.847c-1.143-1.714-4.093-3.282-8.846-4.712c-4.764-1.427-10.853-1.663-18.278-0.712l-82.224,0.568   c-1.332-0.472-3.234-0.428-5.712,0.144c-2.475,0.572-3.713,0.859-3.713,0.859l-1.431,0.715l-1.136,0.859   c-0.952,0.568-1.999,1.567-3.142,2.995c-1.137,1.423-2.088,3.093-2.848,4.996c-8.952,23.031-19.13,44.444-30.553,64.238   c-7.043,11.803-13.511,22.032-19.418,30.693c-5.899,8.658-10.848,15.037-14.842,19.126c-4,4.093-7.61,7.372-10.852,9.849   c-3.237,2.478-5.708,3.525-7.419,3.142c-1.715-0.383-3.33-0.763-4.859-1.143c-2.663-1.714-4.805-4.045-6.42-6.995   c-1.622-2.95-2.714-6.663-3.285-11.136c-0.568-4.476-0.904-8.326-1-11.563c-0.089-3.233-0.048-7.806,0.145-13.706   c0.198-5.903,0.287-9.897,0.287-11.991c0-7.234,0.141-15.085,0.424-23.555c0.288-8.47,0.521-15.181,0.716-20.125   c0.194-4.949,0.284-10.185,0.284-15.705s-0.336-9.849-1-12.991c-0.656-3.138-1.663-6.184-2.99-9.137   c-1.335-2.95-3.289-5.232-5.853-6.852c-2.569-1.618-5.763-2.902-9.564-3.856c-10.089-2.283-22.936-3.518-38.547-3.71   c-35.401-0.38-58.148,1.906-68.236,6.855c-3.997,2.091-7.614,4.948-10.848,8.562c-3.427,4.189-3.905,6.475-1.431,6.851   c11.422,1.711,19.508,5.804,24.267,12.275l1.715,3.429c1.334,2.474,2.666,6.854,3.999,13.134c1.331,6.28,2.19,13.227,2.568,20.837   c0.95,13.897,0.95,25.793,0,35.689c-0.953,9.9-1.853,17.607-2.712,23.127c-0.859,5.52-2.143,9.993-3.855,13.418   c-1.715,3.426-2.856,5.52-3.428,6.28c-0.571,0.76-1.047,1.239-1.425,1.427c-2.474,0.948-5.047,1.431-7.71,1.431   c-2.667,0-5.901-1.334-9.707-4c-3.805-2.666-7.754-6.328-11.847-10.992c-4.093-4.665-8.709-11.184-13.85-19.558   c-5.137-8.374-10.467-18.271-15.987-29.691l-4.567-8.282c-2.855-5.328-6.755-13.086-11.704-23.267   c-4.952-10.185-9.329-20.037-13.134-29.554c-1.521-3.997-3.806-7.04-6.851-9.134l-1.429-0.859c-0.95-0.76-2.475-1.567-4.567-2.427   c-2.095-0.859-4.281-1.475-6.567-1.854l-78.229,0.568c-7.994,0-13.418,1.811-16.274,5.428l-1.143,1.711   C0.288,140.146,0,141.668,0,143.763c0,2.094,0.571,4.664,1.714,7.707c11.42,26.84,23.839,52.725,37.257,77.659   c13.418,24.934,25.078,45.019,34.973,60.237c9.897,15.229,19.985,29.602,30.264,43.112c10.279,13.515,17.083,22.176,20.412,25.981   c3.333,3.812,5.951,6.662,7.854,8.565l7.139,6.851c4.568,4.569,11.276,10.041,20.127,16.416   c8.853,6.379,18.654,12.659,29.408,18.85c10.756,6.181,23.269,11.225,37.546,15.126c14.275,3.905,28.169,5.472,41.684,4.716h32.834   c6.659-0.575,11.704-2.669,15.133-6.283l1.136-1.431c0.764-1.136,1.479-2.901,2.139-5.276c0.668-2.379,1-5,1-7.851   c-0.195-8.183,0.428-15.558,1.852-22.124c1.423-6.564,3.045-11.513,4.859-14.846c1.813-3.33,3.859-6.14,6.136-8.418   c2.282-2.283,3.908-3.666,4.862-4.142c0.948-0.479,1.705-0.804,2.276-0.999c4.568-1.522,9.944-0.048,16.136,4.429   c6.187,4.473,11.99,9.996,17.418,16.56c5.425,6.57,11.943,13.941,19.555,22.124c7.617,8.186,14.277,14.271,19.985,18.274   l5.708,3.426c3.812,2.286,8.761,4.38,14.853,6.283c6.081,1.902,11.409,2.378,15.984,1.427l73.087-1.14   c7.229,0,12.854-1.197,16.844-3.572c3.998-2.379,6.373-5,7.139-7.851c0.764-2.854,0.805-6.092,0.145-9.712   C546.782,404.25,546.115,401.725,545.451,400.298z"/>
                                            </g>
                                        </svg>
                                    </span>
                        </li>
                    </div>
                </div>
            </div>
            <div id="modal-demo-02" class="modal" tabindex="-1" role="dialog">
                <form action="<?= $urlActionPayment ?>" class="modal__form  modal__dialog">
                    <div class="modal__content">
                        <div class="modal__header">
                            <span class="close  modal__close" data-dismiss="modal"
                                  aria-label="Закрыть"><span></span></span>
                            <div class="modal__title">Выберите способ оплаты
                            </div>
                            <?php
                            if (!$isFirstPay) {
                                echo '<span style="font-size: 18px;color: #ca0006; text-align: center; margin-left: 50px">
                                                При первом пополнении от 1000 рублей бонус 20%
                                               </span>';
                            }
                            ?>
                            <div class="modal__wrapper">
                                <label class="field-text  modal__field-number">
                                    <span class="field-text__name  modal__field-number-name">Введите сумму:</span>
                                    <span class="field-text__input-wrap">
                                    <input class="field-text__input  field-text__input-number" type="number" name="sum">
                                </span>
                                </label>
                            </div>
                            <div class="modal__wrapper-bottom">
                                <div class="modal__pay-btn-wrapper">
                                    <input type="submit" name="pay" value="Пополнить"
                                           class='btn  btn--accent  modal__pay-btn'>
                                </div>
                            </div>
                </form>
            </div>
    </div>
</div>

<div id="modal-demo-03" class="modal" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal__dialog" role="document">
        <div class="modal__content">
            <div class="modal__header">
                            <span class="close  modal__close" id="close-modal-3" data-dismiss="modal"
                                  aria-label="Закрыть" id="cb"><span></span></span>
                <div class="modal__title">
                    Необходимо пополнить баланс
                </div>
            </div>
            <div class="modal__wrapper">
                <p id="modal3-text" style="color: #dddddd">Недостаточно средств на балансе. Пополните баланс на
                    100р!</p>
                <div class="modal__img">
                    <img id="modal-img-prize2" src="">
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modal-demo-05" class="modal" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal__dialog" role="document">
        <div class="modal__content">
            <div class="modal__header">
                            <span class="close  modal__close" id="close-modal-3" data-dismiss="modal"
                                  aria-label="Закрыть" id="cb"><span></span></span>
                <div class="modal__title">
                    Вы активировали промо код!
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modal-demo-07" class="modal" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal__dialog" role="document">
        <div class="modal__content">
            <div class="modal__header">
                            <span class="close  modal__close" id="close-modal-3" data-dismiss="modal"
                                  aria-label="Закрыть" id="cb"><span></span></span>
                <div class="modal__title">
                    <span id="free-case-error"></span>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modal-demo-04" class="modal  modal-prize" tabindex="-1" role="dialog">
    <div class="modal__dialog" role="document">
        <div class="modal__content modal__content-box">
            <div class="modal__header  modal__header-win">
                <span class="close  modal__close" data-dismiss="modal" aria-label="Закрыть"><span></span></span>
                <div class="modal__title  modal__title--mt">Вы выйграли <span class="modal__title-prize">часы</span>!
                </div>
            </div>
            <div class="modal__box  modal__box--green">
                <img class="modal__img-win-hov" src="img/box__green-hov.png" alt="win">
                <div class="modal__title  modal__title-win modal__title-prize">Fish Eye</div>
                <img class="modal__img-win  modal__img-win--one" src="img/win-bg-1.png" alt="win">
                <img class="modal__img-win  modal__img-win--two" src="img/win-bg-2.png" alt="win">
                <div class="modal__img-prize">
                    <img id="modal-img-prize" src="" alt="Смарт Часы (Android)">
                </div>
            </div>
            <div class="modal__wrapper-bottom">
                <button id="bsell" class="btn btn--xs-mt btn--accent modal__btn--mr" data-dismiss="modal"
                        data-bid="0" data-sell="0" data-id="0">Продать за 90 &#8381;
                </button>
                <button class="btn btn--xs-mt btn--accent" data-dismiss="modal">Открыть еще</button>
                <!--                    <button class="btn  btn--xs-mt  btn--accent">Заказать доставку</button>-->
            </div>
        </div>
    </div>
</div>

<div id="modal-demo-06" class="modal" tabindex="-1" role="dialog">
    <form action="<?= $urlActionPayment ?>" class="modal__form  modal__dialog">
        <div class="modal__content">
            <div class="modal__header">
                            <span class="close  modal__close" data-dismiss="modal"
                                  aria-label="Закрыть"><span></span></span>
            </div>
            <div class="modal__wrapper">
                <label class="field-text  modal__field-number">
                    <span class="field-text__name  modal__field-number-name" style="font-size: 18px">
                        Пополните баланс на 100 рублей и получите коробку бесплатно
                    </span>
                </label>
            </div>
            <div class="modal__wrapper-bottom">
                <div class="modal__pay-btn-wrapper">
                    <input type="hidden" name="sum" value="100">
                    <input type="submit" name="pay" value="Пополнить"
                           class='btn  btn--accent  modal__pay-btn'>
                </div>
            </div>
    </form>
</div>
</footer>

</div>
<span id="btn-roulette"></span>
</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/jquery.3.1.1.min.js"><\/script>')</script>
<script type="text/javascript">
    VK.Widgets.Group("vk_groups", {mode: 3}, <?= Yii::$app->params['vkGroupId']?>);
</script>
<script>
    var bsell = $('#bsell');
    var csrfToken = $('meta[name="csrf-token"]').attr("content");

    bsell.on('click', function () {
        $.ajax({
            dataType: 'json',
            url: '<?= Url::toRoute(['/site/sell']) ?>',
            data: {_csrf: csrfToken, bid: bsell.attr('data-bid'), id: bsell.attr('data-id')},
            success: function (data) {
                console.log(data);
                $('.main-nav__link-user-balance').html(data.balance + ' &#8381;');
            },
            fail: function () {
                console.log('err');
            }
        });
    });
</script>
<?php
$promoOk = Yii::$app->session->get('promocode_ok');
if ($promoOk && $promoOk == 'ok') {
    $promoOk = true;
    Yii::$app->session->set('promocode_ok', '');
} else {
    $promoOk = false;
}

?>

<script src="js/script.min.js"></script>

<script>
    var promoOk = '<?=$promoOk?>';

    if (promoOk == '1') {
        $('#modal-demo-05').modal('show');
    }
</script>
</body>
</html>
