<?php
/**
 * Created by PhpStorm.
 * User: zouxiaojie
 * Date: 2019/6/14
 * Time: 1:25 PM
 */

namespace app\common\lib\exception;


class UserException extends BaseException
{
    public $code = 404;
    public $msg = '请求的用户不存在';
    public $errorCode = 60000;
}