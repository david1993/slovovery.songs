<?php Form::alert($message,'alert-error')?>
<div class="row-fluid">
	<form action="/admin/access" method="post" class="span7 form-horizontal" >
			<div class="control-group"  >
				<label class="control-label" >Новый пароль:</label>
				<div class="controls" >
					<input type="password"  name="password" class="span8" />
					<?= Form::important(Arr::path($errors, '_external.password')); ?>
				</div>	
			</div>
			<div class="control-group"  >
				<label class="control-label double" >Подтвердите новый пароль:</label>
				<div class="controls" >
					<input type="password" name="password_confirm" class="span8" />
					<?= Form::important(Arr::path($errors, '_external.password_confirm')); ?>
				</div>	
			</div>
			<div class="control-group"  >
				<label class="control-label" >Старый пароль:</label>
				<div class="controls" >
					<input type="password" name="old_password" class="span8" />
					<?= Form::important(Arr::path($errors, '_external.old_password')); ?>
				</div>	
			</div>
			<div class="control-group">
				<div class="controls"  >
					<button type="submit" name="create" class="medium_button">Сохранить</button>
				</div>
			</div>
	</form>    
</div>