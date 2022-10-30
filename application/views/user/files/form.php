<div class="row-fluid">
	<div class="span3 tabs"><a href="/user/tovars"><strong>Редактирование товаров</strong></a></div><div class="span3"><strong>Импорт товаров из файла</strong></div>
</div>
<p>Вы можете импортировать полный перечень ваших товаров из файла формата YML, CSV либо Excel.</p>
<p><a href="#">Подробнее о форматах файлов</a></p>
<div class="clearfix"></div>
<p><strong>Начать импорт</strong></p>
<?php Form::alert($message,'alert-error')?>
<form method="post" enctype="multipart/form-data">
	<div>Выберите файл:</div>
	<input type="file" name="files[]" />
	<?=Form::important(Arr::path($errors, '_external.files'));?>
	<div>или укажите размещение файла в интернете:</div>
	<input type="text" name="fileByUrl" placeholder="http://" />
	<div class="clearfix"></div>
	<button type="submit" class="medium_button" >Далее</button>
</form>