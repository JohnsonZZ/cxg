<?php
/**
*
* 函数：日志记录
* @param  string $log   日志内容。
* @param  string $account （可选）用户名。
*
**/
function addlog($log,$account=false){
	$Model = M('log');
	if(!$account){
		$data['user'] = session('account');
		
	}else{
		$data['user'] = $account;
	}
	$data['ip'] = $_SERVER["REMOTE_ADDR"];
	$data['log'] = $log;
	$Model->data($data)->add();
}
