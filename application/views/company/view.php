<div class="row-fluid company_page">
	<div class="span6 pull-left">
		<p>Юридическое название:  <strong><?=$company->opf?> "<?=$company->law_name?>"</strong></p>
		<p>Центральный офис:  <strong><?=$company->address?></strong></p>
		<p>Телефон:  <strong><?=$company->phone?></strong></p>
	</div>
	<div class="span6 pull-left">
		<p><?=$company->description?></p>
	</div>
	<div class="clearfix"></div>
	<h3 class="fon" >Магазины компании</h3>
	<div class="row-fluid">
		
		<div class="span4" >
				<?php foreach ($shops as $shop):?>
				<div class="shop" >
					<h4><a href="/shop/view/<?=$shop->id?>"><?=$shop->name?></a></h4>
					<p><a class="address" href="/shop/view/<?=$shop->id?>" ><?=$shop->address?></a></p>
					<p><?=$shop->phone?></p>
					<p><?=$shop->description?></p>
				</div>
				<?php endforeach?> 
		</div>
		<div id="map_canvas" class="span8 pull-left" ></div>		
	</div>
</div>	
