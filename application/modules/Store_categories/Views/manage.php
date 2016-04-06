<h2><?php echo $headline; ?></h2>


<?php 
	if (isset($flash)){
		echo $flash;
	}

	if ($new_category_allowed == TRUE){
		echo anchor('store_categories/create/x/'.$parent_category, 'Create New Category on this level');
		echo nbs(7);
	}

	if ($parent_category > 0){
		echo anchor('store_categories/create/'.$parent_category,
					 'Update Parent Category Name');
	}
	
?>

</br></br>

<?php
echo Modules::Run('store_categories/_desplay_categories_table', $parent_category);
?>