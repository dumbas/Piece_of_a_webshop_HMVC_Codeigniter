<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');

class Copy_Controller extends MX_Controller{

function __construct(){
	parent::__construct();
}

function get($order_by){
	$this->load->model('copy_model');
	$query = $this->copy_model->get($order_by);
	return $query;
}

function get_with_limit($limit, $offset, $order_by){
	$this->load->model('copy_model');
	$query = $this->copy_model->get_with_limit($limit, $offset, $order_by);
	return $query;
}

function get_where($id){
	$this->load->model('copy_model');
	$query = $this->copy_model->get_where($id);
	return $query;
}

function get_where_custom($col, $value){
	$this->load->model('copy_model');
	$query = $this->copy_model->get_where_custom($col, $value);
	return $query;
}

function insert($data){
	$this->load->model('copy_model');
	$this->copy_model->insert($data);
}

function update($id, $data){
	$this->load->model('copy_model');
	$this->copy_model->update($id,$data);
}

function delete($id){
	$this->load->model('copy_model');
	$this->copy_model->delete($id);
}

function count_where($column, $value){
	$this->load->model('copy_model');
	$count = $this->copy_model->count_where($column, $value);
	return $count;
}

function count_all(){
	$this->load->model('copy_model');
	$count_all = $this->copy_model->count_all();
	return $count_all;
}

function get_max(){
	$this->load->model('copy_model');
	$max_id = $this->copy_model->get_max();
	return $max_id;
}

function custom_query($mysql_query){
	$this->load->model('copy_model');
	$query = $this->copy_model->custom_query($mysql_query);
	return $query;

}

}