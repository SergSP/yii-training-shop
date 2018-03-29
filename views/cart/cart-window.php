<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 29.03.2018
 * Time: 12:22
 */

if(!empty($session['cart'])):?>
    <div class="table-responsive">
        <table class="table table-hover table-scripted">
            <thead><tr>
                <th>Фото</th>
                <th>Наименование</th>
                <th>Количество</th>
                <th>Цена</th>
                <th></th>
            </tr></thead>
            <tbody>
            <?php foreach ($session['cart'] as $id => $item):?>
                <tr>
                    <td><?= \yii\helpers\Html::img("@web/images/products/{$item['img']}", ['alt' => $item['name'], 'height' => '64px']) ?></td>
                    <td><?= $item['name'] ?></td>
                    <td><?= $item['qty'] ?></td>
                    <td><?= $item['price'] ?></td>
                    <td><span class="glyphicon glyphicon-remove text-danger del-cart-item" onclick="delCartItem(<?= $id ?>)" aria-hidden="true"></span></td>
                </tr>
            <?php endforeach;?>

            <tr>
                <td colspan="2">Итого</td>
                <td colspan="1"><?= $session['cart.qty'] ?></td>
                <td colspan="1"><?= $session['cart.sum'] ?></td>
                <td></td>
            </tr>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <h3>Корзина пуста</h3>
<?php endif; ?>
