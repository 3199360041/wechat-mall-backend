<?php

namespace app\api\service;

use app\api\service\Order as OrderService;
use app\api\model\Order as OrderModel;
use app\common\lib\enum\OrderStatusEnum;
use app\common\lib\exception\OrderException;
use app\common\lib\exception\TokenException;
use think\Loader;
use think\Log;

Loader::import('WxPay.WxPay', EXTEND_PATH, '.Api.php');

class Pay
{
    private $orderID;
    private $orderNO;

    function __construct($orderID)
    {
        if (!$orderID)
        {
            throw new Exception('订单号不允许为NULL');
        }
        $this->orderID = $orderID;
    }

    public function pay()
    {
        //订单号不存在
        //订单号存在，但是订单号和当前用户id不一致
        //订单被支付过
        //库存量检测
        $this->checkOrderValid();
        $orderService = new OrderService();
        $status = $orderService->checkOrderStock($this->orderID);
        if(!$status['pass'])
        {
            return $status;
        }

        return $this->makeWxPreOrder($status['orderPrice']);
    }

    private function makeWxPreOrder($totalPrice)
    {
        $openid = Token::getCurrentTokenVar('openid');
        if(!$openid)
        {
            throw new TokenException();
        }

        $wxOrderData = new \WxPayUnifiedOrder();
        $wxOrderData->SetOut_trade_no($this->orderNO);
        $wxOrderData->SetTrade_type('JSAPI');
        $wxOrderData->SetTotal_fee($totalPrice * 100);
        $wxOrderData->SetBody('礼物小单');
        $wxOrderData->SetOpenid($openid);
        $wxOrderData->SetNotify_url(config('secure.pay_back_url'));

        return $this->getPaySignature($wxOrderData);
    }

    /**
     * @param $wxOrderData
     * @return array
     * @throws \WxPayException
     *
     * $wxOrder
     *       {
                ["appid"]=>
                string(18) "wxd7a5ff580dd837c5"
                ["mch_id"]=>
                string(10) "1528016531"
                ["nonce_str"]=>
                string(16) "Evg4bX3zGgSmfeO1"
                ["prepay_id"]=>
                string(36) "wx241708594291959a42bf81361423219500"
                ["result_code"]=>
                string(7) "SUCCESS"
                ["return_code"]=>
                string(7) "SUCCESS"
                ["return_msg"]=>
                string(2) "OK"
                ["sign"]=>
                string(64) "B3E09A74CC20290407CAB440FE3A0BB11863441572E559CD7FADD301E7BDA5B8"
                ["trade_type"]=>
                string(5) "JSAPI"
                }
     *
     */
    private function getPaySignature($wxOrderData)
    {
        $config = new \WxPayConfig();
        $wxOrder = \WxPayApi::unifiedOrder($config, $wxOrderData);
        if($wxOrder['return_code'] != 'SUCCESS' || $wxOrder['result_code'] != 'SUCCESS')
        {
            Log::record($wxOrder,'error');
            Log::record('获取预支付订单失败', 'error');
        }
        $this->recordPreOrder($wxOrder);
        $signature = $this->sign($config, $wxOrder);
        return $signature;
    }

    private function sign($config, $wxOrder)
    {
        $jsApiPayData = new \WxPayJsApiPay();
        $jsApiPayData->SetAppid(config('wx.app_id'));
        $jsApiPayData->SetTimeStamp((string)time());

        $rand = md5(time() . mt_rand(0, 1000));
        $jsApiPayData->SetNonceStr($rand);

        $jsApiPayData->SetPackage('prepay_id='.$wxOrder['prepay_id']);
        $jsApiPayData->SetSignType('md5');

        $sign = $jsApiPayData->MakeSign($config);


        $rawValues = $jsApiPayData->GetValues();
        $rawValues['paySign'] = $sign;

        unset($rawValues['appId']);

        return $rawValues;
    }

    private function recordPreOrder($wxOrder)
    {
        OrderModel::where('id', '=', $this->orderID)->update(['prepay_id' => $wxOrder['prepay_id']]);
    }

    private function checkOrderValid()
    {
        $order = OrderModel::where('id', '=', $this->orderID)->find();
        if(!$order)
        {
            throw new OrderException();
        }

        if(!Token::isValidOperate($order->user_id))
        {
            throw new TokenException([
                'msg' => '订单与用户不一致',
                'errorCode' => 10003
            ]);
        }
        if($order->status != OrderStatusEnum::UNPAID)
        {
            throw new OrderException([
                'msg' => '订单已经支付过了',
                'errorCode' => 80003,
                'code' => 400
            ]);
        }
        $this->orderNO = $order->order_no;
        return true;
    }
}