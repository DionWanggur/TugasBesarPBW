<form method="GET" action="jadwalUTS" style="margin-bottom: 2%;">
        <legend>Search by Mata Kuliah</legend>
        <input type="text" name="filter" value="" style="width: 40%">
        <input type="submit" value="SEARCH">
    </form>
    
    <div class="contentUTS">
    <?php 
        foreach ($link as $key => $value) {
            echo "$value";
        }
        echo "<br><br><br>";
    ?>
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