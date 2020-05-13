<?php
require_once "controller/services/view.php";
require_once "controller/services/mysqlDB.php";
require_once 'model/ujian.php';

class Controller{
	protected $db;
	
	public function __construct(){
		$this->db = new MySQLDB("localhost","root","","ftisakademik");
    }

	public function view_index(){
		if(session_status() == PHP_SESSION_ACTIVE && isset($_SESSION['nama'])) {
			$nama = $_SESSION['nama'];
			$kondisi = $_SESSION['kondisi'];
			if ($kondisi == "admin") {
				$content = "<h1>Layanan Bagi Admin Untuk Mengatur Jadwal Ujian</h1><br>
				<img src='View/Img/ujian.jpg' alt='ujian' style='width: 400px;height: 200px'>
				<h2>Selamat Datang ".$nama."</h2>";
				return View::createView('adminPage.php',["nama"=>$nama,
				"content"=>$content]);
			} else {
				$resUTS = $this->getUTS();
				$resUAS = $this->getUAS();
				return View::createView('UserPage.php',["resUTS"=>$resUTS, "resUAS"=>$resUAS,"nama"=>$nama]);
			}
		}
		else{
			return View::createView('index.php',[]);
		}
	}
	
	public function login(){
		$username = $_POST['nama'];
		$password = $_POST['password'];
		$kondisi='';

		if (isset($username) && isset($password) && $username != "" && $password != "") {
			$query = "SELECT * FROM `user` WHERE `username` LIKE '$username' AND `password` LIKE '$password' ";
			$query_result = $this->db->executeSelectQuery($query);
			if($query_result[0]['role']=='mahasiswa'){
				$kondisi = 'mahasiswa';
				$_SESSION['nama'] = $query_result[0]['username'];
				$_SESSION['password'] = $query_result[0]['password'];
				$_SESSION['kondisi'] = $kondisi;
			}	
			else{
				$kondisi = 'admin';
				$_SESSION['nama'] = $query_result[0]['username'];
				$_SESSION['password'] = $query_result[0]['password'];
				$_SESSION['kondisi'] = $kondisi;
			}
		}
		return $kondisi;
		
	}
	public function logout(){
		session_destroy();
	}

	public function getUTS(){
		$name = "";
		$result = [];
		$query = "
		SELECT distinct nama, tipe, tata_cara,mulai,selesai,ruang,shift,kebutuhan_pengawas 
		FROM 
			(
			SELECT mengajar.kode, tipe, tata_cara, mulai, selesai, ruang, shift, kebutuhan_pengawas 
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
			
			$query_result = $this->db->executeSelectQuery($query);
			foreach($query_result as $key => $value){
				$result[] = new ujian(null,$value['nama'], $value['tipe'],$value['tata_cara'],$value['mulai'], $value['selesai'],$value['ruang'], $value['shift'], $value['kebutuhan_pengawas']);	
			}
		
		return $result;
	}

	public function getUAS(){
		$name = "";
		$result = [];
		$query = "
		SELECT distinct nama, tipe, tata_cara,mulai,selesai,ruang,shift,kebutuhan_pengawas 
		FROM 
			(
			SELECT mengajar.kode, tipe, tata_cara, mulai, selesai, ruang, shift, kebutuhan_pengawas 
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
			
			$query_result = $this->db->executeSelectQuery($query);
			foreach($query_result as $key => $value){
				$result[] = new ujian(null,$value['nama'], $value['tipe'],$value['tata_cara'],$value['mulai'], $value['selesai'],$value['ruang'], $value['shift'], $value['kebutuhan_pengawas']);	
			}
		
		return $result;
	}
}

?>