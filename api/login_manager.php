<?php
session_start();
require_once 'config.php'; // Asegúrate de que aquí esté definida tu conexión $pdo

header("Content-Type: application/json");

// Obtener datos del cuerpo de la petición (JSON)
$data = json_decode(file_get_contents('php://input'), true);
$cedula = $data['cedula'] ?? null;
$password = $data['password'] ?? null;

if (!$cedula || !$password) {
    http_response_code(400);
    echo json_encode(["success" => false, "msg" => "Cédula y contraseña requeridas"]);
    exit;
}

try {
    // Buscar al usuario por cédula y que esté activo (estatus = 1)
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE cedula = ? AND estatus = 1 LIMIT 1");
    $stmt->execute([$cedula]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar contraseña
    if ($usuario && password_verify($password, $usuario['password_hash'])) {
        // Registrar el último login
        $update = $pdo->prepare("UPDATE usuarios SET ultimo_login = NOW() WHERE id_usuario = ?");
        $update->execute([$usuario['id_usuario']]);

        // Crear sesión con los campos de tu tabla
        $_SESSION['user_id'] = $usuario['id_usuario'];
        $_SESSION['nombre'] = $usuario['nombre_completo'];
        $_SESSION['rol'] = $usuario['rol'];
        $_SESSION['empresa'] = $usuario['empresa'];

        echo json_encode([
            "success" => true,
            "msg" => "Bienvenido/a " . $usuario['nombre_completo'],
            "user" => [
                "nombre" => $usuario['nombre_completo'],
                "rol" => $usuario['rol']
            ]
        ]);
    } else {
        http_response_code(401);
        echo json_encode(["success" => false, "msg" => "Credenciales incorrectas o usuario inactivo"]);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "msg" => "Error de base de datos"]);
}