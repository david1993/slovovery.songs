	<?php 
$user = Auth::instance ()->get_user ();?>
	<div id="catalog2">
	
	
	<?php if($user):?> 
				<a  href="/pesni/edit/new" style="border:1px solid #ccc;background:#fff; padding:5px 10px;border-radius:5px;text-decoration:none;">Добавить песню</a><br/><br/>
				<? endif;?>
	<?php 

foreach ($songs as $song):
$name=$song->title;
	?>
					<div class="item">
			
				<a href="/pesni/view/<?=$song->id?>" class="title" name="n<?=$song->id?>"><?=$name?>
				<? if($song->accords):?><span class="acc"> #♭ </span> <? endif;?>
				  <? if($song->filemp3):?><span class="acc mp3">mp3 </span> <? endif;?>
				</a><?php if($user):?> 
				<a class="delete" href="/pesni/delete/<?=$song->id?>">удалить</a>
				<? endif;?>
				</div>
				
<?php 

endforeach;
?>		</div>
	<div class="clear" ></div>	
	<br/><br/> 
		<?=$pagination?>
