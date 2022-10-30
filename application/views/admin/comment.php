<form action="" method="get" class="form-inline">
	<input class="span5" name="keyword" type="text" value="<?=$keyword?>" />
	<input  name="per_page" type="hidden" value="<?=Arr::get($_GET,'per_page',5)?>" />
	<button class="btn" type="submit">Найти</button>
</form>
<br />
<form action="/user/comments/" method="post" class="comments form-inline">
	<div class="row-fluid">
		<div class="span12">
			<?php foreach ($comments as $comment) : ?>
			<div class="row-fluid">
				<div class="span pull-left checkbox"><input type="checkbox" name="comment[]" value="<?=$comment->id?>" /></div>
				<div class="span2 pull-left"><?=date("d.m.Y G:i", $comment->date)?></div>
				<div class="span8 pull-left"><?=$comment->text?></div>
				<div class="span1 pull-left"><a href="/comment/delete/<?=$comment->id?>?per_page=<?=Arr::get($_GET,'per_page',5)?>">Удалить</a></div>
			</div>
			<hr/>
			<?php endforeach; ?>
		</div>
	</div>
	
	<?php if(!empty($comments['_total_rows:protected'])) : ?>
	<div class="row-fluid">
		<div class="span12 fon">
				<div class="row-fluid">
					<div class="span1">
					</div>
					<div class="span3">
						<button type="submit" class="btn submit disabled" disabled="disabled">Удалить выделенные</button>
					</div>
				</div>
		</div>
	</div>
	<?php endif; ?>
</form>
<?=$pagination?>
