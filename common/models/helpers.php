<?php
/**
 * Created by PhpStorm.
 * User: milon517
 * Date: 2015/9/29
 * Time: 10:43
 */

namespace common\models;
use Yii;

class helpers
{
    /**
     * 根据IP规则得到设备所在区域
     * @param $ip
     */
    public static function getAreaByIpRules($ip)
    {
        if(empty($ip))
        {
            return '';
        }
        $_area='';
        $_ips=explode('.',$ip);
        if(!empty($_ip[2]))
        {
           $_tmp=$_ip[2];
           //得到最后一位数字
           $_tmp=substr($_tmp,-1);
            switch($_tmp)
            {
                case '1':
                    $_area='A';
                    break;
                case '2';
                    $_area='B';
                    break;
                case '3':
                    $_area='C';
                    break;
                case '4':
                    $_area='D';
                    break;
            }
        }
        return $_area;
    }

}