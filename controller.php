<?php
require_once "controller/services/view.php";

class Controller{
    
	public function view_index(){
		return View::createView('index.php',[]);
    }
}

?>