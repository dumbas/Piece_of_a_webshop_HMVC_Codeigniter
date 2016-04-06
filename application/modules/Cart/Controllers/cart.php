<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');

class Cart extends MX_Controller{

function __construct(){
	parent::__construct();
}

function _draw_qty_dropdown($item_id){
	$data ['item_id'] = $item_id;
	$this->load->view('draw_qty_dropdown', $data);
}

function _desplay_to_cart_box($item_id, $item_price){

	$data['item_id'] = $item_id;
	$data['item_price'] = $item_price;
	$data['currency'] = Modules::Run('site_settings/get_currency');
	$this->load->view('add_to_cart_box', $data);

}

function get($order_by){
	$this->load->model('cart_model');
	$query = $this->cart_model->get($order_by);
	return $query;
}

function get_with_limit($limit, $offset, $order_by){
	$this->load->model('cart_model');
	$query = $this->cart_model->get_with_limit($limit, $offset, $order_by);
	return $query;
}

function get_where($id){
	$this->load->model('cart_model');
	$query = $this->cart_model->get_where($id);
	return $query;
}

function get_where_custom($col, $value){
	$this->load->model('cart_model');
	$query = $this->cart_model->get_where_custom($col, $value);
	return $query;
}

function insert($data){
	$this->load->model('cart_model');
	$this->cart_model->insert($data);
}

function update($id, $data){
	$this->load->model('cart_model');
	$this->cart_model->update($id,$data);
}

function delete($id){
	$this->load->model('cart_model');
	$this->cart_model->delete($id);
}

function count_where($column, $value){
	$this->load->model('cart_model');
	$count = $this->cart_model->count_where($column, $value);
	return $count;
}

function count_all(){
	$this->load->model('cart_model');
	$count_all = $this->cart_model->count_all();
	return $count_all;
}

function get_max(){
	$this->load->model('cart_model');
	$max_id = $this->cart_model->get_max();
	return $max_id;
}

function custom_query($mysql_query){
	$this->load->model('cart_model');
	$query = $this->cart_model->custom_query($mysql_query);
	return $query;

}

}