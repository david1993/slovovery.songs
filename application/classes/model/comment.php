<?php defined('SYSPATH') or die('No direct script access.');
class Model_Comment extends ORM {
	
	public function labels()
	{
		return array(
			'text'		=> '',
		);
	}
	
	public function rules()
	{
	    return array(
	       'text' => array(
	            array('not_empty'),
		        array('max_length', array(':value', 65500)),
	        )
	    );
	}
	
	public function create_comment($values,$expected)
	{
		$this->values($values,$expected);	
        return $this->create();
	}
}