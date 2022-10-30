<?php /*Form::alert($message,'alert-error')*/?>
<form action="/user/edit" method="post" class="span7 form-horizontal" >
	 <?php
		$labels = ORM::factory('user')->labels();
		if(! isset($values))
		{    	
			$values = $_POST;
		}
    ?>
	<?= Form::field('email', $labels,$values,$errors,'span')?>
	<?= Form::field('name', $labels,$values,$errors)?>
	<?= Form::field('post', $labels,$values,$errors)?>	
	<?= Form::field('phone', $labels,$values,$errors)?>
	<br />
	<div class="control-group" >	
		<label class="control-label" >Новый пароль:</label>
		<div class="controls" >	
			<input type="password"  name="password" class="span12" />
			<?= Form::important(Arr::path($errors, '_external.password')); ?>
		</div>	
	</div>
	<div class="control-group" >	
		<label class="control-label double" >Подтвердите новый пароль:</label>
		<div class="controls" >	
				<input type="password" name="password_confirm" class="span12" />
				<?= Form::important(Arr::path($errors, '_external.password_confirm')); ?>
		</div>	
	</div>
	<div class="control-group" >	
		<label class="control-label" >Старый пароль:</label>
		<div class="controls" >	
				<input type="password" name="old_password" class="span12" />
				<?= Form::important(Arr::path($errors, '_external.old_password')); ?>
		</div>	
	</div>
	<div class="control-group">
		<div class="controls"  >
			<button class="medium_button" type="submit" name="create" name="do" >Сохранить</button>
		</div>
	</div>
	
</form>    