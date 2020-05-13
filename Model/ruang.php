<?php

class Ruang{
    public $nama;
    public $kapasitas;

	public function __construct($name, $kapasitas){
        $this->nama = $name;
        $this->kapasitas = $kapasitas;
	}
}
?>
