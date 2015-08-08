<?php
/**
 * Created by PhpStorm.
 * Author: Shengjun
 * CreateTime: 15-5-10.下午5:33
 * Description:
 */

namespace frontend\widgets;


use frontend\widgets\assets\BoxAsset;
use yii\bootstrap\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class Box extends Widget{
    public $title= 'Box Title';
    public $label = '';
    public $content='';

    public $options = [
        "class" => 'box',
        "solid" => true,
        "variant" => null,
        "reload" => false,
        "header" => true,
        "footer" => true,
    ];

    public $headerOptions = [
        "border" => true,
    ];
    public $footerOptions = [];
    public $bodyOptions = [];
    public $toolbar = [
        "collapse" => true,
        "removeAble" => true,
        "items" => [],
        "options" =>[
            "class" => "",
        ],
    ];

    public $reloadOptions = [
        "source" => '/input/default/test',
        "trigger" => '.refresh-btn',
        "onLoadStart" => 'function(box){}',
        "onLoadDone" => "function(box){}",
    ];

    private $reload = false;
    private $header = true;
    private $js=[];
    /**
     * @var bool 折叠显示，只有设置 toolbar collapse = true时有效
     */
    public $collapsed = false;

    public $refresh = true;
    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();
        Html::addCssClass($this->options,"box");
        Html::addCssClass($this->headerOptions,"box-header");
        Html::addCssClass($this->bodyOptions,"box-body");
        Html::addCssClass($this->footerOptions,"box-footer");
        if($this->collapsed){
            Html::addCssClass($this->options,'collapsed-box');
        }
        $this->renderPanel();
    }
    public function renderPanel(){
        $this->header = ArrayHelper::remove($this->options,"header",true);
        $this->reload = ArrayHelper::remove($this->options,"reload",true);
        $solid = ArrayHelper::remove($this->options,"solid",false);
        $variant = ArrayHelper::remove($this->options,"variant",null);
        $border = ArrayHelper::remove($this->headerOptions,"border",false);
        if($solid){
            Html::addCssClass($this->options,'box-solid');
        }
        if($variant){
            Html::addCssClass($this->options,'box-'.$variant);
        }
        //render pannel container
        echo Html::beginTag("div",$this->options);
        //render header
        if($this->header){
            $this->renderHeader($border);
        }
        //render content body
        echo Html::beginTag("div",$this->bodyOptions);
    }

    public function run(){
        echo Html::endTag("div");
        echo Html::endTag("div");
        $this->registerScript();
        BoxAsset::register($this->getView());
    }



    public function renderHeader($border){
        if($border){
            Html::addCssClass($this->headerOptions,"with-border");
        }
        echo Html::beginTag('div',$this->headerOptions);
        echo $this->renderTitle();
        echo $this->renderToolbar();
        if($this->refresh){
            echo $this->addRefreshBtn();
        }
        echo Html::endTag("div");
    }

    public function registerScript(){
        //TODO
    }

    public function renderTitle(){
        return Html::tag("h3",$this->title,["class"=>"box-title"]);
    }

    public function renderToolbar(){
        $items = ArrayHelper::getValue($this->toolbar,"items",[]);
        $collapse = ArrayHelper::getValue($this->toolbar,"collapse",false);
        $removeAble = ArrayHelper::getValue($this->toolbar,"removeAble",false);
        $options = ArrayHelper::getValue($this->toolbar,"options");
        if($collapse){
            if($this->collapsed){
                $items[] = '<button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-plus"></i></button>';
            }else{
                $items[] = '<button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>';
            }
        }
        if($removeAble){
            $items[] = '<button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>';
        }
        Html::addCssClass($options,"box-tools pull-right");
        return Html::tag("div",implode("\n",$items),$options);
    }

    public function renderFooter(){
        //return Html::tag("div",$this->footer,$this);
    }
    public function addRefreshBtn(){
        return '<div class="refresh-btn"></div>';
    }
} 