<?php 
$sort_fields = Array(
	'name'=>'Названию',
	'price'=>'Цене',
);
?>

<div class="row-fluid">
	<div class="sort fon">
		<div class="span8">
			<div class="sort_by">Сортировать по:</div>
			<?php foreach($sort_fields as $column=>$title):?>
				<?php 
					$params=$_GET;
					if($order_by == $column)
					{
						$params['order_dir'] = ($order_dir == 'ASC' ? 'DESC' : 'ASC');
					}
					else
					{
						$params['order_by']=$column;
						$params['order_dir']='ASC';
					}
				?>
				<div class="span2">
					<a href="<?=URL::query($params)?>" class="<?=($order_by==$column)?'active':'';?>" >
						<?php 
							if($order_by==$column)
							{
								echo '<i class="icon-arrow-'.($order_dir=='ASC' ? 'up':'down').'"></i>';
							}
						?><?=$title?>
					</a>
				</div>
			<?php endforeach;?>
		</div>
		<div class="clearfix" ></div>
	</div>
</div>

