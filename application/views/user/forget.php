<?php Form::alert($message,'alert-error')?>
 
<form action="/user/forget" method="post" class="form-horizontal" >
	<div class="control-group" >	
		<label class="control-label double" >Укажите e-mail, который вводился при регистрации:</label>
		<div class="controls" >
			<input type="text" name="email" value="" />
		</div>	
	</div>
	<div class="control-group">
		<div class="controls"  >
			<button type="submit" name="login" class="medium_button">Отправить</button>
		</div>
	</div>
</form>