<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');

class Template extends MX_Controller{

function __construct(){
	parent::__construct();
}

function admin($data){
	Modules::run('site_security/check_is_admin');
	$this->load->view('admin_view' , $data);
}

function public_page($data){
	
	$this->load->view('public_page_view', $data);
}

}