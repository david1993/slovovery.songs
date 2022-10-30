<div id="filter">
<h3>Фильтр</h3><br/>
<form action="" method="POST" id="filter_form">

	<?php 
		foreach ($filterFields as $fieldName=>$filterField):
		
	?>
	<h5><?=$filterField['name']?>:</h5>
	<?php 
		foreach ($filterField['values'] as $key=>$filterTitle):?>
   <input type="radio" name="<?=$fieldName?>" value="<?=$key?>"<? if($filterField['value']==$key) echo ' checked="checked"'?>>
   <a href="?<?php echo $fieldName.'='.$key;?>"><?=$filterTitle?></a><Br>
   <?php endforeach?>
   
   <?php endforeach?>
	<input type="submit" value="Поиск"/>
   
</form>
</div>




<?php 

echo View::factory ( 'song/yakors' )->bind ( 'yakors', $yakors );
?>
<?php if(Auth::instance()->logged_in('admin')):?><h3>Управление</h3>
<a href="/song/check_import">Check import</a>
<?php endif; ?>