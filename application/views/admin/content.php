<div class="row-fluid" >
	<div class="span12" >
		<?php foreach ($pages as $page):?>
		<div class="row-fluid">
			<div class="span8 pull-left"><h4><a href="/<?=$page->alt_name?>"><?=$page->name?></a></h4></div>
			<div class="span2 pull-left"><a href="/page/edit/<?=$page->id?>"> Редактировать</a></div>
			<div class="span1 pull-left"><a href="/page/del/<?=$page->id?>"> Удалить</a></div>
		</div>
		<hr>
		<?php endforeach;?>        
	</div>   
</div>
<div class="row-fluid" >
	<div class="span12" >
		<?=$pagination?>
	</div>   
</div>    