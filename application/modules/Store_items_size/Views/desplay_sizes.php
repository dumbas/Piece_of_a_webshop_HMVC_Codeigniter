

<?php
$num_rows = $query->num_rows();
if ($num_rows > 0) {
	echo "<h2>Sizes so far</h2>";
	echo "<ul>";
		foreach($query->result() as $row) {
			echo "<li>";
			echo $row->item_size. " ";
			echo anchor('store_items_size/ditch/'.$row->id.'/'.$item_id, '<span style = "color: red;">Delete</span>');
			echo "</li>";
		}
	echo "</ul>";	
}
?>