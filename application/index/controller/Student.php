<?php
namespace app\index\Controller;
use think\Db;
use think\Controller;
use app\index\controller\Base;
use app\index\model\Student as StudentModel;
use think\Request;
class Student extends Base
{
	// list
	public function studentList() {
		$this->isLogin();
		$list = Db::table('student')
					->where('is_deleted','eq','0')
					->group('id')
					->order('id desc')
					->select();
		$s = new StudentModel();
		$list = $s->getTotalData($list);
		$this->assign('data',array(
			'list' => $list,
			'totalNum' => count($list)
			));
		return $this->view->fetch();
	}
	// add
	public function studentAdd() {
		$this->isLogin();
		$grandList = Db::table('grand')
						->where('is_deleted','eq','0')
						->select();
		$this->assign('data',array(
			'grandList' => $grandList,
			'count' 	=> count($grandList)
			));
		return $this->view->fetch();
	}
	// save
	public function studentSave(Request $request) {
		$this->isLogin();
		$data = $request->param();
		$rule = array(
			'name|学生名' => 'require',
			'sex|性别' => 'require',
			'email|邮箱' => 'require|email',
			'tel|手机号' => 'require|number|max:11|min:11',
			'address|地址' => 'require',
			// 'detail|' => 'require'
			'grandIds|绑定班级' => 'require',
			'creator_id|创建人ID' => 'require'
			);
		$msg = array(
			'name' => array(
				'require' => '学生名不能为空,请检查'
				),
			'sex' => array(
				'require' => '性别不能为空，请检查'
				),
			'email' => array(
				'require' => '邮箱不能为空，请检查',
				'email' => '邮箱格式不对，请检查'
				),
			'tel' => array(
				'require' => '手机号不能为空，请检查',
				'number' => '手机号格式错误，请检查',
				'max' => '手机号长度应为11位，请检查',
				'min' => '手机号长度应为11位，请检查'
				),
			'address' => array(
				'require' => '地址不能为空，请检查'
				),
			'grandIds' => array(
				'require' => '未绑定班级，请检查'
				),
			'creator_id' => array(
				'require' => '创建人绑定异常，请检查'
				)
			);
		$res = $this->validate($data,$rule,$msg);
		if ($res === true) {
			// 防止重名
			$list = Db::table('student')
						->where('is_deleted','eq','0')
						->where('name','eq',$data['name'])
						->select();
			if (empty($list)) {
				// save
				$data['grand_ids'] = $data['grandIds'];
				unset($data['grandIds']);
				$data['create_time'] = time();
				$result = Db::table('student')
								->insert($data);
				if ($result) {
					return array(
				        'status' => 0,
				        'msg' => '添加成功'
				        );
				} else {
					return array(
				        'status' => 1,
				        'msg' => '添加失败'
				        );
				}
			} else {
				return array(
				    'status' => 1,
				    'msg' => '学生名重复，请检查'
				    );
			}
		} else {
			return array(
				'status' => 1,
				'msg' => $res
				);
		}
	}
	// edit
	public function studentEdit(Request $request) {
		$this->isLogin();
		$data = $request->param();
		if (!isset($data['id']) || intval($data['id']) <= 0) {
			return array(
				'status' => 1,
				'msg' => '非法访问'
				);
		}
		$id = intval($data['id']);
		$info = Db::table('student')
						->where('is_deleted','eq','0')
						->where('id','eq',$id)
						->select();
		if (empty($info)) {
			$this->assign('data', array(
				'empty' => 1,
				'msg' => '获取数据异常'
				));
		} else {
			$grandList = Db::table('grand')
						->where('is_deleted','eq','0')
						->select();
			$this->assign('data', array(
				'empty' => 0,
				'grandList' => $grandList,
				'count' => count($grandList),
				'info' => $info[0],
				'grandIds' => explode(',', $info[0]['grand_ids'])
				));
		}
		return $this->view->fetch();
	}
	// update
	public function studentUpdate(Request $request) {
		$this->isLogin();
		$data = $request->param();
		// dump($data);
		// die;
		$rule = array(
			'name|学生名' => 'require',
			'sex|性别' => 'require',
			'email|邮箱' => 'require|email',
			'tel|手机号' => 'require|number|max:11|min:11',
			'address|地址' => 'require',
			// 'detail|' => 'require'
			'grandIds|绑定班级' => 'require',
			'id|学生ID' => 'require'
			);
		$msg = array(
			'name' => array(
				'require' => '学生名不能为空,请检查'
				),
			'sex' => array(
				'require' => '性别不能为空，请检查'
				),
			'email' => array(
				'require' => '邮箱不能为空，请检查',
				'email' => '邮箱格式不对，请检查'
				),
			'tel' => array(
				'require' => '手机号不能为空，请检查',
				'number' => '手机号格式错误，请检查',
				'max' => '手机号长度应为11位，请检查',
				'min' => '手机号长度应为11位，请检查'
				),
			'address' => array(
				'require' => '地址不能为空，请检查'
				),
			'grandIds' => array(
				'require' => '未绑定班级，请检查'
				),
			'id' => array(
				'require' => '学生ID绑定异常，请检查'
				)
			);
		$res = $this->validate($data,$rule,$msg);
		if ($res === true) {
			// 重名
			$list = StudentModel::all(array(
				'name' => $data['name']
				));
			$id = intval($data['id']);
			if (count($list) > 1 || (count($list) == 1 && $list[0]->id != $id)) {
				return array(
					'status' => 1,
					'msg' => '学生名重复，请检查'
					);
			}
			$data['grand_ids'] = $data['grandIds'];
			unset($data['grandIds']);
			$list = StudentModel::all($data);
			if (empty($list)) {
				$data['update_time'] = time();
				unset($data['id']);
				// var_dump($data);
				// die;
				$result = Db::table('student')
							->where('id','eq',$id)
							->update($data);
				if ($result) {
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
			} else {
				// 未修gai
				return array(
					'status' => 0,
					'msg' => '修改成功'
					);
			}
		} else {
			return array(
				'status' => 1,
				'msg' => $res
				);
		}
	}
	// delete
	public function studentDelete(Request $request) {
		$this->isLogin();
		$data = $request->param();
		if (!isset($data['id']) || intval($data['id']) <= 0) {
			return array(
				'status' => 1,
				'msg' => '非法访问'
				);
		}
		$id = intval($data['id']);
		$res = Db::table('student')
					->where('id','eq',$id)
					->update(array(
							'is_deleted' => 1,
							'update_time' => time()
						));
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
	}
}