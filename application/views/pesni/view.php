<div class="row-fluid stock_page">
	<div class="span9 pul-left" >
	
		<?php
		$user = Auth::instance ()->get_user ();
			
		?>
			<p>
			<?=str_replace("\n","<br/>", $song->text);?>
			
		
			
		</p>
			<?php
			
			if($song->accords):
		?>
		<h2>Аккорды</h2>
	
			
			
				<div style="background-color:#eee;margin-bottom:20px;padding:20px;">
					
						
					<p><?=str_replace("\n","<br/>", $song->accords);?></p>
				
				<div class="clear"></div>
					
				</div>
		<?php endif;?>
		<?php if($song->filemp3):
				$file="http://songs.slovovery.ru/files/pesni/$song->id/$song->filemp3";
				?>
				
				
					<a href="<?=$file?>"><?=$song->filemp3?></a>
				
				
				
				
				<?php endif;?>	
		
			
		<?php
			
			if($user):
		?><div>
		
		<a href="/pesni/edit/<?=$song->id?>">Редактировать</a>
			
		</div>
		
		<?php endif;?>
	
	<!-- Put this script tag to the <head> of your page -->
<script type="text/javascript" src="//vk.com/js/api/openapi.js?111"></script>

<script type="text/javascript">
  VK.init({apiId: 4305895, onlyWidgets: true});
</script>

<!-- Put this div tag to the place, where the Comments block will be -->
<div id="vk_comments"></div>
<script type="text/javascript">
VK.Widgets.Comments("vk_comments", {limit: 10, width: "520", attach: "*"});
</script>
	
	</div>
	
	<div class="span3 pull-left" >
	</div>
</div>     
    