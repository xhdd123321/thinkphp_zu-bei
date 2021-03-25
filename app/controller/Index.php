<?php
namespace app\controller;

use app\BaseController;
use think\facade\Request;
use app\model\User;
use app\model\Commodity;
use app\model\Userrented;

class Index extends BaseController
{
    public function index()
    {
        return '<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px;} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:) </h1><p> ThinkPHP V' . \think\facade\App::version() . '<br/><span style="font-size:30px;">14载初心不改 - 你值得信赖的PHP框架</span></p><span style="font-size:25px;">[ V6.0 版本由 <a href="https://www.yisu.com/" target="yisu">亿速云</a> 独家赞助发布 ]</span></div><script type="text/javascript" src="https://tajs.qq.com/stats?sId=64890268" charset="UTF-8"></script><script type="text/javascript" src="https://e.topthink.com/Public/static/client.js"></script><think id="ee9b1aa918103c4fc"></think>';
    }

    public function hello($name = 'ThinkPHP6')
    {
        return 'hello,' . $name;
    }

	public function test()
	{
		return 'success!';
	}
	
	public function setphone()
	{
		$userData = Request::param();
		return User::setphone($userData);
	}
	public function setgender()
	{
		$userData = Request::param();
		return User::setgender($userData);
	}
	public function setlocation()
	{
		$userData = Request::param();
		return User::setlocation($userData);
	}
	public function addcom()
	{
		$comData = Request::param();
		return Commodity::add($comData);
	}
	public function addrent()
	{
		$rentData = Request::param();
		return Userrented::add($rentData);
	}
	public function search()
	{
		$searchData = Request::param();
		if(Request::has('id','post'))
			return Commodity::searchinfo($searchData);
		if(Request::has('searchClass','post'))
			return Commodity::searchclass($searchData);
		if(Request::has('uid','post'))
			return Commodity::searchusercom($searchData);
		if(Request::has('uidrent','post'))
			return Userrented::searchuserrented($searchData);
		return Commodity::search($searchData);
	}
	public function uploadimg()
	{
		$file = request()->file('file');
		if ($file) {
			$savename = \think\facade\Filesystem::disk('public')->putFile('topic', $file);
			if ($savename) {
				$file = $savename;
				$file=str_replace("\\","/",$file);
				$res = ['errCode'=>0,'errMsg'=>'图片上传成功','file'=>$file];
				return json($res);
			}
		}
	}
	public function changeComStatus()
	{
		$searchData = Request::param();
		return Commodity::changeComStatus($searchData);
	}
	public function changeRentStatus()
	{
		$rentData = Request::param();
		return Userrented::changeRentStatus($rentData);
	}
	public function searchrentinfo()
	{
		$rentData = Request::param();
		return Userrented::searchrentinfo($rentData);
	}
	public function checkrentseller()
	{
		$rentData = Request::param();
		return Userrented::checkrentseller($rentData);
	}
	public function checkrentbuyer()
	{
		$rentData = Request::param();
		return Userrented::checkrentbuyer($rentData);
	}
	public function changeRentOtherStatus()
	{
		$rentData = Request::param();
		return Userrented::changeRentOtherStatus($rentData);
	}
	public function searchComAllRent()
	{
		$rentData = Request::param();
		return Userrented::searchComAllRent($rentData);
	}
}
