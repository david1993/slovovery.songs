<div class="row-fluid">
    <div class="span12">
        <ul class="nav">


        <?php
		
		$link_after_tree = Controller_Category::link_after_tree();
		
        function renderLevel2($arr){
            if(count($arr))
            {
                return implode('',$arr);
            }
        }

        $level2 = Array();

        foreach ($subcats as $category)
        {
            //echo Debug::dump($category);
            $item='<a href="/category/view/'.$category['id'].'">'.$category['name'].'</a>';

            if($category['depth'] == 1)
            {
                echo renderLevel2($level2);
                echo '<li class="cat_'.$category['id'].'"><h5>'.$item.'</h5></li>';
                $level2 = Array();
            }
            elseif ($category['depth'] == 2)
            {
                $level2[]='<li class="p_'.$category['parent_id'].'">'.$item.'</li>';
            }
        }
        echo renderLevel2($level2);
		
		foreach($link_after_tree as $title=>$info)
		{
			echo '<li class="'.Arr::get($info, 'class').'"><a href="'.Arr::get($info, 'href').'">'.$title.'</a></li>';
		}
		
        ?>
		
        </ul>
    </div>
</div>