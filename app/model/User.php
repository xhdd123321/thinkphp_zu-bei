<?php
namespace app\model;

use think\Model;

class User extends Model
{
	public function commodity()
    {
    	return $this->hasMany(Commodity::class,'aid');
    }
	public function userrented()
    {
    	return $this->hasMany(Userrented::class,'aid');
    }
	public static function login($userData){
		//查询用户是否存在
		$userInfo = User::where('openid','=',$userData['openid'])->find();
		//不存在->注册
		if(!$userInfo){
			$userInfo['openid'] = $userData['openid'];
			$userInfo['session_key'] = $userData['session_key'];
			$userInfo['nickname'] = $userData['nickName'];
			$userInfo['avatarurl'] = $userData['avatarUrl'];
			$userInfo['gender'] = $userData['gender'];
			$user = User::create($userInfo);
			$userInfo['id'] = $user->id;
		}else{
			return json($userInfo);
		}
		if(empty($userInfo['id'])){
			return json(['code'=>'error','msg'=>'注册失败']);
		}else{
			return json($userInfo);
		}
	}
	public static function setphone($userData){
		$id = $userData['id'];
		$phone = $userData['phone'];
		$user = User::find($id);
		if($user){
			$user->phone = $phone;
			$user->save();
		}
		return json($user->phone);
	}
	public static function setgender($userData){
		$id = $userData['id'];
		$gender = $userData['gender'];
		$user = User::find($id);
		if($user){
			$user->gender = $gender;
			$user->save();
		}
		return json($user->gender);
	}
	public static function setlocation($userData){
		$id = $userData['id'];
		$location = $userData['location'];
		$user = User::find($id);
		if($user){
			$user->location = $location;
			$user->save();
		}
		return json($user->location);
	}
}