<?php
namespace app\index\controller;
use app\index\controller\Base;
use think\Request;
use think\Controller;
use think\Session;
use think\Db;
use app\index\model\User as UserModel;
/**
*  user 类
*/
class User extends Base
{
	// denglu
	public function login() {
		$this->alreadyLogin();
		return $this->view->fetch();
	}
	// checklogin
	public function checkLogin(Request $request){
		// $res = UserModel::get(array());
		// $res = json_decode($res, true);
		// var_dump($res);
		// die;
		// 验证码
		// $this->Validate($data, $rule, $msg);
		// $status = 0;
		$message = '';
		$data = $request->param();
		$rule = array(
				'name|用户名' => 'require',
				'password|密码' => 'require',
				'verify|验证码' => 'require|captcha'
			);
		$msg = array(
				'name' => array('require' => '用户名不能为空，请检查输入'),
				'password' => array('require' => '密码不能为空，请检查输入'),
				'verify' => array(
					'require' => '验证码不能为空，请检查输入',
					'captcha' => '验证码错误，请检查'
					)
				// 'verify|captcha' => '验证码错误，请检查' 
			);
		$message = $this->validate($data, $rule, $msg);
		// var_dump($message);
		// die;
		if ($message === true){
			$map = array(
					'name' => $data['name'],
					'password' => md5($data['password']),
					'status' => 0 // 0启用 1 用户停止使用
				);
			$res = UserModel::get($map);// 返回对象
			// $res = json_decode($res, true);
			// get 返回的数组 只有一条数据 all 获取全部数据
			// var_dump($res);
			// die;
			// if (empty($res)) {
			if ($res == null) {
				return array(
		    		'status' => 1,
		    		'msg' => '用户名或密码错误或不存在该用户',
		    		'data' => $data
		    	);
			} else {
				Session::set('user_id', $res->id);
				Session::set('user_info', $res->getData());
				// 更新登录次数
				$loginCount = intval($res->login_count) + 1;
				Session::set('user_info.login_count', $loginCount);
				$res = Db::execute('update user set login_count=? where id=?', [$loginCount, $res->id]);
				// // 存session
				// $res->login_count = $loginCount;
				return array(
		    		'status' => 0,
		    		'msg' => '登录成功',
		    		'data' => $data
		    	);
			}
		} else {
			return array(
		    		'status' => 1,
		    		'msg' => $message,
		    		'data' => $data
		    	);
		}
	}
	// logout
	public function logout()
	{
		Session::delete('user_info');
		Session::delete('user_id');
		// return $this->view->fetch('login');
		$this->success('退出登录成功', url('user/login'));
	}
	// list页面
	public function userList()
	{
		$this->isLogin();
		$role = Session::get('user_info.role');
		if ($role == 2) // 2 超级管理员
		{
			$data = UserModel::all();
			// var_dump('00');
			// for () {

			// }
		} else {
			// var_dump(Session::get('user_id'));
			// die;
			$name = Session::get('user_info.name');
			$data = UserModel::all(array(
				'id' => Session::get('user_id')
				));
			// $data->roleName = UserModel::getRole($data->role);
		}
		// var_dump(json_decode($data[0],true));
		// die;
		$m = new UserModel();
		for ($i = 0; $i < count($data);$i++) {
			$data[$i]->roleName = $m->getRole($data[$i]->role);
			$data[$i]->statusName = $m->getStatus($data[$i]->status);
		}
		$array = array(
			'list' => $data,
			'totalNum' => count($data)
			);
		$this->assign('data', $array);
		// $this->assign('list', $data);
		// $this->assign('userList', $data);
		// $this->assign('zhang', 'zhanhgsan');
		return $this->view->fetch();
	}
	// 添加用户
	public function userAdd() {
		$this->isLogin();
		return $this->view->fetch();
	}
	// save用户
	public function userSave(Request $request) {
		$this->isLogin();
		$data = $request->param();
		// var_dump($data);
		// die;
		$rule = array(
			'name|管理员名' => 'require',
			'password|初始密码' => 'require',
			'password2|重复密码' => 'require|confirm:password',
			'email|邮箱' => 'require|email',
			'role|角色' => 'require',
			'status|是否启用' => 'require'
			);
		$msg = array(
			'name' => array(
				'require' => '管理员名不能为空,请检查'
				),
			'password' => array(
				'require' => '初始密码不能为空,请检查'
				),
			'password2' => array(
				'require' => '重复密码不能为空,请检查',
				'confirm' => '两次输入的密码不一致'
				),
			'email' => array(
				'require' => '邮箱不能为空，请检查',
				'email' => '邮箱格式错误'
				),
			'role' => array(
				'require' => '角色选择有误,请检查'
				),
			'status' => array(
				'require' => '启用状态选择有误，请检查'
				)
			);
		$val = $this->validate($data, $rule, $msg);
		if ($val === true)
		{
			$map = array(
				'name' => $data['name']
				);
			$res = UserModel::get($map);
			if (empty($res)) {
				// 无重名的元素 save
				$res = Db::execute('insert into user (name, password, email, role, status, create_time) values (?,?,?,?,?,?)', [
						 	$data['name'],
						 	md5($data['password']),
						 	$data['email'],
						 	$data['role'],
						 	$data['status'],
						 	time()
						 ]);
				// die;
				// $raw = array(
				// 	''
				// 	);
				if ($res > 0) {
					return array(
				        'status' => 0,
				        'msg' => '添加成功',
				        'data' => $data
				        );
				} else {
					return array(
				        'status' => 1,
				        'msg' => '添加失败',
				        'data' => $data
				        );
				}
			} else {
				// 又重名元素
				return array(
				    'status' => 1,
				    'msg' => '管理员名重复，请检查',
				    'data' => $data
				    );
			}
		} else {
			return array(
				'status' => 1,
				'msg' => $val,
				'data' => $data
				);
		}
	}
	// 管理员详情页
	public function userShow() {
		$this->isLogin();
		// $id = intval($_GET['id']);
		// var_dump($_GET);
		// die;
		$data = UserModel::all(array(
			'id' => intval($_GET['id'])
			));
		if (empty($data)) {
			$this->assign('data', array(
				'empty' => 1
				));
		} else {
			$m = new UserModel();
			$data[0]->roleName = $m->getRole($data[0]->role);
			$data[0]->statusName = $m->getStatus($data[0]->status);
			$this->assign('data', array(
				'empty' => 0,
				'info' => $data[0]
				));
		}
		return $this->view->fetch();
	}
	// 启用 or 停止
	public function userStopOpen() {
		$this->isLogin();
		// $data = $request->param();
		// var_dump($data['type']);
		// die;
		$type = intval($_POST['type']);
		// die;
		if ($type == 1) {
			// 启动
			$status = 0;
		} else {
			// 关闭
			$status = 1;
		}
		// echo $status;
		// die;
		$id = intval($_POST['id']);
		$res = Db::execute('update user set status=? where id=?',[$status, $id]);
		if ($res) {
			return array(
				'status' => 0,
				'msg' => '操作成功'
				);
		} else {
			return array(
				'status' => 1,
				'msg' => '操作失败'
				);
		}
	}
	// 修改密码
	public function changePassword() {
		$this->isLogin();
		$id = intval($_GET['id']);
		$data = UserModel::all(array(
			'id' => $id
			));
		if (empty($data)) {
			$this->assign('data', array(
				'empty' => 1,
				'msg' => '数据获取异常'
				));
		} else {
			$this->assign('data', array(
				'empty' => 0,
				'info' => $data[0]
				));
		}
		return $this->view->fetch();
	}
	// 保存password
	public function passwordSave(Request $request) {
		$this->isLogin();
		$data = $request->param();
		if (!isset($data['password']) || $data['password'] == '') {
			return array(
				'status' => 1,
				'msg' => 'password输入异常,请检查'
				);
		}
		// die;
		$id = intval($data['userId']);
		// var_dump($id);
		// die;
		$info = UserModel::all(array(
			'id' => $id
			));
		// die;
		// var_dump($info);
		// die;
		if (empty($info)) {
			return array(
				'status' => 1,
				'msg' => '提交异常,数据获取异常'
				);
		} else {
			// die;
			if (md5($data['password']) == $info[0]->password || $data['password'] == $info[0]->password) {
				return array(
				'status' => 0,
				'msg' => '修改成功'
				);
			} else {
				$res = Db::execute('update user set password =? where id=?',[md5($data['password']),$id]);
				if ($res) {
					return array(
				    'status' => 0,
				    'msg' => '修改成功'
				    );
				} else {
					return array(
				    'status' => 1,
				    'msg' => '修改失败'
				    );
				}
			}
		}
	}
	// 删除数据
	public function userDelete() {
		$this->isLogin();
		if (!isset($_POST['id']) || intval($_POST['id']) <= 0) {
			return array(
				'status' => 1,
				'msg' => '非法访问'
				);
		}
		$id = intval($_POST['id']);
		$res = UserModel::all(array(
			'id' => $id
			));
		if (count($res) > 0) {
			$res = Db::execute('delete from user where id=?',[$id]);
			if ($res) {
				return array(
				'status' => 0,
				'msg' => '删除成功'
				);
			} else {
				return array(
				'status' => 1,
				'msg' => '删除失败'
				);
			}
		} else {
			return array(
				'status' => 1,
				'msg' => '要删除的数据不存在'
				);
		}
	}
	// 编辑页面
	public function userEdit() {
		$this->isLogin();
		if (!isset($_GET['id']) || intval($_GET['id']) <= 0) {
			return array(
				'status' => 1,
				'msg' => '非法访问'
				);
		}
		$id = intval($_GET['id']);
		$res = UserModel::all(array(
			'id' => $id
			));
		if (empty($res)) {
			$this->assign('data', array(
				'empty' => 1,
				'msg' => '获取数据异常'
				));
		} else {
			$this->assign('data', array(
				'empty' => 0,
				'info' => $res[0]
				));
		}
		return $this->view->fetch();
	}
	// 更新数据
	public function userUpdate(Request $request) {
		$this->isLogin();
		$data = $request->param();
		$rule = array(
			'userId|用户ID' => 'require',
			'name|管理员名' => 'require',
			'password|初始密码' => 'require',
			'email|邮箱' => 'require|email',
			'role|角色' => 'require',
			'status|是否启用' => 'require'
			);
		$msg = array(
			'userId' => array(
				'require' => '用户ID不能为空，请检查,'
				),
			'name' => array(
				'require' => '管理员名不能为空,请检查'
				),
			'password' => array(
				'require' => '初始密码不能为空,请检查'
				),
			'email' => array(
				'require' => '邮箱不能为空，请检查',
				'email' => '邮箱格式错误'
				),
			'role' => array(
				'require' => '角色选择有误,请检查'
				),
			'status' => array(
				'require' => '启用状态选择有误，请检查'
				)
			);
		$res = $this->validate($data, $rule, $msg);
		if ($res === true) {
			// 先判断是否修改过
			$dataOld = $data;
			$id = intval($data['userId']);
			// 判断是否重名
			$userList = UserModel::all(array(
				'name' => $data['name']
				));
			if (count($userList) > 1 || (count($userList) == 1 && $userList[0]->id != $id)) {
				return array(
				    'status' => 1,
				    'msg' => '管理员名重复，请检查',
				    'data' => $data
				    );
			}
			unset($data['userId']);
			$data['id'] = $id;
			$info = UserModel::all($data);
			$data['password'] = md5($data['password']);
			$info2 = UserModel::all($data);
			if (empty($info) && empty($info2)) {
				$info = UserModel::all(array(
					'id' => $id
					));
				if ($info[0]->password == $dataOld['password']) {
					$data['password'] = $dataOld['password'];
				}
				// 有修改保存
				$result = Db::execute('update user set name=?,password=?,email=?,role=?,status=? where id=?',
					[
						$data['name'],
						$data['password'],
						$data['email'],
						intval($data['role']),
						intval($data['status']),
						$id
					]);
				if ($result) {
					return array(
				        'status' => 0,
				        'msg' => '修改成功',
				        'data' => $dataOld
				        );
				} else {
					return array(
				        'status' => 1,
				        'msg' => '修改失败',
				        'data' => $dataOld
				        );
				}
			} else {
				// 无修改直接返回
				return array(
				    'status' => 0,
				    'msg' => '修改成功',
				    'data' => $dataOld
				    );
			}
		} else {
			return array(
				'status' => 1,
				'msg' => $res,
				'data' => $data
				);
		}
	}
}