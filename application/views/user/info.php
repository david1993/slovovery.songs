<div class="row-fluid" >
	<div class="span9" >
		<?php if(!$active):?>
		<div class="row-fluid" >
			<div class="span12" >
				<p class="label-important">Показ товаров остановлен.</p>
			</div>
		</div>
		<?php endif;?>
		<?php if(Auth::instance()->logged_in('seller')):?>
		<h3><a href="/user/tovars/">Мои товары</a><small>(<?=$count_tovars?>)</small></h3>
		<p>Мебель, которую вы размещаете на портале.
		</p> 
		<h3><a href="/user/stocks/">Мои акции</a><small>(<?=$count_stocks?>)</small></h3>
		<p>Информация о ваших спецпредложениях: скидки, новые поступления, и проч.
		</p> 
		<h3><a href="/user/shops/">Мои магазины</a><small>(<?=$count_shops?>)</small></h3> 
		<p>Интернет-магазины, оффлайн-магазины, склады, производство
		<h5><a href="/company/edit">Компания</a></h5>
		<?php endif;?>
		<h5><a href="edit/">Личные данные</a></h5>

		<?= HTML::anchor('user/logout', 'Выход'); ?>
	</div> 
	<div class="span3" >
		<div class="row-fluid">
			<div class="span12 inner_right_banner">
				<img src="/images/right_banner.gif" />
			</div>
		</div>
	</div>	
</div>  
    