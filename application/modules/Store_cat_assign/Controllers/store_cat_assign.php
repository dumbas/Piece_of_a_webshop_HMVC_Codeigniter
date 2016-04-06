<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');

class Store_cat_assign extends MX_Controller{

function __construct(){
	parent::__construct();
}

function ditch(){
	$id = $this->uri->segment(3);
	$item_id = $this->uri->segment(4);
	$this->delete($id);
	redirect ('store_cat_assign/assign/'.$item_id);
}

function _draw_assigned_categories($item_id){

	$data['query'] = $this->get_where_custom('item_id', $item_id);
	$num_rows = $data['query']->num_rows();

	if ($num_rows > 0){
		$this->load->view('assigned_categories', $data);
	}

}

function assign(){

	$item_id = $this->uri->segment(3);
	$submit = $this->input->post('submit', TRUE);

	if ($submit == "Cancel"){
		redirect('store_items/create/'.$item_id);
	}

	if ($submit == "Submit"){
		$data['item_id'] = $item_id;
		$data['category_id'] = $this->input->post('category_id', TRUE);
		$this->insert($data);
	}

	$data['item_id'] = $item_id;
	$template = "admin";
	$current_url = current_url();
	$data['form_location'] = $current_url;
	$data['view_file'] = "assign";
	$this->load->module('template');
	$this->template->$template($data);

}

function get($order_by){
	$this->load->model('store_cat_assign_model');
	$query = $this->store_cat_assign_model->get($order_by);
	return $query;
}

function get_with_limit($limit, $offset, $order_by){
	$this->load->model('store_cat_assign_model');
	$query = $this->store_cat_assign_model->get_with_limit($limit, $offset, $order_by);
	return $query;
}

function get_where($id){
	$this->load->model('store_cat_assign_model');
	$query = $this->store_cat_assign_model->get_where($id);
	return $query;
}

function get_where_custom($col, $value){
	$this->load->model('store_cat_assign_model');
	$query = $this->store_cat_assign_model->get_where_custom($col, $value);
	return $query;
}

function insert($data){
	$this->load->model('store_cat_assign_model');
	$this->store_cat_assign_model->insert($data);
}

function update($id, $data){
	$this->load->model('store_cat_assign_model');
	$this->store_cat_assign_model->update($id,$data);
}

function delete($id){
	$this->load->model('store_cat_assign_model');
	$this->store_cat_assign_model->delete($id);
}

function count_where($column, $value){
	$this->load->model('store_cat_assign_model');
	$count = $this->store_cat_assign_model->count_where($column, $value);
	return $count;
}

function count_all(){
	$this->load->model('store_cat_assign_model');
	$count_all = $this->store_cat_assign_model->count_all();
	return $count_all;
}

function get_max(){
	$this->load->model('store_cat_assign_model');
	$max_id = $this->store_cat_assign_model->get_max();
	return $max_id;
}

function custom_query($mysql_query){
	$this->load->model('store_cat_assign_model');
	$query = $this->store_cat_assign_model->custom_query($mysql_query);
	return $query;

}

}