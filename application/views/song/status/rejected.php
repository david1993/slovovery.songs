<div class="clearfix" ></div>
<?php if($stock->reject_reason):?>
		<div class="span8">
			<h5>Комментарий модератора:</h5>
			<p><i><?= $stock->reject_reason?></i></p>
		</div>
<?php endif;?>
<div class="clearfix" ></div>
<div class="pull-left" >	
	<a  href="/stock/edit/<?=$stock->id?>"><b>Редактировать</b></a>
</div>
<div class="pull-left" >
	<a  href="/stock/publish/<?=$stock->id?>">Повторно отправить на модерацию</a>
</div>	
<div class="pull-left" >	
	<a  href="/stock/delete/<?=$stock->id?>"> Удалить</a>
</div>	