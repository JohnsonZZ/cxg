<?php
namespace  Cxg\Controller;
use  Cxg\Controller\ComController;
header("Content-type:text/html;charset=utf-8");
class NewsController extends ComController {
    public function index(){
		$News = M('News');
		$count = $News->count(); // 查询满足要求的总记录数
		$Page = new \Think\Page($count,8); // 实例化分页类 传入总记录数和每页显示的记录数(10)
		$list = $News->order('id desc')->limit($Page->firstRow . ',' . $Page->listRows)->select();
		$Page->setConfig('prev', '<');
		$Page->setConfig('next', '>');
		$Page->setConfig('header','');
		$show = $Page->show(); // 分页显示输出
		$this->assign('page', $show); // 赋值分页输出
		$this->assign('list',$list);
		$this->display();
    }
	public function add(){
		$this->display();
    }
	public function edit(){
		$data['id'] = I('get.id');
		$News = M('News');
		$list = $News->where($data)->find();
		$this->assign('list',$list);
		$this->display();
	}
	public function update(){
		$id = I('post.id');
		$data['title'] = I('post.title');
		$data['brief'] = $_POST['brief'];
		$data['content'] = $_POST['content'];
		$News = M('News');
		if($id){
			$result = $News->where('id ='.$id)->save($data);
			if($result){
				addlog('修改新闻');
				$this->success('修改成功', 'index');
			} else {
				$this->error('修改失败');
			}
		}else{
			$result = $News->add($data);
			if($result){
				addlog('新增新闻');
				$this->success('新增成功', 'add');
			} else {
				$this->error('新增失败');
			}
		}
	}
	public function del(){
		$lids = I('param.id');
		if(is_array($lids)){
			$lids = implode(',',$lids);
			$map['id']  = array('in',$lids);
		}else{
			$map['id'] = $lids;
		}
		$News = M('News');
		$result = $News->where($map)->delete();
		if($result){
			addlog('删除新闻');
			$this->success('删除成功');
		} else {
			$this->error('删除失败');
		}
	}
}