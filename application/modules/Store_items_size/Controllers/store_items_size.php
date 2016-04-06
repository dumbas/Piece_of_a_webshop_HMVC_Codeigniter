<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');

class Store_items_size extends MX_Controller{

function __construct(){
	parent::__construct();
}
function _draw_dropdown($item_id){

	$data['query'] = $this->get_where_custom('item_id', $item_id);
	$this->load->view('draw_dropdown', $data);

}

function ditch($update_id){
	Modules::Run('site_security/check_is_admin');
	
	$item_id = $this->uri->segment(4);
	$this->delete($update_id);
	redirect('store_items_size/update/'.$item_id);
}

function _desplay_sizes($item_id){
	$data['query'] = $this->get_where_custom('item_id', $item_id);
	$this->load->view('desplay_sizes', $data);
}

function update($item_id){

	$submit = $this->input->post('submit', TRUE);
	$items_size = trim($this->input->post('item_size', TRUE));

	if ($submit == "Cancel"){
		redirect('store_items/create/'.$item_id);
	}

	if (($submit == "Submit") && ($items_size !="")){

		$data['item_id'] = $item_id;
		$data['item_size'] = $items_size;
		$this->insert($data);
	}

	$data['form_location'] = current_url();

	$data['item_id'] = $item_id;
	$template = "admin";
	$data['view_file'] = "update";
	$this->load->module('template');
	$this->template->$template($data);
}

function get($order_by){
	$this->load->model('store_items_size_model');
	$query = $this->store_items_size_model->get($order_by);
	return $query;
}

function get_with_limit($limit, $offset, $order_by){
	$this->load->model('store_items_size_model');
	$query = $this->store_items_size_model->get_with_limit($limit, $offset, $order_by);
	return $query;
}

function get_where($id){
	$this->load->model('store_items_size_model');
	$query = $this->store_items_size_model->get_where($id);
	return $query;
}

function get_where_custom($col, $value){
	$this->load->model('store_items_size_model');
	$query = $this->store_items_size_model->get_where_custom($col, $value);
	return $query;
}

function insert($data){
	$this->load->model('store_items_size_model');
	$this->store_items_size_model->insert($data);
}
/*
function update($id, $data){
	$this->load->model('copy_model');
	$this->store_items_size_model->update($id,$data);
}
*/
function delete($id){
	$this->load->model('store_items_size_model');
	$this->store_items_size_model->delete($id);
}

function count_where($column, $value){
	$this->load->model('store_items_size_model');
	$count = $this->store_items_size_model->count_where($column, $value);
	return $count;
}

function count_all(){
	$this->load->model('store_items_size_model');
	$count_all = $this->store_items_size_model->count_all();
	return $count_all;
}

function get_max(){
	$this->load->model('store_items_size_model');
	$max_id = $this->store_items_size_model->get_max();
	return $max_id;
}

function custom_query($mysql_query){
	$this->load->model('store_items_size_model');
	$query = $this->store_items_size_model->custom_query($mysql_query);
	return $query;

}

}