<h2><?php echo $headline; ?></h2>
<div id="leftside">

	<?php 
		if(isset($flash)){
			echo $flash;
		}

		echo validation_errors("<p style =' color: red'>","</p>");
		echo form_open($form_location);
	?>

	<table cellpaddinig = "7" cellspacing = "0" border = "0" width = "600">
		<tr>
			<td valign = "top">Category Name</td>
			<td><?php echo form_input('category_name', $category_name); ?></td>
		</tr>
		
		<tr>
			<td valign = "top">&nbsp;</td>
			<td><?php echo form_submit('submit', 'Submit'); ?></td>
		</tr>
	</table>

	<?php
		echo form_close();
	?>

</div>

<div id="rightside">

	<?php
		if ($category_id > 0){
			//we are editing an item
			include('additional_options_view.php');
		}
	?>

</div>