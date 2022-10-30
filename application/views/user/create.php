<?php /*Form::alert($message,'alert-error')*/?>
<form action="/user/create" method="post">
	
	<label>Имя пользователя:</label>
	<input type="text" name="username" value="<?php echo HTML::chars(Arr::get($_POST, 'username'))?>" />
	<?= Form::important(Arr::get($errors, 'username')); ?></span>
	
	<label>Эл.почта:</label>
	<input type="text" name="email" value="<?php echo HTML::chars(Arr::get($_POST, 'email'))?>" />
	<?= Form::important(Arr::get($errors, 'email')); ?>
	
	<label>Пароль:</label>
	<input type="password" name="password" />
	<?= Form::important(Arr::path($errors, '_external.password')); ?>
	
	<label>Подтверждение пароля:</label>
	<input type="password" name="password_confirm" />
	<?= Form::important(Arr::path($errors, '_external.password_confirm')); ?>
	
	<div class="form-actions">
    	<button type="submit" name="create" class="btn btn-primary">Сохранить</button>
    </div>
</form>        
    