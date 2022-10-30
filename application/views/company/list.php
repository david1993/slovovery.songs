<div class="row-fluid" >
<div class="span9" >
	<div id="abc" class="span12" >
		<?php 
			if($abc['Все']=='active')
			{
				echo '<span class="active all"><b><a href="?page='.Arr::get($_GET,'page',1).'" >Все</a></b></span>';
			}
			else
			{
				echo '<span class="noactive all"><a href="?page='.Arr::get($_GET,'page',1).'" >Все</a></span>';
			}
			unset($abc['Все']);
			
			foreach($abc as $key => $val)
			{
				if($key == 'A') echo '<div class="clearfix" ></div><div class="span1 pull-left" ></div>';
				switch ($val)
				{
					case 'active': echo '<span class="active"><b><a href="?letter='.$key.'">'.$key.'</a></b></span>';break;
					case 'noactive': echo '<span class="noactive"><a href="?letter='.$key.'">'.$key.'</a></span>';break;
					case 'empty': echo '<span>'.$key.'</span>';break;
					default:break;
				} 
		}?> 
	<div class="clearfix"></div>	
	</div>


<?php foreach ($companies as $company):?>
	<div class="span12">
		<h4><a href="/company/view/<?=$company->id?>"><?=$company->company_name?></a></h4>
		<p><?=$company->description?></p>
	</div>
<?php endforeach?>
</div>
<div class="span3" >
	<div class="row-fluid">
			<div class="span12 inner_right_banner">
				<img src="/images/right_banner.gif" />
			</div>
		</div>
</div> 
<?=$pagination?>
</div>	
