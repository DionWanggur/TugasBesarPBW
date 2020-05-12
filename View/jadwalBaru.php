<div class="content" style="width: 70%;display: inline-block;">
    <form action="buatJadwal" method="get">
        <label for="sceaduleTitle"><strong>Judul Jadwal</strong></label>
        <input type="text" name="sceaduleTitle" placeholder="Title">
        <label for="sceaduleType"><strong>Tipe Jadwal</strong></label><br>
        <select name="tipeUjian" id="">
            <option value="UTS">UTS</option>
            <option value="UAS">UAS</option>
        </select><br>
        <label for="sceaduleType"><strong>Hari</strong></label><br>
        <input type="number" name="jumlahHari" placeholder="Jumlah Hari dalam Ujian" id="" min="1" max="31">
        <br>
        <label for="semester"><strong>Semester</strong></label><br>
        <select name="semester" id="">
            <option value="ganjil">GANJIL</option>
            <option value="genap">GENAP</option>
        </select><br>
        <input type="submit" value="Next >>" style="background-color: rgba(12, 158, 12, 0.87);">
        <input type="button" value="Cancel" style="float: right; background-color: rgba(240, 6, 6, 0.836);">
    </form>
</div>
<div id="section">
    <h3>kamu bisa menambahkan jadwal ujian yang sudah ada dari perangkat, import file .xls dari perangkat</h3>
    <form id="formUpload" method="POST" action="fileUpload" enctype="multipart/form-data">
        <i class="fa fa-upload" style="font-size:50px"></i><br><br>
        <input type="file" name="file">
        <input type="submit" value="Upload" name="submit">
    </form>

</div>