	
	<div class="filter" >
		<form action="" type="get" class="form-inline">
			<div class="row-fluid">
				<div class="span10 pull-left">
					<label><b>Ключевое слово</b></label>
					<input type="text" name="keyword"  value="<?=$keyword?>" class="span12 keyword" />
				</div>
				<div class="span2 pull-left">
					<button  type="submit">Показать</button>
				</div>
			</div>	
			<div class="checkboxes">
				<?php foreach($categories as $key=>$value) : ?>
					<div class="pull-left"><input type="checkbox" value="<?=$key?>" name="categories[]" <?php if (in_array($key,$category_ids)) echo 'checked'; ?>><label><?=$value?></label></div>
				<?php endforeach; ?>	
				<?php foreach($shoptypes as $key=>$value) : ?>
					<div class="pull-left">	<input type="checkbox" value="<?=$key?>" name="shoptypes[]" <?php if (in_array($key,$shoptype_ids)) echo 'checked'; ?>><label><?=$value?></label></div>
				<?php endforeach; ?>
			</div>
			<div class="clearfix" ></div>
		</form>
		<div class="clearfix" ></div>
	</div>
