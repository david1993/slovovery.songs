<?php
$callback = $_GET['CKEditorFuncNum'];
		$file_name = $_FILES['upload']['name'];
		$file_name_tmp = $_FILES['upload']['tmp_name'];
		$file_new_name = '/images/'; // серверный адрес - папка для сохранения файлов. (нужны права на запись)
		$full_path = $file_new_name.$file_name;
		$http_path = '/images/'.$file_name; // адрес изображения для обращения через http
		$message = '';
		echo move_uploaded_file($file_name_tmp, $full_path); exit;
		if(move_uploaded_file($file_name_tmp, $full_path) )
		{
			$message = 'Файл успешно загружен';
		} else
		{
			$message = 'Ошибка, повторите попытку позже'; // эта ошибка появится в браузере если скрипт не смог загрузить файл
			$http_path = '';
		}
		echo '<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction("'.$callback.'", "'.$full_path.'","'.$message.'" );</script>';
	?>