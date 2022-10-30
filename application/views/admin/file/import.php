<div class="row-fluid">
	<div class="span12 pull-left">
	</div>
	<? foreach ($companies as $company): ?>
		<div class="span12 pull-left">
			<span>Продавец: </span><a href="/user/index/<?=$company->id?>/"><?=$company->company_name?></a>
		</div>
	<?php endforeach;?>	
	<div class="span12 pull-left">
		<span>Файл: </span><a href="<? echo 'http://'.$_SERVER['SERVER_NAME'].substr($path, 1); ?>"><? echo 'http://'.$_SERVER['SERVER_NAME'].substr($path, 1); ?></a>
	</div>
	<?php
		define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
		
		date_default_timezone_set('Europe/London');
		
		require_once 'Classes/PHPExcel/IOFactory.php';
		
		require_once 'xml.php';
		
		if (!file_exists ($path)){
			die ("File not exist");
		}
		$strpos = strpos($path, ".xls");
		
		if ($strpos > -1) { 
			$objPHPExcel = PHPExcel_IOFactory::load($path);
			$i = 2;
			$fcategories = array();
			while ($category = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue()) {
				array_push($fcategories, $category); 
				if ($category == '')
					break;
				$i++;
			}
			$fcategories = array_unique ($fcategories);
			//print_r ($fcategories);
		}
		
		$strpos = strpos($path, ".csv");
		
		if ($strpos > -1) { 
			$objReader = PHPExcel_IOFactory::createReader('CSV')->setDelimiter(',')
                                                    ->setEnclosure('"')
                                                    ->setLineEnding("\r\n")
                                                    ->setSheetIndex(0);
			$objPHPExcelFromCSV = $objReader->load($path);
			$worksheet = $objPHPExcelFromCSV->getActiveSheet();
			
			$i = 0;
			$fcategories = array();
			foreach ($worksheet->getRowIterator() as $row) {
			    $cellIterator = $row->getCellIterator();
			    $cellIterator->setIterateOnlyExistingCells(false);
			    foreach ($cellIterator as $cell) {
			        if (!is_null($cell)) {
				  $cell_array = explode(';', $cell->getValue());
				  if ($i > 0)
					array_push($fcategories, $cell_array[2]);
				  $i++;
			        }
			    }
			}
			$fcategories = array_unique ($fcategories);

		}
		$strpos = strpos($path, ".xml");
		
		if ($strpos > -1) { 
			$data = file_get_contents($path);
			$dom = new DomDocument();
			$dom->loadXML($data);
			$temp_categories = $dom->getElementsByTagName('category');
			$fcategories = array();
			foreach ($temp_categories as $category) {
				array_push ($fcategories, $category->nodeValue);
			}
		}
		function echospaces($depth) {
			$str = '';
			for ($i = 1; $i < $depth; $i++){
				$str .= '&nbsp;&nbsp;&nbsp;';
			}
			return $str;
		}
	?>
	<form method="post" enctype="multipart/form-data" class="span12" action="/file/finish/<?=$id?>">
		<div class="row-fluid">
			<div class="span5 pull-left">
				<h4>Разделы в файле</h4>
			</div>
			<div class="span2 pull-left">
			</div>
			<div class="span5 pull-left">
				<h4>Разделы на сайте</h4>
			</div>
		</div>
		<?php foreach ($fcategories as $fcategory):?>
		<div class="row-fluid">
			<div class="span5 pull-left">
				<?php echo $fcategory; ?>
				<input type="hidden" name="fcategories[]" value="<?php echo $fcategory; ?>" />
			</div>
			<div class="span2 pull-left">
				<i class="icon-circle-arrow-right"></i>
			</div>
			<div class="span5 pull-left">
				<select name="categories[]">
					<?php 
						$prev_pid = 0; $prev_id = 1; $depth = 0; $flag = TRUE;
						foreach ($categories as $node):
					?>
						
					<?php
						if($node['parent_id'] == $prev_id)
						{
							$depth++;
							$flag = TRUE;
						}
						elseif($node['parent_id'] != $prev_pid)
						{
							$depth--;
							$flag = FALSE;
						}
						if ($node['parent_id'] != $prev_pid && $prev_id != 1 && $depth == 1 && $depth == 2) {
							echo '</option>';
						}
						if ($node['rgt'] - $node['lft'] != 1){
							if ($node['parent_id'] != $prev_pid && $flag) { 
								echo '<option value="'.$node['id'].'">'.echospaces($depth).$node['name'].'</option>';
								$flag = TRUE;
							}
							elseif ($flag) {
								echo '<option value="'.$node['id'].'">'.echospaces($depth).$node['name'].'</option>';
								$flag = FALSE;
							}
							else {
								echo '<option value="'.$node['id'].'">'.echospaces($depth).$node['name'].'</option>';
								$flag = FALSE;
							}
						}
						else {
							if ($flag) {
								echo '<option value="'.$node['id'].'">'.echospaces($depth).$node['name'].'</option>';
							}
							else {
								echo '<option value="'.$node['id'].'">'.echospaces($depth).$node['name'].'</option>';
								$flag = TRUE;
							}
						}
						$prev_id = $node['id'];
						$prev_pid = $node['parent_id'];
					?>
						
					<?php endforeach;?>
				</select>
			</div>
		</div>
		<?php endforeach;?>
		<div class="span12 pull-left">
			
				<div class="control-group">
					<div class="controls"  >
						<button class="medium_button" type="submit">Продолжить импорт</button>
					</div>
				</div>
			
		</div>
	</form>
	<div class="span12 pull-left">
		<a href="#">Не импортировать, отправить сообщение продавцу</a>
	</div>

</div>