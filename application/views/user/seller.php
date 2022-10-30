<?php if(Auth::instance()->logged_in('seller')):?>
	<div class="span1 pull-right"><a href="/user/logout" >Выход</a></div>
	<div class="span9 seller" >
		<div class="pull-left name"><?=$seller['username']?></div><div class="email">(<?=$seller['email']?>)</div>
		<p></p>
		<span class="l_manager" >Ваш менеджер:</span><strong><?=$manager['name']?></strong> <a href="/user/feedback">отправить сообщение</a><?=isset($manager['phone'])? "<span class='l_phone' >тел.:</span><strong>".$manager['phone']."</strong>":''?>
	</div>
<?php endif;?>