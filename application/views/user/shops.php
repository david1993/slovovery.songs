<div class="row-fluid">
	<div class="span12">
		<?=$sort?>
	</div>
</div>
<form action="/user/shops/" method="post" class="shops form-inline">
	<div class="row-fluid">
		<div class="span12">
			<?php foreach ($shops as $shop):?>
				<div class="row-fluid">
					<div class="span checkbox">
						<input type="checkbox" name="shop[]" value="<?=$shop->id?>" />
					</div>
					<div class="span4">	
						<h4><a href="/shop/edit/<?=$shop->id?>"><?=$shop->name?></a></h4>
						<span>
							<?php
								if ($shop->kind == '1') echo $shop->address;
								elseif ($shop->kind == '2') echo $shop->url;
							?>
						</span>
					</div>
					<div class="span3">
						<?=$shop->kind->name?>
					</div>
					<div class="span1"></div>
					<div class="span1"></div>
					<div class="span1"></div>
					<div class="span1">
						<a href="/shop/delete/<?=$shop->id?>">Удалить</a>
					</div>
				</div>
			<?php endforeach?>
			<hr/>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span12 fon">
				<div class="row-fluid">
					<div class="all pull-left">
						<input type="checkbox" id="all"  /> <label for="all">Выделить все</label> 
					</div>
					<div class="span2">
						<button type="submit" class="btn submit disabled" disabled="disabled">Удалить</button>
					</div>
				</div>
		</div>
	</div>
		
	<!--	</div>
		<div class="span3"></div>
	</div>
	<label class="checkbox all"><input type="checkbox" /> Выделить все</label> <button type="submit" class="btn"><i class="icon-trash"></i> Удалить</button>-->
</form>
<?=$pagination?>