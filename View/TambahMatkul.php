<form action="" method="post">
    <label for="mataKuliahUjian"><strong>Pilih Mata Kuliah</strong></label>
    <select name="mataKuliahUjian" id="" required>
        <option value="">ASD</option>
        <option value="">DAA</option>
        <option value="">PBO</option>
    </select><br>
    <label for="tataCara"><strong>Tata Cara</strong></label>
    <select name="tataCara" id="" required>
        <option value="">C-Close Book</option>
        <option value="">C-Open Book</option>
        <option value="">P-Open File</option>
    </select><br>
    <label for="mulai">Mulai</label>
    <input type="time" name="waktuMulai" id="" style="margin-right: 5%;" required>
    <label for="mulai">Selesai</label>
    <input type="time" name="waktuSelesai" id="" required><br><br>
    <label for="ruang">Ruang</label>
    <input type="text" name="ruang" id="" style="width: 20%;margin-right: 5%;">
    <input type="button" value="Tambahkan" style="background-color: rgba(12, 158, 12, 0.87);">
</form>