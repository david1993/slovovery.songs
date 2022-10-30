<?php defined('SYSPATH') or die('No direct script access.');
class Model_File extends ORM {

	const FILE_PATH = './files/';

	/*public function rules(){
		return array(
				'file' => array(
						array('Upload::valid'),
						array('Upload::not_empty'),
						array('Upload::type', array(':value', array('csv','xsl', 'yml', 'png'))),
						array(array($this, 'file_save'), array(':value'))
				),
		);
	}*/
	
	public function create_file(){
		
		$this->user_id = Auth::instance()->get_user();
		$now = getdate();
		$this->datetime = strtotime(date("j-m-Y, H:i:s", time()));
		$this->status = 0;
		
		$dir = $this->get_dir();
		$path = self::FILE_PATH.$dir;
		$count = count($_FILES['files']['name']);
		if(!file_exists($path)){
			mkdir($path, 0777, true);
		}
		
		//$this->values(array($path), array('path'));
		
		if(isset($_FILES['files'])){
			$file_validation = Validation::factory($_FILES)
				->rule('files', 'Upload::valid')
				->rule('files','Upload::type_a', array(':value', array('csv','xls', 'xlsx', 'xml')))
				->rule('files','Upload::size_a', array(':value', '3M'));
			
			$this->check($file_validation);
		}
		if (isset($_POST['fileByUrl'])){
			$file = $_POST['fileByUrl'];
			$filename = preg_replace('/\s+/u', '_', $file);
			$ext = substr($file,-4);
			if (@fopen($file,"rb")){
		        $content = file_get_contents($file);
		        $filename = $path.md5(mt_rand().time()).$ext;
		        $file = fopen($filename,"a+");
		        ftruncate($file,0);
		        fwrite($file,$content);
		        fclose($file);
		        $this->path = $filename;
	        }
		}
		if ($file_validation->check()){
			for($i = 0; $i < $count; $i++){		
				$filename = preg_replace('/\s+/u', '_', $_FILES['files']['name'][$i]);
				if($filename)
				{
					Upload::save_a($_FILES['files'], $filename , $path, $i, 0777);
					$this->path = $path . $filename;
				}
			}			
	        return $this->create();
		}
	}
	
	/*public static function file_save($value){
		// upload file
		$uploaded = Upload::save($value, $value['name'], $this->get_dir());
		
		// if uploaded set file name to save to database
		if ($uploaded)
		{
			// set file name
			$this->set('file', $value['name']);
		}
		
		// return result
		return $uploaded;
	}*/
	
	public function get_dir(){
		$dirnum = round($this->id/500)+1;
		return $dirnum."/".$this->id;
	}
	
	public function create(Validation $validation = NULL){
		parent::create($validation);
		return $this;
	}
}
?>