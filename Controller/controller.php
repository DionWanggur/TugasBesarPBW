<?php
require_once "controller/services/view.php";

class Controller{
    
	public function view_index(){
		if(session_status() == PHP_SESSION_ACTIVE and isset($_SESSION['nama'])) {
			$nama = $_SESSION['nama'];
			if ($nama == "admin") {
				return View::createView('adminPage.php',["nama"=>$nama]);
			} else {
				return View::createView('UserPage.php',["nama"=>$nama]);
			}
		}
		else{
			return View::createView('index.php',[]);
		}
	}
	
	public function login(){
		if (isset($_POST['nama']) and $_POST['nama'] != "") {
			$_SESSION['nama'] = $_POST['nama'];
		}
		
	}
	public function logout(){
		session_destroy();
	}
}

?>