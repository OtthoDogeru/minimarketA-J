<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesion</title>
    <link rel="stylesheet" href="css.css">
    <script src="javascript/alerta.js"></script>
</head>
<body>
    <form action="2.php" method ="POST">
        <h1>Login Matrícula</h1>
        <p>Usuario <input type="text" placeholder="Ingrese su nombre" name="usuario"></p>
        <p>Contraseña <input type="password" placeholder="Ingrese su contraseña" name="contraseña"></p>
       
        <input type="submit" value="Ingresar">
    </form>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>