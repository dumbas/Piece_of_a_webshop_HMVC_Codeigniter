<h2>Upload Success</h2>
<p>The image was successfully uploaded.</p>

<p><?php
echo anchor('store_items/create/'.$item_id, 'Return To Edit Item');
?></p>

<?php

if (isset($big_pic)){
	$pic_path = base_url()."item_pics/".$big_pic;
	echo "<p>";
	echo "<img src = '".$pic_path."'>";
	echo "</p>";
}

?>