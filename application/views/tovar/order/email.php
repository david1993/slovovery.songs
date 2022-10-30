<p>Поступил заказ</p>
<p>Магазин: <a href="/shop/view/<?=$shop->id?>" ><?=$shop->name?></a></p>
<p>Продукт: <a href="/tovar/view/<?=$tovar->id?>" ><?=$tovar->name?></a></p>
<?php if($values['name']):?>
	<p>Клиент: <?=$values['name']?></p>
<?php endif;?>
<p>Телефон: <?=$values['phone']?></p>
<p>E-mail: <?=$values['email']?></p>
<?php if($values['add']):?>
	<p>Дополнительно: <?=$values['add']?></p>
<?php endif;?>