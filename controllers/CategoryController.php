<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 27.03.2018
 * Time: 17:20
 */

namespace app\controllers;
use app\models\Category;
use app\models\Product;
use yii\data\Pagination;
use yii\helpers\Html;
use Yii;
use yii\web\HttpException;

class CategoryController extends AppController
{
    public function actionIndex(){
        $hits = Product::find()->where(['hit' => '1', 'hide' => '0'])->limit(6)->all();
        $this->setMeta('[Yii-тренинг] Интернет магазин');
        return $this->render('index', compact('hits'));
    }

    public function actionView($id){
//        $products = Product::find()->where(['category_id' => Html::encode($id)])->limit(9)->all();
        $query = Product::find()->where(['category_id' => Html::encode($id)]);
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 9, 'forcePageParam' => false, 'pageSizeParam' => false]);
        $products = $query->offset($pages->offset)->limit($pages->limit)->all();

        if(empty($products)) throw new HttpException(404,"Категория не найдена.");

        $catinfo=Yii::$app->cache->get('catinfo'.$id);
        if(!$catinfo){
            $catinfo = Category::findOne($id);
            Yii::$app->cache->set('catinfo'.$id,$catinfo ,60*120);
        }

        $this->setMeta('[Yii-тренинг] Интернет магазин | ' . $catinfo->name, $catinfo->keywords, $catinfo->description);
        return $this->render('view', compact('products', 'pages', 'catinfo'));
    }
}