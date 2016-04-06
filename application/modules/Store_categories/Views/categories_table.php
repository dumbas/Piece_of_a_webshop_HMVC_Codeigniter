<table cellpaddinig = "7" cellspacing = "0" border = "1" width = "600">

<tr>
	<th>Count</th>
	<th>Category Name</th>
	<th>Action</th>
</tr>

<?php
$count = 0;
	foreach ($query->result() as $row){
	$count++; 
?>
<tr>
	<td><?=$count;?></td>
	<td><?=$row->category_name; ?></td>
	<td><?=anchor('store_categories/manage/'.$row->id, 'Edit Category') ; ?></td>
</tr>

<?php } ?>

</table>