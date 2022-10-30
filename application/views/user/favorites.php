<div class="row-fluid" >
<div class="span9" >
<?php if(Auth::instance()->logged_in('login')):?>
	<div class="row-fluid">
		<?php if(sizeof($tovars)): ?>
			<div class="span2" ><a class="clr_favorites" href="/user/clear_favorites/" >Очистить избранное</a></div>
		<?php else:?>
			<div class="span2" ><p>Список пуст</p></div>
		<?php endif;?>
	</div>	
	<div class="row-fluid">	
		<div class="span9 pull-float">
	<?php foreach ($tovars as $tovar):?>
		<div class="row-fluid">
				<div class="span3 pull-float">
					<?php $images = $tovar->get_images(); ?>
					<?php if (!empty($images)): ?>
						<img src="/<?=$tovar->get_dir().'/'.$images[0]?>" />
					<?php endif ?>
				</div>
				<div class="span6 pull-float">	
					<h4 class="pull-left" ><a href="/tovar/view/<?=$tovar->id?>"><?=$tovar->name?></a></h4>
					<div class="pull-left">
							<div class="pull-left rate">рейтинг: 
								<b>
									<?php if(is_null($tovar->rate->rate)):?>
										0
									<?php else:?>
										<?= $tovar->rate->rate?>
									<?php endif;?>
								</b>
							</div>
							<div class="pull-left note">отзывов: 
								<b>
									<?php if(is_null($tovar->comments_count)):?>
										0
									<?php else:?>
										<?= $tovar->comments_count?>
									<?php endif;?>
								</b>
							</div>
						</div>
						<div class="clearfix"></div>
					<p><strong><?=$tovar->price?> руб.</strong></p>
					<p><?=$tovar->description?></p>
					<p><a class="rm_favorite" href="/user/remove_from_favorites/<?=$tovar->id?>">Удалить из избранного</a></p>
				</div>
		</div>
	<?php endforeach;?>
		</div>
		<div class="span3 pull-right" >
		</div>
	</div>
<?php else :?>
			<div class="span12" >Чтобы посмотреть избранное, войдите на сайт через свой аккаунт:</div>	
			<div class="clearfix"></div>
			<div class="loginza">
				<a href="https://loginza.ru/api/widget?token_url=<?=Kohana_URL::base(true)?>user/loginza/user/favorites/0&providers_set=vkontakte,facebook,twitter,google,mailru,yandex,openid,livejournal,rambler" ></a>  
			</div>
<?php endif;?>
</div>
<div class="span3" >
	<div class="row-fluid">
			<div class="span12 inner_right_banner">
				<img src="/images/right_banner.gif" />
			</div>
		</div>
</div>
</div>	
