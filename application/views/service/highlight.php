<div class="row-fluid">
	<div class="span6">
		<form action="/payment/" method="post" class="form-horizontal">
			<input type="hidden" name="service_id" value="<?=$service->id?>" />
			<input type="hidden" name="model" value="<?=$object->object_name()?>" />
			<input type="hidden" name="object_id" value="<?=$object->id?>" />
			<input type="hidden" name="sum" value="<?=$service->cost?>" />
			<p>Выделите ваш магазин или товар в каталоге цветом, чтобы он привлекал больше внимания посетителей.</p>
			<div class="control-group link">
				<label class="control-label"><b>Вы хотите выделить:</b></label>
				<div class="controls">
					<span>
						<?=$type?>
					</span>
					<span>
						<a href="/<?=$object->object_name()?>/view/<?=$object->id?>" ><?=$object->name?></a>
					</span>
				</div>
			</div>
			<div class="control-group link">
				<label class="control-label"><b>Стоимость услуги (руб):</b></label>
				<div class="controls">
					<span>
						<?=round($service->cost)?> руб.
					</span>
				</div>
			</div> 
			<div class="control-group link">
				<label class="control-label"><b>Срок действия:</b></label>
				<div class="controls">
					<span>
						1 мес.
					</span>
				</div>
			</div>
			<p>Вы можете оплатить услугу любым удобным способом: кредитной картой, электронными деньгами, с помощью SMS, либо в терминале оплаты.</p>
			<button class="medium_button">Заказать и оплатить</button>
		</form>
		
	</div>
	<div class="span6">
		<?php 
			if($object->object_name() == 'tovar'):
				echo HTML::image('/images/tovars/mini/'.(round($object->id/500)+1).'/'.$object->id.'/'.Arr::get($images,'0',''));
			else:
				echo HTML::image('/images/shops/'.$object->id.'/'.Arr::get($images,'0',''));
			endif;
		?>
	</div>
</div>