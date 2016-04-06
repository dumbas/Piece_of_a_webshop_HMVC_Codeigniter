<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');

class Store_categories extends MX_Controller{

function __construct(){
	parent::__construct();
}

function get_breadcrumb($category_id){
		
		$breadcrumb = "";

	do {
			if (!isset ($parent_category)){
				$parent_category = $category_id;
			}

		$parent_category = $this->get_parent_category($parent_category);

			if ($parent_category > 0){
				$parents[] = $parent_category;
			}

	} while ($parent_category !="");

	if (isset($parents)){
			$parents = array_reverse($parents);
			foreach($parents as $parent){
				$category_name = $this->get_category_name($parent);
				$breadcrumb.= $category_name." > "; 
			}
		}

	return $breadcrumb;

}

function get_end_of_line_categories(){

	$max_depth = Modules::Run('site_settings/get_max_category_depth');

	$query = $this->get('category_name');
	foreach ($query->result() as $row){
		$category_id = $row->id;
		$parent_category = $row->parent_category;
		$category_depth = $this->get_category_depth($parent_category);

		if ($category_depth == $max_depth){
			//This must be an 'end of line' categories
			$categories[] = $category_id; 
		}
	}
	
		if (!isset($categories)){
				$categories = "";
		}

	return $categories;
}

function is_new_category_allowed($parent_category){
	// get max allowed depth
	$max_depth = Modules::Run('site_settings/get_max_category_depth');
	// get current category depth
	$current_depth = $this->get_category_depth($parent_category);
	// figure out if a new category is allowed
	if ($current_depth < $max_depth){
		return TRUE;
	} else {
		return FALSE;
	}

}

function get_category_depth($parent_category){
	//figure out how many layers deep a category is, based on parent category
	$depth = 0;
		do {
			$depth++;
			$parent_category = $this->get_parent_category($parent_category);
		} while ($parent_category !="");

	return $depth;
}

function get_parent_category($id){
	$query = $this->get_where($id);
		foreach($query->result() as $row){
			$parent_category = $row->parent_category;
		}
	if (!isset($parent_category)){
		$parent_category = "";
	}
	return $parent_category;
}

function _desplay_categories_table($parent_category){

	$data['query'] = $this->get_where_custom('parent_category', $parent_category);
	$this->load->view('categories_table', $data);
}

function delete_category($update_id){

	$submit = $this->input->post('submit', TRUE);

	if ($submit == 'No - Cancel delete'){
		redirect('store_categories/create/'.$update_id);
	}

	if ($submit == 'Yes - Delete Category'){
		//delete the item
		$this->delete($update_id);

		//add flashdata

		$value = "<p style = 'color: green;'>The category was successfully deleted.</p>";
		$this->session->set_flashdata('item', $value);

		redirect('store_categories/manage');
	}

	$data['update_id'] = $update_id;
	$template = "admin";
	$current_url = current_url();
	$data['form_location'] = $current_url;
	$data['view_file'] = "delete_conf";
	$this->load->module('template');
	$this->template->$template($data);

}


function create(){

	$category_id = $this->uri->segment(3);
	$data = $this->get_data_from_post();
	$submit = $this->input->post('submit', TRUE);

	if ($category_id > 0){
	
			if ($submit != "Submit"){
				//form hasn't been posted yet, so read from the db
				$data = $this->get_data_from_db($category_id);
			}
		$data['headline'] = "Edit Category";

	} else {
		$data['headline'] = "Create New Category";
	}

	$current_url = current_url();
	$data ['form_location'] = str_replace('/create', '/submit', $current_url);
	
	$flash = $this->session->flashdata('category');

	if($flash !=""){
		$data['flash'] = $flash;
	}

	$data['category_id'] = $category_id;
	$template = "admin";
	$data['view_file'] = "create";
	$this->load->module('template');
	$this->template->$template($data);
}

function submit(){
	//delas with the submitted form
	$parent_category = $this->uri->segment(4);
	if (!is_numeric($parent_category)){
		$parent_category = 0;
	}

	$this->form_validation->set_rules('category_name', 'Category Name', 'required');

	if ($this->form_validation->run() == FALSE){
		$this->create();
	} else {

		$update_id = $this->uri->segment(3);

		if ($update_id > 0){
			//This is an update
			$data = $this->get_data_from_post();
			$data['category_url'] = url_title($data['category_name']);
			$this->update($update_id, $data);
			$value = "<p style = 'color: green;'>The category was successfully updated.</p>";
			$parent_category = $update_id;
		} else {
			//Create new record
			$data = $this->get_data_from_post();
			$data['category_url'] = url_title($data['category_name']);
			$data['parent_category'] = $parent_category;
			$this->insert($data);
			$value = "<p style = 'color: green;'>The category was successfully created.</p>";
			$update_id = $this->get_max();

			$this->session->set_flashdata('category', $value);
			
		}
		//add flashdata
		$this->session->set_flashdata('category', $value);	

		redirect ('store_categories/manage/'.$parent_category);
		
	}
}

function get_category_name($id){

	$data = $this->get_data_from_db($id);
	$category_name = $data['category_name'];
	
	return $category_name;
}

function manage(){

	$template = "admin";

	$parent_category = $this->uri->segment(3);
		if (($parent_category < 1) || (!is_numeric($parent_category))){
			$parent_category = 0;
		}

	$data['parent_category'] = $parent_category;

		if ($parent_category > 0){
			$data['headline'] = "Manage ".$this->get_category_name($parent_category);
		} else {
		// This is a top level category, so use the default headline
			$data['headline'] = "Manage Store Categories";
		}

	$flash = $this->session->flashdata('category');
		if ($flash !=""){
			$data['flash'] = $flash;
		}

	$data['new_category_allowed'] = $this->is_new_category_allowed($parent_category);

	$data['view_file'] = "manage";
	$this->load->module('template');
	$this->template->$template($data);

}

function get_data_from_post(){
	$data['category_name'] = $this->input->post('category_name', TRUE);
	//$data['category_price'] = $this->input->post('category_price', TRUE);
	//$data['category_description'] = $this->input->post('category_description', TRUE);
	return $data;
}

function get_data_from_db($update_id){

	$query = $this->get_where($update_id);
	foreach($query->result() as $row){

		$data['category_name'] = $row->category_name;
		//$data['category_price'] = $row->category_price;
		//$data['small_pic'] = $row->small_pic;
		//$data['big_pic'] = $row->big_pic;
		//$data['category_url'] = $row->category_url;
		//$data['category_description'] = $row->category_description;
	}

	if (!isset($data)){
		$data = "";
	}

	return $data;

}

function get($order_by){
	$this->load->model('store_categories_model');
	$query = $this->store_categories_model->get($order_by);
	return $query;
}

function get_with_limit($limit, $offset, $order_by){
	$this->load->model('store_categories_model');
	$query = $this->store_categories_model->get_with_limit($limit, $offset, $order_by);
	return $query;
}

function get_where($id){
	$this->load->model('store_categories_model');
	$query = $this->store_categories_model->get_where($id);
	return $query;
}

function get_where_custom($col, $value){
	$this->load->model('store_categories_model');
	$query = $this->store_categories_model->get_where_custom($col, $value);
	return $query;
}

function insert($data){
	$this->load->model('store_categories_model');
	$this->store_categories_model->insert($data);
}

function update($id, $data){
	$this->load->model('store_categories_model');
	$this->store_categories_model->update($id,$data);
}

function delete($id){
	$this->load->model('store_categories_model');
	$this->store_categories_model->delete($id);
}

function count_where($column, $value){
	$this->load->model('store_categories_model');
	$count = $this->store_categories_model->count_where($column, $value);
	return $count;
}

function count_all(){
	$this->load->model('store_categories_model');
	$count_all = $this->store_categories_model->count_all();
	return $count_all;
}

function get_max(){
	$this->load->model('store_categories_model');
	$max_id = $this->store_categories_model->get_max();
	return $max_id;
}

function custom_query($mysql_query){
	$this->load->model('store_categories_model');
	$query = $this->store_categories_model->custom_query($mysql_query);
	return $query;

}

}