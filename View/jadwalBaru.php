<div class="sidenav">
    <span id="logo"> FTIS</span>
    <hr>
    <div class="sidenavContent">
        <a href=""><i class="fa fa-file" style="font-size:50px;"></i><br><br> Jadwal Baru</a>
        <hr>
        <a href=""><i class="fa fa fa-book" style="font-size:50px"></i><br><br> Jadwal Ujian</a>
        <hr>
    </div>

</div>


<div class="main">
    <div class="user">
        <h2 style="display: inline-block;"><?php echo $nama; ?></h2>
        <a href="logout"><i class="fa fa-sign-out" style="font-size:30px"></i><br>Sign Out</a>
    </div>
    <hr>
    <div class="content" style="width: 70%;display: inline-block;">
        <form action="admin" method="post">
            <label for="sceaduleTitle"><strong>Judul Jadwal</strong></label>
            <input type="text" name="sceaduleTitle" placeholder="Title">
            <label for="sceaduleType"><strong>Tipe Jadwal</strong></label><br>
            <select name="tipeUjian" id="">
                <option value="UTS">UTS</option>
                <option value="UAS">UAS</option>
            </select><br>
            <label for="sceaduleType"><strong>Hari</strong></label><br>
            <input type="number" name="jumlahHari" placeholder="Jumlah Hari dalam Ujian" id="" min="1" max="31">
            <br><br>
            <input type="button" value="Next >>" style="background-color: rgba(12, 158, 12, 0.87);">
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
</div>