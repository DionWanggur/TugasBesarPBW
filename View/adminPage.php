<div class="sidenav">
    <span id="logo"> FTIS</span>
    <hr>
    <div class="sidenavContent">
        <a href="tambahJadwal"><i class="fa fa-file" style="font-size:50px;"></i><br><br> Jadwal Baru</a>
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
    <?php echo $content;?>
</div>