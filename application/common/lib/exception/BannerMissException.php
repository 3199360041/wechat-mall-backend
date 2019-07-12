<?php
/**
 * Created by PhpStorm.
 * User: zouxiaojie
 * Date: 2019/6/3
 * Time: 8:08 AM
 */

namespace app\common\lib\exception;


class BannerMissException extends BaseException
{
    public $code = 400;
    public $msg = '请求的Banner不存在';
    public $errorCode = 40000;
}