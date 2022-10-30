<div class="row-fluid service" >
		<form action="/admin/service" method="post" class="span7 form-horizontal" >	
				<?php foreach ($services as $service):?>
					<div class="control-group"  >
						<label class="control-label double" ><?=$service->name?>:</label>
						<div class="controls" >
							<input type="text" class="span8" value="<?=$service->cost?>" id="service<?=$service->id?>" name="<?=$service->id?>" />
						</div>	
					</div>
				<?php endforeach;?>    
				<div class="control-group">
					<div class="controls" >
						<button type="submit" name="create" class="medium_button">Сохранить</button>
					</div>
				</div>
		</form> 
</div>