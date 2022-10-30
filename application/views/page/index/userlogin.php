<h4>Вход</h4>
<?php if ($error):?><p style="color:red"><?=$error?></p>
<?php endif;?>
<form action="/" method="post" class="form-horizontal">
    <div class="control-group">
		<label class="control-label" >Логин:</label>
		<div class="controls" >
			<input type="text" name="username"  value="" />
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
			<!-- <a href="/user/forget/">Забыли пароль?</a> -->
		</div>
    </div>
</form> 