<?php
/**
 * Created by PhpStorm.
 * User: zouxiaojie
 * Date: 2019/6/12
 * Time: 7:46 PM
 */

namespace app\common\lib\exception;


class ProductException extends BaseException
{
    public $code = 404;
    public $msg = '指定商品不存在，请检查商品ID';
    public $errorCode = 20000;
}