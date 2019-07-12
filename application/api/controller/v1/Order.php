<?php

namespace app\api\controller\v1;

use app\api\controller\BaseController;
use app\api\validate\IDMustBePositiveInt;
use app\api\validate\OrderPlace;
use app\api\service\Token as TokenService;
use app\api\service\Order as OrderService;
use app\api\validate\PagingParameter;
use app\api\service\Token;
use app\api\model\Order as OrderModel;
use app\common\lib\exception\OrderException;

    //用户在选择商品后，向api提交包含它所选商品的相关信息
    //api在接收到信息后，需要检查订单相关商品的库存量
    //有库存，把订单数据存入数据库中，下单成功了，返回客户端消息，告诉客户端可以支付了
    //调用我们的支付接口，进行支付
    //需要再次进行库存量检测
    //服务器这边就可以调用微信的支付接口进行支付
    //微信会返回给我们一个支付的结果（异步）
    //成功：也需要进行库存量的检测
    //成功：进行库存量的扣除，失败：返回一个支付失败的结果

class Order extends BaseController
{
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'placeOrder'],
        'checkPrimaryScope' => ['only' => 'getDetail, getSummaryByUser']
    ];

    public function placeOrder()
    {
        (new OrderPlace())->goCheck();
        $products = input('post.products/a');
        $uid = TokenService::getCurrentUid();
        $order = new OrderService();
        $status = $order->place($uid, $products);
        return $status;
    }

    public function getSummaryByUser($page = 1, $size = 15)
    {
        (new PagingParameter())->goCheck();
        $uid = Token::getCurrentUid();
        $pagingOrders = OrderModel::getSummaryByUser($uid, $page, $size);
        if($pagingOrders->isEmpty())
        {
            return [
                'data' => [],
                'current_page' => $pagingOrders->currentPage()
             ];
        }
        $data = $pagingOrders->hidden(['snap_items', 'snap_address', 'prepay_id'])->toArray();
        return [
            'data' => $data,
            'current_page' => $pagingOrders->currentPage()
        ];
    }

    public function getDetail($id)
    {
        (new IDMustBePositiveInt())->goCheck();
        $orderDatail = OrderModel::get($id);
        if(!$orderDatail)
        {
            throw new OrderException();
        }

        return $orderDatail->hidden(['prepay_id']);
    }
}