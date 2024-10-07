<?php
// Conexión a la base de datos
$host = "localhost"; // Cambia esto si es necesario
$user = "root"; // Usuario de la base de datos
$password = ""; // Contraseña de la base de datos
$dbname = "nombre_de_tu_base_de_datos"; // Nombre de la base de datos

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Validación de datos y registro de usuario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validación de los campos del formulario
    if (isset($_POST['usuario'], $_POST['correo'], $_POST['clave'])) {
        $usuario = trim($_POST['usuario']);
        $correo = trim($_POST['correo']);
        $clave = $_POST['clave'];

        // Validar el formato del correo electrónico
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            die("El formato de correo electrónico es inválido.");
        }

        // Validar que la contraseña cumpla con criterios mínimos (longitud)
        if (strlen($clave) < 8) {
            die("La contraseña debe tener al menos 8 caracteres.");
        }

        // Cifrado seguro de la contraseña
        $clave_cifrada = password_hash($clave, PASSWORD_DEFAULT);

        try {
            // Comprobación de usuario o correo duplicado
            $stmt = $conn->prepare("SELECT COUNT(*) FROM usuarios WHERE usuario = :usuario OR correo = :correo");
            $stmt->execute([':usuario' => $usuario, ':correo' => $correo]);
            $count = $stmt->fetchColumn();

            if ($count > 0) {
                die("El nombre de usuario o correo ya están registrados.");
            }

            // Inserción segura de datos en la base de datos
            $sql = "INSERT INTO usuarios (usuario, correo, clave) VALUES (:usuario, :correo, :clave)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':usuario' => $usuario,
                ':correo' => $correo,
                ':clave' => $clave_cifrada
            ]);

            echo "Registro exitoso.";
        } catch (PDOException $e) {
            die("Error al registrar el usuario: " . $e->getMessage());
        }
    } else {
        die("Por favor, complete todos los campos.");
    }
}
?>
