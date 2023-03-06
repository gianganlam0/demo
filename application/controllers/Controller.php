<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Controller extends CI_Controller {

	function index(){
		$this->load->model('Model');
		$Model = new Model();
		$data['data'] = $Model->getData();
		$data['data2'] = $Model->findUserByName('bao');
		$this->load->view('View', $data);
	}
}
