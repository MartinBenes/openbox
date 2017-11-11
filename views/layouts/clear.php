<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\models\User;
use yii\helpers\Url;

$user = User::getCurrentUser();
$urlActionPayment = Url::toRoute(['/freekassa/payment/create']);
?>

<!DOCTYPE html>
<html class="no-js  page" lang="ru">

<head>
    <meta charset="utf-8">
    <title>Box</title>
    <meta name="description" content="">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="format-detection" content="telephone=no">

    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <link href="css/style.min.css" rel="stylesheet" media="screen">
    <link href="css/site.css" rel="stylesheet" media="screen">

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
                                <div class="page-header__users-number">940 000</div>
                                <div class="page-header__users-text">Пользователей</div>
                            </div>
                        </div>

                        <div class="page-header__counter-block  page-header__counter-block_ml">
                            <div class="page-header__users">
                                <div class="page-header__users-number">4564135</div>
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

                                <li class="main-nav__item  main-nav__item_ml">
                                    <button class="btn  main-nav__btn" data-toggle="modal" data-target="#modal-demo-01">
                                        Вход
                                    </button>
                                </li>
                                <li class="main-nav__item">
                                    <button class="btn  main-nav__btn" data-toggle="modal" data-target="#modal-demo-01">
                                        Регистрация
                                    </button>
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
                <div class="owl-carousel" id="owl-carousel-demo">
                    <div>
                        <img src="http://214010.selcdn.ru/ranbox/items-i/21_medium.png" alt="surpise"
                             class="owl-carousel__prize">
                        <img src="http://214010.selcdn.ru/ranbox/users/vk_350174184_medium.jpg" alt="person"
                             class="owl-carousel__person">
                    </div>
                    <div>
                        <img src="http://214010.selcdn.ru/ranbox/items-i/usb_led_medium.png" alt="surpise"
                             class="owl-carousel__prize">
                        <img src="http://214010.selcdn.ru/ranbox/users/vk_350174184_medium.jpg" alt="person"
                             class="owl-carousel__person">
                    </div>
                    <div>
                        <img src="http://214010.selcdn.ru/ranbox/items-i/45_medium.png" alt="surpise"
                             class="owl-carousel__prize">
                        <img src="http://214010.selcdn.ru/ranbox/users/vk_350174184_medium.jpg" alt="person"
                             class="owl-carousel__person">
                    </div>
                    <div>
                        <img src="http://214010.selcdn.ru/ranbox/items-i/usb_led_medium.png" alt="surpise"
                             class="owl-carousel__prize">
                        <img src="http://214010.selcdn.ru/ranbox/users/vk_350174184_medium.jpg" alt="person"
                             class="owl-carousel__person">
                    </div>
                    <div>
                        <img src="http://214010.selcdn.ru/ranbox/items-i/21_medium.png" alt="surpise"
                             class="owl-carousel__prize">
                        <img src="http://214010.selcdn.ru/ranbox/users/vk_350174184_medium.jpg" alt="person"
                             class="owl-carousel__person">
                    </div>
                    <div>
                        <img src="http://214010.selcdn.ru/ranbox/items-i/powerbank_medium.png" alt="surpise"
                             class="owl-carousel__prize">
                        <img src="http://214010.selcdn.ru/ranbox/users/vk_350174184_medium.jpg" alt="person"
                             class="owl-carousel__person">
                    </div>
                    <div>
                        <img src="http://214010.selcdn.ru/ranbox/items-i/21_medium.png" alt="surpise"
                             class="owl-carousel__prize">
                        <img src="http://214010.selcdn.ru/ranbox/users/vk_350174184_medium.jpg" alt="person"
                             class="owl-carousel__person">
                    </div>
                    <div>
                        <img src="http://214010.selcdn.ru/ranbox/items-i/6_medium.png" alt="surpise"
                             class="owl-carousel__prize">
                        <img src="http://214010.selcdn.ru/ranbox/users/vk_350174184_medium.jpg" alt="person"
                             class="owl-carousel__person">
                    </div>
                    <div>
                        <img src="http://214010.selcdn.ru/ranbox/items-i/21_medium.png" alt="surpise"
                             class="owl-carousel__prize">
                        <img src="http://214010.selcdn.ru/ranbox/users/vk_350174184_medium.jpg" alt="person"
                             class="owl-carousel__person">
                    </div>
                    <div>
                        <img src="http://214010.selcdn.ru/ranbox/items-i/6_medium.png" alt="surpise"
                             class="owl-carousel__prize">
                        <img src="http://214010.selcdn.ru/ranbox/users/vk_350174184_medium.jpg" alt="person"
                             class="owl-carousel__person">
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
                        <div class="page-footer__copyright">Copyright 2017</div>
                        <div class="page-footer__confidential">Авторизируясь на сайте вы принимаете
                            <a href="#" class="page-footer__link">пользовательское соглашение</a>
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
                            <div class="modal__title">Выберите любимую социальную сеть</div>
                        </div>
                        <div class="modal__wrapper">
                            <a href="<?= Url::toRoute(['/site/login-social', 'service' => 'vkontakte']) ?>"
                               class="modal__link">
                                <img src="img/vk.png" alt="Вконтакте">
                            </a>
                            <a href="<?= Url::toRoute(['/site/login-social', 'service' => 'facebook']) ?>"
                               class="modal__link">
                                <img src="img/fb.png" alt="Facebook">
                            </a>
                            <a href="<?= Url::toRoute(['/site/login-social', 'service' => 'odnoklassniki']) ?>"
                               class="modal__link">
                                <img src="img/ok.png" alt="Odnoklassniki">
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div id="modal-demo-02" class="modal" tabindex="-1" role="dialog">
                <form action="<?= $urlActionPayment ?>" class="modal__form  modal__dialog">
                <div class="modal__content">
                    <div class="modal__header">
                            <span class="close  modal__close" data-dismiss="modal"
                        aria-label="Закрыть"><span></span></span>
                        <div class="modal__title">Выберите любимый способ оплаты</div>
                    </div>
                        <div class="modal__wrapper">
                            <label class="field-text  modal__field-number">
                                <span class="field-text__name  modal__field-number-name">Введите сумму:</span>
                                <span class="field-text__input-wrap">
                                    <input class="field-text__input  field-text__input-number" type="number" name="sum">
                                </span>
                            </label>
                        </div>
                        <div class="modal__text">Выберите платежную систему:</div>
                        <div class="modal__wrapper-bottom">
                            <div class="modal__pay">
                                <img src="img/visa.png" alt="visa">
                                <input id="modal__pay1" class="field-radio__input" type="radio" name="ctype"
                                       value="158">
                                <label for="modal__pay1" class="field-radio__name"></label>
                            </div>
                            <div class="modal__pay">
                                <img src="img/yandex.png" alt="yandex">
                                <input id="modal__pay2" class="field-radio__input" type="radio" name="ctype"
                                       value="45">
                                <label for="modal__pay2" class="field-radio__name"></label>
                            </div>
                            <div class="modal__pay">
                                <img src="img/qiwi.png" alt="qiwi">
                                <input id="modal__pay3" class="field-radio__input" type="radio" name="ctype"
                                       value="156">
                                <label for="modal__pay3" class="field-radio__name"></label>
                            </div>
                            <div class="modal__pay">
                                <img src="img/mts.png" alt="mts">
                                <input id="modal__pay4" class="field-radio__input" type="radio" name="ctype"
                                       value="84">
                                <label for="modal__pay4" class="field-radio__name"></label>
                            </div>
                            <div class="modal__pay">
                                <img src="img/megafon.png" alt="megafon">
                                <input id="modal__pay5" class="field-radio__input" type="radio" name="ctype"
                                       value="82">
                                <label for="modal__pay5" class="field-radio__name"></label>
                            </div>
                            <div class="modal__pay">
                                <img src="img/tele2.png" alt="tele2">
                                <input id="modal__pay6" class="field-radio__input" type="radio" name="ctype"
                                       value="132">
                                <label for="modal__pay6" class="field-radio__name"></label>
                            </div>
                            <div class="modal__pay">
                                <img src="img/beeline.png" alt="beeline">
                                <input id="modal__pay7" class="field-radio__input" type="radio" name="ctype"
                                       value="83">
                                <label for="modal__pay7" class="field-radio__name"></label>
                            </div>
                            <div class="modal__pay-btn-wrapper">
                                <input type="submit" name="pay" value="Пополнить"
                                       class='btn  btn--accent  modal__pay-btn'>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
    </div>

    <div id="modal-demo-03" class="modal" tabindex="-1" role="dialog"  data-backdrop="static">
        <div class="modal__dialog" role="document">
            <div class="modal__content">
                <div class="modal__header">
                            <span class="close  modal__close" data-dismiss="modal"
                                  aria-label="Закрыть" id="cb"><span></span></span>
                    <div class="modal__title">Вы выйграли <span class="modal__title-prize"></span>!</div>
                </div>
                <div class="modal__wrapper">
                    <div class="modal__img">
                        <img id="modal-img-prize2" src="">
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
                    <button id="bsell" class="btn btn--accent modal__btn--mr" data-dismiss="modal" data-bid="0" data-sell="0" data-id="0">Продать за 90 &#8381;</button>
                    <button class="btn btn--xs-mt btn--accent" data-dismiss="modal">Открыть еще</button>
                    <!--                    <button class="btn  btn--xs-mt  btn--accent">Заказать доставку</button>-->
                </div>


            </div>
        </div>
    </div>
</footer>

</div>
<span id="btn-roulette"></span>
</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/jquery.3.1.1.min.js"><\/script>')</script>
<script type="text/javascript">
    VK.Widgets.Group("vk_groups", {mode: 3}, 20003922);
</script>
<script>
    var bsell = $('#bsell');
    var csrfToken = $('meta[name="csrf-token"]').attr("content");

    bsell.on('click', function () {
        console.log(123);
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
<script src="js/script.min.js"></script>
</body>
</html>

