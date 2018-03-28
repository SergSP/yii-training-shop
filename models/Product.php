<?php

namespace app\models;

use yii\db\ActiveRecord;


class Product extends ActiveRecord
{
    public static function tableName()
    {
        return 'product';
    }

    public function getCategory()
    {

        return $this->hasOne(Category::classname(), ['id' => 'category_id']);

    }

}