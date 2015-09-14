<?php
/**
 * Created by PhpStorm.
 * User: jsj
 * Date: 15/8/19
 * Time: 22:42
 */

namespace frontend\models;

use Yii;
use yii\helpers\Url;
use yii\log\Logger;


class RestfulClient {
    private $host;
    private $ch;
    private $error_code = 0;
    private $error_msg='';
    private $data;

    private $config_key;

    public function __construct($auth_key=null){
        if($auth_key){
            $this->config_key = $auth_key;
        }
    }


    public function withConfig($key){
        $this->config_key=$key;
        return $this;
    }

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

    public function get($url,$query=[]){
        $this->request("GET",$url,$query);
        return $this;
    }

    public function post($url,$post){
        $this->request('POST',$url,[],$post);
        return $this;
    }

    public function request($method,$url,$params=[],$post=[]){
        $this->clear();

        $this->ch = curl_init();
        $options = [
            CURLOPT_USERAGENT       => 'cnpc_' . __CLASS__,
            CURLOPT_TIMEOUT         => 10,
            CURLOPT_RETURNTRANSFER  => 1,
        ];
        curl_setopt_array($this->ch,$options);

        $method = strtoupper($method);

        $this->setHeaders($method);
        $this->setAuth();

        switch ($method){
            case 'POST' :
                curl_setopt($this->ch,CURLOPT_POST, 1);
                curl_setopt($this->ch,CURLOPT_POSTFIELDS, $post);
                break;
            default :
                break;
        }
        $url = $this->buildUrl($url,$params);
        curl_setopt($this->ch,CURLOPT_URL,$url);
        Yii::trace(print_r(curl_getinfo($this->ch),true),"curl/request");
        $this->data = curl_exec($this->ch);
        $error_code = curl_errno($this->ch);
        if($error_code != 0) {
            $this->error_code = $error_code;
            $this->error      = curl_error($this->ch);
        }
        Yii::trace($this->data,'curl/return');
        curl_close($this->ch);

        $this->parseResult();
        return $this;
    }

    public function parseResult(){
        $this->data = json_decode($this->data,true);
    }

    public function setHeaders($method){
        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, $method); //设置请求方式
        curl_setopt($this->ch,CURLOPT_HTTPHEADER,[
            "X-HTTP-Method-Override: $method",
            "Accept: application/json",
            "Content-Type: application/json; charset=UTF-8",
        ]);//设置HTTP头信息
    }

    public function setAuth(){
        $auth = Yii::$app->params["apiAuth"];
        $type = $auth["type"];
        curl_setopt($this->ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        switch($type){
            case "http_basic":
                if(isset($this->config_key)){
                    $key = $this->config_key;
                }else{
                    $key = "http_basic";
                }

                $user = $auth[$key]["user"];
                $pwd = $auth[$key]["pwd"];
                curl_setopt($this->ch,CURLOPT_USERPWD, $user . ':' . $pwd);
                break;
            default:
                break;
        }
    }

    public function buildUrl($url,$params=[]){
        $url .= empty($params)? '' : '?'.http_build_query($params);
        return $url;
    }
}