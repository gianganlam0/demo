<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Model extends CI_Model{
	//constructor
	
	function __construct(){
		parent::__construct();
		$this->load->library('mongo_db',array('activate'=>'default'),'db');
	}
	//declare an attribute
	function getData(){
		$res = $this->db->get('user');
		return $res;
	}
	function findUserByName($name){
		$res = $this->db->where(array('name'=>$name))->get('user');
		return $res;
	}
}
