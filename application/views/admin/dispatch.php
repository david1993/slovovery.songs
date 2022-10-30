<?php Form::alert($message,'alert-error')?>
 <?php
	$labels = ORM::factory('dispatch')->labels(); 
		
	if(! isset($values))
	{    	
		$values = $_POST;
	}
	
?>   
<div class="row-fluid" >
	<form action="/admin/dispatch" method="post" class="span5 form-horizontal" >
		<?= Form::field('period', $labels,$values,$errors,'input',true, false, 'double')?>
		<div class="control-group">
				<div class="controls"  >
					<button type="submit" class="medium_button">Сохранить</button>
				</div>
			</div>
	</form>    
</div>