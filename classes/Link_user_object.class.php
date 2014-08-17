<?php
class Link_user_object extends BaseObject{
	public function __construct($id, $error = false, $loadfromrow = null){
		parent::__construct('link_user_object', $id);
		if(is_null($loadfromrow)) {
			$this->loadFromDb($error);
		} else {
			$this->loadFromRow($loadfromrow);
		}
	}
}

?>