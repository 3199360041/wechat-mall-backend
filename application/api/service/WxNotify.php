<?php

namespace app\api\service;

use app\api\model\Product;
use app\common\lib\enum\OrderStatusEnum;
use think\Loader;
use app\api\model\Order as OrderModel;
use app\api\service\Order as OrderService;
use think\Log;
use think\Db;

Loader::import('WxPay.WxPay', EXTEND_PATH, '.Api.php');

class WxNotify extends \WxPayNotify
{
    //重写回调处理函数
    /**
     * @param \WxPayNotifyResults $objData 回调解释出的参数
     * @param \WxPayConfigInterface $config
     * @param string $msg 如果回调处理失败，可以将错误信息输出到该方法
     * @return true 回调出来完成不需要继续回调，false回调处理未完成需要继续回调
     */
    public function NotifyProcess($objData, $config, &$msg)
    {
        $data = $objData->getValues();
        if ($data['result_code'] == 'SUCCESS')
        {
            $orderNO = $data['out_trade_no'];
            Db::startTrans();
            try{
                $order = OrderModel::where('order_no', '=', $orderNO)->lock(true)->find();
                if($order->status == 1)
                {
                    $service = new OrderService();
                    $stockStatus = $service->checkOrderStock($order->id);
                    if($stockStatus['pass'])
                    {
                        $this->updateOrderStatus($order->id, true);
                        $this->reduceStock($stockStatus);
                    }
                    else
                    {
                        $this->updateOrderStatus($order->id, false);
                    }
                }
                Db::commit();
            }
            catch (\Exception $ex)
            {
                Db::rollback();
                Log::error($ex);
                return false;
            }
        }

        return true;
    }

    private function reduceStock($stockStatus)
    {
        foreach($stockStatus['pStatusArray'] as $singlePStatus)
        {
            Product::where('id', '=', $singlePStatus['id'])->setDec('stock', $singlePStatus['count']);
        }
    }

    private function updateOrderStatus($orderID, $success)
    {
        $status = $success ? OrderStatusEnum::PAID : OrderStatusEnum::PAID_BUT_OUT_OF;
        OrderModel::where('id', '=', $orderID)->update(['status' => $status]);
    }

}