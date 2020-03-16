<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="costume_css" rel="stylesheet">
    <title>Metode Electre </title> 
    <?php include("koneksi.php"); ?>
</head>
    <body>
      <table border="1" style="width:30%">
          <h1>LIST ALTERNATIF</h1>
          <?php $query="Select * from data_electre";
          $hasil=mysqli_query($query); 
          while($data=mysql_fetch_array($hasil)){
              
          ?>
          <tr>
              <td><?php echo $data[0] ?></td>
              <td><?php echo $data[1] ?></td>
              <td><?php echo $data[2] ?></td>
              <td><?php echo $data[3] ?></td>
              <td><?php echo $data[4] ?></td>
          </tr> 
          <?php } ?>
      </table>
    </body>
    
</html>