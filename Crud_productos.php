<?php
include 'db.php';

// Procesar solicitudes POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add'])) {
        $stmt = $pdo->prepare("INSERT INTO productos (nombre, precio, stock) VALUES (?, ?, ?)");
        $stmt->execute([$_POST['nombre'], $_POST['precio'], $_POST['stock']]);
    } elseif (isset($_POST['edit'])) {
        $stmt = $pdo->prepare("UPDATE productos SET nombre=?, precio=?, stock=? WHERE id=?");
        $stmt->execute([$_POST['nombre'], $_POST['precio'], $_POST['stock'], $_POST['id']]);
    } elseif (isset($_POST['delete'])) {
        $stmt = $pdo->prepare("DELETE FROM productos WHERE id=?");
        $stmt->execute([$_POST['id']]);
    }
}

// Cargar todos los productos
$productos = $pdo->query("SELECT * FROM productos")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
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
        input[type="number"] {
            padding: 8px;
            margin-right: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="text"]:focus,
        input[type="number"]:focus {
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
    <h2>Productos</h2>

    <form method="post">
        <input type="hidden" name="id" value="">
        <input type="text" name="nombre" placeholder="Nombre" required>
        <input type="number" name="precio" placeholder="Precio" required>
        <input type="number" name="stock" placeholder="Stock" required>
        <button type="submit" name="add">Agregar</button>
    </form>

    <form method="get" action="index.html">
        <button type="submit" class="back-button">Volver al Índice Principal</button>
    </form>

    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($productos as $producto): ?>
            <tr>
                <td><?php echo htmlspecialchars($producto['id']); ?></td>
                <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                <td><?php echo htmlspecialchars($producto['precio']); ?></td>
                <td><?php echo htmlspecialchars($producto['stock']); ?></td>
                <td>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($producto['id']); ?>">
                        <input type="text" name="nombre" value="<?php echo htmlspecialchars($producto['nombre']); ?>" required>
                        <input type="number" name="precio" value="<?php echo htmlspecialchars($producto['precio']); ?>" required>
                        <input type="number" name="stock" value="<?php echo htmlspecialchars($producto['stock']); ?>" required>
                        <button type="submit" name="edit">Editar</button>
                    </form>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($producto['id']); ?>">
                        <button type="submit" name="delete" onclick="return confirm('¿Estás seguro de que deseas eliminar este producto?');">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
