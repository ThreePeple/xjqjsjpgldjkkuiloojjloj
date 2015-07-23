<?php
/**
 * Created by PhpStorm.
 * Author: Shengjun
 * CreateTime: 15-7-14.下午4:14
 * Description:
 */

namespace frontend\widgets;

use frontend\widgets\DataTableAsset;
use yii\bootstrap\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;

class DataTable extends Widget{
    public $jsOptions = [
        "oLanguage" =>[
            "sProcessing"=>   "处理中...",
                "sLengthMenu"=>   "显示 _MENU_ 项结果",
                "sZeroRecords"=>  "没有匹配结果",
                "sInfo"=>         "显示第 _START_ 至 _END_ 项结果，共 _TOTAL_ 项",
                "sInfoEmpty"=>    "显示第 0 至 0 项结果，共 0 项",
                "sInfoFiltered"=> "(由 _MAX_ 项结果过滤)",
                "sInfoPostFix"=>  "",
                "sSearch"=>       "搜索:",
                "sUrl"=>          "",
                "sEmptyTable"=>     "表中数据为空",
                "sLoadingRecords"=> "载入中...",
                "sInfoThousands"=>  ",",
                "oPaginate"=> [
                    "sFirst"=>    "首页",
                    "sPrevious"=> "上页",
                    "sNext"=>     "下页",
                    "sLast"=>     "末页"
                ],
                "oAria"=> [
                    "sSortAscending"=>  ": 以升序排列此列",
                    "sSortDescending"=> ": 以降序排列此列"
                ]
            ]
        ];
    /**
     * table html options
     * @var
     */
    public $options= [
        "class" => 'display table table-bordered table-striped',
        "width" => '100%'
    ];

    /**
     * @var bool 统计信息
     */
    public $summary = true;
    /**
     * @var bool 是否显示分页
     */
    public $page = true;
    /**
     * @var bool 是否显示每页选择项
     */
    public $pPage = true;
    /**
     * @var bool 是否显示搜索
     */
    public $searchBar = true;

    /**
     * @var array server sider options
     */
    public $ajaxOptions = [
        "url" => '#',
        "type" => 'POST'
    ];
    /**
     * 列定义
     * "columns": [
    {"data": "id", "bSortable": false,"visible": false},
    {"data": "firstName"},
    {"data": "lastName"}
    ],
     * @var
     */
    public $columns=[];
    /**
     * @var 列定义
     * {
    "targets": [3],
    "data": "id",
    "render": function(data, type, full) {
    return "<a href='/update?id=" + data + "'>Update</a>";
    }
    }
     * targets：表示具体需要操作的目标列，下标从0开始
    data: 表示我们需要的某一列数据对应的属性名
    render:返回需要显示的内容。在此我们可以修改列中样式，增加具体内容
    属性列表：data， 之前属性定义中对应的属性值
    type， 未知
    full,    全部数据值可以通过属性列名获取
     */
    public $columnDefs=[];

    public function init(){
        parent::init();
        $headers = $this->renderHeader();
        $footers = $this->renderFooter();
        $content = array_filter([
            $headers,
            $footers
        ]);
        echo Html::tag('table', implode("\n", $content), $this->options);
    }

    public function run(){
        $view  = $this->getView();
        DataTableAsset::register($view);
        $view->registerJs($this->getClientOptions());
    }

    /**
     * 注册代码
     */
    protected function getClientOptions(){
        $id = $this->getId();
        $url = $this->ajaxOptions["url"];
        $type = $this->ajaxOptions["type"];
        $columns = Json::htmlEncode($this->columns);
        $columnDefs = Json::htmlEncode($this->columnDefs);
        $js = <<<JS
        jQuery('#$id').dataTable({
            "oLanguage":{
                "sProcessing":   "处理中...",
                "sLengthMenu":   "显示 _MENU_ 项结果",
                "sZeroRecords":  "没有匹配结果",
                "sInfo":         "显示第 _START_ 至 _END_ 项结果，共 _TOTAL_ 项",
                "sInfoEmpty":    "显示第 0 至 0 项结果，共 0 项",
                "sInfoFiltered": "(由 _MAX_ 项结果过滤)",
                "sInfoPostFix":  "",
                "sSearch":       "搜索:",
                "sUrl":          "",
                "sEmptyTable":     "表中数据为空",
                "sLoadingRecords": "载入中...",
                "sInfoThousands":  ",",
                "oPaginate": {
                    "sFirst":    "首页",
                    "sPrevious": "上页",
                    "sNext":     "下页",
                    "sLast":     "末页"
                },
                "oAria": {
                    "sSortAscending":  ": 以升序排列此列",
                    "sSortDescending": ": 以降序排列此列"
                }
            },
            'serverSide':true,
            //'processing':true,
            'ajax':{
                "url": '$url',
                "type": '$type'
            },
            "columns": $columns,
            "columnDefs":$columnDefs
        });
JS;
        return $js;
    }

    /**
     * 生成表头
     */
    public function renderHeader(){
        $html = [];
        $html[] = '<thead>';
        $html[] = '<tr>';
        foreach($this->columns as $column){
            $header = isset($column["name"])?$column["name"]:$column["data"];
            $html[] = Html::tag('th',$header);
        }
        $html[] = '</tr>';
        $html[] = '</thead>';
        return implode("\n",$html);
    }

    /**
     * 表页脚
     */
    public function renderFooter(){
        if(empty($this->footers))
            return '';
        $html = [];
        $html[] = '<tfoot>';
        $html[] = '<tr>';
        foreach($this->footers as $header=>$options){
            $html[] = Html::tag('th',$header);
        }
        $html[] = '</tr>';
        $html[] = '</tfoot>';
        return implode("\n",$html);
    }
}