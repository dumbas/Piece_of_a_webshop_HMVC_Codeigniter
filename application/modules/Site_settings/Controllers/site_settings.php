<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');

class Site_settings extends MX_Controller{

function __construct(){
	parent::__construct();
}

function get_max_category_depth(){
	$max_depth = 3;
	return $max_depth;
}

function get_currency(){
	$currency = "&pound;";
	return $currency;
}

function get_site_name(){
	$site_name = "The Cool Shop";
	return $site_name;
}

function get_owner_name(){
	$name = "Johny Bravo";
	return $name;
}

function get_owner_email(){
	$email = "johnybravo@yahoo.com";
	return $email;
}

function get_owner_phone(){
	$phone = "0887990088";
	return $phone;
}

}