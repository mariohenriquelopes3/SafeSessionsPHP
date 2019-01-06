<?php

class Session {
	
	public $id;
	public $dataHora;
	public $keySession;
	
	public function __construct($id = null, $keySession = null) {
		$this->id = $id;
		$this->keySession = $keySession;
		$this->dataHora = date('Y-m-d H:i:s');
	}
	
}

?>