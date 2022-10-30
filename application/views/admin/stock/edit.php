<?php Form::alert($message,'alert-error')?>
<form method="post" enctype="multipart/form-data" class="span8 form-horizontal" >	
    <?php
    $labels = ORM::factory('stock')->mod_labels(); 
	$statuses = ORM::factory('stock')->statuses();
    
	if(! isset($values))
    {    	
    	$values = $_POST;
    }
	
    ?>
	<?= Form::field('name', $labels,$values,$errors,'input',true)?>
	<div class="control-group" >	
		<label class="control-label" >Статус<b class="text-error">*</b>:</label>
		<div class="controls" >
			<?= Form::select('status_id',array_slice($statuses, 2, 3, true),$values['status_id'], array('class' => 'span12'))?>
		</div>	
	</div>
	<?= Form::field('reject_reason', $labels,$values,$errors,'textareaEditable')?>
	
	<div class="control-group">
		<div class="controls"  >
			<button class="medium_button" type="submit"  ><b>Сохранить</b></button>
			<a href="/admin/stock/" class="button" > <button class="medium_button" type="button" >Отмена</button></a>
		</div>
	</div>
</form>
    
        
    