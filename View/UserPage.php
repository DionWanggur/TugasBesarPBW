<div class="sidenav">
    <span id="logo">FTIS</span>
    <hr>
    <div class="sidenavContent">
        <a href=""><i class="fa fa-list-alt" style="font-size:70px;"></i><br><br> Jadwal Ujian</a>
        <hr>
        <a href="download"><i class="fa fa-download" style="font-size:70px"></i><br><br> Download Jadwal Ujian</a>
        <hr>
    </div>

</div>

<div class="main">
    <div class="user">
        <h2 style="display: inline-block;"><?php echo $nama; ?></h2>
        <a href="logout"><i class="fa fa-sign-out" style="font-size:30px"></i><br>Sign Out</a>
    </div>
    <hr>
    <form method="GET" action="users.php" style="margin-bottom: 2%;">
        <legend>Search by Mata Kuliah</legend>
        <input type="text" name="filter" value="" style="width: 40%">
        <input type="submit" value="SEARCH">
    </form>
    <div class="contentUTS">
        <table>
            <tr>
                <th>No.</th>
                <th>Mata Kuliah</th>
                <Th>Tipe</Th>
                <th>Tata Cara</th>
                <th>Mulai</th>
                <th>Selesai</th>
                <th>Ruang</th>
                <th>Shift</th>
                <th>Kebutuhan Pengawas</th>
            </tr>
            <?php
            $i=1;
            foreach($resUTS  as $key => $value){
            echo"<tr>";
            echo "<td>".$i."</td>";
            echo " <td>".$value->mataKuliah."</td> ";
            echo " <td>".$value->tipe."</td> ";
            echo " <td>".$value->tatacara."</td> ";
            echo " <td>".$value->mulai."</td> ";
            echo " <td>".$value->selesai."</td> ";
            echo " <td>".$value->ruang."</td> ";
            echo " <td>".$value->shift."</td> ";
            echo " <td>".$value->jumlahPengawas."</td> ";
            echo"</tr>";
            $i++;
            }
            ?>
        </table>
    </div>
    <div class="contentUAS">
        <table>
            <tr>
                <th>No.</th>
                <th>Mata Kuliah</th>
                <Th>Tipe</Th>
                <th>Tata Cara</th>
                <th>Mulai</th>
                <th>Selesai</th>
                <th>Ruang</th>
                <th>Shift</th>
                <th>Kebutuhan Pengawas</th>
            </tr>
            <?php
            $i=1;
            foreach($resUAS  as $key => $value){
            echo"<tr>";
            echo "<td>".$i."</td>";
            echo " <td>".$value->mataKuliah."</td> ";
            echo " <td>".$value->tipe."</td> ";
            echo " <td>".$value->tatacara."</td> ";
            echo " <td>".$value->mulai."</td> ";
            echo " <td>".$value->selesai."</td> ";
            echo " <td>".$value->ruang."</td> ";
            echo " <td>".$value->shift."</td> ";
            echo " <td>".$value->jumlahPengawas."</td> ";
            echo"</tr>";
            $i++;
            }
            ?>
        </table>
    </div>
</div>