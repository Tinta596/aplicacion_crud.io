<?php
include 'db.php';

// Procesar solicitudes POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add'])) {
        $stmt = $pdo->prepare("INSERT INTO proveedores (nombre, contacto, telefono) VALUES (?, ?, ?)");
        $stmt->execute([$_POST['nombre'], $_POST['contacto'], $_POST['telefono']]);
    } elseif (isset($_POST['edit'])) {
        $stmt = $pdo->prepare("UPDATE proveedores SET nombre=?, contacto=?, telefono=? WHERE id=?");
        $stmt->execute([$_POST['nombre'], $_POST['contacto'], $_POST['telefono'], $_POST['id']]);
    } elseif (isset($_POST['delete'])) {
        $stmt = $pdo->prepare("DELETE FROM proveedores WHERE id=?");
        $stmt->execute([$_POST['id']]);
    }
}

// Cargar todos los proveedores
$proveedores = $pdo->query("SELECT * FROM proveedores")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proveedores</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background: linear-gradient(135deg, #2c3e50, #34495e);
            color: #ecf0f1;
        }

        h2 {
            color: #e74c3c;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #2980b9;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        button {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #c0392b;
        }

        form {
            margin-bottom: 20px;
        }

        input[type="text"] {
            padding: 8px;
            margin-right: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="text"]:focus {
            border-color: #2980b9;
            outline: none;
        }
        
        .back-button {
            background-color: #3498db;
            margin-bottom: 20px;
        }

        .back-button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <h2>Proveedores</h2>

    <form method="post">
        <input type="text" name="nombre" placeholder="Nombre" required>
        <input type="text" name="contacto" placeholder="Contacto" required>
        <input type="text" name="telefono" placeholder="Teléfono" required>
        <button type="submit" name="add">Agregar</button>
    </form>

    <form method="get" action="index.html">
        <button type="submit" class="back-button">Volver al Índice Principal</button>
    </form>

    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Contacto</th>
            <th>Teléfono</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($proveedores as $proveedor): ?>
            <tr>
                <td><?php echo htmlspecialchars($proveedor['id']); ?></td>
                <td><?php echo htmlspecialchars($proveedor['nombre']); ?></td>
                <td><?php echo htmlspecialchars($proveedor['contacto']); ?></td>
                <td><?php echo htmlspecialchars($proveedor['telefono']); ?></td>
                <td>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($proveedor['id']); ?>">
                        <input type="text" name="nombre" value="<?php echo htmlspecialchars($proveedor['nombre']); ?>" required>
                        <input type="text" name="contacto" value="<?php echo htmlspecialchars($proveedor['contacto']); ?>" required>
                        <input type="text" name="telefono" value="<?php echo htmlspecialchars($proveedor['telefono']); ?>" required>
                        <button type="submit" name="edit">Editar</button>
                    </form>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($proveedor['id']); ?>">
                        <button type="submit" name="delete" onclick="return confirm('¿Estás seguro de que deseas eliminar este proveedor?');">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
