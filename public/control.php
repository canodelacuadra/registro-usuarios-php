<?php
try {
    $conexion = new PDO($dsn, $usuario, $contrasena);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Error de conexión: ' . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Procesar el formulario de registro
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);

    try {
        // Insertar el usuario en la base de datos
        $stmt = $conexion->prepare('INSERT INTO usuarios (nombre, email, contrasena) VALUES (:nombre, :email, :contrasena)');
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':contrasena', $contrasena, PDO::PARAM_STR);
        $stmt->execute();
        include 'exito.php';
        
    } catch (PDOException $e) {
        include 'fracaso.php';
    }  
}