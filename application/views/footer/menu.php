<?php 
$links = array();
foreach ($items as $alt_name=>$name)
{
	$links[]='<a href="/'.$alt_name.'/">'.$name.'</a>';
}
foreach ($static_items as $alt_name=>$name)
{
	$links[]='<a href="/'.$alt_name.'/">'.$name.'</a>';
}
echo implode('', $links);
?>
        
    