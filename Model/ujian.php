<?php
    class ujian{
        public $id;
        public $mataKuliah;
        public $tipe;
        public $tatacara;
        public $mulai;
        public $selesai;
        public $ruang;
        public $shift;
        public $jumlahPengawas;

        public function __construct($id,$mataKuliah,$tipe, $tatacara, $mulai, $selesai, $ruang, $shift, $jumlahPengawas){
            $this->id = $id;
            $this->mataKuliah = $mataKuliah;
            $this->tipe = $tipe;
            $this->tatacara = $tatacara;
            $this->mulai = $mulai;
            $this->selesai = $selesai;
            $this->ruang = $ruang;
            $this->shift = $shift;
            $this->jumlahPengawas = $jumlahPengawas;
        }
    }
?>  