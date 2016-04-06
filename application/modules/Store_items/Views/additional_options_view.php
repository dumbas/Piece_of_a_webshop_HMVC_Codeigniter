<h2>Additional Options</h2>

<ul>
	<li><?= anchor('store_items_colour/update/'.$item_id, 'Update Item Color'); ?></li>
	<li><?= anchor('store_items_size/update/'.$item_id, 'Update Item Size'); ?></li>
	<li><?= anchor('store_items/upload_pic/'.$item_id, 'Update Item Picture'); ?></li>
	<li><?= anchor('store_cat_assign/assign/'.$item_id, 'Category Assign'); ?></li>
	<li><?= anchor('store_items/delete_item/'.$item_id, '<span style=" color: red;">Delete Item</span>'); ?></li>

</ul>