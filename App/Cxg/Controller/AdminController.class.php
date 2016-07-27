<?php
namespace Cxg\Controller;
use Cxg\Controller\ComController;
header("Content-type:text/html;charset=utf-8");
class AdminController extends ComController {
    public function index(){
		$Admin = M('Admin');
		$keyword = I('get.keyword');
		if(empty($keyword)){
			$count = $Admin->count(); // 查询满足要求的总记录数
			$Page = new \Think\Page($count,8); // 实例化分页类 传入总记录数和每页显示的记录数(10)
			$list = $Admin->order('id asc')->limit($Page->firstRow . ',' . $Page->listRows)->select();
			$Page->setConfig('prev', '<');
			$Page->setConfig('next', '>');
			$Page->setConfig('header','');
			$show = $Page->show(); // 分页显示输出
			$this->assign('page', $show); // 赋值分页输出
			$this->assign('list',$list);
		}else{
			$data['account'] = "$keyword";
			$list = $Admin->where($data)->select();
			$this->assign('list',$list);
		}
		$this->display();
    }
	public function add(){
		$this->display();
    }
	public function edit(){
		$data['id'] = I('get.id');
		$Admin = M('Admin');
		$list = $Admin->where($data)->find();
		$this->assign('list',$list);
		$this->display();
	}
	public function update(){
		$id = I('post.id');
		$data['account'] = I('post.account');
		$data['pwd'] = I('post.pwd');
		$data['salt'] = base64_encode(mcrypt_create_iv(32,MCRYPT_DEV_RANDOM));
		$data['pwd'] = sha1($data['pwd'].$data['salt']);
		if(!empty($_FILES)){
			$upload = new \Think\Upload();// 实例化上传类
			$upload->subName   =     array('date', 'Ymd');
			$upload->maxSize   =     1048576 ;// 设置附件上传大小
			$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			$upload->rootPath  =     'Public/upload/image/'; // 设置附件上传根目录
			$upload->replace   =	 true;
			$upload->savePath  =     ''; // 设置附件上传（子）目录
			// 上传文件 
			$info   =   $upload->upload();
			if($info) {
				$data['href'] = $info['photo']['savepath'] . $info['photo']['savename'];
			}else{
				if(empty($id)){
					$data['href'] = 'avatar/avatar.jpg';
					$flag = 1;
				}
			}
		}
		$Admin = M('Admin');
		if($id){
			$path = $Admin->where('id ='.$id)->field('href')->find();	//更头像
			$file = 'Public/upload/image/'.$path['href']; //储存之前的头像路径
			$result = $Admin->where('id ='.$id)->save($data);
			if($result){
				if(isset($data['href']) && $path['href'] !== 'avatar/avatar.jpg'){
					unlink($file);//成功后删除之前的头像
				}
				$this->success('修改成功', 'index');
			} else {
				$this->error('修改失败');
			}
		}else{
			$result = $Admin->add($data);
			if($result){
				$this->success('新增成功', 'add');
			} else {
				$this->error('新增失败');
			}
		}
	}
	public function del(){
		$data['id'] = I('get.id');
		$Admin = M('Admin');
		$result = $Admin->where($data)->delete();
		if($result){
			$this->success('删除成功');
		} else {
			$this->error('删除失败');
		}
	}
}