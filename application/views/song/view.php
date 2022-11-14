<div class="row-fluid stock_page">
	<div class="span9 pul-left" >
	
		<?php
		$user = Auth::instance ()->get_user ();
			if(sizeof($slides)):
		?>
			
			<?php 
				$i=0;
				foreach ($slides as $key => $slide):
					$i++;
				?>				
					<a name="<?=$slide->id_slide?>"></a>
					<p><?=$slide->text.", "?></p>
			<?php endforeach;?> 
		<?php endif;?>			
		<p>
			
		</p>
			<?php
			
			if(sizeof($accords)):
		?>
		<h2>Аккорды</h2>
	
			
			<?php 
				$i=0;
				foreach ($accords as $key => $accord):
					$i++;
					//if($accord->text):
					
				?>				
				<div style="background-color:#eee;margin-bottom:20px;padding:20px;">
					
					<p><?=$accord->text?></p>
				<?php if($accord->image):
				
				?>
					<a href="/images/accords/<?=$song->id?>/<?=$accord->image?>"><img alt="" src="/images/accords/mini/<?=$song->id?>/<?=$accord->image?>"/></a>
				<?php endif;?>	
				<div class="clear"></div>
				<?php
							if($user && $user->id==$accord->id_user or Auth::instance()->logged_in('admin')):
					?>
					<a href="/accord/delete/<?=$accord->id?>" class="delete">удалить</a>
					<?php endif;?>	
				</div>
			<?php endforeach;?> 
		<?php endif;?>
        <br/>
        Сайт скоро переедет на        <a href="http://slovovery.ru/">slovovery.ru</a><br/>
        <a href="<?=$newSongUrl?>"><?=$song->name?> -  на новом сайте</a>

		<?php
			
			if($user):
		?><div>
			<h4>Добавить аккорды</h4>
			 <form id="formAddAccord" method="post" action="/accord/add/<?=$song->id?>" enctype="multipart/form-data">
			 Фотография:<br/>
			 <input type="file" name="images[]" /><br /> 
			<?= Form::field('text', ORM::factory('accord')->labels(), array(), array(),'textareaEditable')?>
			<button class="medium_button" type="submit"  ><b>Сохранить</b></button>
			</form>	
		</div>
		
		<?php endif;?>
		<h2>Информация о странице</h2>
		<p>дата создание: <?=$song->creation_date?></p>
		<p>дата изменения: <?=$song->edit_date?></p>
		<p>скачать в формате ppt или pptx: <a href="/songs/files/<?=$song->file?>"><?=$song->file?></a></p>
		
	</div>
	
	<div class="span3 pull-left" >
	</div>
</div>     
    