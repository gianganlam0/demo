<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FileModel extends CI_Model{

	public function get($_id){
		$this->load->library('Mongo_db','db');
		$_id = new MongoDB\BSON\ObjectId($_id);
		$file = $this->db->where(['_id'=>$_id])->get('file');
		if (count($file) == 0) return ['message' => 'File không tồn tại','code'=>404,'data'=>[]];
		$file = $file[0];
		$name = $file['name'];
		$path = base_url() . $file['path'];
		return ['message' => 'Tải file thành công','code'=>200,'data'=>['name'=>$name,'path'=>$path]];
	}
	// public function put(){}
	
}
