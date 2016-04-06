<h2>Update Items Size</h2>

<p>Please enter a size and than press 'Submit'.</p>

<div id = "leftside">
	<?php
		echo form_open($form_location);
		echo form_input('item_size', '');
		echo nbs(3);
		echo form_submit('submit', 'Submit');
		echo nbs(3);
		echo form_submit('submit', 'Cancel');
		echo form_close();
	?>
</div>

<div id = "rightside">
<?php
echo Modules::Run('store_items_size/_desplay_sizes', $item_id);
?>
</div>