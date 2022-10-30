<div class="row-fluid" >
<div class="span12">
	<div class="row-fluid" >
		<div class="span9 pull-left">
			<div class="row-fluid" >
				<?php if($images):?>
				<div class="span6 pull-left">
						<?php foreach($images as $key => $image):
								if($image==$firstImg):?>
									<div class="image_f">
										<?=HTML::image('/images/tovars/mini/'.(round($tovar->id/500)+1).'/'.$tovar->id.'/'.$image);?>
									</div>
								<?php endif?>
						<?php endforeach?>
						<div class="row-fluid" >
						<?php foreach($images as $key => $image):?>
								<?php if($image!=$firstImg):?>
									<div class="span4 image">
										<?=HTML::image('/images/tovars/mini/'.(round($tovar->id/500)+1).'/'.$tovar->id.'/'.$image);?>
									</div>
								<?php endif?>
						<?php endforeach?>
						</div>
				</div>
				<?php endif?>				
					<div class="images_big"  >
						<div class="close"></div>
						<?php foreach($images as $key => $image):?>
							<div class="image">
								<?=HTML::image('/images/tovars/'.(round($tovar->id/500)+1).'/'.$tovar->id.'/'.$image, array('width' => '600'));?>
							</div>
						<?php endforeach?>
					</div>
				
				<div class="span6 pull-left">
					<p class="price"><b><?=$tovar->price?> руб.</b></p>
					<p class="description"><?=$tovar->description?></p>
					<?=View::factory('rate/view')->set('obj',$tovar)->set('model','tovar');?>
					<?php if(Auth::instance()->logged_in('login')):?>
						<p>
							<?php if($tovar->is_favorite()):?>
								<a class="tofavorites" href="/user/favorites/">В избранном</a>
							<?php else: ?>
								<a class="tofavorites" href="/tovar/tofavorites/<?=$tovar->id?>">Добавить в избранное</a>
							<?php endif;?>
						</p>
					<?php else:?>	
						
						<p>После авторизации вы сможете добавить товар в избранное</p>
						<div class="loginza">
							<a href="https://loginza.ru/api/widget?token_url=<?=Kohana_URL::base(true)?>user/loginza/tovar/view/<?=$tovar->id?>&providers_set=vkontakte,facebook,twitter,google,mailru,yandex,openid,livejournal,rambler" ></a>  
						</div>
					<?php endif;?>
				</div>
			</div>
			<div class="clearfix"></div>
			<?php if(sizeof($shops)):?>
			<div class="shops">
			<div class="row-fluid">
				<h4><b>Где купить</b></h4>
				<?php foreach($shops as $shop):?>
				<div class="row-fluid" >
					<div class="shop" >
						<?php $shop_obj = ORM::factory('shop',$shop['shop_id']);?>
						<div class="row-fluid" >
							<div class="span5 pull-left">
								<a href="/shop/view/<?=$shop_obj->id?>" class="pull-left name">"<?=$shop_obj->name?>"</a> 
								<span class="pull-left kind">(<?=mb_strtolower($shop['name'])?>)</span>
							</div>
							<div class="span5 pull-left">
								<span class="pull-left price"><b><?=($shop['price'])? $shop['price'].' руб.,&nbsp;':''?></b></span>
								<?php $shop_services =$shop_obj->shopservices->find_all()->as_array();?>
								<span class="services">
									<?php foreach($shop_services as $key => $service): if($key!=0) echo ', ' ?><?=mb_strtolower($service->name)?><?php endforeach?>
								</span>
							</div>
							<div class="span2 pull-right" >
								<a class="pull-right" href="/tovar/order/<?=$tovar->id?>/<?=$shop_obj->id?>">Отправить заказ</a>
								<a class="pull-right" href="/tovar/question/<?=$tovar->id?>/<?=$shop_obj->id?>">Задать вопрос</a>
							</div>
							<div class="row-fluid">
								<div class="span8">
									<?php if($shop_obj->kind_id == 1):?>
										<span class="contacts">Телефон: <?=$shop_obj->phone?>; Адрес: <?=$shop_obj->address?> </span>
									<?php else:?>
										<span><a class="url" href="<?=$shop['url']?>">Страница товара в интернет-магазине</a></span>
									<?php endif?>
								</div>
							</div>
						</div>
					</div>
				</div>	
				<?php endforeach?>
				</div>
			</div>
			<?php endif?>
			<div class="row-fluid" >
				<div id="comment">
					<div class="row-fluid" >
						<div class="span2 pull-left" >
							<h4><b>Отзывы</b></h4>
						</div>
						<div class="span3 pull-left" >	
							<a href="#comment_add" class="comment_add">Оставить отзыв</a>
						</div>	
					</div>	
						<div class="comments" >
							<?=$comments?>
							<div class="row-fluid" >
								<div class="span8" >
									<?=$comment_form?>
								</div>
							</div>
						</div>
				</div>
			</div>	
			<div class="clearfix"></div>
		</div>
		<div class="span3">
			<?php if(sizeof($tovars_similar)):?>
						<h5 class="fon" >Близко по цене:</h5>
						<?php foreach($tovars_similar as $tovar_s):?>
						<div class="row-fluid" >
							<div class="span10 pull-center">
								<?php $image = $tovar_s->get_images(1);?>
								<a href="/tovar/view/<?=$tovar_s->id?>" ><?=(sizeof($image))?HTML::image('/images/tovars/mini/'.(round($tovar_s->id/500)+1).'/'.$tovar_s->id.'/'.$image[0]):'';?></a>
								<div><a href="/tovar/view/<?=$tovar_s->id?>" ><?=$tovar_s->name?></a></div>
								<div><strong><?=$tovar_s->price?> руб.</strong></div>
							</div>
						</div>
						<?php endforeach?>
			<?php endif?>
		</div>
	</div>
</div>
</div>