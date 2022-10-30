<div class="row-fluid" >
	<div class="span12" >
		<form action="/subscriber/create" method="post" class="subscriber form-inline" >
			<p>Подпишитесь на рассылку акций мебельных магазинов</p>
			<div class="control-group">
				<label class="control-label" >Ваш e-mail<b class="text-error">*</b>:</label>
				<div class="controls" >
					<input class="span4" type="text" name="email" /> <button type="submit" name="login" >Подписаться</button>
					<label class="span1 control-label" style="height:4px;" ></label>
					<?= Form::important(Arr::path($errors, '_external.email')); ?>
				</div>
			</div>
		</form>
	</div>
</div>