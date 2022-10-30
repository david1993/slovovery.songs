<div class="row-fluid"  >
<?php /*Form::alert($message,'alert-error')*/?>
<p>
	<?=$shop->kind->name?>,
	<?php
		if ($shop->kind_id == 1) echo $shop->address;
		else if ($shop->kind_id == 2) echo $shop->url;
	?>
</p>
<p><?php if ($shop -> kind_id == 1) :?>
			<a href="/shop/view/<?=$shop -> id?>" target="_blank">Открыть страницу магазина</a>
		<?php elseif ($shop -> kind_id == 2) : ?>
			<a href="<?=$shop -> url?>" target="_blank">Открыть страницу магазина</a>
		<?php endif; ?></p>
<ul class="nav nav-tabs">
	<li class="active">
		<a href="#tab1" data-toggle="tab">Товары в магазине</a>
	</li>
	<li>
		<a href="#tab2" data-toggle="tab">Описание магазина</a>
	</li>
</ul>
<div class="tab-content">
	<div class="tab-pane active" id="tab1">
		<p>Отметьте галочками товары, которые имеются в наличии в этом магазине.<br />
		Вы можете выделить до 8 товаров как "Лучшие предложения".</p>
		<?=Form::important(Arr::path($errors, '_external.url'));?>
		<?=Form::important(Arr::path($errors, '_external.best'));?>
		<form method="post" enctype="multipart/form-data">
		<label class="checkbox" id="all">
			<input type="checkbox">
			Все товары в наличии в этом магазине
		</label>
		<div class="clearfix" ></div>
		<div class="row-fluid" >
		<span class="span12 cattree">		
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
								//if($node['tovars_count']){
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
											echo '<li><span class="name"><i class="icon-plus"></i>'.$node['name'].' <small>('.$node['tovars_count'].')</small></li><div class="tovars">';
												if(isset($tovars[$node['id']]))
													foreach($tovars[$node['id']] as $tovar)
													{ 
														if(isset($_POST['exist']))
														{
															echo '<div class="row-fluid" ><div class="span4"><input class="exist pull-left" type="checkbox" name="exist['.$tovar['id'].']" value="'.$tovar['id'].'" '.(isset($_POST['exist'])&&isset($_POST['exist'][$tovar['id']])? 'checked':'').' /><div class="span11"><label>'.$tovar['name'].'</label></div></div><div class="span5"><label class="pull-left" >Цена в магазине:</label></div><input class="span7" type="text" name="price['.$tovar['id'].']" value="'.($_POST['price'][$tovar['id']]?$_POST['price'][$tovar['id']]:'').'" />';
															if($shop->kind_id == 2) echo '<div class="clearfix"></div><label class="pull-left" >URL страницы товара:</label></div><input class="span7" type="text" name="url['.$tovar['id'].']" value="'.($_POST['url'][$tovar['id']]?$_POST['url'][$tovar['id']]:'').'" /></div>'; else echo '</div>';
															echo '<div class="span3"><input class="normal pull-left" type="checkbox" name="best['.$tovar['id'].']" value="1" '.(isset($_POST['best'])&&isset($_POST['best'][$tovar['id']])? 'checked':'').' /><label>Лучшее предложение</label></div></div>';
														}
														else
														{
															echo '<div class="row-fluid" ><div class="span4" ><input class="exist pull-left" type="checkbox" name="exist['.$tovar['id'].']" value="'.$tovar['id'].'" '.(($tovar['shop_id']==$shop->id)? 'checked':'').' /><div class="span11"><label>'.$tovar['name'].'</label></div></div><div class="span5"><label class="pull-left" >Цена в магазине:</label><input class="span7" type="text" name="price['.$tovar['id'].']" value="'.($tovar['price']?$tovar['price']:'').'" />';
															if($shop->kind_id == 2) echo '<div class="clearfix"></div><label class="pull-left" >URL страницы товара:</label><input class="span7" type="text" name="url['.$tovar['id'].']" value="'.$tovar['url'].'" /></div>'; else echo '</div>';
															echo '<div class="span3"><input class="normal pull-left" type="checkbox" name="best['.$tovar['id'].']" value="1" '.($tovar['best']? 'checked':'').' /><label>Лучшее предложение</label></div></div>';
														}
													}
											echo '</div>';
										}
										else {
											echo '</ul><li><span class="name"><i class="icon-plus"></i>'.$node['name'].' <small>('.$node['tovars_count'].')</small></li><div class="tovars">';
												if(isset($tovars[$node['id']]))
													foreach($tovars[$node['id']] as $tovar)
													{ 
														if(isset($_POST['exist']))
														{
															echo '<div class="row-fluid" ><div class="span4"><input class="exist pull-left" type="checkbox" name="exist['.$tovar['id'].']" value="'.$tovar['id'].'" '.(isset($_POST['exist'])&&isset($_POST['exist'][$tovar['id']])? 'checked':'').' /><div class="span11"><label>'.$tovar['name'].'</label></div></div><div class="span5"><label class="pull-left" >Цена в магазине:</label><input class="span7" type="text" name="price['.$tovar['id'].']" value="'.($_POST['price'][$tovar['id']]?$_POST['price'][$tovar['id']]:'').'" />';
															if($shop->kind_id == 2) echo '<div class="clearfix"></div><label class="pull-left" >URL страницы товара:</label><input class="span7" type="text" name="url['.$tovar['id'].']" value="'.($_POST['url'][$tovar['id']]?$_POST['url'][$tovar['id']]:'').'" /></div>'; else echo '</div>';
															echo '<div class="span3"><input class="normal pull-left" type="checkbox" name="best['.$tovar['id'].']" value="1" '.(isset($_POST['best'])&&isset($_POST['best'][$tovar['id']])? 'checked':'').' /><label>Лучшее предложение</label></div></div>';
														}
														else
														{
															echo '<div class="row-fluid" ><div class="span4"><input class="exist pull-left" type="checkbox" name="exist['.$tovar['id'].']" value="'.$tovar['id'].'" '.(($tovar['shop_id']==$shop->id)? 'checked':'').' /><div class="span11"><label>'.$tovar['name'].'</label></div></div><div class="span5"><label class="pull-left" >Цена в магазине:</label><input class="span7" type="text" name="price['.$tovar['id'].']" value="'.($tovar['price']?$tovar['price']:'').'" />';
															if($shop->kind_id == 2) echo '<div class="clearfix"></div><label class="pull-left" >URL страницы товара:</label><input class="span7" type="text" name="url['.$tovar['id'].']" value="'.$tovar['url'].'" /></div>'; else echo '</div>';
															echo '<div class="span3"><input class="normal pull-left" type="checkbox" name="best['.$tovar['id'].']" value="1" '.($tovar['best']? 'checked':'').' /><label>Лучшее предложение</label></div></div>';
														}
													}
											echo '</div>';
											$flag = TRUE;
										}
									}
								$prev_id = $node['id'];
								$prev_pid = $node['parent_id'];
								
							?>
							
						<?php endforeach;?>
					</ul>
			</span>		
			</div>
			<div class="control-group">
				<div class="controls"  >
					<button type="submit" name="do" value="catalog_edit" class="medium_button"><b>Сохранить</b></button>
					<a href="/user/shops/" class="button" > <button class="medium_button" type="button" >Отмена</button></a>
				</div>
			</div>
    </form>
	<p><a href="/user/tovars/">Добавить товары</a></p>
	</div>
	<div class="tab-pane" id="tab2">
		<form id="formShop" method="post" enctype="multipart/form-data" class="span7 form-horizontal" >
			 <?php
				$labels = ORM::factory('shop')->labels();
				$values = $shop->as_array();
				
				if(! isset($values))
				{    	
					$values = $_POST;
				}
				
			?>
			<?php
				if ($shop -> kind_id == 1) :
				$shoptype = $shop->shoptypes->find()->as_array();
				$city = $shop->cities->find()->as_array();
			?>
				<?=Form::inputHidden('kind_id', 1, $errors)?>
				<?=Form::inputHidden('lat',$values['lat'], $errors)?>
				<?=Form::inputHidden('lng',$values['lng'], $errors)?>
				<?=Form::field('name', $labels,$values,Arr::path($errors, '_external'),'input', true)?>
				<div class="control-group"  >
					<label class="control-label" >Тип магазина<b class="text-error">*</b>:</label>
					<div class="controls" >	
						<?=Form::select('shoptype', $shoptypes, (isset($shoptype['id'])) ? $shoptype['id'] : null, array('class'=>'span12'));?>
					</div>	
				</div>
				<?=Form::field('description', $labels,$values,$errors,'textareaEditable')?>
				<div class="control-group" >	
					<label class="control-label" >Город<b class="text-error">*</b>:</label>
					<div class="controls" >
						<?=Form::select('city', $cities, (isset($city['id'])) ? $city['id'] : null, array('class'=>'span12'));?>
						<?= Form::important(Arr::get($errors, 'city'));?>
					</div>	
				</div>
				<?=Form::field('address', $labels,$values,Arr::path($errors, '_external'),'input', true,'например,  <i>Лобачевского, 16</i>')?>
				<div class="control-group" >	
					<div class="controls" >
						<p>Если адрес найден не точно, укажите местоположение вашего магазина на карте.</p>
						<div class="row-fluid"><div id="map_canvas" class="span12" ></div></div>
						<span id="lat" ><?php (isset($values['lat'])) ? "X:".$values['lat']:"" ?></span>
						<span id="lng" ><?php (isset($values['lng'])) ? "Y:".$values['lng']:"" ?></span>
					</div>	
				</div>
				<div class="control-group" >	
					<label class="control-label" >Фотографии:</label>
					<div class="controls" >
						<?php if($images):?>
							<div class="row-fluid images">
								<?php foreach($images as $image):?>
									<div class="span4 image">
										<?=HTML::image('/images/shops/mini/'.$shop->id.'/'.$image);?>
										<a href="/shop/remove_image/<?=$shop->id?>/?image=<?=$image?>" class="rm_image">Удалить</a>
									</div>
								<?php endforeach?>
							</div>
						<?php endif?>		
						<input type="file" name="images[]" /><br /> 					   
						<div style="display: none;" id="add_photo"><input type="file" name="images[]"  /><br /></div> 
						<a href="#" class="js" onClick="jQuery('#add_photo').clone(true).insertBefore(this).show(); return false;">+ еще фотографии</a> 
						<?=Form::important(Arr::path($errors, '_external.images'));?>
					</div>	
				</div>
				<div class="control-group" >	
					<label class="control-label" >Услуги:</label>
					<div class="controls" >
						<?php
							foreach($shopservices as $id =>$shopservice){
								echo '<label class="checkbox"><input type="checkbox" name="shopservice[]" value="'.$id.'"'.($shopservice['check'] ? 'checked':'').' />'.$shopservice['name'].'</label>';
							}
						?>
					</div>	
				</div>
				<?=Form::field('phone', $labels, $values, Arr::path($errors, '_external'),'input', true)?>
				<?=Form::field('email', $labels,$values,Arr::path($errors, '_external'),'input', true, false,'double')?>
			<?php elseif ($shop -> kind_id == 2) : 
				$shoptype = $shop->shoptypes->find_all()->as_array();
				$city = $shop->cities->find_all()->as_array();
			?>
				<?=Form::inputHidden('kind_id', 2, $errors)?>
				<?=Form::field('name', $labels, $values, Arr::path($errors, '_external'),'input', true)?>
				<?=Form::field('url', $labels, $values, Arr::path($errors, '_external'),'input', true);?>
				<?=Form::field('description', $labels, $values, $errors,'textareaEditable')?>
				
				<div class="control-group" >	
					<label class="control-label" >Город<b class="text-error">*</b>:</label>
					<div class="controls" >
						<?=Form::select('city[]', $cities, (isset($city)) ? $city : null);?>
					</div>	
				</div>
				<div class="control-group" >	
					<label class="control-label" >Услуги:</label>
					<div class="controls" >
						<?php
							foreach($shopservices as $id =>$shopservice){
								echo '<label class="checkbox"><input type="checkbox" name="shopservice[]" value="'.$id.'"'.($shopservice['check'] ? 'checked':'').' />'.$shopservice['name'].'</label>';
							}
						?>
					</div>	
				</div>
				<?=Form::field('phone', $labels, $values, Arr::path($errors, '_external'),'input', true)?>
				<?= Form::field('email', $labels, $values, Arr::path($errors, '_external'), 'input', true, false,'double')?>
			<?php endif; ?>
			<div class="control-group">
				<div class="controls"  >
					<button type="submit" name="do" value="shop_edit" class="medium_button"><b>Сохранить</b></button>
					<a href="/user/shops/" class="button" > <button class="medium_button" type="button" >Отмена</button></a>
				</div>
			</div>
		</form>	
	</div>
</div>
</div>