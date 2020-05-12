<div class="content" style="width: 40%;display: inline-block;">
    <form action="tambahMatkul" method="get">
        <label for="Hari"><strong>Hari</strong></label>
        <input type="date" name="hariUjian" placeholder="YYYY/MM/DD" required>
        <label for="jumlahMatkul"><strong>Jumlah Mata Kuliah</strong></label><br>
        <input type="number" name="jumlahMatkul" required placeholder="Jumlah Mata Kuliah Pada Hari Tersebut" id="" min="1" max="31">
        <br>
        <input type="submit" value="Buat Jadwal" style="background-color: rgba(12, 158, 12, 0.87);">
        <input type="button" value="Cancel" style="float: right; background-color: rgba(240, 6, 6, 0.836);">
    </form>
</div>
<div id="section" style="width: 55%; ">
    <?php echo $matKul ;?>
    <!-- <form action="" method="post">
        <label for="mataKuliahUjian"><strong>Pilih Mata Kuliah</strong></label>
        <select name="mataKuliahUjian" id="">
            <option value="">ASD</option>
            <option value="">DAA</option>
            <option value="">PBO</option>
        </select><br>
        <label for="tataCara"><strong>Tata Cara</strong></label>
        <select name="tataCara" id="">
            <option value="">C-Close Book</option>
            <option value="">C-Open Book</option>
            <option value="">P-Open File</option>
        </select><br>
        <label for="mulai">Mulai</label>
        <input type="time" name="waktuMulai" id="" style="margin-right: 5%;">
        <label for="mulai">Selesai</label>
        <input type="time" name="waktuSelesai" id=""><br><br>
        <label for="ruang">Ruang</label>
        <input type="text" name="ruang" id="" style="width: 20%;margin-right: 5%;">
        <input type="button" value="Next >>" style="background-color: rgba(12, 158, 12, 0.87);">

    </form> -->
</div>