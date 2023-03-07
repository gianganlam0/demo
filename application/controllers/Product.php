<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller{
	function index($productName=''){

		$this->load->view('ProductView',['productName'=>$productName]);
	}
}
