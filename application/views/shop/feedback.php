<?php 
	$send = Arr::get($_GET,'send',0);
	if($send):
?>
	<p>Сообщение успешно отправлено.</p>
	<p><a href="/shop/view/<?=$shop->id?>" >Вернуться на страницу магазина</a></p>
<?php else:?>
	<p>Ваше сообщение будет отправлено менеджеру магазина "<?=$shop->name?>" </p>
	<?php Form::alert($message,'alert-error')?>
		<?php
		$labels = ORM::factory('shop')->feedback_labels();	
		if(! isset($values))
		{    	
			$values = $_POST;
		}
		
		?>
		<form method="post" enctype="multipart/form-data" class="span7 form-horizontal" >	
			<?= Form::field('name', $labels,$values,$errors,'input')?>
			<?= Form::field('phone', $labels,$values,Arr::path($errors, '_external'),'input')?>
			<?= Form::field('email', $labels,$values,Arr::path($errors, '_external'),'input',true)?>
			<?= Form::field('message', $labels,$values,Arr::path($errors, '_external'),'textarea',true)?>
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
        
    