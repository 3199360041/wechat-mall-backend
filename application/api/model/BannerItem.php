<?php

namespace app\api\model;


class BannerItem extends BaseModel
{
    protected $hidden = ['id', 'img_id', 'banner_id', 'delete_time', 'update_time'];

    public function banner()
    {
        return $this->belongsTo('Banner', 'id', 'banner_id');
    }

    public function img()
    {
        return $this->belongsTo('Image', 'img_id', 'id');
    }
}
