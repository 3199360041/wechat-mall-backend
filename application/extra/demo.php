<?php

return [
    'secure' => [
        'token_salt' => 'jiwlkpih,mndkjhfSEWSDFDkjishdkf',
        //'pay_back_url' => 'http://localhost:8000/api/v1/pay/notify',
        'pay_back_url' => 'http://notify.vipgz1.idcfengye.com/api/v1/pay/notify',//Ngrok
    ],
    'setting' => [
        'img_prefix' => 'http://127.0.0.1:8000/images',
        'token_expire_in' => 7200,
    ],
    'wx' => [

        //商户号
        'merchant_id' => '',
        'key' => '',

        // 小程序app_id
        'app_id' => '',
        // 小程序app_secret
        'app_secret' => '',

        // 微信使用code换取用户openid及session_key的url地址
        'login_url' => "https://api.weixin.qq.com/sns/jscode2session?" .
            "appid=%s&secret=%s&js_code=%s&grant_type=authorization_code",

        // 微信获取access_token的url地址
        'access_token_url' => "https://api.weixin.qq.com/cgi-bin/token?" .
            "grant_type=client_credential&appid=%s&secret=%s",
    ],
];
