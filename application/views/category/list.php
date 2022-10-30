<div class="row-fluid" >
	<div class="span9" >
		<form action="" method="post"  class="category"  id="categorylist" >

		<?php
		function renderLevel2($arr){
			if(count($arr))
			{
				foreach($arr as $val) echo '<div class="span3 pull-left">'.$val.'</div>';
			}
		}

		$level2 = Array();

		$f=0;
		foreach ($subcats as $category)
		{
			//echo Debug::dump($category);
			$item='<a href="/category/view/'.$category['id'].'">'.$category['name'].'</a>'.(($category['depth'] == 2)?'<span>'.$category['tovars_count'].'</span>':'');
			
			if($category['depth'] == 1)
			{
				if(Auth::instance()->logged_in('admin')){
				$item = '<input type="checkbox" value="'.$category['id'].'" name="categories[]" /> '.$item;
				}
				echo renderLevel2($level2);
				if($f) {echo '<div class="clearfix" ></div><hr/>'; $f=0;}
				echo '<h3>'.$item.'</h3>';
				$level2 = Array();

			}
			elseif ($category['depth'] == 2)
			{
				$level2[]=$item;
				$f=1;
			}
		}
		echo renderLevel2($level2);
		?>  
			
		<!--<input class="btn" type="submit" value="Перенести">-->   

		<?php if(Auth::instance()->logged_in('admin')):?>
			<div class="clearfix" ></div>
			<button class="medium_button" ><a href="/category/create/<?=$category_id?>" >Добавить</a> </button>
		
						<button type="submit" class="btn submit disabled" disabled="disabled">Удалить</button>

		
		<?php endif;?>
		</form> 
		<div class="clearfix" ></div> 
		
  </div>
  <div class="span3">
	<div class="row-fluid">
			<div class="span12 inner_right_banner">
				<img src="/images/right_banner.gif" />
			</div>
		</div>
  </div>
</div>  
