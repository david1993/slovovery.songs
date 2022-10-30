<div class="pagination">
	<div class="row-fluid" >
		<div class="span2 pull-left">
		<?php if ($previous_page !== FALSE): ?>
			<div class="span2 pull-left" ><a href="<?php echo HTML::chars($page->url($previous_page)) ?>" rel="prev"> Предыдущая</a></div>
		<?php else: ?>
			<div class="span2 pull-left disabled"><a href="<?php echo HTML::chars($page->url($previous_page)) ?>" rel="prev"> Предыдущая</a></div>
		<?php endif ?>
		
		</div>
		<div class="span2 pull-right">
		<?php if ($next_page !== FALSE): ?>
			<div class="span2 pull-left" ><a href="<?php echo HTML::chars($page->url($next_page)) ?>" rel="next">Следующая </a></div>
		<?php else: ?>
			<div class="span2 pull-left disabled" ><a href="<?php echo HTML::chars($page->url($next_page)) ?>" rel="next">Следующая </a></div>
		<?php endif ?>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="row-fluid" >
		<div class="span1 pull-left"></div>
		<div class="span3 pull-left pag" >
			<ul>
				<?php for ($i = 1; $i <= $total_pages; $i++): ?>
					<?php if ($i == $current_page): ?>
						<li class="active"><a href="<?php echo HTML::chars($page->url($i)) ?>"><?php echo $i ?></a></li>
					<?php else: ?>
						<li><a href="<?php echo HTML::chars($page->url($i)) ?>"><?php echo $i ?></a></li>
					<?php endif ?>
				<?php endfor ?>
			</ul>
		</div>
		<div class="span4 pull-left">
			<form method="get" class="form-inline">
				<label>Выводить по:</label>
				<?php $count_arr=Array(20,50,100,300,1000)?>
				<select class="span1" name="per_page">
					<?php foreach($count_arr as $count):?>
						<option <?=($count==$items_per_page) ? 'selected="selected"':''?>><?=$count?></option>
					<?php endforeach;?>
				</select>
				<button type="submit" >ОK</button>
			</form>
		</div>
	</div>
</div>
<!-- .pagination -->