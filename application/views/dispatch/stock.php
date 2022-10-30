<div style="width: 760px;">
<?php foreach ($stocks as $stock):?>
	<div class="row">
		
		<h4><a href="<?=URL::base('http', TRUE)?>stock/view/<?=$stock->id?>"><?=$stock->name?></a></h4>
			
		<?php foreach ($stock->shops->find_all() as $shop):?>				
			<p><a href="<?=URL::base('http', TRUE)?>shop/view/<?=$shop->id?>"><?=$shop->name.", ".($shop->url ? $shop->url: $shop->address)?></a></p>
		<?php endforeach?> 
		<p><?=$stock->anons?></p>
		<?php if(isset($stock->pic)):?>
		<p><a href="<?=URL::base('http', TRUE)?>shop/view/<?=$shop->id?>"><?= HTML::image(URL::base("http", TRUE).'images/mini/'.$stock->pic)?></a></p>
		<?php endif;?>
		
	</div>
<?php endforeach?> 
</div>