<?php
namespace app\index\model;
use think\Model;
use think\Db;
class Grand extends Model{
	// 加载绑定的课程信息
	public function getTotalData($list) {
		// var_dump($list);
		// die;
		$programList = Db::table('program')
						->where('is_deleted','eq','0')
						->field('id,name')
						->select();
		for ($i=0; $i < count($list); $i++) { 
			$programName = '';
			// var_dump($list[$i]);
			// die;
			$proList = explode(',', $list[$i]['program_ids']);
			foreach ($programList as $key => $value) {
				if (in_array($value['id'], $proList)) {
					$programName .= $value['name'].',';
				}
			}
			$list[$i]['programName'] = $programName;
		}
		unset($programList);
		return $list;
	}
	// 任教教师
	public function getTeacherNames($id) {
		// 判断字段field_A中是否包含23:
		// select * from table_test where FIND_IN_SET("23", field_A) ;
		// dump($teacherList);
		// die;
		$teacherList = Db::query('select id,name from teacher where find_in_set(?,grand_ids)',[$id]);
		$teacherList = array_column($teacherList, 'name'); // 获取name列 php>5.5
		$teacherNames = implode(',', $teacherList);
		unset($teacherList);
		return $teacherNames;
	}
	// 包含学生列表
	public function getStudentList($id) {
		$studentList = Db::query('select * from student where find_in_set(?,grand_ids)',[$id]);
		return $studentList;
	}
}