<?php
namespace Cxg\Controller;
use Think\Controller;
class ComController extends Controller {
    public function _initialize(){
		if(null !== session('account')||null !== cookie('account')){
			
		}else{
			$this->redirect('Login/index');
		}
    }
}