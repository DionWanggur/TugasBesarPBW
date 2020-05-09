<?php
require_once "controller/services/view.php";

class UserController{
    
	public function view_index(){
		return View::createView('UserPage.php',[]);
    }
}

?>