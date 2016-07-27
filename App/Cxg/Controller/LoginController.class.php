<?php
namespace Cxg\Controller;
use Think\Controller;
class LoginController extends Controller {
    public function index(){
		$this->display();
    }
	public function login(){
		$Admin = M('Admin');
		$account = I('post.account');
		$pwd = I('post.pwd');
		$remember = I('post.remember');
		$result = $Admin->where("account = '$account'")->find();
		if($result){
			if($result['pwd'] == sha1($pwd.$result['salt'])){
				if($remember){
					cookie('account',$account);
				}
				session('account',$account);
				session('href',$result['href']);
				addlog('登录成功');
				$this->redirect('Index/index');
			} else {
				$this->error('密码错误');
			}
		} else {
			$this->error('账号不存在');
		}
	}
	public function quit(){
		session(null);
		cookie(null);
		$this->redirect('index');
	}
}