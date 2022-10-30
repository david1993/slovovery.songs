<div class="row-fluid">
	<div class="span9">
	<?php foreach ($stocks as $stock):?>
	<div class="row-fluid">
		<div class="span12">
			<div class="row-fluid" >
				
				<h3 ><?=$stock->name?><small class="date"><?=Date::cyrdate($stock->begin_time)?></small></h3>
			</div>
			<div class="row-fluid">
				<div class="pull-left" >
					<?=View::factory('stock/status')
					->set('status_id',$stock->status_id)
					->set('status',$stock->status());?>
				</div>
				<?php 
					switch ($stock ->status_id){
						case 1: $view='/stock/status/draft'; break;
						case 3: $view='/stock/status/rejected'; break;
						default: $view='';
					}
				?>
				<?php 
					if(strlen($view))
					{
					 echo View::factory($view)
							->set('stock',$stock);
					}
				?>
			</div>
		</div>
	</div>
	<hr/>
	<?php endforeach?> 
	
	</div>
	<div class="span3"></div>
</div>
 <?=$pagination?>
 

    