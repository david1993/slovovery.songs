

	<?php $count = sizeof($stocks)-1; 
		foreach ($stocks as $key => $stock):?>
	<div class="row-fluid">
			<?php if($key == 0):?>
			<div class="span12 top">
				<a href="/stock/view/<?=$stock->id?>"><?= $stock->pic ? HTML::image('/images/mini/'.$stock->pic):''?></a>
				<h4><a href="/stock/view/<?=$stock->id?>"><?=$stock->name?></a> </h4>
			</div>
			<?php else:?>	
			<div class="span12 stock">
				<span class="date"><?=Date::cyrdate($stock->begin_time)?></span>
				<h4><a href="/stock/view/<?=$stock->id?>"><?=$stock->name?></a> </h4>
				
				<?php foreach ($stock->shops->find_all() as $shop):?>				
					<span class="shop"><a href="/shop/view/<?=$shop->id?>"><?=$shop->name.", ".($shop->url ? $shop->url: $shop->address)?></a></span>
				<?php endforeach?> 
				<p><?=$stock->anons?></p>
			</div>
			<?php endif;?>
	</div>
	<?php if($key!=0&&$count!=$key): ?>
		<hr />
	<?php endif;?>
	<?php endforeach?> 
	<div class="row-fluid">
		<p class="span12">
			<?php echo View::factory('stock/rsslink')?>
		</p>
	</div>
	<?=View::factory('subscriber/form')->bind('errors', $errors)->bind('message', $message) ?>
	
	


    
