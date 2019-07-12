<?php

namespace app\api\controller;

use app\api\service\Token;
use app\common\controller\BaseController as Controller;

class BaseController extends Controller
{
    //管理员能访问
    protected function checkPrimaryScope()
    {
        return Token::needPrimaryScope();
    }
    //用户能访问，管理员不能访问
    protected function checkExclusiveScope()
    {
        return Token::needExclusiveScope();
    }
}