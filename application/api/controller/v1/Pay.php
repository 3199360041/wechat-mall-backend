<?php

namespace app\api\controller\v1;

use app\api\controller\BaseController;
use app\api\service\WxNotify;
use app\api\validate\IDMustBePositiveInt;
use app\api\service\Pay as PayService;
use think\Loader;

Loader::import('WxPay.WxPay', EXTEND_PATH, '.Api.php');

class Pay extends BaseController
{
    protected $beforeActionList = [
        //用户能访问，管理员不能访问
        'checkExclusiveScope' => ['only' => 'getPreOrder']
    ];

    public function getPreOrder($id = '')
    {
        (new IDMustBePositiveInt())->goCheck();
        $pay = new PayService($id);
        return $pay->pay();
    }

    //1。检测库存量
    //2。真实更新订单状态
    //3。减库存
    //4。 成功要处理成功信息，失败要返回没有成功信息
    //微信回调特点：  post | xml | 不会携带参数
    public function receiveNotify()
    {
        $config = new \WxPayConfig();
        $notify = new WxNotify();
        $notify->Handle($config, false);
    }

    public function redirectNotify()
    {
        return null;
    }
}