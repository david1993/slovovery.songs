<?php /*Form::alert($message,'alert-error')*/?>

<?php if($stock->reject_reason):?>
<div class="span12">
	<?=View::factory('stock/status')
			->set('status_id',$stock->status_id)
			->set('status',$stock->status());?>
	</div>
		<div class="span12">
			<h5>Комментарий модератора:</h5>
			<p><i><?= $stock->reject_reason?></i></p>
		</div>
	<?php endif;?>   

   <form method="post" enctype="multipart/form-data" class=" form-horizontal" >
	<div class="span7" >
    <?php
    $labels = ORM::factory('stock')->labels();
    
	if(! isset($values))
    {    	
    	$values = $_POST;
		
    }
	
    ?>
	
	
	<div class="clearfix" ></div>
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
	<?= Form::field('url', $labels,$values, $errors,'input',false, false,'double');?>
	<div class="control-group" >	
			<?php if(sizeof($shops)) echo '<label class="control-label" >Магазины, в которых проходит акция:</label>'; ?>
			<div class="controls" >
				<?php 
					foreach($shops as $id =>$shop){
						echo '<label class="checkbox"><input type="checkbox" name="shop[]" value="'.$id.'"'.($shop['check'] ? 'checked':'').' />'.$shop['name'].'</label>';
					} 
				?>
			</div>	
		</div>
	</div>
	<div class="clearfix"></div>	
	<div class="control-group">
		<div class="controls"  >
			<button class="medium_button" type="submit" name="do" value="publish" ><b>Сохранить и отправить на проверку</b></button>
			<button class="medium_button" type="submit" name="do" value="draft">Сохранить</button>
			<a href="/stock/list/" class="button" > <button class="medium_button" type="button" >Отмена</button></a>
		</div>
	</div>
    </form>
    
        
    