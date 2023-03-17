<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FileController extends CI_Controller {
	public function download(){//don need view
		$this->load->model('FileModel');
		$this->load->helper('date');
		$cipherText=$this->input->get('token');
		$cipherText = urldecode($cipherText);
		$cipherText = base64_decode($cipherText);
		
		$plainText = $this->encryption->decrypt($cipherText);
		if (!$plainText) {
			$this->output->set_status_header(404);
			// echo json_encode(['message' => 'Không tìm thấy file','code'=>404,'data'=>[]]);
			return;
		}
		$ids = explode('_', $plainText);
		$userId = $ids[0];
		$fileId = $ids[1];
		$time = now('Asia/Ho_Chi_Minh');
		// echo $plainText;
		try {
			$res = $this->FileModel->get($fileId); //[data[name,path]]
			if ($res['code'] == 200) {
				$this->load->helper('download');
				//update downloadtime
				//check if user download file before
				$this->load->model('UserModel');
				$user = $this->UserModel->getUser(['_id'=>new MongoDB\BSON\ObjectId($userId)]);
				$user = $user[0];
				if ($user['downloadTime'] == null){
					$this->UserModel->updateUser(['downloadTime'=>$time],['_id'=>new MongoDB\BSON\ObjectId($userId)]);
				}
				//else do nothing
				$data = file_get_contents($res['data']['path']);
				force_download($res['data']['name'], $data);
			}
			else{
				$this->output->set_status_header($res['code']);
				// echo json_encode($res);
			}
		} catch (\Throwable $th) {
			$this->output->set_status_header(500);
		}
    }
	public function upload(){//don need view
		echo 'Developing...';
	}

}
