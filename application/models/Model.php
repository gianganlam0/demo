<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Model extends CI_Model{
	function getData(){
		$res = $this->db->get('user');
		return $res;
	}
	function findUserByName($name){
		$res = $this->db->where(array('name'=>$name))->get('user');
		return $res;
	}
}
