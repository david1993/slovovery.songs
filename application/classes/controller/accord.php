<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Accord extends Controller_Layout {
	public function action_add() {
		$song_id = $this->request->param ( 'id' );
	
		$user = Auth::instance ()->get_user ();
	
		
	
		if (HTTP_Request::POST == $this->request->method ()) {
			try {
				$accord = ORM::factory ( 'accord' );
	
				$accord->active = 1;
				$accord->id_user=$user->id;
				$accord->id_song=$song_id;
				$accord->publish_time=time();
				$text=$_POST['text'];
				$text=trim($text);
				$text=str_replace("\n","<br/>", $text);
				$accord->text=$text;
				$accord->create ();
				if(count($_FILES['images']['name']))
				{
					$accord -> save_images($song_id);
				}
		
	
				$_POST = array ();
			} catch ( ORM_Validation_Exception $e ) {
	
				$message = 'Не удалось создать aккорд.';
	
				$errors = $e->errors ( 'models' );
			}
		}
		$this->request->redirect($_SERVER['HTTP_REFERER']);
	}
	public function action_delete() {
		$id = $this->request->param('id');
		$accord = ORM::factory('accord',$id);
		$user = Auth::instance ()->get_user ();
		if($user->id==$accord->id_user or Auth::instance()->logged_in('admin')){
			$accord->delete_image();
			$accord->delete();
		}
		$this->request->redirect($_SERVER['HTTP_REFERER']);
	}
	
	
}
?>