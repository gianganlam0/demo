<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserController extends CI_Controller {
	public function register(){//just a api so no need view

		$this->load->model('EmailModel');
		$this->load->model('UserModel');
		$req = $this->input->post();
		//validate data
		$valiRes = $this->UserModel->valiRegister($req);
		if ($valiRes['code']!=200) {
			$this->output->set_status_header($valiRes['code']);
			//return error message in body
			echo json_encode($valiRes);
		}
		else{
			$req['age'] = intval($req['age']);
			$req['sex'] = (int)$req['sex'];
			$req['latitude'] = (float)$req['latitude'];
			$req['longitude'] = (float)$req['longitude'];
			$req['activeCode'] = random_string('alnum', 32);
			$req['sentMailTime'] = null;
			$req['openMailTime'] = null;
			$req['downloadTime'] = null;

			//chua dk -> da dk ma chua kich hoat(gui lai ma) -> da kich hoat

			try {
				$users = $this->UserModel->getUser(['email'=>$req['email']]);
				if (count($users) == 0) {//chưa đăng ký
					$this->UserModel->insertUser($req);
					$to = $req['email'];
					$sub = "Xác nhận địa chỉ email";
					$body = "<p>Vui lòng bấm vào liên kết sau để xác nhận địa chỉ email này là của bạn<p><br>".
					base_url()."usercontroller/active?email=$req[email]&activeCode=$req[activeCode]";
		
					$result = $this->EmailModel->sendEmail($to, $sub, $body);
					$this->output->set_status_header($result['code']);
					echo json_encode($result);
					// $res=$this->UserModel->insertUser($req);
					// $this->output->set_status_header($res['code']);
					// $res['data']='';
					// if ($res['code']==200) $res['message']='';
					// echo json_encode($res);
				}
				else if($users[0]['activeCode'] != null){//đã đăng ký nhưng chưa kích hoạt, gửi lại code
					$this->UserModel->updateUser(['activeCode'=>$req['activeCode']],['email'=>$req['email']]);
					$to = $req['email'];
					$sub = "Xác nhận địa chỉ email";
					$body = "<p>Vui lòng bấm vào liên kết sau để xác nhận địa chỉ email này là của bạn<p><br>".
					base_url()."usercontroller/active?email=$req[email]&activeCode=$req[activeCode]";
		
					$result = $this->EmailModel->sendEmail($to, $sub, $body);
					$this->output->set_status_header($result['code']);
					echo json_encode($result);
				}
				else{//đã kích hoạt
					$this->output->set_status_header(400);
					echo json_encode(['code'=>400,'message'=>'Email đã được đăng ký','data'=>'']);
				}
			} catch (\Throwable $th) {
				$this->output->set_status_header(500);
				echo json_encode(['code'=>500,'message'=>$th->getMessage(),'data'=>'']);
			}


		}
    }
	public function active(){//need view
		$this->load->model('UserModel');
		$this->load->model('EmailModel');
		$email = $this->input->get('email') == null? '':$this->input->get('email');
		$activeCode = $this->input->get('activeCode') == null? '':$this->input->get('activeCode');
		try {
			$res = $this->UserModel->activeUser(['email'=>$email,'activeCode'=>$activeCode]);
			$this->output->set_status_header($res['code']);

			if ($res['code'] == 200){
				//now send file download link to user
				//get user info by email

				$user = $this->UserModel->getUser(['email'=>$email])[0];
				$userId = $user['_id'];
				$fileId = '640a9eafa29a32ea7148dbf1';//hard code
				$plainText = $userId.'_'.$fileId;
				//encrypt
				$cipherText = $this->encryption->encrypt($plainText);
				$cipherText = base64_encode($cipherText);
				$cipherText = urlencode($cipherText);

				//inject image tag to email body to check if user open email
				$url = base_url()."usercontroller/openMail?token=$cipherText";
				//send email
				$to = $email;
				$sub = "Link tải file";
				$body = "<p>Vui lòng bấm vào liên kết sau để tải file<p><br>".
				base_url()."filecontroller/download?token=$cipherText<br>".
				"<img alt='openmail' style='display:block' title='openmail' border='0' width='1' height='1' src=$url></img>";

				$this->EmailModel->sendEmail($to, $sub, $body);
				// $this->output->set_status_header($result['code']);
				// $res['message'] = $result['message'];
			}

			$this->load->view('ActiveView',['res'=>$res]);

		} catch (\Throwable $th) {
			$this->output->set_status_header(500);
			$this->load->view('ActiveView',['res'=>['code'=>500,'message'=>$th->getMessage(),'data'=>'']]);
		}
	}
	public function openMail(){
		$this->load->model('UserModel');
		$this->load->helper('date');
		$cipherText=$this->input->get('token');
		$cipherText = urldecode($cipherText);
		$cipherText = base64_decode($cipherText);
		$plainText = $this->encryption->decrypt($cipherText);
		$ids = explode('_', $plainText);
		$userId = $ids[0];
		$userId = new MongoDB\BSON\ObjectId($userId);
		$time = now('Asia/Ho_Chi_Minh');
		// $time = date('H:i:s', $time);
		try {
			$res = $this->UserModel->getUser(['_id'=>$userId,'openMailTime'=>null]);
			if (count($res) == 0) return;
			$this->UserModel->updateUser(['openMailTime'=> $time],['_id'=>$userId]);
			//echo a transparent image
			$img = imagecreatetruecolor(1, 1);
			imagesavealpha($img, true);
			$trans_colour = imagecolorallocatealpha($img, 0, 0, 0, 127);
			imagefill($img, 0, 0, $trans_colour);
			header('Content-Type: image/png');
			imagepng($img);
			
		} catch (\Throwable $th) {
			throw $th;
		}
		// $fileId = $ids[1];
	}
	public function login(){
		if ($this->session->has_userdata('username')) {
			redirect(base_url());
		}
		$this->load->view('LoginView');
	}//view
	public function auth(){
		$this->load->model('UserModel');
		$req = $this->input->post();
		//validate data
		$res = $this->UserModel->valiLogin($req);
		if ($res['code']!=200) {
			$this->output->set_status_header($res['code']);
			//return error message in body
			echo json_encode($res);
		}
		else{
			$username = $req['username'];
			$password = $req['password'];
			try {
				//check if login before
				if ($this->session->has_userdata('username')) {
					$this->output->set_status_header(400);
					echo json_encode(['code'=>400,'message'=>'Bạn đã đăng nhập','data'=>'']);
				}
				else{
					//check if user exist
					$users = $this->UserModel->getAdmin(['username'=>$username]);
					if (count($users) == 0) {
						$this->output->set_status_header(400);
						echo json_encode(['code'=>400,'message'=>'Tài khoản không tồn tại','data'=>'']);
					}
					else{
						//check if password correct
						$user = $users[0];
						if (hash('sha256',$password) != $user['password']) {
							$this->output->set_status_header(400);
							echo json_encode(['code'=>400,'message'=>'Mật khẩu không đúng','data'=>'']);
						}
						else{
							//login success
							$this->session->set_userdata('username',$username);
							$this->output->set_status_header(200);
							echo json_encode(['code'=>200,'message'=>'Đăng nhập thành công','data'=>'']);
						}
							
					}
				}
				
			} catch (\Throwable $th) {
				$this->output->set_status_header(500);
				echo json_encode(['code'=>500,'message'=>$th->getMessage(),'data'=>'']);
			}
		}
	}
	public function logout(){
		try{
			$this->session->unset_userdata('username');
			$this->output->set_status_header(200);
			echo json_encode(['code'=>200,'message'=>'Đăng xuất thành công','data'=>'']);
		}
		catch(\Throwable $th){
			$this->output->set_status_header(500);
			echo json_encode(['code'=>500,'message'=>$th->getMessage(),'data'=>'']);
		}
	}
	public function get(){
		if ($this->session->username!='admin') {
			response(['code'=>401]);
		}
		else{
			$this->load->model('UserModel');
			try {
				$res['data'] = $this->UserModel->getUser();
				echo response($res);
			} catch (\Throwable $th) {
				echo response(['code'=>500,'message'=>$th->getMessage()]);
			}
		}
	}
}
