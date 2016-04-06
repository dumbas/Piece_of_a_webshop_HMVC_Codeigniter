<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');

class Store_items extends MX_Controller{

function __construct(){
	parent::__construct();
}

function show($item_id){

	$data = $this->get_data_from_db($item_id);

	$template = "public_page";
	$data['view_file'] = "show_item";
	$data['item_id'] = $item_id;
	$this->load->module('template');
	$this->template->$template($data);
}

function upload_success($item_id){

	$query = $this->get_where($item_id);
	foreach($query->result() as $raw){
		$data['big_pic'] = $raw->big_pic;
	}

	$data['item_id'] = $item_id;
	$template = "admin";
	$data['view_file'] = "upload_success";
	$this->load->module('template');
	$this->template->$template($data);


}

function do_upload($item_id){
	Modules::Run('site_security/check_is_admin');

		$config['upload_path'] = './item_pics/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '1000';
		$config['max_width']  = '2024';
		$config['max_height']  = '2768';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload()){

			$data['error'] = array('error' => $this->upload->display_errors("<p style = 'color: red;'>", "</p>"));
			$data['item_id'] = $item_id;
			$template = "admin";
			$data['view_file'] = "upload_pic";
			$this->load->module('template');
			$this->template->$template($data);

		} else {

			$data = $this->upload->data();
			$file_name = $data['file_name']; //the name of the file that is now uploaded
			// creates a thumbnail
			$config['image_library'] = 'gd2';
			$config['source_image'] = './item_pics/'.$file_name;
			$config['create_thumb'] = TRUE;
			$config['maintain_ratio'] = TRUE;
			$config['width'] = 137;
			$config['height'] = 137;

			$this->load->library('image_lib', $config);
			$this->image_lib->resize();

			//resize the larger picture (make it 400px x 400px)
			$new_widht = 400;
			$new_height = 400;
			$this->_resize_pic($file_name, $new_widht, $new_height);

			//update the database 
			$raw_file_name = $data['raw_name'];
			$file_ext = $data['file_ext'];

			unset($data);

			$data['small_pic'] = $raw_file_name."_thumb".$file_ext ;
			$data['big_pic'] = $file_name;
			$this->update($item_id, $data);

			//divert to success page
			redirect('store_items/upload_success/'.$item_id);

		}
}

function _resize_pic($file_name, $new_widht, $new_height){
	Modules::Run('site_security/check_is_admin');

	$config['image_library'] = 'gd2';
	$config['source_image'] = './item_pics/'.$file_name;
	$config['create_thumb'] = FALSE;
	$config['maintain_ratio'] = TRUE;
	$config['width'] = $new_widht;
	$config['height'] = $new_height;

	$this->image_lib->initialize($config); 

	$this->load->library('image_lib', $config);
	$this->image_lib->resize();

}

function upload_pic($item_id){

	$data['item_id'] = $item_id;
	$template = "admin";
	$data['view_file'] = "upload_pic";
	$this->load->module('template');
	$this->template->$template($data);
}

function delete_item($update_id){

	$submit = $this->input->post('submit', TRUE);

	if ($submit == 'No - Cancel delete'){
		redirect('store_items/create/'.$update_id);
	}

	if ($submit == 'Yes - Delete Item'){
		//delete the item
		$this->delete($update_id);

		//add flashdata

		$value = "<p style = 'color: green;'>The item was successfully deleted.</p>";
		$this->session->set_flashdata('item', $value);

		redirect('store_items/manage');
	}

	$data['update_id'] = $update_id;
	$template = "admin";
	$current_url = current_url();
	$data['form_location'] = $current_url;
	$data['view_file'] = "delete_conf";
	$this->load->module('template');
	$this->template->$template($data);

}

function _desplay_items_table(){
	$data['query'] = $this->get('item_name');
	$this->load->view('items_table', $data);
}

function get_data_from_post(){
	$data['item_name'] = $this->input->post('item_name', TRUE);
	$data['item_price'] = $this->input->post('item_price', TRUE);
	$data['item_description'] = $this->input->post('item_description', TRUE);
	return $data;
}

