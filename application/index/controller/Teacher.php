<?php
namespace app\index\controller;
use think\Controller;
use app\index\controller\Base;
use think\Db;
use think\Request;
use app\index\model\Teacher as TeacherModel;
class Teacher extends Base
{
	// list
	public function teacherList() {
		$this->isLogin();
		$list = Db::table('teacher')
					->where('is_deleted','eq','0')
					->select();
		$t = new TeacherModel();
		// huoqu班级
		$list = $t->getTotalData($list);
		// 课程
		$list = $t->getTotalData2($list);
		$this->assign('data',array(
			'totalNum' => count($list),
			'list' => $list
			));
		return $this->view->fetch();
	}
	// add
	public function teacherAdd() {
		$this->isLogin();
		$grandList = Db::table('grand')
						->where('is_deleted','eq','0')
						->field('id,name')
						->select();
		$programList = Db::table('program')
						->where('is_deleted','eq','0')
						->field('id,name')
						->select();
		$this->assign('data',array(
			'grandList' => $grandList,
			'countGrand' 	=> count($grandList),
			'programList' => $programList,
			'countProgram' 	=> count($programList)
			));
		return $this->view->fetch();
	}
	// save
	public function teacherSave(Request $request) {
		$this->isLogin();
		$data = $request->param();
		$rule = array(
			'name|教师名' => 'require',
			'sex|性别' => 'require',
			'email|邮箱' => 'require|email',
			'tel|手机号' => 'require|number|max:11|min:11',
			'address|地址' => 'require',
			// 'detail|' => 'require'
			'grandIds|绑定班级' => 'require',
			'programIds|绑定课程' => 'require',
			'creator_id|创建人ID' => 'require'
			);
		$msg = array(
			'name' => array(
				'require' => '教师名不能为空,请检查'
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
			'programIds' => array(
				'require' => '未绑定课程，请检查'
				),
			'creator_id' => array(
				'require' => '创建人绑定异常，请检查'
				)
			);
		$res = $this->validate($data,$rule,$msg);
		if ($res === true) {
			// 防止重名
			$list = Db::table('teacher')
						->where('is_deleted','eq','0')
						->where('name','eq',$data['name'])
						->select();
			if (empty($list)) {
				// save
				$data['grand_ids'] = $data['grandIds'];
				unset($data['grandIds']);
				$data['program_ids'] = $data['programIds'];
				unset($data['programIds']);
				$data['create_time'] = time();
				$result = Db::table('teacher')
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
				    'msg' => '教师名重复，请检查'
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
	public function teacherEdit(Request $request) {
		$this->isLogin();
		$data = $request->param();
		if (!isset($data['id']) || intval($data['id']) <= 0) {
			return array(
				'status' => 1,
				'msg' => '非法访问'
				);
		}
		$id = intval($data['id']);
		$info = Db::table('teacher')
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
						->field('id,name')
						->select();
			$programList = Db::table('program')
						->where('is_deleted','eq','0')
						->field('id,name')
						->select();
			$this->assign('data', array(
				'empty' => 0,
				'grandList' => $grandList,
				'countGrand' => count($grandList),
				'programList' => $programList,
				'countProgram' => count($programList),
				'info' => $info[0],
				'grandIds' => explode(',', $info[0]['grand_ids']),
				'programIds' => explode(',', $info[0]['program_ids']),
				));
		}
		return $this->view->fetch();
	}
	// update
	public function teacherUpdate(Request $request) {
		$this->isLogin();
		$data = $request->param();
		// dump($data);
		// die;
		$rule = array(
			'name|教师名' => 'require',
			'sex|性别' => 'require',
			'email|邮箱' => 'require|email',
			'tel|手机号' => 'require|number|max:11|min:11',
			'address|地址' => 'require',
			// 'detail|' => 'require'
			'grandIds|绑定班级' => 'require',
			'programIds|绑定课程' => 'require',
			'id|教师ID' => 'require'
			);
		$msg = array(
			'name' => array(
				'require' => '教师名不能为空,请检查'
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
			'programIds' => array(
				'require' => '未绑定课程，请检查'
				),
			'id' => array(
				'require' => '教师ID绑定异常，请检查'
				)
			);
		$res = $this->validate($data,$rule,$msg);
		if ($res === true) {
			// 重名
			$list = TeacherModel::all(array(
				'name' => $data['name']
				));
			$id = intval($data['id']);
			if (count($list) > 1 || (count($list) == 1 && $list[0]->id != $id)) {
				return array(
					'status' => 1,
					'msg' => '教师名重复，请检查'
					);
			}
			$data['grand_ids'] = $data['grandIds'];
			unset($data['grandIds']);
			$data['program_ids'] = $data['programIds'];
			unset($data['programIds']);
			$list = TeacherModel::all($data);
			if (empty($list)) {
				$data['update_time'] = time();
				unset($data['id']);
				// var_dump($data);
				// die;
				$result = Db::table('teacher')
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
	public function teacherDelete(Request $request) {
		$this->isLogin();
		$data = $request->param();
		if (!isset($data['id']) || intval($data['id']) <= 0) {
			return array(
				'status' => 1,
				'msg' => '非法访问'
				);
		}
		$id = intval($data['id']);
		$res = Db::table('teacher')
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