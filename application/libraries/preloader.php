<?php
	if (!defined('BASEPATH')) exit('No direct script access allowed');
	
	class Preloader{
		//this class use to load some js and css files to all views in the project
		public function __construct(){
			echo "<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js'></script>";//js
			echo "<script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js'></script>";//js
			echo "<script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js'></script>";//js
			echo "<script src='".base_url()."js/Utils.js'></script>";//for some useful functions of js
			echo "<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css'>";
			echo "<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>";
		}
	}
