<?php

require_once "WxPay.Config.Interface.php";

class WxPayConfig extends WxPayConfigInterface
{
	public function GetAppId()
	{
		return config('wx.app_id');
	}
	public function GetMerchantId()
	{
		return config('wx.merchant_id');
	}
    public function GetKey()
    {
        return config('wx.key');
    }
    public function GetAppSecret()
    {
        return config('wx.app_secret');
    }
	public function GetNotifyUrl()
	{
		return config("secure.pay_back_url");
	}
	public function GetSignType()
	{
		return "HMAC-SHA256";
	}
	public function GetProxy(&$proxyHost, &$proxyPort)
	{
		$proxyHost = "0.0.0.0";
		$proxyPort = 0;
	}
	public function GetReportLevenl()
	{
		return 1;
	}
	public function GetSSLCertPath(&$sslCertPath, &$sslKeyPath)
	{
		$sslCertPath = '../cert/apiclient_cert.pem';
		$sslKeyPath = '../cert/apiclient_key.pem';
	}
}
