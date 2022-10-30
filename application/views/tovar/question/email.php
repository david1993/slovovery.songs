<p>Поступил вопрос</p>
<p>Магазин: <a href="/shop/view/<?=$shop->id?>" ><?=$shop->name?></a></p>
<p>Продукт: <a href="/tovar/view/<?=$tovar->id?>" ><?=$tovar->name?></a></p>
<?php if($values['name']):?>
	<p>Клиент: <?=$values['name']?></p>
<?php endif;?>
<?php if($values['phone']):?>
	<p>Телефон: <?=$values['phone']?></p>
<?php endif;?>
<p>E-mail: <?=$values['email']?></p>
<?php if($values['message']):?>
	<p>Вопрос: <?=$values['message']?></p>
<?php endif;?>