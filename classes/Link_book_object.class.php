<?php
class Link_book_object extends BaseObject{
	public function __construct($id, $error = false, $loadfromrow = null){
		parent::__construct('link_book_object', $id);
		if(is_null($loadfromrow)) {
			$this->loadFromDb($error);
		} else {
			$this->loadFromRow($loadfromrow);
		}
	}
}

?>