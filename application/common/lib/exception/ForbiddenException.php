<?php
/**
 * Created by PhpStorm.
 * User: zouxiaojie
 * Date: 2019/6/14
 * Time: 3:36 PM
 */

namespace app\common\lib\exception;


class ForbiddenException extends BaseException
{
    public $code = 403;
    public $msg = '权限不够';
    public $errorCode = 10001;
}