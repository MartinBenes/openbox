<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PromoCodes */

$this->title = 'Партнерка';
?>
<div class="promo-codes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>