<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 26.03.2018
 * Time: 12:46
 */

namespace app\controllers;

use Yii;
use yii\web\Controller;

class AppController extends Controller
{
    protected function setMeta($title = null, $keywords = null, $description = null)
    {
        $this->view->title = $title;
        $this->view->registerMetaTag(['name' => 'keywords', 'content' => $keywords]);
        $this->view->registerMetaTag(['name' => 'description', 'content' => $description]);
    }

    protected function sessionopen()
    {
        $session=Yii::$app->session;
        $session->open();
        return $session;
    }

    protected function clearCart()
    {
        $session=$this->sessionopen();
        $session->remove('cart');
        $session->remove('cart.qty');
        $session->remove('cart.sum');
    }

}