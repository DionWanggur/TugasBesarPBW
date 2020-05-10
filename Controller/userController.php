<?php
require_once "controller/services/view.php";
require_once 'vendor/autoload.php';

class UserController{
    
	public function view_index(){
		return View::createView('UserPage.php',[]);
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