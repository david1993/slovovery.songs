<br />
<div class="row-fluid admin" >
	<div class="span12" >
		<?php foreach ($cities as $city):?>
			<div class="row-fluid">
				<div class="span8"><h4><?=$city->name?></h4></div>
				<div class="span2"><a  href="/city/edit/<?=$city->id?>">Редактировать</a></div>
				<div class="span2"><a  href="/city/del/<?=$city->id?>">Удалить</a></div>
			</div>
			<hr />
		<?php endforeach;?>        
	</div>    
</div>    
<?=$pagination?>