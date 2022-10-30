<ul class="breadcrumb">
    <li><a href="/">Главная</a><span class="divider">/</span></li>
    <?php
    if($lastIsActive) $last = array_pop($items);
     
    foreach ($items as $id=>$name){
    	echo '<li><a href="/category/view/'.$id.'">'.$name.'</a><span class="divider">/</span></li>';
    }
    
    if($lastIsActive) echo '<li class="active">'.$last.'</li>';
    ?>
</ul>

        
    