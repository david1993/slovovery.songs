 <div class="navbar">
    	<div class="navbar-inner">
			<ul class="nav">
			<?php foreach ($nav as $name=>$item):?>
				<li <?=Arr::get($item, 'class', FALSE)? ('class="'.$item['class'].'"'):''?>><a href="<?=$item['href']?>"><?=$name?></a></li>
			<?php endforeach;?>
			</ul>
     </div>
  </div>

        
    