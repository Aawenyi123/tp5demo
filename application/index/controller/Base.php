<?php
namespace app\index\controller;
use think\Controller;
use think\Session;
// 公共基础类
class Base extends Controller
{
	// 初始化操作
	protected function _initialize()
	{
		parent::_initialize();// 继承父类初始化操作
		define('USER_ID',Session::get('user_id'));
	}
	// 检查是否登录
	protected function isLogin()
	{
		if(USER_ID == null) {
			$this->error('用户未登录，请登录', url('user/login'));
		}
	}
	// 检查是否重复登录
	protected function alreadyLogin()
	{
		if(USER_ID != null)
		{
			$this->error('用户已登录，请勿重复登录', url('index/index'));
		}
	}
}
