<div class="row-fluid rating" >
	<div class="span4 pull-left" >
		<p>
			<?php if(is_null($obj->rate->rate)):?>
				Нет оценок
			<?php else:?>
				Средняя оценка: <b><?= $obj->rate->rate?></b>
				<br /> <span><i>оценили: <?= $obj->rate->rates_count?></i><span>
			<?php endif;?>
		</p>
	</div>
	<div class="span8 pull-left" >
		<p>
			<?php if(Auth::instance()->logged_in('login')):?>
				Ваша оценка:
				<?php 
				$user_rate = Auth::instance()->get_user()->get_rate($model,$obj->id);
				if(is_numeric($user_rate)):?>
					<?=$user_rate;?>
				<?php else :?>
					<?php for($i=1;$i<=5;$i++):?>
						<a href="/rate/<?=$model?>/<?=$obj->id?>/<?=$i?>"><?=$i?></a>&nbsp;
					<?php endfor;?>
				<?php endif;?>
			<?php else :?>
				Войдите, чтобы поставить оценку	
			<?php endif;?>
		</p>
	</div>
</div>