<?php
	$url = $_SERVER['REDIRECT_URL'];
	$baseURL = '/TugasPhpPbw/Praktikum/TugasBesarPBW';
	session_start();
	if ($_SERVER["REQUEST_METHOD"] == "GET") {
		switch ($url) {
			case $baseURL.'/index':
				require_once "Controller/controller.php";
				$controller = new Controller();
				echo $controller->view_index();
				break;
			case $baseURL.'/logout':
				require_once "Controller/controller.php";
				$controller = new Controller();
				echo $controller->logout();
				header('Location: index');
			break;
			case $baseURL.'/jadwalBaru':
				require_once "Controller/adminController.php";
				$AdmController = new AdminController();
				echo $AdmController->view_index();
			break;
			default:
				echo '404 Not Found';
				break;
		}
	}else if($_SERVER["REQUEST_METHOD"] == "POST"){
		switch ($url) {
			case $baseURL.'/login':
				require_once "Controller/controller.php";
				$controller = new Controller();
				echo $controller->login();
				header('Location: index');
				break;
			case $baseURL.'/admin':
				require_once "Controller/adminController.php";
				$AdmController = new AdminController();
				echo $AdmController->view_index();
			break;
			default:
				echo '404 Not Found';
				break;
		}
	}
		
?>