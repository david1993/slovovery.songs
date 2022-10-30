
	
	<div id="catalog">
	<?php
			 foreach ($songs as $song):
				$name=$song->name;
			 
	?>
					
			
				<a href="/song/view/<?=$song->id?>" name="n<?=$song->id?>"><?=$name?>
				<? if(sizeof($song->accords->find_all())):?><span class="acc"># ♭</span><? endif;?>
				</a> 	
				<!-- <small class="date"><?//=Date::cyrdate($song->begin_time)?></small>  -->
			<?php endforeach?> 
	
	
							
						
						</div>
	<div class="clear" ></div>	
	<br/><br/> 
		<?=$pagination?>



 

    
