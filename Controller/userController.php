<?php
require_once "controller/services/view.php";
require_once "controller/services/mysqlDB.php";
require_once 'vendor/autoload.php';
require_once 'model/ujian.php';

class UserController{
	protected $db;
	
	public function __construct(){
		$this->db = new MySQLDB("localhost","root","","ftisakademik");
	}
	
	public function view_index($content){
		if(session_status() == PHP_SESSION_ACTIVE && isset($_SESSION['nama'])) {
			$nama = $_SESSION['nama'];
			if ($_SESSION['kondisi'] == "mahasiswa") {
				return View::createView('UserPage.php',["nama"=>$nama,
				"content"=>$content]);
			}
		}
	}

	public function view_liatJadwal(){
		if(session_status() == PHP_SESSION_ACTIVE && isset($_SESSION['nama'])) {
            $nama = $_SESSION['nama'];
            if ($_SESSION['kondisi'] == "mahasiswa") {
                $content =  View::createView('liatJadwal.php',["nama"=>$nama]);
                return $this->view_index($content);
            }
        }
	}

	public function view_download(){
		if(session_status() == PHP_SESSION_ACTIVE && isset($_SESSION['nama'])) {
            $nama = $_SESSION['nama'];
            if ($_SESSION['kondisi'] == "mahasiswa") {
                $content =  View::createView('downloadJadwal.php',["nama"=>$nama]);
                return $this->view_index($content);
            }
        }
	}

	public function view_UTS(){
		if(session_status() == PHP_SESSION_ACTIVE && isset($_SESSION['nama'])) {
            if ($_SESSION['kondisi'] == "mahasiswa") {
				$resUTS = $this->getUTS();
				$link = $_SESSION['jadwalUTS'];
                $content =  View::createView('utsUser.php',["resUTS"=>$resUTS,"link"=>$link]);
                return $this->view_index($content);
            }
        }
	}

	public function view_UAS(){
		if(session_status() == PHP_SESSION_ACTIVE && isset($_SESSION['nama'])) {
			if ($_SESSION['kondisi'] == "mahasiswa") {
				$resUAS = $this->getUAS();
				$link = $_SESSION['jadwalUAS'];
                $content =  View::createView('uasUser.php',["resUAS"=>$resUAS,"link"=>$link]);
                return $this->view_index($content);
            }
        }
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
			$query .="ORDER BY mulai ASC";
			$query_result = $this->db->executeSelectQuery($query);
			$query_result = $this->pagination($query,$name,$query_result,'jadwalUTS');
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
			$query .="ORDER BY mulai ASC";
			$query_result = $this->db->executeSelectQuery($query);
			$query_result = $this->pagination($query,$name,$query_result,'jadwalUAS');
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

	public function downloadUTS(){
		$query ="
		SELECT distinct nama, tipe, tata_cara,mulai,selesai,ruang,shift,kebutuhan_pengawas 
		FROM 
			(
			SELECT mengajar.kode, tipe, tata_cara, mulai, selesai, ruang, shift, kebutuhan_pengawas 
			FROM ujian inner join mengajar on ujian.mengajar_id = mengajar.id WHERE tipe LIKE 'UTS'
			)as himpA inner join matakuliah 
				on himpA.kode = matakuliah.kode
		ORDER BY mulai ASC";
		$query_result = $this->db->executeSelectQuery($query);
		$result = $this->db->executeSelectQuery($query_result);
		foreach($query_result as $key => $value){
			$result[] = new ujian(null,$value['nama'], $value['tipe'],$value['tata_cara'],$value['mulai'], $value['selesai'],$value['ruang'], $value['shift'], $value['kebutuhan_pengawas']);	
		}
		$this->download($result);
	}

	public function downloadUAS(){
		$query ="
		SELECT distinct nama, tipe, tata_cara,mulai,selesai,ruang,shift,kebutuhan_pengawas 
		FROM 
			(
			SELECT mengajar.kode, tipe, tata_cara, mulai, selesai, ruang, shift, kebutuhan_pengawas 
			FROM ujian inner join mengajar on ujian.mengajar_id = mengajar.id WHERE tipe LIKE 'UAS'
			)as himpA inner join matakuliah 
				on himpA.kode = matakuliah.kode
		ORDER BY mulai ASC";
		$query_result = $this->db->executeSelectQuery($query);
		$result = $this->db->executeSelectQuery($query_result);
		foreach($query_result as $key => $value){
			$result[] = new ujian(null,$value['nama'], $value['tipe'],$value['tata_cara'],$value['mulai'], $value['selesai'],$value['ruang'], $value['shift'], $value['kebutuhan_pengawas']);	
		}
		$this->download($result);
	}
	
	public function download($jadwal)
	{
		$resUTS = $jadwal;
		$html = '<!DOCTYPE html>
		<html lang="en">
		<head>
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<link rel="stylesheet" href="View/Style/download.css">
			<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
			<title>Jadwal Ujian FTIS UNPAR</title>
		</head>
		<body>
			<h1>Jadwal Ujian</h1>
			<table>
				<tr>
					<th>No.</th>
					<th>Mata Kuliah</th>
					<Th>Tipe</Th>
					<th>Tata Cara</th>
					<th>Mulai</th>
					<th>Selesai</th>
					<th>Ruang</th>
					<th>Shift</th>
					<th>Kebutuhan Pengawas</th>
				</tr>';
		$i=1;
		foreach($resUTS  as $key => $value){
			$html.='<tr>
			<td>'.$i.'</td>
			<td>'.$value->mataKuliah.'</td> 
			<td>'.$value->tipe.'</td> 
	 		<td>'.$value->tatacara.'</td> 
			<td>'.$value->mulai.'</td>
		 	<td>'.$value->selesai.'</td> 
		  	<td>'.$value->ruang.'</td> 
		  	<td>'.$value->shift.'</td> 
		  	<td>'.$value->jumlahPengawas.'</td> 
		</tr>';
		$i++;
		}
		$html.=' </table>
		</body>
		</html>';

		$mpdf = new \Mpdf\Mpdf();
		$mpdf->WriteHTML($html);
		$mpdf->Output('Jadwal_Ujian.pdf',\Mpdf\Output\Destination::INLINE);
	}

}

?>