<?php
/**
 * Created by PhpStorm.
 * User: jsj
 * Date: 15/8/19
 * Time: 22:42
 */

namespace app\models;

use Yii;
use yii\helpers\Url;
use yii\log\Logger;


class RestfulClient {
    private $host;
    private $ch;
    private $error_code = 0;
    private $error_msg='';
    private $data;


    public function clear(){
        $this->error_code = 0;
        $this->error_msg='';
        $this->data = null;
    }

    /**
     * 读取数据
     * @return mixed
     */
    public function getData(){
        return $this->data;
    }
    /**
     * @return bool 请求是否有错
     */
    public function hasErrors()
    {
        return $this->error_code !== 0;
    }

    /**
     * @return string 获取请求错误信息
     */
    public function getError()
    {
        return $this->error_msg;
    }

    public function getErrorCode(){
        return $this->error_code;
    }

    public static function get($path,$query){
        $model = new self();
        $model->request("GET",$path,$query);
        return $model->getData();
    }

    public function request($method,$path,$params){
        $this->clear();

        $this->ch = curl_init();
        $options = [
            CURLOPT_USERAGENT       => 'cnpc_' . __CLASS__,
            CURLOPT_TIMEOUT         => 10,
            CURLOPT_RETURNTRANSFER  => 1,
        ];
        curl_setopt_array($this->ch,$options);

        $method = strtoupper($method);
        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, $method); //设置请求方式
        curl_setopt($this->ch,CURLOPT_HTTPHEADER,array("X-HTTP-Method-Override: $method"));//设置HTTP头信息
        switch ($method){
            case 'POST' :
                curl_setopt($this->ch,CURLOPT_POST, 1);
                curl_setopt($this->ch,CURLOPT_POSTFIELDS, $params);
                $url = $this->buildUrl($path);
                break;
            default :
                $url = $this->buildUrl($path,$params);
                break;
        }
        curl_setopt($this->ch,CURLOPT_URL,$url);
        $this->data = curl_exec($this->ch);
        if ($this->data === false || $this->data === null) {
            $this->error_code = curl_errno($this->ch);
            $this->error      = curl_error($this->ch);
        }
        Yii::getLogger()->log($this->data,Logger::LEVEL_TRACE,'curl\return');
        curl_close($this->ch);

        $this->parseResult();
    }

    public function parseResult(){
        //TODO
    }

    public function buildUrl($path,$params=[]){
        $domain = Yii::$app->params["apiDomain"];
        $url = $domain .'/'. trim($path,'/');
        $url .= empty($params)? '' : '?'.http_build_query($params);
        return $url;
    }
}