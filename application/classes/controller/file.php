<?php defined('SYSPATH') or die('No direct script access.');

class Controller_File extends Controller_Layout {
	public static function nav() { 
		return array(
					'Контент'=>array('href'=>'/admin/content/'),
					'Акции'=>array('href'=>'/admin/stock/'),
					'Отзывы'=>array('href'=>'/admin/comment/'),
					'Продавцы'=>array('href'=>'/admin/company/'),
					'Города'=>array('href'=>'/admin/city/'),
					'Настройки'=>array('href'=>'/admin/settings/'),
				); 
	}
	public function before()
	{
		parent::before();
		$this->template->navibar = View::factory('admin/navibar')->set('nav',$this->nav());
		if (!Auth::instance()->logged_in('admin'))
		{
			Request::current()->redirect('user/index');
		}
	}
	public function action_index()
	{	
		
	}
	public function action_start()
	{	
		$id = $this->request->param('id');

		$this->template->h1 = 'Импорт файла';

		$this->template->content = View::factory('admin/file/start_import')
									->bind('path',$path)
									->bind('id',$id)
									->bind('companies',$companies);
		$file = ORM::factory('file',$id);
		$path = $file->path;
		
		$companies = ORM::factory('company');
		$companies = $companies->where('user_id', '=', $file->user_id)->find_all();
	}
	public function action_import()
	{	
		$id = $this->request->param('id');
		
		$this->template->h1 = 'Импорт файла';

		$this->template->content = View::factory('admin/file/import')
									->bind('path',$path)
									->bind('id',$id)
									->bind('companies',$companies)
									->bind('categories', $categories);
		$file = ORM::factory('file',$id);
		$path = $file->path;
		
		$companies = ORM::factory('company');
		$companies = $companies->where('user_id', '=', $file->user_id)->find_all();
		
		$user=Auth::instance()->get_user();
		$categories = ORM::factory('category',1)->get_subtree_for_user($user->id);
	}
	public function action_finish()
	{
		$id = $this->request->param('id');
		
		$categories = Arr::get($_POST,'categories',1);
		$fcategories = Arr::get($_POST,'fcategories',1);
		
		$this->template->h1 = 'Импорт файла';
	
		$this->template->content = View::factory('admin/file/finish_import')
									->bind('path', $path)
									->bind('id', $id)
									->bind('companies', $companies)
									->bind('count', $good_count)
									->bind('bad_count', $bad_count);
		$file = ORM::factory('file',$id);
		$path = $file->path;
	
		$companies = ORM::factory('company');
		$companies = $companies->where('user_id', '=', $file->user_id)->find_all();
		
		define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
		
		date_default_timezone_set('Europe/London');
		
		require_once 'classes/PHPExcel/IOFactory.php';
		
		$strpos = strpos($file->path, ".xls");
		
		$bad_count = 0;
		
		if ($strpos > -1) { 
		
			$objPHPExcel = PHPExcel_IOFactory::load($file->path);
			$i = 2;
			while ($number = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue()) {
				$temp_id = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
				$temp_category = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
				$temp_name = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
				$temp_price = intval ($objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue());
				$temp_producer = intval ($objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue());
				$temp_description = $objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
				if ($temp_id != NULL && !empty($temp_id) && $temp_name != NULL && !empty($temp_name) && $temp_category != NULL && !empty($temp_category) && $temp_producer != NULL && !empty($temp_producer) && $temp_producer > 0 && $temp_price != NULL && !empty($temp_price) && $temp_price > 0) { 
					$tovar = ORM::factory('tovar');
					$category_key = array_keys($fcategories, $temp_category);
					$values = array (
							'category_id' => $categories[$category_key[0]],
							'name' => $temp_name,
							'price' => $temp_price,
							'producer_id' => $temp_producer,
							'description' => $temp_description,
							'user_id' => $file->user_id
					);
				
					if (count($tovar->where('id', '=', $temp_id)->find_all()) > 0)
						$is_exist_tovar = true;
					else 
						$is_exist_tovar = false;
					if (!$is_exist_tovar) {
						$tovar->create_tovar($values, array(
								'category_id',
								'name',
								'price',
								'producer_id',
								'description',
								'user_id'
						));
						 
						$tovar->save();
					}
					else {
						$tovar->save_tovar($values, array(
								'category_id',
								'name',
								'price',
								'producer_id',
								'description',
								'user_id'
						));
					}
				}
				else {
					$bad_count++;
				}
				$i++;
				if ($number == '')
					break;
			}
			$count = $i-2;
			$fcategories = array_unique ($fcategories);
			$good_count = $count - $bad_count;
		}
		
		$strpos = strpos($file->path, ".csv");
		
		if ($strpos > -1) { 
			$objReader = PHPExcel_IOFactory::createReader('CSV')->setDelimiter(',')
                                                    ->setEnclosure('"')
                                                    ->setLineEnding("\r\n")
                                                    ->setSheetIndex(0);
			$objPHPExcelFromCSV = $objReader->load($path);
			$worksheet = $objPHPExcelFromCSV->getActiveSheet();
			$i = 0;
			foreach ($worksheet->getRowIterator() as $row) {
			    $cellIterator = $row->getCellIterator();
			    $cellIterator->setIterateOnlyExistingCells(false);
			    foreach ($cellIterator as $cell) {
			        if (!is_null($cell)) {
				  $cell_array = explode(';', $cell->getValue());
				  if ($i > 0) {
					$temp_id = $cell_array[1];
					$temp_category = $cell_array[2];
					$temp_name = $cell_array[3];
					$temp_price = intval ($cell_array[4]);
					$temp_producer = intval ($cell_array[5]);
					$temp_description = $cell_array[6];
					if ($temp_id != NULL && !empty($temp_id) && $temp_name != NULL && !empty($temp_name) && $temp_category != NULL && !empty($temp_category) && $temp_producer != NULL && !empty($temp_producer) && $temp_producer > 0 && $temp_price != NULL && !empty($temp_price) && $temp_price > 0) { 
						$tovar = ORM::factory('tovar');
						$category_key = array_keys($fcategories, $temp_category);
						$values = array (
								'category_id' => $categories[$category_key[0]],
								'name' => $temp_name,
								'price' => $temp_price,
								'producer_id' => $temp_producer,
								'description' => $temp_description,
								'user_id' => $file->user_id
						);
						if (count($tovar->where('id', '=', $temp_id)->find_all()) > 0)
							$is_exist_tovar = true;
						else 
							$is_exist_tovar = false;
						if (!$is_exist_tovar) {
							$tovar->create_tovar($values, array(
									'category_id',
									'name',
									'price',
									'producer_id',
									'description',
									'user_id'
							));
							 
							$tovar->save();
						}
						else {
							$tovar->save_tovar($values, array(
									'category_id',
									'name',
									'price',
									'producer_id',
									'description',
									'user_id'
							));
						}
					}
					else {
						$bad_count++;
					}
				  }
				  $i++;
			        }
			    }
			}
			$count = $i-1;
			$fcategories = array_unique ($fcategories);
			$good_count = $count - $bad_count;
		}
		$strpos = strpos($file->path, ".xml");
		
		function getCategory ($path, $id) {
			$data = file_get_contents($path);
			$dom = new DomDocument();
			$dom->loadXML($data);
			$category = $dom->getElementsByTagName('category');
			foreach ($category as $t) {
				if ($t->getAttribute('id') == $id)
					return $t->nodeValue;
			}
			
		}
		
		if ($strpos > -1) {
			$data = file_get_contents($file->path);
			$dom = new DomDocument();
			$dom->loadXML($data);
			$offers = $dom->getElementsByTagName('offer');
			$i = 0;
			foreach ($offers as $offer) {
				$i++;
				$temp_id = $offer->getAttribute('id');
				$categoryIds = $offer->getElementsByTagName('categoryId');
				foreach ($categoryIds as $categoryId) {
					$temp_category = getCategory($file->path, $categoryId->nodeValue);
				}	
				$names = $offer->getElementsByTagName('name');
				$temp_name = "";
				foreach ($names as $name) {
					$temp_name = $name->nodeValue;
				}
				if ($temp_name == "") $temp_name = "undefined";
				$prices = $offer->getElementsByTagName('price');
				foreach ($prices as $price) {
					$temp_price = $price->nodeValue;
				}
				$temp_producer = 1;
				/*$country_of_origins = $offer->getElementsByTagName('country_of_origin');
				foreach ($country_of_origins as $country_of_origin) {
					$temp_producer = $country_of_origin->nodeValue;
				}*/
				$descriptions = $offer->getElementsByTagName('description');
				foreach ($descriptions as $description) {
					$temp_description = $description->nodeValue;
				}
				if ($temp_id != NULL && !empty($temp_id) && $temp_name != NULL && !empty($temp_name) && $temp_category != NULL && !empty($temp_category) && $temp_producer != NULL && !empty($temp_producer) && $temp_producer > 0 && $temp_price != NULL && !empty($temp_price) && $temp_price > 0) { 
					$tovar = ORM::factory('tovar');
					$category_key = array_keys($fcategories, $temp_category);
					$values = array (
							'category_id' => $categories[$category_key[0]],
							'name' => $temp_name,
							'price' => $temp_price,
							'producer_id' => $temp_producer,
							'description' => $temp_description,
							'user_id' => $file->user_id
					);
					if (count($tovar->where('id', '=', $temp_id)->find_all()) > 0)
						$is_exist_tovar = true;
					else
						$is_exist_tovar = false;
					if (!$is_exist_tovar) {
						$tovar->create_tovar($values, array(
								'category_id',
								'name',
								'price',
								'producer_id',
								'description',
								'user_id'
						));
				
						$tovar->save();
					}
					else {
						$tovar->save_tovar($values, array(
								'category_id',
								'name',
								'price',
								'producer_id',
								'description',
								'user_id'
						));
					}
				}
				else {
					$bad_count++;
				}
			}

			$count = $i-1;
			$fcategories = array_unique ($fcategories);
			$good_count = $count - $bad_count;
		}
		$file->set('status', 1)->save();
	}
	
	
}
?>