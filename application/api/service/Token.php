<?php

namespace app\api\service;


use app\common\lib\enum\ScopeEnum;
use app\common\lib\exception\ForbiddenException;
use app\common\lib\exception\TokenException;
use think\Cache;
use think\Exception;
use think\Request;

class Token
{
    public static function generateToken()
    {
        //32位的随机字符串
        $randChar = getRandChar(32);
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        $salt = config('secure.token_salt');
        return md5($randChar.$timestamp.$salt);
    }

    public static function getCurrentTokenVar($key)
    {
        $token = Request::instance()->header('token');
        $vars = Cache::get($token);
        if(!$vars)
        {
            throw new TokenException();
        }
        else
        {
            if(!is_array($vars))
            {
                $vars = json_decode($vars, true);
            }
            if(array_key_exists($key, $vars))
            {
                return $vars[$key];
            }
            else
            {
                throw new Exception('token变量不存在');
            }
        }
    }

    public static function getCurrentUid()
    {
        $uid = self::getCurrentTokenVar('uid');
        return $uid;
    }

    public static function needPrimaryScope()
    {
        $scope = self::getCurrentTokenVar('scope');
        if($scope)
        {
            if($scope >= ScopeEnum::User)
            {
                return true;
            }
            else
            {
                throw new ForbiddenException();
            }
        }
        else
        {
            throw new TokenException();
        }
    }

    public static function needExclusiveScope()
    {
        $scope = self::getCurrentTokenVar('scope');
        if($scope)
        {
            if($scope == ScopeEnum::User)
            {
                return true;
            }
            else
            {
                throw new ForbiddenException();
            }
        }
        else
        {
            throw new TokenException();
        }
    }

    public static function isValidOperate($checkedUID)
    {
        if(!$checkedUID)
        {
            throw new Exception('检测UID时，必须要传入一个被检测的UID');
        }
        $currentOperateUID = self::getCurrentUid();
        if($currentOperateUID == $checkedUID)
        {
            return true;
        }
        return false;
    }

    public static function verifyToken($token)
    {
        $exist = Cache::get($token);
        if($exist){
            return true;
        }
        else {
            return false;
        }
    }

}