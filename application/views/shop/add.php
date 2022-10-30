<?php /*Form::alert($message,'alert-error')*/?>
    <form id="formShop" method="post" enctype="multipart/form-data" class="span7 tovar_add form-horizontal" >
	
    <?php
    $labels = ORM::factory('shop')->labels();
    if(! isset($values))
    {    	
    	$values = $_POST;
    }
    ?>
	<?php if ($kind == 1) : ?>
		<?= Form::inputHidden('kind_id', 1, $errors)?>
		<?= Form::inputHidden('lat', '', $errors)?>
		<?= Form::inputHidden('lng', '', $errors)?>
		<?= Form::field('name', $labels, $values, Arr::path($errors, '_external'),'input', true)?>
		<?= Form::field('shoptype', $labels, $shoptypes, $errors, 'select', true)?>
		<?= Form::field('description', $labels, $values, $errors, 'textareaEditable')?>
		<div class="control-group" >	
			<label class="control-label" >Город<b class="text-error">*</b>:</label>
			<div class="controls" >
				<?= Form::select('city',$cities, isset($values['city'])?$values['city']:'',array('class'=>'span12'));?>
				<?= Form::important(Arr::get($errors, 'city'));?>
			</div>	
		</div>
		<?= Form::field('address', $labels, $values, Arr::path($errors, '_external'),'input', true,'например,  <i>Лобачевского, 16</i>')?>
		<div class="control-group" >	
			<div class="controls" >
				<p>Если адрес найден не точно, укажите местоположение вашего магазина на карте.</p>
				<div class="row-bluid"><div id="map_canvas" class="span12" ></div></div>
				<span id="lat" ></span>
				<span id="lng" ></span>
			</div>	
		</div>
		<div class="control-group" >	
			<label class="control-label" >Фотографии:</label>
			<div class="controls" >
				<input type="file" name="images[]" /><br /> 					   
				<input type="file" name="images[]" /><br /> 					   
				<input type="file" name="images[]" /><br /> 					   
				<div style="display: none;" id="add_photo"><input type="file" name="images[]"  /><br /></div> 
				<a href="#" class="js" onClick="jQuery('#add_photo').clone(true).insertBefore(this).show(); return false;">+ еще фотографии</a> 
				<?=Form::important(Arr::path($errors, '_external.images'));?>
			</div>	
		</div>
		<?= Form::field('shopservice', $labels, $shopservices, $errors, 'checkbox');?>
		<?= Form::field('phone', $labels, $values, Arr::path($errors, '_external'),'input', true)?>
		<?= Form::field('email', $labels, $values, Arr::path($errors, '_external'),'input', true, false,'double')?>
	<?php elseif ($kind == 2) : ?>
		<?= Form::inputHidden('kind_id', 2, $errors)?>
		<?= Form::field('name', $labels, $values, Arr::path($errors, '_external'),'input', true)?>
		<?= Form::field('url', $labels, $values, Arr::path($errors, '_external'),'input', true);?>
		<?= Form::field('description', $labels, $values, $errors,'textareaEditable')?>
		<?= Form::field('city', $labels, $cities, Arr::path($errors, '_external'), 'selectMultiple', true);?>
		<?= Form::field('shopservice', $labels, $shopservices, $errors, 'checkbox');?>
		<?= Form::field('phone', $labels, $values, Arr::path($errors, '_external'),'input', true)?>
		<?= Form::field('email', $labels, $values, Arr::path($errors, '_external'),'input', true, false,'double')?>
	<?php endif; ?>
	<div class="control-group">
		<div class="controls"  >
			<button class="medium_button" type="submit" name="do" value="publish" ><b>Готово</b></button>
			<a href="/user/shops/" class="button" > <button class="medium_button" type="button" >Отмена</button></a>
		</div>
	</div>
    </form>
    
        
    