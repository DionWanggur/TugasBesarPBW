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
		if(session_status() == PHP_SESSION_ACTIVE && isset($_SESSION['nama'])) {
			$nama = $_SESSION['nama'];
			if ($_SESSION['kondisi'] == "admin") {
				return View::createView('adminPage.php',["nama"=>$nama,
				"content"=>$content]);
			}
		}
	}
	public function view_jadwalBaru(){
		$semester = $this->getSemester();
		if(session_status() == PHP_SESSION_ACTIVE && isset($_SESSION['nama'])) {
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
			if(session_status() == PHP_SESSION_ACTIVE && isset($_SESSION['berhasil'])){
				$berhasil = $_SESSION['berhasil'];
			}
            if ($_SESSION['kondisi'] == "admin") {
                $content =  View::createView('TambahJadwal.php',["nama"=>$nama]);
                return $this->view_index($content);
            }
        }
	}
	
	public function view_buatJadwal(){
		if (isset($_GET['tipeUjian']) && $_GET['tipeUjian'] != "") {
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
		if(session_status() == PHP_SESSION_ACTIVE && isset($_SESSION['nama'])) {
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
		if(session_status() == PHP_SESSION_ACTIVE && isset($_SESSION['tipeUjian'])) {
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


		$queryCek = "SELECT ruang FROM ujian WHERE ruang LIKE '$ruang' AND mulai LIKE '$resMulai' AND selesai LIKE '$resSelesai'";
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
		return $status;
		
	}

	public function uploadEksel(){
		include "excel_reader2.php";

		$target = basename($_FILES['fileeksel']['name']) ;
		move_uploaded_file($_FILES['fileeksel']['tmp_name'], $target);

		// beri permisi agar file xls dapat di baca
		chmod($_FILES['fileeksel']['name'],0777);

		// mengambil isi file xls
		$data = new Spreadsheet_Excel_Reader($_FILES['fileeksel']['name'],false);
		// menghitung jumlah baris data yang ada
		$jumlah_baris = $data->rowcount($sheet_index=0);

		// jumlah default data yang berhasil di import
		$_SESSION['berhasil'] = 0;
		for ($i=2; $i<=$jumlah_baris; $i++){

		// menangkap data dan memasukkan ke variabel sesuai dengan kolumnya masing-masing
		$matakuliah     = $data->val($i, 1);
		$tipe   = $data->val($i, 2);
		$tatacara  = $data->val($i, 3);

		$mulai  = $data->val($i, 4);
		$mulaia = new DateTime($mulai);
		$mulaiai = $mulaia->format("Y-m-d H:i:s");

		$selesai  = $data->val($i, 5);
		$selesaia = new DateTime($selesai);
		$selesaiai = $selesaia->format("Y-m-d H:i:s");

		$ruang  = $data->val($i, 6);
		$shift  = $data->val($i, 7);
		$jumPengawas  = $data->val($i, 8);
		if($matakuliah != "" && $tipe != "" && $tatacara != "" && $mulaiai!="" && $selesai!="" && $ruang!="" && $shift !="" && $jumPengawas!=""){
			// input data ke database (table data_pegawai)
			$query = "SELECT mengajar.id FROM matakuliah inner join mengajar on matakuliah.kode = mengajar.kode WHERE matakuliah.nama LIKE '$matakuliah'";
				$query_result = $this->db->executeSelectQuery($query);
				foreach($query_result as $key => $value){
					$id = $value['id'];
					$queryInsert = "INSERT INTO ujian (mengajar_id,tipe,tata_cara,mulai,selesai,ruang,shift,kebutuhan_pengawas) 
						values ('$id','$tipe','$tatacara','$resMulai','$resSelesai','$ruang','$shift','$jumPengawas')";
					$queryInsert_result = $this->db->executeNonSelectQuery($queryInsert);
				}
			$_SESSION['berhasil']++;
		}
}

	// hapus kembali file .xls yang di upload tadi
	unlink($_FILES['fileeksel']['name']);
	}
}
