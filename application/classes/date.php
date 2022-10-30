<?php defined('SYSPATH') or die('No direct script access.');
class Date extends Kohana_Date {
	
	public static function arr_months(){
		return array(
					'',
					'января',
					'февраля',
					'марта',
					'апреля',
					'мая',
					'июня',
					'июля',
					'августа',
					'сентября',
					'октября',
					'ноября',
					'декабря',
				);
	}
	
	public static function month($num){
		return Arr::get(Date::arr_months(),$num);
	}
	
	public static function cyrdate($timestamp){
		$date=explode(".", date("d.n.Y",$timestamp));
		return $date[0].'&nbsp;'.Date::month($date[1]).'&nbsp;'.$date[2];
	}
	
}       
    ?>