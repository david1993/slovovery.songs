<?php //echo View::factory('profiler/stats');?>
<div class="row-fluid tabs">
	<div class="span3"><strong>Редактирование товаров</strong></div><div class="span3"><a href="/user/files"><strong>Импорт товаров из файла</strong></a></div>
</div>
<div class="row-fluid" >
	<span class="span6 cattree">
		<ul class="tree">
			<?php $prev_pid = 0; $prev_id = 1; $depth = 0; $flag = TRUE;?>
			<?php foreach ($tree as $node):?>
				
				<?php
					if($node['parent_id'] == $prev_id)
					{
						$depth++;
						$flag = TRUE;
					}
					elseif($node['parent_id'] != $prev_pid)
					{
						$depth--;
						$flag = FALSE;
					}
					if ($node['parent_id'] != $prev_pid && $prev_id != 1 && $depth == 1 && $depth == 2) {
						echo '</ul></li>';
					}
					if ($node['rgt'] - $node['lft'] != 1){
						if ($node['parent_id'] != $prev_pid && $flag) { 
							echo '<li><span class="name"><i class="icon-plus"></i>'.$node['name'].' <small>('.$node['tovars_count'].')</small></span><ul class="tree">';
							$flag = TRUE;
						}
						elseif ($flag) {
							echo '<li><span class="name"><i class="icon-plus"></i>'.$node['name'].' <small>('.$node['tovars_count'].')</small></span><ul class="tree">';
							$flag = FALSE;
						}
						else {
							echo '</ul><li><span class="name"><i class="icon-plus"></i>'.$node['name'].' <small>('.$node['tovars_count'].')</small></span><ul class="tree">';
							$flag = FALSE;
						}
					}
					else {
						if ($flag) {
							echo '<li><a href="/user/tovars/'.$node['id'].'">'.$node['name'].'</a> <small>('.$node['tovars_count'].')</small></li>';
						}
						else {
							echo '</ul><li><a href="/user/tovars/'.$node['id'].'">'.$node['name'].'</a> <small>('.$node['tovars_count'].')</small></li>';
							$flag = TRUE;
						}
					}
					$prev_id = $node['id'];
					$prev_pid = $node['parent_id'];
				?>
				
			<?php endforeach;?>
		</ul>
	</span>
</div>