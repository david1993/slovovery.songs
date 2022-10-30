<?php /*Form::alert($message,'alert-error')*/?>
<form method="post" enctype="multipart/form-data" class="span8 form-horizontal" >	
    <?php
    $labels = array('name'=>'Заголовок H1','alt_name'=>'Псевдостатический адрес','content'=>'Контент страницы');
    if(! isset($values))
    {    	
    	$values = $_POST;
    }
    ?>
	<?= Form::field('name', $labels,$values,$errors)?>
	<?= Form::field('alt_name', $labels,$values,$errors,'input',false,false,'double')?>
	<?= Form::field('content', $labels,$values,$errors,'textareaEditable')?>
	<div class="control-group">
		<div class="controls"  >
			<button class="medium_button" type="submit" name="do" value="publish" >Сохранить</button>
		</div>
	</div>
</form>
    
        
    