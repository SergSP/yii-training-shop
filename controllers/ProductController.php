<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 27.03.2018
 * Time: 18:46
 */

namespace app\controllers;

use app\models\Category;
use app\models\Product;
use yii\helpers\Html;
use Yii;
use yii\web\HttpException;

class ProductController extends AppController
{
    public function actionView($id)
    {
        $product=Product::findOne($id);
        $hits=Yii::$app->cache->get('hits');
        if(!$hits){
            $hits = Product::find()->where(['hit' => '1', 'hide' => '0'])->limit(6)->all();
            Yii::$app->cache->set('hits',$hits ,60*30);
        }

        if(empty($product)) throw new HttpException(404,"Товар не найден.");

        $this->setMeta('[Yii-тренинг] Интернет магазин | ' . $product->name, $product->keywords, $product->description);
        return $this->render('view', compact('product', 'hits'));
    }
}