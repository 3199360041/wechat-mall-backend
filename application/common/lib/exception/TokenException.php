<?php
/**
 * Created by PhpStorm.
 * User: zouxiaojie
 * Date: 2019/6/13
 * Time: 6:15 PM
 */

namespace app\common\lib\exception;


class TokenException extends BaseException
{
    public $code = 401;
    public $msg = 'token无效或者已过期';
    public $errorCode = 10001;
}