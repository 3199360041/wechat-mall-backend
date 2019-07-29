<?php

namespace app\api\validate;

use app\common\lib\exception\ParameterException;
use think\Request;
use think\Validate;

class BaseValidate extends Validate
{
    public function goCheck()
    {
        $request = Request::instance();
        $params = $request->param();
//        var_dump($params);

        $result = $this->batch()->check($params);
//        var_dump($result);return;
        if (!$result)
        {
            throw new ParameterException([
//                'code' => 400,
//                'errorCode' => 10002,
                'msg' => $this->error,
            ]);
        }
        else
        {
            return true;
        }
    }

    protected function isPositiveInteger($value, $rule = '', $data = '', $field = '')
    {
        if(is_numeric($value) && is_int($value + 0) && ($value + 0) > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }


    protected function isNotEmpty($value, $rule = '', $data = '', $field = '')
    {
        if(empty($value))
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    public function getDataByRule($arrays)
    {
        if(array_key_exists('user_id', $arrays) |
        array_key_exists('uid', $arrays))
        {
            throw new ParameterException([
                'msg' => '参数中含有非法参数名user_id或uid'
            ]);
        }
        $newArray = [];
        foreach($this->rule as $key => $value)
        {
            $newArray[$key] = $arrays[$key];
        }
        return $newArray;
    }

    //没有使用TP的正则验证，集中在一处方便以后修改
    //不推荐使用正则，因为复用性太差
    //手机号的验证规则
    protected function isMobile($value)
    {
        $rule = '^((0\d{2,3}-\d{7,8})|(1[3584]\d{9}))$^';
        $result = preg_match($rule, $value);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}