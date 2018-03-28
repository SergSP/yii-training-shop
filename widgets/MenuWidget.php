<?php

namespace app\widgets;

use yii\base\Widget;
use app\models\Category;
use Yii;

class MenuWidget extends Widget
{
    public $tpl='menu';
    public $data;
    public $tree;
    public $menuHTML;

    public function init()
    {
        parent::init();
        if(!in_array($this->tpl,['menu','select'])) $this->tpl='menu';
        $this->tpl.='.php';
    }

    public function run()
    {
        //get cache
        $menu=Yii::$app->cache->get('menu');
        if($menu) return $menu;

        $this->data = Category::find()->asArray()->indexBy('id')->all();
        $this->tree=$this->getTree();
        $this->menuHTML=$this->getMenuHtml($this->tree);

        //set cache
        Yii::$app->cache->set('menu',$this->menuHTML,60*30);

        return $this->menuHTML;
    }

    protected function getTree()
    {
        $tree=[];
        foreach ($this->data as $id => &$node) {
            if (!$node['parent_id']) $tree[$id]=&$node;
            else $this->data[$node['parent_id']]['childs'][$node['id']]=&$node;
        }
        return $tree;
    }

    protected function getMenuHtml($tree)
    {
        $str='';
        foreach ($tree as $category) {
            $str.=$this->catToTemplate($category);
        }
        return $str;
    }

    protected function catToTemplate($category)
    {
        ob_start();
        include __DIR__.'/menu_template/'.$this->tpl;
        return ob_get_clean();
    }
}