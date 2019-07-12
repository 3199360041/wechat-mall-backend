<?php
/**
 * Created by PhpStorm.
 * User: zouxiaojie
 * Date: 2019/6/12
 * Time: 6:29 PM
 */

namespace app\common\lib\exception;


class ThemeException extends BaseException
{
    public $code = 404;
    public $msg = '指定主题不存在，请检查主题ID';
    public $errorCode = 30000;
}