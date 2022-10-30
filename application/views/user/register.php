
<form action="/user/register" method="post" id="registration" class="span7 form-horizontal">
	 <?php
    $labels = ORM::factory('user')->labels();
    if(! isset($values))
    {    	
    	$values = $_POST;
    }
    ?>
	<p><i>Зарегистрируйтесь для размещения ваших предложений на mebelboom.com</i></p>
	<?= Form::field('company_name', $labels,$values,Arr::path($errors, '_external'),'input',TRUE)?>
	<input type="hidden" id="username" name="username" class="span6" value="<?php echo HTML::chars(Arr::get($_POST, 'username'))?>" />
	
	<div class="control-group">
		<label class="control-label" >E-mail<b class="text-error">*</b>:</label>
		<div class="controls" >
			<input type="text" name="email" class="span12" value="<?php echo HTML::chars(Arr::get($_POST, 'email'))?>" onchange="document.getElementById('username').value=this.value;" />
			<?= Form::important(Arr::get($errors, 'email')); ?>
			<?= Form::important(Arr::path($errors, '_external.email')); ?>
		</div>
    </div>
	<div class="control-group" >
		<label class="control-label" >Пароль<b class="text-error">*</b>:</label>
		<div class="controls" >
			<input type="password" name="password" class="span12"/>
			<?= Form::important(Arr::path($errors, '_external.password')); ?>
		</div>	
	</div>
	<div class="control-group" >
		<label class="control-label" >Подтверждение пароля<b class="text-error">*</b>:</label>
		<div class="controls" >
			<input type="password" name="password_confirm" class="span12"/>
			<?= Form::important(Arr::path($errors, '_external.password_confirm')); ?>
		</div>	
	</div>
	<?= Form::field('name', $labels,$values,$errors)?>
	<?= Form::field('phone', $labels,$values,$errors)?>
	<div class="control-group">
		<div class="controls"  >
			<button type="submit" name="create" class="medium_button" >Готово</button>
		</div>
    </div>
</form>        
    