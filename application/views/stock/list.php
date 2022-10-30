
<div class="row-fluid stocks_list">
	<div class="span9" >
		<div class="span8" >
		<?=View::factory('subscriber/form')->bind('errors', $errors)->bind('message', $message) ?>
		</div>
		<div class="row-fluid" >
			<?php foreach ($stocks as $stock):?>
			<div class="span12">
					<h3><a href="/stock/view/<?=$stock->id?>"><?=$stock->name?></a> <small class="date"><?=Date::cyrdate($stock->begin_time)?></small></h3>
					<?php
						$shops = $stock->shops->find_all();
						if(sizeof($shops)):
					?>
					<p>	
						<?php 
							$i=0;
							foreach ($shops as $key => $shop):
								$i++;
						?>				
							<a href="/shop/view/<?=$shop->id?>"><?=$shop->name.", ".($shop->url ? $shop->url: $shop->address)?></a><?php echo ($i>0)?"<br />":""; ?>
						<?php endforeach;?> 
					</p>
					<?php endif;?>
					<p><?=$stock->anons?></p>
					<?php if(isset($stock->pic)):?>
						<?= HTML::image('/images/mini/'.$stock->pic)?>
					<?php endif;?>
			</div>
			<div class="clearfix" ></div>
			<div class="span12" >
				<hr />
			</div>	
			<?php endforeach?> 
			
		</div>
		
	</div>
	<div class="span3">
		<div class="row-fluid">
			<div class="span12 inner_right_banner">
				<img src="/images/right_banner.gif" />
			</div>
		</div>
	</div>
	<div class="clearfix" ></div>	
		<?=$pagination?>
</div>
 
 

    
