<h1>

<?php
	echo $item_name;
?><br>
</h1>


<div class="container">
	<div class="row">
	    <div class="col-md-4">
	    	<?php
	    		$pic_path = base_url()."item_pics/".$big_pic;
	    	?>
	    	<img src="<?php echo $pic_path; ?>">
	    </div>
	    <div class="col-md-4">
	        <h4>Item ID : <?=$item_id; ?></h4>

	        <?php
	        	$currency = Modules::Run('site_settings/get_currency');
	        	$item_price = number_format($item_price, 2);
	        	$item_price = str_replace('.00', "", $item_price);
	        	
	        ?>
	        <h4>Item Price : <?=$currency.' '.$item_price; ?></h4>
			
			<?php
				echo nl2br($item_description);
			?>

	          <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
	    </div>
	    <div class="col-md-4">
	    	<?php 
	    		echo Modules::Run('cart/_desplay_to_cart_box', $item_id, $item_price);
	    	?>

	    </div>
    </div>
</div>
