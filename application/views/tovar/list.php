<?=$filter?>

<?=$sort?>
<div class="row-fluid">
	<div class="span9">
		<?php foreach ($tovars as $tovar) : ?>
				<div class="row-fluid">
					<div class="span11" >
						<div class="row-fluid <?=!is_null($tovar['highlight'])?'highlight':'';?>">
							<div class="span3 pull-left">
									<?php $tovar_obj = ORM::factory('tovar',(int)$tovar['id']); 
										$image = $tovar_obj ->get_firstImg(); ?>
									<?php if (!empty($image)): ?>
										<img src="/<?=Model_Tovar::MINI_PIC_PATH.$tovar_obj ->get_dir().'/'.$image?>" />
									<?php endif ?>
							</div>
							<div class="span6 pull-left">	
								<h4 class="pull-left" ><a href="/tovar/view/<?=$tovar['id']?>"><?=$tovar['name']?></a></h4>
								<div class="pull-left">
									<div class="pull-left rate">рейтинг: 
										<b>
											<?php if(is_null($tovar['rate'])):?>
												0
											<?php else:?>
												<?= $tovar['rate']?>
											<?php endif;?>
										</b>
									</div>
									<div class="pull-left note">отзывов: 
										<b>
											<?php if(is_null($tovar['comments_count'])):?>
												0
											<?php else:?>
												<?= $tovar['comments_count']?>
											<?php endif;?>
										</b>
									</div>
								</div>
								<div class="clearfix"></div>
								<p><strong><?=$tovar['price']?> руб.</strong></p>
								<p><em>Производство: <?=$tovar['producer_name'];?></em></p>
								<p><?
									$str=$tovar['description'];
									
									//разбиваем на массив
									$arr_str = explode(" ", $str);
									//берем первые 6 элементов
									$lenght=240;
									$new_str='';
									$i=0;
									while(mb_strlen($new_str) < $lenght){
										if ($i!=0){
											$new_str.=' ';
										}
										$new_str.=$arr_str[$i];
										$i++;
										
									}
									
									// Если необходимо добавить многоточие
									if (mb_strlen($str) > 250) {
										$new_str .= '...';
									}
									echo $new_str;								
								?></p>
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>
		<?php endforeach; ?>
		
	</div>
	<div class="span3" >
		<div class="row-fluid">
			<div class="span12 inner_right_banner">
				<div class="row-fluid">
					<div class="span12" >
						<div class="span10" >
							<img src="/images/feniks.jpg" >
						</div>
						<h5><a href="#" >Магазины "Кухни&Кухоньки"</a></h5>
						<p>
							Более 200 видов кухонных гарнитуров всегда в наличии в магазинах сети
						</p>
						<hr />
					</div>
				</div>
				
				<div class="row-fluid">
					<div class="span12" >
						<div class="span10" >
							<img src="/images/gloria.jpg" >
						</div>	
						<h5><a href="#" >Кухни "Villeroy&Bosch"</a></h5>
						<p>
							Вы достойны лучшего!
						</p>
						<hr />
					</div>
				</div>
				<a href="#" >Разместить специальное предложение</a>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
	<?=$pagination?>
</div>	