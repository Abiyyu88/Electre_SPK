<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="costume_css" rel="stylesheet">
    <title>Metode Electre </title> 
    <?php include("koneksi.php"); 
    error_reporting(0);?>
</head>
    <body>
    <ul>
    <h4><a href="input.php">Data Alternatif</a></h4>
    <h4><a href="output.php">Hitung Nilai Alternatif</a></h4>
    </ul>
        <?php $namaTanpaBobot=array();
        $arraySoal=array();
        $arrayConcordance=array();
        $arrayDisordance=array();
        $arrayMatriksDominanConcordance=array();
        $arrayMatriksDominanDisordance=array();
        $arrayAgregatDominanceMatriks=array();
        $statusInputan=false; ?>
        <table border="1" style="width:40%">
            <h3>LIST ALTERNATIF</h3>
            <tr>          
                <td></td>
                <td>Fasilitas Pendukung</td>
                <td>Harga Bangunan</td>
                <td>Tahun Konstruksi</td>
                <td>Jarak Ke Tempat Kerja</td>
                <td>Sistem Keamanan</td>
            </tr>
            <?php $query="Select * from data_electre";
            $hasil=mysqli_query($koneksi,$query);           
            $i=0;
            while($data=mysqli_fetch_array($hasil, MYSQLI_ASSOC)){
            ?>
            <tr>
            <td><?php echo $namaTanpaBobot[$i]=$data['namaAlternatif'] ?></td>
            <td><?php echo $arraySoal[$i][0]=$data['Fasilitas'] ?></td>
            <td><?php echo $arraySoal[$i][1]=$data['Harga'] ?></td>
            <td><?php echo $arraySoal[$i][2]=$data['Tahun'] ?></td>
            <td><?php echo $arraySoal[$i][3]=$data['Jarak'] ?></td>
            <td><?php echo $arraySoal[$i][4]=$data['Keamanan'] ?></td>
            </tr> 
            <?php $i++; } ?>
        </table>
        <?php 
        $namaBobot=$namaTanpaBobot;
        $namaBobot[count($namaBobot)]="Bobot";
        $kriteriaBobot=array("Fasilitas","Harga","Tahun","Jarak","Keamanan");
        $banyakAlternatif=$i+1;
        $arraySoal=testingBobot($arraySoal);
        
        echo "<h3><br>"."MATRIKS SOAL"."<br></h3>";
        printArray4($arraySoal);
        $arrayXDataNilai=$arraySoal;
        $arrayXDataNilai=xDataNilai($arraySoal,$arrayXDataNilai);

        echo "<br>"."MATRIKS X (Data Nilai)"."<br>";
        printArray4($arrayXDataNilai);
        $arrayRNormalisasi=$arraySoal;
        $arrayRNormalisasi=rNormalisasi($arrayXDataNilai,$arrayRNormalisasi);

        echo "<br>"."MATRIKS R Normalisasi"."<br>";
        printArray4($arrayRNormalisasi);
        $arrayV=$arraySoal;
        $arrayV=tabelV($arrayV,$arrayRNormalisasi);

        echo "<br>"."MATRIKS V (NORMALISASI * BOBOT)"."<br>";
        printArray4($arrayV);
        $arrayConcordance=deklarasiArray3x3($arrayConcordance);
        $arrayConcordance=tabelConcordance($arrayConcordance,$arrayV);
            
        echo "<br>"."TABEL CONCORDANCE"."<br>";
        printArray3x3($arrayConcordance);
        $arrayDisordance=deklarasiArray3x3($arrayDisordance);
        $arrayDisordance=tabelDisordance($arrayDisordance,$arrayV);

        echo "TABEL DISCORDANCE"."<br>";
        printArray3x3($arrayDisordance);
        $arrayMatriksConcordance=$arrayConcordance;
        $arrayMatriksConcordance=matriksConcordance($arrayMatriksConcordance,$arrayV,$arraySoal);
        
        echo "TABEL MATRIKS CONCORDANCE"."<br>";
        printArray3x3($arrayMatriksConcordance);
        $arrayMatriksDisordance=$arrayDisordance;
        $arrayMatriksDisordance=matriksDisordance($arrayMatriksDisordance,$arrayV);
        
        echo "TABEL MATRIKS DISCORDANCE"."<br>";
        printArray3x3($arrayMatriksDisordance);
        $tresholdConcordance=tresholdConcordance($arrayMatriksConcordance);
        
        echo "TRESHOLD CONCORDANCE"."<br>".$tresholdConcordance."<br>"."<br>";
        $tresholdDisordance=tresholdDisordance($arrayMatriksDisordance);

        echo "TRESHOLD DISCORDANCE"."<br>".$tresholdDisordance."<br>"."<br>";
        $arrayMatriksDominanConcordance=matriksDominanConcordance($arrayMatriksDominanConcordance,$tresholdConcordance,$arrayMatriksConcordance);

        echo "MATRIKS DOMINAN CONCORDANCE"."<br>";
        printArray3x3($arrayMatriksDominanConcordance);
        $arrayMatriksDominanDisordance=matriksDominanConcordance($arrayMatriksDominanDisordance,$tresholdDisordance,$arrayMatriksDisordance);

        echo "MATRIKS DOMINAN DISORDANCE"."<br>";
        printArray3x3($arrayMatriksDominanDisordance);
        $arrayAgregatDominanceMatriks=agregatDominanceMatriks($arrayAgregatDominanceMatriks,$arrayMatriksDominanConcordance,$arrayMatriksDominanDisordance);

        echo "AGREGATE DOMINANCE MATRIKS"."<br>";
        printArray3x3agregrat   ($arrayAgregatDominanceMatriks);

        echo "PILIHAN YANG PALING OPTIMAL ADALAH :"."<br>";
        $jawaban=perangkingan($arrayAgregatDominanceMatriks);

        if($jawaban==10){echo "Tidak ada alternatif yang sesuai";
        }
        else{
            echo "Nama Alternatif= ".$namaBobot[$jawaban];  
        }
        ?>
        <?php
        function testingBobot($arraySoal){
            global $i;
            $arraySoal[$i][0]="3";
            $arraySoal[$i][1]="2";                            
            $arraySoal[$i][2]="2";
            $arraySoal[$i][3]="2";
            $arraySoal[$i][4]="1";                            
            return $arraySoal;  
        }
        ?>
         <?php
        function deklarasiArray3x3($arraySoal){
            global $banyakAlternatif;
            for($i=0;$i<$banyakAlternatif;$i++){
               for($j=0;$j<$banyakAlternatif;$j++){
                 $arraySoal[$i][$j]="0";
            }}return $arraySoal;}
        ?>
        
        <?php
        function printArray4($printArray){
            ?>
            <tabel style="width:50%">
                <tr>
                    <td>Alternatif : </td>
            <?php
                global $kriteriaBobot;global $namaBobot;
                global $banyakAlternatif;
                for($i=0;$i<5;$i++){ ?>
                    <td><?php echo $kriteriaBobot[$i]; ?></td><?php } ?>
                    <br>
                    </tr>
                    <?php
                for($i=0;$i<$banyakAlternatif;$i++){ ?>
                    <tr>
                    <td><?php echo $namaBobot[$i]; ?> |</td>
                    <?php 
                for($j=0;$j<5;$j++){ ?>
                    <td>
                    <?php echo " ' ".$printArray[$i][$j]." ' ";  ?> 
                    </td>
                    <?php }
                    //echo " |";
                    //echo "<br>";}echo "<br>"; 
                    ?>
                </tr> <br>
            <?php } ?>
                 </tabel> <?php } ?>
    
        
        <?php
        function printArray3x3($printArray){
            echo "Alternatif"." |";
            global $namaBobot;
            global $banyakAlternatif;
            for($i=0;$i<$banyakAlternatif-1;$i++){
                echo " ".$namaBobot[$i]." ";}
            echo "<br>";
            for($i=0;$i<$banyakAlternatif-1;$i++){    
                echo $namaBobot[$i];
                echo "| ";
               for($j=0;$j<$banyakAlternatif-1;$j++){
                   if($i==$j){$printArray[$i][$j]="0";}
                echo "' ".$printArray[$i][$j]." ' ";}
                echo " |";
                echo "<br>";}echo "<br>";}
        ?>
        <?php
        function printArray3x3agregrat($printArray){
            echo "Alternatif"." |";
            global $namaBobot;
            global $banyakAlternatif;
            for($i=0;$i<$banyakAlternatif-1;$i++){
                echo " ".$namaBobot[$i]." ";}
            echo "<br>";
            for($i=0;$i<$banyakAlternatif-1;$i++){    
                echo $namaBobot[$i];
                echo "| ";
               for($j=0;$j<$banyakAlternatif-1;$j++){
                   if($i==$j){$printArray[$i][$j]="-";}
                echo "' ".$printArray[$i][$j]." ' ";}
                echo " |";
                echo "<br>";}echo "<br>";}
        ?>    
        <?php
        function xDataNilai($arraySoal,$arrayXDataNilai){
            global $banyakAlternatif;
            for($i=0;$i<5;$i++){
                 $arrayXDataNilai[$banyakAlternatif-1][$i]=0;
                for($j=0;$j<$banyakAlternatif-1;$j++){
          $arrayXDataNilai[$banyakAlternatif-1][$i]=($arraySoal[$j][$i]*$arraySoal[$j][$i])+$arrayXDataNilai[$banyakAlternatif-1][$i];
                }$arrayXDataNilai[$banyakAlternatif-1][$i]=sqrt($arrayXDataNilai[$banyakAlternatif-1][$i]);
            }
            return $arrayXDataNilai;
        }
        ?>
        
        <?php
        function rNormalisasi($arrayXDataNilai,$arrayRNormalisasi){
            global $banyakAlternatif;
            for($i=0;$i<$banyakAlternatif-1;$i++){
            for($j=0;$j<5;$j++){
                if($arrayRNormalisasi[$i][$j]==0){
                     $arrayRNormalisasi[$i][$j]="0";
                }else{
                $arrayRNormalisasi[$i][$j]=$arrayRNormalisasi[$i][$j]/$arrayXDataNilai[$banyakAlternatif-1][$j];
                }
            }}
        return $arrayRNormalisasi;
        }
        ?>
        
        <?php
        function tabelV($arrayV,$arrayRNormalisasi){
            global $banyakAlternatif;
            for($i=0;$i<$banyakAlternatif-1;$i++){
            for($j=0;$j<5;$j++){
                $arrayV[$i][$j]=$arrayRNormalisasi[$i][$j]*$arrayV[$banyakAlternatif-1][$j];
            }}
            
        return $arrayV;}
        ?>
        
        <?php
        function tabelConcordance($arrayConcordance,$arrayV){
            global $banyakAlternatif;
            
            for($baris=0;$baris<$banyakAlternatif;$baris++){
            for($kolom=0;$kolom<$banyakAlternatif;$kolom++){
            if($baris==$kolom){$arrayConcordance[$baris][$kolom]="";}
            else{
            $arrayConcordance[$baris][$kolom]=" ";
            for($j=0;$j<5;$j++){
            if($arrayV[$baris][$j]>=$arrayV[$kolom][$j]){
                $i=$j+1;
                if($j==4){
                $arrayConcordance[$baris][$kolom]=$arrayConcordance[$baris][$kolom].$i;
                }else{
                $arrayConcordance[$baris][$kolom]=$arrayConcordance[$baris][$kolom].$i.",";}}
            }}}}
            return $arrayConcordance;}
        ?>
        
         <?php
        function tabelDisordance($arrayDisordance,$arrayV){
            global $banyakAlternatif;
            for($baris=0;$baris<$banyakAlternatif-1;$baris++){
            for($kolom=0;$kolom<$banyakAlternatif-1;$kolom++){
            if($baris==$kolom){$arrayDisordance[$baris][$kolom]=" ";}
            else{
            $arrayDisordance[$baris][$kolom]=" ";
            for($j=0;$j<5;$j++){
            if($arrayV[$baris][$j]<$arrayV[$kolom][$j]){
                $i=$j+1;
                if($j==4){
                $arrayDisordance[$baris][$kolom]=$arrayDisordance[$baris][$kolom].$i;
                }else{
                $arrayDisordance[$baris][$kolom]=$arrayDisordance[$baris][$kolom].$i.",";}}
            }}}}
            
        return $arrayDisordance;}
        ?>
        
        <?php
        function matriksConcordance($arrayMatriksConcordance,$arrayV,$arraySoal){
            global $banyakAlternatif;
            $baris=0;
            $targetBaris=3;
            $kolom=0;
            for($baris=0;$baris<$banyakAlternatif-1;$baris++){
             for($kolom=0;$kolom<$banyakAlternatif-1;$kolom++){
                 if($kolom==$baris){$arrayMatriksConcordance[$baris][$kolom]=" ";}
                 else{
            $arrayMatriksConcordance[$baris][$kolom]=" ";
            for($j=0;$j<5;$j++){
            if($arrayV[$baris][$j]>=$arrayV[$kolom][$j]){
                $i=$j+1;
                $arrayMatriksConcordance[$baris][$kolom]+=$arraySoal[$targetBaris][$j];
            }
            }
            }}}
            
        return $arrayMatriksConcordance;}
        ?>
        
        <?php
        function matriksDisordance($arrayMatriksDisordance,$arrayV){
            global $banyakAlternatif;
            $baris=0;$kolom=1;
            for($baris=0;$baris<$banyakAlternatif-1;$baris++){ $barisTarget=0;
            for($kolom=0;$kolom<$banyakAlternatif-1;$kolom++){
            if($baris==$kolom){$arrayMatriksDisordance[$baris][$kolom]="-";$barisTarget++;}
            else{
            if($baris==$barisTarget){$barisTarget++;}
            else{
            $arrayPembagi=array();$arrayDibagi=array();
            for($j=0;$j<5;$j++){
            $arrayPembagi[$j]=$arrayV[$baris][$j]-$arrayV[$barisTarget][$j];
                    //untuk absolute
                    if($arrayPembagi[$j]<0){
                        $arrayPembagi[$j]=$arrayPembagi[$j]*-1;
                    }
            }
            $pembagi=max($arrayPembagi);
            //mencari max bilangan yang akan dibagi
            $arrayDibagi[0]="0";
            $i=0;
            $arrayMatriksDisordance[$baris][$kolom]=" ";
            for($j=0;$j<5;$j++){
            if($arrayV[$baris][$j]<$arrayV[$barisTarget][$j]){
                $arrayDibagi[$i]=$arrayV[$baris][$j]-$arrayV[$barisTarget][$j];
                if($arrayDibagi[$i]<0){
                    $arrayDibagi[$i]=$arrayDibagi[$i]*-1;
                }
                $i++;
            }
            }$dibagi=max($arrayDibagi); 
            if($dibagi==0){
                $arrayMatriksDisordance[$baris][$kolom]=="-";
            }else{
                $arrayMatriksDisordance[$baris][$kolom]=$dibagi/$pembagi;
                if($arrayMatriksDisordance[$baris][$kolom]==0){$arrayMatriksDisordance[$baris][$kolom]="0";}
            }$barisTarget++;}
            }}}
            
            
            
        return $arrayMatriksDisordance;}
        ?>
        
        <?php
        function tresholdConcordance($arrayMatriksConcordance){
            global $banyakAlternatif;
            $jawaban=0;
            for($i=0;$i<$banyakAlternatif-1;$i++){
               for($j=0;$j<$banyakAlternatif-1;$j++){
                $jawaban=$arrayMatriksConcordance[$i][$j]+$jawaban;
            } 
            }
            global $namaTanpaBobot;
            $banyakKriteria=count($namaTanpaBobot);
            $jawaban=$jawaban/($banyakKriteria*($banyakKriteria-1));
            return $jawaban;
        }
        ?>
        
        <?php
        function tresholdDisordance($arrayMatriksDisordance){
            global $banyakAlternatif;
            $jawaban=0;
            for($i=0;$i<$banyakAlternatif-1;$i++){
               for($j=0;$j<$banyakAlternatif-1;$j++){
                $jawaban=$arrayMatriksDisordance[$i][$j]+$jawaban;
            } 
            }
            global $namaTanpaBobot;
            $banyakKriteria=count($namaTanpaBobot);
            $jawaban=$jawaban/($banyakKriteria*($banyakKriteria-1));
            return $jawaban;
        }
        ?>
        
        <?php
        function matriksDominanConcordance($arrayMatriksDominanConcordance,$tresholdConcordance,$arrayMatriksConcordance){
            global $banyakAlternatif;
            for($i=0;$i<$banyakAlternatif-1;$i++){
                for($j=0;$j<$banyakAlternatif-1;$j++){
                    
                    if($arrayMatriksConcordance[$i][$j]>=$tresholdConcordance){
                        
                        $arrayMatriksDominanConcordance[$i][$j]="1";
                    }
                    else{
                        $arrayMatriksDominanConcordance[$i][$j]="0";
                    }
                }
            }
            return $arrayMatriksDominanConcordance;
        }
        ?>
        
        <?php
        function matriksDominanDisordance($arrayMatriksDominanDisordance,$tresholdDisordance,$arrayMatriksDisordance){
            global $banyakAlternatif;
            for($i=0;$i<$banyakAlternatif-1;$i++){
                for($j=0;$j<$banyakAlternatif-1;$j++){
                    
                        if($arrayMatriksDisordance[$i][$j]>=$tresholdDisordance){
                        
                        $arrayMatriksDominanDisordance[$i][$j]="1";
                    }
                        else{
                        $arrayMatriksDominanDisordance[$i][$j]="0";
                    }
                }
            }
            return $arrayMatriksDominanDisordance;
        }
        ?>
        
        <?php
        function agregatDominanceMatriks($arrayAgregatDominanceMatriks,$arrayMatriksDominanConcordance,$arrayMatriksDominanDisordance){
            global $banyakAlternatif;
            for($i=0;$i<$banyakAlternatif-1;$i++){
                for($j=0;$j<$banyakAlternatif-1;$j++){
                    $hasilPerkalianMatriksDominan=$arrayMatriksDominanConcordance[$i][$j]*$arrayMatriksDominanDisordance[$i][$j];
                    if($hasilPerkalianMatriksDominan==1){
                        $arrayAgregatDominanceMatriks[$i][$j]="1";
                    }else{
                        $arrayAgregatDominanceMatriks[$i][$j]="0";
                    }
                }
            }
            return $arrayAgregatDominanceMatriks;
        }
        
        ?>
        <?php
        
        function perangkingan($arrayAgregatDominanceMatriks){
            $perangkinganBaris=array();
            global $banyakAlternatif;
            for($i=0;$i<$banyakAlternatif-1;$i++){
                $perangkinganBaris[$i]=" ";
                for($j=0;$j<$banyakAlternatif-1;$j++){
                    $perangkinganBaris[$i]=$arrayAgregatDominanceMatriks[$i][$j]+ $perangkinganBaris[$i];
            }}
            $tertinggi=max($perangkinganBaris);
            if($tertinggi==0){return $ruangTertinggi=10;}
           
            foreach($perangkinganBaris as $key => $value){   
                if($tertinggi==$value){
                    $ruangTertinggi=$key;
                    return $ruangTertinggi;
                }
            }
        }
        ?>
    </body>
</html>