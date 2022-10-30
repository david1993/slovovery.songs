<?php /*View::factory('profiler/stats');*/ ?>
<div class="row-fluid">
	<div class="span12">
		<p style="color:red;">Требуется импорт файлов:</p>
	</div>
	<div class="span12">
		<?php foreach ($files as $file):?>
			<div class="row-fluid">
				<div class="span7 pull-left"><h4><?=$file->path?></h4></div>
				<div class="span3 pull-left">Загружено <? echo date ('j.d.Y H:i', $file->datetime); ?></div>
				<div class="span2 pull-left">
					<a href="/file/start/<?=$file->id?>/">Импортировать</a>
				</div>
			</div>
			<hr />
		<?php endforeach;?>	
	</div>    
</div>
<div class="clearfix" ></div>
<form action="" method="get" class="form-inline">
	<input class="span5" name="keyword" type="text" value="<?=$keyword?>" />
	<input  name="per_page" type="hidden" value="<?=Arr::get($_GET,'per_page',5)?>" />
	<button class="btn" type="submit">Найти</button>
</form>
<div class="row-fluid">
<div class="span5"><a href="/company/csv/">Экспорт списка продавцов в .CSV</a></div>
</div>
<div class="clearfix" ></div>
<div class="row-fluid">
	<div class="span12">
		<?php foreach ($companies as $company):?>
			<div class="row-fluid">
				<div class="span8 pull-left"><h4><a href="/company/view/<?=$company->id?>/" ><?=$company->company_name?></a></h4></div>
				<div class="span2 pull-left">
					<?php if($company->active) {?>
						<a  href="/company/active/<?=$company->id?>/0/">Отключить</a>
					<?php 
					}
					else
					{ 
					?>
						<a  href="/company/active/<?=$company->id?>/1/" style="color:red;" >Включить</a>
					<?php 
					}
					?>
				</div>	
				<div class="span2 pull-left"><a href="/user/del/<?=$company->user_id?>">Удалить</a></div>
				
			</div>
			<hr />
		<?php endforeach;?>	
	</div>    
</div> 
<div class="row-fluid" >
	<div class="span12" >
		<?=$pagination?>
	</div>   
</div>   