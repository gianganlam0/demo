<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HomeController extends CI_Controller {

	function index(){
		$this->load->view('HomeView');
	}
	function test(){
		$this->load->view('TestView');
	}
}
