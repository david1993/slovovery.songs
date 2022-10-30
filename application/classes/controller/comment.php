<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Comment extends Controller_Layout {
	
	public static function get_models_id($model,$flip = false)
	{
		$models_id = array(
			'shop'         => 1,
			'tovar'        => 2,
		);
		
		if($flip) $models_id = array_flip($models_id);
		
		return isset($models_id[$model])?$models_id[$model]:false;
	}
	
	public function action_index()
	{
	}
	
	public function action_add()
	{
		if(Auth::instance()->logged_in('login'))
		{
			$user = Auth::instance()->get_user();
			
			$values = array();
			$values['model_id'] = self::get_models_id($this->request->param('model'));
			$values['page_id'] = $this->request->param('id');
			$values['author'] = ($user->name)?$user->name:$user->username;
			$values['text'] = htmlspecialchars($this->request->post('text'));
			$values['date'] = time();
			$values['active'] = 1;
			
			try 
			{
				$comment = ORM::factory('comment')->create_comment($values, array(
					'model_id',	
					'page_id',
					'author',
					'text',	
					'date',	
					'active',	
				));			  
				
				
				//
				$object = ORM::factory($this->request->param('model'),$this->request->param('id'));
				if($object->loaded())
				{
					$object -> comments_count = $object->comments_count+1;
					$object -> save();
				}
				$this->request->redirect($this->request->referrer().'#comment');
			} 
			catch (ORM_Validation_Exception $e) 
			{
				$this->request->redirect($this->request->referrer());
				$errors = $e->errors('models');
			
			}
		}
		else
		{
			$this->request->redirect('/');
		}
	}
	
	public function action_delete()
	{
		$id = $this->request->param('id');
		$comment = ORM::factory('comment',$id);
		$per_page = Arr::get($_GET,'per_page',5);
		if($comment->loaded()&&Auth::instance()->logged_in('admin'))
		{		
				$model = self::get_models_id($comment->model_id,true);
				$id = $comment->page_id;
				if($comment->delete())
				{
					$object = ORM::factory($model,$id);
					if($object->loaded())
					{ 
						$object->comments_count = $object->comments_count - 1;
						$object->save();
					}
				}
				$this->request->redirect('/admin/comment/?per_page='.$per_page);
				
		}
	}	
	
	public function action_deleteItems(){
		if (HTTP_Request::POST == $this->request->method()&& Auth::instance()->logged_in('admin') && isset($_POST['comment'])){
				$comments_id = $_POST['comment'];
				foreach($comments_id as $comment_id)
				{
					$comment = ORM::factory('comment',$comment_id);
					if($comment->loaded())
					{	
						$model = self::get_models_id($comment->model_id);
						$id = self::get_models_id($comment->page_id);
						if($comment->delete())
						{
							$object = ORM::factory($model,$id);
							if($object->loaded())
							{
								$object->comments_count = $object->comments_count - 1;
								$object->save();
							}
						}
					}
				}
				$_POST = array();
					
		}
		$this->request->redirect($this->request->referrer());
	}
	
}