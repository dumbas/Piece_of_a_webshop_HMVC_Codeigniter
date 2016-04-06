<h2>Delete Category</h2>

<p>Are you sure that you want to delete the Category?</p>

<?php
echo form_open($form_location);
echo form_submit('submit', 'Yes - Delete Category');
echo nbs(7);
echo form_submit('submit', 'No - Cancel delete');
echo form_close()
?>