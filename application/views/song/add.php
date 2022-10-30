<p>Добавляемые вами акции проходят предварительную проверку модератором сайта.</p>
<p><strong>Срок проведения проверки: 1 сутки.</strong></p>
<br />
<?php /*Form::alert($message,'alert-error')*/?>
    <form method="post" enctype="multipart/form-data" class="form-horizontal" >	
	<div class="span7" >
   <?php
    $labels = ORM::factory('stock')->labels();
	
	$labels = array_merge($labels,array('shops' => 'Магазины, в которых проходит акция'));
    
	if(! isset($values))
    {    	
    	$values = $_POST;
    }
    ?>
	<?= Form::field('name', $labels,$values,$errors,'input',true)?>
	<?= Form::field('anons', $labels,$values,$errors,'textarea',true)?>
	<?= Form::field('begin_time', $labels,$values,$errors,'input', true)?>
	<?= Form::field('content', $labels,$values,$errors,'textarea')?>
	<div class="control-group" >	
			<label class="control-label" >Изображение:</label>
			<div class="controls" >
				<?= Form::file('pic',array('accept'=>'image/jpeg'))?>
				<?= Form::important(Arr::path($errors, '_external.pic'));?>
			</div>	
		</div>
	<?= Form::field('url', $labels,$values, $errors,'input',false, false,'double')?>
	<?= Form::field('shops', $labels,$shops, $errors,'checkbox')?>
	</div>
	<div class="clearfix"></div>
	<div class="control-group">
		<div class="controls"  >
			<button class="medium_button" type="submit" name="do" value="publish" ><b>Добавить и отправить на проверку</b></button>
			<button class="medium_button" type="submit" name="do" value="draft">Добавить</button>
			<a href="/stock/list/" class="button" > <button class="medium_button" type="button" >Отмена</button></a>
		</div>
	</div>
</form>
    
        
    