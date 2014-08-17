<?php
class Chapter extends BaseObject{
	public function __construct($id, $error = false, $loadfromrow = null){
		parent::__construct('chapter', $id);
		if(is_null($loadfromrow)) {
			$this->loadFromDb($error);
		} else {
			$this->loadFromRow($loadfromrow);
		}
	}
}

?>