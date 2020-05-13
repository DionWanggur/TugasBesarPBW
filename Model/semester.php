<?php

class Semester{
    public $jenis;
    public $tahunAjar;

	public function __construct($jenis, $tahunAjar){
        $this->jenis = $jenis;
        $this->tahunAjar = $tahunAjar;
	}
}
?>
