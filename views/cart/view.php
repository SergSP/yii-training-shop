<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 29.03.2018
 * Time: 19:17
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>
<div class="container">
    <?php if(Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?= Yii::$app->session->getFlash('success') ?>
        </div>
    <?php endif; ?>
    <?php if(Yii::$app->session->hasFlash('error')): ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?= Yii::$app->session->getFlash('error') ?>
        </div>
    <?php endif; ?>
    <? if(!empty($session['cart'])):?>
        <div class="table-responsive">
            <table class="table table-hover table-scripted">
                <thead><tr>
                    <th>Фото</th>
                    <th>Наименование</th>
                    <th>Количество</th>
                    <th>Цена</th>
                    <th>Сумма</th>
                    <th></th>
                </tr></thead>
                <tbody>
                <?php foreach ($session['cart'] as $id => $item):?>
                    <tr>
                        <td><a href="<?= Url::to(['product/view', 'id' => $id]) ?>"><?= \yii\helpers\Html::img("@web/images/products/{$item['img']}", ['alt' => $item['name'], 'height' => '64px']) ?></a></td>
                        <td><a href="<?= Url::to(['product/view', 'id' => $id]) ?>"><?= $item['name'] ?></a></td>
                        <td><?= $item['qty'] ?></td>
                        <td><?= $item['price'] ?></td>
                        <td><?= $item['price']*$item['qty'] ?></td>
                        <td><span class="glyphicon glyphicon-remove text-danger del-cart-item" onclick="delCartItem(<?= $id ?>)" aria-hidden="true"></span></td>
                    </tr>
                <?php endforeach;?>

                <tr>
                    <td colspan="2">Итого</td>
                    <td colspan="1"><?= $session['cart.qty'] ?></td>
                    <td></td>
                    <td colspan="1"><?= $session['cart.sum'] ?></td>
                    <td></td>
                </tr>
                </tbody>
            </table>
        </div>
        <hr />
        <?php $form = ActiveForm::begin() ?>
        <?= $form->field($order,'name') ?>
        <?= $form->field($order,'email') ?>
        <?= $form->field($order,'phone') ?>
        <?= $form->field($order,'address') ?>
        <?= Html::submitButton('Заказать', ['class' => 'btn btn-success']) ?>
        <?php $form = ActiveForm::end() ?>

<?php else: ?>
        <h3>Корзина пуста</h3>
<?php endif; ?>
</div>

