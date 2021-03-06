<?php
/* @var $this yii\web\View */
/* @var $cnt array */
/* @var $items \app\modules\opencase\models\CaseItem[] */

/* @var $user app\Models\User */

use yii\helpers\Url;

?>

<?php
$i = 0;
$cases = [
    '0' => $items[0],
    '1000' => $items[1000],
    '999' => $items[999],
    '500' => $items[500],
    '250' => $items[250],
    '100' => $items[100],
];
/**
 * @var $case \app\modules\opencase\models\CaseItem[]
 */
foreach ($cases as $id => $case) :
    $i++;
    $openBoxes = round(425 * $id / $i) + (isset($cnt[$id][0]['cnt']) ? $cnt[$id][0]['cnt'] + 3592 : 1);
    $chancePng = $id > 999 ? 'x3.png' : 'x2.png';

    ?>
    <div class="box-wrapper"
         onclick="window.location.href ='<?= Url::toRoute(['/site/box', 'id' => $id]) ?>';">
        <div class="box-wrapper__left">
            <div class="box boxColor<?= $id ?>">
                <div class="box__header">
                    <div class="box__name">
                        <?php
                        if ($id == 0) {
                            echo "Бесплатная <br> коробка";
                        } else {
                            $t = $i - 1;
                            echo "Коробка<div class='box__number'>№{$t}</div>";
                        }
                        ?>
                    </div>
                    <div class="box__price"><?= $id ?>&#8381;</div>
                </div>
                <div class="box__surprice">
                    <img src="img/cover<?= $id ?>.png">

                </div>
            </div>
            <button href="<?= Url::toRoute(['/site/box', 'id' => $id]) ?>" class="btn btn--accent box__btn">Открыть
                коробку
            </button>
            <div class="box-wrapper__text">
                Уже выдано
                <span class="box-wrapper__number"><?= $openBoxes ?> товаров</span>
            </div>
        </div>
        <div class="box-wrapper__right">
            <div class="box-wrapper__right-text">Коробка содержит <?= count($case) ?> товаров</div>
            <div class="box-wrapper__items">
                <?php
                foreach ($case as $item) {
                    $s = '<div class="box-wrapper__item"><img src="%s" alt="surpise"></div>';
                    if (isset($s, $item->item->image)) {
                        echo sprintf($s, $item->item->image);
                    }
                }
                ?>
            </div>
        </div>
    </div>

<?php
endforeach;
?>

</div>

<div class="guarantees">
    <div class="container">
        <h2 class="guarantees__title">Наши гарантии</h2>
        <div class="guarantees__wrapper">

            <div class="guarantees__item">
                <div class="guarantees__icon">
                    <img src="img/glasses.png" alt="glasses">
                </div>
                <h3 class="guarantees__subtitle">Полная прозрачность</h3>
                <p class="guarantees__text">
                    У нас вы можете посмотреть все. Кто получил, что получил и когда. Каждый профиль снабжен
                    ссылкой на контакт человека в одной из трех социальных сетей.
                </p>
            </div>

            <div class="guarantees__item">
                <div class="guarantees__icon">
                    <img src="img/money.png" alt="money">
                </div>
                <h3 class="guarantees__subtitle">Гарантия низких цен</h3>
                <p class="guarantees__text">
                    Благодаря крупным оптовым закупкам цены в нашем магазине на все товары одни из самых
                    низких на рынке.
                </p>
            </div>

            <div class="guarantees__item">
                <div class="guarantees__icon">
                    <img src="img/magnifier.png" alt="magnifier">
                </div>
                <h3 class="guarantees__subtitle">Проверенные товары</h3>
                <p class="guarantees__text">
                    Мы выкладываем только проверенные товары от надежных поставщиков. Каждый товар
                    тестируется перед отправкой и снабжается всей сопровождающей документацией.
                </p>
            </div>

        </div>
    </div>
</div>