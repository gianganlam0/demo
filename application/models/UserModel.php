<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserModel extends CI_Model{
	public function __construct(){
		parent::__construct();
		$this->load->library('Mongo_db','db');
	}
	public function getAdmin($data=[]){
		if ($data == []){
			return $this->db->get('admin');
		}
		return $this->db->where($data)->get('admin');
	}
	public function getUser($data=[]){
		if ($data == []){
			return $this->db->get('user');
		}
		return $this->db->where($data)->get('user');
	}
	public function getUserLimitOffset($limit,$offset=0,$data=[]){
		if ($data == []){
			return $this->db->limit($limit)->offset($offset)->get('user');
		}
		return $this->db->where($data)->limit($limit)->offset($offset)->get('user');
	}
	public function getTotalUser($data=[]){
		if ($data == []){
			return $this->db->count('user');
		}
		return $this->db->where($data)->count('user');
	}
	public function insertUser($data){
		return $this->db->insert('user',$data);
	}
	public function updateUser($data, $by){
		return $this->db->where($by)->set($data)->update('user');
	}
	public function upsertUser($data, $by=[]){
		//upsert user by key in $by
		if ($by == []) return $this->db->insert('user',$data);
		return $this->db->where($by)->set($data)->update('user');
	}
	public function activeUser($data){
		//$data is email,activeCode
		$this->load->library('Mongo_db','db');
		$this->load->helper('date');
		$users = $this->getUser($data);
		// var_dump($data);
		if (count($users) == 0) {
			return ['message' => 'Link không hợp lệ hoặc đã hết hạn','code'=>404];
		}
		else{
			$sentMailTime = now('Asia/Ho_Chi_Minh');
			// $sentMailTime = date('H:i:s', $sentMailTime);
			$this->db->where($data)->set(['activeCode'=>null,'sentMailTime'=>$sentMailTime])->update('user');
			return ['message' => 'Kích hoạt tài khoản thành công, link tài liệu đã được gửi qua email','code'=>200];
		}
	}
	public function valiRegister($req){
		if (!(isset($req['email'])&&isset($req['fullname'])&&isset($req['email'])&&isset($req['fullname'])&&
		isset($req['email'])&&isset($req['fullname'])&&isset($req['email']))){
			return ['message' => 'Thiếu thông tin','code'=>400];
		}
		$email = $req['email'];
		$fullname = $req['fullname'];
		$sex = $req['sex'];
		$age = $req['age'];
		$job = $req['job'];
		$x = $req['latitude'];
		$y = $req['longitude'];

		$regex = '/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/';
		if(!preg_match($regex, $email)){
			return ['message' => 'Email không hợp lệ', 'code' => 422];
		}
		if($fullname == ''){
			return ['message' => 'Họ tên không được để trống', 'code' => 422];
		}
		if(!in_array($sex,['0','1','2'])){
			return ['message' => 'Giới tính không hợp lệ', 'code' => 422];
		}
		if($age == '' || !is_numeric($age) || $age < 0 || $age > 150){
			return ['message' => 'Tuổi không hợp lệ', 'code' => 422];
		}
		if($job == ''){
			return ['message' => 'Nghề nghiệp không được để trống', 'code' => 422];
		}
		if($x != '' && !is_numeric($x)){
			return ['message' => 'Tọa độ X không hợp lệ', 'code' => 422];
		}
		if($y != '' && !is_numeric($y)){
			return ['message' => 'Tọa độ Y không hợp lệ', 'code' => 422];
		}
		return ['message' => '', 'code' => 200];
	}
	public function valiLogin($req){
		if (!(isset($req['username'])&&isset($req['password']))){
			return ['message' => 'Thiếu thông tin','code'=>400];
		}
		$username = $req['username'];
		$password = $req['password'];

		if($username == ''){
			return ['message' => 'Tên đăng nhập không được để trống', 'code' => 422];
		}
		if($password == ''){
			return ['message' => 'Mật khẩu không được để trống', 'code' => 422];
		}
		return ['message' => '', 'code' => 200];
	}
}
