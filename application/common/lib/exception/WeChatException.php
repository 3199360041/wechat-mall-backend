<?php
/**
 * Created by PhpStorm.
 * User: zouxiaojie
 * Date: 2019/6/13
 * Time: 3:30 PM
 */

namespace app\common\lib\exception;


class WeChatException extends BaseException
{
    public $code = 400;
    public $msg = '微信服务器接口调用失败';
    public $errorCode = 999;
}