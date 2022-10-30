<div class="row-fluid">
	<div class="span9">
<?php Form::alert($message,'alert-error')?>

<form action="/user/login" method="post" class="form-horizontal">
    <div class="control-group">
		<label class="control-label" >Email:</label>
		<div class="controls" >
			<input type="text" name="username"  value="<?php echo HTML::chars(Arr::get($_POST, 'username'))?>" />
		</div>
    </div>
    <div class="control-group">
		<label class="control-label" >Пароль:</label>
		<div class="controls" >
			<input type="password" name="password"  />
		</div>
    </div>
    <div class="control-group">
		<div class="controls" >
			<button type="submit">Войти</button>
			<a href="/user/forget/">Забыли пароль?</a>
		</div>
    </div>
</form> 
 
 
 <p class="large">У вас нет аккаунта продавца?</p>
 <p><a href="/user/register/"><b>Зарегистрируйтесь</b></a>, чтобы разместить свои предложения на mebelboom.com</p>
</div> 
<div class="span3" >
	<div class="row-fluid">
			<div class="span12 inner_right_banner">
				<img src="/images/right_banner.gif" />
			</div>
		</div>
</div> 
</div>
    