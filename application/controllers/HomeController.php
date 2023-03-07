<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HomeController extends CI_Controller {

	function index(){
		$this->load->model('HomeModel');
		// $HomeModel = new HomeModel();

		$this->load->view('components/header');
		$this->load->view('HomeView');
		$this->load->view('components/footer');
	}
}
