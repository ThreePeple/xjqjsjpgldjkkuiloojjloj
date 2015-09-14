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

    private $http_code = 500;

    private $request_headers = [
        'Accept' => 'application/json',
        'X-HTTP-Method-Override' => 'GET',
        'Content-Type'=>'application/json; charset=UTF-8'
    ];

    private $response_headers = [];

    public function __construct($auth_key=null){
        if($auth_key){
            $this->config_key = $auth_key;
        }
    }

    public function getHeader($k=null){
        if($k){
            return $this->response_headers[$k];
        }else{
            return $this->response_headers;
        }
    }

    public function withHeaders($headers){
        $this->request_headers = array_merge($this->request_headers,$headers);
        return $this;
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

    public function getHttpCode(){
        return $this->http_code;
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
            CURLOPT_HEADERFUNCTION => 'handlerHeaders',
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
        }else{
            $this->http_code = curl_getinfo($this->ch,CURLINFO_HTTP_CODE);
            switch($this->http_code){
                case 401:
                case 403:
                    $this->error_code = $this->http_code;
                    $this->error = '用户验证失败';
                    break;
                case 400:
                    $this->error_code = $this->http_code;
                    $this->error = 'Bad Request';
                    break;
                case 409:
                    $this->error = $this->getHeader('Error-Message');
                    $this->error_code = $this->http_code;
                    break;
            }
        }
        Yii::trace($this->data,'curl/return');
        curl_close($this->ch);

        $this->parseResult();
        return $this;
    }

    public function handlerHeaders($ch,$strHeader){
        $h = explode(':',$strHeader,2);
        if(count($h)==2){
            $this->response_headers[$h[0]] = $h[1];
        }else{
            $this->response_headers[] = $strHeader;
        }
        return strlen($strHeader);
    }

    public function parseResult(){
        $this->data = json_decode($this->data,true);
    }

    public function setHeaders($method){
        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, $method); //设置请求方式
        $this->request_headers['X-HTTP-Method-Override'] = $method;
        $headers = [];
        foreach($this->request_headers as $k=>$h){
            if(is_int($k)){
                $headers[] = $h;
            }else{
                $headers[] = $k.':'.$h;
            }
        }
        curl_setopt($this->ch,CURLOPT_HTTPHEADER,$headers);//设置HTTP头信息
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