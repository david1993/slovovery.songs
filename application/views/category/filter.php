
	<div class="filter" >
		<form action="" type="get" class="form-inline">
			<div class="row-fluid" >
				<div class="span3 pull-left">
					<label><b>Цена</b></label>
					<div>
						<span>от</span><input type="text" class="span4" name="startPrice" value="<?=$startPrice?>" class="span1" />
						<span>до</span><input type="text" class="span4" name="endPrice" value="<?=$endPrice?>" class="span1" />
						<span>руб.</span>
					</div>
				</div>
				<div class="span3 pull-left">
					<label><b>Страна-производитель</b></label>
					<select name="producer" class="span12">
						<?php foreach($producers as $key=>$value) : ?>
							<option value="<?=$key?>" <?php if ($producer_id == $key) echo 'selected="selected"'; ?>><?=$value?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="span4 pull-left">
					<label><b>Ключевое слово</b></label>
					<input type="text" name="keyword" class="span12" value="<?=$keyword?>" />
				</div>
				<div class="span2 pull-left">
					<button class="pull-left"  type="submit">Показать</button>
				</div>
			</div>	
				
		</form>
		<div class="clearfix" ></div>
	</div>
