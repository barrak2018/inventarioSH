<?php
require_once 'config.php'; // Tu conexión PDO ($pdo)

/**
 * ESTE ARCHIVO ES SOLO PARA DESARROLLO.
 * ELIMÍNALO DESPUÉS DE CREAR EL PRIMER USUARIO.
 */

// Datos del primer administrador (Cambiarlos a tu gusto)
$datos = [
    'cedula' => '30464263',
    'password' => 'admin123', // <--- ESTA SERÁ TU CLAVE INICIAL
    'nombre' => 'ADMINISTRADOR GENERAL',
    'codigo' => 'ADM-001',
    'cargo' => 'JEFE DE SISTEMAS',
    'empresa' => 'CJE PERFUMES',
    'rol' => 'admin'
];

try {
    // Generar el Hash seguro
    $password_hash = password_hash($datos['password'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO usuarios (
                cedula, 
                password_hash, 
                nombre_completo, 
                codigo_empleado, 
                cargo, 
                empresa, 
                rol, 
                estatus
            ) VALUES (?, ?, ?, ?, ?, ?, ?, 1)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $datos['cedula'],
        $password_hash,
        $datos['nombre'],
        $datos['codigo'],
        $datos['cargo'],
        $datos['empresa'],
        $datos['rol']
    ]);

    echo "<h1>¡Éxito!</h1>";
    echo "<p>Usuario administrador creado correctamente.</p>";
    echo "<ul>
            <li><b>Cédula:</b> {$datos['cedula']}</li>
            <li><b>Contraseña:</b> {$datos['password']}</li>
          </ul>";
    echo "<p style='color:red;'><b>IMPORTANTE:</b> Borra este archivo de tu servidor ahora mismo por seguridad.</p>";

} catch (PDOException $e) {
    if ($e->getCode() == 23000) {
        echo "<h1>Error</h1><p>El usuario ya existe en la base de datos.</p>";
    } else {
        echo "<h1>Error de BD</h1><p>" . $e->getMessage() . "</p>";
    }
}