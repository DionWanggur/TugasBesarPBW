<div class="content" style="width: 100%;display: inline-block;">
    <h2>Ambil Judul</h2>
    <form action="tambahMatkul" method="get">
        <label for="mulai"><strong>Mulai</strong></label>
        <input type="datetime-local" name="mulai" placeholder="YYYY/MM/DD" required>
        <label for="selesai"><strong>Selesai</strong></label>
        <input type="datetime-local" name="selesai" placeholder="YYYY/MM/DD" required>
        <br>
        <label for="mataKuliahUjian"><strong>Pilih Mata Kuliah</strong></label>
        <select name="mataKuliahUjian" id="">
            <option value="">ASD</option>
            <option value="">DAA</option>
            <option value="">PBO</option>
        </select><br>
        <label for="tataCara"><strong>Tata Cara</strong></label>
        <select name="tataCara" id="">
            <option value="C-Close Book">C-Close Book</option>
            <option value="C-Open Book">C-Open Book</option>
            <option value="P-Open File">P-Open File</option>
            <option value="P-Close File">P-Close File</option>
            <option value="P-Third Party">P-Third Party</option>
            <option value="Tidak Ada">Tidak Ada</option>
        </select><br>
        <label for="ruang">Ruang</label>
        <select name="ruang" id="">
            <option value="">1</option>
            <option value="">2</option>
            <option value="">3</option>
        </select><br>
        <input type="button" value="Tambahkan" style="background-color: rgba(12, 158, 12, 0.87);">
        <input type="button" value="Cancel" style="float: right; background-color: rgba(240, 6, 6, 0.836);">
        <br><br>
        <input type="submit" value="Buat Jadwal" style="background-color: rgba(12, 158, 12, 0.87);">
    </form>
</div>