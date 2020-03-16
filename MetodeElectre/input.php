<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="costume_css" rel="stylesheet">
    <title>Metode Electre </title> 
</head>
    <body>
      <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="costume_css" rel="stylesheet">
    <title>Metode Electre </title> 
    <?php include("koneksi.php"); ?>
</head>
    <body>
        
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
        <?php
        $query="Select * from data_electre";
        $hasil=mysqli_query($koneksi,$query);             
        while($data=mysqli_fetch_array($hasil, MYSQLI_ASSOC)){
        ?>
        <tr>
            <td><?php echo $data['namaAlternatif']; ?></td>
            <td><?php echo $data['Fasilitas']; ?></td>
            <td><?php echo $data['Harga']; ?></td>
            <td><?php echo $data['Tahun']; ?></td>
            <td><?php echo $data['Jarak']; ?></td>
            <td><?php echo $data['Keamanan']; ?></td>
        </tr> 
        <?php } ?>
        
    </table>
    <ul>
    <h4><a href="input.php">Data Alternatif</a></h4>
    <h4><a href="output.php">Hitung Nilai Alternatif</a></h4>
    </ul>
    <?php
        if(isset($_POST['uploadFile'])){
            $namaAlternatif=$_POST['namaAlternatif'];
            $kriteriaHarga=intval($_POST['kriteriaFasilitas']);
            $kriteriaKualitas=intval($_POST['kriteriaHarga']);
            $kriteriaFitur=intval($_POST['kriteriaTahun']);
            $kriteriaPopuler=intval($_POST['kriteriaJarak']);
            $kriteriaKeawetan=intval($_POST['kriteriaKeamanan']);
            $query="INSERT INTO data_electre (`namaAlternatif`, `Fasilitas`, `Harga`, `Tahun`, `Jarak`, `Keamanan`) VALUES 
            ('$namaAlternatif', '$kriteriaFasilitas', '$kriteriaHarga', '$kriteriaTahun', '$kriteriaJarak', '$kriteriaKeamanan');";
            mysqli_query ($koneksi,$query);
                header('Location:input.php');
        }
    ?>
    </body>
</html>