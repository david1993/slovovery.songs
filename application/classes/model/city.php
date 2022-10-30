<?php defined('SYSPATH') or die('No direct script access.');

class Model_City extends ORM {
	
	protected $_has_many = array(
		'shops' => array(
			'model' => 'shop',
			'through' => 'shops_cities',
			'foreign_key' => 'city_id',
			'far_key' => 'shop_id', 
		),
	);
	
}