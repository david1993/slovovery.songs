<div class="btn-toolbar">
<div class="btn-group">
	<a class="btn" href="/stock/publish/<?=$stock->id?>"><i class="icon-ok"></i> Опубликовать </a>
	
	<button class="btn" onclick="$('#reject-reason').show();"><i class="icon-ban-circle"></i> Отклонить</a>
<!--	<a class="btn" href="/stock/publish/<?=$stock->id?>"></a>-->
</div>
<div class="btn-group">
	<a class="btn" href="/stock/edit/<?=$stock->id?>"><i class="icon-pencil"></i> Изменить</a>
	<a class="btn" href="/stock/delete/<?=$stock->id?>"><i class="icon-trash"></i> Удалить</a>
</div>
</div>
<form id="reject-reason" action="/stock/reject/<?=$stock->id?>" method="post" style="display:none">
<textarea rows="2" name="rejectreason" placeholder="Причина отказа" class="span6"></textarea>
<div><input type="submit" value="Отправить" class="btn btn-primary" /></div>
</form>
<?php if($stock->reject_reason):?>
<div class="row">
    <div class="alert alert-block span6">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <h4>Комментарий модератора:</h4>
    <?= $stock->reject_reason?>
    </div>
</div>
<?php endif;?>

    