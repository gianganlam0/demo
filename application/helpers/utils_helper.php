<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (! function_exists('response')) {
	function response($res)
	{
		if (!isset($res['code'])) $res['code']=200;
		if (!isset($res['message'])) $res['message']='';
		if (!isset($res['data'])) $res['data']='';
		$CI = &get_instance();
		$CI->output->set_status_header($res['code']);
		return json_encode(['code'=>$res['code'],'message'=>$res['message'],'data'=>$res['data']]);
	}
}
