<?php
namespace app\index\model;
use think\Model;
class User extends Model {
	// 获取启动状态
	public function getStatus($status)
	{
		$statusList = array(
			0 => '已启用',
			1 => '已停用'
			);
		return $statusList[$status];
	}
	// 获取角色级别
	public function getRole($role)
	{
		$roleList = array(
			1 => '管理员',
			2 => '超级管理员'
			);
		return $roleList[$role];
	}
}