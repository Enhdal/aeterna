<?php
class User extends BaseObject{
	public function __construct($id, $error = false, $loadfromrow = null){
		parent::__construct('user', $id);
		if(is_null($loadfromrow)) {
			$this->loadFromDb($error);
		} else {
			$this->loadFromRow($loadfromrow);
		}
	}
}

?>