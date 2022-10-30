<div class="row-fluid">
	<div class="span12 pull-left">
	</div>
	<? foreach ($companies as $company): ?>
		<div class="span12 pull-left">
			<span>Продавец: </span><a href="/user/index/<?=$company->id?>/"><?=$company->company_name?></a>
		</div>
	<?php endforeach;?>	
	<div class="span12 pull-left">
		<span>Файл: </span><a href="<? echo 'http://'.$_SERVER['SERVER_NAME'].substr($path, 1); ?>"><? echo 'http://'.$_SERVER['SERVER_NAME'].substr($path, 1); ?></a>
	</div>
	<div class="span12 pull-left">
		<h3>Импорт завершен</h3>	
	</div>
	<div class="span12 pull-left">
		<h4 class="green">Импортировано товаров: &nbsp; <?=$count?></h4>
	</div>
	<div class="span12 pull-left">
		<h4 class="red">Импортировано товаров с ошибками: &nbsp; <?=$bad_count?></h4>
	</div>
	<form method="post" enctype="multipart/form-data" class="span12" action="/file/import/<?=$id?>">
	<div class="span12 pull-left">
		Сообщение продавцу
	</div>
	<textarea></textarea>
	<div class="control-group">
		<div class="controls"  >
			<button class="medium_button" type="submit">Отправить</button>
		</div>
	</div>
	</form>

</div>