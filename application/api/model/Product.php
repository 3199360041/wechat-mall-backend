<?php

namespace app\api\model;


class Product extends BaseModel
{
    protected $hidden = ['create_time', 'delete_time', 'update_time', 'pivot', 'from', 'category_id'];

    protected $autoWriteTimestamp = true;

    public function getMainImgUrlAttr($value, $data)
    {
        return $this->getUrlAttr($value, $data);
    }

    public function imgs()
    {
        return $this->hasMany('ProductImage', 'product_id', 'id');
    }

    public function properties()
    {
        return $this->hasMany('ProductProperty', 'product_id', 'id');
    }

    public static function getMostRecent($count)
    {
        return self::limit($count)->order('create_time desc')->select();
    }

    public static function getAllByCategoryID($id)
    {
        $products = self::where('category_id', '=', $id)->select();
        return $products;
    }

    public static function getProductDetail($id)
    {
        $product = self::with([
            'imgs' => function($query){
                $query->with(['imgUrl'])->order('order', 'asc');
            }
        ])->with(['properties'])->find($id);
        return $product;
    }
}
