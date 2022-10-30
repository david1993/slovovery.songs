<a href="/song/check_import">Проверка импорта</a><br/><br/>

Приветствуем<?php if($user->name):?>, <?echo $user->name; endif;?>!<br/>


Ваш логин: <i><?=$user->username?></i> <br/>
<a href="/user/logout">Выход</a> 