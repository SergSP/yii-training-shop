<?php

namespace app\widgets;

use yii\base\Widget;
use app\models\Category;
use Yii;

class MenuWidget extends Widget
{
    public $tpl='menu';
    public $model;
    public $data;
    public $tree;
    public $menuHTML;

    public function init()
    {
        parent::init();
        if(!in_array($this->tpl,['menu','select','selectproduct'])) $this->tpl='menu';
        $this->tpl.='.php';
    }

    public function run()
    {
        //get cache
        if ($this->tpl == 'menu.php'){
            $menu = Yii::$app->cache->get('menu');
            if ($menu) return $menu;
        }

        $this->data = Category::find()->asArray()->indexBy('id')->all();
        $this->tree=$this->getTree();
        $this->menuHTML=$this->getMenuHtml($this->tree);

        //set cache
        if ($this->tpl == 'menu.php')
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

    protected function getMenuHtml($tree, $tab='')
    {
        $str='';
        foreach ($tree as $category) {
            $str.=$this->catToTemplate($category, $tab);
        }
        return $str;
    }

    protected function catToTemplate($category, $tab)
    {
        ob_start();
        include __DIR__.'/menu_template/'.$this->tpl;
        return ob_get_clean();
    }
}