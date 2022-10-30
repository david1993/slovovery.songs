<div class="row-fluid" >
	<div class="span12" id="comment_add">
		<?php if(Auth::instance()->logged_in('login')):?>
		<?php $labels = ORM::factory('comment')->labels();?>
		<div class="clearfix"></div>
			<form id="form" action="/comment/add/<?=$id?>/<?=$model?>/" method="post" class="form-horizontal">
				<label>Текст отзыва</label>
				<div class="control-group">
					<textarea class="span12" name="text" row="5"></textarea>
				</div>
				<button type="submit" name="do" >Отправить</button>
			</form>
		<?php else :?>
			<div class="span12" >Чтобы оставить отзыв, войдите на сайт через свой аккаунт:</div>	
			<div class="clearfix"></div>
			<div><?=$loginza?></div>
		<?php endif;?>
	</div>
</div>


										
										