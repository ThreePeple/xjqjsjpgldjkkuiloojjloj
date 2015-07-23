<?php
/**
 * Created by PhpStorm.
 * Author: Shengjun
 * CreateTime: 15-7-15.下午1:25
 * Description:
 */

namespace common\models;

use yii\base\Component;

class DataTableProvider extends Component{

    public $draw;
    public $recordsTotal;
    public $recordsFiltered;
    public $data;


} 