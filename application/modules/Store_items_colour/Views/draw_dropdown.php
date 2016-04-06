<select name="colour" class="form-control">
<option value="">Select Colour...</option>
	<?php
	foreach($query->result() as $row){
		echo'<option value="'.$row->id.'"> "'.$row->item_colour.'"</option>';
	}
	?>
</select>