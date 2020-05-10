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
        <h2 style="display: inline-block;"><?php echo $nama ;?></h2>
        <a href="logout"><i class="fa fa-sign-out" style="font-size:30px"></i><br>Sign Out</a>
    </div>
    <hr>
    <div id="tambahJadwal"  style="width: 70%;display: inline-block;">
        <a href="jadwalBaru"><i class="fa fa-plus-circle" style="font-size:70px"></i><br><br> Tambah Jadwal Baru</a>
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