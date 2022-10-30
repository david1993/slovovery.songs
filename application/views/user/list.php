<?php defined('SYSPATH') or die('No direct script access.');
foreach ($users as $user){
	echo '<p>'.$user->username.' ('.$user->email.')</p>';
}        
    