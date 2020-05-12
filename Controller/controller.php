<?php
require_once "controller/services/view.php";
require_once "controller/services/mysqlDB.php";

class Controller{
	protected $db;
	
	public function __construct(){
		$this->db = new MySQLDB("localhost","root","","tubespbw");
    }

	public function view_index(){
		if(session_status() == PHP_SESSION_ACTIVE && isset($_SESSION['username'])) {
			$nama = $_SESSION['username'];
			$kondisi = $_SESSION['kondisi'];
			if ($kondisi == "admin") {
				$content = "<h1>Layanan Bagi Admin Untuk Mengatur Jadwal Ujian</h1><br>
				<img src='View/Img/ujian.jpg' alt='ujian' style='width: 400px;height: 200px'>
				<h2>Selamat Datang ".$nama."</h2>";
				return View::createView('adminPage.php',["nama"=>$nama,
				"content"=>$content]);
			} else {
				return View::createView('UserPage.php',["nama"=>$nama]);
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
				$_SESSION['username'] = $query_result[0]['username'];
				$_SESSION['password'] = $query_result[0]['password'];
				$_SESSION['kondisi'] = $kondisi;
			}	
			else{
				$kondisi = 'admin';
				$_SESSION['username'] = $query_result[0]['username'];
				$_SESSION['password'] = $query_result[0]['password'];
				$_SESSION['kondisi'] = $kondisi;
			}
		}
		return $kondisi;
		
	}
	public function logout(){
		session_destroy();
	}
}

?>