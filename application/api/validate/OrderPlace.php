<?php
/**
 * Created by PhpStorm.
 * User: zouxiaojie
 * Date: 2019/6/15
 * Time: 3:44 PM
 */

namespace app\api\validate;


use app\common\lib\exception\ParameterException;

class OrderPlace extends BaseValidate
{
    protected $products = [
        [
            'product_id' => 1,
            'count' => 3
        ],
        [
            'product_id' => 2,
            'count' => 3
        ],
        [
            'product_id' => 3,
            'count' => 3
        ]
    ];

    protected $oProducts = [
        [
            'product_id' => 1,
            'count' => 3
        ],
        [
            'product_id' => 2,
            'count' => 3
        ],
        [
            'product_id' => 3,
            'count' => 3
        ]
    ];

    protected $rule = [
        'products' => 'checkProducts'
    ];

    protected $singleRule = [
        'product_id' => 'require|isPositiveInteger',
        'count' => 'require|isPositiveInteger'
    ];

    protected function checkProducts($values)
    {
//        $values = [
//            [
//                'product_id' => 1,
//                'count' => 4
//            ],
//            [
//                'product_id' => 2,
//                'count' => 5
//            ]
//        ];

        if(!is_array($values))
        {
            throw new ParameterException([
                'msg' => '商品参数不正确'
            ]);
        }
        if(empty($values))
        {
            throw new ParameterException([
                'msg' => '商品列表不能为空'
            ]);
        }


        foreach($values as $value)
        {
            $this->checkProduct($value);
        }

        return true;
    }

    protected function checkProduct($value)
    {
        $validate = new BaseValidate($this->singleRule);
        $result = $validate->check($value);
        if(!$result)
        {
            throw new ParameterException([
                'msg' => '商品列表参数错误'
            ]);
        }
    }
}