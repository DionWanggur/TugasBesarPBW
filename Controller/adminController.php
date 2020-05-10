<?php
require_once "controller/services/view.php";

class AdminController{
    
	public function view_index(){
		if(session_status() == PHP_SESSION_ACTIVE and isset($_SESSION['nama'])) {
			$nama = $_SESSION['nama'];
			if ($nama == "admin") {
				return View::createView('jadwalBaru.php',["nama"=>$nama]);
			}
		}
    }
}

?>