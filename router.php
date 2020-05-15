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
			case $baseURL.'/tambahJadwal':
				require_once "Controller/adminController.php";
				$AdmController = new AdminController();
				echo $AdmController->view_tambahJadwal();
			break;
			case $baseURL.'/liatJadwal':
				require_once "Controller/userController.php";
				$Usrcontroller = new UserController();
				echo $Usrcontroller->view_liatJadwal();
			break;
			case $baseURL.'/jadwalAdmin':
				require_once "Controller/adminController.php";
				$AdmController = new AdminController();
				echo $AdmController->view_liatJadwal();
			break;
			case $baseURL.'/downloadJadwal':
				require_once "Controller/userController.php";
				$Usrcontroller = new UserController();
				echo $Usrcontroller->view_download();
			break;
			case $baseURL.'/jadwalUTS':
				require_once "Controller/userController.php";
				$Usrcontroller = new UserController();
				echo $Usrcontroller->view_UTS();
			break;
			case $baseURL.'/jadwalUAS':
				require_once "Controller/userController.php";
				$Usrcontroller = new UserController();
				echo $Usrcontroller->view_UAS();
			break;

			case $baseURL.'/jadwalUTSAdmin':
				require_once "Controller/adminController.php";
				$AdmController = new AdminController();
				echo $AdmController->view_UTS();
			break;
			case $baseURL.'/jadwalUASAdmin':
				require_once "Controller/adminController.php";
				$AdmController = new AdminController();
				echo $AdmController->view_UAS();
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
			case $baseURL.'/downloadUTS':
				require_once "Controller/userController.php";
				$AdmController = new UserController();
				echo $AdmController->downloadUTS();
			break;
			case $baseURL.'/downloadUAS':
				require_once "Controller/userController.php";
				$AdmController = new UserController();
				echo $AdmController->downloadUAS();
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
			case $baseURL.'/tambahMatkul':
				require_once "Controller/adminController.php";
				$controller = new AdminController();
				$res = $controller->insertUjian();
				if($res == "berhasil"){
					header('Location: index');
				}
				else{
					$message = "Jadwal bentrok";
					echo "<script type='text/javascript'>alert('$message');</script>";
					echo "<a href='buatJadwal'>Kembali</a>";
				}
				break;
			case $baseURL.'/fileUpload':
				require_once "Controller/adminController.php";
				$controller = new AdminController();
				 $sukses = $controller->uploadEksel();
				if($sukses == "berhasil"){
					header('Location: index');
				}
				else{
					$message = "Error :Upload Gagal";
					echo "<script type='text/javascript'>alert('$message');</script>";
					echo "<a href='tambahJadwal'>Kembali</a>";
				}
			break;
			case $baseURL.'/deleteBook':
				require_once "Controller/adminController.php";
				$roleCtrl = new adminController();
				$lokasi = $roleCtrl->delete();
				if ($lokasi =='UTS') {
					header('Location: jadwalUTSAdmin');
				} else {
					header('Location: jadwalUASAdmin');
				}
				break;
			default:
				echo '404 Not Found';
				break;
		}
	}
		
?>