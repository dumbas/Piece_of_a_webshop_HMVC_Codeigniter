<div id="add_to_cart_box">
<strong>
	Item Price: <?= $currency." ".$item_price;?> 
</strong><br><br>

<?=Modules::Run('store_items_colour/_draw_dropdown', $item_id) ;?><br>

<?=Modules::Run('store_items_size/_draw_dropdown', $item_id) ;?><br>

<?=Modules::Run('cart/_draw_qty_dropdown', $item_id) ;?><br>

<button type="button" class="btn btn-primery" style= "background-color: #337AB7;color: white">
            <span class=" glyphicon glyphicon-plus"></span>
          Add To Basket
        </button>
</div>