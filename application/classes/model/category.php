<?php defined('SYSPATH') or die('No direct script access.');
class Model_Category extends ORM {
	public function rules()
	{
		return array(
	        'name' => array(
		array('not_empty'),
		array('max_length', array(':value', 255)),
		),
		);
	}

	public function filters()
	{
		return array(
	        'name' => array(
		array('trim'),
		),
		);
	}

	public function get_path()
	{
		return DB::select('parent.name','parent.id')
		->from(array($this->_table_name,'node'))
		->from(array($this->_table_name,'parent'))
		->where('node.lft','BETWEEN',array(DB::expr('parent.lft'),DB::expr('parent.rgt')))
		->and_where('node.id','=',$this->id)
		->execute($this->_db);
	}

	public function inc_count($added=1)
	{
		$query = DB::query(Database::UPDATE, 'UPDATE categories AS node,categories AS parent
			SET parent.tovars_count=parent.tovars_count + :added
			WHERE node.lft BETWEEN parent.lft AND parent.rgt
        	AND node.id =:category_id')
		->param(':category_id',$this->id)
		->param(':added',$added);
		return 	$query->execute($this->_db);
	}

	public function dec_count($deleted=1)
	{
		$query = DB::query(Database::UPDATE, 'UPDATE categories AS node,categories AS parent
			SET parent.tovars_count=parent.tovars_count - :deleted
			WHERE node.lft BETWEEN parent.lft AND parent.rgt
        	AND node.id =:category_id')
		->param(':category_id',$this->id)
		->param(':deleted',$deleted);
		return 	$query->execute($this->_db);
	}

	public function rebuild_leafs_counts()
	{
		//UPDATE categories SET categories.tovars_count=
		//(SELECT COUNT(tovars.id) as c FROM tovars WHERE categories.id=tovars.category_id GROUP BY categories.id)
		
		$query = DB::query(Database::UPDATE, 'UPDATE categories SET categories.tovars_count=(SELECT COUNT(tovars.id) FROM tovars WHERE categories.id=tovars.category_id AND tovars.active = 1 GROUP BY categories.id)');
		return 	$query->execute($this->_db);
	}
	
	public function rebuild_parents_counts()
	{
		$query = DB::query(Database::UPDATE, 'UPDATE categories,(SELECT SUM(node.tovars_count) as nc, parent.id AS pid FROM categories AS node,categories AS parent WHERE node.lft BETWEEN parent.lft AND parent.rgt AND node.rgt = node.lft+1 AND node.id<>parent.id GROUP BY parent.id) as cats SET categories.tovars_count=cats.nc WHERE categories.id=cats.pid');
		return 	$query->execute($this->_db);
	}
	
	public function rebuild_counts()
	{
		$this->rebuild_leafs_counts();
		$this->rebuild_parents_counts();
	}

	public function get_subcats()
	{
		return DB::select('name','id')
		->from($this->_table_name)
		->where('parent_id','=',$this->id)
		->execute($this->_db);
	}


	public function get_subtree() {
		return DB::select('name','id','parent_id','lft','rgt')
		->from($this->_table_name)
		->where('lft','>',$this->lft)
		->and_where('lft','<',$this->rgt)
		->order_by('lft')
		->execute($this->_db);
	}
	
	/*public function get_subtree_for_shop($shop_id) {
		return $shops = DB::query(Database::SELECT, "SELECT parent.name,parent.id,parent.parent_id,parent.lft,parent.rgt,count(tovar_id) as tovars_count
FROM categories AS node,categories AS parent, shops_tovars, tovars 
WHERE node.lft BETWEEN parent.lft AND parent.rgt AND node.rgt = node.lft+1 AND node.id<>parent.id AND parent.id<>1 AND shop_id = {$shop_id} AND tovar_id = tovars.id AND tovars.category_id = node.id GROUP BY parent.lft")
						->execute()
						->as_array();
	}*/
	
	public function get_subtree_for_shop($shop_id) {
		return DB::query(Database::SELECT, "SELECT main.id,main.name,main.parent_id,main.lft,main.rgt, case
when main.tovars_count > 0 then main.tovars_count
when prnt.nc > 0 then prnt.nc
else 0
end as tovars_count
FROM (
		SELECT mnode.id,mnode.name,mnode.parent_id,mnode.lft,mnode.rgt,node.tovars_count as tovars_count
		FROM categories as mnode LEFT JOIN (
				SELECT COUNT(tovars.id) as tovars_count,categories.id,lft,rgt 
				FROM tovars, categories, shops_tovars 
				WHERE shop_id = {$shop_id} AND tovar_id = tovars.id AND categories.id=tovars.category_id GROUP BY categories.id
		) AS node ON mnode.id = node.id) as main 
		
		LEFT JOIN (
				SELECT SUM(node.tovars_count) as nc, parent.id AS pid 
				FROM (	SELECT COUNT(tovars.id) as tovars_count,categories.id,lft,rgt 
						FROM tovars, categories, shops_tovars 
						WHERE shop_id = {$shop_id} AND tovar_id = tovars.id AND categories.id=tovars.category_id GROUP BY categories.id
					)AS node,
					categories AS parent 
					WHERE node.lft BETWEEN parent.lft AND parent.rgt AND node.rgt = node.lft+1 AND node.id<>parent.id GROUP BY parent.lft
		) AS prnt ON main.id = prnt.pid WHERE main.id<>1 GROUP BY main.lft")
						->execute()
						->as_array();
	}
	
	public function get_subtree_for_user($user_id) {
		return DB::query(Database::SELECT, "SELECT main.name,main.id,main.parent_id,main.lft,main.rgt, case
													when main.tovars_count > 0 then main.tovars_count
													when prnt.nc > 0 then prnt.nc
													else 0
													end as tovars_count
											FROM (
													SELECT mnode.id,mnode.name,mnode.parent_id,mnode.lft,mnode.rgt,node.tovars_count as tovars_count
													FROM categories as mnode LEFT JOIN (
														SELECT COUNT(tovars.id) as tovars_count,categories.id,lft,rgt 
														FROM tovars, categories 
														WHERE tovars.user_id ={$user_id} AND tovars.category_id=categories.id GROUP BY categories.id
													) AS node ON mnode.id = node.id) as main 
		
													LEFT JOIN (
															SELECT SUM(node.tovars_count) as nc, parent.id AS pid 
															FROM (	
																	SELECT COUNT(tovars.id) as tovars_count,categories.id,lft,rgt 
																	FROM tovars, categories 
																	WHERE tovars.user_id ={$user_id} AND tovars.category_id=categories.id GROUP BY categories.id
																)AS node,
																categories AS parent 
															WHERE node.lft BETWEEN parent.lft AND parent.rgt AND node.rgt = node.lft+1 AND node.id<>parent.id GROUP BY parent.lft
													) AS prnt ON main.id = prnt.pid 
											WHERE main.id<>1 GROUP BY main.lft")
						->execute()
						->as_array();
	}

	
	public function get_subtree_all_tovars_user($user_id) {
		return DB::query(Database::SELECT, "SELECT main.id,case
												when main.tovars_count > 0 then main.tovars_count
												when prnt.nc > 0 then prnt.nc
												else 0
												end as tovars_count
												FROM (
														SELECT mnode.id,mnode.lft,node.tovars_count as tovars_count
														FROM categories as mnode LEFT JOIN (
																SELECT COUNT(tovars.id) as tovars_count,categories.id,lft,rgt 
																FROM tovars, categories 
																WHERE tovars.user_id = {$user_id} AND tovars.category_id=categories.id GROUP BY categories.id
														) AS node ON mnode.id = node.id) as main 
														
														LEFT JOIN (
																SELECT SUM(node.tovars_count) as nc, parent.id AS pid 
																FROM (	SELECT COUNT(tovars.id) as tovars_count,categories.id,lft,rgt 
																		FROM tovars, categories 
																		WHERE tovars.user_id = {$user_id} AND tovars.category_id=categories.id GROUP BY categories.id
																	)AS node,
																	categories AS parent 
																	WHERE node.lft BETWEEN parent.lft AND parent.rgt AND node.rgt = node.lft+1 AND node.id<>parent.id GROUP BY parent.lft
														) AS prnt ON main.id = prnt.pid WHERE main.id<>1 GROUP BY main.lft")
						->execute()
						->as_array();
	}
	
	/**
	 *
	 SELECT node.name, (COUNT(parent.name) - (sub_tree.depth + 1)) AS depth
		FROM nested_category AS node,
		nested_category AS parent,
		nested_category AS sub_parent,
		(
		SELECT node.name, (COUNT(parent.name) - 1) AS depth
		FROM nested_category AS node,
		nested_category AS parent
		WHERE node.lft BETWEEN parent.lft AND parent.rgt
		AND node.name = 'PORTABLE ELECTRONICS'
		GROUP BY node.name
		ORDER BY node.lft
		)AS sub_tree
		WHERE node.lft BETWEEN parent.lft AND parent.rgt
		AND node.lft BETWEEN sub_parent.lft AND sub_parent.rgt
		AND sub_parent.name = sub_tree.name
		GROUP BY node.name
		HAVING depth <= 1
		ORDER BY node.lft;
	 */

	public function get_subtree2level() {


		$depths=DB::select('node.id',array(DB::expr('COUNT(parent.id)-1'),'depth'))
		->from(array($this->_table_name,'node'))
		->from(array($this->_table_name,'parent'))
		->where('node.lft','BETWEEN',array(DB::expr('parent.lft'),DB::expr('parent.rgt')))
		->and_where('node.id','=',$this->id)
		->group_by('node.name')
		->order_by('node.lft');

		return DB::select('node.id','node.parent_id','node.name','node.tovars_count',array(DB::expr('COUNT(parent.id)-(sub_tree.depth+1)'),'depth'))
		->from(array($this->_table_name,'node'))
		->from(array($this->_table_name,'parent'))
		->from(array($this->_table_name,'sub_parent'))
		->from(array($depths,'sub_tree'))
		->where('node.lft','BETWEEN',array(DB::expr('parent.lft'),DB::expr('parent.rgt')))
		->and_where('node.lft','BETWEEN',array(DB::expr('sub_parent.lft'),DB::expr('sub_parent.rgt')))
		->and_where('sub_parent.id','=',DB::expr('sub_tree.id'))
		->group_by('node.id')
		->having('depth','BETWEEN',array(1,2))
		->order_by('node.lft')
		->execute($this->_db);
	}

	public function moveto(Array $ids, $parent_id=NULL){
		DB::update($this->_table_name)
		->set(array('parent_id'=>$parent_id))
		->where('id','IN', $ids)
		->execute($this->_db);
	}

	public function append_to($parent_id)
	{
		$this->parent_id = $parent_id;

		$left = $this->get_left($parent_id);
		$this->lft = $left;
		$this->rgt = $left + 1;


		DB::update($this->_table_name)
		->set(array('rgt'=>DB::expr('rgt + 2')))
		->where('rgt','>=', $left)
		->execute($this->_db);
			
		DB::update($this->_table_name)
		->set(array('lft'=>DB::expr('lft + 2')))
		->where('lft','>', $left)
		->execute($this->_db);

		$this->create();
	}

	public function get_left($parent_id)
	{
		//return Debug::vars($parent_id);
		if($parent_id)
		{
			$result = DB::select('rgt')
			->from($this->_table_name)
			->where('id','=',$parent_id)
			->execute($this->_db);
			return $result->get('rgt');
		}
		else
		{
			$result = DB::select(array(DB::expr('MAX(`rgt`)'), 'maxrgt'))
			->from($this->_table_name)
			->where('parent_id','=',$parent_id)
			->execute($this->_db);
			return $result->get('maxrgt')+1;
		}
	}

	public function delete_all()
	{
        $leftId = $this -> lft;
		$rightId = $this -> rgt;
		
        $sql = 'DELETE FROM ' . $this->_table_name . ' WHERE lft BETWEEN ' . $leftId . ' AND ' . $rightId;
        
        DB::query(Database::SELECT, $sql)->execute();
       
	   
        $deltaId = (($rightId - $leftId) + 1);
        $sql = 'UPDATE ' . $this->_table_name . ' SET lft = CASE WHEN lft > ' . $leftId.' THEN lft - ' . $deltaId . ' ELSE lft END, '
        .' rgt = CASE WHEN rgt > ' . $leftId . ' THEN rgt - ' . $deltaId . ' ELSE rgt END '
        . 'WHERE rgt > ' . $rightId;
  
         DB::query(Database::SELECT, $sql)->execute();
       
	}
	public function delet_all()
	{
		$leftId = $this->lft;
		$rightId = $this->rgt;
		$delta= $this->tovars_count;
		$id=$this->parent_id;
		while($id!=0){
			DB::update($this->_table_name)
			->set(array('tovars_count'=>DB::expr('tovars_count - '.$delta)))
			->where('id','=', $id)
			->execute($this->_db);
			$id = DB::select('*')
			->from($this->_table_name)
			->where('id','=',$id)
			->execute($this->_db)->get('parent_id');
		}
	
		//удаляем старые
		$sql = 'DELETE FROM ' . $this->_table_name . ' WHERE lft BETWEEN ' . $leftId . ' AND ' . $rightId;
		DB::query(Database::DELETE, $sql)->execute();
		 
	
		$deltaId = (($rightId - $leftId) + 1);
		$sql = 'UPDATE ' . $this->_table_name . ' SET lft = CASE WHEN lft > ' . $leftId.' THEN lft - ' . $deltaId . ' ELSE lft END, '
				.' rgt = CASE WHEN rgt > ' . $leftId . ' THEN rgt - ' . $deltaId . ' ELSE rgt END '
						. 'WHERE rgt > ' . $rightId;
	
		DB::query(Database::UPDATE, $sql)->execute();
		 
	
	}
}
