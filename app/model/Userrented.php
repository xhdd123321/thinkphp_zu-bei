<?php
namespace app\model;

use think\Model;

class Userrented extends Model
{
	public function user()
    {
    	return $this->belongsTo(User::class,'aid');
    }
	public function commodity()
    {
    	return $this->belongsTo(Commodity::class,'cid');
    }
	public static function add($rentData){
		$rentNew['aid'] = $rentData['aid'];
		$rentNew['cid'] = $rentData['cid'];
		$rentNew['time'] = $rentData['time'];
		$rentNew['allprice'] = $rentData['allprice'];
		$ifrent = Userrented::where('cid',$rentNew['cid'])->whereRaw('otherstatus=0 OR status=0')->find();
		if($ifrent){
			return json(['code'=>'error','msg'=>'物品已被购买']);
		}
		$rent = Userrented::create($rentNew);
		$id = $rent->id;
		$rent = Userrented::find($id);
		if($rent){
			$rent->commodity->save(['status' => 2]);
			return json($rent);
		}
		else
			return json(['code'=>'error','msg'=>'添加失败']);
	}
	public static function searchuserrented($searchData){
		$uid = $searchData['uidrent'];
		$list = Userrented::where('aid',$uid)->with('commodity')->order('id','desc')->select();
		return json($list);
	}
	public static function searchrentinfo($rentData){
		$cid = $rentData['cid'];
		$rent = Userrented::where('cid',$cid)->where('otherstatus',0)->find();
		if($rent){
			return json($rent);
		}
		else{
			return json(['code'=>'error','msg'=>'查看失败']);
		}
	}
	public static function checkrentseller($rentData){
		$id = $rentData['id'];
		$rent = Userrented::with(['user','commodity'])->find($id);
		$rent->visible(['user' => ['avatarurl','nickname','location','phone']])->toArray();
		if($rent){
			return json($rent);
		}
		else{
			return json(['code'=>'error','msg'=>'查看失败']);
		}
	}
	public static function checkrentbuyer($rentData){
		$id = $rentData['id'];
		$rent = Userrented::with([
			'commodity' => function ($q) {
				return $q->with([
					'user' => function ($q) {
						return $q->field('id,nickname,location,phone');
					}
				]);
			}
		])->find($id);
		if($rent){
			return json($rent);
		}
		else{
			return json(['code'=>'error','msg'=>'查看失败']);
		}
	}
	public static function changeRentOtherStatus($rentData){
		$id = $rentData['id'];
		$rent = Userrented::find($id);
		if($rent){
			$status = $rent->otherstatus;
			$rent->otherstatus = !$status;
			$rent->save();
			if($rent->otherstatus == 1&&$rent->status == 1){
				$now_time = date('Y-m-d H:i:s',time());
				$rent->end_time = $now_time;
				$rent->save();
			}
		}
		return json($rent);
	}
	public static function changeRentStatus($rentData){
		$id = $rentData['id'];
		$rent = Userrented::find($id);
		if($rent){
			$status = $rent->status;
			$rent->status = !$status;
			$rent->save();
			if($rent->otherstatus == 1&&$rent->status == 1){
				$now_time = date('Y-m-d H:i:s',time());
				$rent->end_time = $now_time;
				$rent->save();
			}
		}
		return json($rent);
	}
	public static function searchComAllRent($rentData){
		$cid = $rentData['cid'];
		$rent = Userrented::where('cid',$cid)->order('id','desc')->select();
		return json($rent);
	}
}