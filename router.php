<?php
	$url = $_SERVER['REDIRECT_URL'];
	$baseURL = '/TugasPhpPbw/Praktikum/TugasBesar';

	if ($_SERVER["REQUEST_METHOD"] == "GET") {
		switch ($url) {
			case $baseURL.'/index':
				require_once "Controller/controller.php";
				$controller = new Controller();
				echo $controller->view_index();
				break;
			default:
				echo '404 Not Found';
				break;
		}
	}else if($_SERVER["REQUEST_METHOD"] == "POST"){
		switch ($url) {
			case $baseURL.'/user':
				require_once "Controller/userController.php";
				$UsrController = new UserController();
				echo $UsrController->view_index();
				break;
			default:
				echo '404 Not Found';
				break;
		}
	}
		
?>