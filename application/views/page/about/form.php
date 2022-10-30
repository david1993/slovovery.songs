<div class="row-fluid" > 
	<?php Form::alert($message,'alert-error')?>
</div> 
<div class="row-fluid" > 
		<form method="post" enctype="multipart/form-data" class="span7 form-horizontal" id="feedback" >	
			<?php
				$labels = ORM::factory('page')->feedback_labels();
				if(!isset($values))
				{    	
					$values = $_POST;
				}
			?>
			
			<h3><b>Свяжитесь с нами</b></h3>
			<?= Form::field('name', $labels,$values,$errors,'input')?>
			<?= Form::field('phone', $labels,$values,$errors,'input')?>
			<?= Form::field('email', $labels,$values,$errors['_external'],'input',true)?>
			<?= Form::field('message', $labels,$values,$errors['_external'],'textarea',true)?>
			<div class="control-group">
				<label class="control-label ">Введите текст с картинки<b class="text-error">*</b>:</label>
				<div class="controls">
					<input type="text" value="" class="span12" name="captcha">
					<?=Form::important(Arr::get($captcha_error, 'captcha'))?>
					<?=$captcha?>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="control-group">
				<div class="controls" >
					<button type="submit" name="do" class="medium_button" >Отправить</button>
				</div>
			</div>
			<div class="clearfix"></div>
		</form>
</div>