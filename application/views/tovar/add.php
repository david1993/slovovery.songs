<?php /*Form::alert($message,'alert-error')*/?>
    <form method="post" enctype="multipart/form-data" class="span7 form-horizontal" >	
    <?php
    $labels = ORM::factory('tovar')->labels();
    
	if(! isset($values))
    {    	
    	$values = $_POST;
    }
    ?>
	<?= Form::inputHidden('category_id', $category_id, $errors)?>
	<?= Form::field('name', $labels,$values,$errors,'input',true)?>
	<?= Form::field('price', $labels,$values,$errors,'input',true)?>
	<?= Form::field('producer_id', $labels,$producers,$errors,'select',true)?>
	<?= Form::field('description', $labels,$values,$errors,'textarea')?>
	<div class="control-group" >	
		<label class="control-label" >Фотографии:</label>
		<div class="controls" >
			<input type="file" name="images[]" /><br /> 					   
			<input type="file" name="images[]" /><br /> 					   
			<input type="file" name="images[]" /><br /> 					   
			<div style="display: none;" id="add_image"><input type="file" name="images[]"  /><br /></div> 
			<a href="#" class="js add_field_image" >+ еще фотографии</a>
			<?=Form::important(Arr::path($errors, '_external.images'));?>
		</div>	
	</div>
	<div class="control-group" style="margin-bottom:-5px;" >
		<div style="margin-left: 180px;" ><?=Form::important(Arr::path($errors, '_external.url'));?></div>
		<label class="control-label" >Товар представлен в магазинах:</label>
		<div class="controls" >
			<label class="checkbox all"><input type="checkbox"/>Все магазины</label>
		</div>	
	</div>
	<?= Form::field('shop', null,$shops, $errors,'checkboxWithFields')?>	
	<div class="control-group">
				<div class="controls"  >
					<button class="medium_button" type="submit" name="do" ><b>Готово</b></button>
					<a href="/user/tovars/" class="button" > <button class="medium_button" type="button" >Отмена</button></a>
				</div>
			</div>
    </form>
    
        
    