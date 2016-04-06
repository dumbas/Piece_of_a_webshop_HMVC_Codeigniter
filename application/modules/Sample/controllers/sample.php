<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class sample extends MX_Controller {

	function index(){
		echo "HELLO WORLD";
		$this->load->view('sample');
	}
}