<?php defined('SYSPATH') or die('No direct script access.');
return array(
    'username' => array(
        'not_empty' => 'Введите имя.',
        'min_length' => 'Должно быть не меньше :param2 символов.',
        'max_length' => 'Должно быть не длиннее :param2 символов.',
        'username_available' => 'Пользователь с таким адресом уже существует в системе',
        'unique' => 'Пользователь с таким адресом уже существует в системе',
    ),
    'email' => array(
        'not_empty' => 'Введите эл.почту',
        'min_length' => 'This email is too short, it must be at least :param2 characters long',
        'max_length' => 'This email is too long, it cannot exceed :param2 characters',
        'email' =>   'Пожалуйста, введите правильный адрес электронной почты.',
        'email_available' => 'Этот адрес уже используется.',
    	'unique' => 'Этот адрес уже используется',
    ),
    'password' => array(
    	'not_empty' => 'Введите пароль'
    )
);        
    