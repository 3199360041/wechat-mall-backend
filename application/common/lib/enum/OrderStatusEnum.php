<?php
/**
 * Created by PhpStorm.
 * User: zouxiaojie
 * Date: 2019/6/17
 * Time: 2:03 PM
 */

namespace app\common\lib\enum;


class OrderStatusEnum
{
    // 待支付
    const UNPAID = 1;

    // 已支付
    const PAID = 2;

    // 已发货
    const DELIVERED = 3;

    // 已支付，但库存不足
    const PAID_BUT_OUT_OF = 4;

    // 已处理PAID_BUT_OUT_OF
    const HANDLED_OUT_OF = 5;
}