<?php
namespace Home\Controller;
use Think\Controller;
header("Content-type:text/html;charset=utf-8");
class ServicesController extends Controller {
    public function index(){
        $this -> display();
	}
	public function news(){
        $News = M('News');
		$count = $News ->count();
		$Page = new \Think\Page($count,8);
		$news = $News -> order('time desc') -> limit($Page->firstRow . ',' . $Page->listRows) -> select();
		$show = $Page-> show(); // 分页显示输出
		$this -> assign('page', $show); // 赋值分页输出
		$this -> assign('news',$news);		
        $this -> display();
	}
	public function article(){
		$data['id'] = I('get.id');
		$news = M('News')->where($data)->find();
		$this -> assign($news);
		$this->display();
	}
	
	
	
	public function area(){
        $this -> display();
	}
	public function train(){
        $this -> display();
	}
	public function product(){
        $this -> display();
	}
	public function data(){
        $this -> display();
	}
	public function study(){
        $this -> display();
	}
}