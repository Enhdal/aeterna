<?php
class Book extends BaseObject{
	public function __construct($id, $error = false, $loadfromrow = null){
		parent::__construct('book', $id);
		if(is_null($loadfromrow)) {
			$this->loadFromDb($error);
		} else {
			$this->loadFromRow($loadfromrow);
		}
	}
}

?>