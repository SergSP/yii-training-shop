<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Product', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'id',
            //'category_id',
            [
                'attribute' => 'category_id',
                'value' => function ($model) {
                    return $model->category->name;
                },
                'format' => 'html',
            ],
            //'img',
            [
                'attribute' => 'img',
                'value' => function ($model) {
                    return Html::a(Html::img("@web/images/products/{$model->img}", ['style' => 'width: 96px']), ['/product/view', 'id' => $model->id]);
                },
                'format' => 'html',
            ],
            //'name',
            [
                'attribute' => 'name',
                'value' => function ($model) {

                    return Html::a(\yii\helpers\StringHelper::truncate($model->name, 64), ['/product/view', 'id' => $model->id]);
                },
                'format' => 'html',
            ],
            [
                'attribute' => 'content',
                'value' => function ($model) {
                    return \yii\helpers\StringHelper::truncate($model->content, 127);
                },
                'format' => 'html',
            ],
            //'content:ntext',
            'sale_price',
            //'price',
            //'keywords',
            //'description',
            'hit',
            'new',
            'hide',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
