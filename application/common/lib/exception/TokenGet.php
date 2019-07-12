<?php
/**
 * Created by PhpStorm.
 * User: zouxiaojie
 * Date: 2019/6/13
 * Time: 2:30 PM
 */

namespace app\common\lib\exception;


use app\api\validate\BaseValidate;

class TokenGet extends BaseValidate
{
    protected $rule = [
        'code' => 'require|isNotEmpty'
    ];

    protected $message = [
        'code' => '没有code，不能获取token'
    ];
}