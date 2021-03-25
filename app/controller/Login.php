<?php
namespace app\controller;

use app\BaseController;
use think\facade\Request;
use think\facade\Db;
use app\model\User;

class Login extends BaseController
{
	public function login()
	{	/*
		$code = 'e20eb189245b769767af6c1573dcf528NW';//获取code
		//$code = $_REQUEST['code'];//获取code
		$appid ="Vdk2nZv7a9SA8nVfVX4qAynjUcbAuCft";
		$secret = "t1woUapbNPVyVNSwt7G2vwmvgAGBztEm";
		$url = "https://spapi.baidu.com/oauth/jscode2sessionkey?client_id=$appid&sk=$secret&code=$code";
		//通过code换取网页授权access_token
		$weixin =  file_get_contents($url);
		//$openid = $array['openid'];//输出openid
		return $weixin;
		*/
		$userData = Request::param();
		$code = $userData['code'];
		$clientId = 'Vdk2nZv7a9SA8nVfVX4qAynjUcbAuCft';
        $sk = 't1woUapbNPVyVNSwt7G2vwmvgAGBztEm';
		$url = "https://spapi.baidu.com/oauth/jscode2sessionkey?client_id={$clientId}&sk={$sk}&code={$code}";
		$ret = $this->curlPost($url);
		//$ret = '{"openid":"l214zFqNrEuIEnp6m7Y01sw8yj","session_key":"981ce8b151c0599acf7ad1a673c6ff5e"}'; //测试数据openid,sk
		$obj = json_decode($ret);
		$arr = get_object_vars($obj);
		$userData['openid'] = $arr['openid'];
		$userData['session_key'] = $arr['session_key'];
		return User::login($userData);
	}
	function curlPost($url)
	{
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($curl);
		curl_close($curl);
		return $output;
	}
}
