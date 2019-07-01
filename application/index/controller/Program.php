<?php
namespace app\index\controller;
use think\Session;
use think\Controller;
use app\index\controller\Base;
use think\Request;
use think\Db;
use think\Program as ProgramModel;
class Program extends Base {
	public function programList() {
		$this->isLogin();
		// 获取课程列表
		// 查询构造器
		$data = Db::table('program')
				->alias('p')
				->join('user u', 'p.creator_id=u.id', 'left')
				->field('p.*,u.name as creator_name')
				->where('p.is_deleted','eq','0')
				->group('p.id')
				->order('p.id desc')
				->select();
		// var_dump($data);
		// die;
		$this->assign('data',array(
			'totalNum' => count($data),
			'list' => $data
			));
		return $this->view->fetch();
	}
	// 添加页面
	public function programAdd() {
		$this->isLogin();
		return $this->view->fetch();
	}
	// 保存数据
	public function programSave(Request $request) {
		$data = $request->param();
		$rule = array(
			'name|课程名' => 'require',
			'detail|课程描述' => 'require',
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
				)
			);
		$res = $this->validate($data, $rule, $msg);
		if ($res === true) {
			// 验证通过 验证是否重名
			$list = Db::table('program')
					->where('name','eq',$data['name'])
					->where('is_deleted','eq','0')
					->select();
			if (empty($list)) {				
				// 未重名 新建
				$data['create_time'] = time();
				// insert
				$result = Db::table('program')->insert($data);
				if ($result) {
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
				return array(
					'status' => 1,
					'msg' => '课程名重复，请检查',
					'data' => $data
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
	// 删除
	public function programDelete() {
		if (!isset($_POST['id']) || intval($_POST['id']) <= 0) {
			return array(
				'status' => 1,
				'msg' => '非法操作，数据绑定异常'
				);
		}
		$id = intval($_POST['id']);
		// 假删除
		$res = Db::table('program')
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
	// 编辑页
	public function programEdit() {
		$this->isLogin();
		if (!isset($_GET['id']) || intval($_GET['id']) <= 0) {
			$this->assign('data', array(
				'empty' => 1,
				'msg' => '数据获取异常'
				));
		} else {
			$id = intval($_GET['id']);
			$info = Db::table('program')
					->where('id','eq',$id)
					->select();
			if (empty($info)) {
				$this->assign('data', array(
				    'empty' => 1,
				    'msg' => '数据获取异常'
				    ));
			} else {
				$this->assign('data', array(
				    'empty' => 0,
				    'msg' => '数据获取正常',
				    'info' => $info[0]
				    ));
			}
		}
		return $this->view->fetch();
	}
	// 保存更新
	public function programUpdate(Request $request) {
		$data = $request->param();
		$rule = array(
			'name|课程名' => 'require',
			'detail|课程描述' => 'require',
			'id|课程id' => 'require'
			);
		$msg = array(
			'name' => array(
				'require' => '课程名不能为空，请检查'
				),
			'detail' => array(
				'require' => '课程描述不能为空，请检查'
				),
			'id' => array(
				'require' => '课程id绑定异常，请检查'
				)
			);
		$res = $this->validate($data, $rule, $msg);
		if ($res === true) {
			// 验证是否重复
			$list = Db::table('program')
					->where('name','eq',$data['name'])
					->select();
			if (count($list) > 1 || (
				count($list) == 1 && $list[0]['id'] != $data['id']
				)) {
				// 出现重名
				return array(
				    'status' => 1,
				    'msg' => '课程名重复，请检查'
				    );
			} else if (count($list) == 1) {
				if ($list[0]['detail'] == $data['detail']) {
					// 未修改
					return array(
				        'status' => 0,
				        'msg' => '修改完成'
				        );
				} else {
					// 保存
					$id = intval($data['id']);
					$result = Db::table('program')
							->where('id','eq',$id)
							->update(array(
								'name' => $data['name'],
								'detail' => $data['detail'],
								'update_time' => time()
								));
					if ($result) {
						return array(
				    		'status' => 0,
				    		'msg' => '修改完成'
				    		);
					} else {
						return array(
				    		'status' => 1,
				    		'msg' => '修改失败'
				    		);
					}
				}
			} else {
				// 保存
				$id = intval($data['id']);
				$result = Db::table('program')
						->where('id','eq',$id)
						->update(array(
							'name' => $data['name'],
							'detail' => $data['detail'],
							'update_time' => time()
							));
				if ($result) {
					return array(
				   		'status' => 0,
				   		'msg' => '修改完成'
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
}