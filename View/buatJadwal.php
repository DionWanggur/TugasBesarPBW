<div class="content" style="width: 100%;display: inline-block;">
    <h2>Tambahkan Mata Kuliah Pada Jadwal Yang Anda Buat !</h2>
    <form action="tambahMatkul" method="POST">
        <label for="mulai"><strong>Mulai</strong></label>
        <input type="datetime-local" name="mulai" placeholder="YYYY/MM/DD" style="width: 25%; margin-right:2%;" required>
        <label for="selesai"><strong>Selesai</strong></label>
        <input type="datetime-local" name="selesai" placeholder="YYYY/MM/DD" style="width: 25%" required>
        <label ><strong>Jumlah Pengawas</strong></label>
        <input type="number" name="jumlahPengawas"  style="width: 10%" min="1" max="10" required>
        <label ><strong>Shift</strong></label>
        <input type="number" name="shift"  style="width: 10%" min="1" max="3" required>
        <br>
        <label for="mataKuliahUjian"><strong>Pilih Mata Kuliah</strong></label>
        <select name="mataKuliahUjian" id="" required>
            <?php
                foreach($matkul as $key => $row){
                    echo "<option value = '". $row->nama."'>" . $row->nama. "</option>";
                }
            ?>
        </select><br>
        <label for="tataCara"><strong>Tata Cara</strong></label>
        <select name="tataCara" id="" required>
            <option value="C-Close Book">C-Close Book</option>
            <option value="C-Open Book">C-Open Book</option>
            <option value="P-Open File">P-Open File</option>
            <option value="P-Close File">P-Close File</option>
            <option value="P-Third Party">P-Third Party</option>
            <option value="Tidak Ada">Tidak Ada</option>
        </select><br>
        <label for="ruang">Ruang</label>
        <select name="ruang" id="" required>
            <?php
                foreach($ruang as $key => $row){
                    echo "<option value = '". $row->nama."'>" . $row->nama." Kapasitas = ".$row->kapasitas."</option>";
                }
            ?>
        </select><br>
        <input type="submit" value="Buat Jadwal" style="background-color: rgba(12, 158, 12, 0.87); margin-right:3%;">
        <input type="button" value="Cancel" style="background-color: rgba(240, 6, 6, 0.836);float:right" onclick="cancaled()">
    </form>
</div>

<script>
    function cancaled() {
        if (confirm("Anda Yakin Untuk Membatalkan Pengisisan Form ?")) {
            window.location.href='index';
        }
    }
    
</script>