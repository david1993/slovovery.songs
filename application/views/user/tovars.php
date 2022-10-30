<?php //echo View::factory('profiler/stats');?>
<div class="row-fluid">
	<div class="span12">
		<?=$sort?>
	</div>
</div>
<form action="/user/tovars/<?=$category_id?>" method="post" class="tovars form-inline">
	<div class="row-fluid">
		<div class="span12">
			<?php foreach ($tovars as $tovar) : ?>
			<div class="row-fluid">
				<div class="span1 checkbox">
					<input type="checkbox" name="tovar[]" value="<?=$tovar->id?>" />
				</div>
				<div class="span3">	
					<h4><a href="/tovar/edit/<?=$tovar->id?>"><?=$tovar->name?></a></h4>
				</div>
				<div class="span2">
					<?=$tovar->price?> руб.
				</div>
				<div class="span2">
					<!--<p>п: 300 р: 3 о: 1</p>-->
				</div>
				<div class="span1">
					<!--<p class="text-error">Не указан магазин</p>-->
				</div>
				<div class="span1">
					<!--<a href="#" class="text-success">Выделить цветом</a>-->				
				</div>
				<div class="span1">
								
				</div>
				<div class="span1">
					<a href="/tovar/delete/<?=$tovar->id?>">Удалить</a>
				</div>
			</div>
			<?php endforeach; ?>
		<hr/>
		</div>
	</div>
	<?php if(!empty($tovars['_total_rows:protected'])) : ?>
	<div class="row-fluid">
		<div class="span12 fon">
				<div class="row-fluid">
					<div class="all pull-left">
						<input type="checkbox" id="all" /> <label for="all">Выделить все</label> 
					</div>
					<div class="span3">
						<!--<label class="span">Перенести в раздел</label>-->
						<ul class="nav-pills span">
							<li class="dropdown">
								<div class="btn-group dropdown">
									<button class="btn transferdropdown disabled" data-toggle="dropdown" disabled="disabled">Перенести в раздел</button>
									<button class="btn transferdropdown dropdown-toggle" data-toggle="dropdown" disabled="disabled">
										<span class="caret"></span>
									</button>
									<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
										<?php $prev_pid = 0; $prev_id = 1; $depth = 0; $flag = TRUE; ?>										
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
														echo '<li class="dropdown-submenu"><a tabindex="-1" href="#">'.$node['name'].'</a><ul class="dropdown-menu">';
														$flag = TRUE;
													}
													elseif ($flag) {
														echo '<li class="dropdown-submenu"><a tabindex="-1" href="#">'.$node['name'].'</a><ul class="dropdown-menu">';
														$flag = FALSE;
													}
													else {
														echo '</ul><li class="dropdown-submenu"><a tabindex="-1" href="#">'.$node['name'].'</a><ul class="dropdown-menu">';
														$flag = FALSE;
													}
												}
												else {
													if ($flag) {
														echo '<li><a class="transfer" tabindex="-1" href="#">'.$node['name'].'</a><input type="hidden" name="category_id" value="'. $node['id'] .'" /></li>';
													}
													else {
														echo '</ul><li><a class="transfer" tabindex="-1" href="#">'.$node['name'].'</a><input type="hidden" name="category_id" value="'. $node['id'] .'" /></li>';
														$flag = TRUE;
													}
												}
												$prev_id = $node['id'];
												$prev_pid = $node['parent_id'];
											?>
										<?php endforeach; ?>
									</ul>
								</div>
							</li>
						</ul>
						<!--<button type="button" class="btn"><i class="icon-arrow-left"></i> Перенести</button>-->
					</div>
					<div class="span3">
						<button type="submit" class="btn submit disabled" disabled="disabled"> Удалить</button>
					</div>
				</div>
		</div>
	</div>
	<?php endif; ?>
</form>
<?=$pagination?>
