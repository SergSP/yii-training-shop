<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 28.03.2018
 * Time: 21:49
 */

namespace app\controllers;

use Yii;
use app\models\Product;
use app\models\Cart;
use yii\helpers\Html;
use app\models\OrderItems;
use app\models\Order;

class CartController extends AppController
{
    public function actionShow()
    {
        $this->layout=false;
        $session=Yii::$app->session;
        $session->open();

        return $this->render('cart-window', compact('session'));
    }

    public function actionAdd($id, $qty=1)
    {
        $this->layout=false;
        $session=$this->sessionopen();

        $id=(int)(Html::encode($id));
        $qty=(int)(Html::encode($qty));
        $product=Product::findOne($id);
        if(empty($product)) return false;

        $cart=new Cart();
        $cart->AddToCart($product,$qty);
        if(!Yii::$app->request->isAjax) return $this->redirect(Yii::$app->request->referrer);
        return $this->render('cart-window', compact('session'));
    }

    public function actionClear()
    {
        $this->layout=false;

        $cart=new Cart();
        $cart->clearCart();

        return $this->render('cart-window', compact('session'));
    }
    public function actionDelitem($id)
    {
        $this->layout=false;
        $session=$this->sessionopen();

        $id=(int)(Html::encode($id));
        if(!$id) return $this->render('cart-window', compact('session'));

        $cart=new Cart();
        $cart->delFromCart($session,$id);

        return $this->render('cart-window', compact('session'));
    }

    public function actionView()
    {
        $session=$this->sessionopen();
        $this->setMeta('Корзина');

        $order=new Order();
        if($order->load(Yii::$app->request->post())){
            $order->qty=$session['cart.qty'];
            $order->sum=$session['cart.sum'];

            if($order->save()){
                Yii::$app->session->setFlash('success', "Заказ принят.");
                $this->saveOrderItems($session['cart'],$order->id);

                $session->remove('cart');
                $session->remove('cart.qty');
                $session->remove('cart.sum');
                return $this->refresh();
            }else{
                Yii::$app->session->setFlash('error', "Ошибка оформления заказа. Повторите попытку.");
            }
        }

        return $this->render('view', compact('session','order'));
    }

    public function saveOrderItems($items, $order_id)
    {
        foreach ($items as $id => $item) {
            $order_items=new OrderItems();
            $order_items->order_id=$order_id;
            $order_items->product_id=$id;
            $order_items->name=$item['name'];
            $order_items->price=$item['price'];
            $order_items->qty_item=$item['qty'];
            $order_items->sum_item=$item['price']*$item['qty'];
            $order_items->save();


        }
    }

}
