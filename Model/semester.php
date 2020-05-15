<?php

class Semester{
    public $id;
    public $jenis;
    public $tahunAjar;

	public function __construct($id,$jenis, $tahunAjar){
        $this->id = $id;
        $this->jenis = $jenis;
        $this->tahunAjar = $tahunAjar;
	}
}
?>
