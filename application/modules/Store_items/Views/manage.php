<h2>Manage your items</h2>

<?php 
	if (isset($flash)){
		echo $flash;
	}
?>

<?php echo anchor('store_items/create','Create New Item');
?>

</br></br>

<?php
echo Modules::Run('store_items/_desplay_items_table');
?>