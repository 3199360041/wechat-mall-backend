<?php
/**
 * Created by PhpStorm.
 * User: zouxiaojie
 * Date: 2019/6/18
 * Time: 2:39 PM
 */

namespace app\api\validate;


class PagingParameter extends BaseValidate
{
    protected $rule = [
        'page' => 'isPositiveInteger',
        'size' => 'isPositiveInteger'
    ];

    protected $message = [
        'page' => '分页参数必须是正整数',
        'size' => '分页参数必须是正整数'
    ];
}