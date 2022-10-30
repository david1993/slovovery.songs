
<?php if(sizeof($comments)):
		foreach ($comments as $comment):?>
	<div class="comment">
			<h5 class="fon">
				<b><?=$comment->author?></b>
				<small>
					<?=date("j", $comment->date).' '.Date::month(date("n", $comment->date)).' '.date("Y", $comment->date).', '.date("G:i", $comment->date);?>
				</small>
			</h5>
		<div class="text">
			<i><?=$comment->text?></i>
		</div>
	</div>
<?php 
		endforeach;
	else:
?> 
	<p>Ваш отзыв может быть первым<p>
<?php 
	endif;
?> 