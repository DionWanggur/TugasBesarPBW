<?php
require_once "controller/services/view.php";
require_once "controller/services/mysqlDB.php";
require_once "Model/matakuliah.php";
require_once "Model/ruang.php";
require_once "Model/semester.php";

class AdminController{
	
	protected $db;
	
	public function __construct(){
		$this->db = new MySQLDB("localhost","root","","ftisakademik");
    }

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
		$semester = $this->getSemester();
		if(session_status() == PHP_SESSION_ACTIVE and isset($_SESSION['nama'])) {
			$nama = $_SESSION['nama'];
			if ($_SESSION['kondisi'] == "admin") {
				$content =  View::createView('jadwalBaru.php',["nama"=>$nama,"semester"=>$semester]);
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
		if (isset($_GET['tipeUjian']) and $_GET['tipeUjian'] != "") {
			$_SESSION['tipeUjian'] = $_GET['tipeUjian'];
		}
		$matkul = $this->getAllMataKuliah();
		$ruang = $this->getAllRuang();
		if(isset($_SESSION['status']) && !empty($_SESSION['status'])) {
			$status = $_SESSION['status'];
		}
		else{
			$status = null;
		}
		if(session_status() == PHP_SESSION_ACTIVE and isset($_SESSION['nama'])) {
			$nama = $_SESSION['nama'];
			if ($_SESSION['kondisi'] == "admin") {
				$content = View::createView('buatJadwal.php',["nama"=>$nama,"matkul"=> $matkul,
				"ruang"=>$ruang,"status"=>$status
				]);
				return $this->view_index($content);
			}
		}
	}

	public function tambahMatkul(){
		if(session_status() == PHP_SESSION_ACTIVE and isset($_SESSION['tipeUjian'])) {
			$mulai = $_GET['mulai'];
			$selesai = $_GET['selesai'];
			$mataKuliah = $_GET['mataKuliahUjian'];
			$tatacara = $_GET['tataCara'];
			$ruangujian = $_GET['ruang'];
			$tipeJadwal = $_SESSION['tipeUjian'];
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

	public function getAllMataKuliah(){
		$query = "SELECT nama FROM matakuliah ";
		$query_result = $this->db->executeSelectQuery($query);
		$result = [];
		foreach ($query_result as $key => $value) {
			$result[] = new MataKuliah($value['nama']);
		}
		
		return $result;
	}

	public function getAllRuang(){
		$query = "SELECT nama,kapasitas FROM ruang";
		$query_result = $this->db->executeSelectQuery($query);
		$result = [];
		foreach ($query_result as $key => $value) {
			$result[] = new Ruang($value['nama'],$value['kapasitas']);
		}
		return $result;
	}

	public function getSemester(){
		$query = "SELECT * FROM semester";
		$query_result = $this->db->executeSelectQuery($query);
		$result = [];
		foreach ($query_result as $key => $value) {
			if ($value['berjalan'] == 1) {
				$result[] = new Semester($value['jenis'],$value['tahun_ajar']);
			}
		}
		return $result;
	}

	public function insertUjian(){
		$mulai = new DateTime($_POST['mulai']);
		$resMulai = $mulai->format("Y-m-d H:i:s");

		$selesai = new DateTime($_POST['selesai']);
		$resSelesai = $selesai->format("Y-m-d H:i:s");

		$matkul = $_POST['mataKuliahUjian'];
		$tatacara = $_POST['tataCara'];
		$ruang = $_POST['ruang'];
		$tipe = $_SESSION['tipeUjian'];
		$shift = $_POST['shift'];
		$jumPengawas = $_POST['jumlahPengawas'];

		$_SESSION['status'] = "";
		$status = "";


		$queryCek = "SELECT ruang,mulai,selesai	 FROM ujian WHERE ruang LIKE '$ruang' AND mulai LIKE '$resMulai' AND selesai LIKE '$resSelesai'";
		$queryCek_result = $this->db->executeSelectQuery($queryCek);
		if($queryCek_result[0]['ruang']==null){
			$query = "SELECT mengajar.id FROM matakuliah inner join mengajar on matakuliah.kode = mengajar.kode WHERE matakuliah.nama LIKE '$matkul'";
			$query_result = $this->db->executeSelectQuery($query);
			foreach($query_result as $key => $value){
				$id = $value['id'];
				$queryInsert = "INSERT INTO ujian (mengajar_id,tipe,tata_cara,mulai,selesai,ruang,shift,kebutuhan_pengawas) 
					values ('$id','$tipe','$tatacara','$resMulai','$resSelesai','$ruang','$shift','$jumPengawas')";
				$queryInsert_result = $this->db->executeNonSelectQuery($queryInsert);
			}
			$_SESSION['status'] = "berhasil";
			$status = "berhasil";
		}
		else{
			$_SESSION['status'] = "bentrok";
			$status = "bentrok";
		}
		
	}
}

?>