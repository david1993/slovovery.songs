<?php defined('SYSPATH') or die('No direct script access.');
class  Form extends Kohana_Form {
	
	public static function alert($value,$class)
	{
		if(isset($value)){
			echo '<div class="alert '.$class.'">'.$value.'</div>';
		}
	}
	
	public static function important($value){
		if(isset($value)){
			echo '<span class="label label-important">'.$value.'</span>';
		}
	}
	
	public static function field($name,$labels,$values,$errors,$type='input',$requried=FALSE,$help = FALSE,$class = FALSE){
		echo '<div class="control-group">';
		echo $labels[$name] ? '<label class="control-label '.$class.'" >'.$labels[$name].(($requried)?'<b class="text-error">*</b>':'').':</label>':'';
		echo '<div class="controls" >';
		switch ($type){
			case 'input':
				echo '<input type="text" name="'.$name.'" class="span12" value="'.HTML::chars(Arr::get($values, $name)).'"/>';
			break;
			case 'hidden':
				echo '<input type="hidden" name="'.$name.'" value="'.HTML::chars(Arr::get($values, $name)).'"/>';
			break;
			case 'customInput':
				echo '<input type="text" name="'.$name.'" class="' . $name . ' '.$class.'" value="'.HTML::chars(Arr::get($values, $name)).'"/>';
			break;
			case 'textarea':
				echo '<textarea row="5" name="'.$name.'" class="span12">'.HTML::chars(Arr::get($values, $name)).'</textarea>';
			break;
			case 'textareaEditable':
				echo '<textarea row="5" id="textID" name="'.$name.'" class="span12">'.HTML::chars(Arr::get($values, $name)).'</textarea>';
			break;
			case 'span':
				echo '<span>'.HTML::chars(Arr::get($values, $name)).'</span><input type="hidden" name="'.$name.'" class="span5" value="'.HTML::chars(Arr::get($values, $name)).'"/>';
			break;
			case 'select':
				echo '<select name="'.$name.'" class="span12">';
				foreach ($values as $key => $value){
					echo '<option value="' . $key . '">' . $value . '</option>';
				}
				echo '</select>';
			break;
			case 'selectMultiple':
				echo '<select name="'.$name.'[]" class="span12" multiple="multiple">';
				foreach ($values as $key => $value){
					echo '<option value="' . $key . '">' . $value . '</option>';
				}
				echo '</select>';
			break;
			case 'checkbox':
				foreach ($values as $key => $value){
					echo '<label class="checkbox"><input type="checkbox" name="'.$name.'[]" value="'.$key.'" />'.$value.'</label>';
				}
			break;
			case 'checkboxWithFields':
				foreach ($values as $key => $shop){
					echo '<label class="checkbox"><input type="checkbox" name="'.$name.'[]" value="'.$key.'"'.(@is_array($_POST['shop'])&&in_array($key,$_POST['shop']) ? 'checked':'').' /><b>'.$shop['name'].'</b>  '.$shop['address'].'</label>';
					echo '<div class="dopfields">';
					
					$val = (@is_array($_POST['url'])&&isset($_POST['url'][$key]))?$_POST['url'][$key]:'';
					if($shop['kind_id']==2) echo '<div class="control-group link" ><label class="control-label" >URL страницы товара:</label><div class="controls" ><input class="subfield" type="text" name="url['.$key.']" value="'.$val.'"></div></div>';
					
					$val = (@is_array($_POST['price_shop'])&&isset($_POST['price_shop'][$key]))?$_POST['price_shop'][$key]:'';
					echo '<div class="control-group link" ><label class="control-label" >Цена в магазине:</label><div class="controls" ><input class="subfield price_shop" type="text" name="price_shop['.$key.']" value="'.$val.'"></div></div></div>';
				}
			break;
			default: break;
		}
		if($help) echo '<span class="help-block">'.$help.'</span>';
		echo Form::important(Arr::get($errors, $name)).'</div></div>';
		
	}
	
	public static function inputHidden($name,$values,$errors){
		echo '<input type="hidden" name="'.$name.'" value="' . $values . '"/>';
		echo Form::important(Arr::get($errors, $name));
	}
}       
    ?>