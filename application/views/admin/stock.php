<div class="row-fluid">
	<div class="span12">
		<?php foreach ($stocks as $stock):?>
			<div class="row-fluid">
				<div class="span6 "><h4><?=$stock->name?></h4></div>
				<div class="span3"><?=View::factory('stock/status')->set('status_id',$stock->status_id)->set('status',$stock->status());?></div>
				<div class="span2"><a href="/stock/edit/<?=$stock->id?>"> Редактировать</a></div>
				<div class="span1"><a href="/stock/delete/<?=$stock->id?>"> Удалить</a></div>
			</div>
			<hr/>
		<?php endforeach?> 
		<?=$pagination?>
	</div>
</div>