<?php 
switch ($status_id){
	case 1: $type='label-inverse'; break;
	case 2: $type='label-warning'; break;
	case 3: $type='label-important'; break;
	case 4: $type='label-success'; break;
	case 5: $type='label-important'; break;
	default: $type='';
}
?>
<span class="label <?=$type?>"><?=$status?></span>
        
    