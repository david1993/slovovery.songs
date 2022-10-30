<?php /*Form::alert($message,'alert-error')*/ ?>
<form method="post" enctype="multipart/form-data" class="span7 form-horizontal" >	
    <?php
    $labels = array('name'=>'Название');
    if(! isset($values))
    {    	
    	$values = $_POST;
    }
    ?>
	<?= Form::field('name', $labels,$values,$errors)?>
	<div class="control-group">
		<div class="controls"  >
			<button class="medium_button" type="submit" name="do" value="publish" >Сохранить</button>
		</div>
	</div>
	
</form>