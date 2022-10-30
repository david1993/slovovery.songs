<div class="row-fluid">
			<div class="span6 pull-left">
				<div class="span8">
					<?=View::factory('rate/view')->set('obj',$shop)->set('model','shop');?>	
				</div>
				<div class="row-fluid">
					<div class="span8 pull-left"><p><?=($shop -> kind_id == 1)?'Магазин':'Интренет-магазин'?> компании <a href="/company/view/<?=$company->id?>"><?=$company->company_name?></a></p></div>
					<div class="span4 pull-left"><a href="/company/view/<?=$company->id?>#shops_list" >другие магазины сети</a></div>
				</div>
				<div class="row-fluid ">
					<div class="span11" >
						<?php if ($shop -> kind_id == 1) :?>
							<p>г.<?=$shop->cities->find()->name?>, <?=$shop->address?></p>
						<?php elseif ($shop -> kind_id == 2) : ?>
							<p><a href="<?=$shop->url?>"><?=$shop->name?></a></p>
						<?php endif; ?>
						<p><?=$shop->phone?></p>
					</div>
					<h5><a href="/shop/feedback/<?=$shop->id?>" >Оправить сообщение</a></h5>
					<div class="clearfix" ></div>
					<p><i><?=$shop->description?></i></p>
				</div>
				<div class="row-fluid">
				<span class="cattree">
						<h4><b>Товар в магазине</b></h4>					
						<ul class="tree">
							<?php $prev_pid = 0; $prev_id = 1; $depth = 0; $flag = TRUE;?>
							<?php foreach ($tree as $node):?>
								
								<?php
								
									if($node['parent_id'] == $prev_id)
									{
										$depth++;
										$flag = TRUE;
									}
									elseif($node['parent_id'] != $prev_pid)
									{
										$depth--;
										$flag = FALSE;
									}
									if ($node['parent_id'] != $prev_pid && $prev_id != 1 && $depth == 1 && $depth == 2 ) {
										echo '</ul></li>';
									}
									if($node['tovars_count']){
										if ($node['rgt'] - $node['lft'] != 1){
											if ($node['parent_id'] != $prev_pid && $flag) { 
												echo '<li><span class="name"><i class="icon-plus"></i>'.$node['name'].' <small>('.$node['tovars_count'].')</small></span><ul class="tree">';
												$flag = TRUE;
											}
											elseif ($flag) {
												echo '<li><span class="name"><i class="icon-plus"></i>'.$node['name'].' <small>('.$node['tovars_count'].')</small></span><ul class="tree">';
												$flag = FALSE;
											}
											else {
												echo '</ul><li><span class="name"><i class="icon-plus"></i>'.$node['name'].' <small>('.$node['tovars_count'].')</small></span><ul class="tree">';
												$flag = FALSE;
											}
										}
										else {
											if ($flag) {
												echo '<li><a href="/category/view/'.$node['id'].'/'.$shop -> id.'">'.$node['name'].'</a> <small>('.$node['tovars_count'].')</small></li>';
											}
											else {
												echo '</ul><li><a href="/category/view/'.$node['id'].'/'.$shop -> id.'">'.$node['name'].'</a> <small>('.$node['tovars_count'].')</small></li>';
												$flag = TRUE;
											}
										}
									}else{
										if ($node['rgt'] - $node['lft'] != 1){
											if (($node['parent_id'] != $prev_pid && $flag) ||($flag)) { 
												echo '<li><ul>';
												$flag = TRUE;
											}
											else {
												echo '</ul><li><ul>';
												$flag = FALSE;
											}
										}
										else {
											if (!$flag) {
												echo '</ul>';
												$flag = TRUE;
											}
										}
									}
									$prev_id = $node['id'];
									$prev_pid = $node['parent_id'];
									
								?>
								
							<?php endforeach;?>
						</ul>
						
				</span>
				</div>
				<div class="row-fluid" >
					<div id="comment">
						<div class="row-fluid" >
							<div class="span4 pull-left" >
								<h4><b>Отзывы</b></h4>
							</div>
							<div class="span3 pull-left" >	
								<a href="#comment_add" class="comment_add">Оставить отзыв</a>
							</div>	
						</div>	
						<div class="comments" >
								<?=$comments?>
								<?=$comment_form?>
						</div>
					</div>
				</div>	
				<div class="clearfix"></div>
				
			</div>
			<div class="span6 pull-left">
				<?php if ($shop -> kind_id == 1) :				
					$images = ORM::factory('shop',$shop->id)->get_images();
					if(sizeof($images)):
				?>
					<div id="tabs" class="row-fluid">
							<div class="row-fluid navig">
								<div class="span3 pull-left header act">
									<a href="">Магазин на карте</a>
								</div>
								<div class="span3 pull-left header noact">	
									<a href="">Фотографии</a>
								</div>
							</div>
							<div class="row-fluid">
								<ul class="tab-content">
									<li class="content" style="display:block;" >
										<div class="row-fluid">
											<div id="map_canvas" ></div>
										</div>
									</li>
									<li class="content" style="display:none;">
										<?php foreach($images as $key => $val):?>
										<div class="img_b" style="display:<?php echo ($key==0)?'block':'none'; ?>" >
											<?=HTML::image('/images/shops/'.$shop->id.'/'.$val);?>
										</div>
										<?php endforeach;?>
									</li>
								</ul>
							</div>
							<div class="row-fluid">
								<?php foreach($images as $key => $val):?>
									<div class="span4 img_s" >
										<?=HTML::image('/images/shops/'.$shop->id.'/'.$val);?>
									</div>
								<?php endforeach;?>
							</div>	
					</div>
					<?php else:?>
						<div id="map_canvas"></div>
					<?php endif;?>
				<?php endif; ?>
				
				<?php if(sizeof($best)):?>
					<div class="row-fluid bests">
						<div class="span12" >
							<h4><b>Лучшие предложения</b></h4>
							<?php foreach($best as $val):?>
							<div class="row-fluid best" >
								
										<?php 
											$images = ORM::factory('tovar',$val['id'])->get_images();
											if($images):
										?>
										<div class="span4 pull-left">
											<?=HTML::image('/images/tovars/'.(round($val['id']/500)+1).'/'.$val['id'].'/'.$images[0]);?>
										</div>
										<?php endif;?>
										<div class="span8 pull-left">
											<div class="row-fluid" ><a href="/tovar/view/<?=$val['id']?>" >"<?=$val['name']?>"</a></div>
											<div class="row-fluid" >
												<div class="pull-left price"><b><?=($val['price_shop'])?$val['price_shop']:$val['price']?> руб.</b>,&nbsp;</div>
												<?php $shop_services =$shop->shopservices->find_all()->as_array();?>
												<div class="pull-left services">
													<?php foreach($shop_services as $key => $service): if($key!=0) echo ', ' ?><?=mb_strtolower($service->name)?><?php endforeach?>
												</div>
											</div>
											<div class="description">
												<?=$val['description']?>
											</div>
										</div>
								
							</div>
							<?php endforeach;?>
						</div>
					</div>
				<?php endif;?>
			</div>
</div>