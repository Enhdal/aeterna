<?php

Class BaseObjectList {
    public $dbtable = '';
    protected $myclass = '';
	private $_res = null;
	private $_count = null;
	private $query_innerjoin = '';
	private $query_where = '';
	private $query_orderby = '';
	private $query_limit = '';
	private $query = '';
	// save all result
	private $data = null;
	private $firstcall = true;
	private $_pos = 0;

	/**
	 * __construct
	 * @param $t table in database
	 * @param $innerjoin add a inner join, it must include INNER JOIN/LEFT JOIN/RIGHT JOIN
	 * @param $where the where condition, no need to write WHERE key word
	 * @param $orderby the ORDER BY, no need to ORDER BY key word but can have a DESC
	 * @param $limit the LIMIT condition, no need to write LIMIT key word
	 * @param $alias the alias of the main table
	 */
    public function __construct($t = '', $innerjoin = '', $where = '', $orderby = '', $limit = '', $alias = '') {
		global $cfg;
		global $db;
    	$this->dbtable = $t;
    	$this->myclass = ucfirst($t);
		
		if($t == ''){
			// There is no table defined, so the object is used to do a set of new objects.
			$this->data = array();
		} else {
			$this->query_innerjoin = $innerjoin;
			$this->query_where = $where;
			$this->query_orderby = $orderby;
			$this->query_limit = $limit;
			$as = ($alias != '')?$alias:$t;
			// Query building.
			if($where != '')
				$where = "WHERE $where";
			//file_put_contents('BOL__construct.log', print_r($where, true));
			if($orderby != '')
				$orderby = "ORDER BY $orderby";
			if($limit != '')
				$limit = "LIMIT $limit";
			$q = '';
			foreach($cfg[$t]['fields'] as $champ => $type) {
				if($q != '') {
					$q .= ',';
				}
				$q .= $as.'.'.strtolower($champ);
			}
			$query = "SELECT $q FROM $t $as $innerjoin $where $orderby $limit";
			$this->query = $query;
			
			Tool::dbConnect();
			$answer = $db->query($query);
			$this->_res = $answer;
		}
		//_log($query, 'BOL__construct.log');
		//echo '<pre>'.print_r($query, true).'</pre>';
		//echo '<pre>'.print_r($answer, true).'</pre>';
    }
	
	/**
	* Get count of results of the query.
	*/
	public function getCount() {
		if(is_null($this->_count)) {
			global $db;
			$answer = $db->query("SELECT count(id_{$this->dbtable}) AS count {$this->query_where} GROUP BY id_{$this->dbtable}");
			$data = $answer->fetch();
			$this->_count = $data['count'];
			$answer->closeCursor();
		}
		return $this->_count;
	}
	
	/**
	 * Return next value or false if end of results
	 */
	public function getNext() {
		if($this->firstcall) {
			Tool::dbConnect();
			if(is_null($this->_res))
				die('ERROR 20140717.01 - _res not initialized');
			//var_dump($this->query);
			if($row = $this->_res->fetch(PDO::FETCH_ASSOC)) {
				$c = $this->myclass;
				$id = $row['id_' . $this->dbtable];
				
				// Instantiate the class of object.
				//$obj = new $c($id, true, $row);
				$obj = Tool::getBaseObject($c, $id, $row);
				//var_dump($obj);
				$this->data[$this->_pos] = $obj;
				$this->_pos++;
				// Close the processing of the request.
				return $obj;
			} else {
				$this->firstcall = false;
				$this->_res->closeCursor();
				return false;
			}
		} else {
			if((isset($this->data[$this->_pos]))){
				return $this->data[$this->_pos++];
			} else {
				return false;
			}
		}
	}
	
	/**
	* move position on results list.
	*/
	public function seek($pos = 0) {
		$this->_pos = $pos;
		$this->firstcall = false;
	}
	
	public function push($element){
		if($this->firstcall === true)
			$this->firstcall = false;
		$position = count($this->data);
		$this->data[$position] = $element;
		$this->_count = (int) $this->_count + 1;
	}
	
	public function addAll(){
		global $db;
		Tool::dbConnect();
		$this->seek(0);
		try{
			$db->setAttribute(PDO::ATTR_AUTOCOMMIT, FALSE);
			$db->beginTransaction();
			while($obj = $this->getNext()){
				$obj->add();
			}
			$db->commit();
		} catch (Exception $ex) {
			echo $ex->getMessage().'<br />';
			$db->rollBack();
		}
		$db->setAttribute(PDO::ATTR_AUTOCOMMIT, TRUE);
	}
	
	public function updateAll(){
		global $db;
		Tool::dbConnect();
		if($this->firstcall){
			while($this->getNext());
		}
		$this->seek(0);
		try{
			$db->beginTransaction();
			$db->setAttribute(PDO::ATTR_AUTOCOMMIT, FALSE);
			while($obj = $this->getNext()){
				$obj->update();
			}
			$db->commit();
		} catch (Exception $ex) {
			$db->rollBack();
		}
		$db->setAttribute(PDO::ATTR_AUTOCOMMIT, TRUE);
	}
	
	public function deleteAll(){
		global $db;
		Tool::dbConnect();
		if($this->firstcall){
			while($this->getNext());
		}
		$this->seek(0);
		try{
			$db->beginTransaction();
			while($obj = $this->getNext()){
				$obj->delete();
			}
			$db->commit();
		} catch (Exception $ex) {
			$db->rollBack();
		}
	}
	
}
?>