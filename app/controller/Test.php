<?php
namespace app\controller;

use app\BaseController;
use think\facade\Db;
use think\facade\Request;

class Test extends BaseController
{
	public function test()
	{
		$name = Request::param('name');
		return json_encode('success?');
		//$list = Db::table('test')->select();
		//echo json_encode($list);
	}
}
