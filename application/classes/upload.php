<?php defined('SYSPATH') or die('No direct script access.');
class  Upload extends Kohana_Upload {
	
	
	public static function size_a(array $file, $size)
	{
		$status = true;
		$count = count($file['name']);
		$size = Num::bytes($size);
		
		if ($file['error'] === UPLOAD_ERR_INI_SIZE)
		{
			// Upload is larger than PHP allowed size (upload_max_filesize)
			return FALSE;
		}
		
		// Convert the provided size to bytes for comparison
		for($i = 0; $i < $count;$i++){
			if($size < $file['size'][$i]) 
			{
				$status = false; break;
			}
		}

		// Test that the file is under or equal to the max size
		return $status;
	}
	
	public static function type_a(array $file, array $allowed)
	{
		$status = true;
		$count = count($file['name']);
		
		for($i = 0; $i < $count;$i++){
			if($file['name'][$i]){
				$ext = strtolower(pathinfo($file['name'][$i], PATHINFO_EXTENSION));
				if(!in_array($ext, $allowed)) 
				{
					$status = false; break;
				}
			}
		}
		
		return $status;
	}

	public static function save_a(array $file, $filename = NULL, $directory = NULL,$index = null, $chmod = 0644)
	{
		if ( ! isset($file['tmp_name'][$index]) OR ! is_uploaded_file($file['tmp_name'][$index]))
		{
			// Ignore corrupted uploads
			return FALSE;
		}

		if ($filename === NULL)
		{
			// Use the default filename, with a timestamp pre-pended
			$filename = uniqid().$file['name'][$index];
		}

		if (Upload::$remove_spaces === TRUE)
		{
			// Remove spaces from the filename
			$filename = preg_replace('/\s+/u', '_', $filename);
		}

		if ($directory === NULL)
		{
			// Use the pre-configured upload directory
			$directory = Upload::$default_directory;
		}

		if ( ! is_dir($directory) OR ! is_writable(realpath($directory)))
		{
			throw new Kohana_Exception('Directory :dir must be writable',
				array(':dir' => Debug::path($directory)));
		}

		// Make the filename into a complete path
		$filename = realpath($directory).DIRECTORY_SEPARATOR.$filename;

		if (move_uploaded_file($file['tmp_name'][$index], $filename))
		{
			if ($chmod !== FALSE)
			{
				// Set permissions on filename
				chmod($filename, $chmod);
			}

			// Return new file path
			return $filename;
		}

		return FALSE;
	}
	
}       
?>