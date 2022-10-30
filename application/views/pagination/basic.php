<div class="pagination">
<div class="row" >
	<div class="span1 pull-left">Страницы:</div>
	<?php if ($previous_page !== FALSE): ?>
		<div class="span2 pull-left" >&larr;<a href="<?php echo HTML::chars($page->url($previous_page)) ?>" rel="prev"> Предыдущая</a></div>
	<?php else: ?>
		<div class="span2 pull-left disabled">&larr;<a href="<?php echo HTML::chars($page->url($previous_page)) ?>" rel="prev"> Предыдущая</a></div>
	<?php endif ?>
	<?php if ($next_page !== FALSE): ?>
		<div class="span2 pull-left" ><a href="<?php echo HTML::chars($page->url($next_page)) ?>" rel="next">Следующая </a>&rarr;</div>
	<?php else: ?>
		<div class="span2 pull-left disabled" ><a href="<?php echo HTML::chars($page->url($next_page)) ?>" rel="next">Следующая </a>&rarr;</div>
	<?php endif ?>
	<div class="clearfix"></div>
</div>
<div class="row" >
	<div class="span1 pull-left"></div>
	<div class="span3 pull-left" >
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
</div>
</div>
<!-- .pagination -->