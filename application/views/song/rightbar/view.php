<?php if(Auth::instance()->logged_in('admin')):?><h3>Управление</h3>

<form method="post" action="/song/change_active/<?=$song->id?>">
	<h4>активность:</h4>
	<input type="radio" value="1" <? if($song->active==1) echo 'checked';?> name="active"/> активна<br/>
	<input type="radio" value="0" <? if($song->active==0) echo 'checked';?> name="active"/> не активна<br/>
	<input type="submit" value="ok"/>
</form><br/>
<a href="/song/delete/<?php echo $song->id;?>">Delete</a><br/>
<a href="/song/send_to_check/<?php echo $song->id;?>">Make song as new and send to check</a>
<br/>
<a href="/song/send_to_check2/<?php echo $song->id;?>">Make song not updated and send to check</a>
<?php endif;?>