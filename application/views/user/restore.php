<?php Form::alert($message,'alert-error')?>
 
<?if(!$message){ ?>
	<p><?=$notice?></p>
	<p>Логин:<?=$username?></p>
	<p>Пароль:<?=$new_password?></p>
<?}?>