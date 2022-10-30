<?php /*Form::alert($message,'alert-error')*/?>
<p><a href="/tovar/view/<?=$tovar -> id?>" target="_blank">Открыть страницу товара</a></p>

<ul class="nav nav-tabs">
	<li class="active">
		<a href="#tab1" data-toggle="tab">Описание товара</a>
	</li>
	<li>
		<a href="#tab2" data-toggle="tab">Статистика</a>
	</li>
</ul>
<div class="tab-content">
	<div class="tab-pane active" id="tab1">
    <form method="post" enctype="multipart/form-data" class="span7 form-horizontal" >	
    <?php
    $labels = ORM::factory('tovar')->labels();
    
	if(! isset($values))
    {    	
    	$values = $_POST;
		
    }
	
    ?>
	
	
	<?= Form::field('name', $labels,$values,$errors,'input',true)?>
	<?= Form::field('price', $labels,$values,$errors,'input',true)?>
	<div class="control-group"  >
		<label class="control-label" >Страна-производитель<b class="text-error">*</b>:</label>
		<div class="controls" >
			<?=Form::select('producer_id', $producers, $values['producer_id'], array('class' => 'span12'));?>
		</div>	
	</div>
	<?= Form::field('description', $labels,$values,$errors,'textarea')?>
	<div class="control-group" >
		<label class="control-label" >Фотографии:</label>
		<div class="controls" >
				<?php if($images):?>
				<div class="row-fluid images">
					<?php foreach($images as $image):?>
						<div class="span4 image">
							<?=HTML::image(Model_Tovar::MINI_PIC_PATH.$tovar->get_dir().'/'.$image);?>
							<input type="radio" name="firstImg" value="<?=$image?>"<?php 
							if(isSet($firstImg) && $firstImg==$image) echo 'checked="checked"';
								
								
								?>/> Главное изображение<br>
							<a href="/tovar/remove_image/<?=$tovar->id?>/?image=<?=$image?>" class="rm_image">Удалить</a>
						</div>
					<?php endforeach?>
				</div>
				<?php endif?>	
			<input type="file" name="images[]" /><br /> 					   
			<div style="display: none;" id="add_photo"><input type="file" name="images[]"  /><br /></div> 
			<a href="#" class="js add_field_image" onClick="jQuery('#add_photo').clone(true).insertBefore(this).show(); return false;">+ еще фотографии</a>
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
	<?php
		if(!isset($_POST['shop']))
		{	echo '<div class="control-group" ><div class="controls" >';
			foreach ($shops as $key => $shop){
				echo '<label class="checkbox"><input type="checkbox" name="shop[]" value="'.$key.'" '.$shop['check'].' /><b>'.$shop['name'].'</b>  '.$shop['address'].'</label>';
				echo '<div class="dopfields">';
					
				$val = sizeof($shop['info'])?$shop['info']['url']:'';
				if($shop['kind_id']==2) echo '<div class="control-group link" ><label class="control-label" >URL страницы товара:</label><div class="controls" ><input class="subfield" type="text" name="url['.$key.']" value="'.$val.'"></div></div>';
					
				$val = (sizeof($shop['info']))?$shop['info']['price']:'';
				echo '<div class="control-group link" ><label class="control-label" >Цена в магазине:</label><div class="controls" ><input class="subfield price_shop" type="text" name="price_shop['.$key.']" value="'.$val.'"></div></div></div>';		
			}
			echo '</div></div>';
		}
		else
		{
			echo Form::field('shop', null,$shops, $errors,'checkboxWithFields');
		}
	?>
	<div class="control-group">
				<div class="controls"  >
					<button type="submit" name="do" value="draft" class="medium_button"><b>Сохранить</b></button>
					<a href="/user/tovars/" class="button" > <button class="medium_button" type="button" >Отмена</button></a>
				</div>
			</div>
    </form>
    </div>
	<div class="tab-pane" id="tab2">
		<p>Здесь будет размещаться информация о просмотрах</p>
	</div>
</div>
        
    