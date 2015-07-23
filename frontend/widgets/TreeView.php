<?php
/**
 * Created by PhpStorm.
 * Author: Shengjun
 * CreateTime: 15-5-8.下午7:29
 * Description:
 */

namespace frontend\widgets;


use yii\base\InvalidConfigException;
use yii\bootstrap\BootstrapAsset;
use yii\bootstrap\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;

class TreeView extends Widget{
    /**
     * @var array list of items in the nav widget. Each array element represents a single
     * menu item which can be either a string or an array with the following structure:
     *
     * - label: string, required, the nav item label.
     * - url: optional, the item's URL. Defaults to "#".
     * - visible: boolean, optional, whether this menu item is visible. Defaults to true.
     * - linkOptions: array, optional, the HTML attributes of the item's link.
     * - options: array, optional, the HTML attributes of the item container (LI).
     * - active: boolean, optional, whether the item should be on active state or not.
     * - items: array|string, optional, the configuration array for creating a [[Dropdown]] widget,
     *   or a string representing the dropdown menu. Note that Bootstrap does not support sub-dropdown menus.
     *
     * If a menu item is a string, it will be rendered directly without HTML encoding.
     */
    public $items = [];
    /**
     * @var boolean whether the nav items labels should be HTML-encoded.
     */
    public $encodeLabels = false;

    public static $level_counter=[];

    public $collapse = true;

    public $options = [
        "ajax" => false,
        "ajaxUrl" => '',
        "collapse" => true,
    ];
    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();
        $this->registerScript();
    }
    public function registerScript(){
        $js=[];
        $js[] = "jQuery('.sidebar').delegate('.ajax','click',function(){
            var _data={};
            _data['uid'] ='u_'+$(this).attr('id');
            var _url = $(this).attr('ajaxUrl');
            var _this = this;
            console.log(_data,_this);
            $(_this).removeClass('ajax')
            jQuery.ajax({
                url:_url,
                type:'post',
                data: _data,
                success:function(res){
                    // var _id = $(res).attr('_id');
                    $(_this).find('ul').replaceWith($(res));
                    $(_this).find('ul').collapse('show');
                }
            });
            return false;
        })";
        $this->getView()->registerJs(implode("\n", $js),View::POS_READY,'collapse-menu');
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        BootstrapAsset::register($this->getView());
        $options = $this->options;
        $_id = $this->getId();
        Html::addCssClass($options,$_id);
        return $this->renderTreeView($this->items, $options);
    }

    public function renderTreeView($childItems,$options){
    $items = [];
    foreach ($childItems as $i => $item) {
        if (isset($item['visible']) && !$item['visible']) {
            continue;
        }
        $items[] = $this->renderItem($item,$options);
    }
    $collapse = ArrayHelper::remove($options,"collapse",true);
    if($collapse)
        Html::addCssClass($options,"collapse");
    else{
        Html::addCssClass($options,"collapse in");
    }

    return Html::tag('ul', implode("\n", $items), $options);
}

    public function renderItem($item){
        if (is_string($item)) {
            return $item;
        }
        if (!isset($item['label'])) {
            throw new InvalidConfigException("The 'label' option is required.");
        }
        $encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
        $label = $encodeLabel ? Html::encode($item['label']) : $item['label'];
        $options = ArrayHelper::getValue($item, 'options', []);
        $items = ArrayHelper::getValue($item, 'items');
        $url = ArrayHelper::getValue($item, 'url', '#');
        $linkOptions = ArrayHelper::getValue($item, 'linkOptions', []);
        $id = ArrayHelper::getValue($item,"id");
        $options["id"] = $id;
        $ajax = ArrayHelper::remove($options,"ajax",false);

        if ($items !== null) {
            $toggle_class = 'u_'.$id;
            $linkOptions['data-toggle'] = 'collapse';
            $linkOptions['data-target'] = '.'.$toggle_class;

            Html::addCssClass($options, 'collapse-menu');
            if($ajax){
                Html::addCssClass($options,"ajax");
            }
            Html::addCssClass($linkOptions, 'collapsed');
            Html::addCssClass($linkOptions, 'collapse-toggle');
            $label .= ' ' . Html::tag('b', '', ['class' => 'caret']);
            if (is_array($items)) {
                $op =[];
                $op["id"] = $toggle_class;
                //$op["class"] = "collapse";
                Html::addCssClass($op,$toggle_class);
                $items = $this->renderTreeView($items,$op);
            }
        }
        return Html::tag('li', Html::a($label, $url, $linkOptions) . $items, $options);
    }
} 