<p>The item has been assigned to the following:<br><br></p>

<ul>
<?php
	$this->load->Module('store_categories');
	foreach ($query->result() as $row){
		$delete_url = base_url()."store_cat_assign/ditch/".$row->id."/".$item_id;
		$category_name = $this->store_categories->get_category_name($row->category_id);
		echo "<li>".$category_name." "."<a href='".$delete_url."'style = color:red;>Delete</a></li>";
	}

?>

</ul>