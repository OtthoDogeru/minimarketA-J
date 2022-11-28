<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css2.css">
</head>
<body>
<?php
session_start();
$carrera = $_SESSION['carrera'];
$seleccion = $_POST['eleccion'];
$codigof = $_SESSION['usuario']
?>
<p><h1>FICHA DE MATRICULA</h1></p>
<?php $_SESSION['usuario'] ?>
<table border='0' cellpadding='4' cellspacing='0' align = 'center'>
    <tr>
        <th>CODIGO</th>
        <td><?php echo $_SESSION['usuario']?></td>
        <th>SEMESTRE ACADEMIDO</th>
        <td>20221</td>
    </tr>
    <tr>
        <th>APELLIDO</th>
        <td><?php echo $_SESSION['apellidos']?></td>
    </tr>
    <tr>
        <th>NOMBRES</th>
        <td><?php echo $_SESSION['nombres']?></td>
    </tr>
    <tr>
        <th>CARRERA</th>
        <td><?php echo $_SESSION['abc']?></td>
    </tr>
    <tr>
        <th>SEDES</th>
        <td><?php echo $_SESSION['sede']?></td>
    </tr>
</table>
<p><h3>DETALLES DE CURSO</h3></p>
<form action="">
    <table border='1' cellpadding='4' cellspacing='0' align = 'center'>
        <tr>
            <th>CICLO</th>
            <th>ASIGNATURA</th>
            <th>CREDITOS</th>
            <th>H.T.</th>
            <th>H.P.</th>
            <th>SECCION</th>
        </tr>
        <?php
        include ("Conexion.php");
        $suma = 0;
        foreach($_POST['eleccion'] as $curso){
            $sql = "SELECT
            E.CODI_UNIV,
            C.codi_curs,
            CU.cicl_curs,
            C.DESC_CURS,   
            CU.cred_curs,
            CU.hrst_curs,
            CU.hrsp_curs,
            E.CODI_SEDE,
            E.CODI_CARR
            FROM
            estudiantes AS E,
            curso AS C
            INNER JOIN curricula AS CU
            ON
            C.CODI_CURS = CU.codi_curs
            WHERE
            C.CODI_CURS = '$curso' AND CU.codi_carr = '$carrera' and E.CODI_UNIV='$codigof'";
            $re = mysqli_query($cn, $sql);
            $fila = mysqli_fetch_assoc($re);
            ?>
            <tr>
                <td><?php echo $fila["cicl_curs"]?></td>
                <td><?php echo $fila["DESC_CURS"]?></td>
                <td><?php echo $fila["cred_curs"]; $suma = $suma + $fila["cred_curs"];?></td>
                <td><?php echo $fila["hrst_curs"]?></td>
                <td><?php echo $fila["hrsp_curs"]?></td>
                <td><?php $codicurso =  $fila["codi_curs"]?></td>
                <td><?php $fila["CODI_UNIV"]?></td>
                <td>A</td>

            <?php
                $insert="INSERT INTO dmatricula(CODI_UNIV,CICL_ACAD,CODI_CURS,CRED_CURS,HRST_CURS,HRSP_CURS,CICL_CURS,SECC_MATR,FECH_REGI,OBSE_CONV) 
                VALUES(".$fila["CODI_UNIV"].",'20222','$codicurso',".$fila["cred_curs"].",".$fila["hrst_curs"].",".$fila["hrsp_curs"].",".$fila["cicl_curs"].",'A', CURDATE(),'');";
                $dmatricula =mysqli_query($cn,$insert); 

            ?>
            </tr>
            <?php 
        }
        $insert2="INSERT INTO ematricula(CODI_UNIV,CICL_ACAD,CODI_SEDE,CODI_CARR,TOTA_CRED,FECH_MATR,LOGI_USUA,OBSE_MATR,CICL_MATR) 
        VALUES(".$fila["CODI_UNIV"].",'20222','".$fila["CODI_SEDE"]."','".$fila["CODI_CARR"]."','$suma',CURDATE(),' ',' ','".$fila["cicl_curs"]."');"; 
        $qe =mysqli_query($cn,$insert2);  

        $insert3 ="UPDATE estudiantes set SEME_ULTI='20221' where CODI_UNIV=".$_SESSION['usuario']." ";
        $qalu =mysqli_query($cn,$insert3); 
        ?>
        <tr><td colspan ="2">total de creditos</td><td ><?php echo $suma?></td><td colspan ="3"></td></tr>
        <?php         
    echo "</table>";  
    ?>
    <p><h2>Matricula realizada el <?php $DateAndTime = date('m-d-Y h:i:s a', time());   echo $DateAndTime ?></h2></p>
</form>
</body>
</html>
