<?php
namespace  Cxg\Controller;
use  Cxg\Controller\ComController;
header("Content-type:text/html;charset=utf-8");
class AreaController extends ComController {
    public function index(){
		$Area = M('Area');
		$list = $Area -> where('id = 1') -> find();
		$this->assign('list',$list);
		$this->display();
    }

	public function update(){
		$data['content'] = $_POST['content'];
		$Area = M('Area');
		$result = $Area->where('id = 1 ')->save($data);
		if($result){
			addlog('修改场地');
			$this->success('修改成功', 'index');
		} else {
			$this->error('修改失败');
		}
	}
}