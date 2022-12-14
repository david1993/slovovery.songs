<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @package  Captcha
 *
 * Captcha configuration is defined in groups which allows you to easily switch
 * between different Captcha settings for different forms on your website.
 * Note: all groups inherit and overwrite the default group.
 *
 * Group Options:
 *  type		Captcha type, e.g. basic, alpha, word, math, riddle
 *  width		Width of the Captcha image
 *  height		Height of the Captcha image
 *  complexity	Difficulty level (0-10), usage depends on chosen style
 *  background	Path to background image file
 *  fontpath	Path to font folder
 *  fonts		Font files
 *  promote		Valid response count threshold to promote user (FALSE to disable)
 */

return array(
	'default' => array(
		'style'      	=> 'basic',
		'width'      	=> 150,
		'height'     	=> 50,
		'complexity' 	=> 4,
		'background' 	=> '',
		'fontpath'   	=> MODPATH.'captcha/fonts/',
		'fonts'      	=> array('dejavuserif.ttf'),
		'promote'    	=> FALSE,
	),
	// Words of varying length for Captcha_Word to pick from
	// Note: all Unicode characters should work, but not everyone can type them, so be careful with that (no japanese/chinese captcha please ;))
	'words' => array
	(
		'cd', 'tv', 'it', 'to', 'be', 'or',
		'sun', 'car', 'dog', 'bed', 'kid', 'egg',
		'bike', 'tree', 'bath', 'roof', 'road', 'hair',
		'hello', 'world', 'earth', 'beard', 'chess', 'water',
		'barber', 'bakery', 'banana', 'market', 'purple', 'writer',
		'america', 'release', 'playing', 'working', 'foreign', 'general',
		'aircraft', 'computer', 'laughter', 'alphabet', 'kangaroo', 'spelling',
		'architect', 'president', 'cockroach', 'encounter', 'terrorism', 'cylinders',
	),
	// Riddles for Captcha_Riddle to pick from
	// Note: use only alphanumeric characters
	'riddles' => array
    (
        'Do you hate spam? (yes or no)' => 'yes',
        'Are you a robot? (yes or no)' => 'no',
    ),

);
