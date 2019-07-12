<?php

namespace app\api\model;


class Banner extends BaseModel
{
    protected $hidden = ['delete_time', 'update_time'];

    public static function getBannerByID($id)
    {
        $res = self::with(['items', 'items.img'])->find($id);
        return $res;
    }

    public function items()
    {
        return $this->hasMany('BannerItem', 'banner_id', 'id');
    }
}