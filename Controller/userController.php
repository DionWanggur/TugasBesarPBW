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

}

?>