<?php
namespace app\model;

use think\Model;

class Commodity extends Model
{
	public function user()
    {
    	return $this->belongsTo(User::class,'aid');
    }
	public function userrented()
    {
    	return $this->hasMany(Userrented::class,'cid');
    }
	public static function add($comData){
		$comNew['aid'] = $comData['aid'];
		$comNew['title'] = $comData['title'];
		$comNew['type'] = $comData['type'];
		$comNew['price'] = $comData['price'];
		$comNew['content'] = $comData['content'];
		$comNew['cover'] = $comData['cover'];
		$com = Commodity::create($comNew);
		$id = $com->id;
		$com = Commodity::find($id);
		if($com)
			return json($com);
		else
			return json(['code'=>'error','msg'=>'添加失败']);
	}
	public static function search($searchData){
		$key = $searchData['searchValue'];
		$status = $searchData['status'];
		$location = $searchData['location'];
		$list = Commodity::hasWhere('user',['location'=>$location])->where('status',$status)->whereLike('title','%'.$key.'%')->with('user')->order('id','asc')->select();
		$list->visible(['user' => ['avatarurl','nickname']])->toArray();
		return json($list);
	}
	public static function searchinfo($searchData){
		$id = $searchData['id'];
		$info = Commodity::with(['user', 'userrented'=>function($query){$query->where('status = 0 or otherstatus = 0')->find();}])->find($id);
		$info->visible(['user' => ['avatarurl','nickname','location','phone']])->toArray();
		return json($info);
	}
	public static function searchclass($searchData){
		$type = $searchData['searchClass'];
		$status = $searchData['status'];
		$location = $searchData['location'];
		$list = Commodity::hasWhere('user',['location'=>$location])->where('status',$status)->where('type',$type)->with('user')->order('id','asc')->select();
		$list->visible(['user' => ['avatarurl','nickname']])->toArray();
		return json($list);
	}
	public static function searchusercom($searchData){
		$uid = $searchData['uid'];
		$list = Commodity::where('aid',$uid)->with('user')->order('status','desc')->select();
		$list->visible(['user' => ['avatarurl','nickname']])->toArray();
		return json($list);
	}
	public static function changeComStatus($searchData){
		$id = $searchData['id'];
		$com = Commodity::find($id);
		if($com){
			$status = $com->status;
			if($status==2)
				$com->sales = $com->sales+1;
			$com->status = !$status;
			$com->save();
		}
		return json($com);
	}
}