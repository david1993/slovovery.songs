			<?php 
			$id=$song->id;
			
			if (!isset($id)) $id='new';
			
			
			$name=$song->title;
			if(isset($name)):
			?>
			
			<a target="_blank" href="/pesni/view/<?=$song->id?>" class="title" name="n<?=$song->id?>"><?=$name?></a>
				<?php endif;?>
			 <form id="formAddAccord" method="post" action="/pesni/edit/<?=$id?>" enctype="multipart/form-data">
			
			 <?= Form::field('title', ORM::factory('pesni')->labels(), $values, array(),'input')?>
			
			<?= Form::field('text', ORM::factory('pesni')->labels(), $values, array(),'textareaEditable')?>
			<?= Form::field('accords', ORM::factory('pesni')->labels(), $values, array(),'textareaEditable')?>
			
			 Аудиозапись:<a href="/files/pesni/<?=$song->id?>/<?=$song->filemp3?>"><?=$song->filemp3?></a>
		<br/>
			 <input type="file" name="filemp3" /><br /> 
			 
			 
			<button class="medium_button" type="submit"  ><b>Сохранить</b></button>
			</form>	