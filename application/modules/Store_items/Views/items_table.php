<table cellpaddinig = "7" cellspacing = "0" border = "1" width = "600">

<tr>
	<th>Count</th>
	<th>Item Name</th>
	<th>Action</th>
</tr>

<?php
$count = 0;
	foreach ($query->result() as $row){
	$count++; 
?>
<tr>
	<td><?=$count;?></td>
	<td><?=$row->item_name; ?></td>
	<td><?=anchor('store_items/create/'.$row->id, 'Edit Item') ; ?></td>
</tr>

<?php } ?>

</table>