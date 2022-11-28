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
$seleccion = $_POST['seleccion'];
?>
<h1 align = 'center'>MATRICULA DE ESTUDIANTES</h1>
<p><h2>CURSOS ELEGIDOS</h2></p>
<form action="4.php" method="POST">
    <table border='1' cellpadding='4' cellspacing='0' align = 'center' class="table">
        <tr>
            <th>ASIGNATURA</th>
            <th>CREDITOS</th>
            <th>CICLO</th>
            <th>ELEGIR CURSO</th>
        </tr>
    <?php
    include ("Conexion.php");
    $sumacred=0;
    foreach($_POST['seleccion'] as $curso){
        $sql = "SELECT C.CODI_CURS, C.DESC_CURS, CU.cred_curs, CU.cicl_curs FROM curso as C 
        INNER JOIN curricula as CU ON C.CODI_CURS = CU.codi_curs
        WHERE C.CODI_CURS = '$curso' AND CU.codi_carr = '$carrera'";
        $re = mysqli_query($cn, $sql);
        $fila = mysqli_fetch_assoc($re);
        ?>
        <tr>
            <td><?php echo $fila["DESC_CURS"]?></td>
            <td><?php echo $fila["cred_curs"];$sumacred = $sumacred + $fila["cred_curs"];?></td>
            <td><?php echo $fila["cicl_curs"]?></td>
            <td><input type='checkbox' value="<?php echo $fila["CODI_CURS"]?>" name='eleccion[]' checked="checked"> Elegir</td>
        </tr>
        <?php 
    }
    ?>
    <tr><td>TOTAL DE CREDITOS</td><td ><?php echo $sumacred?></td><td colspan ="3"></td></tr>
    <?php
    echo "</table>";   
    ?>
    <?php
    if($sumacred>18 or $sumacred<10){
        ?>
        <p>Los créditos no cumplen con los requisitos, vuelva a iniciar sesión y matriculese.</p>
        <a href="index.php" style="color: green;">Cancelar</a>
        <?php
    }
    else{
        ?>
        <p><input type="submit" value ="Confirmar Matricula" class="button"></p>
        <a href="index.php" style="color: green;">Cancelar</a>
        <?php
    }
    ?>
</form>

</body>
</html>