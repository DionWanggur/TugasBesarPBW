<?php
	$url = $_SERVER['REDIRECT_URL'];
	$baseURL = '/TugasPhpPbw/Praktikum/TugasBesar';
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
			case $baseURL.'/tambahJadwal':
				require_once "Controller/adminController.php";
				$AdmController = new AdminController();
				echo $AdmController->view_tambahJadwal();
			break;
			case $baseURL.'/jadwalBaru':
				require_once "Controller/adminController.php";
				$AdmController = new AdminController();
				echo $AdmController->view_jadwalBaru();
			break;
			case $baseURL.'/buatJadwal':
				require_once "Controller/adminController.php";
				$AdmController = new AdminController();
				echo $AdmController->view_buatJadwal();
			break;
			case $baseURL.'/tambahMatkul':
				require_once "Controller/adminController.php";
				$AdmController = new AdminController();
				echo $AdmController->tambahMatkul();
				header('Location: buatJadwal');
			break;
			case $baseURL.'/download':
				require_once "Controller/userController.php";
				$AdmController = new UserController();
				echo $AdmController->download();
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
			break;
			default:
				echo '404 Not Found';
				break;
		}
	}
		
?>