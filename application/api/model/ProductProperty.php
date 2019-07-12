<?php

namespace app\api\model;


class ProductProperty extends BaseModel
{
    protected $hidden = ['delete_time', 'product_id', 'update_time'];
}