 <div class="homesongs">
 <? foreach ($songs as $song):
				$name=$song->name;
			 
	?>
				<a href="/song/view/<?=$song->id?>" name="n<?=$song->id?>"><?=$name?>
				<small class="date"><?=Date::cyrdate($song->created_time)?></small> 
				</a> 	 <br/> 
			<?php endforeach?> 
			
			</div>