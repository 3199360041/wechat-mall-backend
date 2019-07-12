<?php

namespace app\api\controller\v1;

use app\api\service\Token as TokenService;
use app\api\service\UserToken;
use app\common\lib\exception\ParameterException;
use app\common\lib\exception\TokenGet;

class Token
{
    public function getToken($code = '')
    {
        (new TokenGet())->goCheck();
        $ut = new UserToken($code);
        $token = $ut->get();
        return [
            'token' => $token
        ];
    }

    public function verfiyToken($token = '')
    {
        if(!$token){
            throw new ParameterException([
                'token不能为空'
            ]);
        }
        $valid = TokenService::verifyToken($token);

        return [
            'isValid' => $valid
        ];
    }
}