<?php /*Form::alert($message,'alert-error')*/?>

<p><a href="/company/view/<?=$company_id?>" target="_blank">Открыть страницу компании</a></p>

<form action="/company/edit" method="post" class="span7 form-horizontal" >
	 <?php
		$labels = ORM::factory('company')->labels();
		
		if(! isset($values))
		{    	
			$values = $_POST;
		}
    ?>
	<?=Form::field('company_name', $labels,$values,$errors,'input', true)?>
	<div class="control-group" >	
			<label class="control-label" >Юр.название<b class="text-error">*</b>:</label>
			<div class="controls" >
				<div class="row-fluid" >
					<div class="span2"><?=Form::select('opf', $opfs, $values['opf']);?></div>
					<div class="span10"><?=Form::field('law_name', $labels,$values,$errors, 'customInput',false,false,'span12')?></div>
				</div>
			</div>	
		</div>
	<div class="control-group" >	
			<label class="control-label" >Город<b class="text-error">*</b>:</label>
			<div class="controls" >
				<?=Form::select('city',$cities, $values['city'], array('class'=>'span12'));?>
			</div>	
		</div>
		
	<?=Form::field('url', $labels,$values,$errors)?>
	<?=Form::field('address', $labels,$values,$errors,'input', true)?>
	<?=Form::field('phone', $labels,$values,$errors,'input', true)?>
	<?=Form::field('description', $labels,$values,$errors,'textarea')?>
	<div class="control-group">
		<div class="controls"  >
			<button class="medium_button" type="submit" name="create"  >Сохранить</button>
		</div>
	</div>
</form>    