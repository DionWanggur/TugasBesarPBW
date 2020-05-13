<?php
require_once "controller/services/view.php";
require_once "controller/services/mysqlDB.php";
require_once "Model/matakuliah.php";
require_once "Model/ruang.php";
require_once "Model/semester.php";
require_once 'model/ujian.php';


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

	public function view_liatJadwal(){
		if(session_status() == PHP_SESSION_ACTIVE && isset($_SESSION['nama'])) {
            $nama = $_SESSION['nama'];
            if ($_SESSION['kondisi'] == "admin") {
                $content =  View::createView('liatJadwalAdmin.php',["nama"=>$nama]);
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

	public function view_UTS(){
		if(session_status() == PHP_SESSION_ACTIVE && isset($_SESSION['nama'])) {
            if ($_SESSION['kondisi'] == "admin") {
				$resUTS = $this->getUTS();
				$link = $_SESSION['jadwalUTSAdmin'];
                $content =  View::createView('utsAdmin.php',["resUTS"=>$resUTS,"link"=>$link]);
                return $this->view_index($content);
            }
        }
	}

	public function view_UAS(){
		if(session_status() == PHP_SESSION_ACTIVE && isset($_SESSION['nama'])) {
			if ($_SESSION['kondisi'] == "admin") {
				$resUAS = $this->getUAS();
				$link = $_SESSION['jadwalUASAdmin'];
                $content =  View::createView('uasAdmin.php',["resUAS"=>$resUAS,"link"=>$link]);
                return $this->view_index($content);
            }
        }
	}

	public function getUTS(){
		$name = "";
		$result = [];
		$query = "
		SELECT distinct himpA.id,nama, tipe, tata_cara,mulai,selesai,ruang,shift,kebutuhan_pengawas 
		FROM 
			(
			SELECT ujian.id, mengajar.kode, tipe, tata_cara, mulai, selesai, ruang, shift, kebutuhan_pengawas
			FROM ujian inner join mengajar on ujian.mengajar_id = mengajar.id WHERE tipe LIKE 'UTS'
			)as himpA inner join matakuliah 
				on himpA.kode = matakuliah.kode
			";
		if(isset($_GET['filter'])){
			$name = $_GET['filter'];
			if(isset($name)&&$name!=""){
				$name = $this->db->escapeString($name);
				$query .= " WHERE nama LIKE '%$name%'";
				}
			}
			$query .="ORDER BY mulai ASC";
			$query_result = $this->db->executeSelectQuery($query);
			$query_result = $this->pagination($query,$name,$query_result,'jadwalUTSAdmin');
			foreach($query_result as $key => $value){
				$result[] = new ujian($value['id'],$value['nama'], $value['tipe'],$value['tata_cara'],$value['mulai'], $value['selesai'],$value['ruang'], $value['shift'], $value['kebutuhan_pengawas']);	
			}

			return $result;
	}

	public function getUAS(){
		$name = "";
		$result = [];
		$query = "
		SELECT distinct  himpA.id, nama, tipe, tata_cara,mulai,selesai,ruang,shift,kebutuhan_pengawas 
		FROM 
			(
			SELECT ujian.id, mengajar.kode, tipe, tata_cara, mulai, selesai, ruang, shift, kebutuhan_pengawas 
			FROM ujian inner join mengajar on ujian.mengajar_id = mengajar.id WHERE tipe LIKE 'UAS'
			)as himpA inner join matakuliah 
				on himpA.kode = matakuliah.kode
			";
		if(isset($_GET['filter'])){
			$name = $_GET['filter'];
			if(isset($name)&&$name!=""){
				$name = $this->db->escapeString($name);
				$query .= " WHERE nama LIKE '%$name%'";
				}
			}
			$query .="ORDER BY mulai ASC";
			$query_result = $this->db->executeSelectQuery($query);
			$query_result = $this->pagination($query,$name,$query_result,'jadwalUASAdmin');
			foreach($query_result as $key => $value){
				$result[] = new ujian(null,$value['nama'], $value['tipe'],$value['tata_cara'],$value['mulai'], $value['selesai'],$value['ruang'], $value['shift'], $value['kebutuhan_pengawas']);	
			}
			return $result;
	}

	public function pagination($query,$name,$query_result,$href)
	{
		$name = $name;
		$href = $href;
		$query = $query;
		$linkarr = [];
		$result = $query_result;
		$start = 0; $show = 5;
		$pageCount = count($result) / $show;

		if (isset($_GET['start'])) {
			$start = $this->db->escapeString($_GET['start']);
		}
	
		$query .= " LIMIT $start, $show";

		$result = $this->db->executeSelectQuery($query);

		if ($pageCount > 1) {
			for ($i = 0; $i < $pageCount; $i++) {
				$link = "<a class='pageLink' href ='".$href;
				if ($name != "") {
					$link .= "?filter=".$name;
				}
				if ($i!=0) {
					$str = $i * $show;
					if ($name !="") {
						$link .= "&";
					}else{
						$link .= "?";
					}
					$link .= "start=".$str;
				}
				$link .= "'>".($i + 1)."</a>";

				array_push($linkarr,$link);
							
			}
		}
		$_SESSION[$href] = $linkarr;
		return $result;
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

	public function delete(){ //seharusnya ada validasi isset dan escape string
		$id = $_POST['ujian_id'];
		$query = "DELETE FROM ujian WHERE id=".$id;
		$query_result = $this->db->executeNonSelectQuery($query);
	}
}
