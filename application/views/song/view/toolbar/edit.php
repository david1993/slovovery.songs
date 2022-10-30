<div class="btn-toolbar">
<div class="btn-group">
	<a class="btn" href="/stock/edit/<?=$stock->id?>"><i class="icon-pencil"></i> Изменить</a>
	<a class="btn" href="/stock/delete/<?=$stock->id?>"><i class="icon-trash"></i> Удалить</a>
</div>
</div>
<?php if($stock->reject_reason):?>
<div class="row">
    <div class="alert alert-block span6">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <h4>Комментарий модератора:</h4>
    <?= $stock->reject_reason?>
    </div>
</div>
<?php endif;?>

    