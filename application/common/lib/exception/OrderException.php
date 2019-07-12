<?php
/**
 * Created by PhpStorm.
 * User: zouxiaojie
 * Date: 2019/6/16
 * Time: 2:19 PM
 */

namespace app\common\lib\exception;


class OrderException extends BaseException
{
    public $code = 404;
    public $msg = '订单不存在，请检查ID';
    public $errorCode = 80000;
}