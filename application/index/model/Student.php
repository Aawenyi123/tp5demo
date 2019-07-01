<?php
namespace app\index\model;
use think\Model;
use think\Db;
class Student extends Model
{
	// 获取班级信息
	public function getTotalData($list) {
		$grandList = Db::table('grand')
						->field('id,name')
						->where('is_deleted','eq','0')
						->select();
		// dump($grandList);
		for ($i=0; $i < count($list); $i++) { 
			$grandIds = explode(',', $list[$i]['grand_ids']);
			$grandNames = array();
			foreach ($grandList as $key => $value) {
				if (in_array($value['id'], $grandIds)) {
					$grandNames[] = $value['name'];
				}
			}
			$list[$i]['grandNames'] = implode(',', $grandNames);
		}
		unset($grandList);
		// dump($list);
		// die;
		return $list;
	}
}