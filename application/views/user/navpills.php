<?php if(Auth::instance()->logged_in('seller')):?>
<h4 style="color:#817F82;">Личный кабинет продавца</h4>
<div class="row-fluid">
<?php foreach ($nav as $key=>$value):?>
<div class="span6" >
	<ul class="nav nav-pills span12">
		<?php foreach ($value as $name=>$item):?>
			<li <?=Arr::get($item, 'class', FALSE)? ('class="'.$item['class'].'"'):''?>>
				<a class="<?if ($key=='second') echo ' btn-small'; ?>" href="<?=$item['href']?>"><?=$name?></a>
			</li>
		<?php endforeach;?>
	</ul>
	</div>
<?php endforeach; ?>
</div>
<?php endif;?>