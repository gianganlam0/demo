<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller{
	public function dashboard(){
		if ($this->session->username!='admin') {
			response(['code'=>401]);
		}
		else{
			$this->load->view('AdminView');
		}
	}
}

