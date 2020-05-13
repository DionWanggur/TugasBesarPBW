<?php
require_once "controller/services/view.php";

class AdminController{
    
	public function view_index($content){
		if(session_status() == PHP_SESSION_ACTIVE and isset($_SESSION['nama'])) {
			$nama = $_SESSION['nama'];
			if ($_SESSION['kondisi'] == "admin") {
				return View::createView('adminPage.php',["nama"=>$nama,
				"content"=>$content]);
			}
		}
	}
	public function view_jadwalBaru(){
		if(session_status() == PHP_SESSION_ACTIVE and isset($_SESSION['nama'])) {
			$nama = $_SESSION['nama'];
			if ($_SESSION['kondisi'] == "admin") {
				$content =  View::createView('jadwalBaru.php',["nama"=>$nama]);
				return $this->view_index($content);
			}
		}
	}

	
	public function view_tambahJadwal(){
		if(session_status() == PHP_SESSION_ACTIVE && isset($_SESSION['nama'])) {
            $nama = $_SESSION['nama'];
            if ($_SESSION['kondisi'] == "admin") {
                $content =  View::createView('TambahJadwal.php',["nama"=>$nama]);
                return $this->view_index($content);
            }
        }
	}
	
	public function view_buatJadwal(){
		if(session_status() == PHP_SESSION_ACTIVE and isset($_SESSION['nama'])) {
			$nama = $_SESSION['nama'];
			if ($_SESSION['kondisi'] == "admin") {
				$content = View::createView('buatJadwal.php',["nama"=>$nama]);
				return $this->view_index($content);
			}
		}
	}

	public function view_tambahMatkul(){
		if(session_status() == PHP_SESSION_ACTIVE and isset($_SESSION['nama'])) {
			$nama = $_SESSION['nama'];
			if ($_SESSION['kondisi'] == "admin") {
				$content = View::createView('buatJadwal.php',["nama"=>$nama]);
				return $this->view_index($content);
			}
		}
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


	}
}

?>