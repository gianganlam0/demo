<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Controller extends CI_Controller {

	function index(){
		$this->load->model('MyModel');
		$MyModel = new MyModel();
		$data['data'] = $MyModel->genData();
		$this->load->view('View', $data);
	}
}
