<?php
/**
 * Created by PhpStorm.
 * User: zouxiaojie
 * Date: 2019/6/12
 * Time: 7:35 PM
 */

namespace app\api\validate;


class Count extends BaseValidate
{
    protected $rule = [
        'count' => 'isPositiveInteger|between:1,15'
    ];
}