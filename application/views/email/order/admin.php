<p>Компания "<?=$user->company->company_name?>" оплатила счет №<?=$order->id?></p>
<p><b>Сумма:</b> <?=$order->sum?> руб.</p>
<p><b>Услуга:</b> <?=$service->name?> </p>
<?php if($service->id == 1 || $service->id == 2): ?>
	<p><b>Объект:</b> <a href="<?=Kohana_URL::base(true)?>/<?=$object->object_name()?>/view/<?=$object->id?>" ><?=$object->name?></a> </p>
<?php endif; ?>