<select name="qty" class="form-control">
<option value="">Select Quantity...</option>
	<?php

	for ($i=1; $i <= 10; $i++) { 
		echo'<option value="'.$item_id.'">'.$i.'</option>';
	}

	?>
</select>