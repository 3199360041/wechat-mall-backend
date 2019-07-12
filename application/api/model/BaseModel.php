<?php

namespace app\api\model;

use think\Model;

class BaseModel extends Model
{
    public function getUrlAttr($value, $data)
    {
        $finalUrl = $value;
        //$data['from'] == 1 图片保存在本地
        //$data['from'] == 2 图片保存在七牛云
        if($data['from'] == 1)
        {
            $finalUrl = config('setting.img_prefix').$value;
        }
        return $finalUrl;
    }
}
