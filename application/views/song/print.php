<?php 

foreach ($songs as $song):
	

?>

<h2><?php echo $song->name;?></h2>
<?php	
$slides = $song->slides->where ( 'active', '=', '1' )->find_all ();
foreach ($slides as $slide){
	echo "<p>$slide->text, </p>";
	
}
endforeach;
?>