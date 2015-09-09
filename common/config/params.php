<?php
return [
    'wireless_api_host' => 'http://223.72.164.195:8090/imcrs/',
    'api_host' => 'http://10.253.10.223:8080/imc/',
    'user.passwordResetTokenExpire' => 3600,
    "apiAuth" => [
        "type" => "http_basic",
        "http_basic" => [
            "user" => 'huligen',
            "pwd" => 'huligen',
        ],
        'http_imc' =>[
            "user" => 'admin',
            "pwd" => '2233@dzm',
        ],
    ],
    'sms_soap' => 'http://10.8.125.9:8022/SendMSMService/Service.svc?wsdl'
];
