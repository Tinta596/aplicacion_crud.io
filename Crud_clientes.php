<?php
include 'db.php';

// Procesar solicitudes POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add'])) {
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $telefono = $_POST['telefono'];

        if ($nombre && $email && $telefono) {
            $stmt = $pdo->prepare("INSERT INTO clientes (nombre, email, telefono) VALUES (?, ?, ?)");
            $stmt->execute([$nombre, $email, $telefono]);
        }
    } elseif (isset($_POST['edit'])) {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $telefono = $_POST['telefono'];

        if ($id && $nombre && $email && $telefono) {
            $stmt = $pdo->prepare("UPDATE clientes SET nombre = ?, email = ?, telefono = ? WHERE id = ?");
            $stmt->execute([$nombre, $email, $telefono, $id]);
        }
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];
        if ($id) {
            $stmt = $pdo->prepare("DELETE FROM clientes WHERE id = ?");
            $stmt->execute([$id]);
        }
    }
}

// Cargar todos los clientes
$clientes = $pdo->query("SELECT * FROM clientes")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
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

        input[type="text"],
        input[type="email"] {
            padding: 8px;
            margin-right: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="text"]:focus,
        input[type="email"]:focus {
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
    <h2>Clientes</h2>

    <form method="post">
        <input type="text" name="nombre" placeholder="Nombre" required>
        <input type="email" name="email" placeholder="Email" required>
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
            <th>Email</th>
            <th>Teléfono</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($clientes as $cliente): ?>
            <tr>
                <td><?php echo htmlspecialchars($cliente['id']); ?></td>
                <td><?php echo htmlspecialchars($cliente['nombre']); ?></td>
                <td><?php echo htmlspecialchars($cliente['email']); ?></td>
                <td><?php echo htmlspecialchars($cliente['telefono']); ?></td>
                <td>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($cliente['id']); ?>">
                        <input type="text" name="nombre" value="<?php echo htmlspecialchars($cliente['nombre']); ?>" required>
                        <input type="email" name="email" value="<?php echo htmlspecialchars($cliente['email']); ?>" required>
                        <input type="text" name="telefono" value="<?php echo htmlspecialchars($cliente['telefono']); ?>" required>
                        <button type="submit" name="edit">Editar</button>
                    </form>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($cliente['id']); ?>">
                        <button type="submit" name="delete" onclick="return confirm('¿Estás seguro de que deseas eliminar este cliente?');">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
