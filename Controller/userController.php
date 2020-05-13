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
    
	public function view_index(){
		if(session_status() == PHP_SESSION_ACTIVE && isset($_SESSION['nama'])) {
			$nama = $_SESSION['nama'];
		}
		$resUTS = $this->getUTS();
		$resUAS = $this->getUAS();
		return View::createView('UserPage.php',["resUTS"=>$resUTS, "resUAS"=>$resUAS,"nama"=>$nama]);
	}
	
	public function download()
	{
		$mpdf = new \Mpdf\Mpdf();
		$mpdf->WriteHTML('<table>
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
		</tr>
	</table>');
		$mpdf->Output();
	}

	public function getUTS(){
		$query = "
		SELECT distinct nama, tipe, tata_cara,mulai,selesai,ruang,shift,kebutuhan_pengawas 
		FROM 
			(
			SELECT mengajar.kode, tipe, tata_cara, mulai, selesai, ruang, shift, kebutuhan_pengawas 
			FROM ujian inner join mengajar on ujian.mengajar_id = mengajar.id WHERE tipe LIKE 'UTS'
			)as himpA inner join matakuliah 
				on himpA.kode = matakuliah.kode
			";
		$query_result = $this->db->executeSelectQuery($query);
		$result = [];
		foreach($query_result as $key => $value){
			$result[] = new ujian(null,$value['nama'], $value['tipe'],$value['tata_cara'],$value['mulai'], $value['selesai'],$value['ruang'], $value['shift'], $value['kebutuhan_pengawas']);
		}

		return $result;
	}

	public function getUAS(){
		$query = "
		SELECT distinct nama, tipe, tata_cara,mulai,selesai,ruang,shift,kebutuhan_pengawas 
		FROM 
			(
			SELECT mengajar.kode, tipe, tata_cara, mulai, selesai, ruang, shift, kebutuhan_pengawas 
			FROM ujian inner join mengajar on ujian.mengajar_id = mengajar.id WHERE tipe LIKE 'UAS'
			)as himpA inner join matakuliah 
				on himpA.kode = matakuliah.kode
			";
		$query_result = $this->db->executeSelectQuery($query);
		$result = [];
		foreach($query_result as $key => $value){
			$result[] = new ujian(null,$value['nama'], $value['tipe'],$value['tata_cara'],$value['mulai'], $value['selesai'],$value['ruang'], $value['shift'], $value['kebutuhan_pengawas']);
		}

		return $result;
	}
}

?>