<?php 
	$send = Arr::get($_GET,'send',0);
	if($send):
?>
	<p>Заказ успешно отправлен.</p>
	<p><a href="/tovar/view/<?=$tovar->id?>" >Вернуться на страницу товара</a></p>
<?php else:?>
	<p>Ваш заказ будет отправлен менеджеру компании-продавца по электронной почте. </p>
	<?php Form::alert($message,'alert-error')?>
		<?php
		$labels = ORM::factory('tovar')->order_labels();	
		if(! isset($values))
		{    	
			$values = $_POST;
		}
		
		?>
		<form method="post" enctype="multipart/form-data" class="span7 form-horizontal" >	
			<div class="control-group link" >
				<label class="control-label" >Компания:</label>
				<div class="controls" >
					<span><a href="/company/view/<?=$company->id?>" ><?=$company->company_name?></a></span>
					<input type="hidden" name="company_id" value="<?=$company->id?>" />
				</div>	
			</div>
			<div class="control-group link" >
				<label class="control-label" >Магазин:</label>
				<div class="controls" >
					<span><a href="/shop/view/<?=$shop->id?>" ><?=$shop->name?></a></span>
					<input type="hidden" name="shop_id" value="<?=$shop->id?>" />
				</div>	
			</div>
			<div class="control-group link" >
				<label class="control-label" >Продукт:</label>
				<div class="controls" >
					<span><a href="/tovar/view/<?=$tovar->id?>" ><?=$tovar->name?></a></span>
					<input type="hidden" name="tovar_id" value="<?=$tovar->id?>" />
				</div>	
			</div>
			<?= Form::field('name', $labels,$values,$errors,'input')?>
			<?= Form::field('phone', $labels,$values,Arr::path($errors, '_external'),'input',true)?>
			<?= Form::field('email', $labels,$values,Arr::path($errors, '_external'),'input',true)?>
			<?= Form::field('add', $labels,$values,$errors,'textarea')?>
			<div class="control-group">
				<label class="control-label ">Введите текст с картинки<b class="text-error">*</b>:</label>
				<div class="controls">
					<input type="text" value="" class="span12" name="captcha">
					<?=Form::important(Arr::get($captcha_error, 'captcha'))?>
					<?=$captcha?>
				</div>
			</div>
			<div class="control-group">
				<div class="controls"  >
					<button type="submit" name="do" class="medium_button" >Отправить</button>
				</div>
			</div>
		</form>
<?php endif;?>
        
    