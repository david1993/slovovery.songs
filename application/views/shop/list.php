<div>
			<?=$filter?>
	</div>
	<div class="row-fluid">
		<div class="span12">
			<?=$sort?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span4">
			<?php foreach ($shops as $shop):?>
				<div class="shop <?=!is_null($shop['highlight'])?'highlight':'';?>">	
				<h4><a href="/shop/view/<?=$shop['id']?>"><?=$shop['name']?></a></h4>
							<div class="pull-left rate">рейтинг: 
								<b>
									<?php if(is_null($shop['rate'])):?>
										0
									<?php else:?>
										<?= $shop['rate']?>
									<?php endif;?>
								</b>
							</div>
							<div class="pull-left note">отзывов: 
								<b>
									<?php if(is_null($shop['comments_count'])):?>
										0
									<?php else:?>
										<?= $shop['comments_count']?>
									<?php endif;?>
								</b>
							</div>
							<div class="clearfix" ></div>
					<p><a class="address" href="/shop/view/<?=$shop['id']?>" ><?=$shop['address']?></a></p>
					<p><?=$shop['phone']?></p>
					<p><?=$shop['description']?></p>
			</div>
			<?php endforeach?> 
			
		</div>
		<div id="map_canvas" class="span8"></div>
	</div>
	<div class="clearfix" ></div>
		
			<?=$pagination?>