<?php
require_once "controller/services/view.php";

class AdminController{
    
	public function view_index($content){
		if(session_status() == PHP_SESSION_ACTIVE and isset($_SESSION['nama'])) {
			$nama = $_SESSION['nama'];
			if ($nama == "admin") {
				return View::createView('adminPage.php',["nama"=>$nama,
				"content"=>$content]);
			}
		}
	}
	public function view_jadwalBaru(){
		if(session_status() == PHP_SESSION_ACTIVE and isset($_SESSION['nama'])) {
			$nama = $_SESSION['nama'];
			if ($nama == "admin") {
				$content =  View::createView('jadwalBaru.php',["nama"=>$nama]);
				return $this->view_index($content);
			}
		}
	}

	
	public function view_tambahJadwal(){
		if(session_status() == PHP_SESSION_ACTIVE and isset($_SESSION['nama'])) {
			$nama = $_SESSION['nama'];
			if ($nama == "admin") {
				$content = View::createView('tambahJadwal.php',["nama"=>$nama]);
				return $this->view_index($content);
			}
		}
	}
	
	public function view_buatJadwal(){
		if(session_status() == PHP_SESSION_ACTIVE and isset($_SESSION['nama'])) {
			$nama = $_SESSION['nama'];
			if ($nama == "admin") {
				$matkul = '<h2>Daftar Mata Kuliah</h2>';
				$content = View::createView('buatJadwal.php',["nama"=>$nama,
				"matKul"=>$matkul]);
				return $this->view_index($content);
			}
		}
	}

	public function view_tambahMatkul(){
		if(session_status() == PHP_SESSION_ACTIVE and isset($_SESSION['nama'])) {
			$nama = $_SESSION['nama'];
			if ($nama == "admin") {
				if (isset( $_GET['jumlahMatkul']) and $_GET['jumlahMatkul']){
					$matkul = '<h2>Daftar Mata Kuliah</h2>';
					for ($i=0; $i <$_GET['jumlahMatkul'] ; $i++) { 
						$matkul .= View::createView('TambahMatkul.php',[]);
					}
					$content = View::createView('buatJadwal.php',["nama"=>$nama,
						"matKul"=>$matkul]);
					return $this->view_index($content);
				}
				$matkul = '<h2>belum Okay!</h2>';
				$content = View::createView('buatJadwal.php',["nama"=>$nama,
				"matKul"=>$matkul]);
				return $this->view_index($content);
			}
		}
		// if(session_status() == PHP_SESSION_ACTIVE and isset($_SESSION['nama'] )) {
		// 	$nama = $_SESSION['nama'];
		// 	if ($nama == "admin") {
		// 		$matkul = '<h2>Rockstar Okay!</h2>';
		// 		$content = View::createView('buatJadwal.php',["nama"=>$nama,
		// 			"matKul"=>$matkul]);
		// 		$content = View::createView('buatJadwal.php',["nama"=>$nama]);
		// 		return $this->view_index($content);
		// 		// if (isset( $_GET['jumlahMatkul']) and $_GET['jumlahMatkul'] !="") {
		// 		// 	//$matkul = View::createView('TambahMatkul.php',[]);
		// 		// 	$matkul = '<h2>Rockstar Okay!</h2>';
		// 		// 	$content = View::createView('buatJadwal.php',["nama"=>$nama,
		// 		// 	"matKul"=>$matkul]);
		// 		// 	$content = View::createView('buatJadwal.php',["nama"=>$nama]);
		// 		// 	return $this->view_index($content);
		// 		// }
		// 		// else{
		// 		// 	$matkul = '<h2>Isi Form di samping dengan teliti!</h2>';
		// 		// 	$content = View::createView('buatJadwal.php',["nama"=>$nama,
		// 		// 	"matKul"=>$matkul]);
		// 		// 	$content = View::createView('buatJadwal.php',["nama"=>$nama]);
		// 		// 	return $this->view_index($content);
		// 		// }	
		// 	}
		// }
	}
	
	public function getJadwalBaru()
	{
		//untuk database
		$title = $_GET['sceaduleTitle'];
		$tipeJadwal = $_GET['tipeUjian'];// lihat M09
		$jmlHari = $_GET['jumlahHari'];
		$semester = $_GET['semester'];
	}

	public function getBuatJadwal()
	{
		$hari = $_GET['hariUjian'];
		$jmlMatkul = $_GET['jumlahMatkul'];

	}
}

?>