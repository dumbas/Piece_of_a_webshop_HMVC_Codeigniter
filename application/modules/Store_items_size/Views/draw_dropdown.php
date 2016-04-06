<select name="colour" class="form-control">
<option value="">Select Size...</option>
	<?php
	foreach($query->result() as $row){
		echo'<option value="'.$row->id.'"> "'.$row->item_size.'"</option>';
	}
	?>
</select>