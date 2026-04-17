<?php
require_once 'config.php'; // Tu conexión $pdo

header("Content-Type: application/json");

$data = json_decode(file_get_contents('php://input'), true);

if (!$data['cedula'] || !$data['password'] || !$data['nombre_completo']) {
    echo json_encode(["success" => false, "msg" => "Faltan campos obligatorios"]);
    exit;
}

// Cifrar la contraseña (Paso crítico de seguridad)
$pass_hash = password_hash($data['password'], PASSWORD_BCRYPT);

try {
    $sql = "INSERT INTO usuarios (cedula, password_hash, nombre_completo, codigo_empleado, cargo, empresa, rol) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $data['cedula'],
        $pass_hash,
        $data['nombre_completo'],
        $data['codigo_empleado'],
        $data['cargo'],
        $data['empresa'],
        $data['rol']
    ]);

    echo json_encode(["success" => true, "msg" => "Usuario registrado correctamente"]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "msg" => "Error: La cédula o el código ya existen"]);
}