<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 28.03.2018
 * Time: 21:42
 */

namespace app\models;
use app\controllers\CartController;
use yii\db\ActiveRecord;
use Yii;


class Cart extends ActiveRecord
{
    public function AddToCart($product,$qty=1)
    {
        if(isset($_SESSION['cart'][$product->id]['qty'])) $_SESSION['cart'][$product->id]['qty']+=$qty;
        else{
            $_SESSION['cart'][$product->id]=[
                'qty' => $qty,
                'name' => $product->name,
                'price' => $product->sale_price,
                'img' => $product->img
            ];
        }
        $this->refreshCart();

    }
    public function delFromCart($session,$id)
    {
        if(empty($session['cart'][$id])) return false;
        unset($_SESSION['cart'][$id]);

        $this->refreshCart();

        return true;
    }

    public function clearCart()
    {
        $session=Yii::$app->session;
        $session->open();

        $session->remove('cart');
        $session->remove('cart.qty');
        $session->remove('cart.sum');
    }

    public function refreshCart()
    {
        $_SESSION['cart.qty']=0;
        $_SESSION['cart.sum']=0;
        foreach ($_SESSION['cart'] as $id => $item) {
            if(is_numeric($id) and is_float($item['price']) and is_numeric($item['qty'])) {
                $_SESSION['cart.qty'] += $item['qty'];
                $_SESSION['cart.sum'] += $item['price'] * $item['qty'];
            }else {
                $this->clearCart();
                return false;
            }
        }
    }
}