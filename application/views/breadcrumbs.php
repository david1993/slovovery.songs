<ul class="breadcrumb">
    <li><a href="/">Главная</a> <span class="divider">/</span></li>
    <?php 
    foreach ($items as $item){
    	echo '<li><a href="'.$item['href'].'">'.$item['name'].'</a> <span class="divider">/</span></li>';
    }
    ?>
<!--    <li class="active">Data</li>-->
</ul>
       
    