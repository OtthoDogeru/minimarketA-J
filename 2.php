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
$usuario = $_POST['usuario'];
$contraseña = $_POST['contraseña'];

session_start();
$_SESSION['usuario'] = $usuario;

include ("Conexion.php");
$sql = "SELECT
E.CODI_UNIV,
CU.DESC_CURS,
CU.CODI_CURS,
C.cred_curs,
C.cicl_curs,
E.CODI_CARR,
E.nombres,
E.apellidos,
E.CODI_SEDE,
CAR.DESC_CARR
FROM
curricula AS C
JOIN curso AS CU
ON
CU.CODI_CURS = C.codi_curs
JOIN estudiantes AS E
ON
C.codi_carr = E.CODI_CARR
JOIN carrera as CAR
ON	E.CODI_CARR = CAR.CODI_CARR
WHERE
E.CODI_UNIV = '$usuario' AND E.CLAV_UNIV = '$contraseña'";
$re = mysqli_query($cn, $sql);

$filas = mysqli_num_rows($re);

if($filas){
?>
    <h1 align = 'center'>MATRICULA DE ESTUDIANTES</h1>
    <h2>BIENVENIDO AL REGISTRO DE MATRÍCULAS SEÑOR <?php echo $_SESSION['nombres']?>  <?php echo $_SESSION['apellidos'] ?></h2>
    <p><h2>CURSOS DISPONIBLES</h2></p>
    <form action="3.php" method="POST">
        <table border='1' cellpadding='4' cellspacing='0' align = 'center'>
            <tr><th>ASIGNATURA</th><th>CREDITOS</th><th>CICLO</th><th>ELEGIR CURSO</th></tr>
            <?php
            while( $row = mysqli_fetch_assoc( $re ) ) {
                $_SESSION['codigo'] = $row["CODI_UNIV"];
                $_SESSION['carrera'] = $row["CODI_CARR"];
                $_SESSION['nombres'] = $row["nombres"];
                $_SESSION['apellidos'] = $row["apellidos"];
                $_SESSION['sede'] = $row["CODI_SEDE"];
                $_SESSION['abc'] = $row["DESC_CARR"];
                ?>
                <tr>
                    <td><?php echo $row["DESC_CURS"]?></td>
                    <td><?php echo $row["cred_curs"]?></td>
                    <td><?php echo $row["cicl_curs"]?></td>
                    <td><input type='checkbox' value="<?php echo $row["CODI_CURS"]?>" name='seleccion[]'> Elegir</td>
                </tr>
                <?php
            }         
            echo "</table>";   
            ?>
            <p><input type="submit" value ="Continuar Matricula" class="button"></p>
            <a href="index.php" style="color: red;"><h1>Cancelar Matrícula</h1></a>
    </form>
<?php   
}else{

    include("index.php");
    ?>
    <script>mensaje()</script>
    <?php
}
mysqli_free_result($re);
?>
</body>
</html>