<?php
/**
 * Created by PhpStorm.
 * Author: Shengjun
 * CreateTime: 15-5-19.上午11:42
 * Description:
 */

namespace frontend\widgets;


use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class SideNav extends Widget{
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

    public $options;

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        return $this->renderTreeView($this->items,$this->options);
    }

    public function renderTreeView($childItems,$options){
        $items = [];
        foreach ($childItems as $i => $item) {
            if (isset($item['visible']) && !$item['visible']) {
                continue;
            }
            $items[] = $this->renderItem($item,$options);
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
        if (isset($item['active'])) {
            $active = ArrayHelper::remove($item, 'active', false);
        } else {
            $active = false;
        }
        if ($items !== null) {
            $label .= ' ' . Html::tag('i', '', ['class' => 'icon icon-gather pull-right']);
            if (is_array($items)) {
                $op =[];
                $op["class"] = "treeview-menu";
                if($active){
                    Html::addCssClass($op,"menu-open");
                    $op["style"] = "display:block;";
                }
                $items = $this->renderTreeView($items,$op);
            }
        }
        if ( $active) {
            Html::addCssClass($options, 'active');
        }
        return Html::tag('li', Html::a($label, $url, $linkOptions) . $items, $options);
    }
} 