function get_data_from_db($update_id){

	$query = $this->get_where($update_id);
	foreach($query->result() as $row){

		$data['item_name'] = $row->item_name;
		$data['item_price'] = $row->item_price;
		$data['small_pic'] = $row->small_pic;
		$data['big_pic'] = $row->big_pic;
		$data['item_url'] = $row->item_url;
		$data['item_description'] = $row->item_description;
	}

	if (!isset($data)){
		
		echo "Sorry the item is not available";
		die();
		
	}

	return $data;

}

function manage(){

	$template = "admin";

	$flash = $this->session->flashdata('item');
	if($flash !=""){
		$data['flash'] = $flash;
	}

	$data['view_file'] = "manage";
	$this->load->module('template');
	$this->template->$template($data);

}

function create(){

	$item_id = $this->uri->segment(3);
	$data = $this->get_data_from_post();
	$submit = $this->input->post('submit', TRUE);

	if ($item_id > 0){
	
			if ($submit != "Submit"){
				//form hasn't been posted yet, so read from the db
				$data = $this->get_data_from_db($item_id);
			}
		$data['headline'] = "Edit Item";

	} else {
		$data['headline'] = "Create New Item";
	}

	$current_url = current_url();
	$data ['form_location'] = str_replace('/create', '/submit', $current_url);
	
	$flash = $this->session->flashdata('item');

	if($flash !=""){
		$data['flash'] = $flash;
	}

	$data['item_id'] = $item_id;
	$template = "admin";
	$data['view_file'] = "create";
	$this->load->module('template');
	$this->template->$template($data);
}

function submit(){
	//deals with the submitted form
	$this->form_validation->set_rules('item_name', 'Item Name', 'required');
	$this->form_validation->set_rules('item_price', 'Item Price', 'is_numeric|required');
	$this->form_validation->set_rules('item_description', 'Item Description', 'required');

	if ($this->form_validation->run() == FALSE){
		$this->create();
	} else {

		$update_id = $this->uri->segment(3);

		if ($update_id > 0){
			//This is an update
			$data = $this->get_data_from_post();
			$data['item_url'] = url_title($data['item_name']);
			$this->update($update_id, $data);
			$value = "<p style = 'color: green;'>The item was successfully updated.</p>";
		} else {
			//Create new record
			$data = $this->get_data_from_post();
			$data['item_url'] = url_title($data['item_name']);
			$this->insert($data);
			$value = "<p style = 'color: green;'>The item was successfully created.</p>";
			$update_id = $this->get_max();
		}
		//add flashdata
		$this->session->set_flashdata('item', $value);	

		
		redirect('store_items/create/'.$update_id);
	}
}

function get($order_by){
	$this->load->model('store_items_model');
	$query = $this->store_items_model->get($order_by);
	return $query;
}

function get_with_limit($limit, $offset, $order_by){
	$this->load->model('store_items_model');
	$query = $this->store_items_model->get_with_limit($limit, $offset, $order_by);
	return $query;
}

function get_where($id){
	$this->load->model('store_items_model');
	$query = $this->store_items_model->get_where($id);
	return $query;
}

function get_where_custom($col, $value){
	$this->load->model('store_items_model');
	$query = $this->store_items_model->get_where_custom($col, $value);
	return $query;
}

function insert($data){
	$this->load->model('store_items_model');
	$this->store_items_model->insert($data);
}

function update($id, $data){
	$this->load->model('store_items_model');
	$this->store_items_model->update($id,$data);
}

function delete($id){
	$this->load->model('store_items_model');
	$this->store_items_model->delete($id);
}

function count_where($column, $value){
	$this->load->model('store_items_model');
	$count = $this->copy_model->count_where($column, $value);
	return $count;
}

function count_all(){
	$this->load->model('store_items_model');
	$count_all = $this->store_items_model->count_all();
	return $count_all;
}

function get_max(){
	$this->load->model('store_items_model');
	$max_id = $this->store_items_model->get_max();
	return $max_id;
}

function custom_query($mysql_query){
	$this->load->model('store_items_model');
	$query = $this->copy_model->custom_query($mysql_query);
	return $query;

}

}