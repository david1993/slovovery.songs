 <nav>
					<ul class="menu">
						<?php foreach ($nav as $name=>$item):?>
		<li ><a href="<?=$item['href']?>" <?=Arr::get($item, 'class', FALSE)? ('class="'.$item['class'].'"'):''?>><?=$name?></a></li>
		<?php endforeach;?>
						
						
						<li><div class="search">
						<form action="/search">
							<input type="text" name="q" value="<? if(isset($_GET['q'])){ echo $_GET['q'];}?>"/>
							<input type="submit" value="Искать"/>
						</form>
						</div></li>
					</ul>
				</nav>
 
 

        
    