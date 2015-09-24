<?php
/**
 * Created by PhpStorm.
 * User: milon
 * Date: 15/8/22
 * Time: 16:05
 */
namespace frontend\models;
class Constants {
    const DEVICE='plat/res/device';//设备信息列表
    const DEVICE_LINK='plat/res/link';//链路信息列表
    const IP_MAC_LEARN='res/access/ipMacLearn';//查询设备当前的接入信息列表
    const TASK='perf/task';//性能指标
    const DEVICE_TASK='perf/summaryData';//设备性能指标
    const DEVICE_ALARM='fault/alarm';//设备告警信息
    const DEVICE_MODEL='plat/res/model';//设备型号
    public static $TASKS=[1,2,4,5,6,8];//设备性能指标配置项

}