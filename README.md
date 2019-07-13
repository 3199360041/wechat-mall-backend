```bash
cd ./public
path/to/php -S 127.0.0.1:8000 router.php
```

#  运行的时候，需要配置微信小程序的id和secret, 微信支付相关的商户号和支付key
#  ./application/extra/wx.php

#  需要配置支付回调地址
#  ./application/extra/secure.php

#  数据库文件是./data/zerg.sql

#  TODO:
* 后台管理系统
* 第三方云储存(qiniu, aliyuncs, qcloud)
* 微信小程序端支付功能


#   wx.php文件内容如下:
```php
<?php

return [
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
];
```