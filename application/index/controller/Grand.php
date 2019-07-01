<?php
namespace app\index\controller;
use app\index\controller\Base;
use think\Request;
use think\Db;
use app\index\model\Grand as GrandModel;
class Grand extends Base{
	// 列表页
	public function grandList() {
		$this->isLogin();
		// 获取课程列表
		// 查询构造器
		$data = Db::table('grand')
				->alias('g')
				->join('user u', 'g.creator_id=u.id', 'left')
				->field('g.*,u.name as creator_name')
				->where('g.is_deleted','eq','0')
				->group('g.id')
				->order('g.id desc')
				->select();
		$g = new GrandModel();
		$data = $g->getTotalData($data);
		// var_dump($data);
		// die;
		$this->assign('data',array(
			'totalNum' => count($data),
			'list' => $data
			));
		return $this->view->fetch();
	}
	// 添加班级
	public function grandAdd() {
		$this->isLogin();
		$programList = Db::table('program')
						->where('is_deleted','eq','0')
						->field('id,name')
						->select();
		$this->assign('data',array(
			'programList' => $programList,
			'count' => count($programList)
			));
		return $this->view->fetch();
	}
	// save
	public function grandSave(Request $request) {
		$this->isLogin();
		$data = $request->param();
		$rule = array(
			'name|班级名' => 'require',
			'detail|班级描述' => 'require',
			'programIds|课程绑定' => 'require',
			'creator_id' => 'require'
			);
		$msg = array(
			'name' => array(
				'require' => '课程名不能为空，请检查'
				),
			'detail' => array(
				'require' => '课程描述不能为空，请检查'
				),
			'creator_id' => array(
				'require' => '创建人绑定异常，请检查'
				),
			'programIds' => array(
				'require' => '未绑定课程，请检查'
				)
			);
		$res = $this->validate($data, $rule, $msg);
		if ($res === true) {
			$list = Db::table('grand')
						->where('name','eq',$data['name'])
						->where('is_deleted','eq',0)
						->select();
			if (empty($list)) {
				// save
				$data['program_ids'] = $data['programIds'];
				unset($data['programIds']);
				$data['create_time'] = time();
				$result = Db::table('grand')
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
				    'msg' => '班级名重复，请检查'
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
	public function grandDelete() {
		$this->isLogin();
		if (!isset($_POST['id']) && intval($_POST['id']) <= 0) {
			return array(
				'status' => 1,
				'msg' => '非法操作，数据绑定异常'
				);
		}
		$id = intval($_POST['id']);
		// 假删除
		$res = Db::table('grand')
					->where('id','eq',$id)
					->update(array(
						'is_deleted' => 1
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
	// update
	public function grandEdit() {
		$this->isLogin();
		if (!isset($_GET['id']) || intval($_GET['id']) <= 0) {
			$this->assign('data', array(
				'empty' => 1,
				'msg' => '数据获取异常'
				));
		} else {
			$id = intval($_GET['id']);
			$programList = Db::table('program')
						->where('is_deleted','eq','0')
						->field('id,name')
						->select();
			$info = Db::table('grand')
						->where('id','eq',$id)
						->where('is_deleted','eq','0')
						->select();
			if (empty($info)) {
				$this->assign('data',array(
			        'programList' => $programList,
			        'count' => count($programList),
			        'empty' => 1,
			        'msg' => '数据获取异常'
			        ));
			} else {
				// var_dump(explode(',', $info[0]['program_ids']));
				// die;
				$this->assign('data',array(
			        'programList' => $programList,
			        'count' => count($programList),
			        'info' => $info[0],
			        'proList' => explode(',', $info[0]['program_ids']),
			        'empty' => 0,
			        'msg' => '数据获取成功'
			        ));
			}
		}
		return $this->view->fetch();
	}
	// update
	public function grandUpdate(Request $request) {
		$this->isLogin();
		$data = $request->param();
		$rule = array(
			'name|班级名' => 'require',
			'detail|班级描述' => 'require',
			'programIds|课程绑定' => 'require',
			'grandId|班级id' => 'require'
			);
		$msg = array(
			'name' => array(
				'require' => '课程名不能为空，请检查'
				),
			'detail' => array(
				'require' => '课程描述不能为空，请检查'
				),
			'grandId' => array(
				'require' => '班级Id不能为空，请检查'
				),
			'programIds' => array(
				'require' => '未绑定课程，请检查'
				)
			);
		$res = $this->validate($data,$rule,$msg);
		$id = intval($data['grandId']);
		if ($res === true) {
			$list = Db::table('grand')
					->where('name','eq',$data['name'])
					->where('is_deleted','eq','0')
					->select();
			if (count($list) > 1 || (
				count($list) == 1 && $list[0]['id'] != $id)) {
				return array(
				    'status' => 1,
				    'msg' => '班级名重复，请检查'
				    );
			} else {
				$result = Db::table('grand')
							->where('id','eq',$id)
							->update(array(
								'name' => $data['name'],
								'detail' => $data['detail'],
								'program_ids' => $data['programIds'],
								'update_time' => time()
								));
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
			}
		} else {
			return array(
				'status' => 1,
				'msg' => $res
				);
		}
	}
	// show
	public function grandShow(Request $request) {
		$this->isLogin();
		$data = $request->param();
		if (!isset($data['id']) && intval($data['id']) <= 0) {
			return array(
				'status' => 1,
				'msg' => '非法操作，数据绑定异常'
				);
		}
		$id = intval($data['id']);
		$info = Db::table('grand')
					->alias('g')
					->join('user u','g.creator_id = u.id','left')
					->where('g.id','eq',$id)
					->where('g.is_deleted','eq','0')
					->field('g.*,u.name as creator_name')
					->select();
		// dump($info);
		// die;
		if (empty($info)) {
			$this->assign('data',array(
			    // 'info' => $info[0]
			    'empty' => 1,
			    'msg' => '获取数据异常'
			    ));
		} else {
			$g = new GrandModel();
			$info = $g->getTotalData($info);
			$teacherNames = $g->getTeacherNames($id);
			$studentList = $g->getStudentList($id);
			$this->assign('data',array(
			    'info' => $info[0],
			    'empty' => 0,
			    'teacherNames' => $teacherNames,
			    'studentList' => $studentList,
			    'countStudent' => count($studentList)
			    ));
		}
		return $this->view->fetch();
	}
}