<?php Form::alert($message,'alert-error')?>
<div class="row-fluid">
<form action="/admin/settings" method="post" class="span7 form-horizontal" >
		<div class="control-group"  >
			<label class="control-label" >E-mail администратора<b class="text-error">*</b>:</label>
			<div class="controls" >
				<input type="email"  name="email" class="span8" value="<?=$values['email']?>">
				<?= Form::important(Arr::path($errors, 'email')); ?>
			</div>	
		</div>
		<div class="control-group"  >
			<label class="control-label" >Имя менеджера<b class="text-error">*</b>:</label>
			<div class="controls" >
				<input type="text"  name="username" class="span8" value="<?=$values['name']?>" />
				<?= Form::important(Arr::path($errors, 'name')); ?>
			</div>	
		</div>
		<div class="control-group"  >
			<label class="control-label" >Телефон менеджера<b class="text-error">*</b>:</label>
			<div class="controls" >
				<input type="text"  name="phone" class="span8" value="<?=$values['phone']?>" />
				<?= Form::important(Arr::path($errors, '_external.phone')); ?>
			</div>	
		</div>
		
		<div class="control-group">
			<div class="controls"  >
				<button type="submit" name="create" class="medium_button">Сохранить</button>
			</div>
		</div>
</form>    
</div>