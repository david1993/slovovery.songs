<form method="post" enctype="multipart/form-data" class="span7 form-horizontal" >	
    <?php
    $labels = ORM::factory('user')->feedback_labels();
    
	if(!isset($values))
    {    	
    	$values = $_POST;
    }
	
    ?>
	<p>Ваш менеджер: <i><?=$manager['username']?></i></p>
	<p>Ответ на сообщение вы получите по электронной почте</p>
	<?=Form::inputHidden('seller',$values['seller'],$errors)?>
	<?=Form::inputHidden('email',$values['email'],$errors)?>
	<?= Form::field('theme', $labels,$values,$errors['_external'],'input',true)?>
	<?= Form::field('message', $labels,$values,$errors['_external'],'textarea',true)?>
	<div class="control-group">
		<div class="controls"  >
			<button type="submit" name="do" class="medium_button" >Отправить</button>
		</div>
	</div>
</form>   